<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SWCH</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assestscandidate/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assestscandidate/css/style.css')}}">
    <link rel="icon" href="{{ asset('assestscandidate/img/favicon.png')}}">

    <style type="text/css">
    .panel-title {

        display: inline;

        font-weight: bold;

    }

    .display-table {

        display: table;

    }

    .display-tr {

        display: table-row;

    }

    .display-td {

        display: table-cell;

        vertical-align: middle;

        width: 100%;

    }

    .panel-default>.panel-heading {
        width: 100%;
    }
    </style>
</head>

<body style="backgrond: #f3f3f3">

    <div class="pay-head" style="height:65px;background:#fff;box-shadow: 2px 0px 2px 2px #ccc;">
        <div class="container">
            <div class="row">
                <div class="py-logo">
                    <a href=""><img src="{{ asset('img/logo.png')}}" width="94"></a>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    @yield('javascripts')
</body>

</html>