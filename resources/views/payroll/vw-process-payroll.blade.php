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
         <li class="nav-item active"><a href="#">Process Employee Payroll</a></li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                 @include('layout.message')
                  <div class="card-body">
                    <form action="{{url('payroll/vw-process-payroll')}}" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
                        {{ csrf_field() }}
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="text-input" class=" form-control-label" style="text-align:right;">Select Month</label>
                            </div>
                            <div class="col-md-6">
                                <select data-placeholder="Choose Month..." name="month" id="month" class="form-control" required>
                                    <option value="" selected disabled > Select </option>
                                    @foreach ($monthlist as $month)
                                    <option value="<?php echo $month->month_yr; ?>" @if(isset($req_month) && $req_month==$month->month_yr) selected @endif><?php echo $month->month_yr; ?></option>
                                    @endforeach
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
         @if (!empty($process_payroll))
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Process Attendance</h4>
                    </div> --}}
                    <div class="card-body">
                        <form action="{{url('payroll/edit-process-payroll')}}" method="post" id="myForm">
                            {{csrf_field()}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" id="deleteme" name="deleteme" class="deleteme" value="" />
                            <input type="hidden" id="deletemy" name="deletemy" class="deletemy" value="@if(isset($month_yr)){{$month_yr}} @endif" />
								<table id="basic-datatables" class="table table-striped table-bordered table-responsive">
									<thead style="text-align:center;vertical-align:middle;">
                                        <tr>
											<th>
												<div class="checkbox">
													<label><input type="checkbox" name="all" id="all" width="30px;" height="30px;">
														Select</label>
												</div>
											</th>
											<td>Employee ID</td>
											<td>Employee Code</td>
											<td>Employee Name</td>
											<td>Month</td>
											<td>Basic Pay</td>
											  @if(count($rate_master)!=0)
												@foreach($rate_master as $rate)
											@if($rate->id <27)
													@if($rate->head_type=='earning')
												<td>{{$rate->head_name}}</td>
											@endif
												@endif
												@endforeach
												@endif
													<td>Others</td>
													@if(count($rate_master)!=0)
												@foreach($rate_master as $rate)
											@if($rate->id <27)
													@if($rate->head_type=='deduction')
												<td>{{$rate->head_name}}</td>
											@endif
												@endif
												@if($rate->id ==29)
													@if($rate->head_type=='deduction')
												<td>{{$rate->head_name}}</td>
											@endif
												@endif
												@endforeach
												@endif


													<td>Inc. Tax.</td>
													<td>Others</td>
											<td>Gross Salary</td>
											<td>Deduction</td>
											<td>Net Salary</td>
											<td>Action</td>
										</tr>
									</thead>

									<tbody>

										<?php if (!empty($process_payroll)) {
    									foreach ($process_payroll as $processpayroll) {?>
												<tr>
													<td>
														<div class="checkbox"><label><input type="checkbox" name="payroll_id[]" value="<?php echo $processpayroll->id; ?>"></label>

														</div>
													</td>

													<td>{{$processpayroll->employee_id}}</td>
													<td>{{$processpayroll->old_emp_code}}</td>
													<td>{{$processpayroll->emp_name}}</td>
													<td>{{$processpayroll->month_yr}}</td>
													<td>{{$processpayroll->emp_basic_pay}}</td>
													 <td>{{$processpayroll->emp_da}}</td>
													<td>{{$processpayroll->emp_vda}}</td>
													<td>{{$processpayroll->emp_hra}}</td>
													<td>{{$processpayroll->emp_others_alw}}</td>
													<td>{{$processpayroll->emp_tiff_alw}}</td>
													<td>{{$processpayroll->emp_conv}}</td>
													<td>{{$processpayroll->emp_medical}}</td>
													<td>{{$processpayroll->emp_misc_alw}}</td>
													<td>{{$processpayroll->emp_over_time}}</td>
													<td>{{$processpayroll->emp_bouns}}</td>
													<td>{{$processpayroll->emp_leave_inc}}</td>
													<td>{{$processpayroll->emp_hta}}</td>

													<td>{{$processpayroll->other_addition}}</td>
														<td>{{$processpayroll->emp_prof_tax}}</td>
													<td>{{$processpayroll->emp_pf}}</td>
													<td>{{$processpayroll->emp_pf_int}}</td>
													<td>{{$processpayroll->emp_apf}}</td>
													<td>{{$processpayroll->emp_i_tax}}</td>
													<td>{{$processpayroll->emp_insu_prem}}</td>
													<td>{{$processpayroll->emp_pf_loan}}</td>
													<td>{{$processpayroll->emp_esi}}</td>
													<td>{{$processpayroll->emp_adv}}</td>
														<td>{{$processpayroll->emp_hrd}}</td>
														<td>{{$processpayroll->emp_co_op}}</td>
															<td>{{$processpayroll->emp_furniture}}</td>
															<td>{{$processpayroll->emp_misc_ded}}</td>
															<td>@if($processpayroll->emp_pf_employer==null) 0 @else {{$processpayroll->emp_pf_employer}} @endif</td>
													<td>{{$processpayroll->emp_income_tax}}</td>
													<td>{{$processpayroll->emp_others_deduction}}</td>
													<td>{{$processpayroll->emp_gross_salary}}</td>
													<td>{{$processpayroll->emp_total_deduction}}</td>
													<td>{{$processpayroll->emp_net_salary}}</td>
													<td>
														<a href='{{url("pis/payrolldelete/$processpayroll->id")}}'  onclick="return confirm('Are you sure you want to delete this?');"><i class="fas fa-trash"></i></a>
													</td>
												</tr>

										<?php }
                                    }?>

									</tbody>
									<tfoot>

										<tr>
											<td colspan="7" style="border:none;"><button type="submit" class="btn btn-info btn-sm">Save</button><button type="submit" name="btnDelete" class="btn btn-info btn-sm" style="background-color:red !important;float:right;" onclick="confirmDelete(event);">Delete All Records for the month</button></td>

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
        // Listen for click on toggle checkbox for each Page
        $('#all').click(function(event) {
    
            if (this.checked) {
                //alert("test");
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    
    
        // Listen for click on toggle checkbox for each Page
        $('#all').click(function(event) {
    
            if (this.checked) {
                //alert("test");
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    
        function confirmDelete(e){
            e.preventDefault();
            if (confirm("Do you want to delete all the generated records for the month?") == true) {
            //text = "You pressed OK!";
                $('#deleteme').val('yes');
                $('#myForm').submit();
            }
        }
        /*function deleteProcessPayroll(clrt){
    
            alert(clrt);
    
    
        }*/
    </script>
	
    @endsection
   