@extends('employeer.include.app')
@section('title', 'Class Edit')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Edit Class</h4>
                  </div>
                  <div class="card-body">
                     <div class="multisteps-form">
                        @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                        @endif
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                              <form action="{{url('org-settings/update-classes')}}" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <input type="hidden" name="class_id" value="<?php print_r($enteries[0]->class_id) ?>">
                                          <label for="inputFloatingLabel" class="col-form-label">Class Name</label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom"  name="class_name" value="<?php print_r($enteries[0]->class_name) ?>">
                                          @if ($errors->has('class_name'))
                                          <div class="error" style="color:red;">{{ $errors->first('class_name') }}</div>
                                          @endif
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