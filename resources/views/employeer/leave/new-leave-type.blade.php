@extends('employeer.include.app')
@section('title', 'Add Leave Type')
@if(!empty($holidaydtl->id))  
@section('title', 'Edit Leave Type')
@else   
@section('title', 'Add Leave Type')
@endif 
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('leave/dashboard')}}">Dashboard</a></li>
            @if(!empty($holidaydtl->id))
            <li class="breadcrumb-item active">Edit Leave Type</li>
            @else
            <li class="breadcrumb-item active">Add New Leave Type</li>
            @endif
         </ul>
         <div class="card custom-card">
            <div class="card-header">
               @if(!empty($holidaydtl->id))  
               <h4 class="card-title"><i class="far fa-user"></i>  Edit Leave type</h4>
               @else   
               <h4 class="card-title"><i class="far fa-user"></i>  Add New Leave type</h4>
               @endif 
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form action="{{url('leave/new-leave-type')}}" method="post" enctype="multipart/form-data" class="form-horizontal" >
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="<?php  if(!empty($holidaydtl->id)){echo $holidaydtl->id;} ?>">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="leave-type" class="col-form-label">Leave Type</label>
                                    <input  type="text" class="form-control input-border-bottom" required=""  name='leave_type_name' id="leave-type" value="<?php if(isset($holidaydtl->id)){  echo $holidaydtl->leave_type_name;  }?>{{ old('leave_type_name') }}">
                                    @if($errors->has('leave_type_name'))
                                    <div class="error" style="color:red;">{{$errors->first('leave_type_name')}}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="alias" class="col-form-label">Leave Type Sort Code</label>
                                    <input  type="text" class="form-control input-border-bottom" required=""  name='alies'  id="alias" value="<?php if(isset($holidaydtl->id)){  echo $holidaydtl->alies;  }?>{{ old('alies') }}">
                                    @if($errors->has('alies'))
                                    <div class="error" style="color:red;">{{ $errors->first('alies') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel-remarks" class="col-form-label">Remarks</label>
                                    <input id="inputFloatingLabel-remarks" type="text" class="form-control input-border-bottom"  name='remarks' value="<?php if(isset($holidaydtl->id)){  echo $holidaydtl->remarks;  }?>">
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="row form-group">
                              <div class="col-md-12 text-center">
                                 <button type="submit" class="btn btn-primary">Submit</button>
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
@endsection
@section('script')

@endsection