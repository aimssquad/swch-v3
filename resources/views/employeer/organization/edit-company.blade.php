@extends('employeer.include.app')
@section('title', 'Edit Organisation Profile')
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('leave/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Edit Organisation Profile</li>
         </ul>
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title"><i class="far fa-user"></i>  Edit Organisation Profile</h4>
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form action="{{url('org-company-profile/editcompany')}}" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
                           {{csrf_field()}}
                           <input  type="hidden" class="form-control input-border-bottom" required=""  name="reg"  value="{{ $Roledata->reg}}">
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel" class="col-form-label">Organisation Name <span class="star">(*)</span></label>
                                    <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required=""  name="com_name"  value="{{ $Roledata->com_name}}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="selectFloatingLabel" class="col-form-label">Type of Organisation  <span class="star">(*)</label>
                                    <select class="select" id="selectFloatingLabel" required="" name="com_type">
                                       <option value="">&nbsp;</option>
                                       @foreach($type_or_master as $type_or)
                                       <option value="{{$type_or->name}}" <?php if ($Roledata->com_type == $type_or->name) {echo 'selected';}?>>{{$type_or->name}}</option>
                                       @endforeach
                                       <option value="others-type"  <?php if ($Roledata->com_type == 'others-type') {echo 'selected';}?>>Others</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 write-type" id="others-type"  <?php if ($Roledata->com_type == 'others-type') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="inputFloatingLabel8" class="col-form-label">Type Name</label>
                                    <input id="inputFloatingLabel8" type="text" class="form-control input-border-bottom"  name="others_type"  value="@if($Roledata->others_type){{  $Roledata->others_type }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel7" class="col-form-label"> Registration No.  </label>
                                    <input id="inputFloatingLabel7" type="text" class="form-control input-border-bottom"  name="com_reg"  value="@if($Roledata->com_reg){{  $Roledata->com_reg }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel7" class="col-form-label"> Country.  </label>
                                    <input id="inputFloatingLabel7" type="text" class="form-control input-border-bottom"  name="country"  value="@if($Roledata->country){{  $Roledata->country }}@endif">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel4" class="col-form-label">Contact No.  <span class="star">(*)</label>
                                    <input id="inputFloatingLabel4" type="text" class="form-control input-border-bottom" required="" name="p_no"  value="{{  $Roledata->p_no }}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel3" class="col-form-label">Login Email ID  <span class="star">(*)</label>
                                    <input id="inputFloatingLabel3" type="text" class="form-control " required=""readonly name="email"  value="{{  $Roledata->email }}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel3" class="col-form-label">Organisation Email ID  <span class="star">(*)</label>
                                    <input id="organ_email" type="email" class="form-control input-border-bottom" required="" name="organ_email"  value="{{  $Roledata->organ_email }}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel5" class="col-form-label">Website</label>
                                    <input id="inputFloatingLabel5" type="text" class="form-control input-border-bottom" name="website"  value="@if ($Roledata->website){{  $Roledata->website }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="land" class="col-form-label">Landline Number</label>
                                    <input id="land" type="text" class="form-control input-border-bottom" name="land"  value="@if ($Roledata->land){{  $Roledata->land }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="trad_name" class="col-form-label">Trading Name  <span class="star"></label>
                                    <input id="trad_name" type="text" class="form-control input-border-bottom"  name="trad_name"  value="@if($Roledata->trad_name){{  $Roledata->trad_name }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel9" class="col-form-label">Trading Period  <span class="star"></label>
                                    <select class="select" id="inputFloatingLabel9"  name="com_year">
                                       <option value="">&nbsp;</option>
                                       <option value="0 to 6 months"  <?php if ($Roledata->com_year == '0 to 6 months') {echo 'selected';}?>>0 to 6 months</option>
                                       <option value="Over 6 to 12 months"  <?php if ($Roledata->com_year == 'Over 6 to 12 months') {echo 'selected';}?>>Over 6 to 12 months</option>
                                       <option value="Over 12 to 18 months"  <?php if ($Roledata->com_year == 'Over 12 to 18 months') {echo 'selected';}?>>Over 12 to 18 months</option>
                                       <option value="Over 18 to 36 months"  <?php if ($Roledata->com_year == 'Over 18 to 36 months') {echo 'selected';}?>>Over 18 to 36 months</option>
                                       <option value="Over 36 months+"  <?php if ($Roledata->com_year == 'Over 36 months+') {echo 'selected';}?>>Over 36 months+</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="selectFloatingLabel1" class="col-form-label">Name of Sector  <span class="star"></label>
                                    <select class="select" id="selectFloatingLabel1" name="com_nat">
                                       <option value="">&nbsp;</option>
                                       @foreach($nat_or_master as $nat_or)
                                       <option value="{{$nat_or->name}}" <?php if ($Roledata->com_nat == $nat_or->name) {echo 'selected';}?>>{{$nat_or->name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 Other-service-activities" id="Other-service-activities" <?php if ($Roledata->com_nat == 'Other service activities') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <input id="inputFloatingLabel10" type="text" class="form-control input-border-bottom" name="nature_type"  value="@if($Roledata->nature_type){{  $Roledata->nature_type }}@endif">
                                    <label for="inputFloatingLabel10" class="col-form-label">Name Of Sector</label>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="trad_status" class="col-form-label">Have you changed Organisation /Trading  name in<br> last 5 years?    <span class="star">(*)</label>
                                    <select class="select" id="trad_status" required="" name="trad_status" onchange="trade_epmloyee(this.value);">
                                       >
                                       <option value="">&nbsp;</option>
                                       <option value="Yes" <?php if ($Roledata->trad_status == 'Yes') {echo 'selected';}?>>Yes</option>
                                       <option value="No" <?php if ($Roledata->trad_status == 'No') {echo 'selected';}?>>No</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-4 " id="criman_new" <?php if ($Roledata->trad_status == 'Yes') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="trad_other" class="col-form-label">Give Details </label>
                                    <input id="trad_other" type="text" class="form-control input-border-bottom" name="trad_other"  value="@if($Roledata->trad_other){{  $Roledata->trad_other }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="penlty_status" class="col-form-label">Did your organisation faced penalty (e.g., recruiting<br>  illegal employee) in last  3 years?    <span class="star">(*)</label>
                                    <select class="select" id="penlty_status" required="" name="penlty_status" onchange="penlty_epmloyee(this.value);">
                                       >
                                       <option value="">&nbsp;</option>
                                       <option value="Yes" <?php if ($Roledata->penlty_status == 'Yes') {echo 'selected';}?>>Yes</option>
                                       <option value="No" <?php if ($Roledata->penlty_status == 'No') {echo 'selected';}?>>No</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-4 " id="criman_penlty_new" <?php if ($Roledata->penlty_status == 'Yes') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="penlty_other" class="col-form-label">Give Details </label>
                                    <input id="penlty_other" type="text" class="form-control input-border-bottom" name="penlty_other"  value="@if($Roledata->penlty_other){{  $Roledata->penlty_other }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3 form-group">
                                 <label for="exampleFormControlFile1" class="col-form-label">Your Logo</label>
                                 <div class="d-flex flex-row mb-3">
                                    <div class="p-2">
                                       @if($Roledata->logo!='')
                                       <a href="#">	<img src="{{ asset($Roledata->logo) }}" height="50px" width="50px"/ ></a>
                                       @endif
                                    </div>
                                    <div class="p-2">
                                       <input type="file" class="form-control-file" id="exampleFormControlFile1"  name="image" >
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Authorised Person Details</h3>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="f_name" class="col-form-label">First Name  <span class="star">(*)</label>
                                    <input id="f_name" type="text" class="form-control input-border-bottom" required=""  name="f_name"  value="{{ $Roledata->f_name}}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="l_name" class="col-form-label">Last Name  <span class="star">(*)</label>
                                    <input id="l_name" type="text" class="form-control input-border-bottom" required="" name="l_name"  value="{{ $Roledata->l_name}}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="desig" class="col-form-label">Designation <span class="star">(*) </label>
                                    <input id="desig" type="text" class="form-control input-border-bottom" name="desig"  value="{{ $Roledata->desig}}" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="con_num" class="col-form-label">Phone No  <span class="star">(*)</label>
                                    <input id="con_num" type="text" class="form-control input-border-bottom" required="" name="con_num"  value="{{ $Roledata->con_num}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="authemail" class="col-form-label">Email  <span class="star">(*)</label>
                                    <input id="authemail" type="text" class="form-control input-border-bottom" required="" name="authemail"  value="{{ $Roledata->authemail}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="exampleFormControlFile1" class="mb-0">Proof Of Id</label>
                                    <div class="d-flex flex-row mb-3">
                                       <div class="p-2">	@if($Roledata->proof!='')
                                          <a href="{{ asset($Roledata->proof) }}" target="_blank">	<img src="{{ asset($Roledata->proof) }}" height="50px" width="50px"/></a>
                                          @endif
                                       </div>
                                       <div class="p-2"><input type="file" class="form-control-file" id="exampleFormControlFile1"   name="proof" ></div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="bank_status" class="col-form-label">Do you have a history of Criminal <br>conviction/Bankruptcy/Disqualification?    <span class="star">(*)</label>
                                    <select class="select" id="bank_status" required="" name="bank_status" onchange="bank_epmloyee(this.value);">
                                       >
                                       <option value="">&nbsp;</option>
                                       <option value="Yes" <?php if ($Roledata->bank_status == 'Yes') {echo 'selected';}?>>Yes</option>
                                       <option value="No" <?php if ($Roledata->bank_status == 'No') {echo 'selected';}?>>No</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6 " id="criman_bank_new" <?php if ($Roledata->bank_status == 'Yes') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="bank_other" class="col-form-label">Give Details </label>
                                    <input id="bank_other" type="text" class="form-control input-border-bottom" name="bank_other"  value="@if($Roledata->bank_other){{  $Roledata->bank_other }}@endif">
                                 </div>
                              </div>
                           </div>
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Key Contact </h3>
                           <div class="form-check">
                              <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="key_person"  id="filladdress" value="1" <?php if ($Roledata->key_person == '1') {echo 'checked';}?> >
                              <span class="form-check-sign">If Same As Authorised Person</span>
                              </label>
                           </div>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="key_f_name" class="col-form-label">First Name  <span class="star">(*)</label>
                                    <input id="key_f_name" type="text" class="form-control input-border-bottom" required=""  name="key_f_name"  value="{{ $Roledata->key_f_name}}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="key_f_lname" class="col-form-label">Last Name  <span class="star">(*)</label>
                                    <input id="key_f_lname" type="text" class="form-control input-border-bottom" required="" name="key_f_lname"  value="{{ $Roledata->key_f_lname}}">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="key_designation" class="col-form-label">Designation <span class="star">(*) </label>
                                    <input id="key_designation" type="text" class="form-control input-border-bottom" name="key_designation"  value="{{ $Roledata->key_designation}}" required>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="key_phone" class="col-form-label">Phone No  <span class="star">(*)</label>
                                    <input id="key_phone" type="text" class="form-control input-border-bottom" required="" name="key_phone"  value="{{ $Roledata->key_phone}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="key_email" class="col-form-label">Email  <span class="star">(*)</label>
                                    <input id="key_email" type="text" class="form-control input-border-bottom" required="" name="key_email"  value="{{ $Roledata->key_email}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="exampleFormControlFile1">Proof Of Id</label>
                                    <div class="d-flex flex-row mb-3">
                                       <div class="p-2">
                                          @if($Roledata->key_proof!='')
                                          <a href="{{ asset($Roledata->key_proof) }}" target="_blank">	<img src="{{ asset($Roledata->key_proof) }}" height="50px" width="50px"/></a>
                                          @endif
                                       </div>
                                       <div class="p-2"><input type="file" class="form-control-file" id="exampleFormControlFile1"   name="key_proof" ></div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="key_bank_status" class="col-form-label">Do you have a history of Criminal conviction<br>/Bankruptcy/Disqualification?    <span class="star">(*)</label>
                                    <select class="select" id="key_bank_status" required="" name="key_bank_status" onchange="key_bank_epmloyee(this.value);">
                                       >
                                       <option value="">&nbsp;</option>
                                       <option value="Yes" <?php if ($Roledata->key_bank_status == 'Yes') {echo 'selected';}?>>Yes</option>
                                       <option value="No" <?php if ($Roledata->key_bank_status == 'No') {echo 'selected';}?>>No</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6 " id="criman_key_bank_new" <?php if ($Roledata->key_bank_status == 'Yes') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="key_bank_other" class="col-form-label">Give Details </label>
                                    <input id="key_bank_other" type="text" class="form-control input-border-bottom" name="key_bank_other"  value="@if($Roledata->key_bank_other){{  $Roledata->key_bank_other }}@endif">
                                 </div>
                              </div>
                           </div>
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Level 1 User    </h3>
                           <div class="form-check">
                              <label class="form-check-label">
                              <input class="form-check-input" type="checkbox"  id="filladdresslevel"   name="level_person"  value="1" <?php if ($Roledata->level_person == '1') {echo 'checked';}?>>
                              <span class="form-check-sign">If Same As Authorised Person</span>
                              </label>
                           </div>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_f_name" class="col-form-label">First Name  <span class="star">(*)</label>
                                    <input id="level_f_name" type="text" class="form-control input-border-bottom" required=""  name="level_f_name"  value="{{ $Roledata->level_f_name}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_f_lname" class="col-form-label">Last Name  <span class="star">(*)</label>
                                    <input id="level_f_lname" type="text" class="form-control input-border-bottom" required="" name="level_f_lname"  value="{{ $Roledata->level_f_lname}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_designation" class="col-form-label">Designation <span class="star">(*) </label>
                                    <input id="level_designation" type="text" class="form-control input-border-bottom" name="level_designation"  value="{{ $Roledata->level_designation}}" required>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_phone" class="col-form-label">Phone No  <span class="star">(*)</label>
                                    <input id="level_phone" type="text" class="form-control input-border-bottom" required="" name="level_phone"  value="{{ $Roledata->level_phone}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_email" class="col-form-label">Email  <span class="star">(*)</label>
                                    <input id="level_email" type="text" class="form-control input-border-bottom" required="" name="level_email"  value="{{ $Roledata->level_email}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="exampleFormControlFile1" class="mb-0">Proof Of Id</label>
                                    @if($Roledata->level_proof!='')
                                    <a href="{{ asset($Roledata->level_proof) }}" target="_blank">	<img src="{{ asset($Roledata->level_proof) }}" height="50px" width="50px"/></a>
                                    @endif
                                    <input type="file" class="form-control-file" id="exampleFormControlFile1"   name="level_proof" >
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_bank_status" class="col-form-label">Do you have a history of Criminal conviction<br>/Bankruptcy/Disqualification?    <span class="star">(*)</label>
                                    <select class="select" id="level_bank_status" required="" name="level_bank_status" onchange="level_bank_epmloyee(this.value);">
                                       >
                                       <option value="">&nbsp;</option>
                                       <option value="Yes" <?php if ($Roledata->level_bank_status == 'Yes') {echo 'selected';}?>>Yes</option>
                                       <option value="No" <?php if ($Roledata->level_bank_status == 'No') {echo 'selected';}?>>No</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6 " id="criman_level_bank_new" <?php if ($Roledata->level_bank_status == 'Yes') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="level_bank_other" class="col-form-label">Give Details </label>
                                    <input id="level_bank_other" type="text" class="form-control input-border-bottom" name="level_bank_other"  value="@if($Roledata->level_bank_other){{  $Roledata->level_bank_other }}@endif">
                                 </div>
                              </div>
                           </div>
                           {{--  --}}
                           <br>
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Level 2 User</h3>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_f_name" class="col-form-label">First Name  </label>
                                    <input id="level_f_name" type="text" class="form-control input-border-bottom"   name="level2_f_name"  value="{{ $Roledata->level2_f_name}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_f_lname" class="col-form-label">Last Name  </label>
                                    <input id="level_f_lname" type="text" class="form-control input-border-bottom"  name="level2_f_lname"  value="{{ $Roledata->level2_f_lname}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_designation" class="col-form-label">Designation  </label>
                                    <input id="level_designation" type="text" class="form-control input-border-bottom" name="level2_designation"  value="{{ $Roledata->level2_designation}}" required>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_phone" class="col-form-label">Phone No  </label>
                                    <input id="level_phone" type="text" class="form-control input-border-bottom"  name="level2_phone"  value="{{ $Roledata->level2_phone}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_email" class="col-form-label">Email  </label>
                                    <input id="level_email" type="text" class="form-control input-border-bottom"  name="level2_email"  value="{{ $Roledata->level2_email}}">
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="exampleFormControlFile1" class="mb-0">Proof Of Id</label>
                                    @if($Roledata->level2_proof!='')
                                    <a href="{{ asset($Roledata->level2_proof) }}" target="_blank">	<img src="{{ asset($Roledata->level2_proof) }}" height="50px" width="50px"/></a>
                                    @endif
                                    <input type="file" class="form-control-file" id="exampleFormControlFile1"   name="level2_proof" >
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="level_bank_status" class="col-form-label">Do you have a history of Criminal conviction<br>/Bankruptcy/Disqualification?</label>
                                    <select class="select" id="level_bank_status"  name="level2_bank_status" onchange="level2_bank_epmloyee(this.value);">
                                       <option value="">&nbsp;</option>
                                       <option value="Yes" <?php if ($Roledata->level2_bank_status == 'Yes') {echo 'selected';}?>>Yes</option>
                                       <option value="No" <?php if ($Roledata->level2_bank_status == 'No') {echo 'selected';}?>>No</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6 " id="criman_level2_bank_new" <?php if ($Roledata->level2_bank_status == 'Yes') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="level_bank_other" class="col-form-label">Give Details </label>
                                    <input id="level2_bank_other" type="text" class="form-control input-border-bottom" name="level2_bank_other"  value="@if($Roledata->level2_bank_other){{  $Roledata->level2_bank_other }}@endif">
                                 </div>
                              </div>
                           </div>
                           {{--  --}}
                           
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Organisation Address</h3>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="zip" style="width:100%" class="col-form-label">Post Code  </label>
                                    <input id="zip" type="text" class="form-control input-border-bottom"  name="zip"  onchange="getcode();"  value="@if($Roledata->zip){{  $Roledata->zip }}@endif">
                                    <!--	<span><button style="padding: 3px 10px;float:right;" type="button" class="btn btn-default" ><i class="fas fa-search"></i></button></span>--></label>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="address" class="col-form-label">Address Line 1  </label>
                                    <input id="address" type="text" class="form-control input-border-bottom"  name="address"  value="@if($Roledata->address){{  $Roledata->address }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="address2" class="col-form-label">Address Line 2</label>
                                    <input id="address2" type="text" class="form-control input-border-bottom"  name="address2"  value="@if($Roledata->address2){{  $Roledata->address2 }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="road" class="col-form-label">Address Line 3  </label>
                                    <input id="road" type="text" class="form-control input-border-bottom"  name="road"  value="@if($Roledata->road){{  $Roledata->road }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="city" class="col-form-label">City / County</label>
                                    <input id="city" type="text" class="form-control input-border-bottom" name="city"  value="@if($Roledata->city){{  $Roledata->city }}@endif">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="country" class="col-form-label">Country </label>
                                    <select class="select" id="country"  name="country" onchange="countryfun(this.value);">
                                       @foreach($cuurenci_master as $desig)
                                       <option value="{{$desig->country_name}}" <?php if ($Roledata->country == '') {if ($desig->country_name == $desig->country_name) {echo 'selected';}}if ($Roledata->country == $desig->country_name) {echo 'selected';}?>>{{$desig->country_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px; ">Organisation Employee (According to latest RTI)</h3>
                           <div id="education_fieldbbs">
                              <?php $truplouii_id = 1;
                                 $countwmploor = count($employee_or_rs);?>
                              @if ($countwmploor!=0)
                              @foreach($employee_or_rs as $empuprotgans)
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group ">
                                       @if($truplouii_id==1)
                                       <label for="name<?=$truplouii_id?>" class="col-form-label">Full Name</label>
                                       @endif
                                       <input type="text" class="form-control "  value="{{ $empuprotgans->name}}"  id="name<?=$truplouii_id?>" name="name[]" @if($Roledata->licence=='yes')readonly  @endif
                                       >
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group ">
                                       @if($truplouii_id==1)
                                       <label for="department<?=$truplouii_id?>" class="col-form-label">Department</label>
                                       @endif
                                       <input type="text" class="form-control " value="{{ $empuprotgans->department}}"  id="department<?=$truplouii_id?>" name="department[]" 	@if($Roledata->licence=='yes')readonly  @endif >
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group ">
                                       @if($truplouii_id==1)
                                       <label for="job_type<?=$truplouii_id?>" class="col-form-label">Job Type</label>
                                       @endif
                                       <select class="select" id="job_type<?=$truplouii_id?>"  name="job_type[]" @if($Roledata->licence=='yes')readonly disabled  @endif  >
                                       <option value="">&nbsp;</option>
                                       <option value="FULL TIME"  <?php if ($empuprotgans->job_type == 'FULL TIME') {echo 'selected';}?> >FULL TIME</option>
                                       <option value="PART TIME"  <?php if ($empuprotgans->job_type == 'PART TIME') {echo 'selected';}?> >PART TIME</option>
                                       <option value="CONTRACTUAL"  <?php if ($empuprotgans->job_type == 'CONTRACTUAL') {echo 'selected';}?> >CONTRACTUAL</option>
                                       <option value="SELF EMPLOYED"  <?php if ($empuprotgans->job_type == 'SELF EMPLOYED') {echo 'selected';}?> >SELF EMPLOYED</option>
                                       <option value="FREELANCER"  <?php if ($empuprotgans->job_type == 'FREELANCER') {echo 'selected';}?> >FREELANCER</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                       @if($truplouii_id==1)
                                       <label for="designation<?=$truplouii_id?>" class="col-form-label">Job Title</label>
                                       @endif
                                       <input type="text" class="form-control " value="{{ $empuprotgans->designation}}" id="designation<?=$truplouii_id?>" name="designation[]"  @if($Roledata->licence=='yes')readonly  @endif  >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group ">
                                       @if($truplouii_id==1)
                                       <label for="immigration<?=$truplouii_id?>" class="col-form-label">Immigration Status
                                       </label>
                                       @endif
                                       <select class="select" id="immigration<?=$truplouii_id?>"  name="immigration[]"  @if($Roledata->licence=='yes')readonly disabled  @endif >
                                       <option value="">&nbsp;</option>
                                       <option value="British Citizen"  <?php if ($empuprotgans->immigration == 'British Citizen') {echo 'selected';}?>  >British Citizen</option>
                                       <option value="Indefinite Leave to Remain" <?php if ($empuprotgans->immigration == 'Indefinite Leave to Remain') {echo 'selected';}?> >Indefinite Leave to Remain</option>
                                       <option value="EU Citizenship" <?php if ($empuprotgans->immigration == 'EU Citizenship') {echo 'selected';}?> >EU Citizenship</option>
                                       <option value="Leave to Remain (Student Visa)"  <?php if ($empuprotgans->immigration == 'Leave to Remain (Student Visa)') {echo 'selected';}?>>Leave to Remain (Student Visa)</option>
                                       <option value="Leave to Remain (Spouse Visa)" <?php if ($empuprotgans->immigration == 'Leave to Remain (Spouse Visa)') {echo 'selected';}?> >Leave to Remain (Spouse Visa)</option>
                                       <option value="Leave to Remain (Human Right Visa)" <?php if ($empuprotgans->immigration == 'Leave to Remain (Human Right Visa)') {echo 'selected';}?> >Leave to Remain (Human Right Visa)</option>
                                       <option value="Other Leave to Remain" <?php if ($empuprotgans->immigration == 'Other Leave to Remain') {echo 'selected';}?> >Other Leave to Remain </option>
                                       </select>
                                    </div>
                                 </div>
                                 @if ($truplouii_id==($countwmploor))
                                 @if($Roledata->licence=='no')
                                 <div class="col-md-4">
                                    <div class="input-group-btn btn-up mt-0">
                                       <button class="btn btn-success" type="button"  onclick="education_fieldhhs(<?=$countwmploor;?>);"> <i class="fas fa-plus"></i> </button>
                                    </div>
                                 </div>
                                 @endif
                                 @endif
                              </div>
                              @if ($truplouii_id!=($countwmploor))
                              @endif
                              <?php $truplouii_id++;?>
                              @endforeach
                              @endif
                              @if ($countwmploor==0)
                              <div class="row">
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="name1" class="col-form-label">Full Name</label>
                                       <input type="text" class="form-control input-border-bottom" id="name1" name="name[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                       <label for="department1" class="col-form-label">Department</label>
                                       <input type="text" class="form-control input-border-bottom" id="department1" name="department[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                       <label for="job_type1" class="col-form-label">Job Type</label>
                                       <select class="select" id="job_type1"  name="job_type[]" >
                                          <option value="">&nbsp;</option>
                                          <option value="FULL TIME"   >FULL TIME</option>
                                          <option value="PART TIME"   >PART TIME</option>
                                          <option value="CONTRACTUAL"   >CONTRACTUAL</option>
                                          <option value="SELF EMPLOYED"  >SELF EMPLOYED</option>
                                          <option value="FREELANCER"   >FREELANCER</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <label for="designation1" class="col-form-label">Job Title</label>
                                    <div class="form-group " required>
                                       <input type="text" class="form-control input-border-bottom" id="designation1" name="designation[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group" >
                                       <label for="immigration1" class="col-form-label">Immigration Status</label>
                                       <select class="select" id="immigration1"  name="immigration[]" >
                                          <option value="">&nbsp;</option>
                                          <option value="British Citizen"  >British Citizen</option>
                                          <option value="Indefinite Leave to Remain">Indefinite Leave to Remain</option>
                                          <option value="EU Citizenship" >EU Citizenship</option>
                                          <option value="Leave to Remain (Student Visa)" >Leave to Remain (Student Visa)</option>
                                          <option value="Leave to Remain (Spouse Visa)" >Leave to Remain (Spouse Visa)</option>
                                          <option value="Leave to Remain (Human Right Visa)" >Leave to Remain (Human Right Visa)</option>
                                          <option value="Other Leave to Remain" >Other Leave to Remain </option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-3 pt-3">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="name2" name="name[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2 pt-3">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="department2" name="department[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2 pt-3">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="job_type2"  name="job_type[]" >
                                          <option value="">&nbsp;</option>
                                          <option value="FULL TIME"   >FULL TIME</option>
                                          <option value="PART TIME"   >PART TIME</option>
                                          <option value="CONTRACTUAL"   >CONTRACTUAL</option>
                                          <option value="SELF EMPLOYED"  >SELF EMPLOYED</option>
                                          <option value="FREELANCER"   >FREELANCER</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-2 pt-3">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="designation2" name="designation[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-3 pt-3">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="immigration2"  name="immigration[]" >
                                          <option value="">&nbsp;</option>
                                          <option value="British Citizen"  >British Citizen</option>
                                          <option value="Indefinite Leave to Remain">Indefinite Leave to Remain</option>
                                          <option value="EU Citizenship" >EU Citizenship</option>
                                          <option value="Leave to Remain (Student Visa)" >Leave to Remain (Student Visa)</option>
                                          <option value="Leave to Remain (Spouse Visa)" >Leave to Remain (Spouse Visa)</option>
                                          <option value="Leave to Remain (Human Right Visa)" >Leave to Remain (Human Right Visa)</option>
                                          <option value="Other Leave to Remain" >Other Leave to Remain </option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-3 pt-3">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="name3" name="name[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2 pt-3">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="department3" name="department[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2 pt-3">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="job_type3"  name="job_type[]" >
                                          <option value="">&nbsp;</option>
                                          <option value="FULL TIME"   >FULL TIME</option>
                                          <option value="PART TIME"   >PART TIME</option>
                                          <option value="CONTRACTUAL"   >CONTRACTUAL</option>
                                          <option value="SELF EMPLOYED"  >SELF EMPLOYED</option>
                                          <option value="FREELANCER"   >FREELANCER</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-2 pt-3">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="designation3" name="designation[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-3 pt-3">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="immigration3"  name="immigration[]" >
                                          <option value="">&nbsp;</option>
                                          <option value="British Citizen"  >British Citizen</option>
                                          <option value="Indefinite Leave to Remain">Indefinite Leave to Remain</option>
                                          <option value="EU Citizenship" >EU Citizenship</option>
                                          <option value="Leave to Remain (Student Visa)" >Leave to Remain (Student Visa)</option>
                                          <option value="Leave to Remain (Spouse Visa)" >Leave to Remain (Spouse Visa)</option>
                                          <option value="Leave to Remain (Human Right Visa)" >Leave to Remain (Human Right Visa)</option>
                                          <option value="Other Leave to Remain" >Other Leave to Remain </option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-12 pt-4 text-end">
                                    <div class="input-group-btn btn-up mt-0">
                                       <button class="btn btn-success" type="button"  onclick="education_fieldhhs(3);"> <i class="fas fa-plus"></i> </button>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Trading Hours</h3>
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="day2" class="col-form-label">Day</label>
                                    <input type="text" class="form-control " id="day2"  value="Monday" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="mon_status" class="col-form-label">Status</label>
                                    <select class="select" id="mon_status"  name="mon_status" onchange="monst(this.value);" >
                                       <option value="">&nbsp;</option>
                                       <option value="open" <?php if ($Roledata->mon_status == 'open') {echo 'selected';}?>  >Open</option>
                                       <option value="closed"    <?php if ($Roledata->mon_status == 'closed') {echo 'selected';}?>>Closed</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3" id="mon_status_open" <?php if ($Roledata->mon_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="mon_time" class="col-form-label">Opening Time</label>
                                    <select class="select" id="mon_time"  name="mon_time" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->mon_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->mon_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3"  id="mon_close_open" <?php if ($Roledata->mon_status == 'open') {?>style="display:none;"  <?php } else {?>  style="display:block;"<?php }?>>
                                 <div class="form-group">
                                    <label for="" class="col-form-label">Opening Time</label>
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 " id="mon_status_close" <?php if ($Roledata->mon_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <label for="mon_close" class="col-form-label">Closing Time</label>
                                    <select class="select" id="mon_close"  name="mon_close" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->mon_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->mon_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3"  id="mon_close_close" <?php if ($Roledata->mon_status == 'open') {?>style="display:none;"  <?php } else {?> style="display:block;" <?php }?>>
                                 <div class="form-group">
                                    <label for="" class="col-form-label">Closing Time</label>
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <input type="text" class="form-control " id="day3"  value="Tuesday" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <select class="select" id="tue_status"  name="tue_status" onchange="tuest(this.value);" >
                                       <option value="">&nbsp;</option>
                                       <option value="open" <?php if ($Roledata->tue_status == 'open') {echo 'selected';}?>  >Open</option>
                                       <option value="closed"    <?php if ($Roledata->tue_status == 'closed') {echo 'selected';}?>>Closed</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3" id="tue_status_open" <?php if ($Roledata->tue_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <select class="select" id="tue_time"  name="tue_time" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->tue_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->tue_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="tue_close_open" <?php if ($Roledata->tue_status == 'open') {?>  style="display:none;"<?php } else {?> style="display:block;" <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3 " id="tue_status_close" <?php if ($Roledata->tue_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <select class="select" id="tue_close"  name="tue_close" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->tue_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->tue_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="tue_close_close" <?php if ($Roledata->tue_status == 'open') {?>  style="display:none;"<?php } else {?>  style="display:block;"<?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <input type="text" class="form-control " id="day3"  value="Wednesday" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3">
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="wed_status"  name="wed_status" onchange="wedst(this.value);" >
                                       <option value="">&nbsp;</option>
                                       <option value="open" <?php if ($Roledata->wed_status == 'open') {echo 'selected';}?>  >Open</option>
                                       <option value="closed"    <?php if ($Roledata->wed_status == 'closed') {echo 'selected';}?>>Closed</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3" id="wed_status_open" <?php if ($Roledata->wed_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="wed_time"  name="wed_time" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->wed_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->wed_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="wed_close_open" <?php if ($Roledata->wed_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3 " id="wed_status_close" <?php if ($Roledata->wed_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="wed_close"  name="wed_close" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->wed_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->wed_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="wed_close_close" <?php if ($Roledata->wed_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <input type="text" class="form-control " id="day3"  value="Thursday" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3">
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="thu_status"  name="thu_status" onchange="thust(this.value);" >
                                       <option value="">&nbsp;</option>
                                       <option value="open" <?php if ($Roledata->thu_status == 'open') {echo 'selected';}?>  >Open</option>
                                       <option value="closed"    <?php if ($Roledata->thu_status == 'closed') {echo 'selected';}?>>Closed</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3" id="thu_status_open" <?php if ($Roledata->thu_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="thu_time"  name="thu_time" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->thu_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->thu_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="thu_close_open"  <?php if ($Roledata->thu_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3 " id="thu_status_close" <?php if ($Roledata->thu_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="thu_close"  name="thu_close" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->thu_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->thu_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="thu_close_close" <?php if ($Roledata->thu_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <input type="text" class="form-control " id="day3"  value="Friday" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3">
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="fri_status"  name="fri_status" onchange="frist(this.value);" >
                                       <option value="">&nbsp;</option>
                                       <option value="open" <?php if ($Roledata->fri_status == 'open') {echo 'selected';}?>  >Open</option>
                                       <option value="closed"    <?php if ($Roledata->fri_status == 'closed') {echo 'selected';}?>>Closed</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3" id="fri_status_open" <?php if ($Roledata->fri_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="fri_time"  name="fri_time" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->fri_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->fri_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="fri_close_open" <?php if ($Roledata->fri_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3 " id="fri_status_close" <?php if ($Roledata->fri_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="fri_close"  name="fri_close" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->fri_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->fri_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="fri_close_close" <?php if ($Roledata->fri_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <input type="text" class="form-control " id="day3"  value="Saturday" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3">
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="sat_status"  name="sat_status" onchange="satst(this.value);" >
                                       <option value="">&nbsp;</option>
                                       <option value="open" <?php if ($Roledata->sat_status == 'open') {echo 'selected';}?>  >Open</option>
                                       <option value="closed"    <?php if ($Roledata->sat_status == 'closed') {echo 'selected';}?>>Closed</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3" id="sat_status_open" <?php if ($Roledata->sat_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group form-floating-label">
                                    <select class="select" id="sat_time"  name="sat_time" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sat_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sat_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="sat_close_open" <?php if ($Roledata->sat_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3 " id="sat_status_close" <?php if ($Roledata->sat_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <select class="select" id="sat_close"  name="sat_close" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sat_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sat_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="sat_close_close" <?php if ($Roledata->sat_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <input type="text" class="form-control " id="day1"  value="Sunday" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3">
                                 <div class="form-group">
                                    <select class="select" id="sun_status"  name="sun_status" onchange="sunst(this.value);" >
                                       <option value="">&nbsp;</option>
                                       <option value="open" <?php if ($Roledata->sun_status == 'open') {echo 'selected';}?>  >Open</option>
                                       <option value="closed"    <?php if ($Roledata->sun_status == 'closed') {echo 'selected';}?>>Closed</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3" id="sun_status_open" <?php if ($Roledata->sun_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <select class="select" id="sun_time"  name="sun_time" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sun_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sun_time == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="sun_close_open" <?php if ($Roledata->sun_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 " id="sun_status_close" <?php if ($Roledata->sun_status == 'open') {?> style="display:block;" <?php } else {?> style="display:none;" <?php }?>>
                                 <div class="form-group">
                                    <select class="select" id="sun_close"  name="sun_close" >
                                       <option value="">&nbsp;</option>
                                       <?php $starttime1 = '01:00'; // your start time
                                          $endtime1 = '18:00'; // End time
                                          $duration1 = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time1 = strtotime($starttime1); //change to strtotime
                                          $end_time1 = strtotime($endtime1); //change to strtotime
                                          
                                          $add_mins1 = $duration1 * 60;
                                          while ($start_time1 <= $end_time1) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time1);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sun_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time1 += $add_mins1; // to check endtie=me
                                          
                                          }
                                          $starttime = '18:30'; // your start time
                                          $endtime = '24:00'; // End time
                                          $duration = '30'; // split by 30 mins
                                          
                                          $array_of_time = array();
                                          $start_time = strtotime($starttime); //change to strtotime
                                          $end_time = strtotime($endtime); //change to strtotime
                                          
                                          $add_mins = $duration * 60;
                                          
                                          while ($start_time <= $end_time) // loop between time
                                          {
                                          
                                          $time = date("H:i", $start_time);
                                          ?>
                                       <option value="<?=$time;?>"    <?php if ($Roledata->sun_close == $time) {echo 'selected';}?>><?=$time;?></option>
                                       <?php
                                          $start_time += $add_mins; // to check endtie=me
                                          
                                          }
                                          
                                          ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 pt-3"  id="sun_close_close" <?php if ($Roledata->sun_status == 'open') {?> style="display:none;"<?php } else {?> style="display:block;"  <?php }?>>
                                 <div class="form-group">
                                    <input type="text" class="form-control " id=""  value="closed" readonly>
                                 </div>
                              </div>
                           </div>
                           <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Upload Documents</h3>
                           <div id="education_fields">
                              <?php $trupload_id = 0;
                                 $countpayuppas = count($employee_upload_rs);?>
                              @if ($countpayuppas!=0)
                              @foreach($employee_upload_rs as $empuprs)
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       @if($trupload_id==0)
                                       <label class="col-form-label">Type of Document  </label>
                                       @endif
                                       <select class="form-control input-border-bottom" id="doc_type_{{ $empuprs->id}}" required="" name="type_doc_{{ $empuprs->id}}" onchange="checktype('{{ $empuprs->id }}');">
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  <?php if ($empuprs->type_doc == 'PAYEE And Account Reference Letter From HMRC') {echo 'selected';}?>>PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant"  <?php if ($empuprs->type_doc == 'Latest RTI from Accountant') {echo 'selected';}?>>Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  <?php if ($empuprs->type_doc == 'Employer Liability Insurance Certificate') {echo 'selected';}?>>Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  <?php if ($empuprs->type_doc == 'Proof of Business Premises (Tenancy Agreement)') {echo 'selected';}?>>Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  <?php if ($empuprs->type_doc == 'Copy Of Lease Or Freehold Property') {echo 'selected';}?>>Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month" <?php if ($empuprs->type_doc == 'Business Bank statement for 1 Month') {echo 'selected';}?>   >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month" <?php if ($empuprs->type_doc == 'Business Bank statement for 2 Month') {echo 'selected';}?>   >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month"  <?php if ($empuprs->type_doc == 'Business Bank statement for 3 Month') {echo 'selected';}?>>Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"      <?php if ($empuprs->type_doc == 'SIGNED Annual account (if the business is over 18 months old)') {echo 'selected';}?>>SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  <?php if ($empuprs->type_doc == 'VAT Certificate (if registered)') {echo 'selected';}?>>VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"  <?php if ($empuprs->type_doc == 'Copy of Health and safety star Rating (Applicable for food business only)') {echo 'selected';}?> >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  <?php if ($empuprs->type_doc == 'Registered Business License or Certificate') {echo 'selected';}?>>Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  <?php if ($empuprs->type_doc == 'Franchise Agreement') {echo 'selected';}?>>Franchise Agreement</option>
                                          <option value="Governing Body Registration"  <?php if ($empuprs->type_doc == 'Governing Body Registration') {echo 'selected';}?>>Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  <?php if ($empuprs->type_doc == 'Copy Of Health & Safety Star Rating') {echo 'selected';}?>>Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  <?php if ($empuprs->type_doc == 'Audited Annual Account (if you have)') {echo 'selected';}?>>Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  <?php if ($empuprs->type_doc == 'Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA') {echo 'selected';}?>  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document"  <?php if ($empuprs->type_doc == 'Others Document') {echo 'selected';}?>>Others Document</option>
                                       </select>
                                       <input  type="hidden" class="form-control input-border-bottom" required="" name="id_up_doc[]" value="{{ $empuprs->id}}">
                                    </div>
                                 </div>
                                 @if($empuprs->type_doc=='Others Document')
                                 <div class="col-md-4" id="other_doc_{{ $empuprs->id}}">
                                    <div class="form-group">
                                       @if($trupload_id==0)
                                       <label for="other_doc_input_{{ $empuprs->id}}">Other Doc.Type</label>
                                       @endif
                                       <input type="text" class="form-control input-border-bottom" id="other_doc_input_{{ $empuprs->id}}" name="other_doc_{{ $empuprs->id}}" value="{{$empuprs->other_txt}}">
                                    </div>
                                 </div>
                                 @endif
                                 <div class="col-md-4" style="display: none;" id="other_doc_{{ $empuprs->id}}">
                                    <div class="form-group ">
                                       @if($trupload_id==0)
                                       <label for="other_doc_input_{{ $empuprs->id}}">Other Doc.Type</label>
                                       @endif
                                       <input type="text" class="form-control input-border-bottom" id="other_doc_input_{{ $empuprs->id}}" name="other_doc_{{ $empuprs->id}}" disabled>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       @if($trupload_id==0)
                                       <label for="other_doc_input_{{ $empuprs->id}}" class="d-block mb-3">Upload Document  </label>
                                       @endif
                                       @if($empuprs->docu_nat!='')
                                       <a href="{{ asset('public/'.$empuprs->docu_nat) }}" target="_blank" download  style="text-align: right;
                                          float: right;
                                          position: relative;
                                          top: 23px;
                                          right: 72px;"/><i class="fas fa-download"></i></a>
                                       @endif
                                       @if($empuprs->type_doc=='VAT Certificate (if registered)')
                                       <a href="{{ asset('public/assets/img/VAT Certificate (if registered).pdf')}}" class="sampleupload" target="_blank">Sample Document</a>
                                       @endif
                                       @if($empuprs->type_doc=='Employer Liability Insurance Certificate')
                                       <a href="{{ asset('public/assets/img/Employer Liability Insurance Certificate.pdf')}}" class="sampleupload" target="_blank">Sample Document</a>
                                       @endif
                                       @if($empuprs->type_doc=='PAYEE And Account Reference Letter From HMRC')
                                       <a href="{{ asset('public/assets/img/PAYEE And Account Reference Letter From HMRC.pdf')}}" class="sampleupload" target="_blank">Sample Document</a>
                                       @endif
                                       <input type="file" class="form-control-file" id="docu_nat_{{ $empuprs->id}}" name="docu_nat_{{ $empuprs->id}}"  onchange="Filevalidation({{ $empuprs->id}})">
                                    </div>
                                    @if($trupload_id==0)
                                    <span>*Document Size not more than 2 MB</span>
                                    @endif
                                 </div>
                                 <?php $trupload_id++;?>
                                 @if ($trupload_id==($countpayuppas))
                                 <div class="col-md-2">
                                    <div class="input-group-btn btn-up mt-0">
                                       <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button>
                                    </div>
                                 </div>
                                 @endif
                              </div>
                              @endforeach
                              @endif
                              @if ($countpayuppas==0)
                              <?php $trupload_id = 0;?>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-form-label">Type of Document  </label>
                                       <select class="select" id="d_type1" required="" name="type_doc[]" onchange="checkdoctype(1);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC" selected >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc1">
                                    <div class="form-group form-floating-label">
                                       <label for="newdoc_1">Other Doc.Type</label>
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_1" name="other_doc[]">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="exampleFormControlFile1">Upload Document  </label>
                                       <a style="margin-left:5px;" href="{{ asset('public/assets/img/PAYEE And Account Reference Letter From HMRC.pdf')}}" target="_blank"   class="sampleupload">Sample Document</a>
                                       <input type="file" class="form-control-file"   name="docu_nat[]"   id="docu_nat_new_1" onchange="Filevalidationnew(1)">
                                    </div>
                                    <span>*Document Size not more than 2 MB</span>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="d_type10" required="" name="type_doc[]" onchange="checkdoctype(10);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" selected>Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc10">
                                    <div class="form-group">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_10" name="other_doc[]">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file"   name="docu_nat[]"   id="docu_nat_new_10" onchange="Filevalidationnew(10)">
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <select class="select" id="d_type11" required="" name="type_doc[]" onchange="checkdoctype(11);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  selected>Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc11">
                                    <div class="form-group">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_11" name="other_doc[]">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <a href="{{ asset('public/assets/img/Employer Liability Insurance Certificate.pdf')}}" target="_blank"        class="sampleupload">Sample Document</a>
                                       <input type="file" class="form-control-file"   name="docu_nat[]"   id="docu_nat_new_11" onchange="Filevalidationnew(11)">
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <select class="select" id="d_type2" required="" name="type_doc[]" onchange="checkdoctype(2);" required>
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)" selected >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc2">
                                    <div class="form-group">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_2" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_2" onchange="Filevalidationnew(2)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <select class="select" id="d_type3" required="" name="type_doc[]" onchange="checkdoctype(3);" required>
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property" selected >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc3">
                                    <div class="form-group">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_3" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_3" onchange="Filevalidationnew(3)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <select class="select" id="d_type4" required="" name="type_doc[]" onchange="checkdoctype(4);" required>
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"  selected  >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc4">
                                    <div class="form-group">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_4" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_4" onchange="Filevalidationnew(4)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <select class="select" id="d_type5"  name="type_doc[]" onchange="checkdoctype(5);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  selected>Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc5">
                                    <div class="form-group">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_5" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_5" onchange="Filevalidationnew(5)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <select class="select" id="d_type6"  name="type_doc[]" onchange="checkdoctype(6);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month" selected >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc6">
                                    <div class="form-group">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_6" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_6" onchange="Filevalidationnew(6)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <select class="select" id="d_type7"  name="type_doc[]" onchange="checkdoctype(7);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month"  >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)" selected    >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc7">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_7" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_7" onchange="Filevalidationnew(7)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="d_type8"  name="type_doc[]" onchange="checkdoctype(8);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month"  >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)" selected >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc8">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_8" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <a href="{{ asset('public/assets/img/VAT Certificate (if registered).pdf')}}" target="_blank" class="sampleupload">Sample Document</a>
                                       <input type="file" class="form-control-file" id="docu_nat_new_8" onchange="Filevalidationnew(8)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="d_type9"  name="type_doc[]" onchange="checkdoctype(9);" >
                                          <option value="">&nbsp;</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month"  >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"   selected >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4" style="display: none;" id="other_doc9">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_9" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_9" onchange="Filevalidationnew(9)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group form-floating-label">
                                       <select class="select" id="d_type12"  name="type_doc[]" onchange="checkdoctype(12);">
                                          <option value="">Select Option</option>
                                          <option value="PAYEE And Account Reference Letter From HMRC"  >PAYEE And Account Reference Letter From HMRC</option>
                                          <option  value="Latest RTI from Accountant" >Latest RTI from Accountant</option>
                                          <option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option>
                                          <option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option>
                                          <option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option>
                                          <option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option>
                                          <option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option>
                                          <option value="Business Bank statement for 3 Month"  >Business Bank statement for 3 Month</option>
                                          <option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option>
                                          <option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option>
                                          <option value="Copy of Health and safety star Rating (Applicable for food business only)"    >Copy of Health and safety star Rating (Applicable for food business only)</option>
                                          <option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option>
                                          <option value="Franchise Agreement"  >Franchise Agreement</option>
                                          <option value="Governing Body Registration" >Governing Body Registration</option>
                                          <option value="Copy Of Health & Safety Star Rating"  >Copy Of Health & Safety Star Rating</option>
                                          <option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option>
                                          <option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  selected>Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option>
                                          <option value="Others Document" >Others Document</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-2" style="display: none;" id="other_doc12">
                                    <div class="form-group form-floating-label">
                                       <input type="text" class="form-control input-border-bottom" id="newdoc_12" name="other_doc[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                       <input type="file" class="form-control-file" id="docu_nat_new_12" onchange="Filevalidationnew(12)"  name="docu_nat[]" >
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div class="input-group-btn btn-up mt-0">
                                       <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>
                           @if(Session::get('admin_userp_user_type') == 'user')
                           <div class="row form-group">
                              <input type="hidden" name="status" value="{{$Roledata->status}}">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="last_date" class="col-form-label" style="padding-top:0;">Verification  Date</label>
                                    <input id="verified_on" type="date" class="form-control input-border-bottom"  name="verified_on"  value="<?php if (!empty($Roledata->verified_on)) {?>{{$Roledata->verified_on}}<?php }?>" <?php if ($Roledata->verify == "approved"){?> readonly <?php } ?> >
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="verify" class="col-form-label">Verification</label>
                                    <?php if (!empty($Roledata->status)) {if ($Roledata->status == "inactive") {?>
                                    <input type="text" class="form-control "   readonly value="@if($Roledata->verify=='approved')VERIFIED @else NOT VERIFIED @endif" >
                                    <input type="hidden" class="form-control "  name="verify"  value="{{$Roledata->verify}}" >
                                    <?php } else {
                                       ?>
                                    <select id="verify"  class="form-control "   name="verify" <?php if (!empty($Roledata->status)) {if ($Roledata->status == "inactive") {?> readonly <?php }}?>
                                       >
                                       <option value="approved" <?php if (!empty($Roledata->verify)) {if ($Roledata->verify == "approved") {?> selected="selected" <?php }}?>  >VERIFIED</option>
                                       <option value="not approved" <?php if (!empty($Roledata->verify)) {if ($Roledata->verify == "not approved") {?> selected="selected" <?php }}?>>NOT VERIFIED</option>
                                    </select>
                                    <?php
                                       }}?>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group ">
                                    <label for="licence" class="col-form-label">License Applied <span class="star">(#)</span></label>
                                    <!-- || $application_status_tareq->last_date==NULL -->
                                    @if ($Roledata->status == "inactive" || $Roledata->verify == "not approved" )
                                    <input type="text" class="form-control "  name="licence_o" readonly value="@if($Roledata->licence=='yes') APPLIED @else NOT APPLIED @endif" >
                                    <input type="hidden" class="form-control "   name="licence"  value="{{$Roledata->licence}}" >
                                    @else
                                    <!-- <select id="licence"  class="form-control "   name="licence" <?php //if ($Roledata->status == "inactive" || $Roledata->verify == "not approved") {?> readonly <?php //}?>>
                                       <option value="yes" <?php //if (!empty($Roledata->licence)) {if ($Roledata->licence == "yes") {?> selected="selected" <?php //}}?>  >APPLIED</option>
                                       <option value="no" <?php //if (!empty($Roledata->licence)) {if ($Roledata->licence == "no") {?> selected="selected" <?php //}}?>>NOT APPLIED</option>
                                       </select> -->
                                    <input type="text" class="form-control "  name="licence_o" readonly value="@if($Roledata->licence=='yes') APPLIED @else NOT APPLIED @endif" >
                                    <input type="hidden" class="form-control "   name="licence"  value="{{$Roledata->licence}}" >
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group ">
                                    <label for="licence" class="col-form-label">Type</label>
                                    @if ($Roledata->status == "inactive" || $Roledata->verify == "not approved")
                                    <input type="text" class="form-control "  name="license_type_o" readonly value="NA" >
                                    <input type="hidden" class="form-control "   name="license_type"  value="{{$Roledata->license_type}}" >
                                    @else
                                    <select id="license_type"  class="form-control "   name="license_type" @if($Roledata->status == "inactive" || $Roledata->verify == "not approved")  readonly @else required @endif >
                                    <option value=""></option>
                                    <option value="Internal" <?php if (!empty($Roledata->license_type)) {if ($Roledata->license_type == "Internal") {?> selected="selected" <?php }}?>  >Internal</option>
                                    <option value="External" <?php if (!empty($Roledata->license_type)) {if ($Roledata->license_type == "External") {?> selected="selected" <?php }}?>>External</option>
                                    </select>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           @else
                           <input type="hidden" name="licence" value="{{$Roledata->licence}}">
                           <input type="hidden" name="verify" value="{{$Roledata->verify}}">
                           <input type="hidden" name="status" value="{{$Roledata->status}}">
                           <input type="hidden" name="license_type" value="{{$Roledata->license_type}}">
                           @endif
                           <br>
                           <div class="row">
                              <div class="col-md-12">
                                 <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                              <div class="col-md-12">
                                 <p style="color:red;text-align:right;margin:5px 5px 0 0;font-size:14px">(*) marked fields are mandatory fields</p>
                                 <p style="color:red;text-align:right;margin:5px 5px 0 0;font-size:14px">(#) marked fields requires application submission date to be updated via Application Status.</p>
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
<script >
    $(document).ready(function() {
        $('#basic-datatables').DataTable({
        });
    
        $('#multi-filter-select').DataTable( {
            "pageLength": 5,
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                            );
    
                        column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                    } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });
    
        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });
    
        var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
    
        $('#addRowButton').click(function() {
            $('#add-row').dataTable().fnAddData([
                $("#addName").val(),
                $("#addPosition").val(),
                $("#addOffice").val(),
                action
                ]);
            $('#addRowModal').modal('hide');
    
        });
    });
 </script>
 <script>
    $('#selectFloatingLabel').change(function() {
         $('.write-type').hide();
         $('#' + $(this).val()).show();
    });
    
    
    
 </script>
 <script>
    $('#selectFloatingLabel1').change(function() {
            $('.Other-service-activities').hide();
            $('#' + $(this).val()).show();
     });
     
 </script>
 <script>
    $('#selectFloatingLabel2').change(function() {
            $('.prmt').hide();
            $('#' + $(this).val()).show();
     });
     
 </script>
 <script>
    var room = 12;
    function education_fields() {
        // alert(room);
    
        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass"+room);
        var rdiv = 'removeclass'+room;
        divtest.innerHTML = '<div class="row"><div class="col-md-6"><div class="form-group form-floating-label"><select class="form-control input-border-bottom"  name="type_doc[]" onchange="checkdoctype('+ room +')" id="d_type'+ room +'"><option value="">&nbsp;</option><option value="PAYEE And Account Reference Letter From HMRC" >PAYEE And Account Reference Letter From HMRC</option><option value="Latest RTI from Accountant" >Latest RTI from Accountant</option><option value="Employer Liability Insurance Certificate"  >Employer Liability Insurance Certificate</option><option value="Proof of Business Premises (Tenancy Agreement)"  >Proof of Business Premises (Tenancy Agreement)</option><option value="Copy Of Lease Or Freehold Property"  >Copy Of Lease Or Freehold Property</option><option value="Business Bank statement for 1 Month"    >Business Bank statement for 1 Month</option><option value="Business Bank statement for 2 Month"  >Business Bank statement for 2 Month</option><option value="Business Bank statement for 3 Month" >Business Bank statement for 3 Month</option><option value="SIGNED Annual account (if the business is over 18 months old)"     >SIGNED Annual account (if the business is over 18 months old)</option><option value="VAT Certificate (if registered)"  >VAT Certificate (if registered)</option><option value="Copy of Health and safety star Rating (Applicable for food business only)"  >Copy of Health and safety star Rating (Applicable for food business only)</option><option value="Registered Business License or Certificate"  >Registered Business License or Certificate</option><option value="Franchise Agreement"  >Franchise Agreement</option><option value="Governing Body Registration" >Governing Body Registration</option><option value="Audited Annual Account (if you have)"  >Audited Annual Account (if you have)</option><option value="Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA"  >Regulatory body certificate if applicable to your business such as ACCA, FCA , OFCOM, IATA, ARLA</option><option value="Copy Of Health & Safety Star Rating"   >Copy Of Health & Safety Star Rating</option><option value="Others Document" >Others Document</option></select></div></div><div class="col-md-4" id="other_doc'+ room +'" style="display:none"><div class="form-group form-floating-label"><input type="text"  id="newdoc_'+ room +'" class="form-control input-border-bottom"   name="other_doc[]"></div></div><div class="col-md-4"><div class="form-group"><input type="file" class="form-control-file" id="docu_nat_new_'+ room +'" onchange="Filevalidationnew('+ room +')" name="docu_nat[]" ></div></div><div class="col-md-2"><div class="input-group-btn btn-up mt-0"><button class="btn btn-success mb-0" style="margin-right: 15px;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';
    
        objTo.appendChild(divtest)
    }
       function remove_education_fields(rid) {
           $('.removeclass'+rid).remove();
       }
    
    
    
    function education_fieldhhs(roomkk) {
        // alert(roomkk);
    
        roomkk++;
        var objTo = document.getElementById('education_fieldbbs')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removcaseclass"+roomkk);
        var rdiv = 'removcaseclass'+roomkk;
     divtest.innerHTML = '<div class="row"><div class="col-md-3"><div class="form-group form-floating-label"><input type="text" class="form-control input-border-bottom" id="name'+ roomkk +'" name="name[]" ></div></div><div class="col-md-2"><div class="form-group form-floating-label"><input type="text" class="form-control input-border-bottom" id="department'+ roomkk +'" name="department[]"></div></div><div class="col-md-2"><div class="form-group form-floating-label"><select class="form-control input-border-bottom " id="job_type'+ roomkk +'"  name="job_type[]" ><option value="">&nbsp;</option><option value="FULL TIME"   >FULL TIME</option><option value="PART TIME"   >PART TIME</option><option value="CONTRACTUAL"   >CONTRACTUAL</option><option value="SELF EMPLOYED"  >SELF EMPLOYED</option><option value="FREELANCER">FREELANCER</option></select></div></div><div class="col-md-2"><div class="form-group form-floating-label"><input type="text" class="form-control input-border-bottom" id="designation'+ roomkk +'" name="designation[]" ></div></div><div class="col-md-3"><div class="form-group form-floating-label"><select class="form-control input-border-bottom " id="immigration'+ roomkk +'"  name="immigration[]"  ><option value="">&nbsp;</option><option value="British Citizen"  >British Citizen</option><option value="Indefinite Leave to Remain">Indefinite Leave to Remain</option><option value="EU Citizenship" >EU Citizenship</option><option value="Leave to Remain (Student Visa)" >Leave to Remain (Student Visa)</option><option value="Leave to Remain (Spouse Visa)" >Leave to Remain (Spouse Visa)</option><option value="Leave to Remain (Human Right Visa)" >Leave to Remain (Human Right Visa)</option><option value="Other Leave to Remain" >Other Leave to Remain </option></select></div></div><div class="col-md-4"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;margin-bottom:0;" type="button"  onclick="education_fieldhhs('+ roomkk +');"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_educationgh_fields('+ roomkk +');"><i class="fas fa-minus"></i></button></div></div></div>';
    
    
        objTo.appendChild(divtest)
    }
       function remove_educationgh_fields(rid) {
           $('.removcaseclass'+rid).remove();
       }
    
        function countryfun(empid){
    
               $.ajax({
            type:'GET',
            url:'{{url('pis/getcompanycountryById')}}/'+empid,
            cache: false,
            success: function(response){
    
    
                document.getElementById("currency").innerHTML = response;
            }
            });
       }
 </script>
 <script type="text/javascript">
    function checktype(id){
    // alert(id);
        var dtype=$("#doc_type_"+id).val();
        if (dtype=='Others Document') {
    
            $("#other_doc_"+id).show();
            $("#other_doc_input_"+id).prop('disabled', false);
    
    
        }
        else{
    
            $("#other_doc_"+id).hide();
            $("#other_doc_"+id).val('');
    
        }
    }
    
    
    function checkdoctype(rid){
     //alert(rid);
        var dtype1=$("#d_type"+rid).val();
        if (dtype1=='Others Document') {
    
            $("#other_doc"+rid).show();
    
        }
        else{
            $("#other_doc"+rid).val('');
            $("#other_doc"+rid).hide();
    
        }
    }
    
    function checkfor1sttime()
    {
        var dtype2=$(".checkfor1sttime").val();
        if (dtype3=='Others Document') {
    
            $("#noalreadydoc").show();
    
        }
        else{
            $("#noalreadydoc").val('');
            $("#noalreadydoc").hide();
    
        }
    }
    
    
    
    
    
    
        function sunst(val)
    {
    
        if (val=='open') {
    
            $("#sun_status_open").show();
                $("#sun_status_close").show();
    $("#sun_close_open").hide();
                $("#sun_close_close").hide();
        }
        else{
            $("#sun_time").val('');
            $("#sun_status_open").hide();
            $("#sun_close").val('');
            $("#sun_status_close").hide();
                $("#sun_close_open").show();
                $("#sun_close_close").show();
    
        }
    }
    
        function monst(val)
    {
    
        if (val=='open') {
    
            $("#mon_status_open").show();
                $("#mon_status_close").show();
    $("#mon_close_open").hide();
                $("#mon_close_close").hide();
        }
        else{
            $("#mon_time").val('');
            $("#mon_status_open").hide();
            $("#mon_close").val('');
            $("#mon_status_close").hide();
    $("#mon_close_open").show();
                $("#mon_close_close").show();
        }
    }
    
         function tuest(val)
    {
    
        if (val=='open') {
    
            $("#tue_status_open").show();
                $("#tue_status_close").show();
    $("#tue_close_open").hide();
                $("#tue_close_close").hide();
        }
        else{
            $("#tue_time").val('');
            $("#tue_status_open").hide();
            $("#tue_close").val('');
            $("#tue_status_close").hide();
                $("#tue_close_open").show();
                $("#tue_close_close").show();
    
        }
    }
    function wedst(val)
    {
    
        if (val=='open') {
    
            $("#wed_status_open").show();
                $("#wed_status_close").show();
    $("#wed_close_open").hide();
                $("#wed_close_close").hide();
        }
        else{
            $("#wed_time").val('');
            $("#wed_status_open").hide();
            $("#wed_close").val('');
            $("#wed_status_close").hide();
                $("#wed_close_open").show();
                $("#wed_close_close").show();
    
        }
    }
    
    function thust(val)
    {
    
        if (val=='open') {
    
            $("#thu_status_open").show();
                $("#thu_status_close").show();
    $("#thu_close_open").hide();
                $("#thu_close_close").hide();
        }
        else{
            $("#thu_time").val('');
            $("#thu_status_open").hide();
            $("#thu_close").val('');
            $("#thu_status_close").hide();
                $("#thu_close_open").show();
                $("#thu_close_close").show();
    
        }
    }
    
    
    
                                               function frist(val)
    {
    
        if (val=='open') {
    
            $("#fri_status_open").show();
                $("#fri_status_close").show();
    $("#fri_close_open").hide();
                $("#fri_close_close").hide();
        }
        else{
            $("#fri_time").val('');
            $("#fri_status_open").hide();
            $("#fri_close").val('');
            $("#fri_status_close").hide();
                $("#fri_close_open").show();
                $("#fri_close_close").show();
    
        }
    }
    
                                               function satst(val)
    {
    
        if (val=='open') {
    
            $("#sat_status_open").show();
                $("#sat_status_close").show();
    $("#sat_close_open").hide();
                $("#sat_close_close").hide();
        }
        else{
            $("#sat_time").val('');
            $("#sat_status_open").hide();
            $("#sat_close").val('');
            $("#sat_status_close").hide();
                $("#sat_close_open").show();
                $("#sat_close_close").show();
    
        }
    }
    
    
    Filevalidation = (val) => {
           const fi = document.getElementById('docu_nat_'+val);
           // Check if any file is selected.
    
           if (fi.files.length > 0) {
               for (const i = 0; i <= fi.files.length - 1; i++) {
    
                   const fsize = fi.files.item(i).size;
                   const file = Math.round((fsize / 1024));
                   // The size of the file.
                    if (file <= 2048) {
    
                   } else {
                     alert(
                         "File is too Big, please select a file up to 2mb");
                             $("#docu_nat_"+val).val('');
                   }
               }
           }
       }
    
           Filevalidationnew = (val) => {
           const fi = document.getElementById('docu_nat_new_'+val);
           // Check if any file is selected.
    
           if (fi.files.length > 0) {
               for (const i = 0; i <= fi.files.length - 1; i++) {
    
                   const fsize = fi.files.item(i).size;
                   const file = Math.round((fsize / 1024));
                   // The size of the file.
                    if (file <= 2048) {
    
                   } else {
                     alert(
                         "File is too Big, please select a file up to 2mb");
                             $("#docu_nat_new_"+val).val('');
                   }
               }
           }
       }
    
       function trade_epmloyee(val) {
    if(val=='Yes'){
    document.getElementById("criman_new").style.display = "block";
    }else{
        document.getElementById("criman_new").style.display = "none";
    }
    
    }
    function penlty_epmloyee(val) {
    if(val=='Yes'){
    document.getElementById("criman_penlty_new").style.display = "block";
    }else{
        document.getElementById("criman_penlty_new").style.display = "none";
    }
    
    }
    function bank_epmloyee(val) {
    if(val=='Yes'){
    document.getElementById("criman_bank_new").style.display = "block";
    }else{
        document.getElementById("criman_bank_new").style.display = "none";
    }
    
    }
    
    function key_bank_epmloyee(val) {
    if(val=='Yes'){
    document.getElementById("criman_key_bank_new").style.display = "block";
    }else{
        document.getElementById("criman_key_bank_new").style.display = "none";
    }
    
    }
    $(document).ready(function(){
         $("#filladdress").on("click", function(){
            if (this.checked)
            {
    
                var ceck=$("#bank_status").val();
               $("#key_f_name").val($("#f_name").val());
               $("#key_f_lname").val($("#l_name").val());
    
               $("#key_designation").val($("#desig").val());
               $("#key_phone").val($("#con_num").val());
               $("#key_email").val($("#authemail").val());
                $("#key_bank_status").val($("#bank_status").val());
                if(ceck=='Yes'){
    
                   document.getElementById("criman_key_bank_new").style.display = "block";
                    $("#key_bank_other").val($("#bank_other").val());
    }else{
        document.getElementById("criman_key_bank_new").style.display = "none";
    }
    
    
           }
           else
           {
                 var ceck=$("#bank_status").val();
               $("#key_f_name").val('');
               $("#key_f_lname").val('');
    
               $("#key_designation").val('');
               $("#key_phone").val('');
               $("#key_email").val('');
                $("#key_bank_status").val('');
    
    
                   document.getElementById("criman_key_bank_new").style.display = "none";
                    $("#key_bank_other").val('');
    
    
       }
       });
    
       /*$(document).on('change','#emp_bank_name', function(e){
           var ifsccode = $('#emp_bank_name option:selected').data('ifsccode');
           $('#emp_ifsc_code').val(ifsccode);
    
       });*/
    });
    
    
    function level_bank_epmloyee(val) {
    if(val=='Yes'){
    document.getElementById("criman_level_bank_new").style.display = "block";
    }else{
        document.getElementById("criman_level_bank_new").style.display = "none";
    }
    
    }
    function level2_bank_epmloyee(val) {
    if(val=='Yes'){
    document.getElementById("criman_level2_bank_new").style.display = "block";
    }else{
        document.getElementById("criman_level2_bank_new").style.display = "none";
    }
    
    }
    $(document).ready(function(){
         $("#filladdresslevel").on("click", function(){
            if (this.checked)
            {
    
                var ceck=$("#bank_status").val();
               $("#level_f_name").val($("#f_name").val());
               $("#level_f_lname").val($("#l_name").val());
    
               $("#level_designation").val($("#desig").val());
               $("#level_phone").val($("#con_num").val());
               $("#level_email").val($("#authemail").val());
                $("#level_bank_status").val($("#bank_status").val());
                if(ceck=='Yes'){
    
                   document.getElementById("criman_level_bank_new").style.display = "block";
                    $("#level_bank_other").val($("#bank_other").val());
    }else{
        document.getElementById("criman_level_bank_new").style.display = "none";
    }
    
    
           }
           else
           {
                 var ceck=$("#bank_status").val();
               $("#level_f_name").val('');
               $("#level_f_lname").val('');
    
               $("#level_designation").val('');
               $("#level_phone").val('');
               $("#level_email").val('');
                $("#level_bank_status").val('');
    
    
                   document.getElementById("criman_level_bank_new").style.display = "none";
                    $("#level_bank_other").val('');
    
    
       }
       });
    
       /*$(document).on('change','#emp_bank_name', function(e){
           var ifsccode = $('#emp_bank_name option:selected').data('ifsccode');
           $('#emp_ifsc_code').val(ifsccode);
    
       });*/
    });
 </script>
 <script>
    function getcode(){
    
        var getaddres=$("#zip").val();
            $.ajax({
            type:'GET',
            url:'{{url('pis/getEmployeedesigappaddressByIhhd')}}/'+getaddres,
            cache: false,
            success: function(response){
    
                   $("#se_add").html(response);
    
            }
            });
    
    }
    function countryfunjj(value){
    
    
            $.ajax({
            type:'GET',
            url:'{{url('pis/getEmployeedesigappaddressByIhhdjfjjbfg')}}/'+value,
            cache: false,
            success: function(response){
    console.log(response);
     var obj = jQuery.parseJSON(response);
                  console.log(obj);
    
    
                   $("#country").val(obj.country);
                    $("#address").val(obj.address);
                     $("#address2").val(obj.address2);
                      $("#road").val(obj.road);
                      $("#city").val(obj.city);
            }
            });
    
    }
    function validateForm(){
        if($("#verified_on").val()=="" && $("#verify").val()=="approved"){
            alert("Verification date required.");
            return false;
        }
        return true;
    
    }
    
 </script>
@endsection