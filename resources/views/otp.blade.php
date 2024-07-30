<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
      <link rel="stylesheet" href="{{ asset('css/style.css')}}">
      <link rel="stylesheet" href="{{ asset('css/line-awesome.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('addtohomescreen/addtohomescreen.css')}}">
      <script src='https://www.google.com/recaptcha/api.js'></script>
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
      <style type="text/css">
      body{    background-color: #fef2f2;}header{height: 80px;}
      .counter1 {
         color: #1c558e;
    font-family: Verdana, Arial, sans-serif;
    /* font-size: 18px; */
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    background: #dadada;
    display: inline-block;
    padding: 10px 15px;
    border-radius: 10px;
    margin-bottom:10px;
}
.counter1_msg{
   line-height:20px;
}
.form-body .btn.btn-default {
    background-image: linear-gradient( 180deg, hsl(180deg 100% 65%) 0%, hsl(184deg 94% 55%) 11%, hsl(187deg 100% 47%) 22%, hsl(190deg 100% 45%) 33%, hsl(193deg 100% 43%) 44%, hsl(196deg 100% 40%) 56%, hsl(199deg 100% 37%) 67%, hsl(201deg 100% 34%) 78%, hsl(206deg 86% 33%) 89%, hsl(216deg 61% 33%) 100% );
    padding: 12px 0;
    border-radius: 30px;
    border: none;
}
   </style>
   </head>
   <body>
      <header>
         <div class="wrapper">
            <div class="row">
               <div class="col-lg-4 col-md-4 col-12 col-xl-4">
                  <div class="mt-1">
                     <img style="width:150px" src="{{ asset('img/logo.png')}}" alt="">
                  </div>
               </div>
            </div>
         </div>
      </header>
      <div class="form-body" style="margin-top: -8px; overflow: hidden;">
         <div class="wrapper">
            <div class="row">
               <div class="text-center col-lg-8 col-md-6">
                  <!--{{-- <h1>SWCH</h1> --}}-->
                  <!--<h3>Your Virtual HR Manager</h3>-->
                  <!--<img src="{{ asset('img/hiring.png')}}" alt="" style="width: 100%;">-->
               </div>
               <div class="col-md-4">
                  <div class="emp">
                     <h4>OTP</h4>

                     <form action="{{url('otpvalidate')}}" method="post" >
                        {{csrf_field()}}
                        @include('layout.message')
                        <div class="row form-group">
                           <div class="col-md-12">
                              <input type="text" class="form-control" placeholder="Enter OTP"   name="otp" required>
                              <span class="form-ico"><i class="las la-user-circle"></i></span>
                              @if ($errors->has('email'))
                              <div class="error" style="color:red;">{{ $errors->first('otp') }}</div>
                              @endif
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-12">
                              <button class="btn btn-default" type="submit" id="loginButton">SUBMIT</button>
                           </div>
                        </div>
                     </form>
                     <div class="text-center">
                         {{-- <div id="countdown" class="counter1"></div> --}}
                         <a id="countdown"  class="counter1" href="{{url('otpsend')}}"></a>
                         <p class="fw-bold text-danger counter1_msg">Wait for till remaining time and </br> check your Register Email Id</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
      <script>
         function countdown( elementName, minutes, seconds )
{
    var element, endTime, hours, mins, msLeft, time;

    function twoDigits( n )
    {
        return (n <= 9 ? "0" + n : n);
    }

    function updateTimer()
    {
        msLeft = endTime - (+new Date);
        if ( msLeft < 1000 ) {
            element.innerHTML = "Send Again";
        } else {
            time = new Date( msLeft );
            hours = time.getUTCHours();
            mins = time.getUTCMinutes();
            element.innerHTML = (hours ? hours + ':' + twoDigits( mins ) : mins) + ':' + twoDigits( time.getUTCSeconds() );
            setTimeout( updateTimer, time.getUTCMilliseconds() + 500 );
        }
    }

    element = document.getElementById( elementName );
    endTime = (+new Date) + 1000 * (60*minutes + seconds) + 500;
    updateTimer();
}

countdown( "countdown", 2, 0 );
      </script>

   </body>
</html>
