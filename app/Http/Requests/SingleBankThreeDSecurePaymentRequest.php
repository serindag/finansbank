<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingleBankThreeDSecurePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
           'name' => 'required|string',
           'phone'=>'required|min:17|max:17',
           'number'=>'required|min:19|max:19',
           'price' => 'required|min:0|max:999999999999.99999999|regex:/^\d+(\.\d{1,2})?$/',
           'month'=>'required|min:1|max:12',
           'year'=>'required',
           'cvv'=>'required|min:3|max:4'

        ];
    }
    public function messages(): array
    {
        return [
            'name.required'=>'İsim Soyisim Boş Geçilemez',
            'name.string'=>'İsim Soyisim Kelimelerden Oluşmak Zorundadır.',
            'phone.required'=>'Telefon Alanı  Boş Geçilemez.',
            'phone.min'=>'Telefon Alanına Başında 0 Olmadan 10 Haneli Şekilde Yazınız.',
            'phone.max'=>'Telefon Alanına Başında 0 Olmadan 10 Haneli Şekilde Yazınız.',
            'number.required'=>'Kart No Boş Geçilemez.',
            'number.min'=>'Kart No 16 Haneli Olmalıdır.',
            'number.max'=>'Kart No 16 Haneli Olmalıdır.',
            'price.required'=>'Tutar Alanı Boş Geçilemez',
            'price.min'=>'Tutar Alanı Eksi Olamaz',
            'month.required'=>'Ay Alanı Boş Geçilemez',
            'month.min'=>'Ay Alanı 1-12 Arasında Olmalıdır.',
            'month.max'=>'Ay Alanı 1-12 Arasında Olmalıdır.',
            'year.required'=>'Yıl Alanı Boş Geçilemez',
            'cvv.required'=>'Cvv Alanı Boş Geçilemez',
            'cvv.min'=>'Cvv  1-12 Arasında Olmalıdır.',
            'cvv.max'=>'Cvv  1-12 Arasında Olmalıdır.',
        ];
    }
}
