@extends('employeer.include.app')
@if(isset($bankdetails) && !empty($bankdetails))
@section('title', 'Edit Bank Sortcode')
@else
@section('title', 'Add Bank Sortcode')
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
                  @if(isset($bankdetails) && !empty($bankdetails))
                  <li class="breadcrumb-item active">Edit Bank Sortcode</li>
                  @else
                  <li class="breadcrumb-item active">Add New Bank Sortcode</li>
                  @endif
                  
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                     @if(isset($bankdetails) && !empty($bankdetails))
                     <h4 class="card-title"><i class="fas fa-university"></i> Edit Bank Sortcode </h4>
                     @else
                     <h4 class="card-title"><i class="far fa-user"></i>Edit Bank Sortcode</h4>
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
                              <form action="{{ url('org-settings/bank-sortcode') }}" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <input type="hidden" name="bankid" value="{{ ((isset($bankdetails) && !empty($bankdetails))?$bankdetails[0]->id:'')}}">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel"  class="col-form-label">Bank Name</label>	
                                          <select name="bank_name" id="bank_name"  class="select input-border-bottom" required="">
                                             @foreach($MastersbankName as $value):
                                             <option value="{{ $value->id }}" <?php if(!empty($bankdetails[0]->id)){ if( $bankdetails[0]->bank_name == $value->id){  echo "selected"; } } ?>>
                                                {{ $value->master_bank_name }} 
                                             </option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel1" class="col-form-label">Bank Sort Code</label>
                                          <input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="bank_sort"   value="{{ (isset($bankdetails[0]->bank_sort) && !empty($bankdetails[0]->bank_sort))?$bankdetails[0]->bank_sort:old('bank_sort')}}">
                                          @if ($errors->has('bank_sort'))
                                          <div class="error" style="color:red;">{{ $errors->first('bank_sort') }}</div>
                                          @endif
                                       </div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="row form-group">
                                    <div class="col-md-4">
                                       <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
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