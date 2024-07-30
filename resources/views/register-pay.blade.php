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
<style>
body{    background-color: #fef2f2;}header{height: 68px;}
</style>
<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
    <title>SWCH</title>
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
			    <div class="text-center col-lg-7 col-md-6">
			    	<h6>WorkPermitCloud</h6>
			    	<h3>Your Virtual HR Manager</h3>
			    	<img src="{{ asset('img/hiring.png')}}" alt="" style="width: 100%;">
			    </div>
				<div class="col-lg-5 col-md-6">
					<div class="emp">
						<h4>Register Here</h4>
					<form action="{{url('login-pay-register')}}" method="post" enctype="multipart/form-data">
						 {{csrf_field()}}
						@if(Session::has('message'))										
							<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
						@endif	
							<div class="row form-group">
							<div class="col-md-12"> 
							<div class="palceholder">
							   <label>Company Name </label>
							  
							</div>
								<input type="text" class="form-control" placeholder="" name="com_name"  required="">
								<span class="form-ico"><i class="lar la-building"></i></span>
								 @if ($errors->has('com_name'))
									<div class="error" style="color:red;">{{ $errors->first('com_name') }}</div>
							@endif
								</div>
							</div>
							
							<div class="row form-group">
							<div class="col-md-6">
							    <div class="palceholder">
							   <label>First Name </label>
							  
							</div>
								<input type="text" class="form-control"  name="f_name" required="">
								<span class="form-ico pass"><i class="las la-user-alt"></i></span>
								 @if ($errors->has('f_name'))
        <div class="error" style="color:red;">{{ $errors->first('f_name') }}</div>
@endif
							</div>
							<div class="col-md-6">
							    <div class="palceholder">
							   <label>Last Name </label>
							  
							</div>
								<input type="text" class="form-control" name="l_name" required="">
								<span class="form-ico pass"><i class="las la-user-alt"></i></span>
								@if ($errors->has('l_name'))
        <div class="error" style="color:red;">{{ $errors->first('l_name') }}</div>
@endif
							</div>
							</div>
							
								<div class="row form-group">
							<div class="col-md-6">
							    <div class="palceholder">
							   <label>Email </label>
							   
							</div>
								<input type="email" class="form-control" name="email" required="">
								<span class="form-ico pass"><i class="lar la-envelope"></i></span>
								@if ($errors->has('email'))
        <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
@endif
							</div>
							<div class="col-md-6">
							    <div class="palceholder">
							   <label>Your Contact Number </label>
							  
							</div>
								<input type="text"  class="form-control" name="p_no" required="">
								<span class="form-ico pass"><i class="las la-phone"></i></span>
								@if ($errors->has('p_no'))
        <div class="error" style="color:red;">{{ $errors->first('p_no') }}</div>
@endif
							</div>
							</div>
							
							<div class="row form-group">
							<div class="col-md-6">
							    <div class="palceholder">
							   <label> Create New Password </label>
							 
							</div>
								<input type="password" class="form-control" name="pass" required="">
								<span class="form-ico pass"><i class="las la-lock"></i></span>
								@if ($errors->has('pass'))
        <div class="error" style="color:red;">{{ $errors->first('pass') }}</div>
@endif
							</div>
							<div class="col-md-6">
							    <div class="palceholder">
							   <label>Confirm  New  Password </label>
							   
							</div>
								<input type="password" class="form-control" name="con_password" required="">
								<span class="form-ico pass"><i class="las la-lock"></i></span>
								@if ($errors->has('con_password'))
        <div class="error" style="color:red;">{{ $errors->first('con_password') }}</div>
@endif
							</div>
							</div>
							
							<div class="form-check">
							<div class="col-md-12">
							  <label class="form-check-label">
								<input type="checkbox" class="form-check-input" value="confirm" name="confirm"  required=""> I confirm that I have read the <a href="http://workpermitcloud.co.uk/privacy-policy">Privacy Policy</a> and I agree to the website <a href="https://workpermitcloud.co.uk/terms-of-use">Terms of Use</a> and <a href="https://workpermitcloud.co.uk/licence-agreement">License Agreement</a>																																																																									
							  </label>
							   @if ($errors->has('confirm'))
									<div class="error" style="color:red;">{{ $errors->first('confirm') }}</div>
								@endif
							</div>
							</div>
							
							<div class="form-check">
							<div class="col-md-12">
							  <label class="form-check-label">
								<input type="checkbox" class="form-check-input" value="understand"  name="understand"  required=""> I understand that they do not, in any way, replace immigration advice																																																																				
							  </label>
							   @if ($errors->has('understand'))
        <div class="error" style="color:red;">{{ $errors->first('understand') }}</div>
@endif
							</div>
							</div>
							<div class="row form-group">
							<div class="col-md-12">
								<button class="btn btn-default" type="submit">REGISTER</button>
								
							</div>
							
							<div class="col-md-12"><p style="color:red;text-align:right;margin:5px 5px 0 0;font-size:14px"> All fields are mandatory </p></div>
							</div>
							
						</form>	
						<div class="row google">
						<div class="col-md-12">
						<hr>
						<span>Already have an account?</span>
							<p><a href="{{ url('login-pay') }}">LOGIN</a></p>
							</div>
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
      
      $('.palceholder').click(function() {
  $(this).siblings('input').focus();
});
$('.form-control').focus(function() {
  $(this).siblings('.palceholder').hide();
});
$('.form-control').blur(function() {
  var $this = $(this);
  if ($this.val().length == 0)
    $(this).siblings('.palceholder').show();
});
$('.form-control').blur();
  </script>
  
  </body>
</html>