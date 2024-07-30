@extends('attendance.include.app')
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="#">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="#">Attendance Report</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                  @endif
                  <div class="card-body">
                     <form  method="post" action="{{url('attendance/report-monthly-attendance')}}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row form-group">
                            <div class="col-md-3">
                            </div>
                           <div class="col-md-6">
                              <div class=" form-group">
                                 <label for="department" class="placeholder"> Select Month</label>
                                 <select data-placeholder="Choose an Month..." class="form-control" name="month_yr" id="month_yr" required>
                                    <option value="" selected disabled> Select </option>
                                    <?php foreach ($monthlist as $month) {?>
                                        @if($month->month_yr!='')
                                        <option value="<?php echo $month->month_yr; ?>" @if(isset($month_yr_new) && $month_yr_new==$month->month_yr) selected @endif ><?php echo $month->month_yr; ?></option>
                                        @endif
                                    <?php }?>
                                </select>
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                            </div>
                           <div class="col-md-3">
                              <a href="#">	
                              <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Go</button></a>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         @if($result !='')
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Attendance Report</h4>
                    </div>
                    <div style="display:inline-flex;float:right;margin-left:20px;">
						<form  method="post" action="{{ url('attendance/xls-export-attendance-report') }}" enctype="multipart/form-data" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="month_yr" value="{{ $req_month }}">
                            <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                        </form>
												
                    </div>
                    <div class="card-body">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:6%;">Sl. No.</th>
                                        <th style="width:10%;">Employee Id</th>
                                        <th style="width:12%;">Employee Name</th>
                                        <th style="width:10%;">Month</th>
                                        <th >Days In Month</th>
                                        <th >No. of Present Days</th>
                                        <th >No. of Leave Taken</th>
                                        <th >No. of Absent Days</th>
                                        <th >No. of Salary Days</th>
                                        <th >No. of Salary Adjustment Days</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php print_r($result);?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
         @endif
      </div>
   </div>

   @endsection
    @section('js')

    @endsection
   