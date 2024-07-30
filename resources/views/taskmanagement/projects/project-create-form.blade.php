@extends('taskmanagement.layouts.master')

@section('title')
SWCH
@endsection

@section('sidebar')
@include('taskmanagement.partials.sidebar')
@endsection

@section('header')
@include('taskmanagement.partials.header')
@endsection

@section('content')

<div class="main-panel">
    <div class="page-header">
        <!-- <h4 class="page-title">Time Shift Management</h4> -->

        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{url('task-management/dashboard')}}">
                    Home
                </a>
            </li>
            <li class="separator">
                /
            </li>
            <li class="nav-home">
                <a href="{{url('task-management/projects')}}">
                    Task Management
                </a>
            </li>
            <li class="separator">
                /
            <li class="nav-item active">
                Create Project
            </li>

        </ul>
    </div>
    <div class="content">
        <div class="page-inner">

            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fa fa-users" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Project Create</h4>
                        </div>
                        <div class="card-body">
                            <form id="frm_project_create" method="POST" action="{{url('projects/add')}}">
                                @include('taskmanagement.include.messages')
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="clearfix"></div>
                                <div class="lv-due" style="border:none;">
                                    <div class="row form-group lv-due-body">
                                        <div class="col-md-6">
                                            <label>Project Title <span>(*)</span></label>
                                            <input type="text" class="form-control" name="title" />

                                        </div>
                                        <div class="col-md-6">
                                            <label>Identifier <span>(*)</span></label>
                                            <input type="text" class="form-control" name="identifier" />

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Description <span>(*)</span></label>
                                            <textarea class="form-control" rows=4 name="description"></textarea>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 btn-up">
                                            <!-- <button type="submit" class="btn btn-danger btn-sm" id="btn_project_create">Submit</button> -->
                                            <button class="btn btn-default" type="submit" id="btn_project_create">Submit</button>
                                            <!-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button> -->
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('taskmanagement.include.footer')
</div>


@endsection

@section('scripts')
@include('taskmanagement.partials.scripts')
<script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>
@endsection