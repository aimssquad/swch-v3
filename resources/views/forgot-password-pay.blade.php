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
	body{    background-color: #fef2f2;}header{height: 68px;}

</style>
  </head>
  <body>

  	<header>
  		<div class="wrapper">
  			<div class="row">
  				<div class="col-lg-4 col-md-4 col-12 col-xl-4">
  					<div class="logo">
  						<img src="{{ asset('img/logo.png')}}" alt="">
  					</div>
  				</div>
  			</div>
  		</div>
  	</header>
    <div class="form-body">
		<div class="wrapper">
			<div class="row">
			    <div class="text-center col-lg-8 col-md-6">
			    	<h6>WorkPermitCloud</h6>
			    	<h3>Your Virtual HR Manager</h3>
			    	<img src="{{ asset('img/hiring.png')}}" alt="" style="width: 100%;">
			    </div>

				<div class="col-md-4">
					<div class="emp">
						<h4>Reset Your Password</h4>
						<form action="{{url('login-pay-forgot-password')}}" method="post" id="my_captcha_form">
						{{csrf_field()}}
						 @if(Session::has('message'))										
			<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
			@endif	
							<div class="row form-group">
							<div class="col-md-12">
								<input type="email" class="form-control" placeholder="Email"   name="email" required>
								<span class="form-ico"><i class="las la-user-circle"></i></span>
								 @if ($errors->has('email'))
        <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
@endif
								</div>
							</div>
							
						
							<div class="row form-group">
							<div class="col-md-12">
							<div class="capcha">
      				<div class="g-recaptcha" id="rcaptcha" data-sitekey="6LcM2-MZAAAAAIlS2Y0CpcIFZYrdgavQdEGEcM-h"  data-theme="light"></div>
				</div>
				<div id="recaptcha-error" style="color:red;">
				    	</div>
							</div>
								
							</div>
							
							<div class="row form-group">
							
							<div class="col-md-12">
								<button class="btn btn-default" type="submit">SUBMIT</button>
									<div class="text-right forgot"><span><a href="{{ url('login-pay') }}">Login Here</a> </span></div>
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