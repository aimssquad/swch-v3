@extends('employeer.include.app')
@section('title', 'Caste Add')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active"> Add Cast Master</li>
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Add Caste</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                    @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                    @endif
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputFloatingLabel" class="col-form-label">Caste Name</label>
                                            <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="cast_name" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <br>
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