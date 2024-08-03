<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-title" content="Add to Home">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
      <link rel="stylesheet" href="{{ asset('css/style.css')}}">
      <link rel="stylesheet" href="{{ asset('css/line-awesome.min.css')}}">
      <script src='https://www.google.com/recaptcha/api.js'></script>
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
      <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png')}}">
      <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/favicon.png')}}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png')}}">
      <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon.png')}}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png')}}">
      <link rel="shortcut icon" sizes="16x16" href="{{ asset('img/favicon.png')}}">
      <link rel="shortcut icon" sizes="196x196" href="{{ asset('img/favicon.png')}}">
      <link rel="apple-touch-icon-precomposed" href="{{ asset('img/favicon.png')}}">
      <link rel="manifest" href="{{ asset('js/manifest.json')}}">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png')}}">
      <meta name="theme-color" content="#ffffff">
      <link rel="stylesheet" type="text/css" href="{{ asset('addtohomescreen/addtohomescreen.css')}}">
      <style>
         /* Your CSS styles */
         /* Replace the following styles with your actual styles */
         body {
    background: url(../img/login-bg.jpg) no-repeat center center;
    background-size: 100%;
    background-attachment: fixed;
    width: 100%;
    height: 100%;
}
         /* Loader styles */
         .loader {
         border: 8px solid #f3f3f3;
         border-top: 8px solid #3498db;
         border-radius: 50%;
         width: 50px;
         height: 50px;
         animation: spin 2s linear infinite;
         position: fixed;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         z-index: 9999;
         display: none;
         }
         @keyframes spin {
         0% { transform: rotate(0deg); }
         100% { transform: rotate(360deg); }
         }
         /* Blur overlay */
         .blur-overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(255, 255, 255, 0.5); /* Adjust the opacity */
         backdrop-filter: blur(5px); /* Apply the blur effect */
         z-index: 9998;
         display: none;
         }
         .login_logo {
    max-width: 100%;
    text-align: center;
}
.login_logo img {
    width: 150px;
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
      <!-- <header>
         <div class="wrapper">
            <div class="row">
               <div class="col-lg-4 col-md-4 col-12 col-xl-4">
                  <div class="mt-1">
                     <img style="width:150px"  src="{{ asset('img/logo.png')}}" alt="">
                  </div>
               </div>
            </div>
         </div>
      </header> -->
      <div class="form-body">
         <div class="wrapper">
            <div class="row d-flex justify-content-center align-items-center h-100">
              
               <div class="col-lg-4 col-md-6">
                  <div class="emp">
                  <div class="login_logo"><img src="https://swchrms.co/img/logo.png" alt=""></div>
                  <h4 class="text-center">Login</h4>
                  <span class="text-center d-block">Your Virtual HR Manager</span>
                     <form action=""  method="post" >
                        {{csrf_field()}}
                        @include('layout.message')
                        <div class="row form-group">
                           <div class="col-md-12">
                              <input type="email" class="form-control" placeholder="Email"   name="email">
                              <span class="form-ico"><i class="las la-user-circle"></i></span>
                              @if ($errors->has('email'))
                              <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
                              @endif
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-12">
                              <input type="password" class="form-control" placeholder="Password" name="psw">
                              <span class="form-ico pass"><i class="las la-lock"></i></span>
                              @if ($errors->has('psw'))
                              <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>
                              @endif
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-12">
                              <button class="btn btn-default" type="submit" id="loginButton">LOGIN</button>
                              <div class="forgot"><a href="{{ url('forgot-password') }}">Forgot Password?</a> <span><a href="{{ url('register') }}">Register Now</a></span></div>
                           </div>
                        </div>
                     </form>
                     <div class="row google">
                        <div class="col-md-12">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="loader" id="loader"></div>
      <div class="blur-overlay" id="blurOverlay"></div>
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="{{ asset('employeeassets/js/core/jquery.3.2.1.min.js')}}"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
      <script src="{{ asset('addtohomescreen/addtohomescreen.min.js')}}"></script>
      <script>
         // Show loader and apply blur effect on background when login button is clicked
         document.getElementById('loginButton').addEventListener('click', function() {
             document.getElementById('loader').style.display = 'block';
             document.getElementById('blurOverlay').style.display = 'block';
         });

         // Remove blur effect when content is fully loaded
         window.addEventListener('load', function() {
             document.getElementById('loader').style.display = 'none';
             document.getElementById('blurOverlay').style.display = 'none';
         });
      </script>
   </body>
</html>
