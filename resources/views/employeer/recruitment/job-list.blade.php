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
                            <a href="{{ url('recruitment/add-job-list') }}" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Job List</a>
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
                        <div class="input-block mb-3 form-focus select-focus">
                            <select class="select floating"> 
                                <option>Select Designation</option>
                                <option>Web Developer</option>
                                <option>Web Designer</option>
                                <option>Android Developer</option>
                                <option>Ios Developer</option>
                            </select>
                            <label class="focus-label">Designation</label>
                        </div>
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
                                        <th class="text-end no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
									@foreach($recruitment_job_rs as $recruitment_job)
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>{{ $recruitment_job->soc }}</td>
											<td>{{ $recruitment_job->title }}</td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{url('recruitment/add-job-list/')}}?id={{$recruitment_job->id}}" data-bs-toggle="modal" data-bs-target="#edit_employee"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
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
    		<!-- Add Employee Modal -->
            <div id="add_employee" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Job List</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Select Job Type</label>
                                            <select class="select">
                                                <option value="">Global Technologies</option>
                                                <option value="1">Delta Infotech</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Job Code <span class="text-danger">*</span></label>
                                            <select class="select">
                                                <option>Select Department</option>
                                                <option>Web Development</option>
                                                <option>IT Management</option>
                                                <option>Marketing</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Department </label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Job Title </label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Job Descriptions </label>
                                            <textarea class="form-control" rows="3"></textarea>
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
            <!-- /Add Employee Modal -->
            
            <!-- Edit Employee Modal -->
            <div id="edit_employee" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                            <input class="form-control" value="John" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Last Name</label>
                                            <input class="form-control" value="Doe" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Username <span class="text-danger">*</span></label>
                                            <input class="form-control" value="johndoe" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                            <input class="form-control" value="johndoe@example.com" type="email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Password</label>
                                            <input class="form-control" value="johndoe" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Confirm Password</label>
                                            <input class="form-control" value="johndoe" type="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                            <input type="text" value="FT-0001" readonly class="form-control floating">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">  
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                            <div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Phone </label>
                                            <input class="form-control" value="9876543210" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-block mb-3">
                                            <label class="col-form-label">Company</label>
                                            <select class="select">
                                                <option>Global Technologies</option>
                                                <option>Delta Infotech</option>
                                                <option selected>International Software Inc</option>
                                            </select>
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
                                </div>
                                <div class="table-responsive m-t-15">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th>Module Permission</th>
                                                <th class="text-center">Read</th>
                                                <th class="text-center">Write</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">Import</th>
                                                <th class="text-center">Export</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Holidays</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Leaves</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Clients</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Projects</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tasks</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Chats</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Assets</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Timing Sheets</td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" checked>													
                                                        <span class="checkmark"></span>
                                                </label>																			
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label class="custom_check">
                                                        <input type="checkbox" name="rememberme" class="rememberme">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Edit Employee Modal -->
            
            <!-- Delete Employee Modal -->
            <div class="modal custom-modal fade" id="delete_employee" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Delete Employee</h3>
                                <p>Are you sure want to delete?</p>
                            </div>
                            <div class="modal-btn delete-action">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Delete Employee Modal -->


@endsection
