@extends('employeer.include.app')

@section('title', 'Organization Profile')

@section('content')

<!-- Page Content -->
<div class="content container-fluid pb-0">
				
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Organization Profile</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    @if(Session::has('message'))										
        <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
    @endif
    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img src="{{ asset('storage/' . $companies_rs->logo) }}" alt="User Image"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{ ucfirst($companies_rs->com_name) }}</h3>
                                        <h6 class="text">Status - <span class="badge bg-inverse-success"> {{ ucfirst($companies_rs->status) }}</span></h6>
                                        <h6 class="text">{{ ucfirst($companies_rs->f_name ?? '') }} {{ ucfirst($companies_rs->l_name ?? '') }}</h6>
                                        <div class="staff-id">Orgnaization ID : {{ $companies_rs->reg }}</div>
                                        <div class="staff-id">Registration No : {{ $companies_rs->reg }}</div>
                                        <div class="staff-id">Type of Organisation : {{ $companies_rs->reg }}</div>
                                        <div class="staff-id">Name of Sector : {{ $companies_rs->reg }}</div>
                                        <div class="staff-id">Trading Name : {{ $companies_rs->reg }}</div>
                                        <div class="staff-id">Trading Period : {{ $companies_rs->reg }}</div>
                                        <div class="small doj">Date of Create : {{ \Carbon\Carbon::parse($companies_rs->created_at)->format('j M Y') }}</div>
                                        <div class="staff-msg">
                                            <a class="btn btn-custom" href="{{url('org-company-profile/pdf')}}?c_id={{base64_encode($companies_rs->id)}}">Download PDF</a>
                                            <a class="btn btn-success" href="{{url('org-company-profile/edit-company')}}?c_id={{base64_encode($companies_rs->id)}}"><i class="fa-solid fa-pencil"></i>Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Phone:</div>
                                            <div class="text"><a href="#">{{ $companies_rs->p_no ?? '' }}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Organization Email ID:</div>
                                            <div class="text"><a href="#">{{ $Roledata->organ_email ?? '' }}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Login Email ID:</div>
                                            <div class="text"><a href="#">{{ $companies_rs->email ?? '' }}</a></div>
                                        </li>
                                        
                                        <li>
                                            <div class="title">Password:</div>
                                            <div class="text">{{ $companies_rs->pass ?? '' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Address:</div>
                                            <div class="text">{{ $companies_rs->address ?? '' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Fax:</div>
                                            <div class="text">{{ $companies_rs->fax ?? '' }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Website:</div>
                                            <div class="text"><a href="{{ $companies_rs->website ?? '' }}" target="_blank">{{ $companies_rs->website ?? '' }}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Landline:</div>
                                            <div class="text"><a href="{{ $companies_rs->website ?? '' }}" target="_blank">{{ $companies_rs->website ?? '' }}</a></div>
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
    
    <div class="card tab-box">
        <div class="row user-tabs">
            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a href="#emp_profile" data-bs-toggle="tab" class="nav-link active">Profile</a></li>
                    <li class="nav-item"><a href="#bank_statutory" data-bs-toggle="tab" class="nav-link">Trading Hours</a></li>
                    <li class="nav-item"><a href="#emp_assets" data-bs-toggle="tab" class="nav-link">Organisation Employee (According to latest RTI)</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="tab-content">
    
        <!-- Profile Info Tab -->
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Authorised Person Details </h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">Name.</div>
                                    <div class="text">{{ ucfirst($companies_rs->f_name ?? '') }} {{ ucfirst($companies_rs->l_name ?? '') }}</div>
                                </li>
                                <li>
                                    <div class="title">Designation.</div>
                                    <div class="text">{{ !empty($companies_rs->desig) ? $companies_rs->desig : 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Phone No.</div>
                                    <div class="text"><a href="#">{{ !empty($companies_rs->con_num) ? $companies_rs->con_num : 'N/A' }}</a></div>
                                </li>
                                <li>
                                    <div class="title">Email Id.</div>
                                    <div class="text">{{ !empty($companies_rs->authemail) ? $companies_rs->authemail : 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Do you have a history of Criminal conviction/Bankruptcy?</div>
                                    <div class="text">{{$companies_rs->bank_status}}</div>
                                </li>
                                <li>
                                    <div class="title">Proof Of Id</div>
                                    <div class="text"><a href="{{ asset('storage/' . $companies_rs->level_proof) }}" target="_blank"><img src="{{ asset('storage/' . $companies_rs->level_proof) }}" height="50px" width="50px"/></a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Key Contact </h3>
                            <ul class="personal-info">
                                <li>
                                    <div class="title">Name</div>
                                    <div class="text">{{ ucfirst($companies_rs->key_f_name ?? '') }} {{ ucfirst($companies_rs->key_f_name ?? '') }}</div>
                                </li>
                                <li>
                                    <div class="title">Designation.</div>
                                    <div class="text">{{ !empty($companies_rs->key_designation) ? $companies_rs->key_designation : 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Phone No.</div>
                                    <div class="text"><a href="#">{{ !empty($companies_rs->key_phone) ? $companies_rs->key_phone : 'N/A' }}</a></div>
                                </li>
                                <li>
                                    <div class="title">Email Id.</div>
                                    <div class="text">{{ !empty($companies_rs->key_email) ? $companies_rs->key_email : 'N/A' }}</div>
                                </li>
                                <li>
                                    <div class="title">Do you have a history of Criminal conviction/Bankruptcy?</div>
                                    <div class="text">{{$companies_rs->key_bank_status}}</div>
                                </li>
                                <li>
                                    <div class="title">Proof Of Id</div>
                                    <div class="text"><a href="{{ asset('storage/' . $companies_rs->key_proof) }}" target="_blank"><img src="{{ asset('storage/' . $companies_rs->key_proof) }}" height="50px" width="50px"/></a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Level 1 User </h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Designation </th>
                                            <th>Phone No</th>
                                            <th>Email Id</th>
                                            <th>Do you have a history of Criminal conviction/Bankruptcy?</th>
                                            <th>Proof Of Id</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ !empty($companies_rs->level_f_name) ? $companies_rs->level_f_name : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level_designation) ? $companies_rs->level_designation : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level_phone) ? $companies_rs->level_phone : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level_email) ? $companies_rs->level_email : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level_bank_status) ? $companies_rs->level_bank_status : 'N/A' }}</td>
                                            <td>    
                                                @if (!empty($companies_rs->level_proof))
                                                    <a href="{{ asset('storage/' . $companies_rs->level_proof) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $companies_rs->level_proof) }}" height="50px" width="50px"/>
                                                    </a>
                                                @else
                                                    No Proof Available
                                                @endif    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Level 2 User </h3>
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Designation </th>
                                            <th>Phone No</th>
                                            <th>Email Id</th>
                                            <th>Do you have a history of Criminal conviction/Bankruptcy?</th>
                                            <th>Proof Of Id</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ !empty($companies_rs->level2_f_name) ? $companies_rs->level2_f_name : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level2_designation) ? $companies_rs->level2_designation : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level2_phone) ? $companies_rs->level2_phone : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level2_email) ? $companies_rs->level2_email : 'N/A' }}</td>
                                            <td>{{ !empty($companies_rs->level2_bank_status) ? $companies_rs->level2_bank_status : 'N/A' }}</td>
                                            <td>	
                                                @if (!empty($companies_rs->level2_proof))
                                                    <a href="{{ asset('storage/' . $companies_rs->level2_proof) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $companies_rs->level2_proof) }}" height="50px" width="50px"/>
                                                    </a>
                                                @else
                                                    No Proof Available
                                                @endif	
                                            </td>                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Info Tab -->
        
        
        <!-- Bank Statutory Tab -->
        <div class="tab-pane fade" id="bank_statutory">
            <div class="table-responsive table-newdatatable">
                <table class="table table-new custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Asset ID</th>
                            <th>Assigned Date</th>
                            <th>Assignee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="assets-details.html" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 001</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage">
                                    <img src="assets/img/profiles/avatar-02.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>John Paul Raj</span>
                                    <p>john@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <a href="assets-details.html" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 002</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage" data-bs-toggle="modal" data-bs-target="#edit-asset">
                                    <img src="assets/img/profiles/avatar-05.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>Vinod Selvaraj</span>
                                    <p>vinod.s@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <a href="assets-details.html" class="table-imgname">
                                    <img src="assets/img/keyboard.png" class="me-2" alt="Keyboard Image">
                                    <span>Dell Keyboard</span>
                                </a>
                            </td>
                            <td>AST - 003</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage" data-bs-toggle="modal" data-bs-target="#edit-asset">
                                    <img src="assets/img/profiles/avatar-03.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>Harika </span>
                                    <p>harika.v@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>
                                <a href="#" class="table-imgname">
                                    <img src="assets/img/mouse.png" class="me-2" alt="Mouse Image">
                                    <span>Logitech Mouse</span>
                                </a>
                            </td>
                            <td>AST - 0024</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="assets-details.html" class="table-profileimage" >
                                    <img src="assets/img/profiles/avatar-02.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="assets-details.html" class="table-name">
                                    <span>Mythili</span>
                                    <p>mythili@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>
                                <a href="#" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 005</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="assets-details.html" class="table-profileimage" >
                                    <img src="assets/img/profiles/avatar-02.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="assets-details.html" class="table-name">
                                    <span>John Paul Raj</span>
                                    <p>john@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>
                                <a href="#" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 006</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage" >
                                    <img src="assets/img/profiles/avatar-05.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>Vinod Selvaraj</span>
                                    <p>vinod.s@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /Bank Statutory Tab -->
        
        <!-- Assets -->
        <div class="tab-pane fade" id="emp_assets">
            <div class="table-responsive table-newdatatable">
                <table class="table table-new custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Asset ID</th>
                            <th>Assigned Date</th>
                            <th>Assignee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="assets-details.html" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 001</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage">
                                    <img src="assets/img/profiles/avatar-02.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>John Paul Raj</span>
                                    <p>john@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <a href="assets-details.html" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 002</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage" data-bs-toggle="modal" data-bs-target="#edit-asset">
                                    <img src="assets/img/profiles/avatar-05.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>Vinod Selvaraj</span>
                                    <p>vinod.s@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <a href="assets-details.html" class="table-imgname">
                                    <img src="assets/img/keyboard.png" class="me-2" alt="Keyboard Image">
                                    <span>Dell Keyboard</span>
                                </a>
                            </td>
                            <td>AST - 003</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage" data-bs-toggle="modal" data-bs-target="#edit-asset">
                                    <img src="assets/img/profiles/avatar-03.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>Harika </span>
                                    <p>harika.v@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>
                                <a href="#" class="table-imgname">
                                    <img src="assets/img/mouse.png" class="me-2" alt="Mouse Image">
                                    <span>Logitech Mouse</span>
                                </a>
                            </td>
                            <td>AST - 0024</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="assets-details.html" class="table-profileimage" >
                                    <img src="assets/img/profiles/avatar-02.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="assets-details.html" class="table-name">
                                    <span>Mythili</span>
                                    <p>mythili@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>
                                <a href="#" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 005</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="assets-details.html" class="table-profileimage" >
                                    <img src="assets/img/profiles/avatar-02.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="assets-details.html" class="table-name">
                                    <span>John Paul Raj</span>
                                    <p>john@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>
                                <a href="#" class="table-imgname">
                                    <img src="assets/img/laptop.png" class="me-2" alt="Laptop Image">
                                    <span>Laptop</span>
                                </a>
                            </td>
                            <td>AST - 006</td>
                            <td>22 Nov, 2022    10:32AM</td>
                            <td class="table-namesplit">
                                <a href="javascript:void(0);" class="table-profileimage" >
                                    <img src="assets/img/profiles/avatar-05.jpg" class="me-2" alt="User Image">
                                </a>
                                <a href="javascript:void(0);" class="table-name">
                                    <span>Vinod Selvaraj</span>
                                    <p>vinod.s@dreamguystech.com</p>
                                </a>
                            </td>
                            <td>
                                <div class="table-actions d-flex">
                                    <a class="delete-table me-2" href="user-asset-details.html">
                                       <img src="assets/img/icons/eye.svg" alt="Eye Icon">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /Assets -->
        
    </div>
</div>
<!-- /Page Content -->

<!-- Profile Modal -->
<div id="profile_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-img-wrap edit-img">
                                <img class="inline-block" src="{{ asset('frontend/assets/img/profiles/avatar-02.jpg')}}" alt="User Image">
                                <div class="fileupload btn">
                                    <span class="btn-text">edit</span>
                                    <input class="upload" type="file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">First Name</label>
                                        <input type="text" class="form-control" value="John">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Last Name</label>
                                        <input type="text" class="form-control" value="Doe">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Birth Date</label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" value="05/06/1985">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Gender</label>
                                        <select class="select form-control">
                                            <option value="male selected">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Address</label>
                                <input type="text" class="form-control" value="4487 Snowbird Lane">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">State</label>
                                <input type="text" class="form-control" value="New York">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Country</label>
                                <input type="text" class="form-control" value="United States">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Pin Code</label>
                                <input type="text" class="form-control" value="10523">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Phone Number</label>
                                <input type="text" class="form-control" value="631-889-3206">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Department <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>Select Department</option>
                                    <option>Web Development</option>
                                    <option>IT Management</option>
                                    <option>Marketing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>Select Designation</option>
                                    <option>Web Designer</option>
                                    <option>Web Developer</option>
                                    <option>Android Developer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Reports To <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>-</option>
                                    <option>Wilmer Deluna</option>
                                    <option>Lesley Grauer</option>
                                    <option>Jeffery Lalor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Profile Modal -->

<!-- Personal Info Modal -->
<div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Passport No</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Passport Expiry Date</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Tel</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Nationality <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Religion</label>
                                <div class="cal-icon">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Marital status <span class="text-danger">*</span></label>
                                <select class="select form-control">
                                    <option>-</option>
                                    <option>Single</option>
                                    <option>Married</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">Employment of spouse</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-block mb-3">
                                <label class="col-form-label">No. of children </label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Personal Info Modal -->

<!-- Family Info Modal -->
<div id="family_info_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Family Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-scroll">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Family Member <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Date of birth <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Date of birth <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-plus-circle"></i> Add More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Family Info Modal -->

<!-- Emergency Contact Modal -->
<div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Primary Contact</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone 2</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Primary Contact</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Relationship <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Phone 2</label>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Emergency Contact Modal -->

<!-- Education Modal -->
<div id="education_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Education Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-scroll">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Oxford University" class="form-control floating">
                                            <label class="focus-label">Institution</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Computer Science" class="form-control floating">
                                            <label class="focus-label">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Starting Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Complete Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="BE Computer Science" class="form-control floating">
                                            <label class="focus-label">Degree</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Grade A" class="form-control floating">
                                            <label class="focus-label">Grade</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Oxford University" class="form-control floating">
                                            <label class="focus-label">Institution</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Computer Science" class="form-control floating">
                                            <label class="focus-label">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="01/06/2002" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Starting Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <div class="cal-icon">
                                                <input type="text" value="31/05/2006" class="form-control floating datetimepicker">
                                            </div>
                                            <label class="focus-label">Complete Date</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="BE Computer Science" class="form-control floating">
                                            <label class="focus-label">Degree</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus focused">
                                            <input type="text" value="Grade A" class="form-control floating">
                                            <label class="focus-label">Grade</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-plus-circle"></i> Add More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Education Modal -->

<!-- Experience Modal -->
<div id="experience_info" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Experience Informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-scroll">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                            <label class="focus-label">Company Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="United States">
                                            <label class="focus-label">Location</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Web Developer">
                                            <label class="focus-label">Job Position</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                            </div>
                                            <label class="focus-label">Period From</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                            </div>
                                            <label class="focus-label">Period To</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa-regular fa-trash-can"></i></a></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Digital Devlopment Inc">
                                            <label class="focus-label">Company Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="United States">
                                            <label class="focus-label">Location</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <input type="text" class="form-control floating" value="Web Developer">
                                            <label class="focus-label">Job Position</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="01/07/2007">
                                            </div>
                                            <label class="focus-label">Period From</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3 form-focus">
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="08/06/2018">
                                            </div>
                                            <label class="focus-label">Period To</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="javascript:void(0);"><i class="fa-solid fa-plus-circle"></i> Add More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Experience Modal -->


@endsection