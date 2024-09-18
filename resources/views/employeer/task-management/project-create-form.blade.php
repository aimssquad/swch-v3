@extends('employeer.include.app')
@section('title', 'Add New Project')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">Task Management Dashboard</a></li>
                    <li class="breadcrumb-item active">Project</li>
                 </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Add New Project</h4>
                  </div>
                  @include('employeer.layout.message')
                  <div class="card-body">
                     <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                            <form id="frm_project_create" method="POST" action="{{url('org-projects/add')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="clearfix"></div>
                                <div class="lv-due" style="border:none;">
                                    <div class="row form-group lv-due-body">
                                        <div class="col-md-6">
                                            <label class="col-fprm-label">Project Title <span>(*)</span></label>
                                            <input type="text" class="form-control" name="title" />

                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-fprm-label">Identifier <span>(*)</span></label>
                                            <input type="text" class="form-control" name="identifier" />

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-fprm-label">Description <span>(*)</span></label>
                                            <textarea class="form-control" rows=4 name="description"></textarea>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4 btn-up">
                                            <button class="btn btn-primary" type="submit" id="btn_project_create">Submit</button>
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
      </div>
   </div>
</div>
@endsection