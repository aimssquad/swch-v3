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

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <div class="row" style="border:none;">
            <div class="col-md-6">
                <h5 class="card-title">Member Management</h5>
            </div>
            <div class="col-md-6">

                <span class="right-brd" style="padding-right:15x;">
                    <ul class="">
                        <li><a href="#">Home</a></li>
                        <li>/</li>
                        <li><a href="#">Task Management</a></li>
                        <li>/</li>
                        <li><a href="#">Member List</a></li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Widgets  -->
        <div class="row">
            <div class="main-card">
                <?php //print_r($role_authorization); exit;
                ?>
                <div class="card">

                    <div class="card-body">
                        <!-- @if(Session::has('message'))
						<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok"></span><em> {{ Session::get('message') }}</em></div>
						@endif -->
                        @include('include.messages')
                        <form enctype="multipart/form-data" id="frm_project_create" method="post">
                            <div id="message"></div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="clearfix"></div>
                            <div class="lv-due" style="border:none;">
                                <div class="row form-group lv-due-body">
                                    <div class="col-md-4">
                                        <label>Project Title <span>(*)</span></label>
                                        <input type="text" class="form-control" name="title" />

                                    </div>
                                    <div class="col-md-4">
                                        <label>Identifier <span>(*)</span></label>
                                        <input type="text" class="form-control" name="identifier" />

                                    </div>
                                    <div class="col-md-4 btn-up">
                                        <button type="submit" class="btn btn-danger btn-sm" id="btn_project_create">Submit</button>
                                        <!-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button> -->
                                    </div>


                                </div>


                            </div>
                        </form>
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




@endsection

@section('scripts')
@include('taskmanagement.partials.scripts')
<script src="{{asset('taskmanagement/taskmanagement.js')}}"></script>
@endsection