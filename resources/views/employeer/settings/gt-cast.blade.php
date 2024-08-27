@extends('employeer.include.app')
@section('title', 'Caste Edit')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Edit Caste</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="{{url('settings/updateCast')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                               <div class="row">
                                   <input type="hidden" name="id" value="<?php if (!empty($cast[0]->id)) { echo $cast[0]->id; } ?>">
                                   <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">Caste Name</label>
                                       <input type="text" class="form-control" required id="cast_name" name="cast_name" value="<?php if (!empty($cast[0]->cast_name)) { echo $cast[0]->cast_name; } ?>">
                                   </div>
                                   </div>
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label class="col-form-label">Status</label>
                                       <select class="select" name="cast_status" required>
                                            <option value="">Select Status</option>
                                            <option value="active" {{ $cast[0]->cast_status === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $cast[0]->cast_status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                       <!-- <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                           <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="status" /> -->
                                   </div>
                               </div>
                                   


                                       </div>
                                       </div>
                                       <div class="form-group">
                                        <br>
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