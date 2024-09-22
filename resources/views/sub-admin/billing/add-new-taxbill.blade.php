@extends('sub-admin.include.app')
@if(!empty($employee_type->id))
@section('title', 'Edit Tax Master')
@else
@section('title', 'Add Tax Master')
@endif
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li>
            @if(!empty($employee_type->id))
            <li class="breadcrumb-item active">Edit Tax Master</li>
            @else
            <li class="breadcrumb-item active">Add Tax Master</li>
            @endif
            
         </ul>
         <div class="card custom-card">
            <div class="card-header">
               @if(!empty($employee_type->id))
               <h4 class="card-title"><i class="far fa-user"></i>  Edit New Tax Master</h4>
               @else
               <h4 class="card-title"><i class="far fa-user"></i>  Add New Tax Master</h4>
               @endif
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form action="{{ url('superadmin/add-taxforbill') }}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id"  class="form-control" value="<?php if(!empty($employee_type->id)){ echo $employee_type->id;}?>">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group ">
                                    <label for="selectFloatingLabel3" class="col-form-label">Tax  Name</label>		
                                    <input type="text" id="name" name="name"  class="form-control " required   value="<?php if(!empty($employee_type->id)){ echo $employee_type->name;}?>">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group ">
                                    <label for="selectFloatingLabel3" class="col-form-label">Tax  Percentage</label>		
                                    <input type="number" id="percent" name="percent" required  class="form-control "   value="<?php if(!empty($employee_type->id)){ echo $employee_type->percent;}?>">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group ">
                                    <label for="selectFloatingLabel3" class="col-form-label">Status</label>
                                    <select id="selectFloatingLabel3"  class="select"   name="status" required >
                                       <option value="active" <?php if(!empty($employee_type->id)){  if(!empty($employee_type->status)){  if($employee_type->status == "active"){ ?> selected="selected" <?php } } }?>  >Active</option>
                                       <option value="inactive" <?php if(!empty($employee_type->id)){  if(!empty($employee_type->status)){ if($employee_type->status == "inactive"){ ?> selected="selected" <?php } } } ?>>Inactive</option>
                                    </select>
                                    </select>
                                 </div>
                              </div>
                           </div> 
                           <br>
                           <div class="row">
                                <div class="col-md-2 btn-up">
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