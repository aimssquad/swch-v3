<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
		<link rel="icon" href="{{ asset('img/favicon.png')}}">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
			<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
	 <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

	 
</head>
<body>
	<div class="wrapper">

  @include('recruitment.include.header')
		<!-- Sidebar -->

		  @include('recruitment.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">Package</h4> -->
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-archive"></i> Edit Mock Interview</h4>
								</div>
								<div class="card-body" style="">
									<form action="" method="post" enctype="multipart/form-data">
			                        {{csrf_field()}}
			                            <input type="hidden" name="id"  class="form-control" value="<?php if (!empty($mock_interview_id)) {echo $mock_interview_id;}?>">
			                            <input type="hidden" name="form_id"  class="form-control" value="<?php echo $form_id;?>">
			                            <input type="hidden" name="job_id"  class="form-control" value="<?php echo $interview_form_details->job_id;?>">
										<div class="row">
											<div class="col-md-4"></div>
											<div class="col-md-4">
												<div class="form-group ">
										            <label for="position" class="placeholder">Position</label>
                                                    <input type="text" id="position" name="position"  class="form-control" value="{{$joblist->title}}" disabled>
											    </div>
											</div>
											<div class="col-md-4"></div>
											<div class="col-md-6">
												<div class="col-md-12">
													<div class="form-group ">
														<label for="candidate_id" class="placeholder">Candidate Name</label>
														<select class="form-control" name="candidate_id" id="candidate_id" required onchange="getCandidateInfo(this.value);" readonly=true>
															<option value="">Select Candidate</option>   
															@foreach($candidates as $item)
															<option value="{{$item->id}}" @if($recruitment_interviews->candidate_id==$item->id) selected @endif>{{$item->name}} </option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="total_exp" class="placeholder">Total Experience (in Yrs)</label>
														@php
                                                            $experience_yrs=0;
                                                            if($candidate_info->exp!=''){
                                                                $experience_yrs=$candidate_info->exp*12;
                                                            }
                                                            if($candidate_info->exp_month!=''){
                                                                $experience_yrs=$experience_yrs+$candidate_info->exp_month;
                                                            }
                                                            $experience_yrs=$experience_yrs/12;
                                                        @endphp
														<input type="text" id="total_exp" name="total_exp"  class="form-control" value="{{$experience_yrs}}" readonly>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="present_employer" class="placeholder">Present Employer</label>
														<input type="text" id="present_employer" name="present_employer" value="{{$candidate_info->cur_or}}" class="form-control" readonly>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="highest_education" class="placeholder">Highest Education</label>
														<input type="text" id="highest_education" name="highest_education"  class="form-control" value="{{$candidate_info->quli}}" readonly>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="dob" class="placeholder">Date of Birth</label>
														<input type="date" id="dob" name="dob"  class="form-control" value="{{$candidate_info->dob}}" readonly>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-12">
													<div class="form-group ">
														<label for="interview_date" class="placeholder">Interview Date</label>
															<input type="date" id="interview_date" name="interview_date"  class="form-control " value="{{$recruitment_interviews->interview_date}}" >
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="interview_time" class="placeholder">Interview Time</label>
															<input type="text" id="interview_time" name="interview_time"  class="form-control " value="{{$recruitment_interviews->interview_time}}" >
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="present_position" class="placeholder">Present Position</label>
														<input type="text" id="present_position" name="present_position"  class="form-control" value="{{$candidate_info->cur_deg}}" readonly>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="institution" class="placeholder">Institution</label>
														<input type="text" id="institution" name="institution"  class="form-control" value="{{$recruitment_interviews->institution}}" >
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group ">
														<label for="interviewer" class="placeholder">Interviewer Name</label>
															<input type="text" id="interviewer" name="interviewer"  class="form-control " value="{{$recruitment_interviews->interviewer}}" >
													</div>
												</div>
											</div>
											<div class="col-md-12">
                                                <div class="table-responsive" style="padding-top:10px;">
										            <table class="display table table-hover" border=1 style="border-color:#ccc;">
                                                        
														<input type="hidden" name="section_ids" id="section_ids" value="{{$section_ids}}" readonly=true>
														<input type="hidden" name="factor_ids" id="factor_ids" value="{{$factor_ids}}" readonly=true>
														<input type="hidden" name="rating_out_off" id="rating_out_off" value="{{$interview_form_details->rating_out_off}}" readonly=true>
                                                        @foreach($interview_form_capstone as $capstone)
                                                            <tr style="background-color:#ddd;">
                                                                <th rowspan=2>Sl. No.</th>
                                                                <th rowspan=2>{{$capstone->capstone_name}}</th>
                                                                <th colspan={{$interview_form_details->rating_out_off+1}} style="text-align:center;">Rating</th>
                                                                
                                                                <th rowspan=2>Comment</th>
                                                                <!-- <th rowspan=2>Score</th> -->
                                                            </tr>
                                                            <tr style="background-color:#ddd;">
															<?php for($i=0;$i<=$interview_form_details->rating_out_off;$i++){?>
                                                                <th style="text-align:center;"><?php echo $i; ?></th>
															<?php } ?>
                                                            </tr>
															@php
                                                                $section_ques_ctr=1;
                                                            @endphp
                                                            @foreach($interview_form_questions as $ques)
                                                            @if($capstone->id==$ques->form_capstone_id)
                                                            <tr>
                                                                <td>{{$section_ques_ctr}}</td>
                                                                <td>{{$ques->question}}</td>

																@if (!empty($mock_interview_details))
                                                                    @foreach($mock_interview_details as $record)
                                                                        @if($record->form_question_id==$ques->id)
                                                                        <?php for($i=0;$i<=$interview_form_details->rating_out_off;$i++){?>
                                                                            <td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_{{$i}}" value="{{$i}}" onclick="setRating({{$ques->id}});" <?php if ($record->rating==$i) { echo 'checked';}?> ></td>
                                                                        <?php } ?>

                                                                        <td>
																			<!-- <input type="text" name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" value="{{$record->comment}}" readonly> -->
																			<textarea name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" rows=2 cols=50 class="form-control" >{{$record->comment}}</textarea>
																		<!-- </td>

                                                                        <td> -->
																			
																		<input type="hidden" name="rating_{{$ques->id}}" id="rating_{{$ques->id}}" value="{{$record->rating}}" readonly=true class="secrate_{{$capstone->id}} cafrate_{{$ques->form_cognitive_ability_id}}">
                                                                        <input type="hidden" name="standard_{{$ques->id}}" id="standard_{{$ques->id}}" value="1" readonly=true class="secstand_{{$capstone->id}}">
                                                                        <input type="hidden" name="cafstandard_{{$ques->id}}" id="cafstandard_{{$ques->id}}" value="1" readonly=true class="cafstand_{{$ques->form_cognitive_ability_id}}">
                                                                        </td>

                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                
																<?php for($i=0;$i<=$interview_form_details->rating_out_off;$i++){?>
																	<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_{{$i}}" value="{{$i}}" onclick="setRating({{$ques->id}});"></td>
																<?php } ?>

																<td><input type="text" name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" value="" ></td>

																<td><input type="text" name="rating_{{$ques->id}}" id="rating_{{$ques->id}}" value="0" readonly=true class="secrate_{{$capstone->id}} cafrate_{{$ques->form_cognitive_ability_id}}">
																<input type="hidden" name="standard_{{$ques->id}}" id="standard_{{$ques->id}}" value="1" readonly=true class="secstand_{{$capstone->id}}">
																<input type="hidden" name="cafstandard_{{$ques->id}}" id="cafstandard_{{$ques->id}}" value="1" readonly=true class="cafstand_{{$ques->form_cognitive_ability_id}}">
																</td>
                                                                @endif

																<!-- <td>
																</td> -->
															</tr>
                                                            @php
                                                                $section_ques_ctr=$section_ques_ctr+1;
                                                            @endphp
                                                            @endif
                                                            @endforeach
                                                        @endforeach
                                                        
                                                    </table>
                                                </div>
                                            </div>
											<div style="display:none">
												<div class="col-md-1"></div>
												<div class="col-md-10">
												<div class="table-responsive">
														<table class="display table table-striped table-hover" border=1 style="border-color:#ccc;">
															<thead>
																<tr style="background-color:pink;">
																	<th>Capstone</th>
																	<th>Value</th>
																	<th>R-Score</th>
																	<th>Load (in %)</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
															@foreach($interview_form_capstone as $capstone)
																<tr>
																	<td>{{$capstone->capstone_name}}</td>

																	<td><input type="text" name="cap_value_{{$capstone->id}}" id="cap_value_{{$capstone->id}}" value="" readonly></td>
																	<td><input type="text" name="cap_rscore_{{$capstone->id}}" id="cap_rscore_{{$capstone->id}}" value="" readonly></td>
																	<td><input type="number" step="any" name="cap_load_{{$capstone->id}}" id="cap_load_{{$capstone->id}}" value="{{$capstone->weightage}}" readonly></td>
																	<td><input type="text" name="cap_score_{{$capstone->id}}" id="cap_score_{{$capstone->id}}" value="" readonly></td>

																</tr>
																
															@endforeach
																<tr style="background-color:lightgrey;font-weight:bold;">
																	<td>Total</td>
																	<td><label id="lb_cap_value" style="font-weight:bold;"></label><input type="hidden" name="cap_value" id="cap_value" value="" readonly>
																	</td>
																	<td><label id="lb_cap_rscore" style="font-weight:bold;"></label><input type="hidden" name="cap_rscore" id="cap_rscore" value="" readonly></td>
																	<td></td>
																	<td><label id="lb_cap_score" style="font-weight:bold;"></label><input type="hidden" name="cap_score" id="cap_score" value="" readonly></td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-md-1"></div>
											</div>
											<div style="display:none">							
												<div class="col-md-1"></div>
												<div class="col-md-10">
												<div class="table-responsive">
														<table class="display table table-striped table-hover" border=1 style="border-color:#ccc;">
															<thead>
																<tr style="background-color:skyblue;">
																	<th>Cognitive Ability</th>
																	<th>Value</th>
																	<th>R-Score</th>
																	<th>Load (in %)</th>
																	<th>Score</th>
																</tr>
															</thead>
															<tbody>
															@foreach($interview_form_ca as $factor)
																<tr>
																	<td>{{$factor->cognitive_ability_name}}</td>

																	<td><input type="text" name="caf_value_{{$factor->id}}" id="caf_value_{{$factor->id}}" value="" readonly></td>
																	<td><input type="text" name="caf_rscore_{{$factor->id}}" id="caf_rscore_{{$factor->id}}" value="" readonly></td>
																	<td><input type="number" step="any" name="caf_load_{{$factor->id}}" id="caf_load_{{$factor->id}}" value="{{$factor->weightage}}" readonly></td>
																	<td><input type="text" name="caf_score_{{$factor->id}}" id="caf_score_{{$factor->id}}" value="" readonly></td>

																</tr>
																
															@endforeach
																<tr style="background-color:lightgrey;font-weight:bold;">
																	<td>Total</td>
																	<td><label id="lb_caf_value" style="font-weight:bold;"></label><input type="hidden" name="caf_value" id="caf_value" value="" readonly>
																	</td>
																	<td><label id="lb_caf_rscore" style="font-weight:bold;"></label><input type="hidden" name="caf_rscore" id="caf_rscore" value="" readonly></td>
																	<td></td>
																	<td><label id="lb_caf_score" style="font-weight:bold;"></label><input type="hidden" name="caf_score" id="caf_score" value="" readonly></td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-md-1"></div>
											</div>

											<div class="col-md-12">
												<div style="font-weight:bold;text-align:left;">Outcome</div>
												<div class="row">

													<div class="col-md-4">
														<div class="form-group ">
															
															<input type="radio" id="outcome_eligible" name="outcome"  style="float: left;clear: none;margin: 2px 0 0 2px;"   value="eligible" <?php if(isset($recruitment_interviews->outcome) && $recruitment_interviews->outcome=='eligible'){?>checked<?php } ?> >
															<label for="outcome_eligible" class="placeholder" style="float: left;clear: none;display: block;padding: 0px 1em 0px 8px;">Eligible for employment</label>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group ">
															
															<input type="radio" id="outcome_not_eligible" name="outcome"  style="float: left;clear: none;margin: 2px 0 0 2px;"   value="not eligible" <?php if(isset($recruitment_interviews->outcome) && $recruitment_interviews->outcome=='not eligible'){?>checked<?php } ?> >
															<label for="outcome_not_eligible" class="placeholder" style="float: left;clear: none;display: block;padding: 0px 1em 0px 8px;">Not eligible for employment</label>
														</div>
	
													</div>
													<div class="col-md-4">
														<div class="form-group ">
															<input type="radio" id="outcome_second_choice" name="outcome"  style="float: left;clear: none;margin: 2px 0 0 2px;" value="Second Choice" <?php if(isset($recruitment_interviews->outcome) && $recruitment_interviews->outcome=='Second Choice'){?>checked<?php } ?> >
															<label for="outcome_second_choice" class="placeholder" style="float: left;clear: none;display: block;padding: 0px 1em 0px 8px;">2<sup>nd</sup> Choice
															</label>
														</div>
	
													</div>
												</div>
											</div>
                                            <div class="col-md-12">&nbsp;</div>
											<div class="col-md-12">
												<div style="font-weight:bold;text-align:left;">Expected Salary/Wage <small>(Please ✔ and put number in blank space if applicable)</small></div>
												<div class="row">

													<div class="col-md-4">
														<div class="form-group ">
															
															<input type="radio" id="expected_salary_1" name="expected_salary"  style="float: left;clear: none;margin: 2px 0 0 2px;" value="National Minimum Wage" <?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='National Minimum Wage'){?>checked<?php } ?> >
															<label for="outcome_eligible" class="placeholder" style="float: left;clear: none;display: block;padding: 0px 1em 0px 8px;">National Minimum Wage</label>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group ">
															
															<input type="radio" id="expected_salary_per_hour" name="expected_salary"  style="float: left;clear: none;margin: 2px 0 0 2px;" value="expected_salary_per_hour" <?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_hour'){?>checked<?php } ?> > &pound; <input type="number" step="any" name="expected_salary_per_hour" id="expected_salary_per_hour" value="<?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_hour'){?>{{$recruitment_interviews->expected_salary_value}}<?php } ?>" style="border:0;border-bottom:1px solid;" > / Hour
															
														</div>
	
													</div>
													<div class="col-md-4">
														<div class="form-group ">
														<input type="radio" id="expected_salary_per_week" name="expected_salary"  style="float: left;clear: none;margin: 2px 0 0 2px;"   value="expected_salary_per_week" <?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_week'){?>checked<?php } ?> > &pound; <input type="number" step="any" name="expected_salary_per_week" id="expected_salary_per_week" value="<?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_hour'){?>{{$recruitment_interviews->expected_salary_value}}<?php } ?>" style="border:0;border-bottom:1px solid;" > / Week
														</div>
	
													</div>
													<div class="col-md-4">
														<div class="form-group ">
														<input type="radio" id="expected_salary_per_month" name="expected_salary"  style="float: left;clear: none;margin: 2px 0 0 2px;"   value="expected_salary_per_month" <?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_month'){?>checked<?php } ?> > &pound; <input type="number" step="any" name="expected_salary_per_month" id="expected_salary_per_month" value="<?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_month'){?>{{$recruitment_interviews->expected_salary_value}}<?php } ?>" style="border:0;border-bottom:1px solid;" > / Month
														</div>
	
													</div>
													<div class="col-md-4">
														<div class="form-group ">
														<input type="radio" id="expected_salary_per_year" name="expected_salary"  style="float: left;clear: none;margin: 2px 0 0 2px;"   value="expected_salary_per_year" <?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_year'){?>checked<?php } ?> > &pound; <input type="number" step="any" name="expected_salary_per_year" id="expected_salary_per_year" value="<?php if(isset($recruitment_interviews->expected_salary) && $recruitment_interviews->expected_salary=='expected_salary_per_year'){?>{{$recruitment_interviews->expected_salary_value}}<?php } ?>" style="border:0;border-bottom:1px solid;" > / Year
														</div>
	
													</div>
												</div>
											</div>
                                            <div class="col-md-12">&nbsp;</div>
											<div class="col-md-12">
												<div style="font-weight:bold;text-align:left;">Work Arrangement <small>(Please ✔ and put number in blank space if applicable)</small></div>
												<div class="row">

													<div class="col-md-4">
														<div class="form-group ">
															
														<input type="radio" id="work_arrangement_day" name="work_arrangement"  style="float: left;clear: none;margin: 2px 0 0 2px;"   value="work_arrangement_day" <?php if(isset($recruitment_interviews->work_arrangement) && $recruitment_interviews->work_arrangement=='work_arrangement_day'){?>checked<?php } ?> > &pound; <input type="number" step="any" name="work_arrangement_day" id="work_arrangement_day" value="<?php if(isset($recruitment_interviews->work_arrangement) && $recruitment_interviews->work_arrangement=='work_arrangement_day'){?>{{$recruitment_interviews->work_arrangement_value}}<?php } ?>" style="border:0;border-bottom:1px solid;"> Hours/Day
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group ">
															
															<input type="radio" id="work_arrangement_week" name="work_arrangement"  style="float: left;clear: none;margin: 2px 0 0 2px;"   value="work_arrangement_week" <?php if(isset($recruitment_interviews->work_arrangement) && $recruitment_interviews->work_arrangement=='work_arrangement_week'){?>checked<?php } ?> > &pound; <input type="number" step="any" name="work_arrangement_week" id="work_arrangement_week" value="<?php if(isset($recruitment_interviews->work_arrangement) && $recruitment_interviews->work_arrangement=='work_arrangement_week'){?>{{$recruitment_interviews->work_arrangement_value}}<?php } ?>" style="border:0;border-bottom:1px solid;"> Hours/Week
															
														</div>
	
													</div>
													
												</div>
											</div>
                                            <div class="col-md-12">&nbsp;</div>
											<div class="col-md-6">
												<div class="form-group ">
													<label for="expected_start_date" class="placeholder">Expected Start Date</label>
													<input type="date" id="expected_start_date" name="expected_start_date"  class="form-control" value="{{$recruitment_interviews->expected_start_date}}" >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group ">
													<label for="comment" class="placeholder">Other Comment</label>
													<textarea id="comment" name="comment" class="form-control" >{{$recruitment_interviews->comment}}</textarea>
												</div>
											</div>
                                            <div class="col-md-12 btn-up">
                                                <button type="submit" class="btn btn-default" >Submit</button>
                                            </div>
                                        </div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@include('recruitment.include.footer')
		</div>

	</div>
	<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});
			
			<?php if (isset($premock_interview->candidate_id)) { ?>
                getCandidateInfo({{$premock_interview->candidate_id}});
				calc_capstone();
				calc_factor();
            <?php }else{ ?>
            	calc_capstone();
				calc_factor();
			<?php } ?>
            
		});

        function setRating(question_id)
        {
            var check=$('input[name="rate_'+question_id+'"]:checked').val();
			$('input[name="rating_'+question_id+'"]').val(check);
			calc_capstone();
			calc_factor();
        }

		function calc_capstone(){
			var str = $('#section_ids').val();
			var str_array = str.split(',');
			var cap_value=0;
			var cap_rscore=0;
			var cap_load=0;
			var cap_score=0;

			var tot_cap_value=0;
			var tot_cap_rscore=0;
			var tot_cap_score=0;

			for(var i = 0; i < str_array.length; i++) {
				// Trim the excess whitespace.
				str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
				// Add additional code here, such as:
				//console.log('------Section----'+str_array[i]);
				cap_value=0;
				$('.secstand_'+str_array[i]).each(function(index, element) {
					//console.log('.secstand_'+str_array[i]+'==='+element.id+'==='+element.value);
					cap_value=eval(cap_value)+eval(element.value);
				});
				cap_value=cap_value*$('#rating_out_off').val();
				$('#cap_value_'+str_array[i]).val(cap_value);
				tot_cap_value=eval(tot_cap_value)+eval(cap_value);

				cap_rscore=0;
				$('.secrate_'+str_array[i]).each(function(index, element) {
					//console.log('.secrate_'+str_array[i]+'==='+element.id+'==='+element.value);
					cap_rscore=eval(cap_rscore)+eval(element.value);
				});

				$('#cap_rscore_'+str_array[i]).val(cap_rscore);
				tot_cap_rscore=eval(tot_cap_rscore)+eval(cap_rscore);

				cap_load=$('#cap_load_'+str_array[i]).val();
				cap_score=cap_rscore*(eval(cap_load)/100);
				cap_score=Math.round((cap_score + Number.EPSILON) * 100) / 100;
				$('#cap_score_'+str_array[i]).val(cap_score);
				tot_cap_score=eval(tot_cap_score)+eval(cap_score);
				tot_cap_score=Math.round((tot_cap_score + Number.EPSILON) * 100) / 100;

			}
			$('#cap_value').val(tot_cap_value);
			$('#cap_rscore').val(tot_cap_rscore);
			$('#cap_score').val(tot_cap_score);

			$('#lb_cap_value').html(tot_cap_value);
			$('#lb_cap_rscore').html(tot_cap_rscore);
			$('#lb_cap_score').html(tot_cap_score);
		}

		function calc_factor(){
			var str = $('#factor_ids').val();
			var str_array = str.split(',');
			var caf_value=0;
			var caf_rscore=0;
			var caf_load=0;
			var caf_score=0;

			var tot_caf_value=0;
			var tot_caf_rscore=0;
			var tot_caf_score=0;

			for(var i = 0; i < str_array.length; i++) {
				// Trim the excess whitespace.
				str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
				// Add additional code here, such as:
				//console.log('------Section----'+str_array[i]);
				cap_value=0;
				$('.cafstand_'+str_array[i]).each(function(index, element) {
					//console.log('.cafstand_'+str_array[i]+'==='+element.id+'==='+element.value);
					caf_value=eval(caf_value)+eval(element.value);
				});
				// console.log('caf_value=='+caf_value);
				// console.log('rating_out_off=='+$('#rating_out_off').val());
				caf_value=caf_value*$('#rating_out_off').val();
				$('#caf_value_'+str_array[i]).val(caf_value);
				tot_caf_value=eval(tot_caf_value)+eval(caf_value);

				caf_rscore=0;
				$('.cafrate_'+str_array[i]).each(function(index, element) {
					//console.log('.cafrate_'+str_array[i]+'==='+element.id+'==='+element.value);
					caf_rscore=eval(caf_rscore)+eval(element.value);
				});

				$('#caf_rscore_'+str_array[i]).val(caf_rscore);
				tot_caf_rscore=eval(tot_caf_rscore)+eval(caf_rscore);

				caf_load=$('#caf_load_'+str_array[i]).val();
				caf_score=caf_rscore*(eval(caf_load)/100);
				caf_score=Math.round((caf_score + Number.EPSILON) * 100) / 100;
				$('#caf_score_'+str_array[i]).val(caf_score);
				tot_caf_score=eval(tot_caf_score)+eval(caf_score);
				tot_caf_score=Math.round((tot_caf_score + Number.EPSILON) * 100) / 100;

			}
			$('#caf_value').val(tot_caf_value);
			$('#caf_rscore').val(tot_caf_rscore);
			$('#caf_score').val(tot_caf_score);

			$('#lb_caf_value').html(tot_caf_value);
			$('#lb_caf_rscore').html(tot_caf_rscore);
			$('#lb_caf_score').html(tot_caf_score);
		}

        function getCandidateInfo(candidate_id)
        {
            $.ajax({
                type:'GET',
                url:"{{url('pis/getInterviewCandidateInfo')}}/"+candidate_id,
                beforeSend: function() {
                    //$('#section').attr('disabled', true);
                },
                success: function(response){
                    var obj = jQuery.parseJSON(response);
                   //console.log(Object.keys(obj).length);
				   
                    if(Object.keys(obj).length>0){
                        
						var experience_yrs=0;
						if(obj.exp!=''){
							experience_yrs=eval(eval(obj.exp)*12);
						}
						if(obj.exp_month!=''){
							experience_yrs=experience_yrs+eval(obj.exp_month);
						}
						// experience_yrs=eval(eval(obj.exp)*12)+eval(obj.exp_month);
						console.log(experience_yrs);
						experience_yrs=experience_yrs/12;
						$("#total_exp").val(experience_yrs);
						console.log(obj);
						if(obj.cur_or!=''){
							$("#present_employer").val(obj.cur_or);
						}
						if(obj.cur_deg!=''){
							$("#present_position").val(obj.cur_deg);
						}
						if(obj.dob!=''){
							$("#dob").val(obj.dob);
						}
						if(obj.quli!=''){
							$("#highest_education").val(obj.quli);
						}
                    }
                    
                }
            });
        }



	</script>

</body>
</html>