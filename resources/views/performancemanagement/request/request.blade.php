@extends('performancemanagement.layouts.master')

@section('title')
SWCH
@endsection

@section('sidebar')
@include('performancemanagement.partials.sidebar')
@endsection

@section('header')
@include('performancemanagement.partials.header')
@endsection

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<!-- Content -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                <h2>Implementation Home page with sakib</h2>
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
                                    <div class="bg-light d-block p-2">Implementation Home page with sakib</div>
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
                                                                <img src="https://allphanes.com/assets/web_img/choto_logo_1.png" alt="Kabbir">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <textarea placeholder="add Comment" class="form-control form-control-sm">
																								</textarea>
                                                            <p class="mt-2 "><strong> tip:</strong> press <strong class="bg-secondary text-white ps-2 pe-2 rounded">M</strong>
                                                                to comment</p>

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
                                                            <img src="https://allphanes.com/assets/web_img/choto_logo_1.png" alt="Kabbir">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10 mt-2">
                                                        <p class="pb-1 mb-0">Tia Saha <span class="ms-4">1 hour ago</span></p>
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
                                                            <img src="https://allphanes.com/assets/web_img/choto_logo_1.png" alt="Kabbir">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10 mt-2">
                                                        <p class="pb-1 mb-0">Tia Saha <span class="ms-4">1 hour ago</span></p>
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
                                                            <img src="https://allphanes.com/assets/web_img/choto_logo_1.png" alt="Kabbir">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10 mt-2">
                                                        <p class="pb-1 mb-0">Tia Saha <span class="ms-4">1 hour ago</span></p>
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
                                                <img style="width: 30px!important; height: 30px;" src="https://allphanes.com/assets/web_img/choto_logo_1.png" alt="Kabbir">
                                            </div>
                                            <span class="mt-1">Tia Saha</span>
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
                                                <img style="width: 30px!important; height: 30px;" src="https://allphanes.com/assets/web_img/choto_logo_1.png" alt="Kabbir">
                                            </div>
                                            <span class="mt-1">Somrita Banerji</span>
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
                <a href="{{url('/performances')}}">Request List</a>
            </li>

        </ul>
    </div>
    <?php $status = request()->get('status');
    ?>
    <div class="content">
        <div class="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fas fa-filter"></i> <select class="filter_option" id="filter_option">
                                    <option value="">All</option>
                                    <option value="pending" <?php if ($status == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="submitted" <?php if ($status == 'submitted') echo 'selected'; ?>>Submitted</option>
                                    <option value="completed" <?php if ($status == 'completed') echo 'selected'; ?>>Completed</option>
                                </select>
                                @if($currentUserType=='employer')
                                <span> <a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('performances/request')}}" data-original-title="Add New Project"><img style="width: 25px;" src="{{asset('img/plus1.png')}}"></a></span>
                                @endif
                            </h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Employee</th>
                                            @if($currentUserType=='employer')
                                            <th>Reporting Auth</th>
                                            @endif
                                            <!-- <th>Joing Date</th> -->
                                            <th>Department</th>
                                            <th>Apprisal Period Start </th>
                                            <th>Apprisal Period End </th>
                                            <th>Rating</th>
                                            <th>Status</th>
                                            <!-- <th>End Date</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($performances as $k=>$p)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$p->emp_fname}} {{$p->emp_mname?' '.$p->emp_mname:''}} {{$p->emp_lname?' '.$p->emp_lname:''}}</td>
                                            @if($currentUserType=='employer')
                                            <td>{{$p->rep_fname}} {{$p->rep_mname?' '.$p->rep_mname:''}} {{$p->rep_lname?' '.$p->rep_lname:''}}</td>
                                            @endif
                                            <td>{{$p->emp_department}}</td>
                                            <td>{{date('d-m-Y', strtotime($p->apprisal_period_start))}}</td>
                                            <td>{{date('d-m-Y', strtotime($p->apprisal_period_end))}}</td>
                                            <td>{{ $p->rating}}</td>
                                            <td>{{ ucfirst($p->status)}}</td>
                                            <td>
                                                <a href="{{url('/performances/request/'.encrypt($p->id))}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                @if($currentUserType=='employer')
                                                <a href="{{url('performances/del/'.encrypt($p->id))}}" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                                @endif
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

    .close.close_popup {
        position: absolute;
        right: 0;
        top: -7px;
        font-size: 30px;
        opacity: 1;
        color: #f00;
    }
</style>


@endsection

@section('scripts')
@include('performancemanagement.partials.scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{asset('assets/performancemanagement/performancemanagement.js')}}"></script>
@endsection