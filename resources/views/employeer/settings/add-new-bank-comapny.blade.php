@extends('employeer.include.app')
@section('title', 'Company Bank Add')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Add Company Bank</li>
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Add Company Bank</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{url('org-settings/add-new-bank-details')}}" method="post" enctype="multipart/form-data">
                              {{csrf_field()}}
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">Bank Name</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="bankname" placeholder="Enter Your Company Name" required>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">Bank Branch</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="bankbranch" placeholder="Enter Your Branch Name" required>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">IFSC Code</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="ifsccode" placeholder="Enter Your IFSC Code" required>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">MICR Code</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="micrcode" placeholder="Enter Your MICR Code" required>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                       <select class="select" name="status" required>
                                          <option>Status</option>
                                          <option value="active">Active</option>
                                          <option value="inActive">inActive</option>
                                       </select>
                                       <!-- <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="status" > -->
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
@endsection