@extends('employeer.include.app')
@section('title', 'Wedges pay mode')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  @if(isset($paytypedetails) && !empty($paytypedetails))
                  <h4 class="card-title"><i class="fas fa-money-bill-wave"></i> Edit  Wedges pay mode</h4>
                  @else
                  <h4 class="card-title"><i class="fas fa-money-bill-wave"></i> Add  Wedges pay mode</h4>
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
                           <form action="{{ url('org-settings/wedgespay-type') }}" method="post" enctype="multipart/form-data">
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
                              </div>
                              <br>
                              <div class="row form-group">
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