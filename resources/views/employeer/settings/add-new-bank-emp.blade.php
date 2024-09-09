@extends('employeer.include.app')
@section('title', 'Employee Bank Add')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active"> Add Employee Bank</li>
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Add Employee Bank</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{url('org-settings/add-new-emp-bank-details')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">Bank Name <span style="color:red;">(*)</span></label>
                                        <select name="bank_name" id="bank_name" class="select" required>
                                            <option value="">Select Bank</option>
                                            @foreach($MastersbankName as $value)
                                            <option value="{{ $value->id }}" <?php if (!empty($bankdetails[0]['id'])) {
                                                if ($bankdetails[0]['bank_name'] == $value->id) {
                                                    echo "selected";
                                                }
                                                } ?>>
                                                {{ $value->master_bank_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">Bank Branch</label>
                                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="branch_name" placeholder="Enter Your Branch Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">IFSC Code</label>
                                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="ifsc_code" placeholder="Enter Your IFSC Code">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">MICR Code</label>
                                        <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="swift_code" placeholder="Enter Your MICR Code">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                        <select class="select" name="status">
                                            <option>Status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                        <!-- <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="status" > -->
                                        </div>
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