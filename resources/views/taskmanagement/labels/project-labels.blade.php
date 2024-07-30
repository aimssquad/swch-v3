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
                <a href="">Label List</a>
            </li>

        </ul>
    </div>
    <div class="content">
        <div class="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fas fa-briefcase"></i> Project Label List
                                <!-- <span> <a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('task-management/create-project')}}" data-original-title="Add New Project"><img style="width: 25px;" src="{{asset('img/plus1.png')}}"></a></span> -->
                            </h4>

                        </div>
                        <div class="card-header">
                            @include('taskmanagement.include.messages')

                            <form method="POST" id="frm_project_labels">
                                <!-- <div id="message"></div> -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="clearfix"></div>
                                <div class="lv-due" style="border:none;">
                                    <div class="row form-group lv-due-body">
                                        <div class="col-md-4">
                                            <label>Label <span>(*)</span></label>
                                            <input type="text" class="form-control" name="title" />

                                        </div>

                                        <div class="col-md-1 mt-2">
                                            <label></label>
                                            <button type="submit" class="btn btn-primary btn-sm mt-4">Submit</button>
                                            <!-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button> -->
                                        </div>


                                    </div>


                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>label Name</th>
                                            <th>Status</th>

                                            <!-- <th>Role</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($labels as $key=>$l)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$l->title}}</td>
                                            <td>{{$l->status}}</td>

                                            <td>
                                                <!-- <a href="#" class="btn btn-info"><i class="fa fa-pencil"></i></a> -->
                                                <a href="{{url('task-management/'.request()->route('id').'/label-del/'.encrypt($l->id))}}" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
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
@include('taskmanagement.partials.scripts')
<script>
    $(document).ready(() => {
        $('#frm_project_labels').validate({
            rules: {
                title: {
                    required: true,

                },

            },
            messages: {
                title: {
                    required: "Title  is required",
                },

            },
            submitHandler: function(form) {
                form.submit();
                // $.ajax({
                //     url: base_url + "/comments/add",
                //     method: "POST",
                //     // headers: {
                //     //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                //     // },
                //     data: $(form).serialize(),
                //     success: (data) => {
                //         console.log("success", data);
                //         $("#frm_task_comment #task_message").html(
                //             '<div class="alert alert-success">Comment has been submitted successfully</div>'
                //         );
                //         getCommentList($('#frm_task_comment #comment_task_id').val());
                //         // $(form)[0].reset();
                //         // alert("Project has been created successfully");
                //     },
                //     error: (error) => {
                //         console.log(error);
                //         $("#frm_task_comment #task_message").html(
                //             '<div class="alert alert-danger">' +
                //             JSON.stringify(error) +
                //             "</div>"
                //         );
                //         // $(form).reset();
                //         // alert(JSON.stringify(error));
                //     },
                // });
            }
        })
    })
</script>
@endsection