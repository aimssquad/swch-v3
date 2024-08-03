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
	body {
    background: url(../img/login-bg.jpg) no-repeat center center;
    background-size: 100%;
    background-attachment: fixed;
    width: 100%;
    height: 100%;
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
  						<img style="width:150px" src="{{ asset('img/logo.png')}}" alt="">
  					</div>
  				</div>
  			</div>
  		</div>
  	</header> -->
    <div class="form-body">
		<div class="wrapper">
			<div class="row d-flex justify-content-center align-items-center h-100">
			   

				<div class="col-md-4">
					<div class="emp">
					<div class="login_logo"><img src="https://swchrms.co/img/logo.png" alt=""></div>
					<h4 class="text-center">Reset Your Password</h4>
					<span class="text-center d-block">Your Virtual HR Manager</span>
						<form action="{{url('forgot-password')}}" method="post" id="my_captcha_form">
						{{csrf_field()}}
						    @include('layout.message')
							<div class="row form-group">
							<div class="col-md-12">
								<input type="email" class="form-control" placeholder="Email"  name="email" required>
								<span class="form-ico"><i class="las la-user-circle"></i></span>
								 @if ($errors->has('email'))
                                    <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
                                @endif
								</div>
							</div>




							<div class="row form-group">

							<div class="col-md-12">
								<button class="btn btn-default" type="submit">SUBMIT</button>
									<div class="text-right forgot"><span><a href="{{ url('/') }}">Login Here</a> </span></div>
							</div>
							</div>
						</form>


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


  </body>
</html>
