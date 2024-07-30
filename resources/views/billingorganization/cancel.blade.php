<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <link rel="stylesheet" href="{{ asset('css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
    <title>SWCH</title>
  </head>
  <body>

<header>
    <!--<div class="header-top">-->
    <!--    <div class="container">-->
    <!--      <div class="row">-->
    <!--        <div class="col-md-12">-->
    <!--          <div class="phone"><span><i class="las la-phone-volume"></i> <i class="lab la-whatsapp" style="color: #24cc63;"></i> 020 8087 2343</span>-->
       
    <!--    </div>-->
    <!--        </div>-->

             
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    
  <div class="wrapper">
    <div class="row">
      <div class="col-5 col-md-4">
        <div class="logo">
           <a href="{{url('/')}}"><img src="{{ asset('img/logo.png')}}" alt=""></a>
        </div>
      </div>
  
      <div class="col-7 col-md-8">
       <div class="social">
            <ul>
               <li><a href="https://www.facebook.com/Skilled-Worker-Route-108128434702266/" target="_blank"><i class="lab la-facebook-square"></i></a></li>
                <li><a href="#" target="_blank"><i class="lab la-twitter-square"></i></a></li>
                <li><a href="https://www.linkedin.com/company/skilledworkerroute" target="_blank"><i class="lab la-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
  </div>
</header>


<div class="clearfix"></div>
<div class="employer-section" class="employer-section" style="width:100%;max-width: 800px;margin: 20px auto;">
        
  <div class="wrapper">
    <div class="row">
      <div class="col-md-12">
          <img src="{{ asset('img/dislike.png')}}" alt="" style="width: 100px;margin-bottom: 25px;">
          
        <h6 style="font-size:21px;">Sorry...!!!</h6>
         <h5>Your Transaction is failed</h5>
        
      </div>
     
    </div>
  </div>
</div>

<div class="text-center tj-copyright" style="background: #bfc9d6;
    font-size: 11px;
    font-weight: 500;
    padding: 10px 0;
    position: fixed;bottom:0;width:100%;
    z-index: 1;">
  © 2021, HRMS  | All Right Reserved
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script>
 	 window.setTimeout(function(){

	
        // Move to a new location or you can do something else
       
	        window.location.href = "{{url('billingorganization/billinglist')}}";
	

    }, 10000);
 </script>
  </body>
</html>