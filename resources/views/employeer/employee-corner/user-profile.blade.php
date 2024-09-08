@extends('employeer.employee-corner.main')
@section('title', 'Employee Corner')
@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    @if(empty($employee->emp_image))
                                    <a href="#"><img src="{{asset('assets/img/user.png')}}" alt="User Image"></a>
                                    @endif
                                    <a href="#"><img src="{{ asset($employee->emp_image) }}" alt="nnn"></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">{{$employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Department:</div>
                                                <div class="text"><a href="#">{{$employee->emp_department}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Designation:</div>
                                                <div class="text"><a href="#">{{$employee->emp_designation}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text"><a href="#">{{$employee->emp_ps_phone}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Employee Code:</div>
                                                <div class="text"><a href="#">{{$employee->emp_code}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <div class="text"><?php echo date("d/m/Y",strtotime($employee->emp_dob)); ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Father Name:</div>
                                                <div class="text">{{$employee->emp_father_name}}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i style="color:#ff902f" class="fa fa-braille"></i> Service Details</h3>
                        <ul class="personal-info">
                            @if($employee->emp_doj!='' && $employee->emp_doj!='1970-01-01')
                                <li>
                                    <div class="title">Date Of Joining :</div>
                                    <div class="text">{{ date('d/m/Y', strtotime($employee->emp_doj)) }}</div>
                                </li>
                            @endif
                            @if($employee->emp_status!='')
                                <li>
                                    <div class="title">Employment Type :</div>
                                    <div class="text">{{$employee->emp_status}}</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i style="color:#ff902f" class="fa fa-bank"></i> Bank Details</h3>
                        <ul class="personal-info">
                            @if(!empty($bank_name))
                                <li>
                                    <div class="title">Bank Name :</div>
                                    <div class="text">{{$bank_name->master_bank_name}}</div>
                                </li>
                            @endif
                            @if($employee->emp_sort_code!='')
                                <li>
                                    <div class="title">Sort Code  :</div>
                                    <div class="text">{{$employee->emp_sort_code}}</div>
                                </li>
                            @endif
                            @if($employee->bank_branch_id!='')
                                <li>
                                    <div class="title">Branch Name :</div>
                                    <div class="text">{{$employee->bank_branch_id}}</div>
                                </li>
                            @endif
                            @if($employee->emp_account_no!='')
                                <li>
                                    <div class="title">A/C No :</div>
                                    <div class="text">{{$employee->emp_account_no}}</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i style="color:#ff902f" class="fa fa-location"></i> Present Address</h3>
                        <ul class="personal-info">
                            @if($employee->emp_pr_street_no!='')
                                <li>
                                    <div class="title">Address Line 1 :</div>
                                    <div class="text">{{$employee->emp_pr_street_no}}</div>
                                </li>
                            @endif
                            @if($employee->emp_per_village!='')
                                <li>
                                    <div class="title">Address Line 2:</div>
                                    <div class="text">{{$employee->emp_per_village}}</div>
                                </li>
                            @endif
                            @if($employee->emp_pr_state!='')
                                <li>
                                    <div class="title">Address Line 3:</div>
                                    <div class="text">{{$employee->emp_pr_state}}</div>
                                </li>
                            @endif
                            @if($employee->emp_pr_city!='')
                                <li>
                                    <div class="title">City / County:</div>
                                    <div class="text">{{$employee->emp_pr_city}}</div>
                                </li>
                            @endif
                            @if($employee->emp_pr_pincode!='')
                                <li>
                                    <div class="title">Post Code:</div>
                                    <div class="text">{{$employee->emp_pr_pincode}}</div>
                                </li>
                            @endif
                            @if($employee->emp_pr_country!='')
                                <li>
                                    <div class="title">Country:</div>
                                    <div class="text">{{$employee->emp_pr_country}}</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i style="color:#ff902f" class="fa fa-users"></i> Authority</h3>
                            <?php
                    	    $user_id = Session::get('users_id');
                            $usersf=DB::table('users')->where('id','=',$user_id)->first();
                                        $employee_re=DB::table('employee')->where('emp_code','=',$employee->emp_reporting_auth)->where('emid','=',$usersf->emid)->first();
                                            if(!empty($employee_re)){
                                                ?>
                                    <p style="margin:0"><b>Reporting Authority:</b> </p>
                                    <?php }
                                    ?>
                                    <span style="margin-bottom:15px">
                                    <?php 
                                    
                                        if(!empty($employee_re)){
                                        echo $employee_re->emp_fname.' '.$employee_re->emp_mname.' '.$employee_re->emp_lname;} ?></span>
                                    <br><br>
                                    
                                        <?php
                                        $employee_sa=DB::table('employee')->where('emp_code','=',$employee->emp_lv_sanc_auth)->where('emid','=',$usersf->emid)->first();
                                            if(!empty($employee_sa)){
                                                ?>
                                    <p style="margin:0"><b>Leave Sanction: Authority: </b></p>
                                        <?php }
                                    ?>
                                    <span><?php $employee_sa=DB::table('employee')->where('emp_code','=',$employee->emp_lv_sanc_auth)->where('emid','=',$usersf->emid)->first();
                                        if(!empty($employee_sa)){
                                        echo $employee_sa->emp_fname.' '.$employee_sa->emp_mname.' '.$employee_sa->emp_lname;}  ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i style="color:#ff902f" class="fa fa-shopping-bag"></i> Pay Details </h3>
                        <ul class="personal-info">
                            @if($employee->emp_group_name!='')
                                @php
                                $job_details=DB::table('grade')->where('id', '=', $employee->emp_group_name )->orderBy('id', 'DESC')->first();
                                @endphp
                                @if(!empty($job_details))
                                    <li>
                                        <div class="title">Pay Level :</div>
                                        <div class="text">{{$job_details->grade_name}}</div>
                                    </li>
                                @endif
                            @endif
                            @if($employee->emp_pay_scale!='')
                                <li>
                                    <div class="title">Basic Pay :</div>
                                    <div class="text">{{$employee->emp_pay_scale}}</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-7 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i style="color:#ff902f" class="fa fa-location"></i> Immigration Details</h3>
                        <ul class="personal-info">
                            @if($employee->ni_no!='')
                                <li>
                                    <div class="title">National ID No :</div>
                                    <div class="text">{{$employee->ni_no}}</div>
                                </li>
                            @endif
                            @if($employee->pass_nat!='')
                                <li>
                                    <div class="title">Nationality :</div>
                                    <div class="text">{{$employee->pass_nat}}</div>
                                </li>
                            @endif
                            @if($employee->pass_doc_no!='')
                                <li>
                                    <div class="title">Passport No :</div>
                                    <div class="text">{{$employee->pass_doc_no}}</div>
                                </li>
                            @endif
                            @if($employee->pas_iss_date!='' && $employee->pas_iss_date!='1970-01-01')
                                <li>
                                    <div class="title">Passport Issued Date :</div>
                                    <div class="text">{{ date('d/m/Y', strtotime($employee->pas_iss_date)) }}</div>
                                </li>
                            @endif
                            @if($employee->pass_exp_date!='' && $employee->pass_exp_date!='1970-01-01')
                                <li>
                                    <div class="title">Passport Expiry Date :</div>
                                    <div class="text">{{ date('d/m/Y', strtotime($employee->pass_exp_date)) }}</div>
                                </li>
                            @endif
                            @if($employee->issue_by!='')
                                <li>
                                    <div class="title">Passport  Issued By :</div>
                                    <div class="text">{{$employee->issue_by}}</div>
                                </li>
                            @endif 
                            @if($employee->pass_review_date!='' && $employee->pass_review_date!='1970-01-01')
                                <li>
                                    <div class="title">Passport Eligible Review Date :</div>
                                    <div class="text">{{ date('d/m/Y', strtotime($employee->pass_review_date)) }}</div>
                                </li>
                            @endif
                            @if($employee->visa_doc_no!='')
                                <li>
                                    <div class="title">BRP No :</div>
                                    <div class="text">{{$employee->visa_doc_no}}</div>
                                </li>
                            @endif
                            @if($employee->visa_issue_date!='' && $employee->visa_issue_date!='1970-01-01')
                                <li>
                                    <div class="title">Visa  Issued Date :</div>
                                    <div class="text">{{ date('d/m/Y', strtotime($employee->visa_issue_date)) }}</div>
                                </li>
                            @endif
                            @if($employee->visa_exp_date!='' && $employee->visa_exp_date!='1970-01-01')
                                <li>
                                    <div class="title">Visa  Expiry Date :</div>
                                    <div class="text">{{ date('d/m/Y', strtotime($employee->visa_exp_date)) }}</div>
                                </li>
                            @endif
                            @if($employee->visa_issue!='')
                                <li>
                                    <div class="title">Visa   Issued By :</div>
                                    <div class="text">{{$employee->visa_issue}}</div>
                                </li>
                            @endif
                            @if($employee->visa_review_date!='' && $employee->visa_review_date!='1970-01-01')
                                <li>
                                    <div class="title">Visa  Eligible Review Date :</div>
                                    <div class="text">{{ date('d/m/Y', strtotime($employee->visa_review_date)) }}</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @if(!empty($module_name))
                <div class="col-md-5 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title"><i style="color:#ff902f" class="fa fa-user-secret"></i> Role</h3>
                            {{$module_name}}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>    
@endsection