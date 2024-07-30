<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
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
.page-name ul li{list-style: none;color: #fff;display: inline-block;}.career{    width: 100%;margin-top: 85px;}
.career-outer {padding-bottom: 50px;}.contact-body, .map, .agriculture, .success, .comment-box {padding: 50px 0 0;}
.heading h1{border-bottom: 2px solid #17276d;width: 50%;margin: 0 auto 30px;padding: 0 0 10px;position: relative;text-align: center;color: #17276d;}
h1:after, h1:before, h2:after, h2:before {content: "";}
.heading h1:after{background-color: #0757ad;height: 4px;position: absolute;bottom: -3px;left: 0;width: 20%;text-align: center;right: 0;margin: 0 auto;}.sb {margin: 0;padding: 0;
}.job-head h3 {color: #17276d;    margin-top: 15px;}
.job {border: 1px solid #ddd;border-bottom: 3px solid #ddd;
    background-image: linear-gradient(to right, #f7dbff, #e4f8fb) !important;
}
.apply a {background-color: #01aef0;color: #fff;padding: 8px 18px;border-radius: 3px;border: 2px solid #01aef0;}.apply {float: right;margin-bottom: 22px;}.apply a:hover {
    color: #01aef0;background: transparent;}.sb a{color:#fff;font-size: 22px;}.sb li{ width: 40px;height: 40px;list-style: none;padding: 4px 10px;display: inline-block;}
.btn-default {
    background: #17276d !important;
    color: #fff !important;
    border: 0px!important;
}
.btn-default:disabled, .btn-default:focus, .btn-default:hover {
    background: #30feff !important;
    color: #fff !important;
    border: 0px!important;
}
</style>
</head>
<body>
	 <header>
	<div class="container">
	  <div class="row">
	     <div class="col-md-12">
	         <?php
	          $Roledatajj = DB::table('registration')      
                 
                  ->where('reg','=',$job->emid) 
                  ->first();
                
                  if(!empty($Roledatajj->logo)){
                      
                      $loh=$Roledatajj->logo;
                 
                      
                    }else{
                      
                      
                  }  
                  
	         ?>
		    <div class="text-center logo">
			  <?php
			      if(!empty($Roledatajj->logo)){
			         ?> <h1><img  style=" max-width: 160px;
    max-height: 78px;
    position: absolute;
   
    left: 0px;" src="{{ asset($loh)}}" alt=""> </h1><?php   }else{ ?>  <h1 style="color:#fff; max-width: 160px;
    max-height: 78px;
   position: absolute;
   
    left: 0px;">LOGO </h1><?php    }
	         ?>
	         	<h2>{{ $Roledatajj->com_name}}</h2>
			</div>
		 </div>
	  </div>
	</div>
	</header>
	
	<!--<div class="name">-->
	<!--<div class="text-center page-name">-->
	
	
	<!--</div>-->
	<!-- </div>-->
	 
	 
	 <div id="about" class="contact-body career-outer">
        	<div class="container-fluid">
            	<div class="row">
                	<div class="career">
                    <div class="col-lg-12">
                    	<div class="heading">
                    		<h1>Job Description</h1>
                        </div>
                    </div>
                    	<div class="web-job-desc">
						<div class="container">
							<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 job">
							<p></p>
							 <ul class="sb large flat no-border blue">
			    <li style="background-color:#325A97;"><a class="w-inline-block social-share-btn fb" href="https://www.facebook.com/sharer/sharer.php?u=&t=" title="Share on Facebook" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><i class="lab la-facebook-f"> </i></a></li>
				<li style="background-color:#00ACED;"><a class="w-inline-block social-share-btn tw" href="https://twitter.com/intent/tweet?" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=%20Check%20up%20this%20awesome%20content' + encodeURIComponent(document.title) + ':%20 ' + encodeURIComponent(document.URL)); return false;"><i class="lab la-twitter"></i></a>	</li>
				<li style="background-color:#DD4B39;"><a class="w-inline-block social-share-btn gplus" href="https://plus.google.com/share?url=" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><i class="lab la-google-plus-g"></i></a</li>
				
				<li style="background-color:#0066CC;margin-left:7px;"><a class="w-inline-block social-share-btn lnk" href="http://www.linkedin.com/shareArticle?mini=true&url=&title=&summary=&source=" target="_blank" title="Share on LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' + encodeURIComponent(document.title)); return false;"><i class="lab la-linkedin-in"></i></a></li>
			</ul>
									<div class="job-head">
										<h3>{{ $Roledatajj->com_name}}</h3>
									</div>
									<div class="job-content">
										<p>Job Title : {{ $job->title}} (Code- {{ $job->job_code}})<br>
										<span>Experience:</span> {{ $job->work_min}} - {{ $job->work_max}} Years<br>
										
										
										</p>
											<h5> Job Description  /  Responsibilities:</h5>
											<p>{!! $job->job_desc !!}</p>
											
											<h5>Educational Qualification:</h5>
											<p>{{ $job->quli}}</p>
											@if($job->skill!='')
											<h5>Skill Set:</h5>
											<p>{{ $job->skill}}</p>
											@endif
										
											@if($job->gender_male!='' || $job->gender)
											<h5>Gender:</h5>
											<p>{{ $job->gender_male}}<?php if($job->gender!='' && $job->gender_male !=''){ echo ',';}  ?> {{ $job->gender}}</p>
											@endif
											<h5>Job Type:</h5>
											<p>{{ $job->job_type}}</p>
											
											<h5>Working Hours:</h5>
											<p>{{ $job->working_hour}} hours weekly</p>
											@if($job->english_pro!='')
												<h5>Language Requirements:</h5>
											<p> @if($job->english_pro!='Others') {{ $job->english_pro}} @else $job->other   @endif</p>
											@endif
											@if($job->basic_min!='')
												<h5>Salary :</h5>
											<p>{{ $job->basic_min}} - {{ $job->basic_max}}    {{ $job->time_pre}}</p>
											@endif
										<span class="apply"><a class="btn btn-default" href="{{url('career/application/'. base64_encode($job->id))}}">Apply</a></span>
										<p></p>
									</div>
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
</body>
</html>