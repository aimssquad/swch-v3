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
                        <a href="{{url('organisation-status/view-recruitment-file')}}"> Recruitment File</a>
                    </li>
                    <li class="separator">
                        /
                    </li>
                    <li class="nav-item active">
                        <a href="#"> Edit Recruitment File</a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="far fa-folder"></i> Edit Recruitment File</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{url('organisation-status/edit-recruitment-file')}}" method="post"
                                        enctype="multipart/form-data" id="myForm">
                                        {{csrf_field()}}

                                        <input id="id" type="hidden" name="id" class="form-control input-border-bottom"
                                             value="{{$hr->id}}">
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
                                                         required disabled>
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
                                                         value="{{$hr->employee_name}}" required readonly>
                                                    <input id="com_employee_id" type="hidden" name="com_employee_id"
                                                        class="form-control input-border-bottom"
                                                         value="0" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos" class="placeholder">Candidate Email
                                                    </label>

                                                    <input id="employee_email" type="text" name="employee_email"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->employee_email}}" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="employee_address" class="placeholder">Candidate Billing Address
                                                    </label>

                                                    <input id="employee_address" type="text" name="employee_address"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->employee_address}}" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="correspondense_addr" class="placeholder">Candidate Correspondence Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="copy_bill_addr" id="copy_bill_addr"> <i style="font-weight:400;">Same As Billing Address</i>
                                                    </label> 

                                                    <input id="correspondense_addr" type="text" name="correspondense_addr"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->correspondense_addr}}" >

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos" class="placeholder">Candidate Phone
                                                    </label>

                                                    <input id="employee_phone" type="text" name="employee_phone"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->employee_phone}}" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="position" class="placeholder">Position/Title
                                                    </label>

                                                    <input id="position" type="text" name="position"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->position}}" >

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="soc" class="placeholder">SOC
                                                    </label>

                                                    <input id="soc" type="text" name="soc"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->soc}}" >

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="candidate_id" class="placeholder">Candidate ID
                                                    </label>

                                                    <input id="candidate_id" type="text" name="candidate_id"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->candidate_id}}" >

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="candidate_type" class="placeholder">Candidate Type
                                                    </label>

                                                    <select class="form-control input-border-bottom" id="candidate_type" name="candidate_type"
                                                        >
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
                                                <div class="form-group">
										            <label for="reffered" class="placeholder">Referred By</label>
												    <select class="form-control input-border-bottom" id="reffered"  name="reffered"  required>
													    <option value="OWN">OWN</option>
														<?php foreach($ref as $refrdept){
													    ?>
													    <option value="{{$refrdept->ref_id}}"  @if($hr->reffered==$refrdept->ref_id) selected @endif>{{$refrdept->name}}</option>
                                                        <?php
                                                        }
                                                        ?>
												    </select>
											    </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="candidate_identified" class="placeholder">Candidate Identified?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="candidate_identified" name="candidate_identified"
                                                        >
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->candidate_identified=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->candidate_identified=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="advert_posted" class="placeholder">Advert posted?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="advert_posted" name="advert_posted"
                                                        >
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->advert_posted=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->advert_posted=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="advert_start_date" class="placeholder">Advert start date </label>
                                                    <input id="advert_start_date" type="date" name="advert_start_date"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->advert_start_date}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="advert_end_date" class="placeholder">Advert end date </label>
                                                    <input id="advert_end_date" type="date" name="advert_end_date"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->advert_end_date}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="candidate_applied" class="placeholder">Candidate applied?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="candidate_applied" name="candidate_applied"
                                                        >
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->candidate_applied=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->candidate_applied=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="date_of_interview" class="placeholder">Date of interview </label>
                                                    <input id="date_of_interview" type="date" name="date_of_interview"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->date_of_interview}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="candidate_hired" class="placeholder">Candidate hired?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="candidate_hired" name="candidate_hired"
                                                        >
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes" @if($hr->candidate_hired=='Yes') selected
                                                            @endif>Yes
                                                        </option>
                                                        <option value="No" @if($hr->candidate_hired=='No') selected
                                                            @endif>No
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="candidate_hired_date" class="placeholder">Hiring Date </label>
                                                    <input id="candidate_hired_date" type="date" name="candidate_hired_date"
                                                        class="form-control input-border-bottom"
                                                         value="{{$hr->candidate_hired_date}}">
                                                </div>
                                            </div>



                                            <div class="col-md-8">
                                                <div class=" form-group">
                                                    <label for="remarks" class="placeholder">Remarks</label>
                                                    <textarea id="remarks" name="remarks"
                                                        class="form-control input-border-bottom"
                                                        >{{$hr->remarks}}</textarea>



                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status" class="placeholder"
                                                        style="padding-top:0;">Status</label>
                                                    <select class="form-control input-border-bottom" id="status"
                                                        name="status" onchange="status_change_for_stage();">
                                                        <option value="">&nbsp;</option>

                                                        <option value="Recruitment Ongoing" @if($hr->status=='Recruitment Ongoing') selected
                                                            @endif>Recruitment Ongoing</option>
                                                        <option value="Hired" @if($hr->status=='Hired')
                                                            selected @endif>Hired</option>


                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-4 stage_div_select" @if($hr->status=='Recruitment Ongoing') style="display:block;" @else style="display:none;" @endif>
                                                <div class="form-group">
                                                    <label for="status" class="placeholder"
                                                        style="padding-top:0;margin-top: 22px;">Recruitment Stage</label>
                                                    <select class="form-control input-border-bottom" id="stage_select"
                                                        name="stage_select" required onchange="updateStage();">
                                                        <option value="">&nbsp;</option>
                                                    @foreach($stages as $k=>$v)
                                                        <option value="{{$v->id}}" @if($hr->stage_id==$v->id)
                                                            selected @endif>{{$v->stage}}</option>
                                                    @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-4 stage_div_hired" @if($hr->status=='Hired') style="display:block;" @else style="display:none;" @endif>
                                                <div class="form-group">
                                                    <label for="status" class="placeholder"
                                                        style="padding-top:0;margin-top: 22px;">Recruitment Stage</label>
                                                        @php
                                                        $currentStage='';
                                                        @endphp
                                                        @foreach($stages as $k=>$v)
                                                        @if($hr->stage_id==$v->id)
                                                        @php
                                                        $currentStage=$v->stage;
                                                        @endphp
                                                        @endif
                                                        @endforeach

                                                        <input type="text" id="stage_name" name="stage_name" value="{{$currentStage}}">


                                                </div>
                                            </div>
                                            <div class="col-md-4 stage_div_hidden"  @if($hr->status=='') style="display:block;" @else style="display:none;" @endif>
                                                <!-- <input type="hidden" id="stage_id" name="stage_id" value=""> -->
                                            </div>


                                            <div class="col-md-12">
                                                <input type="hidden" id="stage_id" name="stage_id" value="{{$hr->stage_id}}">
                                                <button type="submit" class="btn btn-default btn-up">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <h2>Stage History</h2>
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No.</th>
                                                    <th>Employee Name</th>
                                                    <th>Stage</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $i = 1;?>
                                                @foreach($recruitment_file_emp_history as $company)

                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $company->employee_name }} </td>
                                                    <td>{{ $company->stage_name }} </td>
                                                    <td>{{ date('d/m/Y h:i a',strtotime($company->created_at))  }}</td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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


    function status_change_for_stage(){
        var status = document.getElementById("status").value;
        //alert(status);
        if(status=='Hired'){
            $('.stage_div_select').hide();
            $('.stage_div_hired').show();
            $('.stage_div_hidden').hide();
        }
        else if(status=='Recruitment Ongoing'){
            $('.stage_div_select').show();
            $('.stage_div_hired').hide();
            $('.stage_div_hidden').hide();
        }
        else{
            $('.stage_div_select').hide();
            $('.stage_div_hired').hide();
            $('.stage_div_hidden').show();
        }

    }
    function updateStage(){
        var status = document.getElementById("status").value;
        if(status=='Recruitment Ongoing'){
            $('#stage_id').val($('#stage_select').val());
        }
    }

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
        $('#copy_bill_addr').on('click',function(e){
           // alert($(this).prop('checked'));
            if($(this).prop('checked')){
                $('#correspondense_addr').val($('#employee_address').val());
            }else{
                $('#correspondense_addr').val('');
            }
        });
        
        $('#myForm').on('submit', function(e) {
            e.preventDefault();
            var status = document.getElementById("status").value;
            var candidate_hired_date = document.getElementById("candidate_hired_date").value;

            if(status=='Hired' && candidate_hired_date==''){
                alert('Provide Hiring Date.');
                $("#candidate_hired_date").focus();
            }else{
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