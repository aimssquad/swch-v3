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
                                    <a href="#"><img src="{{ asset('storage/'.$employee->emp_image) }}" alt="nnn"></a>
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
                        <h3 class="card-title"><i class="fa fa-bank"></i> Service Details</h3>
                        <?php  if($employee->emp_doj!='' && $employee->emp_doj!='1970-01-01'){ 
                            ?>
                        <p>Date Of Joining : </p>
                        <?php  }?>
                        <?php  if($employee->emp_status!='' ){ 
                                ?>
                        <p>Employment Type : </p>
                         <?php  }?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i class="fa fa-bank"></i> Bank Details</h3>
                        <ul class="personal-info">
                           
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-7 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i class="fa fa-location"></i> Present Address</h3>
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
            <div class="col-md-5 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i class="fa fa-users"></i> Authority</h3>
                        <ul class="personal-info">
                           
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-7 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i class="fa fa-location"></i> Immigration Details</h3>
                        <ul class="personal-info">
                           
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex">
                <div class="card profile-box flex-fill">
                    <div class="card-body">
                        <h3 class="card-title"><i class="fa fa-role"></i> Role</h3>
                        <ul class="personal-info">
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection