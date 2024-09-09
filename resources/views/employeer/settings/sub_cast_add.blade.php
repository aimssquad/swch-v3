@extends('employeer.include.app')
@section('title', 'Sub Caste Add')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Add Sub Cast</li>
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Add Sub Caste</h4>
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
                                   <div class="col-md-6">
                                      <label for="text-input" class=" col-form-label">Select Caste <span>(*)</span></label>
                                      <?php //print_r($getCast); exit; ?>
                                      <select class="select" name="cast_id" required>
                                         <option value='' selected disabled>Select</option>
                                         @foreach($getCast as $cast)
                                         <option value='{{ $cast->id }}'<?php if(app('request')->input('id')){ if( $getCast[0]->cast_name == $cast->cast_name ){ echo 'selected';}   }  ?> <?php if(old('cast_id') == $cast->cast_name){ echo "selected"; } ?> >{{ $cast->cast_name }}</option>
                                         @endforeach
                                      </select>
                                      @if ($errors->has('cast_id'))
                                      <div class="error" style="color:red;">{{ $errors->first('cast_id') }}</div>
                                      @endif
                                   </div>
                                   <div class="col-md-6">
                                      <label for="email-input" class=" col-form-label">Enter Sub Caste Name <span>(*)</span></label>
                                      <input type="text" id="designation_name" name="sub_cast_name" required  class="form-control" value="<?php if(app('request')->input('id')){  echo $getCast[0]->sub_cast_name;   }  ?>{{ old('sub_cast_name') }}">
                                      @if ($errors->has('sub_cast_name'))
                                      <div class="error" style="color:red;">{{ $errors->first('sub_cast_name') }}</div>
                                      @endif
                                   </div>
                                   <?php if(app('request')->input('id')){  ?>
                                   <div class="col-md-6">
                                      <label for="text-input" class=" col-form-label">Status<span>(*)</span></label>
                                      <select class="select" name="cast_status">
                                         <option value="active">Active</option>
                                         <option value="inactive">Inactive</option>
                                      </select>
                                   </div>
                                   <?php  } ?>
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