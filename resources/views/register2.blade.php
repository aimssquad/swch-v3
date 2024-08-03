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
<style>
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
	.form-body .btn.btn-default,.google p {
		background-image: linear-gradient( 180deg, hsl(180deg 100% 65%) 0%, hsl(184deg 94% 55%) 11%, hsl(187deg 100% 47%) 22%, hsl(190deg 100% 45%) 33%, hsl(193deg 100% 43%) 44%, hsl(196deg 100% 40%) 56%, hsl(199deg 100% 37%) 67%, hsl(201deg 100% 34%) 78%, hsl(206deg 86% 33%) 89%, hsl(216deg 61% 33%) 100% );
		padding: 12px 0;
		border-radius: 30px;
		border: none;
	}
	.google p{
		padding:0;
	}
	.google p a{
		display:block;
		padding: 12px 0;
	}
	span.form-ico i {
		margin-top: 5px;
	}

</style>
<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
    <title>SWCH</title>
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
			<div class="row d-flex justify-content-center align-items-center h-100 ml-5">

				<div class="col-lg-6 col-md-6 ml-5">
					<div class="emp">
						<h4>Register Here</h4>
					<form action="{{url('register')}}" method="post" enctype="multipart/form-data">
						 {{csrf_field()}}
						 @include('layout.message')
						 	
						 	
							@if (!empty($org_code))
								<input type="hidden" class="form-control" name="org_code"  value="{{$org_code}}" autocomplete="off" >
								<input type="hidden" class="form-control" name="subadmin"  value="Organization" autocomplete="off" >
							@else
								<div class="row form-group">
									<div class="col-md-12">
										<select class="form-control" name="subadmin"  required="">
											<option value="">Select type</option>
											<option value="Partner">Partner</option>
											<option value="Organization">Organization</option>
										</select>
									</div>
								</div>	
							@endif

							<div class="row form-group">
							<div class="col-md-12">
							<div class="palceholder">
							   

							</div>
								<input type="text" class="form-control" placeholder="Organization name" name="com_name"  required="" value="{{old('com_name')}}">
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
								<input type="text" class="form-control"  name="f_name" required="" value="{{old('f_name')}}">
								<span class="form-ico pass"><i class="las la-user-alt"></i></span>
								@if ($errors->has('f_name'))
										<div class="error" style="color:red;">{{ $errors->first('f_name') }}</div>
								@endif
							</div>
							<div class="col-md-6">
							    <div class="palceholder">
							   <label>Last Name </label>

							</div>
								<input type="text" class="form-control" name="l_name" required=""  value="{{old('l_name')}}">
								<span class="form-ico pass"><i class="las la-user-alt"></i></span>
								@if ($errors->has('l_name'))
										<div class="error" style="color:red;">{{ $errors->first('l_name') }}</div>
								@endif
							</div>
							</div>

								<div class="row form-group">

								<div class="col-md-6">
									<select class="form-control" name="country" id="country" required="">
										<option value="">Select Country</option>
										<?php foreach($user_details as $item){ ?>
											<option value="<?php echo $item->name ?>">{{$item->name}}</option>
										<?php } ?>
									
									</select>
								</div>

									<div class="col-md-6">
										<div class="palceholder">
									<label>Email </label>
									</div>
										<input type="email" class="form-control" name="email" required="" value="{{old('email')}}" autocomplete="off"><br/>
										<span class="form-ico pass"><i class="lar la-envelope"></i></span>
										@if ($errors->has('email'))
												<div class="error" style="color:red;">{{ $errors->first('email') }}</div>
										@endif
									</div>
							
							<div class="col-md-6">
								<select class="form-control" name="country_code" id="country_code" required="">
									{{-- <option value="">Select Country Code</option> --}}
									<?php //foreach($user_details as $item){ ?>
										{{-- <option value="<?php// echo '+'.$item->phonecode ?>">+{{$item->phonecode}}</option> --}}
										  <?php // } ?>
                                 
								</select>
							</div>
							<div class="col-md-6">
							    <div class="palceholder">
							   <label>Your Contact Number </label>

							</div>
							
								<input type="text"  class="form-control" name="p_no" required="" value="{{old('p_no')}}">
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
								<input type="password" class="form-control" name="pass" required="" autocomplete="off">
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
									<input type="checkbox" class="form-check-input" value="confirm" name="confirm"  required=""> I confirm that I have read the <a href="#">Privacy Policy</a> and I agree to the website <a href="#">Terms of Use</a> and <a href="#">License Agreement</a>
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
							<!-- <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="capcha">
                                        <div class="g-recaptcha" id="rcaptcha"
                                            data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}" data-theme="light"></div>
                                    </div>
                                    <div id="recaptcha-error" style="color:red;">
                                    </div>
                                </div>

                            </div> -->
							<div class="row form-group">
							<div class="col-md-12">
								<button class="btn btn-default" type="submit">REGISTER</button>

							</div>

							<div class="col-md-12"><p style="color:red;text-align:right;margin:5px 5px 0 0;font-size:14px"> All fields are mandatory </p></div>
							</div>

						</form>
						<div class="row google">
						<div class="col-md-12">
						<!-- <hr> -->
						<span>Already have an account?</span>
							<p class="mt-1"><a href="{{ url('/') }}">LOGIN</a></p>
							</div>
						</div>

					</div>
				</div>

				<!-- <div class="text-center col-lg-7 col-md-6 mt-5">
			    	<h3 class="mt-5">Your Virtual HR Manager</h3>
			    	<img src="{{ asset('img/hiring.png')}}" alt="" style="width: 100%;">
			    </div> -->
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
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
    $('#country').change(function() {
        var countryName = $(this).val();
		//console.log(countryName);
        if (countryName) {
            $.ajax({
                url: "{{ route('get-country-code') }}",
                type: "GET",
                data: { country: countryName },
                success: function(response) {
                    if (response.phonecode) {
                        $('#country_code').html('<option value="+' + response.phonecode + '">+' + response.phonecode + '</option>');
                    } else {
                        $('#country_code').html('<option value="">Country code not found</option>');
                    }
                },
                error: function(xhr) {
                    console.error("An error occurred: " + xhr.status + " " + xhr.statusText);
                    $('#country_code').html('<option value="">Country code not found</option>');
                }
            });
        } else {
            $('#country_code').html('<option value="">Select Country Code</option>');
        }
    });
});

	</script>
  </body>
</html>
