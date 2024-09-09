@extends('employeer.include.app')
@if(isset($_GET['id']))
@section('title', 'Edit Department')
@else
@section('title', 'Add New Department')
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
                  <li class="breadcrumb-item active">Edit Department</li>
                  @else
                  <li class="breadcrumb-item active">Add Department</li>
                  @endif
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     @if(isset($_GET['id']))
                     <h4 class="card-title"><i class="far fa-user"></i> Edit New Department</h4>
                     @else
                        <h4 class="card-title"><i class="far fa-user"></i> Add New Department</h4>
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
                                                       <div class="row">
                                                           <div class="col-md-4">
                                                           <div class="form-group">
                                                               <label for="inputFloatingLabel" class="col-form-label">Department Name</label>
                                                                   <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="department_name" value="<?php if(isset($_GET['id'])){  echo $departments[0]->department_name;  }?>{{ old('department_name') }}">
                                                                   
                                                                   
                                                                    @if ($errors->has('department_name'))
                               <div class="error" style="color:red;">{{ $errors->first('department_name') }}</div>
                               @endif
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