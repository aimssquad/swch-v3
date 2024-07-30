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
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/apple-icon-57x57.png')}}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/apple-icon-60x60.png')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/apple-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon-76x76.png')}}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/apple-icon-114x114.png')}}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/apple-icon-120x120.png')}}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/apple-icon-144x144.png')}}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/apple-icon-152x152.png')}}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-icon-180x180.png')}}">
<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/android-icon-192x192.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon-96x96.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png')}}">
<link rel="shortcut icon" sizes="16x16" href="{{ asset('img/icon-16x16.png')}}">
<link rel="shortcut icon" sizes="196x196" href="{{ asset('img/icon-196x196.png')}}">

<link rel="apple-touch-icon-precomposed" href="{{ asset('img/icon-152x152.png')}}">
<link rel="manifest" href="{{ asset('js/manifest.json')}}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('img/ms-icon-144x144.png')}}">
<meta name="theme-color" content="#ffffff">
<link rel="stylesheet" type="text/css" href="{{ asset('addtohomescreen/addtohomescreen.css')}}">
<style>
   
        .right-part{padding-top:5%;}.form-group{padding: 10px;}
</style>
  </head>
  <body>
    <div class="form-body-admin" style="background: url({{asset('public/img/login-bg-IC.webp')}}) no-repeat center center;">
		<div class="login-form">
						<div class="col-md-12">
						  <h3><img  style="width: 60px;" src="{{ asset('img/logo.png')}}"> Climbr</h3>
						  <h4 style="font-size:18px;margin-top: 30px;color: #388de4;font-weight: 400;border-bottom: 1px solid #999;padding-bottom: 10px;">Internal User Login</h4>
						  <h4 style="font-size:15px;">Sign-in to your account</h4></div>
					<form action="{{url('user-login')}}"  method="post" id="my_captcha_form">
						{{csrf_field()}}
						 @if(Session::has('message'))
			<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
			@endif
							<div class="row form-group">
							<div class="col-md-12">
								<input type="text" class="form-control" placeholder="Login Id"   name="email" required>
								<span class="form-ico"><i class="las la-user-circle"></i></span>
								 @if ($errors->has('email'))
        <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
@endif
								</div>
							</div>

							<div class="row form-group">
							<div class="col-md-12">
								<input type="password" class="form-control" placeholder="Password" name="psw" required>
								<span class="form-ico pass"><i class="las la-lock"></i></span>
								 @if ($errors->has('psw'))
        <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>
@endif
								</div>
							</div>
							<div class="row form-group">
							<div class="col-md-12">
							<div class="capcha">
      				<div class="g-recaptcha" id="rcaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"  data-theme="light"></div>
				</div>
				<div id="recaptcha-error" style="color:red;">
				    	</div>
							</div>

							</div>
						<!--	<div class="form-check">
							<div class="col-md-12">
							  <label class="form-check-label">
								<input type="checkbox" class="form-check-input" value="1"  name="remember">Remember Me
							  </label>
							  </div>
							</div>-->
							<div class="row form-group">

							<div class="col-md-12">
								<button class="btn btn-default" style="width: 100%;color: #fff;background: #277fbe !important;" type="submit">LOGIN</button>

							</div>
							</div>
						</form>

					</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  	<script src="{{ asset('employeeassets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="{{ asset('addtohomescreen/addtohomescreen.min.js')}}"></script>
 <script>
addToHomescreen();
</script>
  <script>
document.getElementById("my_captcha_form").addEventListener("submit",function(evt)
  {

  var response = grecaptcha.getResponse();
  if(response.length == 0)
  {
    //reCaptcha not verified
     document.getElementById('recaptcha-error').innerHTML = "You can't leave Captcha Code empty";

    evt.preventDefault();
    return false;
  }
  //captcha verified
  //do the rest of your validations here

});

</script>

  </body>
</html>
