@extends('employeer.include.app')
@section('title', 'Edit Project')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">Task Management Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Project</li>
                 </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Edit Project</h4>
                  </div>
                  @include('employeer.layout.message')
                  <div class="card-body">
                     <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                            <form id="frm_project_update" method="POST" action="{{url('org-projects/update')}}">
                                @include('taskmanagement.include.messages')
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="clearfix"></div>
                                <div class="lv-due" style="border:none;">
                                    <div class="row form-group lv-due-body">
                                        <div class="col-md-6">
                                            <label class="col-form-label">Project Title <span>(*)</span></label>
                                            <input type="text" class="form-control" name="title" value="{{$project->title}}" />

                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Identifier <span>(*)</span></label>
                                            <input type="text" class="form-control" name="identifier" value="{{$project->identifier}}" />

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-form-label">Description <span>(*)</span></label>
                                            <textarea class="form-control" rows=4 name="description">{{$project->description}}</textarea>

                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Status <span>(*)</span></label>
                                            <select class="select" rows=4 name="status">
                                                <option>Select Status</option>
                                                @foreach($statusOptions as $k=>$op)
                                                <option value="{{$k}}" {{ ( $k == $project->status) ? 'selected' : '' }}>{{$op}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4 btn-up">
                                            <button class="btn btn-primary" type="submit" id="btn_project_create">Submit</button>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="hidden" name="id" value="{{request()->route('id')}}" />
                                </div>
                            </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection