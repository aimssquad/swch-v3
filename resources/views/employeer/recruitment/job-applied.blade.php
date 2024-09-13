@extends('employeer.include.app')

@section('title', 'Home - HRMS admin template')

@section('content')


    <!-- Page Content -->
            <div class="content container-fluid pb-0">
				
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Job Applied</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('recruitment/dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Job Applied</li>
                            </ul>
                        </div>
                        {{-- <div class="col-auto float-end ms-auto">
                            <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Job Applied</a>
                        </div> --}}
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="row">
                    <div class="col-md-12">
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
                                    <?php $i = 1; ?>
                                    @foreach($candidate_rs as $applied_job)                               
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>{{ $applied_job->job_id }}</td>
                                        <td>{{ $applied_job->job_title }}</td>
                                        <td>{{ $applied_job->name }}</td>
                                        <td>{{ $applied_job->email }}</td>
                                        <td>{{ $applied_job->phone }}</td>
                                        <td>{{ $applied_job->status }}</td>
                                        <td>{{ \Carbon\Carbon::parse($applied_job->date)->format('Y-m-d') }}</td>
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
