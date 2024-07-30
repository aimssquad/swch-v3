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
    position: absolute;
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
.heading h1{border-bottom: 2px solid #17276d;width: 50%;margin: 0 auto 30px;padding: 0 0 10px;position: relative;text-align: center;color: #17276d;}
h1:after, h1:before, h2:after, h2:before {content: "";}
.heading h1:after{background-color: #0686b7;height: 4px;position: absolute;bottom: -3px;left: 0;width: 20%;text-align: center;right: 0;margin: 0 auto;}.sb {margin: 0;padding: 0;
}.job-head h3 {color: #a31d64;    margin-top: 15px;}.job {border: 1px solid #ddd;border-bottom: 3px solid #ddd;background-color: #f5eeee;}
.apply a {background-color: #a31d64;color: #fff;padding: 8px 18px;border-radius: 3px;border: 2px solid #a31d64;}.apply {float: right;margin-bottom: 22px;}.apply a:hover {
    color: #a31d64;background: transparent;}.sb a{color:#fff;font-size: 22px;}.sb li{ width: 40px;height: 40px;list-style: none;padding: 4px 10px;display: inline-block;}
	.job-apply {
    border: 1px solid #ddd;
    border-bottom: 3px solid #ddd;
    padding: 20px;
   background-image: linear-gradient(to right, #f7dbff, #e4f8fb) !important;
}label{font-weight:600}

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
     <?php
$Roledatajj = DB::table('registration')

    ->where('reg', '=', $job->emid)
    ->first();
if (!empty($Roledatajj->logo)) {

    $loh = $Roledatajj->logo;
} else {

}
?>
	    <header >
	<div class="container">
	  <div class="row">
	     <div class="col-md-12">
		    <div class="text-center logo">
			    <?php
if (!empty($Roledatajj->logo)) {
    ?> <h1><img  style=" max-width: 160px;
    max-height: 78px;
    position: absolute;
    top: 120px;
    left: 0px;" src="{{ asset($loh)}}" alt=""> </h1><?php } else {?>  <h1 style="color:#fff; max-width: 160px;
    max-height: 78px;
    position: absolute;
    top: 110px;
    left: 0px;">LOGO </h1><?php }
?>
			</div>
		 </div>
	  </div>
	</div>
	</header>

	<div class="name">
	<div class="text-center page-name">
		<h2>{{ $job->title}}</h2>

		<ul>
		  <li><i class="las la-map-marker"></i> {{ $job->job_loc}}  </li>

		</ul>
	</div>
	 </div>


	 <div id="about" class="contact-body career-outer">
        	<div class="container-fluid">
            	<div class="row">
                	<div class="career">
                    <div class="col-lg-12">
                    	<div class="heading">
                    		<h1>Job Application</h1>
                    			@if(Session::has('message'))
										<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif
                        </div>
                    </div>
                    	<div class="web-job-desc">
						<div class="container">
							<div class="row">
								<div class="col-md-12 job-apply">
								<form action="{{url("career/application")}}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
								<input id="job_id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php echo $job->id; ?>" >

								 <div class="row form-group">
								  <div class="col-md-6">
                                    <label for="name">Job Title <span style="color:red">*</span>:</label>
                                    <input type="text" class="form-control" name="job_title"  required=""   value="<?php echo $job->title; ?>" readonly="">
                                  </div>
									<div class="col-md-6">
										<label for="name">Name <span style="color:red">*</span> :</label>
										<input type="text" class="form-control" name="name" id="name" required="">
									  </div>
									  </div>
									  <div class="row form-group">
									  <div class="col-md-6">
										<label for="email">Email ID:</label>
										<input type="email" class="form-control" name="email">
									  </div>
									  <div class="col-md-6">
										<label for="mobile">Contact No.:</label>
										  <input type="tel" class="form-control" name="phone">
									  </div>
									  </div>
									<div class="row form-group">
									<div class="col-md-6">
                                    <label for="location">Gender:</label>
                                    <select class="form-control" name="gender" >
									  <option value="">Select</option>
									  <option value="Male">Male</option>
									  <option value="Female">Female</option>
									</select>
                                  </div>
                                  <div class="col-md-6">
										<label for="mobile">Date Of Birth.:</label>
										  <input type="date" class="form-control" name="dob">
									  </div>
									  	</div>

							<div class="row form-group">
							       <div class="col-md-6">
							  <label for="year">Experience in Year:</label>
							  <select class="form-control" name="exp" id="experience-year" >
							   <option value="">Select</option>
			   @for ($i = 0; $i <= 20; $i++)

<option value="{{ $i }}" >{{ $i }}</option>
@endfor



							  </select>
							</div>

								     	<div class="col-md-6">
										  <label for="month">Experience in Months:</label>
										   <select class="form-control" name="exp_month" id="experience-month" >
											 <option value="">Select</option>
			   @for ($j = 0; $j <= 11; $j++)

<option value="{{ $j }}" >{{ $j }}</option>
@endfor
										  </select>
										</div>
										</div>
								  <div class="row form-group">
									<div class="col-md-6">

                                    <label for="quali">Educational Qualification:</label>
                                    <input type="text" class="form-control" name="edu" >
                                  </div>

								   <input type="hidden" class="form-control" name="skill_level" >
								    <input type="hidden" class="form-control" name="sal" >
                                  <div class="col-md-6">
								    <label for="key">Skill Set:</label>
                                    <input type="text" class="form-control" name="skill" >

								  </div>
								   </div>
								   <div class="row form-group">


								      <div class="col-md-6">
                                    <label for="file">Most Recent Employer:</label>
                                    <input type="text" class="form-control" name="cur_or" >
                                  </div>

								  <div class="col-md-6">
                                    <label for="file">Most Recent  job Title:</label>
                                    <input type="text" class="form-control" name="cur_deg">
                                  </div>


                                  <div class="col-md-6">
                                    <label for="file">Current Post code :</label>
                                    <input type="text" class="form-control" name="zip" id="zip" onchange="getcode();">
                                  </div>
								  <div class="col-md-6">
                                    <label for="file">Current Location / Address:</label>
                                    <input type="text" class="form-control" name="location" id="location">
                                  </div>

								   <div class="col-md-6">
                                    <label for="file">Expected salary:</label>
                                    <input type="number" class="form-control" name="exp_sal" >
                                  </div>
                                  <div class="col-md-6">
                                    <label for="addr">Uplaod Cover Letter:</label>
                                     <input type="file" class="form-control" accept="application/pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="cover_letter"  >
                                  </div>

								    <div class="col-md-6">
                                    <label for="addr">Uplaod Resume <span style="color:red">*</span>:</label>
                                     <input type="file" class="form-control" accept="application/pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="resume"  required="">
                                  </div>
								  </div>
								  <div class="row form-group">
								<div class="text-left col-md-12 cv">
									  <button class="btn btn-default" type="submit" name="add_job" value="Submit">Submit Application</button>
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












 <script src="{{ asset('employeeassets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
    <script>
function getcode(){

    var getaddres=$("#zip").val();
    	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigappaddressById')}}/'+getaddres,
        cache: false,
		success: function(response){

		 var obj = jQuery.parseJSON(response);
			  console.log(obj);
			  if(obj.route!=''){
			      var add1=obj.route + ', ' + obj.neighborhood;
			        var add2=obj.administrative_area_level_1;
			         var add3=obj.administrative_area_level_2;
			  }else if(obj.neighborhood!=''){
			      var add1=obj.neighborhood + ', ' + obj.administrative_area_level_1;
			       var add2=obj.administrative_area_level_2;
			          var add3='';
			  }else{
			        var add1= obj.administrative_area_level_1;
			          var add2=obj.administrative_area_level_2;
			           var add3='';
			  }

			    $("#location").val(add1+ ',' +add2+ ',' +add3+ ',' +obj.postal_town+ ',' +obj.country);

		}
		});

}

</script>
</html>