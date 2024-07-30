@extends('payroll.include.app')
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home"><a href="{{url('payroll-home-dashboard')}}"> Home</a></li>
         <li class="separator"> / </li>
         <li class="nav-item"><a href="{{url('payroll/dashboard')}}">Payroll</a></li>
         <li class="separator"> / </li>
         <li class="nav-item active">Add Monthly Overtime for All Employee</li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                @include('layout.message')
                  <div class="card-body">
                    <form action="{{url('payroll/vw-add-overtimes-all')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
                        {{ csrf_field() }}
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="text-input" class=" form-control-label" style="text-align:right;">Select Month</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="month_yr" id="month_yr" required>

                                    <option value="" selected disabled > Select </option>
                                        <?php
                                                for ($yy = 2022; $yy <= date('Y'); $yy++) {
                                                    for ($mm = 1; $mm <= 12; $mm++) {
                                                        if ($mm < 10) {
                                                            $month_yr = '0' . $mm . "/" . $yy;
                                                        } else {
                                                            $month_yr = $mm . "/" . $yy;
                                                        }
                                                        ?>
                                                            <option value="<?php echo $month_yr; ?>"  @if(isset($month_yr_new) && $month_yr_new==$month_yr) selected @endif><?php echo $month_yr; ?></option>
                                                        <?php
            
                                                        }
                                                }
                                        ?>
                                </select>
                                @if ($errors->has('month'))
                                <div class="error" style="color:red;">{{ $errors->first('month') }}</div>
                                @endif
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-info" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;
                height: 32px;">Go</button>
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
                    {{-- <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Process Attendance</h4>
                    </div> --}}
                    <div class="card-body">
                        <form action="{{url('payroll/save-overtimes-all')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
                            <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl" class="sm_emp_code_ctrl" value="" />
                            <input type="hidden" id="sm_emp_name_ctrl" name="sm_emp_name_ctrl" class="sm_emp_name_ctrl" value="" />
                            <input type="hidden" id="sm_emp_designation_ctrl" name="sm_emp_designation_ctrl" class="sm_emp_designation_ctrl" value="" />
                            <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl" class="sm_month_yr_ctrl" value="" />

                            <input type="hidden" id="sm_basic_ctrl" name="sm_basic_ctrl" class="sm_basic_ctrl" value="" />
                            <input type="hidden" id="sm_lm_ot_hrs_ctrl" name="sm_lm_ot_hrs_ctrl" class="sm_lm_ot_hrs_ctrl" value="" />
                            <input type="hidden" id="sm_cm_ot_hrs_ctrl" name="sm_cm_ot_hrs_ctrl" class="sm_cm_ot_hrs_ctrl" value="" />
                            <input type="hidden" id="sm_lm_ot_ctrl" name="sm_lm_ot_ctrl" class="sm_lm_ot_ctrl" value="" />

                            <input type="hidden" id="sm_cm_ot_ctrl" name="sm_cm_ot_ctrl" class="sm_cm_ot_ctrl" value="" />
                            <input type="hidden" id="sm_e_overtime_ctrl" name="sm_e_overtime_ctrl" class="sm_e_overtime_ctrl" value="" />

                            

                            <table id="basic-datatables" class="table table-striped table-bordered">
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:2%;">Sl. No.</th>
                                        <th style="width:8%;">Employee Id</th>
                                        <th style="width:8%;">Employee Code</th>
                                        <th style="width:10%;">Employee Name</th>
                                        <th style="width:10%;">Designation</th>
                                        <th style="width:10%;">Month</th>
                                        <th style="width:10%;">Basic</th>
                                        <th style="width:5%;">Last Month OT Hrs.</th>
                                        <th style="width:5%;">Current Month OT Hrs.</th>
                                        <th style="width:6%;">Last Month OT</th>
                                        <th style="width:6%;">Current Month OT</th>
                                        <th style="width:5%;">Overtime Allowance</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php print_r($result);?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="7" style="border:none;">
                                            <button type="button" class="btn btn-info btn-sm checkall" style="margin-right:2%;">Check All</button>
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="map_controls();">Save</button>
                                            <button type="reset" class="btn btn-warning btn-sm"> Reset</button>
                                        </td>
                                        <td><div class="total_lm_ot_hrs" style="font-weight:700;"></div></td>
                                        <td><div class="total_cm_ot_hrs" style="font-weight:700;"></div></td>
                                        <td><div class="total_lm_ot" style="font-weight:700;"></div></td>
                                        <td><div class="total_cm_ot" style="font-weight:700;"></div></td>
                                        <td><div class="total_ot" style="font-weight:700;"></div></td>
                                    </tr>
                                </tfoot>


                            </table>
                        </form>
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
    <script>
        var clicked = false;
        $(".checkall").on("click", function() {
        // $(".checkhour").prop("checked", !clicked);
        // clicked = !clicked;
    
        var ele=document.getElementsByName('empcode_check[]');
       // alert(ele.length);
        for(var i=0; i<ele.length; i++){
            if(ele[i].type=='checkbox')
                ele[i].checked=true;
        }
        map_controls();
    });
    
    function map_controls(){
    
        var cb = $('.checkhour:checked').map(function() {return this.value;}).get().join(',');
        $('#cboxes').val(cb);
    
        var cb1 = $('.sm_emp_code').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_code_ctrl').val(cb1);
    
        var cb2 = $('.sm_emp_name').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_name_ctrl').val(cb2);
    
        var cb3 = $('.sm_emp_designation').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_designation_ctrl').val(cb3);
    
        var cb4 = $('.sm_month_yr').map(function() {return this.value;}).get().join(',');
        $('#sm_month_yr_ctrl').val(cb4);
    
        var cb5 = $('.sm_basic').map(function() {return this.value;}).get().join(',');
        $('#sm_basic_ctrl').val(cb5);
    
        var cb6 = $('.sm_lm_ot_hrs').map(function() {return this.value;}).get().join(',');
        $('#sm_lm_ot_hrs_ctrl').val(cb6);
    
        var cb7 = $('.sm_cm_ot_hrs').map(function() {return this.value;}).get().join(',');
        $('#sm_cm_ot_hrs_ctrl').val(cb7);
    
        var cb8 = $('.sm_lm_ot').map(function() {return this.value;}).get().join(',');
        $('#sm_lm_ot_ctrl').val(cb8);
    
        var cb9 = $('.sm_cm_ot').map(function() {return this.value;}).get().join(',');
        $('#sm_cm_ot_ctrl').val(cb9);
    
        var cb10 = $('.sm_e_overtime').map(function() {return this.value;}).get().join(',');
        $('#sm_e_overtime_ctrl').val(cb10);
    
        
    
    }
    
    function calculate_ot(empcode){
        
        var curr_mdays=$('#curr_mdays_'+empcode).val();
        if(curr_mdays=='') 
            curr_mdays=0;
    
        var prev_mdays=$('#prev_mdays_'+empcode).val();
        if(prev_mdays=='') 
            prev_mdays=0;
    
        var basic=$('#basic_'+empcode).val();
        if(basic=='') 
            basic=0;
    
        var prevPerDay=eval(basic)/eval(prev_mdays);        
        var currPerDay=eval(basic)/eval(curr_mdays);  
    
        var prevPerHr=eval(prevPerDay)/8;        
        var currPerHr=eval(currPerDay)/8;        
    
        var lm_ot_hrs=$('#lm_ot_hrs_'+empcode).val();
        if(lm_ot_hrs=='') 
            lm_ot_hrs=0;
    
        var cm_ot_hrs=$('#cm_ot_hrs_'+empcode).val();
        if(cm_ot_hrs=='') 
            cm_ot_hrs=0;
    
    
        var lm_ot=0;
        if(lm_ot_hrs>0){
            lm_ot = eval(lm_ot_hrs)*eval(prevPerHr);
            lm_ot = Math.round(lm_ot * 100)/100;
        }
    
        var cm_ot=0;
        if(cm_ot_hrs>0){
            cm_ot = eval(cm_ot_hrs)*eval(currPerHr);
            cm_ot = Math.round(cm_ot * 100)/100;
        }
    
        var e_overtime=eval(lm_ot)+eval(cm_ot);
        e_overtime = Math.round(e_overtime * 100)/100;
    
        
        $('#lm_ot_'+empcode).val(lm_ot);		
        $('#cm_ot_'+empcode).val(cm_ot);		
        $('#e_overtime_'+empcode).val(e_overtime);		
    
    
    
    
    }
    
    
    $(document).on("keyup", ".sm_lm_ot_hrs", function() {
        doSumLmOtHrs();
        doSumLmOt();
        doSumOt();
    });
    
    $(document).on("keyup", ".sm_cm_ot_hrs", function() {
        doSumCmOtHrs();
        doSumCmOt();
        doSumOt();
    });
    
    $(document).ready(function(){
        $("#basic-datatables").dataTable().fnDestroy();
        $('#basic-datatables').DataTable({
            lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
            initComplete: function(settings, json) {
                doSumLmOtHrs();
                doSumCmOtHrs();
                doSumLmOt();
                doSumCmOt();
                doSumOt();
            }
        });
    });
    
    function doSumLmOtHrs() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(7).nodes();
        var total = table.column(7 ).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
           $(".total_lm_ot_hrs").html(total);
    }
    
    function doSumCmOtHrs() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(8).nodes();
        var total = table.column(8).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        $(".total_cm_ot_hrs").html(total);
    }
    
    function doSumLmOt() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(9).nodes();
        var total = table.column(9).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
           $(".total_lm_ot").html(total);
    }
    
    function doSumCmOt() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(10).nodes();
        var total = table.column(10).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        $(".total_cm_ot").html(total);
    }
    
    function doSumOt() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(11).nodes();
        var total = table.column(11).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
        $(".total_ot").html(total);
    }
    
    
    
    </script>
    @endsection
   