<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />


    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: [
                "{{ asset('assets/css/fonts.min.css')}}"
            ]
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/autocomplete.css')}}">
</head>

<body>
    <div class="wrapper">

        @include('admin.include.header')
        <!-- Sidebar -->

        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">
                <!--<h4 class="page-title">Organisation</h4>-->
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"> <i class="fas fa-user"></i> New Invoice Candidate</h4>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row form-group">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emid" class="placeholder">Select Organisation</label>
                                                    <input id="emidname" type="text" name="emidname"
                                                        class="form-control input-border-bottom" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="candidate_name" class="placeholder">Candidate
                                                        Name</label>
                                                    <input id="candidate_name" type="text" name="candidate_name"
                                                        class="form-control input-border-bottom" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email" class="placeholder">Candidate
                                                        Email</label>
                                                    <input id="email" type="email" name="email"
                                                        class="form-control input-border-bottom"  required="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="address" class="placeholder">Candidate Address</label>
                                                    <textarea id="address" type="text" name="address"
                                                        class="form-control input-border-bottom" required=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>




    <?php
$aryytestsys = array();
foreach ($or_rs as $billdept) {
    $aryytestsys[] = '"' . $billdept->com_name . '"';
}
$strpsys = implode(',', $aryytestsys);
?>
    <script src="{{ asset('js/jquery.autosuggest.js')}}"></script>
    <script>
    var component_name = [<?=$strpsys;?>];
    console.log(component_name);
    $("#emidname").autosuggest({
        sugggestionsArray: component_name
    });

    // autocomplete(document.getElementById("emidname"), countries);

    // function checkcompany() {
    //     var empid = document.getElementById("emidname").value;

    //     $.ajax({
    //         type: 'GET',
    //         url: "{{url('pis/getremidnamepaykkByIdnew')}}/" + empid,
    //         cache: false,
    //         success: function(html) {
    //             alert(html);
    //             $("#in_id").html(html);
    //         }
    //     });
    // }
    </script>
</body>

</html>