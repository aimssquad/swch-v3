<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamstechnologies - Bootstrap Admin Template">
        <title>Forgot Password - HRMS admin template</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    	<link rel="stylesheet" href="{{asset('frontend/assets/plugins/fontawesome/css/all.min.css')}}">

		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/line-awesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('frontend/assets/css/material.css')}}">
		
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
							<h3 class="account-title">Forgot Password?</h3>
							<p class="account-subtitle">Your Virtual HR Manager</p>
							
							<!-- Account Form -->
							<form action="{{url('forgot-password')}}" method="post" id="my_captcha_form">
                                @csrf
								<div class="input-block mb-4">
									<label class="col-form-label">Email Address</label>
									<input class="form-control" type="text" name="email">
								</div>
								<div class="input-block mb-4 text-center">
									<button class="btn btn-primary account-btn" type="submit">Reset Password</button>
								</div>
								<div class="account-footer">
									<p>Remember your password? <a href="{{ url('/') }}">Login</a></p>
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
		
    </body>
</html>