@extends('employeer.include.app')
@section('title', 'Edit File Devision')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Edit File Devision</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Edit File Devision</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               @if(Session::has('message'))
               <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
               @endif
               <form  method="post" action="{{url('file-management/fileManagment-division-update')}}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="col-form-label">Name</label>
                           <input type="hidden" value="<?php print_r($file_details->id) ?>" name="id">
                           <input type="text" class="form-control" name="name" value="<?php print_r($file_details->name) ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="col-form-label">Status</label>
                           <select class="select" name="status">
                              <option>Status</option>
                              <option value="active" <?php if($file_details->status=='active'){?> selected="selected"<?php }?>>Active</option>
                              <option value="inActive" <?php if($file_details->status=='inActive'){?> selected="selected"<?php }?>>InActive</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row form-group">
                     <div class="col-md-3">
                        <a href="#">
                        <button class="btn btn-primary" type="submit">Go</button></a>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
@endsection