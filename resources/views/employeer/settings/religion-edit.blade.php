@extends('employeer.include.app')
@section('title', 'Religion Edit')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Religion</li>
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Edit Religion</h4>
                  </div>
                  <div class="card-body">
                     <div class="multisteps-form">
                        @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                        @endif
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                            <form action="{{url('org-settings/update-new-religion')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputFloatingLabel" class="col-form-label">Religion Name</label>
                                            <input type="hidden" name="rel_id" value="{{ $enteries->idreligion_master }}">
                                            <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" name="religion_name" value="{{ $enteries->religion_name }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                            <select class="select" name="status">
                                                <option value="active" {{ $enteries->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inActive" {{ $enteries->status == 'inActive' ? 'selected' : '' }}>inActive</option>
                                            </select>
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
