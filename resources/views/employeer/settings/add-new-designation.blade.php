@extends('employeer.include.app')
@if(isset($_GET['id']))
@section('title', 'Edit New Designation')
@else
@section('title', 'Add New Designation')
@endif

@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                  @if(isset($_GET['id']))
                  <li class="breadcrumb-item active">Edit Designation</li>
                  @else
                  <li class="breadcrumb-item active">Add Designation</li>
                  @endif
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     @if(isset($_GET['id']))
                     <h4 class="card-title"><i class="far fa-user"></i> Edit New Designation</h4>
                     @else
                     <h4 class="card-title"><i class="far fa-user"></i> Add New Designation</h4>
                     @endif
                    
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
                            <form action="" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                                           <div class="row form-group">
                                                           <div class="col-md-4">
                                           <div class="form-group">
                                                                   <label for="selectFloatingLabel" class="col-form-label">Select Department</label>
                                                                       <select class="select input-border-bottom" id="selectFloatingLabel" name="department_code" required="">
                                                                                                               
                                               
                                                @foreach($department as $dept)
                                               <option value='{{ $dept->id }}'<?php  if(app('request')->input('id')){ if($designation->department_code==$dept->department_code){ echo 'selected'; } } ?> <?php  if(app('request')->input('id')){ if($designation->department_code==$dept->id){ echo 'selected'; } } ?> >{{ $dept->department_name }}</option>
                                                                   
                                               @endforeach
                                                                                                                   
                                           </select>
                                                               @if ($errors->has('department_code'))
                                                                   <div class="error" style="color:red;">{{ $errors->first('department_code') }}</div>
                                                               @endif
                                                                   
                                                               </div>
                                                               </div>
                                       <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="inputFloatingLabel" class="col-form-label">Designation Name</label>
                                                                   <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  required="" name="designation_name"  value="<?php  if(app('request')->input('id')){ echo $designation->designation_name; } ?> {{ old('designation_name') }}">
                                                                   
                                                                       @if ($errors->has('designation_name'))
                                                               <div class="error" style="color:red;">{{ $errors->first('designation_name') }}</div>
                                                           @endif
                                                               </div>
                                                               </div>
                                                               </div>
                                                               <br>
                                                               <div class="row form-group">
                                       <div class="col-md-4">
                                           <button type="submit" class="btn btn-primary">Submit</button>
                                       </div>
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