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
         <li class="nav-item active"><a href="#">Yearly Employee Bonus</a></li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{url('payroll/add-yearly-bonus')}}" class="btn btn-outline-primary mb-3">Generate Yearly
                        Employee Bonus  <i class="fa fa-plus"></i></a>
                </div>
                @include('layout.message')
                  <div class="card-body">
                    <form action="{{url('payroll/vw-yearly-bonus')}}" method="post" enctype="multipart/form-data"
                            style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
                            {{ csrf_field() }}
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label" style="text-align:right;">Select
                                    Pay Month/Year</label>
                                </div>
                                <div class="col-md-6">
                                    <select data-placeholder="Choose Year..." name="year" id="year" class="form-control"
                                        required>
                                        <option value="" selected disabled> Select </option>
                                        @foreach ($yearlist as $rec)
                                        <option value="<?php echo $rec->year; ?>" @if(isset($req_year) &&
                                            $req_year==$rec->year) selected @endif><?php echo $rec->year; ?></option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('year'))
                                    <div class="error" style="color:red;">{{ $errors->first('year') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info"
                                        style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;">Go</button>
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
                        <form action="{{url('payroll/update-bonus-all')}}" method="post" id="myForm">
                            {{csrf_field()}}
                            <input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
                            <input type="hidden" id="deleteme" name="deleteme" class="deleteme" value="" />
                            <input type="hidden" id="statusme" name="statusme" class="statusme" value="" />
                            <input type="hidden" id="deletemy" name="deletemy" class="deletemy"
                                value="@if(isset($req_year)){{$req_year}} @endif" />
                            <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl"
                                class="sm_emp_code_ctrl" value="" />

                            <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl"
                                class="sm_month_yr_ctrl" value="" />

                            <input type="hidden" id="sm_basic_ctrl" name="sm_basic_ctrl" class="sm_basic_ctrl"
                                value="" />
                            <input type="hidden" id="sm_bonus_ctrl" name="sm_bonus_ctrl" class="sm_bonus_ctrl"
                                value="" />
                            <input type="hidden" id="sm_exgratia_ctrl" name="sm_exgratia_ctrl"
                                class="sm_exgratia_ctrl" value="" />
                            <input type="hidden" id="sm_deduction_ctrl" name="sm_deduction_ctrl"
                                class="sm_deduction_ctrl" value="" />

                            <table id="basic-datatables" class="table table-striped table-bordered table-responsive">
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:5%;">Sl. No.</th>
                                        <th style="width:8%;">Employee Id</th>
                                        <th style="width:10%;">Employee Code</th>
                                        <th style="width:18%;">Employee Name</th>
                                        <th style="width:9%;">Year</th>
                                        <th>Basic Pay</th>
                                        <th>Bonus</th>
                                        <th>Exgratia</th>
                                        <th>Deduction</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php print_r($result);?>
                                </tbody>

                                <tfoot>

                                    <tr>
                                        <td colspan="6" style="border:none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-danger btn-sm checkall"
                                                        style="margin-right:2%;">Check All</button>
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="map_controls();">Save</button>
                                                    <button type="reset" class="btn btn-danger btn-sm">
                                                        Reset</button>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="">Select Status</option>
                                                        <option value="process" selected>Pending</option>
                                                        <option value="approved">Approved</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" name="btnDelete"
                                                        class="btn btn-danger btn-sm"
                                                        style="background-color:red;float:right;"
                                                        onclick="confirmDelete(event);">Delete All Records for this
                                                        year</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="total_bonus" style="font-weight:700;"></div></td>
                                        <td><div class="total_exgratia" style="font-weight:700;"></div></td>
                                        <td><div class="total_deduction" style="font-weight:700;"></div></td>
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
        
            var ele = document.getElementsByName('empcode_check[]');
            // alert(ele.length);
            for (var i = 0; i < ele.length; i++) {
                if (ele[i].type == 'checkbox')
                    ele[i].checked = true;
            }
            map_controls();
        });
        
        
        function confirmDelete(e) {
            e.preventDefault();
            if (confirm("Do you want to delete all the generated records for this year?") == true) {
                //text = "You pressed OK!";
                $('#deleteme').val('yes');
                $('#myForm').submit();
            }
        }
        
        function map_controls() {
        
            var cb = $('.checkhour:checked').map(function() {
                return this.value;
            }).get().join(',');
            $('#cboxes').val(cb);
        
            var cb1 = $('.sm_emp_code').map(function() {
                return this.value;
            }).get().join(',');
            $('#sm_emp_code_ctrl').val(cb1);
        
            var cb2 = $('.sm_month_yr').map(function() {
                return this.value;
            }).get().join(',');
            $('#sm_month_yr_ctrl').val(cb2);
        
            var cb3 = $('.sm_basic').map(function() {
                return this.value;
            }).get().join(',');
            $('#sm_basic_ctrl').val(cb3);
        
            var cb4 = $('.sm_bonus').map(function() {
                return this.value;
            }).get().join(',');
            $('#sm_bonus_ctrl').val(cb4);
        
            var cb5 = $('.sm_exgratia').map(function() {
                return this.value;
            }).get().join(',');
            $('#sm_exgratia_ctrl').val(cb5);
        
            var cb6 = $('.sm_deduction').map(function() {
                return this.value;
            }).get().join(',');
            $('#sm_deduction_ctrl').val(cb6);
        
            $('#statusme').val($('#status').val());
        }
        
        $(document).on("keyup", ".sm_bonus", function() {
            doSumBonus();
        
        });
        $(document).on("keyup", ".sm_exgratia", function() {
            doSumExgratia();
        
        });
        $(document).on("keyup", ".sm_deduction", function() {
            doSumDeduction();
        
        });
        
        
        function calBonus(empcode,bonus_rate){
            //alert($('#basic_'+empcode).val());
            var basic=$('#basic_'+empcode).val();
            var bonus=(basic*bonus_rate)/100;
        
            bonus = Math.round(bonus * 100) / 100;
            $('#bonus_'+empcode).val(bonus);
            doSumBonus();
        }
        
        
        $(document).ready(function() {
            $("#bootstrap-data-table").dataTable().fnDestroy();
            $('#bootstrap-data-table').DataTable({
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                initComplete: function(settings, json) {
                    doSumBonus();
                    doSumExgratia();
                    doSumDeduction();
                }
            });
        
        });
        
        function doSumBonus() {
            var table = $('#bootstrap-data-table').DataTable();
            var nodes = table.column(6).nodes();
            var total = table.column(6).nodes()
                .reduce(function(sum, node) {
                    return sum + parseFloat($(node).find('input').val());
                }, 0);
        
            total = Math.round(total * 100) / 100;
            $(".total_bonus").html(total);
        }
        
        function doSumExgratia() {
            var table = $('#bootstrap-data-table').DataTable();
            var nodes = table.column(7).nodes();
            var total = table.column(7).nodes()
                .reduce(function(sum, node) {
                    return sum + parseFloat($(node).find('input').val());
                }, 0);
        
            total = Math.round(total * 100) / 100;
            $(".total_exgratia").html(total);
        }
        
        function doSumDeduction() {
            var table = $('#bootstrap-data-table').DataTable();
            var nodes = table.column(8).nodes();
            var total = table.column(8).nodes()
                .reduce(function(sum, node) {
                    return sum + parseFloat($(node).find('input').val());
                }, 0);
        
            total = Math.round(total * 100) / 100;
            $(".total_deduction").html(total);
        }
        </script>
	
    @endsection
   