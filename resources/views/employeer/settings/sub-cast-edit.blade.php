@extends('employeer.include.app')
@section('title', 'Sub Caste Edit')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Edit Sub Cast</li>
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Edit Sub Caste</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     @if(Session::has('message'))										
                     <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                     @endif
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{url('org-settings/update-sub-cast')}}" method="post" enctype="multipart/form-data">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="id" value="<?php echo $getCast[0]->id;   ?>">
                              <div class="row form-group">
                                 <div class="col-md-6">
                                    <label for="text-input" class="col-form-label">Select Caste <span>(*)</span></label>
                                    <?php //print_r($getCast); exit; 
                                       ?>
                                    <select class="select" name="cast_id" required>
                                       <option value='' selected disabled>Select</option>
                                       @foreach($getCast as $cast)
                                       <option value='{{ $cast->id }}' <?php if ($getCast[0]->cast_name == $cast->cast_name) { echo 'selected'; } ?> <?php if (old('cast_id') == $cast->cast_name) { echo "selected"; } ?>>{{ $cast->cast_name }}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('cast_id'))
                                    <div class="error" style="color:red;">{{ $errors->first('cast_id') }}</div>
                                    @endif
                                 </div>
                                 <div class="col-md-6">
                                    <label for="email-input" class="col-form-label">Enter Sub Caste Name <span>(*)</span></label>
                                    <input type="text" id="designation_name" required name="sub_cast_name" class="form-control" value="<?php echo $getCast[0]->sub_cast_name;   ?>{{ old('sub_cast_name') }}">
                                    @if ($errors->has('sub_cast_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('sub_cast_name') }}</div>
                                    @endif
                                 </div>
                                 <div class="col-md-6">
                                    <label for="text-input" class="col-form-label">Status<span>(*)</span></label>
                                    <select class="select" name="cast_status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ $getCast[0]->sub_cast_status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $getCast[0]->sub_cast_status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
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