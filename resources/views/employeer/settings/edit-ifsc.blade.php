@extends('employeer.include.app')
@section('title', 'IFSC Edit')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit IFSC</li>
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Edit IFSC</h4>
                  </div>
                  <div class="card-body">
                     <div class="multisteps-form">
                        @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                        @endif
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                              <form action="{{url('org-settings/update-ifsc')}}" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <input type="hidden" value="<?php print_r($enteries->ifsc_no) ?>" name="ifsc_id">
                                          <label for="inputFloatingLabel" class="col-form-label">ifsc</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="ifsc_code" value="<?php print_r($enteries->ifsc_code) ?>" />
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">Bank Name</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="bank_name" value="<?php print_r($enteries->bank_name) ?>"/>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">Bank Address</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="bank_address" value="<?php print_r($enteries->bank_address) ?>"/>
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