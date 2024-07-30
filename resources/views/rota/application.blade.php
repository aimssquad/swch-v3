<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>
	
	<!-- Fonts and icons -->
<link rel="icon" href="{{ asset('carrassests/img/icon.ico')}}" type="image/x-icon"/>
		
	<link rel="stylesheet" href="{{ asset('carrassests/css/line-awesome.min.css')}}">
	
	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	 
<style>
  a, a:hover{text-decoration:none}
  header{
      width: 100%;
    height: 100px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 9999;
    -webkit-transition: height 0.3s;
    -moz-transition: height 0.3s;
    -ms-transition: height 0.3s;
    -o-transition: height 0.3s;
    transition: height 0.3s;
    background: url(img/header-bar.jpg) repeat-x center bottom;
    background-color: rgba(255, 255, 255, 0.98);
    box-shadow: 0 12px 10px -13px #333;
}
.logo h1{    padding-top: 16px;}
.name {
    height: 110px;
    padding: 10px 0;
    margin: 100px 0 0;
    background-color: #3E3E3E;
}
.page-name h2{margin: 0;color: #fff;padding-top: 11px;}
.page-name ul{padding-left: 0;margin-top: 5px;}
.page-name ul li{list-style: none;color: #fff;display: inline-block;}.career{    width: 100%;}
.career-outer {padding-bottom: 50px;}.contact-body, .map, .agriculture, .success, .comment-box {padding: 50px 0 0;}
.heading h1{border-bottom: 2px solid #01AEF0;width: 50%;margin: 0 auto 30px;padding: 0 0 10px;position: relative;text-align: center;color: #01aef0;}
h1:after, h1:before, h2:after, h2:before {content: "";}
.heading h1:after{background-color: #0686b7;height: 4px;position: absolute;bottom: -3px;left: 0;width: 20%;text-align: center;right: 0;margin: 0 auto;}.sb {margin: 0;padding: 0;
}.job-head h3 {color: #a31d64;    margin-top: 15px;}.job {border: 1px solid #ddd;border-bottom: 3px solid #ddd;background-color: #f5eeee;}
.apply a {background-color: #a31d64;color: #fff;padding: 8px 18px;border-radius: 3px;border: 2px solid #a31d64;}.apply {float: right;margin-bottom: 22px;}.apply a:hover {
    color: #a31d64;background: transparent;}.sb a{color:#fff;font-size: 22px;}.sb li{ width: 40px;height: 40px;list-style: none;padding: 4px 10px;display: inline-block;}
	.job-apply {
    border: 1px solid #ddd;
    border-bottom: 3px solid #ddd;
    padding: 20px;
    background-color: #f9f2f2;
}label{font-weight:600}
</style>
</head>
<body>
	    <header>
	<div class="container">
	  <div class="row">
	     <div class="col-md-12">
		    <div class="text-center logo">
			  <h1>	<img src="{{ asset('img/logo.png')}}" alt=""></h1>
			</div>
		 </div>
	  </div>
	</div>
	</header>
	
	<div class="name">
	<div class="text-center page-name">
		<h2>Visitor Register</h2>
		
	</div>
	 </div>
	 
	 
	 <div id="about" class="contact-body career-outer">
        	<div class="container-fluid">
            	<div class="row">
                	<div class="career">
                    <div class="col-lg-12">
                    	<div class="heading">
                    		<h1>Visitor Details</h1>
                        </div>
                    </div>
                    	<div class="web-job-desc">
						<div class="container">
							<div class="row">
								<div class="col-md-12 job-apply">
								<form action="{{url("visitor")}}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
								<input id="reg" type="hidden"  name="reg" class="form-control input-border-bottom" required="" value="<?php   echo $role->reg;  ?>" >
				
								 <div class="row form-group">
								
									<div class="col-md-6">
										<label for="name">Name:</label>
										<input type="text" class="form-control" name="name" id="name" required="">
									  </div>
									   <div class="col-md-6">
										<label for="name">Designation:</label>
										<input type="text" class="form-control" name="desig" id="desig" required="">
									  </div>
									  
									  </div>
									 
									  <div class="row form-group">
									  <div class="col-md-6">
										<label for="email">Email ID:</label>
										<input type="email" class="form-control" name="email">
									  </div>
									  <div class="col-md-6">
										<label for="mobile">Contact No.:</label>
										  <input type="tel" class="form-control" name="phone_number" required="">
									  </div>
									  </div>
									<div class="row form-group">  
								 <div class="col-md-6">
										<label for="name">Address:</label>
										<input type="text" class="form-control" name="address" id="address" required="">
									  </div>
									   <div class="col-md-6">
										<label for="name">Description:</label>
										<textarea  class="form-control" name="purpose" id="purpose" required=""></textarea>
									
									  </div>
							       
							</div>
							
							<div class="row form-group">
								  <div class="col-md-6">
										<label for="name">Date:</label>
										<input type="date" class="form-control" name="date" id="date" required="" min="<?=date('Y-m-d');?>">
									  </div>
									  
									   <div class="col-md-6">
										<label for="name">Time:</label>
										<input type="time" class="form-control" name="time" id="time" required="">
									
									  </div>
									  <div class="col-md-6">
										<label for="name">Reference:</label>
										<textarea  class="form-control" name="reff" id="reff" required=""></textarea>
									
									  </div>
								  </div>
								
								  
							
							
								  <div class="row form-group">
								<div class="text-left col-md-12 cv">
									  <button class="btn btn-default" type="submit" name="add_job" value="Submit" style="    background: #01aef0;color: #fff;">Submit </button>
								</div>
								</div>
								</form>
								</div>
							</div>
						</div>
						</div>
                    </div>
                </div>
            </div>
        </div>












 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>