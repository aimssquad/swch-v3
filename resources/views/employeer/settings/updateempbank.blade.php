@extends('employeer.include.app')
@section('title', 'Company Bank Edit')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Employee Bank</li>
             </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Edit Employee Bank</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="{{url('org-settings/update-emp-bank-details')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="bankid" value="{{ ((isset($bankdetails) && !empty($bankdetails))?$bankdetails[0]['id']:'')}}">
                           <div class="row form-group">
                               <div class="col-md-4">
                                   <label class="col-form-label">Enter Bank Name <span>(*)</span></label>
                                   <?php //print_r($MastersbankName); exit; 
                                   ?>
                                   <select name="bank_name" id="bank_name" class="select" required>
                                       @foreach($MastersbankName as $value):
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
                               <div class="col-md-4">
                                   <label class="col-form-label">Enter Branch Name <span>(*)</span></label>
                                   <input type="text" id="branch_name" required required name="branch_name" class="form-control" value="{{ (isset($bankdetails[0]['branch_name']) && !empty($bankdetails[0]['branch_name']))?$bankdetails[0]['branch_name']:old('branch_name')}}">
                                   @if ($errors->has('branch_name'))
                                   <div class="error" style="color:red;">{{ $errors->first('branch_name') }}</div>
                                   @endif
                               </div>
                          

                         
                               <div class="col-md-4">
                                   <label class="col-form-label">IFSC Code <span>(*)</span></label>
                                   <input type="text"   required id="ifsc_code" name="ifsc_code" class="form-control" value="{{ (isset($bankdetails[0]['ifsc_code']) && !empty($bankdetails[0]['ifsc_code']))?$bankdetails[0]['ifsc_code']:old('ifsc_code')}}">


                                   @if ($errors->has('ifsc_code'))
                                   <div class="error" style="color:red;">{{ $errors->first('ifsc_code') }}</div>
                                   @endif
                               </div>
                           </div>
                           <div class="row form-group">
                               <div class="col-md-4">
                                   <label class="col-form-label">Enter MICR Code </label>
                                   <input type="text"   id="swift_code" name="swift_code" class="form-control" value="{{ (isset($bankdetails[0]['swift_code']) && !empty($bankdetails[0]['swift_code']))?$bankdetails[0]['swift_code']:old('swift_code')}}">
                                   @if ($errors->has('swift_code'))
                                   <div class="error" style="color:red;">{{ $errors->first('swift_code') }}</div>
                                   @endif
                               </div>
                          
                               
                           <div class="col-md-4">
                                   <label class="col-form-label">Enter Account number <span>(*)</span></label>
                                   <select class="select" name="bank_status">
                                          
                                           <option value="active" <?php if($bankdetails['0']['bank_status']=='active'){?> selected="selected"<?php }?>>Active</option>
                                           <option value="inactive" <?php if($bankdetails['0']['bank_status']=='inactive'){?> selected="selected"<?php }?>>InActive</option>
                                           </select>
                                   @if ($errors->has('bank_status'))
                                   <div class="error" style="color:red;">{{ $errors->first('bank_status') }}</div>
                                   @endif
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