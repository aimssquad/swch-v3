@extends('employeer.include.app')
@section('title', 'Add New Employment Type')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Add New Employment Type</h4>
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
                              <form action="{{ url('org-settings/employee-type') }}" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <input type="hidden" name="id"  class="col-form-label" value="<?php if(!empty($employee_type->id)){ echo $employee_type->id;}?>">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">Employment Type</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" name="employee_type_name" value="<?php if(!empty($employee_type->employee_type_name)){ echo $employee_type->employee_type_name;}?>">
                                          @if ($errors->has('employee_type_name'))
                                          <div class="error" style="color:red;">{{ $errors->first('employee_type_name') }}</div>
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