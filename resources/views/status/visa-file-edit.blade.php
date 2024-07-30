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
            urls: ['{{ asset("assets/css/fonts.min.css")}}']
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
    <style>
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    </style>
</head>

<body>
    <div class="wrapper">

        @include('status.include.header')
        <!-- Sidebar -->

        @include('status.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">

                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            Home
                        </a>
                    </li>
                    <li class="separator">
                        /
                    </li>

                    <li class="nav-item">
                        <a href="{{url('organisation-status/view-visa-file')}}"> Visa File</a>
                    </li>
                    <li class="separator">
                        /
                    </li>
                    <li class="nav-item active">
                        <a href="#"> Edit Visa File</a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="far fa-folder"></i> Edit Visa File</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{url('organisation-status/edit-visa-file')}}" method="post"
                                        enctype="multipart/form-data" id="myForm">
                                        {{csrf_field()}}

                                        <input id="id" type="hidden" name="id" class="form-control input-border-bottom"
                                            style="margin-top: 22px;" value="{{$hr->id}}">
                                        <div class="row form-group">

                                            <?php
if (!empty($bill_rs)) {
    $type = $bill_rs->post_date;
    $d_type = date('Y-m-d', strtotime($bill_rs->post_date . '  + 3 Weeks'));
    $sub_date = date('Y-m-d', strtotime($bill_rs->post_date . '  + 4  Weeks'));
} else {
    $type = '';
    $d_type = '';
    $sub_date = '';
}
?>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos" class="placeholder">Name of candidate
                                                    </label>
                                                    <!-- <select class="form-control input-border-bottom"
                                                        id="com_employee_id" name="com_employee_id"
                                                        style="margin-top: 22px;" required disabled>
                                                        <option value="">Select Name of candidate</option>
                                                        @foreach($employees as $record)
                                                        <option value="{{$record->id}}" @if($hr->
                                                            com_employee_id==$record->id) selected
                                                            @endif>{{$record->emp_fname}}
                                                            {{$record->emp_mname}} {{$record->emp_lname}}</option>
                                                        @endforeach
                                                    </select> -->
                                                    <input id="employee_name" type="text" name="employee_name"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="{{$hr->employee_name}}" required >
                                                    <input id="com_employee_id" type="hidden" name="com_employee_id"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="0" >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos_assigned" class="placeholder">CoS assigned?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="cos_assigned" name="cos_assigned"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->cos_assigned=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->cos_assigned=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="candidate_type" class="placeholder">Candidate Type
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="candidate_type" name="candidate_type"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="IN" @if($hr->candidate_type=='IN') selected
                                                            @endif>In Country
                                                        </option>
                                                        <option value="OUT" @if($hr->candidate_type=='OUT') selected
                                                            @endif>Out Country
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_application_started" class="placeholder">Visa application started?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="visa_application_started" name="visa_application_started"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->visa_application_started=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->visa_application_started=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_application_start_date" class="placeholder">Visa application started - Date </label>
                                                    <input id="visa_application_start_date" type="date" name="visa_application_start_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="{{$hr->visa_application_start_date}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_application_submitted" class="placeholder">Visa application submitted?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="visa_application_submitted" name="visa_application_submitted"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->visa_application_submitted=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->visa_application_submitted=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_application_submit_date" class="placeholder">Visa application submitted - Date </label>
                                                    <input id="visa_application_submit_date" type="date" name="visa_application_submit_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="{{$hr->visa_application_submit_date}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="biometric_appo_date" class="placeholder">Biometric appointment date </label>
                                                    <input id="biometric_appo_date" type="date" name="biometric_appo_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="{{$hr->biometric_appo_date}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="documents_uploaded" class="placeholder">Documents uploaded?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="documents_uploaded" name="documents_uploaded"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->documents_uploaded=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->documents_uploaded=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="interview_date_confirm" class="placeholder">Interview date?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="interview_date_confirm" name="interview_date_confirm"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->interview_date_confirm=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->interview_date_confirm=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="interview_date" class="placeholder">Interview Date </label>
                                                    <input id="interview_date" type="date" name="interview_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="{{$hr->interview_date}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="mock_interview_confirm" class="placeholder">Mock interview?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="mock_interview_confirm" name="mock_interview_confirm"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->mock_interview_confirm=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->mock_interview_confirm=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="mock_interview_date" class="placeholder">Mock Interview Date </label>
                                                    <input id="mock_interview_date" type="date" name="mock_interview_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="{{$hr->mock_interview_date}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_granted_date" class="placeholder">Visa Granted - Date </label>
                                                    <input id="visa_granted_date" type="date" name="visa_granted_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="{{$hr->visa_granted_date}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="remarks" class="placeholder">Remarks</label>
                                                    <textarea id="remarks" name="remarks"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;">{{$hr->remarks}}</textarea>



                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status" class="placeholder"
                                                        style="padding-top:0;margin-top: 22px;">Status</label>
                                                    <select class="form-control input-border-bottom" id="status"
                                                        name="status">
                                                        <option value="">&nbsp;</option>
                                                        <!-- <option value="Request" @if($hr->status=='Request') selected
                                                            @endif>Request</option> -->
                                                        <option value="Granted" @if($hr->status=='Granted') selected
                                                            @endif>Granted</option>
                                                        <option value="Rejected" @if($hr->status=='Rejected')
                                                            selected @endif>Rejected</option>
                                                        <option value="Inactive" @if($hr->status=='Inactive')
                                                            selected @endif>Inactive</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-default btn-up">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
            @include('status.include.footer')
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
    </script>




    <script>
    function checkcompany() {
        var empid = document.getElementById("emidname").value;

        $.ajax({
            type: 'GET',
            url: '{{url("pis/getremidnamepaykkById")}}/' + empid,
            cache: false,
            success: function(response) {


                var obj = jQuery.parseJSON(response);

                console.log(obj);

                var reg = obj[0].reg;


                $("#emid").val(reg);
            }
        });
    }

    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            e.preventDefault();
            var status = document.getElementById("status").value;
            var visa_granted_date = document.getElementById("visa_granted_date").value;
            var visa_application_submitted = document.getElementById("visa_application_submitted").value;
            var visa_application_submit_date = document.getElementById("visa_application_submit_date").value;

            if(status=='Granted' && visa_granted_date==''){
                alert('Provide Visa Granted Date.');
                $("#visa_granted_date").focus();
            }
            else if(visa_application_submitted=='Yes' && visa_application_submit_date==''){
                alert('Provide Visa application submitted - Date.');
                $("#visa_application_submit_date").focus();

            }
            else{
                this.submit();
            }

        });
    });

    function bank_epmloyee(val) {
        if (val == 'Yes') {
            document.getElementById("criman_bank_new").style.display = "block";
        } else {
            document.getElementById("criman_bank_new").style.display = "none";
        }

    }

    function bank_yyepmloyee(val) {
        if (val == 'Yes') {
            document.getElementById("criman_banknn_new").style.display = "block";
        } else {
            document.getElementById("criman_banknn_new").style.display = "none";
        }

    }
    </script>
</body>

</html>