<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NLKSOFT CASE </title>
    <link href="{{ asset('assets') }}/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/main.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/responsive.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/animate.min.css">

</head>

<body>
    <div id="jquery-script-menu ">
        <div class="jquery-script-center">
            <div class="jquery-script-clear"></div>
        </div>
    </div>
    <div class="container bg-white mt-3 rounded shadow-lg">
        <h3 class="text-center pt-2">NLKSOFT CASE</h3>
        <form action="{{ route('pay.form') }}" method="POST">
            @csrf
            @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach

                    </div>

                @endif
        <div class="row">
          
            <div class="col-md-6">
                <div class="card border-0 ">
                    <div class="card-body ">

                        <div class="form-group">
                            <label for="cardHolder">İsim Soyisim</label>
                            <input required name="name" class=" form-control form-control-md" id="cardHolder">
                        </div>
                        <div class="form-group">
                            <label for="cardInput">Telefon No</label>
                            <input type="text" required name="phone" class=" form-control form-control-md"  id="phone" placeholder="(555) 555-5555">

                           
                        </div>

                        <div class="form-group">
                            <label for="cardInput">Kart Numarası</label>
                            <input required name="number" class=" form-control form-control-md" id="cardInput">
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="cardInput">Tutar</label>
                            <input type="number" required name="price" step="0.01" class=" form-control form-control-md" id="cardInput">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="monthInput">Son Kullanma Tarihi</label>
                                    <select required  class="form-control form-control-md " name="month"
                                        id="monthInput">
                                        <option class="disabled" readonly>Ay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                    <div class="form-group">
                                        <label for="yearInput"></label>
                                        <select required name="year" class="form-control form-control-md   mt-2" id="yearInput">
                                            <option class="disabled" readonly>YY</option>
                                        </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cwInput">CVC</label>
                                    <input required name="cvv" type="text" class="form-control form-control-md" id="cwInput">
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-md btn-primary  d-block  w-100" value="Devam Et" />
                    </div>
                </div>
            </div>
            
       
            <div class="col-md-6 pt-5">
                <div class="card willFlip" id="willFlip">
                    <div class="front justify-center align-content-center">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <img src="{{ asset('assets') }}/card_bank.png" width="50" style="filter: contrast(0)"
                                    height="50" alt="">
                                <img src="{{ asset('assets') }}/visa.png" width="50" height="50" alt="">
                            </div>
                            <div class="col-md-12 mt-1">
                                <div class="form-group">
                                    <label for="cardNumber"></label>
                                    <input type="text"
                                        class="form-control animate__animated animate__bounce animate__duration-2s"
                                        disabled readonly id="cardNumber">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                <div class="col-md-7 card-holder-content">
                                    <div class="form-group">
                                        <label for="cardHolderValue">İsim Soyisim</label>
                                        <input type="text" placeholder="" disabled
                                            class="cardHolder form-control animate__animated animate__bounce animate__duration-2s"
                                            id="cardHolderValue">
                                    </div>
                                </div>
                                <div class="col-md-4 card-expires-content">
                                    <div class="input-date">
                                        <label for="expiredMonth" class="text-right d-block">Son Kullanma Tarihi</label>
                                        <div
                                            class="row content-date-input justify-content-end animate__animated animate__duration-2s animate__bounce">
                                            <input type="text" disabled class="cardHolder col-4 form-control"
                                                id="expiredMonth">
                                            <h4 class="mt-1 p-2 slash-text"> / </h4>
                                            <input type="text" disabled class="cardHolder col-4 form-control"
                                                id="expiredYear">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="back">
                        <div class="card-bar"></div>
                        <div class="card-body">
                            <div class="col-md-12  back-middle">
                                <div class="form-group">
                                    <label for="cardCcv" class="text-right d-block">CW</label>
                                    <input type="password" disabled class="form-control" id="cardCcv">
                                </div>
                                <img src="{{ asset('assets') }}/visa.png" class="float-right" width="50" height="50"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
    </form>
 </div>
    <script src="{{ asset('assets') }}/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.19/jquery.inputmask.min.js"></script>

    <script src="{{ asset('assets') }}/main.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/popper.min.js"></script>
    <script src="{{ asset('assets') }}/bootstrap.min.js"></script>

    <script src="{{ asset('assets') }}/flipper.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/jquery.inputmask.min.js"></script>
    <script>
      
        $(document).ready(function(){
            $('#phone').inputmask('+\\90(999) 999-9999'); // Telefon numarası maskesi
            
        });

    </script>


</body>

</html>
