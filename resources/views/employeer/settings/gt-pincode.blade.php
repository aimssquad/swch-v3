@extends('employeer.include.app')
@section('title', 'Edit Pincode')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Pincode</li>
                 </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Edit New Pincode</h4>
                  </div>
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                  @endif
                  @if(Session::has('error'))										
                  <div class="alert alert-danger" style="text-align:center;">{{ Session::get('error') }}</div>
                  @endif
                  <div class="card-body">
                     <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                                <form action="{{url('org-settings/updatepincode')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <input type="hidden" value="{{$pincode->id ?? ''}}" name="pincode_id">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputFloatingLabel" class="col-form-label">Pincode</label>
                                                <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="pin_code" value="{{$pincode->pin_code ?? ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputFloatingLabel" class="col-form-label">Country</label>
                                                <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="country" value="{{$pincode->country ?? ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputFloatingLabel" class="col-form-label">City</label>
                                                <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="city" value="{{$pincode->city ?? ''}}"/>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inputFloatingLabel" class="col-form-label">State</label>
                                                <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="state" value="{{$pincode->state ?? ''}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputFloatingLabel" class="col-form-label">District</label>
                                                <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="district" value="{{$pincode->district ?? ''}}"/>
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
</div>
@endsection
