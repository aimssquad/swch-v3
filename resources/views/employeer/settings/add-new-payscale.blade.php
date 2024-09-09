@extends('employeer.include.app')
@if(app('request')->input('id'))
@section('title', 'Edit New Annual Pay')
@else
@section('title', 'Add New Annual Pay')
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
               @if(app('request')->input('id'))
               <li class="breadcrumb-item active">Edit Annual Pay</li>
               @else
               <li class="breadcrumb-item active">Add New Annual Pay</li>
               @endif
               
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  @if(app('request')->input('id'))
                  <h4 class="card-title"><i class="far fa-user"></i> Edit Annual Pay</h4>
                  @else
                  <h4 class="card-title"><i class="far fa-user"></i> Add New Annual Pay</h4>
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
                           <form action="" method="post" enctype="multipart/form-data">
                              {{csrf_field()}}
                              <div id="education_fields">
                                 <div class="row form-group">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label">Paygroup Code</label>
                                          <select class="select input-border-bottom" id="inputFloatingLabel" required="" name="payscale_code">
                                             @foreach($paygroup_rs as $grade)
                                             <option value="{{ $grade->id}}"  <?php  if(app('request')->input('id')){ if($getPayscale[0]->payscale_code==$grade->id){ echo 'selected'; } } ?> >{{ $grade->grade_name}}</option>
                                             @endforeach   
                                          </select>
                                       </div>
                                    </div>
                                    @if (app('request')->input('id'))
                                    <?php   $tr_id=0;
                                       $countpay= count($getPaybac)			;?>
                                    @foreach($getPaybac as $gradebas)
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel<?php echo  $tr_id;?>" class="col-form-label">Annual Pay</label>
                                          <input id="inputFloatingLabel<?php echo  $tr_id;?>" type="text" class="form-control input-border-bottom" required="" name="pay_scale_basic[]" value="{{ $gradebas->pay_scale_basic}}" >
                                       </div>
                                    </div>
                                    </br>
                                    <?php $tr_id++; ?>
                                    @if ($tr_id==($countpay))
                                    <div class="col-md-4 btn-up">
                                       <button class="btn-success" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button>
                                    </div>
                                    @endif
                                    @endforeach   
                                    @endif
                                    @if (empty(app('request')->input('id')))
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel1" class="col-form-label">Annual Pay</label>
                                          <input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="pay_scale_basic[]" >
                                       </div>
                                    </div>
                                    <div class="col-md-4 btn-up">
                                       <button class="btn btn-success" type="button"  onclick="education_fields();" style="margin-top: 25px;"> <i class="fas fa-plus"></i> </button>
                                    </div>
                                    @endif
                                 </div>
                              </div>
                              <br>
                              <div class="form-group">
                                 <div class="col-md-2 btn-up"><button type="submit" class="btn btn-primary">Submit</button></div>
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
@section('script')
    <script>
        var room = 1;
        function education_fields() {
        
            room++;
            var objTo = document.getElementById('education_fields')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "form-group removeclass"+room);
            var rdiv = 'removeclass'+room;
            divtest.innerHTML = '<div class="row"><div class="col-md-4"><div class="form-group"><label for="inputFloatingLabel1" class="col-form-label">Annual Pay</label><input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required=""  name="pay_scale_basic[]" ></div></div><div class="col-md-4" style="margin-top:25px;"><div class="input-group-btn"><button class="btn-success" style="margin-right: 25px;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';
            
            objTo.appendChild(divtest)
        }
        function remove_education_fields(rid) {
            $('.removeclass'+rid).remove();
        }
    </script>
@endsection