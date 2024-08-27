@extends('employeer.include.app')
@section('title', 'Add New Pay Group')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Add New Pay Group</h4>
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
                                                             <label for="inputFloatingLabel" class="col-form-label">Pay Group</label>
                                                                   <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" id="grade_name" name="grade_name"     value="<?php  if(app('request')->input('id')){  echo $getGrade[0]->grade_name; } ?>{{ old('grade_name') }}">
                                                                   
                                                                   @if ($errors->has('grade_name'))
                                                               <div class="error" style="color:red;">{{ $errors->first('grade_name') }}</div>
                                                           @endif
                                                               </div>
                                                           </div>
                                                           <div class="col-md-4">
                                                             <div class="form-group">
                                                                 <label for="selectFloatingLabel" class="col-form-label">Select</label>
                                                                   <select class="select input-border-bottom" id="selectFloatingLabel" required="" name="grade_status">
                                                                       
                                                                       <option value="active"  <?php  if(app('request')->input('id')){ if($getGrade[0]->grade_status=='active'){ echo 'selected'; } } ?> >Active</option>
                                                                       <option value="inactive"  <?php  if(app('request')->input('id')){ if($getGrade[0]->grade_status=='inactive'){ echo 'selected'; } } ?> >Inactive</option>
                                                                       
                                                                   </select>
                                                                   
                                                               </div>
                                                           </div>
                                                           </div>
                                                           <br>
                                                           <div class="row form-group">
                                                           <div class="col-md-4">
                                                             <button class="btn btn-primary" type="submit">Submit</button>
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