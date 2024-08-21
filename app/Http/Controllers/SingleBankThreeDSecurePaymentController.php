<?php

namespace App\Http\Controllers;

use App\Http\Requests\SingleBankThreeDSecurePaymentRequest;
use App\Models\Cart;
use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Mews\Pos\Entity\Card\CreditCardInterface;
use Mews\Pos\Exceptions\CardTypeNotSupportedException;
use Mews\Pos\Exceptions\CardTypeRequiredException;
use Mews\Pos\Exceptions\HashMismatchException;
use Mews\Pos\Factory\CreditCardFactory;
use Mews\Pos\Gateways\PayFlexV4Pos;
use Mews\Pos\Gateways\PayForPos;
use Mews\Pos\PosInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\CartMail;

class SingleBankThreeDSecurePaymentController extends Controller
{
    private string $paymentModel = PosInterface::MODEL_3D_SECURE;

    public function __construct(
        private PosInterface $pos,
        Container $container,
    ) {}

    public function index()
    {
        return view('pay-form1');
    }

    /**
     * route: /single-bank/payment/3d/form
     * Kullanicidan kredi kart bilgileri alip buraya POST ediyoruz
     */
    public function form(SingleBankThreeDSecurePaymentRequest $request)
    {
        $session = $request->getSession();
        $transaction = $request->get('tx', PosInterface::TX_TYPE_PAY_AUTH);
        $callbackUrl = url("/single-bank/payment/3d/response");
        $order       = $this->createNewOrder(
            $this->paymentModel,
            $callbackUrl,
            (float)$request->price,
            $request->phone,
            $request->getClientIp(),
            $request->get('currency', PosInterface::CURRENCY_TRY),
            $request->get('installment'),
        );

        $session->set('order', $order);
        $card = $this->createCard($this->pos, $request->all());

        /**
         * PayFlex'te provizyonu (odemeyi) tamamlamak icin tekrar kredi kart bilgileri isteniyor,
         * bu yuzden kart bilgileri kaydediyoruz
         */
        if ($this->pos::class === PayForPos::class) {
            // Laravel 8'de set() yerine put() metodu kullanmanız gerekiyor.
            $session->set('card', $request->all());
        }
        $session->set('tx', $transaction);

        try {
            $formData = $this->pos->get3DFormData($order, $this->paymentModel, $transaction, $card);
        } catch (\Throwable $e) {
            throw new \Exception('Sistemde hata oluştu' . $e->getMessage());
        }

        $client = new Client();
        $response = $client->post($formData['gateway'], [
            'form_params' => $formData['inputs']
        ]);

        // Cevabı işlemek
        $body = $response->getBody()->getContents();
        return response($body);
    }

    /**
     * route: /single-bank/payment/3d/response
     * Kullanici bankadan geri buraya redirect edilir.
     * Bu route icin CSRF disable edilmesi gerekiyor.
     */
    public function response(Request $request)
    {
        $session = $request->getSession();
        $transaction = $session->get('tx', PosInterface::TX_TYPE_PAY_AUTH);

        // bankadan POST veya GET ile veri gelmesi gerekiyor
        if (($request->getMethod() !== 'POST')
            // PayFlex-CP GET request ile cevapliyor
            && ($request->getMethod() === 'GET' && ($this->pos::class !== PayForPos::class || [] === $request->query->all()))
        ) {
            toastr()->error("Eksik Bilgileri Tamamlayınız");
            return redirect('/');
        }

        $card = null;

        if ($this->pos::class === PayForPos::class) {
            // bu gateway için ödemeyi tamamlarken tekrar kart bilgisi lazım.

            $savedCard = $session->get('card');

            $card = $this->createCard($this->pos, $savedCard);
        }

        $order = $session->get('order');
        if (!$order) {
            throw new \Exception('Sipariş bulunamadı, session sıfırlanmış olabilir.');
        }

        try {
            $this->pos->payment($this->paymentModel, $order, $transaction, $card);
        } catch (HashMismatchException $e) {
            throw new \Exception('Sistemde hata oluştu' . $e->getMessage());
        } catch (\Exception | \Error $e) {
            throw new \Exception('Sistemde hata oluştu' . $e->getMessage());
        }

        $response = $this->pos->getResponse();

        //carts tablosuna kaydetme işlemi
        if ($this->pos->getResponse()['all']['ProcReturnCode'] == 1) {
            $laststatus = "1";
        } else {
            $laststatus = "0";
        }

        $save = Cart::create([
            'order_id' => $session->get('order')['id'],
            'name' => $session->get('card')['name'],
            'phone' => $session->get('order')['phone'],
            'price' => $session->get('order')['amount'],
            'status' => $laststatus
        ]);

    
        // iptal, iade, siparis durum sorgulama islemleri yapabilmek icin $response'u kaydediyoruz
        $session->set('last_response', $response);
        if ($this->pos->isSuccess()) {
            echo 'success';
            toastr()->success("Ödeme Yapıldı");
            return redirect()->back();
        } else {

            toastr()->error("Ödeme Yapılamadı");
            return redirect()->back();

            /*   echo '<h3>Ödeme Yapılamadı</h3>';
            echo '<hr>';

           
            foreach ($this->pos->getResponse()['all'] as $key => $item) {

                echo $key . ' : ' . $item . '<br/>';
            }
            echo $this->pos->getResponse()['error_message'];*/
        }
    }

    private function createNewOrder(
        string $paymentModel,
        string $callbackUrl,
        float $price = 10.01,
        string $phone,
        string $ip,
        string $currency,
        ?int   $installment = 0,
        string $lang = PosInterface::LANG_TR
    ): array {
        $orderId = date('Ymd') . strtoupper(substr(uniqid(sha1(time())), 0, 4));

        $order = [
            'id'          => $orderId,
            'amount'      => $price,
            'phone'        => $phone,
            'currency'    => $currency,
            'installment' => $installment,
            'ip'          => filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? $ip : '127.0.0.1',
        ];

        if (in_array($paymentModel, [
            PosInterface::MODEL_3D_SECURE,
            PosInterface::MODEL_3D_PAY,
            PosInterface::MODEL_3D_HOST,
            PosInterface::MODEL_3D_PAY_HOSTING,
        ], true)) {
            $order['success_url'] = $callbackUrl;
            $order['fail_url']    = $callbackUrl;
        }

        if ($lang) {
            //lang degeri verilmezse account (EstPosAccount) dili kullanilacak
            $order['lang'] = $lang;
        }

        return $order;
    }

    private function createCard(PosInterface $pos, array $card): CreditCardInterface
    {
        try {

            return CreditCardFactory::createForGateway(
                $pos,
                $card['number'],
                $card['year'],
                $card['month'],
                $card['cvv'],
                $card['name'],
                $card['type'] ?? null
            );
        } catch (CardTypeRequiredException | CardTypeNotSupportedException $e) {
            throw new \Exception('Sistemde hata oluştu' . $e->getMessage());
        } catch (\LogicException $e) {
            throw new \Exception('Sistemde hata oluştu' . $e->getMessage());
        }
    }
}
