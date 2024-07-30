<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="assets/img/icon.ico" type="image/x-icon" />

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
            urls: ['{{ asset('
                assets / css / fonts.min.css ')}}'
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
</head>

<body>
    <div class="wrapper">
        @include('admin.include.header')
        <!-- Sidebar -->

        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <!-- <div class="page-header">
								<h4 class="page-title"> Referred Master</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('superadmin/view-referred')}}"> Referred Master</a>
							</li>
						</ul>
					</div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">



                                    <h4 class="card-title"> @if(isset($tareq->id)) Edit @else Add @endif Referred</h4>

                                </div>
                                <div class="card-body">
                                    <form action="{{url('superadmin/edit-referred')}}" method="post"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="row form-group">
                                            <input id="id" type="hidden" name="id"
                                                class="form-control input-border-bottom" required=""
                                                style="margin-top: 22px;" value="{{$tareq->id}}">
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                <label for="inputFloatingLabel" class="placeholder"> Name</label>
                                                    <input id="inputFloatingLabel" type="text"
                                                        class="form-control input-border-bottom" required="" name="name"
                                                        value="{{$tareq->name}}">
                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email" class="placeholder">Email</label>
                                                    <input id="email" type="email"
                                                        class="form-control input-border-bottom" required=""
                                                        name="email" value="{{$tareq->email}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="phone" class="placeholder"> Phone Number</label>
                                                    <input id="phone" type="tel"
                                                        class="form-control input-border-bottom" required=""
                                                        name="phone" value="{{$tareq->phone}}">
                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="address" class="placeholder"> Address</label>
                                                    <input id="address" type="text"
                                                        class="form-control input-border-bottom" name="address"
                                                        value="{{$tareq->address}}">
                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="bank_account_name" class="placeholder"> Bank Account Name</label>
                                                    <input id="bank_account_name" type="text"
                                                        class="form-control input-border-bottom" name="bank_account_name"
                                                        value="{{$tareq->bank_account_name}}">
                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="bank_account_no" class="placeholder"> Bank Account No.</label>
                                                    <input id="bank_account_no" type="text"
                                                        class="form-control input-border-bottom" name="bank_account_no"
                                                        value="{{$tareq->bank_account_no}}">
                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="bank_sort_code" class="placeholder"> Sort Code</label>
                                                    <input id="bank_sort_code" type="text"
                                                        class="form-control input-border-bottom" name="bank_sort_code"
                                                        value="{{$tareq->bank_sort_code}}">
                                                </div>

                                            </div>


                                            <div class="col-md-3">

                                                <div class="form-group">

                                                    <label for="selectFloatingLabel3" class="placeholder">Status</label>
                                                    <select id="selectFloatingLabel3"
                                                        class="form-control input-border-bottom" required name="status">
                                                        <option value="active" @if($tareq->status=='active') selected
                                                            @endif>Active</option>
                                                        <option value="inactive" @if($tareq->status=='inactive')
                                                            selected @endif >Inactive</option>
                                                    </select>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">

                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </div>
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

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <!-- Atlantis JS -->
    <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
    <script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({});

        $('#multi-filter-select').DataTable({
            "pageLength": 5,
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                            )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d +
                            '</option>')
                    });
                });
            }
        });

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $('#addRowButton').click(function() {
            $('#add-row').dataTable().fnAddData([
                $("#addName").val(),
                $("#addPosition").val(),
                $("#addOffice").val(),
                action
            ]);
            $('#addRowModal').modal('hide');

        });
    });


    function getEmployeeName() {
        //$('#emplyeename').show();
        var emp_code = $("#selectFloatingLabel option:selected").text();
        var empid = $("#selectFloatingLabel option:selected").val();
        var name = emp_code.split("(");

        $.ajax({
            type: 'GET',
            url: '{{url('
            role / get - employee - all - details ')}}/' + empid,
            success: function(response) {





                var obj = jQuery.parseJSON(response);
                console.log(obj);

                var bank_sort = obj[0].emp_ps_email;

                $("#inputFloatingLabel1").val(bank_sort);
                $("#inputFloatingLabel1").attr("readonly", true);






            }
        });
        $("#inputFloatingLabel").val(name[0]);



        //$("#emp_name").attr("readonly", true);
    }
    </script>
</body>

</html>