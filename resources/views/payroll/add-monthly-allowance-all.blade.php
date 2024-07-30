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
         <li class="nav-item active">Add Monthly Allowances for All Employee</li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                @include('layout.message')
                  <div class="card-body">
                    <form action="{{url('payroll/vw-add-allowances-all')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
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
                        <form action="{{url('payroll/save-allowances-all')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
                            <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl" class="sm_emp_code_ctrl" value="" />
                            <input type="hidden" id="sm_emp_name_ctrl" name="sm_emp_name_ctrl" class="sm_emp_name_ctrl" value="" />
                            <input type="hidden" id="sm_emp_designation_ctrl" name="sm_emp_designation_ctrl" class="sm_emp_designation_ctrl" value="" />
                            <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl" class="sm_month_yr_ctrl" value="" />

                            <input type="hidden" id="sm_tot_wdays_ctrl" name="sm_tot_wdays_ctrl" class="sm_tot_wdays_ctrl" value="" />
                            <input type="hidden" id="sm_no_d_tiff_ctrl" name="sm_no_d_tiff_ctrl" class="sm_no_d_tiff_ctrl" value="" />
                            <input type="hidden" id="sm_no_d_conv_ctrl" name="sm_no_d_conv_ctrl" class="sm_no_d_conv_ctrl" value="" />
                            <input type="hidden" id="sm_no_d_misc_ctrl" name="sm_no_d_misc_ctrl" class="sm_no_d_misc_ctrl" value="" />
                            <input type="hidden" id="sm_no_d_other_ctrl" name="sm_no_d_other_ctrl" class="sm_no_d_other_ctrl" value="" />

                            <input type="hidden" id="sm_et_tiffalw_ctrl" name="sm_et_tiffalw_ctrl" class="sm_et_tiffalw_ctrl" value="" />
                            <input type="hidden" id="sm_e_tiffalw_ctrl" name="sm_e_tiffalw_ctrl" class="sm_e_tiffalw_ctrl" value="" />

                            <input type="hidden" id="sm_et_convalw_ctrl" name="sm_et_convalw_ctrl" class="sm_et_convalw_ctrl" value="" />
                            <input type="hidden" id="sm_e_conv_ctrl" name="sm_e_conv_ctrl" class="sm_e_conv_ctrl" value="" />

                            <input type="hidden" id="sm_et_miscalw_ctrl" name="sm_et_miscalw_ctrl" class="sm_et_miscalw_ctrl" value="" />
                            <input type="hidden" id="sm_e_miscalw_ctrl" name="sm_e_miscalw_ctrl" class="sm_e_miscalw_ctrl" value="" />
                            <input type="hidden" id="sm_e_extra_misc_alw_ctrl" name="sm_e_extra_misc_alw_ctrl" class="sm_e_extra_misc_alw_ctrl" value="" />
                            
                            <input type="hidden" id="sm_et_otheralw_ctrl" name="sm_et_otheralw_ctrl" class="sm_et_otheralw_ctrl" value="" />
                            <input type="hidden" id="sm_e_otheralw_ctrl" name="sm_e_otheralw_ctrl" class="sm_e_otheralw_ctrl" value="" />

                            <table id="basic-datatables" class="table table-striped table-bordered table-responsive">
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:5%;">Sl. No.</th>
                                        <th style="width:10%;">Employee Id</th>
                                        <th style="width:10%;">Employee Code</th>
                                        <th style="width:20%;">Employee Name</th>
                                        <th style="width:10%;">Month</th>
                                        <th style="width:18%;">No. of Days Present</th>
                                        <th >No. of Tiffin Alw. Days</th>
                                        <th style="width:5%;">Ent. Tiffin Allowance</th>
                                        <th style="width:5%;">Tiffin Allowance</th>
                                        <th >No. of Conv. Alw. Days</th>
                                        <th style="width:5%;">Ent. Conv. Allowance</th>
                                        <th style="width:5%;">Conv. Allowance</th>
                                        <th >No. of Mics. Alw. Days</th>
                                        <th style="width:5%;">Ent. Mics. Allowance</th>
                                        <th style="width:5%;">Mics. Allowance</th>
                                        <th style="width:5%;">Extra Mics. Allowance</th>
                                        <th >No. of Others Alw. Days</th>
                                        <th style="width:5%;">Ent. Others Allowance</th>
                                        <th style="width:5%;">Others Allowance</th>
                                        
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php print_r($result);?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="6" style="border:none;">
                                            <button type="button" class="btn btn-info btn-sm checkall" style="margin-right:2%;">Check All</button>
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="map_controls();">Save</button>
                                            <button type="reset" class="btn btn-warning btn-sm"> Reset</button>
                                        </td>
                                        <td><div class="total_tiff_days" style="font-weight:700;"></div></td>
                                        <td><div class="total_ent_tiff" style="font-weight:700;"></div></td>
                                        <td><div class="total_tiff" style="font-weight:700;"></div></td>
                                        <td><div class="total_conv_days" style="font-weight:700;"></div></td>
                                        <td><div class="total_ent_conv" style="font-weight:700;"></div></td>
                                        <td><div class="total_conv" style="font-weight:700;"></div></td>
                                        <td><div class="total_mics_days" style="font-weight:700;"></div></td>
                                        <td><div class="total_ent_mics" style="font-weight:700;"></div></td>
                                        <td><div class="total_mics" style="font-weight:700;"></div></td>
                                        <td><div class="total_extramics" style="font-weight:700;"></div></td>
                                        <td><div class="total_others_days" style="font-weight:700;"></div></td>
                                        <td><div class="total_ent_others" style="font-weight:700;"></div></td>
                                        <td><div class="total_others" style="font-weight:700;"></div></td>
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
    
        var cb5 = $('.sm_tot_wdays').map(function() {return this.value;}).get().join(',');
        $('#sm_tot_wdays_ctrl').val(cb5);
    
        var cb6 = $('.sm_no_d_tiff').map(function() {return this.value;}).get().join(',');
        $('#sm_no_d_tiff_ctrl').val(cb6);
    
        var cb7 = $('.sm_no_d_conv').map(function() {return this.value;}).get().join(',');
        $('#sm_no_d_conv_ctrl').val(cb7);
    
        var cb8 = $('.sm_no_d_misc').map(function() {return this.value;}).get().join(',');
        $('#sm_no_d_misc_ctrl').val(cb8);
    
        var cb9 = $('.sm_et_tiffalw').map(function() {return this.value;}).get().join(',');
        $('#sm_et_tiffalw_ctrl').val(cb9);
    
        var cb10 = $('.sm_e_tiffalw').map(function() {return this.value;}).get().join(',');
        $('#sm_e_tiffalw_ctrl').val(cb10);
    
        var cb11 = $('.sm_et_convalw').map(function() {return this.value;}).get().join(',');
        $('#sm_et_convalw_ctrl').val(cb11);
    
        var cb12 = $('.sm_e_conv').map(function() {return this.value;}).get().join(',');
        $('#sm_e_conv_ctrl').val(cb12);
    
        var cb13 = $('.sm_et_miscalw').map(function() {return this.value;}).get().join(',');
        $('#sm_et_miscalw_ctrl').val(cb13);
    
        var cb14 = $('.sm_e_miscalw').map(function() {return this.value;}).get().join(',');
        $('#sm_e_miscalw_ctrl').val(cb14);
    
        var cb15 = $('.sm_e_extra_misc_alw').map(function() {return this.value;}).get().join(',');
        $('#sm_e_extra_misc_alw_ctrl').val(cb15);
        
        var cb16 = $('.sm_et_otheralw').map(function() {return this.value;}).get().join(',');
        $('#sm_et_otheralw_ctrl').val(cb16);
    
        var cb17 = $('.sm_e_otheralw').map(function() {return this.value;}).get().join(',');
        $('#sm_e_otheralw_ctrl').val(cb17);
        
        var cb18 = $('.sm_no_d_other').map(function() {return this.value;}).get().join(',');
        $('#sm_no_d_other_ctrl').val(cb18);
    
    }
    function calculate_days(empcode){
        
        var total_wday=$('#tot_wdays_'+empcode).val();
        if(total_wday=='') 
            total_wday=0;
    
        var no_tiffin_days=$('#no_d_tiff_'+empcode).val();
        if(no_tiffin_days=='') 
            no_tiffin_days=0;
    
        var no_conv_days=$('#no_d_conv_'+empcode).val();
        if(no_conv_days=='') 
            no_conv_days=0;
    
        var no_misc_days=$('#no_d_misc_'+empcode).val();
        if(no_misc_days=='') 
            no_misc_days=0;
            
        var no_others_days=$('#no_d_other_'+empcode).val();
        if(no_others_days=='') 
            no_others_days=0;
            
    
        var et_tiffin_alw=$('#et_tiffalw_'+empcode).val();
        if(et_tiffin_alw=='') 
            et_tiffin_alw=0;
    
        var et_conv_alw=$('#et_convalw_'+empcode).val();
        if(et_conv_alw=='') 
            et_conv_alw=0;
    
        var et_misc_alw=$('#et_miscalw_'+empcode).val();
        if(et_misc_alw=='') 
            et_misc_alw=0;
            
        var et_other_alw=$('#et_otheralw_'+empcode).val();
        if(et_other_alw=='') 
            et_other_alw=0;		
            
    
        var e_tiffalw=0;
        if(total_wday>0){
            e_tiffalw = eval(et_tiffin_alw)/eval(total_wday);
            e_tiffalw = eval(e_tiffalw)*no_tiffin_days;
            e_tiffalw = Math.round(e_tiffalw * 100)/100;
        }
    
        var e_conv=0;
        if(total_wday>0){
            e_conv = eval(et_conv_alw)/eval(total_wday);
            e_conv = eval(e_conv)*no_conv_days;
            e_conv = Math.round(e_conv * 100)/100;
        }
    
        var e_miscalw=0;
        if(total_wday>0){
            e_miscalw = eval(et_misc_alw)/eval(total_wday);
            e_miscalw = eval(e_miscalw)*no_misc_days;
            e_miscalw = Math.round(e_miscalw * 100)/100;
        }
        
        var e_otheralw=0;
        if(total_wday>0){
            e_otheralw = eval(et_other_alw)/eval(total_wday);
            e_otheralw = eval(e_otheralw)*no_others_days;
            e_otheralw = Math.round(e_otheralw * 100)/100;
        }
    
        $('#e_tiffalw_'+empcode).val(e_tiffalw);		
        $('#e_conv_'+empcode).val(e_conv);		
        $('#e_miscalw_'+empcode).val(e_miscalw);		
        $('#e_otheralw_'+empcode).val(e_otheralw);		
    
    
    
    
    }
    
    $(document).on("keyup", ".sm_no_d_tiff", function() {
        doSumTiffDays();
        doSumEntTiff();
        doSumTiff();
    });
    
    $(document).on("keyup", ".sm_no_d_conv", function() {
        doSumConvDays();
        doSumEntConv();
        doSumConv();
    });
    
    $(document).on("keyup", ".sm_no_d_misc", function() {
        doSumMicsDays();
        doSumEntMics();
        doSumMics();
    });
    
    $(document).on("keyup", ".sm_no_d_other", function() {
        doSumOthersDays();
        doSumEntOthers();
        doSumOthers();
    });
    
    $(document).on("keyup", ".sm_e_extra_misc_alw", function() {
        doSumMicsExtra();
    });
    
    $(document).ready(function(){
        $("#basic-datatables").dataTable().fnDestroy();
        $('#basic-datatables').DataTable({
            lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
            initComplete: function(settings, json) {
                doSumTiffDays();
                doSumEntTiff();
                doSumTiff();
                doSumConvDays();
                doSumEntConv();
                doSumConv();
                doSumMicsDays();
                doSumEntMics();
                doSumMics();
                doSumMicsExtra();
                doSumOthersDays();
                doSumEntOthers();
                doSumOthers();
            }
        });
    });
    
    function doSumTiffDays() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(6).nodes();
        var total = table.column(6).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
    
          total = Math.round(total * 100)/100;
           $(".total_tiff_days").html(total);
    }
    
    function doSumEntTiff() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(7).nodes();
        var total = table.column(7).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
    
          total = Math.round(total * 100)/100;
        $(".total_ent_tiff").html(total);
    }
    
    function doSumTiff() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(8).nodes();
        var total = table.column(8).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
    
          total = Math.round(total * 100)/100;
           $(".total_tiff").html(total);
    }
    
    function doSumConvDays() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(9).nodes();
        var total = table.column(9).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
    
          total = Math.round(total * 100)/100;
        $(".total_conv_days").html(total);
    }
    
    function doSumEntConv() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(10).nodes();
        var total = table.column(10).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
        $(".total_ent_conv").html(total);
    }
    
    function doSumConv() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(11).nodes();
        var total = table.column(11).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
        $(".total_conv").html(total);
    }
    
    function doSumMicsDays() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(12).nodes();
        var total = table.column(12).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
          total = Math.round(total * 100)/100;
        $(".total_mics_days").html(total);
    }
    
    function doSumEntMics() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(13).nodes();
        var total = table.column(13).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
        $(".total_ent_mics").html(total);
    }
    
    function doSumMics() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(14).nodes();
        var total = table.column(14).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
         // alert(total);
        $(".total_mics").html(total);
    }
    
    function doSumMicsExtra() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(15).nodes();
        var total = table.column(15).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
         //alert(total);
        $(".total_extramics").html(total);
    }
    
    function doSumOthersDays() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(12).nodes();
        var total = table.column(12).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
          total = Math.round(total * 100)/100;
        $(".total_others_days").html(total);
    }
    
    function doSumEntOthers() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(13).nodes();
        var total = table.column(13).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
        $(".total_ent_others").html(total);
    }
    
    function doSumOthers() {
        var table = $('#basic-datatables').DataTable();
        var nodes = table.column(14).nodes();
        var total = table.column(14).nodes()
          .reduce( function ( sum, node ) {
            return sum + parseFloat($( node ).find( 'input' ).val());
          }, 0 );
        
          total = Math.round(total * 100)/100;
         // alert(total);
        $(".total_others").html(total);
    }
    
    
    
    
    
    </script>
    @endsection
   