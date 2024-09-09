@extends('employeer.include.app')

@if(isset($paytypedetails) && !empty($paytypedetails))
@section('title', 'Edit Payment Type')
@else
@section('title', 'Add Payment Type')
@endif 
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
               @if(isset($paytypedetails) && !empty($paytypedetails))
               <li class="breadcrumb-item active">Edit Payment Type</li>
               @else
               <li class="breadcrumb-item active">Add New Payment Type</li>
               @endif
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  @if(isset($paytypedetails) && !empty($paytypedetails))
                  <h4 class="card-title"> Edit Payment Type</h4>
                  @else
                  <h4 class="card-title"> Add Payment Type</h4>
                  @endif 
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
                           <form action="{{ url('org-settings/pay-type') }}" method="post" enctype="multipart/form-data">
                              {{csrf_field()}}
                              <input type="hidden" name="paytypeid" value="{{ ((isset($paytypedetails) && !empty($paytypedetails))?$paytypedetails[0]->id:'')}}">
                              <div class="row">
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">Payment Type</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required=""  name="pay_type"   value="{{ (isset($paytypedetails[0]->pay_type) && !empty($paytypedetails[0]->pay_type))?$paytypedetails[0]->pay_type:old('pay_type')}}">
                                       @if ($errors->has('pay_type'))
                                       <div class="error" style="color:red;">{{ $errors->first('pay_type') }}</div>
                                       @endif
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel1" class="col-form-label">Min. Working Hour</label>
                                       <input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom"  name="work_hour"   value="{{ (isset($paytypedetails[0]->work_hour) && !empty($paytypedetails[0]->work_hour))?$paytypedetails[0]->work_hour:old('work_hour')}}">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel2" class="col-form-label">Rate</label>
                                       <input id="inputFloatingLabel2" type="text" class="form-control input-border-bottom" name="rate"   value="{{ (isset($paytypedetails[0]->rate) && !empty($paytypedetails[0]->rate))?$paytypedetails[0]->rate:old('rate')}}">
                                    </div>
                                 </div>
                              </div>
                              <br>
                              <div class="row form-group">
                                 <div class="col-md-12 btn-up">
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
</div>
@endsection