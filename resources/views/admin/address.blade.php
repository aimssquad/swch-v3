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
<script src='https://www.google.com/recaptcha/api.js'></script>
    <title>SWCH</title>
  </head>
  <body>
    <div class="form-body">
		<div class="container">
		    <dv class="d-block d-sm-block d-md-none d-lg-none d-xl-none col-md-6 mobile-log">
		        <img src="{{ asset('img/logo.png')}}">
		        <p style="    font-size: 15px;">Human Resource Management System</p>
		    </dv>
			<div class="row">
				<div class="col-md-6">
					<div class="reg-form">
						<form  method="post" action="#" id="my_captcha_form" >
						{{csrf_field()}}
						 @if(Session::has('message'))										
			<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
			@endif	
							<div class="row form-group">
							<div class="col-md-12">
								<input type="text" class="form-control" placeholder="post code"   name="post" id="post" onchange="getcode();">
								<span class="form-ico"><i class="las la-user-circle"></i></span>
								
								</div>
							</div>
							
							<div class="row form-group">
							<div class="col-md-12">
							    <select class="form-control" name="add" id="add"></select>
							
								</div>
							</div>
							
							
							<div class="row form-group">
							
							<div class="col-md-12">
								<button class="btn btn-default" type="submit">LOGIN</button>
								
							</div>	
							</div>
						</form>	
						<div class="row google">
						
						</div>
																																		
					</div>
				</div>
				
				<div class="d-none d-sm-none d-md-block d-lg-block d-xl-block col-md-6 right-part">
					<img src="{{ asset('img/logo.png')}}">
					<p>Human Resource Management System</p>
				</div>
			</div>
		</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="{{ asset('employeeassets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  
  <script>
function getcode(){
    
    var getaddres=$("#post").val();
    	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigappaddressByIdkk')}}/'+getaddres,
        cache: false,
		success: function(response){
			
			
			document.getElementById("add").innerHTML = response;
		}
		});
    
}

</script>
	
  </body>
</html>