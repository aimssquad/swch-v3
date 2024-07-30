@extends('taskmanagement.layouts.master')

@section('title')
SWCH
@endsection

@section('sidebar')
@include('taskmanagement.partials.sidebar-project')
@endsection

@section('header')
@include('taskmanagement.partials.header')
@endsection

@section('content')
<?php

use App\Models\TaskManagement\ProjectMembers;
use App\Models\User; ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,1,0" />

<!-- Content -->
<div class="modal fade create_task_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="create_task_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content p-4">
            <button type="button" class="close close_popup" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <section>
                <form method="POST" id="frm_task_create">
                    <div class="container position-relative">
                        <div id="message"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 id="frm_title">Create issue</h4>
                                <div class="d-flex flex-row-reverse position-absolute create_task_new">
                                    <div class="p-2"></div>
                                    <!-- <div class="p-2"><span class="badge rounded-pill text-bg-light p-2 ps-3 pe-3">Import
                                        Issues</span> </div>
                                <div class="p-2"><span class="material-symbols-outlined float-start">
                                        visibility
                                    </span> 1</div> -->
                                </div>
                                <div class="col-sm-12">
                                    <div>
                                        <label>Task <span class="text-danger">*</span></label>
                                        <!-- <select class="form-select  mt-2 mb-4" aria-label="Default select example">
                                        <option selected>Project Name 1</option>
                                        <option value="1">Project Name 2</option>
                                        <option value="2">Project Name 3</option>
                                        <option value="3">Project Name 4</option>
                                    </select> -->
                                        <input type="text" class="form-control" name="task_name" id="task_name" />
                                    </div>
                                    <!-- <div>
                                    <label>Issue Type <span class="text-danger">*</span></label>
                                    <select class="form-select  mt-2" aria-label="Default select example">
                                        <option selected>Issue Type 1</option>
                                        <option value="1">Issue Type 2</option>
                                        <option value="2">Issue Type 3</option>
                                        <option value="3">Issue Type 4</option>
                                    </select>
                                    <small class="d-block"><a href="#" class="text-primary text-decoration-none"> Learn More
                                        </a></small>
                                </div> -->

                                </div>
                                <div class="col-sm-12">
                                    <div class="row mt-3">
                                        <div class="col-sm-2">
                                            Start Date
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control form-control-sm" name="start_date" id="start_date" min={{date('Y-m-d',strtotime("+1 day"))}} />
                                        </div>
                                        <div class="col-sm-2">
                                            End Date
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control form-control-sm" name="expected_end_date" id="expected_end_date" min={{date('Y-m-d',strtotime("+1 day"))}} />
                                        </div>

                                    </div>
                                    <div>
                                        <label>Assign to</label>
                                        <select class="form-select  mt-2" aria-label="Default select example" name="assignedTo" id="assignedTo">
                                            <option selected disabled>Unassigned</option>
                                            @foreach($members as $m)
                                            <option value="{{$m->user_id}}">{{$m->fname}} {{$m->mname}} {{$m->lname}}</option>
                                            @endforeach

                                        </select>
                                        <!-- <small class="d-block"><a href="#" class="text-primary text-decoration-none"> Learn More
                                        </a></small> -->
                                    </div>
                                    <hr class="mt-4 mb-4">

                                    <label>Status <span class="material-symbols-outlined float-start me-1">
                                            schedule
                                        </span></label>
                                    <div id="demo2" class="mt-1">
                                        <div class="wrapper2">
                                            <div class="content2">
                                                <ul>
                                                    @foreach($labels as $l)
                                                    <a href="javascript:void(0);" onclick="setLebels('{{$l->title}}','create')">
                                                        <li><span class="bg-secondary text-white p-1 ps-2 pe-2"><?php



                                                                                                                echo $l->title; ?></span></li>
                                                    </a>
                                                    @endforeach
                                                    <!-- <a href="#">
                                                        <li><span class="bg-secondary text-white p-1 ps-2 pe-2">To Do</span>
                                                        </li>
                                                    </a>
                                                    <a href="#">
                                                        <li><span class="bg-info text-white p-1 ps-2 pe-2">Ready to test</span>
                                                        </li>
                                                    </a>
                                                    <a href="#">
                                                        <li><span class="bg-info text-white p-1 ps-2 pe-2">In Progress</span>
                                                        </li>
                                                    </a>
                                                    <a href="#">
                                                        <li>Resolved</li>
                                                    </a> -->
                                                </ul>
                                            </div>
                                            <div class="parent bg-success text-white" id="task_create_status_display"><?php echo count($labels) > 0 ? $labels[0]->title : ''; ?></div>
                                            <input type="hidden" id="task_create_status" name="status" value="{{count($labels)>0? $labels[0]->title:''}}" />
                                            <input type="hidden" id="task_id" name="task_id" />
                                        </div>

                                    </div>
                                    <p class="mt-1 mb-3">This is the issue's initial status upon creation</p>


                                    <label>Summary <span class="text-danger">*</span></label>
                                    <textarea type="text" placeholder="" class="form-control form-control-sm mt-1" name="task_desc" id="task_desc"></textarea>
                                    <input type="hidden" name="project_id" value="{{decrypt(request()->route('id'))}}" />
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="d-flex">
                                        <div class="p-2 flex-grow-1">
                                            <!-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Create another issue
                                            </label>
                                        </div> -->
                                        </div>
                                        <div class="p-2">
                                            <button type="button" class="btn btn-info danger" data-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="p-2"> <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </section>
        </div>
    </div>
</div>
<div class="modal fade details_task_modal" id="details_task_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <button type="button" class="close close_popup" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="task_left">
                                <h2 id="edit_task_title"></h2>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <p class="mt-1">Due date</p>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="bg-light d-block p-2" id="edit_task_due_date">Light</div>
                                        <!-- <input class="form-control form-control-sm" type="date" placeholder="None" /> -->
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <h6>Description</h6>
                                    <div class="bg-light d-block p-2" id="edit_task_desc">Implementation Home page</div>
                                </div>
                                <div class="mt-4">
                                    <h6>Activity</h6>
                                    <div>
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active bg-secondary" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Comments</button>
                                            </li>
                                            <!-- <li class="nav-item" role="presentation">
										<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
											data-bs-target="#pills-profile" type="button" role="tab"
											aria-controls="pills-profile" aria-selected="false">Profile</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
											data-bs-target="#pills-contact" type="button" role="tab"
											aria-controls="pills-contact" aria-selected="false">Contact</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill"
											data-bs-target="#pills-disabled" type="button" role="tab"
											aria-controls="pills-disabled" aria-selected="false"
											disabled>Disabled</button>
									</li> -->
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active bg-transparent" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                                <div class="bg-light p-3 mb-4">
                                                    <div class="row">
                                                        <form id="frm_task_comment">
                                                            <div id="task_message"></div>
                                                            <div class="col-sm-1">
                                                                <div class="pro_img mt-1">
                                                                    <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-11">
                                                                <textarea placeholder="add Comment" class="form-control form-control-sm" name="comment_details" id="comment_details" value="">
																								</textarea>
                                                                <!-- <p class="mt-2 "><strong> tip:</strong> press <strong class="bg-secondary text-white ps-2 pe-2 rounded">M</strong>
                                                                to comment</p> -->
                                                                <input type="hidden" name="task_id" id="comment_task_id" />
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                                <div class="mt-2">
                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                    <button type="button" class="btn btn-info danger">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div id="task_comment_list">
                                                    <!-- <div class="row p-3 pb-0">
                                                        <div class="col-sm-1">
                                                            <div class="pro_img mt-1">
                                                                <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10 mt-2">
                                                            <p class="pb-1 mb-0">XYZ <span class="ms-4">1 hour ago</span></p>
                                                            <h6>Done</h6>
                                                            <div>
                                                                <button type="button" class="btn btn-dark">Edit</button>
                                                                <button type="button" class="btn btn-info danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row  p-3 pb-0">
                                                        <div class="col-sm-1">
                                                            <div class="pro_img mt-1">
                                                                <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10 mt-2">
                                                            <p class="pb-1 mb-0">XYZ <span class="ms-4">1 hour ago</span></p>
                                                            <h6>Done</h6>
                                                            <div>
                                                                <button type="button" class="btn btn-dark">Edit</button>
                                                                <button type="button" class="btn btn-info danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row  p-3 pb-0">
                                                        <div class="col-sm-1">
                                                            <div class="pro_img mt-1">
                                                                <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10 mt-2">
                                                            <p class="pb-1 mb-0">XYZ <span class="ms-4">1 hour ago</span></p>
                                                            <h6>Done</h6>
                                                            <div>
                                                                <button type="button" class="btn btn-dark">Edit</button>
                                                                <button type="button" class="btn btn-info danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <!-- <div class="tab-pane fade" id="pills-profile" role="tabpanel"
										aria-labelledby="pills-profile-tab" tabindex="0">...
									</div>
									<div class="tab-pane fade" id="pills-contact" role="tabpanel"
										aria-labelledby="pills-contact-tab" tabindex="0">...
									</div>
									<div class="tab-pane fade" id="pills-disabled" role="tabpanel"
										aria-labelledby="pills-disabled-tab" tabindex="0">...
									</div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="d-flex justify-content-start">
                                <div id="demo2">
                                    <div class="wrapper2">
                                        <div class="content2">
                                            <ul>
                                                @foreach($labels as $l)
                                                <a href="javascript:void(0);" onclick="setLebels('{{ $l->title}}','update')">
                                                    <li><span class="bg-secondary text-white p-1 ps-2 pe-2"><?php echo $l->title; ?></span></li>
                                                </a>
                                                @endforeach
                                                <!-- <a href="#">
                                                    <li><span class="bg-secondary text-white p-1 ps-2 pe-2">To Do</span></li>
                                                </a>
                                                <a href="#">
                                                    <li><span class="bg-info text-white p-1 ps-2 pe-2">Ready to test</span>
                                                    </li>
                                                </a>
                                                <a href="#">
                                                    <li><span class="bg-info text-white p-1 ps-2 pe-2">In Progress</span></li>
                                                </a>
                                                <a href="#">
                                                    <li>Resolved</li>
                                                </a> -->
                                            </ul>
                                        </div>
                                        <div class="parent bg-success text-white" id="details_page_status_display"><?php echo count($labels) > 0 ? $labels[0]->title : ''; ?></div>
                                        <input type="hidden" id="details_page_status" name="status" value="<?php echo count($labels) > 0 ? $labels[0]->title : ''; ?>">
                                    </div>

                                </div>
                                <!-- <div class="mt-1">
                                    <span class="material-symbols-outlined float-start text-success ms-2">
                                        done
                                    </span>
                                    Done
                                </div> -->
                            </div>
                            <div class="border rounded mt-3 p-2">
                                <h6 class="pt-1">Details</h6>
                                <hr>
                                <table class="table table-borderless m-0">
                                    <tr>
                                        <td width="50%">Assignee</td>
                                        <td>
                                            <div class="pro_img me-1 float-start">
                                                <img style="width: 30px!important; height: 30px;" src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                            </div>
                                            <span class="mt-1" id="edit_task_assignedTo"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td width="50%">Labels</td>
                                        <td>
                                            <div class="pro_img me-1 float-start">
                                                <span> None</span>
                                            </div>
                                        </td>
                                    </tr> -->
                                    <!-- <tr>
                                        <td width="50%">Reporter</td>
                                        <td>
                                            <div class="pro_img me-1 float-start">
                                                <img style="width: 30px!important; height: 30px;" src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                            </div>
                                            <span class="mt-1">John doe</span>
                                        </td>
                                    </tr> -->
                                </table>
                            </div>
                        </div>
                    </div>
            </section>

        </div>
    </div>
</div>
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
            <li class="nav-item active">
                <a href="{{url('task-management/projects')}}">Job List</a>
            </li>

        </ul>
    </div>
    <div class="content">
        <div class="page-inner">
            <?php
            $users_id = Session::get('users_id');
            $currentUserType = Session::get('user_type');
            $project_id = decrypt(request()->route('id'));
            $currentEmpDetails = User::select('users.*', 'e.id as emp_id')
                ->leftJoin('employee as e', 'e.emp_code', '=', 'users.employee_id')
                ->where('users.id', $users_id)->first();
            $currentMember =  ProjectMembers::where(['project_id' => $project_id, 'user_id' => $currentEmpDetails->emp_id])->first();
            // print_r($currentEmpDetails);
            // die;



            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fas fa-briefcase"></i> Task List
                                <span> <a data-placement="bottom" data-toggle="modal" data-target=".create_task_modal" data-original-title="Add New Task"><img style="width: 25px;" src="{{asset('img/plus1.png')}}"></a></span>
                            </h4>

                        </div>
                        <div class="card-header">
                            @include('taskmanagement.include.messages')


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Task</th>
                                            <th>Assigned To</th>
                                            <th>Description</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($tasks as $k=>$t)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td><a href="javascript:void(0);" onclick="taskDetailsModalOpen('{{$t->id}}')">{{$t->task_name}}</a></td>
                                            <td>{{$t->fname}} {{$t->mname}} {{$t->lname}}</td>
                                            <td>{{$t->task_desc}}</td>
                                            <td>{{$t->start_date}}</td>
                                            <td>{{$t->expected_end_date}}</td>
                                            <td>{{ucwords($t->status)}}</td>
                                            <td><?php
                                                if ((isset($currentMember->role) && (strtolower($currentMember->role) == 'manager' || strtolower($currentMember->role) == 'owner')) || $t->createdBy == $users_id || $currentUserType === 'employer') {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="openEditTaskModal('{{$t->id}}')"><i class="fa fa-edit"></i></a>
                                                <?php } ?>
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
    </div>
    @include('taskmanagement.partials.footer')
</div>
<!-- /.content -->
<div class="clearfix"></div>

<style>
    .pro_img,
    .pro_img img {
        border-radius: 50%;
        height: 40px;
        width: 40px !important;
    }

    #demo2 {
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
    }

    #demo2 .wrapper2 {
        display: inline-block;
        width: 180px;
        margin: 0 10px 0 0;
        height: 20px;
        position: relative;
    }

    #demo2 .parent {
        height: 100%;
        width: 100%;
        display: block;
        cursor: pointer;
        line-height: 30px;
        height: 30px;
        border-radius: 5px;
        background: #F9F9F9;
        border: 1px solid #AAA;
        border-bottom: 1px solid #777;
        color: #282D31;
        font-weight: bold;
        z-index: 2;
        position: relative;
        -webkit-transition: border-radius .1s linear, background .1s linear, z-index 0s linear;
        -webkit-transition-delay: .8s;
        text-align: center;
    }

    #demo2 .parent:hover,
    #demo2 .content2:hover~.parent {
        background: #fff;
        -webkit-transition-delay: 0s, 0s, 0s;
    }

    #demo2 .content2:hover~.parent {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        z-index: 0;
    }

    #demo2 .content2 {
        position: absolute;
        top: 0;
        display: block;
        z-index: 1;
        height: 0;
        width: 180px;
        padding-top: 30px;
        -webkit-transition: height .5s ease;
        -webkit-transition-delay: .4s;
        border: 1px solid #777;
        border-radius: 5px;
        box-shadow: 0 0px 0px rgba(0, 0, 0, .4);
    }

    #demo2 .wrapper2:active .content2 {
        height: 123px;
        z-index: 3;
        -webkit-transition-delay: 0s;
    }

    #demo2 .content2:hover {
        height: 123px;
        z-index: 3;
        -webkit-transition-delay: 0s;
    }


    #demo2 .content2 ul {
        background: #fff;
        margin: 0;
        padding: 0;
        overflow: hidden;
        height: 100%;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    #demo2 .content2 ul a {
        text-decoration: none;
    }

    #demo2 .content2 li:hover {
        background: #eee;
        color: #333;
    }

    #demo2 .content2 li {
        list-style: none;
        text-align: left;
        color: #888;
        font-size: 14px;
        line-height: 30px;
        height: 30px;
        padding-left: 10px;
        border-top: 1px solid #ccc;
    }

    #demo2 .content2 li:last-of-type {
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .modal-lg {
        max-width: 80%;
    }

    .modal-md {
        max-width: 700px;
    }

    .close.close_popup {
        position: absolute;
        right: 0;
        top: -7px;
        font-size: 30px;
        opacity: 1;
        color: #f00;
    }

    .create_task_new {
        right: 0;
        top: 0;
    }

    .danger {
        background: red !important;
        color: white
    }

    @media(max-width:700px) {

        .modal-lg,
        .modal-md {
            max-width: 90%;
            left: 0;
            right: 0;
            margin: auto;
        }

        .create_task_new {
            position: relative !important;
        }
    }

    #btn_details_task_modal {
        display: none;
    }
</style>


@endsection

@section('scripts')
@include('taskmanagement.partials.scripts')
<script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#frm_task_comment #comment_details').val("")
        $("#frm_task_create").validate({
            rules: {
                task_name: {
                    required: true,
                },
                task_desc: {
                    required: true,
                },
            },
            messages: {
                task_name: {
                    required: "Task title is required",
                },
                task_desc: {
                    required: "Task description is required",
                },
            },
            submitHandler: function(form) {
                const task_id = $('#task_id').val();
                if (task_id && task_id !== '') {
                    $.ajax({
                        url: base_url + "/tasks/update",
                        method: "POST",
                        // headers: {
                        //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        // },
                        data: $(form).serialize(),
                        success: (data) => {
                            console.log("success", data);
                            $("#frm_task_create #message").html(
                                '<div class="alert alert-success">Task has been updated successfully</div>'
                            );
                            $(form)[0].reset();
                            $('#create_task_modal').modal('hide');
                            // alert("Project has been created successfully");
                        },
                        error: (error) => {
                            console.log(error);
                            $("#frm_task_create #message").html(
                                '<div class="alert alert-danger">' +
                                JSON.stringify(error) +
                                "</div>"
                            );
                            $(form).reset();
                            alert(JSON.stringify(error));
                        },
                    });
                } else {
                    $.ajax({
                        url: base_url + "/tasks/add",
                        method: "POST",
                        // headers: {
                        //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        // },
                        data: $(form).serialize(),
                        success: (data) => {
                            console.log("success", data);
                            $("#frm_task_create #message").html(
                                '<div class="alert alert-success">Task has been created successfully</div>'
                            );
                            $(form)[0].reset();
                            // alert("Project has been created successfully");
                        },
                        error: (error) => {
                            console.log(error);
                            $("#frm_task_create #message").html(
                                '<div class="alert alert-danger">' +
                                JSON.stringify(error) +
                                "</div>"
                            );
                            $(form).reset();
                            alert(JSON.stringify(error));
                        },
                    });
                }
            },
        });
        $('#frm_task_comment').validate({
            rules: {
                comment_details: {
                    required: true,
                    minlength: 3,
                },

            },
            messages: {
                comment_details: {
                    required: "Comment details  is required",
                    minlength: 'Atleast 3 charactors'
                },

            },
            submitHandler: function(form) {
                $.ajax({
                    url: base_url + "/comments/add",
                    method: "POST",
                    // headers: {
                    //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    // },
                    data: $(form).serialize(),
                    success: (data) => {
                        console.log("success", data);
                        $("#frm_task_comment #task_message").html(
                            '<div class="alert alert-success">Comment has been submitted successfully</div>'
                        );
                        getCommentList($('#frm_task_comment #comment_task_id').val());
                        // $(form)[0].reset();
                        // alert("Project has been created successfully");
                    },
                    error: (error) => {
                        console.log(error);
                        $("#frm_task_comment #task_message").html(
                            '<div class="alert alert-danger">' +
                            JSON.stringify(error) +
                            "</div>"
                        );
                        // $(form).reset();
                        // alert(JSON.stringify(error));
                    },
                });
            }
        })


    })
    const taskDetailsModalOpen = (id) => {
        $('#frm_task_comment #comment_task_id').val(id);
        $.ajax({
            url: base_url + '/tasks/getDetails/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data)
                setTaskDetails(data)
                getCommentList(id)
            },
            error: function(err) {
                console.log(err)
            }
        })
        $('#details_task_modal').modal('show')
    }
    const commentDelete = (id, task_id) => {
        if (window.confirm("Are you sure?")) {
            $.ajax({
                url: base_url + '/comments/del/' + id,
                method: 'GET',
                success: function(data) {
                    console.log(data)
                    // setTaskDetails(data)
                    getCommentList(task_id)
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }
    }
    const setTaskDetails = (data) => {
        console.log(data?.task_name)
        $('#edit_task_title').html(data?.task_name);
        $('#edit_task_due_date').html(data?.expected_end_date);
        $('#edit_task_desc').html(data?.task_desc);
        $('#edit_task_assignedTo').html(data?.assignedUsername);
        $('#edit_task_title').html(data?.task_name);
        $('#details_page_status_display').html(data?.status);
    }
    const setCommentList = (data, id) => {
        let str = '';
        data.forEach(d => {
            str += ` <div class="row p-3 pb-0">
                                                    <div class="col-sm-1">
                                                        <div class="pro_img mt-1">
                                                            <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10 mt-2">
                                                        <p class="pb-1 mb-0">${d.username} <span class="ms-4">${timeSince(new Date(d.created_at))}</span></p>
                                                        <h6>${d.comment_details}</h6>
                                                        
                                                   `;

            if (d.createdBy === <?php echo Session::get('users_id') ?>) {
                str += `<div>
                                                           
                                                            <button type="button" class="btn btn-info danger" onclick="commentDelete(${d.id},${id})">Delete</button>
                                                        </div>
                                                    `
            }
            str += `</div>
                                                </div>`;
        })
        $('#task_comment_list').html(str);
    }
    const getCommentList = (id) => {
        $.ajax({
            url: base_url + '/comments/get?tid=' + id,
            method: 'GET',
            success: function(list) {
                console.log("list>>", list);
                setCommentList(list, id)
            },
            error: function(err) {
                console.log(err)
            }
        })
    }
    const openEditTaskModal = (id) => {
        $('#task_id').val(id);
        console.log(id);
        $.ajax({
            url: base_url + '/tasks/getDetails/' + id,
            method: 'GET',
            success: (data) => {
                console.log(data);
                setTaskCreateForm(data, 'edit')
            },
            error: (err) => {
                console.log(err)
            }
        })
        $('#create_task_modal').modal('show');
    }
    const setTaskCreateForm = (data, mode = null) => {
        if (mode) {
            $('#task_name').val(data?.task_name);
            $('#start_date').val(data?.start_date);
            $('#expected_end_date').val(data?.expected_end_date);
            $('#task_create_status_display').text(data?.status);
            $('#task_create_status').val(data?.task_name);
            $('#task_desc').val(data?.task_desc);
            $('#frm_title').html("Update issue")
            $('select#assignedTo option[value="' + data.assignedTo + '"]').attr("selected", true);
        } else {

        }
    }
    const setLebels = (l, mode) => {
        console.log(l)
        if (mode == 'create') {
            $('#task_create_status_display').text(l)
            $('#task_create_status').val(l)
        } else {
            $('#details_page_status_display').text(l)
            $('#details_page_status').val(l)
        }
        let frmData = new FormData();
        // frmData.append('task_id', $('#comment_task_id').val());
        // frmData.append('status', l)
        // frmData.append('_token', '{{ csrf_token() }}');
        console.log("frmSata>>>", frmData)
        $.ajax({
            url: base_url + '/tasks/updateStatus',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: l,
                task_id: $('#comment_task_id').val()
            },
            dataType: 'JSON',

            success: function(data) {
                // console.log(data)
                // setTaskDetails(data)
                // getCommentList(id)
                console.log(data)
            },
            error: function(err) {
                console.log(err)
            }
        })
    }
</script>
@endsection