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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,1,0" />

<!-- Content -->
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
                                <h2>Implementation Home page </h2>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <p class="mt-1">Due date</p>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="bg-light d-block p-2">Light</div>
                                        <!-- <input class="form-control form-control-sm" type="date" placeholder="None" /> -->
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <h6>Description</h6>
                                    <div class="bg-light d-block p-2">Implementation Home page</div>
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
                                                        <div class="col-sm-1">
                                                            <div class="pro_img mt-1">
                                                                <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <textarea placeholder="add Comment" class="form-control form-control-sm">
																								</textarea>
                                                            <!-- <p class="mt-2 "><strong> tip:</strong> press <strong class="bg-secondary text-white ps-2 pe-2 rounded">M</strong>
                                                                to comment</p> -->

                                                            <div>
                                                                <button type="button" class="btn btn-primary">Save</button>
                                                                <button type="button" class="btn btn-danger">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row p-3 pb-0">
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
                                                            <button type="button" class="btn btn-danger">Delete</button>
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
                                                            <button type="button" class="btn btn-danger">Delete</button>
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
                                                            <button type="button" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
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
                                    <div class="wrapper">
                                        <div class="content2">
                                            <ul>
                                                <a href="#">
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
                                                </a>
                                            </ul>
                                        </div>
                                        <div class="parent bg-success text-white">Done</div>
                                    </div>

                                </div>
                                <div class="mt-1">
                                    <span class="material-symbols-outlined float-start text-success ms-2">
                                        done
                                    </span>
                                    Done
                                </div>
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
                                            <span class="mt-1">XYZ</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Labels</td>
                                        <td>
                                            <div class="pro_img me-1 float-start">
                                                <span> None</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Reporter</td>
                                        <td>
                                            <div class="pro_img me-1 float-start">
                                                <img style="width: 30px!important; height: 30px;" src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="Kabbir">
                                            </div>
                                            <span class="mt-1">John doe</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>

        </div>
    </div>
</div>

<div class="modal fade create_task_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                <h4>Create issue</h4>
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
                                        <input type="text" class="form-control" name="task_name" />
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
                                            <input type="date" class="form-control form-control-sm" name="start_date" />
                                        </div>
                                        <div class="col-sm-2">
                                            End Date
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control form-control-sm" name="expected_end_date" />
                                        </div>

                                    </div>
                                    <div>
                                        <label>Assign to</label>
                                        <select class="form-select  mt-2" aria-label="Default select example" name="assignedTo">
                                            <option selected disabled>Unassigned</option>
                                            @foreach($members as $m)
                                            <option value="{{$m->id}}">{{$m->name}}</option>
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
                                        <div class="wrapper">
                                            <div class="content2">
                                                <ul>
                                                    <a href="#">
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
                                                    </a>
                                                </ul>
                                            </div>
                                            <div class="parent bg-success text-white">To Do</div>
                                        </div>

                                    </div>
                                    <p class="mt-1 mb-3">This is the issue's initial status upon creation</p>


                                    <label>Summary <span class="text-danger">*</span></label>
                                    <textarea type="text" placeholder="" class="form-control form-control-sm mt-1" name="task_desc"></textarea>
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
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Create</button>
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
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Tasks</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Home</a></li>
                        <li>/</li>
                        <li><a href="#" data-toggle="modal" data-target=".details_task_modal">Task Management</a></li>
                        <li>/</li>
                        <!-- <li><a href="#">Project List</a></li>
                        <li>/</li> -->
                        <li><a href="#" data-toggle="modal" data-target=".create_task_modal">Task list</a></li>
                    </ul>
                </span>
            </div>
        </div>
        <a href="#" data-toggle="modal" data-target=".details_task_modal" id="btn_details_task_modal">Task Management</a>
        <!-- Widgets  -->
        <div class="row">

            <div class="main-card">

                <div class="card">
                    <div class="card-header">


                        @include('taskmanagement.include.messages')

                        <div class="aply-lv" style="padding-right: 36px;">
                            <a href="#" data-toggle="modal" data-target=".create_task_modal" class="btn btn-default">Add New Task <i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    <!-- @if(Session::has('message'))										
                            <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                    @endif	 -->

                    <div class="card-body">

                        <div class="srch-rslt" style="overflow-x:scroll;">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
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
                                        <td>{{$t->task_name}}</td>
                                        <td>{{$t->task_desc}}</td>
                                        <td>{{$t->start_date}}</td>
                                        <td>{{$t->expected_end_date}}</td>
                                        <td>{{ucwords($t->status)}}</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <!-- /Widgets -->
    </div>
    <!-- .animated -->
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

    #demo2 .wrapper {
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

    #demo2 .wrapper:active .content2 {
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
<script src="{{asset('taskmanagement/taskmanagement.js')}}"></script>
<script>
    $(document).ready(function($) {

        // $("#details_task_modal").modal('show');
    })

    function taskDetailsModalOpen(id) {
        console.log("ok", id, )
        // jQuery.noConflict();
        // $("#details_task_modal").modal('show');
        $('#btn_details_task_modal').click();


    }
</script>
@endsection