@extends('employeer.include.app')
@section('title', 'Mode Of Employee Edit')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active"> Edit Mode Of Employee</li>
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Edit Mode Of Employee</h4>
                  </div>
                  <div class="card-body">
                     <div class="multisteps-form">
                        @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                        @endif
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                            <form action="{{url('org-settings/mode-emp-new-update')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="id" value="{{$enteries->id}}">
                                            <label for="inputFloatingLabel" class="col-form-label">Mode Of Employee</label>
                                            <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" name="mode_emp_name" value="{{$enteries->mode_emp_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                            <select class="select" name="status">
                                                <option value="active" {{ $enteries->status === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $enteries->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row form-group">
                                    <div class="col-md-2"><button type="submit" class="btn btn-primary">Submit</button></div>
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