@extends('employeer.include.app')
@section('title', 'Add Pincode')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Add New Pincode</h4>
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
                              <form action="" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">Pincode</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="pin_code" required/>
                                       </div>
                                    </div> 
                                    <div class="col-md-4">  
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">Country</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="country" required/>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">City</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="city" required/>
                                       </div>
                                    </div>
                                    <div class="col-md-6">    
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">State</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="state" required/>
                                       </div>
                                    </div>
                                    <div class="col-md-6">   
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">District</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="district" required/>
                                       </div>
                                    </div>
                                 </div>
                                 <br>
                                 <div class="row form-group">
                                    <div class="col-sm-12 col-md-2 text-center"><button type="submit" class="btn btn-primary">Submit</button></div>
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