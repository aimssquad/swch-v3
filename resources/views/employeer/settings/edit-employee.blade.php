@extends('employeer.include.app')
@section('title', 'Employee Type Edit')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Employee Type</li>
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Edit Employee Type</h4>
                  </div>
                  <div class="card-body">
                     <div class="multisteps-form">
                        @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                        @endif
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                              <form action="{{url('org-settings/vw-emp-update')}}" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <input type="hidden" name="id" value="{{$enteries->employ_type_id}}">
                                          <label for="inputFloatingLabel" class="col-form-label">Employee Type</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="employ_type_name" value="{{$enteries->employ_type_name}}">
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