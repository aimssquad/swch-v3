
@extends('employeer.include.app')

@section('title', 'Day Off')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
@php
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
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Day Off</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('rota-org/dashboard')}}">Rota Dashboard</a></li>
					<li class="breadcrumb-item active">Day Off</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems as $value)
				@if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 48)
				<a href="{{url('rota-org/add-offday')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Day Off</a>
				@endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{url('rota-org/add-offday')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Day Off</a>
				@endif
				{{-- <div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div> --}}
			</div>
		</div>
	</div>
    @include('employeer.layout.message')
	<!-- /Page Header -->
	<div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Day Off
                    </h4>
                    <div class="row">
                       <div class="col-auto">
                           <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                               @csrf
                               <input type="hidden" name="data" id="data">
                               <input type="hidden" name="headings" id="headings">
                               <input type="hidden" name="filename" id="filename">
                               {{-- put the value - that is your file name --}}
                               <input type="hidden" id="filenameInput" value="Day-Off">
                               <button type="submit" class="btn btn-success btn-sm">
                                   <i class="fas fa-file-excel"></i> Export to Excel
                               </button>
                           </form>
                       </div>
                       <div class="col-auto">
                           <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                             @csrf
                             <input type="hidden" name="data" id="pdfData">
                             <input type="hidden" name="headings" id="pdfHeadings">
                             <input type="hidden" name="filename" id="pdfFilename">
                             <button type="submit" class="btn btn-info btn-sm">
                                 <i class="fas fa-file-pdf"></i> Export to PDF
                             </button>
                         </form>
                       </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Shift Name</th>
                                    <th>Sunday</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($employee_type_rs as $candidate)
                                @php
                                //dd($candidate);
                                     $employee_desigrs=DB::table('designation')
                                         ->where('id', '=',  $candidate->designation)
                                          ->first();

                                       $employee_depers=DB::table('department')
                                         ->where('id', '=',  $candidate->department)
                                          ->first();
                                    if($candidate->shift_code !=''){
                                       $employee_shift=DB::table('shift_management')
                                         ->where('shift_management.id', '=',  $candidate->shift_code)
                                        ->first();
                                    
                                    }else{
                                        $employee_shift=[];
                                    }

                                    $duty_roaster=DB::table('duty_roster')->where('emid', '=',
                                            $Roledata->reg)->where('shift_code', '=',
                                            $candidate->shift_code)->get();
                                        
                                    
                                @endphp
                                    <tr>
                                        
                                        <td>{{ $employee_depers->department_name }}</td>
                                        <td>{{ $employee_desigrs->designation_name }}</td>
                                    <td> @if(!empty($employee_shift)) {!! $employee_shift->shift_code !!} ( {{ $employee_shift->shift_des }}  ) @endif</td>
                                            
                                        <td>@if($candidate->sun=='1' )
                                         <i class="fas fa-times check-clr dayoff-danger" ></i>
                                                
                                              @else
                                                   <i class="fas fa-check check-clr dayoff-success" ></i>
                                                @endif	</td>
                                        
                                        <td>@if($candidate->mon=='1' )
                                                 <i class="fas fa-times check-clr dayoff-danger" ></i>
                                              @else
                                                <i class="fas fa-check check-clr dayoff-success" ></i>
                                                 
                                                @endif	</td>
                                                <td>@if($candidate->tue=='1' )
                                                  <i class="fas fa-times check-clr dayoff-danger" ></i> 
                                              @else
                                              <i class="fas fa-check check-clr dayoff-success" ></i>
                                                 
                                                @endif	</td>
                                                <td>@if($candidate->wed=='1' )
                                                 <i class="fas fa-times check-clr dayoff-danger" ></i>
                                                 
                                              @else
                                                  <i class="fas fa-check check-clr dayoff-success" ></i>
                                                @endif	</td>
                                                <td>@if($candidate->thu=='1' )
                                                 <i class="fas fa-times check-clr dayoff-danger" ></i>
                                                 
                                              @else
                                               <i class="fas fa-check check-clr dayoff-success" ></i>
                                                 
                                                @endif	</td>
                                                <td>@if($candidate->fri=='1' )
                                                 <i class="fas fa-times check-clr dayoff-danger"></i>
                                                
                                              @else
                                                   <i class="fas fa-check check-clr dayoff-success"></i>
                                                @endif	</td>
                                                <td>@if($candidate->sat=='1' )
                                                 <i class="fas fa-times check-clr dayoff-danger"></i>
                                                 
                                              @else
                                                  <i class="fas fa-check check-clr dayoff-success"></i>
                                                @endif	</td>
                                    <td class="text-end">
                                        {{-- @if(count($duty_roaster)==0) --}}
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            
                                            <div class="dropdown-menu dropdown-menu-right">
                                                
                                                    @if($user_type == 'employee')
                                                        @foreach($sidebarItems as $value)
                                                            @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                                                
                                                                    <a class="dropdown-item" href="{{url('rota/add-offday/')}}?id={{$candidate->id}}">
                                                                        <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                                    </a>
                                                                
                                                            @endif
                                                        @endforeach
                                                    @elseif($user_type == 'employer')
                                                            <a class="dropdown-item" href="{{url('rota/add-offday/')}}?id={{$candidate->id}}">
                                                                <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                            </a>
                                                    @endif

                                                    
                                                
                        
                                                {{-- @if($user_type == 'employee')
                                                    @foreach($sidebarItems as $value)
                                                        @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                                        <a class="dropdown-item" href="#" onclick="confirmDelete('{{ url('rota-org/delete-shift-management/' . $candidate->id) }}')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                        @endif
                                                    @endforeach
                                                @elseif($user_type == 'employer')
                                                <a class="dropdown-item" href="#" onclick="confirmDelete('{{ url('rota-org/delete-shift-management/' . $candidate->id) }}')"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                @endif --}}
                                            </div>
                                            
                                        </div>
                                        {{-- @endif --}}
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

@section('script')
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
    </script>

@endsection
