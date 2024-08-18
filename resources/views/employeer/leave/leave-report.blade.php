@extends('employeer.include.app')
@section('title', 'Add Leave Type')
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title"><i class="far fa-user"></i> Leave Report</h4>
               @if(Session::has('message'))										
               <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
               @endif
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form  method="post" action="{{ url('leave/leave-report') }}" enctype="multipart/form-data" >
                           <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                           <div class="row form-group">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel-choose-year" class="col-form-label">Choose Year</label>
                                    <select id="inputFloatingLabel-choose-year" name="year_value" class="select" required="">
                                       <option value="">&nbsp;</option>
                                       <?php for($i = date("Y")-2; $i <=date("Y")+20; $i++){
                                          echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;
                                          } ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="row form-group">
                              <div class="col-md-6">
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
@endsection
@section('script')
@endsection