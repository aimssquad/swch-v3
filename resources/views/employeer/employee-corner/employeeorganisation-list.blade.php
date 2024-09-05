<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamstechnologies - Bootstrap Admin Template">
        <title>SWCH Login</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/img/favicon.png')}}">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    	<link rel="stylesheet" href="{{asset('frontend/assets/plugins/fontawesome/css/all.min.css')}}">

		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/line-awesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/assets/css/material.css')}}">
			
		<!-- Lineawesome CSS -->
		<link rel="stylesheet" href="{{asset('frontend/assets/css/line-awesome.min.css')}}">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">

    </head>
    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				{{-- <a href="job-list.html" class="btn btn-primary apply-btn">Apply Job</a> --}}
				<div class="container">
				
					<!-- Account Logo -->
					<div class="account-logo">
						<a href="admin-dashboard.html"><img src="{{asset('frontend/assets/img/swch_logo.png')}}" alt="Dreamguy's Technologies"></a>
					</div>
					<!-- /Account Logo -->
					
					<div class="account-box">
						<div class="account-wrapper">
							<h3 class="account-title">{{ $Roledata->com_name }}</h3>
							<p class="account-subtitle">Sign-in to Employee account</p>
							
							<!-- Account Form -->
							<form action="{{url('org-user-check-employee')}}"  method="post" id="my_captcha_form">
                                @csrf
                                @include('layout.message')
								<div class="input-block mb-4">
									<label class="col-form-label">Select Employee</label>
									<select class="form-control" required name="com" id="com">
                                        <option>Select Employee For Proceed</option>
                                        @foreach($users as $user)
                                        <?php
                                        $ff= DB::table('employee')->where('emp_code','=',$user->employee_id)->where('emid','=',$user->emid)->first();
                                         ?>
                                        <option value="{{$user->employee_id}}">{{$user->emp_fname}} {{$user->emp_mname}} {{$user->emp_lname}} ({{$user->employee_id}})</option>
                                        @endforeach
                                     </select>
								</div>
							
								<div class="input-block mb-4 text-center">
									<button class="btn btn-primary account-btn" type="submit">Login</button>
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