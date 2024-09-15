@extends('employeer.include.app')
@section('title', 'Add Mode Of Employee')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active"> Add Mode Of Employee</li>
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Add New Mode Employee Type</h4>
                  </div>
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                  @endif
                  @if(Session::has('error'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('error') }}</div>
                  @endif
                  <div class="card-body">
                     <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                           <form action="{{url('org-settings/add-mode-emp-new')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                              <div class="row">
                                 <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel" class="col-form-label">Mode Of Employee</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="mode_emp_name" placeholder="Enter Your Mode of Employee">
                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                    <select class="select" name="status">
                                    <option>Status</option>
                                    <option value="active">Active</option>
                                    <option value="inActive">inActive</option>
                                    </select>
                                          <!-- <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="status" > -->
                                    </div>
                                    </div>
                                    </div>
                                    <br>
                                    <div class="row form-group">
                                 <div class="col-md-2"><button type="submit" class="btn btn-primary">Submit</button></div>
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