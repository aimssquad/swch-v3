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
                                <li class="breadcrumb-item"><a href="{{ url('recruitment/dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Employee</li>
                            </ul>
                        </div>
                        <div class="col-auto float-end ms-auto">
                            <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Short Listing</a>
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
                        <div class="card custom-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">
                                    <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;
                                </h4>
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
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table datatable">
                                        <thead>
                                            <tr>
                                                <th>SL NO</th>
                                                <th>Job Code</th>
                                                <th>Job Title</th>
                                                <th>Candidate</th>
                                                <th>Email</th>
                                                <th>Contect Number</th>
                                                <th>Status</th>
                                                <th>Date</th>   
                                                <th class="text-end no-sort">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; ?>
                                            @foreach($candidate_rs as $short_list)
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td>{{ $short_list->job_id }}</td>
                                                <td>{{ $short_list->job_title }}</td>
                                                <td>{{ $short_list->name }}</td>
                                                <td>{{ $short_list->email }}</td>
                                                <td>{{ $short_list->phone }}</td>
                                                <td>{{ $short_list->status }}</td>
                                                <td>{{ \Carbon\Carbon::parse($short_list->date)->format('Y-m-d') }}</td>
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
                </div>
            </div>
    <!-- /Page Content -->


@endsection
