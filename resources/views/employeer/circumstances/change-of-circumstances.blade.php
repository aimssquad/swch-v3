@extends('employeer.include.app')

@section('title', 'Change Of Circumstances List')

@section('content')
@php
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
	function my_simple_crypt( $string, $action = 'encrypt' ) {
		// you may change these values to your own
		$secret_key = 'bopt_saltlake_kolkata_secret_key';
		$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
	
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	
		if( $action == 'encrypt' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	
		return $output;
	}

@endphp

    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Change Of Circumstances List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('organization/circumstances')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"> Change Of Circumstances List</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if($user_type == 'employee')
                    @foreach($sidebarItems as $value)
                    @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                    <a href="{{ url('employee/change-of-circumstances-add-new') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Change Of Circumstances</a>
                    @endif
                    @endforeach
                    @elseif($user_type == 'employer')
                    <a href="{{ url('employee/change-of-circumstances-add-new') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Change Of Circumstances</a>
                    @endif
                    {{-- <div class="view-icons">
                        <a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
                        <a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
                    </div> --}}
                </div>
            </div>
            
        </div>
        
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                     <h4 class="card-title"><i class="far fa-user"></i> Change Of Circumstances List</h4>
                     <div>
                        <!-- Excel Link -->
                        <a href="path_to_excel_export" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </a>
                        
                        <!-- PDF Link -->
                        <a href="path_to_pdf_export" class="btn btn-info btn-sm">
                            <i class="fas fa-file-pdf"></i> Export to PDF
                        </a>
                    </div>
                     @include('layout.message')
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="basic-datatables" class="table table-striped custom-table datatable" >
                           <thead>
                              <th>Updated Date</th>
                              <th>Employment Type</th>
                              <th>Employee ID</th>
                              <th>Name Of Member Of The Staff</th>
                              <th>Job  Title</th>
                              <th>Address</th>
                              <th>Contact Number</th>
                              <th>Nationality</th>
                              <th>BRP  Number</th>
                              <th>Visa Expired</th>
                              <th>Remarks/Restriction to work</th>
                              <th>Passport No</th>
                              <th>EUSS Details</th>
                              <th>DBS Details</th>
                              <th>National Id Details</th>
                              <th>Other Documents</th>
                              <th>Are Sponsored migrants aware that they must <br>inform [HR/line manager] promptly of changes<br> in contact Details? </th>
                              <th>Are Sponsored migrants  aware that they need to<br> cooperate Home Office interview by presenting original<br> passports during the Interview (In applicable cases)?</th>
                              <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($employee_rs as $employee)
                              <?php
                                 $employeet = DB::table('employee')->where('emp_code', '=', $employee->emp_code)->where('emid', '=', $employee->emid)->first();

                                 $employeetemployeeother = DB::table('circumemployee_other_doc')->where('emp_code', '=', $employee->emp_code)->where('emid', '=', $employee->emid)
                                     ->where('cir_id', '=', $employee->id)->orderBy('id', 'DESC')->get();

                                 $dataeotherdoc = '';

                                 if (count($employeetemployeeother) != 0) {

                                     foreach ($employeetemployeeother as $valother) {
                                         if ($valother->doc_exp_date != '1970-01-01') {if ($valother->doc_exp_date != '') {
                                             $other_exp_date = date('d/m/Y', strtotime($valother->doc_exp_date));
                                         } else {
                                             $other_exp_date = '';
                                         }} else {
                                             $other_exp_date = '';
                                         }
                                         $dataeotherdoc .= $valother->doc_name . '( ' . $other_exp_date . ')';
                                     }

                                 }
                                     $euss_exp = '';
                                     if ($employee->euss_exp_date != '1970-01-01') {
                                         if ($employee->euss_exp_date != 'null' && $employee->euss_exp_date != NULL) {
                                             $euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->euss_exp_date));
                                         }
                                     }
                                     $dbs_exp = '';
                                     if ($employee->dbs_exp_date != '1970-01-01') {
                                         if ($employee->dbs_exp_date != 'null' && $employee->dbs_exp_date != NULL) {
                                             $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->dbs_exp_date));
                                         }
                                     }
                                     $nid_exp = '';
                                     if ($employee->nat_exp_date != '1970-01-01') {
                                         if ($employee->nat_exp_date != 'null' && $employee->nat_exp_date != NULL) {
                                             $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->nat_exp_date));
                                         }
                                     }
                                 ?>
                              <tr>
                                 <td>{{ date('d/m/Y',strtotime($employee->date_change)) }}</td>
                                 <td>{{ $employeet->emp_status}}</td>
                                 <td>{{ $employee->emp_code}}</td>
                                 <td>{{ $employeet->emp_fname." ".$employeet->emp_mname." ".$employeet->emp_lname }}</td>
                                 <td>{{ $employee->emp_designation}}</td>
                                 <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
                                    @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif
                                 </td>
                                 <td>{{ $employee->emp_ps_phone }}</td>
                                 <td>{{ $employee->nationality }}</td>
                                 <td>{{ $employee->visa_doc_no }}</td>
                                 <td> @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif  @endif</td>
                                 <td>{{ $employee->res_remark }}</td>
                                 <td>{{ $employee->pass_doc_no }}
                                    ( @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{ date('d/m/Y',strtotime($employee->pass_exp_date)) }} @endif  @endif)
                                 </td>
                                 <td>{{ $employee->euss_ref_no . $euss_exp }}</td>
                                 <td>{{ $employee->dbs_ref_no . $dbs_exp }}</td>
                                 <td>{{ $employee->nat_id_no . $nid_exp }}</td>
                                 <td>{{$dataeotherdoc}}</td>
                                 <td>{{ $employee->hr }}</td>
                                 <td>{{ $employee->home }}</td>
                                 {{-- <td>
                                    <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{url('employee/edit-change-cir/'.base64_encode($employee->id))}}"><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}">
                                 </td> --}}
                                 <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                                        <a class="dropdown-item" href="{{url('employee/edit-change-cir/'.base64_encode($employee->id))}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="{{url('employee/edit-change-cir/'.base64_encode($employee->id))}}">
                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                </a>
                                            @endif
                                            {{-- @if($user_type == 'employee')
                                                @foreach($sidebarItems as $value)
                                                    @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                                    <a class="dropdown-item" href='{{url("user-accessrole/view-users-role/$role->id")}}' onclick="return confirm('Are you sure you want to delete this Access?');"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                    @endif
                                                @endforeach
                                            @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href='{{url("user-accessrole/view-users-role/$role->id")}}' onclick="return confirm('Are you sure you want to delete this Access?');"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                            @endif --}}
                                        </div>
                                    </div>
                                </td>
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
    <!-- /Page Content -->


@endsection
