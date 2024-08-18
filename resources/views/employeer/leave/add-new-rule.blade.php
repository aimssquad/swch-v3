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
               <h4 class="card-title"><i class="far fa-user"></i>  Add New Leave type</h4>
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form action="{{ url('leave/save-leave-rule') }}" method="post" enctype="multipart/form-data" >
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="<?php  if(!empty($leave_rule_data->id)){echo $leave_rule_data->id;} ?>">
                           <div class="row form-group">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="employee_type" class="col-form-label">Employee Type</label>
                                    <select   id="employee_type" name="employee_type"  class="select" required="">
                                       {{-- <option>Select</option> --}}
                                       @foreach($employee_type_rs as $employee_type)
                                       <?php if(!isset($leave_rule_data->employee_type)){ ?>
                                       <option value="{{$employee_type->employ_type_id}}">{{ $employee_type->employ_type_name}}</option>
                                       <?php }else{ ?> 
                                       <option value="{{$employee_type->employ_type_id}}" <?php if(!empty($employee_type->employ_type_id)){ if($employee_type->employ_type_id == $leave_rule_data->employee_type){ echo "selected"; } } ?>>{{ $employee_type->employ_type_name}}</option>
                                       <?php } ?>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('employee_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('employee_type') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="leave_type_id" class="col-form-label">Leave Type</label>
                                    <select   id="leave_type_id" name="leave_type_id"  class="select" required="">
                                       @foreach($leave_type_rs as $leave_type)
                                       <option value="{{$leave_type->id}}" <?php if(!empty($leave_rule_data->leave_type_id)){ if($leave_rule_data->leave_type_id == $leave_type->id){ echo "selected"; } } ?> >{{ $leave_type->leave_type_name }}</option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('leave_type_id'))
                                    <div class="error" style="color:red;">{{ $errors->first('leave_type_id') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="max_no" class="col-form-label">Maximum No. (Annual)</label>
                                    <input   type="text" class="form-control input-border-bottom" required="" id="max_no" name="max_no" value="<?php  if(!empty($leave_rule_data->max_no)){echo $leave_rule_data->max_no;} ?>">
                                    @if ($errors->has('max_no'))
                                    <div class="error" style="color:red;">{{ $errors->first('max_no') }}</div>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <div class="row form-group">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="effective_from" class="col-form-label">Effective From</label>	
                                    <input type="date" class="form-control input-border-bottom" required="" id="effective_from" name="effective_from"  value="<?php  if(!empty($leave_rule_data->effective_from)){ echo $leave_rule_data->effective_from; } ?>">
                                    @if ($errors->has('effective_from'))
                                    <div class="error" style="color:red;">{{ $errors->first('effective_from') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="effective_to" class="col-form-label">Effective to</label>	
                                    <input  type="date" class="form-control input-border-bottom" required="" id="effective_to" name="effective_to" value="<?php  if(!empty($leave_rule_data->effective_to)){ echo $leave_rule_data->effective_to; } ?>">
                                    @if ($errors->has('effective_to'))
                                    <div class="error" style="color:red;">{{ $errors->first('effective_to') }}</div>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="row form-group">
                              <div class="col-md-12 text-center"><button class="btn btn-primary">Submit</button></div>
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