@extends('employeer.include.app')

@if(!empty($holidaydtl->id))  
@section('title', 'Edit Holiday Type')
@else   
@section('title', 'Add Holiday Type')
@endif 
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('orgaization/holiday-dashboard')}}">Holiday Dashboard</a></li>
               @if(!empty($holidaydtl->id))
               <li class="breadcrumb-item active">Edit Holiday Type</li>
               @else
               <li class="breadcrumb-item active">Add New Holiday Type</li>
               @endif
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  
                  @if(!empty($holidaydtl->id))  
                  <h4 class="card-title"><i class="far fa-user"></i>  Edit Holiday Type</h4>
                  @else   
                  <h4 class="card-title"><i class="far fa-user"></i>  Add New Holiday Type</h4>
                  @endif 
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{ url('organization/add-holiday-type') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                              {{csrf_field()}}
                              <input type="hidden" name="id" value="<?php  if(!empty($holidaydtl->id)){echo $holidaydtl->id;} ?>">
                              <div class="row">
                                 <div class="col-md-5">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">Holiday Type</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" name="name" value="<?php if(isset($holidaydtl->id)){  echo $holidaydtl->name;  }?>{{ old('name') }}"> 
                                       @if ($errors->has('name'))
                                       <div class="error" style="color:red;">{{ $errors->first('name') }}</div>
                                       @endif
                                    </div>
                                 </div>
                              </div>
                              <div class="row form-group text-center">
                                 <div class="col-md-12"><button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button></div>
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
       function calculateDays(){
       var from_date= $("#inputFloatingLabel1").val();
       var to_date= $("#inputFloatingLabel2").val();
       var fromdate = new Date(from_date);
       var todate = new Date(to_date);
       var diffDays = (todate.getDate() - fromdate.getDate()) + 1 ;
       $("#inputFloatingLabel3").val(diffDays);
   }
</script>
@endsection