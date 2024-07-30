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
<div class="main-panel">
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <div class="row" style="border:none;">
                <div class="col-md-6">
                    <h5 class="card-title">Task Management</h5>
                </div>
                <div class="col-md-6">

                    <span class="right-brd" style="padding-right:15x;">
                        <ul class="">
                            <li><a href="#">Home</a></li>
                            <li>/</li>
                            <li><a href="#">Task Management</a></li>
                            <li>/</li>
                            <li><a href="#">Project List</a></li>
                        </ul>
                    </span>
                </div>
            </div>
            <!-- Widgets  -->
            <div class="row">

                <div class="main-card">

                    <div class="card">
                        <div class="card-header">


                            @include('include.messages')

                            <div class="aply-lv" style="padding-right: 36px;">
                                <a href="{{ url('role/add-user-role') }}" class="btn btn-default">Add New User Role <i class="fa fa-plus"></i></a>
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
                                            <th>User ID</th>
                                            <th>Module Name</th>
                                            <th>Sub Module Name</th>
                                            <th>Menu</th>
                                            <th>Rights</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
</div>
<!-- /.content -->
<div class="clearfix"></div>




@endsection

@section('scripts')
@include('taskmanagement.partials.scripts')
@endsection