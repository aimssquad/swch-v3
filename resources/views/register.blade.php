<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamstechnologies - Bootstrap Admin Template">
        <title>Register - HRMS admin template</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
		
		 
    </head>
    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<div class="container">
				
					<!-- Account Logo -->
					<div class="account-logo">
						<a href="admin-dashboard.html"><img src="{{asset('frontend/assets/img/swch_logo.png')}}" alt="Dreamguy's Technologies"></a>
					</div>
					<!-- /Account Logo -->
					
					<div class="account-box">
						<div class="account-wrapper">
							<h3 class="account-title">Register Here</h3>
							{{-- <p class="account-subtitle">Access to our dashboard</p> --}}
							
							<!-- Account Form -->
							<form action="{{url('register')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                @include('layout.message')
                                    
                                    
                                   @if (!empty($org_code))
                                       <input type="hidden" class="form-control" name="org_code"  value="{{$org_code}}" autocomplete="off" >
                                       <input type="hidden" class="form-control" name="subadmin"  value="Organization" autocomplete="off" >
                                   @else
                                       
                                        <div class="input-block mb-4">
                                            <label class="col-form-label">Select type<span class="mandatory">*</span></label>
                                            <select class="form-control" name="subadmin"  required="">
                                                <option value="">Select type</option>
                                                <option value="Partner">Partner</option>
                                                <option value="Organization">Organization</option>
                                            </select>
                                       </div>	
                                   @endif
                                <div class="input-block mb-4">
									<label class="col-form-label">Organization name<span class="mandatory">*</span></label>
									<input class="form-control" type="text" placeholder="Organization name" name="com_name"  required="" value="{{old('com_name')}}">
                                    @if ($errors->has('com_name'))
                                        <div class="error" style="color:red;">{{ $errors->first('com_name') }}</div>
                                    @endif
								</div>
								<div class="input-block mb-4">
									<label class="col-form-label">First Name<span class="mandatory">*</span></label>
									<input class="form-control" type="text" name="f_name" required="" value="{{old('f_name')}}">
                                    @if ($errors->has('f_name'))
										<div class="error" style="color:red;">{{ $errors->first('f_name') }}</div>
								    @endif
								</div>
								<div class="input-block mb-4">
									<label class="col-form-label">Last Name<span class="mandatory">*</span></label>
									<input class="form-control" type="text" name="l_name" required=""  value="{{old('l_name')}}">
                                    @if ($errors->has('l_name'))
										<div class="error" style="color:red;">{{ $errors->first('l_name') }}</div>
								    @endif
								</div>
                                <div class="input-block mb-4">
									<label class="col-form-label">Email<span class="mandatory">*</span></label>
									<input class="form-control" type="email" name="email" required="" value="{{old('email')}}">
                                    @if ($errors->has('email'))
										<div class="error" style="color:red;">{{ $errors->first('email') }}</div>
								    @endif
								</div>
								<div class="input-block mb-4">
									<label class="col-form-label">Country<span class="mandatory">*</span></label>
									<select class="form-control" name="country" id="country" required="">
										<option value="">Select Country</option>
										<?php foreach($user_details as $item){ ?>
											<option value="<?php echo $item->name ?>">{{$item->name}}</option>
										<?php } ?>
									
									</select>
								</div>
                                <div class="input-block mb-4">
									<label class="col-form-label">Country Code<span class="mandatory">*</span></label>
									<select class="form-control" name="country_code" id="country_code" required="">
                                        {{-- <option value="">Select Country Code</option> --}}
                                        <?php //foreach($user_details as $item){ ?>
                                            {{-- <option value="<?php// echo '+'.$item->phonecode ?>">+{{$item->phonecode}}</option> --}}
                                              <?php // } ?>
                                     
                                    </select>
								</div>
                                <div class="input-block mb-4">
									<label class="col-form-label">Your Contact Number<span class="mandatory">*</span></label>								
									<input class="form-control" type="text" name="p_no" required="" value="{{old('p_no')}}">
                                    @if ($errors->has('p_no'))
										<div class="error" style="color:red;">{{ $errors->first('p_no') }}</div>
								    @endif
								</div>
                                <div class="input-block mb-4">
									<label class="col-form-label">Password<span class="mandatory">*</span></label>
									<input class="form-control" type="text" name="pass" required="">
                                    @if ($errors->has('pass'))
										<div class="error" style="color:red;">{{ $errors->first('pass') }}</div>
								    @endif
								</div>
                                <div class="input-block mb-4">
									<label class="col-form-label">Repeat Password<span class="mandatory">*</span></label>
									<input class="form-control" type="text" name="con_password" required="">
                                    @if ($errors->has('con_password'))
										<div class="error" style="color:red;">{{ $errors->first('con_password') }}</div>
								    @endif
								</div>
								<div class="input-block mb-4 text-center">
									<button class="btn btn-primary account-btn" type="submit">Register</button>
								</div>
								<div class="account-footer">
									<p>Already have an account? <a href="{{ url('/') }}">Login</a></p>
								</div>
							</form>
							<!-- /Account Form -->
						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
       <script src="{{asset('frontend/assets/js/jquery-3.7.1.min.js')}}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
	
		<!-- Custom JS -->
		<script src="{{asset('frontend/assets/js/app.js')}}"></script>
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