@extends('employeer.include.app')
@if(isset($taxdetails) && !empty($taxdetails))                    	
@section('title', 'Tax Edit')
@else
@section('title', 'Tax Add')
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
                    @if(isset($taxdetails) && !empty($taxdetails))
                    <li class="breadcrumb-item active">Edit Tax</li>
                    @else
                    <li class="breadcrumb-item active">Add New Tax</li>
                    @endif
                 </ul>
               <div class="card custom-card">
                  <div class="card-header">
                    @if(isset($taxdetails) && !empty($taxdetails))
                            	
                    <h4 class="card-title"><i class="fas fa-money-bill-wave"></i> Edit Tax Master</h4>
                        @else
                        
                    <h4 class="card-title"><i class="fas fa-money-bill-wave"></i> Add Tax Master</h4>
                        @endif 
                  </div>
                  <div class="card-body">
                     <div class="multisteps-form">
                        @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                        @endif
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                            <form action="{{ url('org-settings/tax') }}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                   <input type="hidden" name="taxid" value="{{ ((isset($taxdetails) && !empty($taxdetails))?$taxdetails[0]->id:'')}}">
                                                      <div class="row">
                                                      <div class="col-md-4">
                                                      <div class="form-group">
                                                          <label for="inputFloatingLabel" class="col-form-label">Tax Code</label>
                                                              <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" name="tax_code"   value="{{ (isset($taxdetails[0]->tax_code) && !empty($taxdetails[0]->tax_code))?$taxdetails[0]->tax_code:old('tax_code')}}">
                                                              
                                                              @if ($errors->has('tax_code'))
                                                          <div class="error" style="color:red;">{{ $errors->first('tax_code') }}</div>
                                                      @endif
                                                          </div>
                                                                                                                    
                                                      </div>
                                                      <div class="col-md-4">
                                                      <div class="form-group">
                                                          <label for="inputFloatingLabel1" class="col-form-label">Percentage of Deduction</label>
                                                              <input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="per_de"   value="{{ (isset($taxdetails[0]->per_de) && !empty($taxdetails[0]->per_de))?$taxdetails[0]->per_de:old('per_de')}}">
                                                              
                                                              @if ($errors->has('per_de'))
                                                          <div class="error" style="color:red;">{{ $errors->first('per_de') }}</div>
                                                      @endif
                                                          </div>
                                                      
                                  </div>
                                  
                                  
                                               <div class="col-md-4">
                                                      <div class="form-group">
                                                          <label for="inputFloatingLabel2" class="col-form-label">Tax Reference</label>
                                                              <input id="inputFloatingLabel2" type="text" class="form-control input-border-bottom" required=""  name="tax_ref"   value="{{ (isset($taxdetails[0]->tax_ref) && !empty($taxdetails[0]->tax_ref))?$taxdetails[0]->tax_ref:old('tax_ref')}}">
                                                              
                                                              @if ($errors->has('tax_ref'))
                                                          <div class="error" style="color:red;">{{ $errors->first('tax_ref') }}</div>
                                                      @endif
                                                          </div>
                                                      
                                  </div>
                                  </div>
                                  
                                  <br>
                                               <div class="form-group">
                                                      <div class="col-md-12">
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