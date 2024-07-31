@extends('employeer.include.app')

@section('title', 'Home - HRMS admin template')

@section('content')


    <!-- Page Content -->
            <div class="content container-fluid pb-0">
				
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Employee</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Employee</li>
                            </ul>
                        </div>
                        <div class="col-auto float-end ms-auto">
                            <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Job Posting</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
                <!-- Search Filter -->
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">  
                        <div class="input-block mb-3 form-focus">
                            <input type="text" class="form-control floating">
                            <label class="focus-label">Employee ID</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">  
                        <div class="input-block mb-3 form-focus">
                            <input type="text" class="form-control floating">
                            <label class="focus-label">Employee Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3"> 
                        {{-- <div class="input-block mb-3 form-focus select-focus">
                            <select class="select floating"> 
                                <option>Select Designation</option>
                                <option>Web Developer</option>
                                <option>Web Designer</option>
                                <option>Android Developer</option>
                                <option>Ios Developer</option>
                            </select>
                            <label class="focus-label">Designation</label>
                        </div> --}}
                    </div>
                    <div class="col-sm-6 col-md-3">  
                        <a href="#" class="btn btn-success w-100"> Search </a>  
                    </div>     
                </div>
                <!-- /Search Filter -->
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th>SL NO</th>
                                        <th>Job Code</th>
                                        <th>Job Title</th>
                                        <th>Job Link</th>
                                        <th>Vacancy</th>
                                        <th>Job Location</th>
                                        <th>Job Post Date</th>
                                        <th>Closing Date</th>
                                        {{-- <th>Email</th> --}}
                                        {{-- <th>Phone No</th>
                                        <th>Status</th> --}}
                                        <th class="text-end no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php $i = 1; ?>
									@foreach($company_job_rs as $recruitment_job)
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>{{ $recruitment_job->soc }}</td>
                                            <td>{{ $recruitment_job->title }}</td>
                                            <td style="text-align:center" id="myInput">
                                                @if( $recruitment_job->post_date<=date('Y-m-d') && $recruitment_job->clos_date>=date('Y-m-d'))
                                                
                                                <a target="_blank" href="{{ $recruitment_job->job_link }}">
                                                    @endif {{ $recruitment_job->job_link }}</a>
                                                    @if( $recruitment_job->post_date<=date('Y-m-d') && $recruitment_job->clos_date>=date('Y-m-d'))
                                                <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="{{ $recruitment_job->job_link }}" title="Copy Link">
                                                    <!-- icon from google's material design library -->
                                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24"><path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" /></svg>
                                                    </button>  @endif
                                            </td>
                                            <td>{{ $recruitment_job->no_vac }}</td>
                                            <td>{{ $recruitment_job->job_loc }}</td>
                                            <td>{{ date('d/m/Y',strtotime($recruitment_job->post_date)) }}</td>
                                            <td>{{ date('d/m/Y',strtotime($recruitment_job->clos_date)) }}</td>
                                            {{-- <td>{{ $recruitment_job->email }}</td> --}}
                                            {{-- <td>{{ $recruitment_job->con_num }}</td>
                                            <td>{{ $recruitment_job->status }}</td> --}}
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_employee"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
    <!-- /Page Content -->


@endsection
