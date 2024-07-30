<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/line-awesome.min.css')}}" />

    <title>SWCH</title>
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
.main-panel{margin-top:0;}
.page-name h2{margin: 0;color: #fff;padding-top: 11px;}
.page-name ul{padding-left: 0;margin-top: 5px;}
.page-name ul li{list-style: none;color: #fff;display: inline-block;}.career{    width: 100%;}
.career-outer {padding-bottom: 50px;}.contact-body, .map, .agriculture, .success, .comment-box {padding: 50px 0 0;}
.heading h1{border-bottom: 2px solid #01AEF0;width: 50%;margin: 0 auto 30px;padding: 0 0 10px;position: relative;text-align: center;color: #A31D64;}
h1:after, h1:before, h2:after, h2:before {content: "";}
.heading h1:after{background-color: #A31D64;height: 4px;position: absolute;bottom: -3px;left: 0;width: 20%;text-align: center;right: 0;margin: 0 auto;}.sb {margin: 0;padding: 0;
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
			  <h1><a href="#">HRMPLUS</a>
			</div>
		 </div>
	  </div>
	</div>
	</header>
	
	<div class="name">
	<div class="text-center page-name">
		<h2>Employee Basic Information</h2>
		
	</div>
	 </div>
	 
	 
	 <div id="about" class="contact-body career-outer">
        	<div class="container-fluid">
            	<div class="row">
                	<div class="career">
                    <div class="col-lg-12">
                    	<div class="heading">
                    		<h1>Fill up the details</h1>
							@if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif	
								<?php
								$arr_em=array();
						
								$arr_em=explode(" ",$employee->name);
							
							
								if(count($arr_em)==2){
								    $f_n=$arr_em['0'];
								     $l_n=$arr_em['1'];
								     $m_n='';
								}else{
								   $f_n=$arr_em['0'];
								     $l_n=$arr_em['2'];
								     $m_n=$arr_em['1'];
								}
								
								?>
								
                        </div>
                    </div>
                    	<div class="web-job-desc">
						<div class="container">
							<div class="row">
								<div class="col-md-12 job-apply">
								<form method="post" name="signupForm100" enctype="multipart/form-data" action="{{url('new-employe/save-new')}}">
								{{ csrf_field() }}
								 <div class="row form-group">
								 <div class="col-md-6">
                                    <label for="name">Employee Code:</label>
									<input type="hidden" class="form-control" name="o_id" value="{{$employee->id}}" required="">
									<input type="hidden" class="form-control" name="emid" value="{{$reg}}" required="">
                                    <input type="text" class="form-control" name="emp_code" value="" required="">
                                  </div>
								  <div class="col-md-6">
                                    <label for="name">First Name:</label>
									
                                    <input type="text" class="form-control" name="emp_fname" value="{{$f_n}}" required="" readonly>
                                  </div>
									
									  </div>
									  <div class="row form-group">
									  <div class="col-md-6">
										<label for="name">Middle Name:</label>
										<input type="text" class="form-control" name="emp_mid_name" value="{{$m_n}}" readonly>
									  </div>
									  <div class="col-md-6">
										<label for="lname">Last Name:</label>
										<input type="text" class="form-control"  name="emp_lname"  required="" value="{{$l_n}}" readonly>
									  </div>
									
									  
									  </div>
									<div class="row form-group">
									     <div class="col-md-6">
										<label for="emp_department">Department:</label>
										<input type="text" class="form-control"  name="emp_department"  required="" value="{{$employee->department}}" readonly>
									  </div>
									  
									     <div class="col-md-6">
										<label for="emp_designation">Job Title:</label>
										<input type="text" class="form-control"  name="emp_designation"  required="" value="{{$employee->designation}}" readonly>
									  </div>
									  </div>
									   <div class="row form-group">
									     <div class="col-md-6">
										<label for="emp_status">Job Type:</label>
										<input type="text" class="form-control"  name="emp_status"  required="" value="{{$employee->job_type}}" readonly>
									  </div>
									  
									 	<div class="col-md-6">
                                    <label for="location">Email ID:</label>
                                    <input type="email" class="form-control" required="" name="emp_ps_email">
                                  </div>
  
							       	
							</div>
							
							<div class="row form-group">
							    	
									
						
							<div class="col-md-6">
							  <label for="year">Phone No.:</label>
							  <input type="tel" class="form-control"  required="" name="emp_ps_phone">
							</div>
								     	
									
                                    
								  </div>
								  
								   
								    
								   
								  
								  <div class="row form-group">
								<div class="text-left col-md-12 cv">
									  <button class="btn btn-default" type="submit" name="add_job" value="Submit" style="    background: #01aef0;color: #fff;">Submit</button>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>