<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
</head>

<body>



    <div class="clearfix"></div>
    <div class="text-center employer-section" style="width:100%;max-width: 800px;margin: 0 auto;   ">
        <div class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <img src="{{ asset('img/like.png')}}" alt="" style="width: 100px;margin-bottom: 25px;">

                    <h6 style="font-size:21px;">Congratulations...!!!</h6>
                    <h5>Your payment done successfully</h5>
                    <h4>This page will automatically redirect. Please do not refresh the page.</h4>

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
        © 2021, HRMS | All Right Reserved
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
    window.setTimeout(function() {




        window.location.href = "{{url('billingorganization/billinglist')}}";


    }, 10000);
    </script>
</body>

</html>