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
									<h4 class="card-title"><i class="fas fa-archive"></i>Mock Interview Feedback</h4>
								</div>
								<div class="card-body" style="">
									<form action="" method="post" enctype="multipart/form-data">
			                        {{csrf_field()}}
			                            <input type="hidden" id="interview_id" name="interview_id" value="{{$interview_id}}">
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label for="candidate_id" class="placeholder">Candidate Name</label>
                                                    <input type="text" id="candidate_id" name="candidate_id"  class="form-control" value="{{$recruitment_interviews->candidate_name}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
													<div class="form-group ">
														<label for="interview_date" class="placeholder">Interview Date</label>
															<input type="date" id="interview_date" name="interview_date"  class="form-control " value="{{$recruitment_interviews->interview_date}}" readonly>
													</div>
												</div>
												
											<div class="col-md-6">
												<div class="form-group ">
										            <label for="position" class="placeholder">Position</label>
                                                    <input type="text" id="position" name="position"  class="form-control" value="{{$recruitment_interviews->title}}" readonly>
											    </div>
											</div>
											<div class="col-md-6">
                                                <div class="form-group ">
                                                    <label for="interview_time" class="placeholder">Interview Time</label>
                                                        <input type="text" id="interview_time" name="interview_time"  class="form-control " value="{{$recruitment_interviews->interview_time}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label for="company_name" class="placeholder">Company Name</label>
                                                        <input type="text" id="company_name" name="company_name"  class="form-control " value="{{$Roledata->com_name}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label for="dob" class="placeholder">Date of Birth</label>
                                                    <input type="date" id="dob" name="dob"  class="form-control" value="{{$candidate_info->dob}}" readonly>
                                                </div>
                                            </div>
											
											<div class="col-md-12" style="display:none;">
                                                <div class="table-responsive" style="padding-top:10px;">
										            <table class="display table table-hover" border=1 style="border-color:#ccc;">
                                                        
														<input type="hidden" name="section_ids" id="section_ids" value="{{$section_ids}}" readonly=true>
														<input type="hidden" name="factor_ids" id="factor_ids" value="{{$factor_ids}}" readonly=true>
														<input type="hidden" name="rating_out_off" id="rating_out_off" value="{{$interview_form_details->rating_out_off}}" readonly=true>
                                                        @foreach($interview_form_capstone as $capstone)
                                                            <tr style="background-color:#ddd;">
                                                                <th rowspan=2 width="5%">Sl. No.</th>
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
                                                                            <td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_{{$i}}" value="{{$i}}" onclick="setRating({{$ques->id}});" <?php if ($record->rating==$i) { echo 'checked';}?> disabled></td>
                                                                        <?php } ?>

                                                                        <td>
																			<!-- <input type="text" name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" value="{{$record->comment}}" readonly> -->

																		<textarea name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" rows=2 cols=50 class="form-control" readonly>{{$record->comment}}</textarea>
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

																<td><input type="text" name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" value="" readonly></td>

																<td><input type="text" name="rating_{{$ques->id}}" id="rating_{{$ques->id}}" value="0" readonly=true class="secrate_{{$capstone->id}} cafrate_{{$ques->form_cognitive_ability_id}}">
																<input type="hidden" name="standard_{{$ques->id}}" id="standard_{{$ques->id}}" value="1" readonly=true class="secstand_{{$capstone->id}}">
																<input type="hidden" name="cafstandard_{{$ques->id}}" id="cafstandard_{{$ques->id}}" value="1" readonly=true class="cafstand_{{$ques->form_cognitive_ability_id}}">
																</td>
                                                                @endif
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
											<div class="col-md-12">&nbsp;</div>
												<div class="col-md-1"></div>
												<div class="col-md-10">
												<div class="table-responsive">
														<table class="display table table-striped table-hover" border=1 style="border-color:#ccc;">
															<thead>
																<tr style="background-color:pink;">
																	<th width="40%">Capstone</th>
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
											
												<div class="col-md-1"></div>
												<div class="col-md-10">
												<div class="table-responsive">
														<table class="display table table-striped table-hover" border=1 style="border-color:#ccc;">
															<thead>
																<tr style="background-color:skyblue;">
																	<th width="40%">Cognitive Ability</th>
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
											
                                            <div class="col-md-12">&nbsp;</div>
											<div class="col-md-6">
                                                <div class="form-group ">
                                                    <label for="recommendation" class="placeholder">Recommendation</label>
                                                    
                                                    <textarea class="form-control" id="recommendation" name="recommendation" rows=5 required @if($recruitment_interviews->feedback_submitted=='Y') readonly @endif>{{$recruitment_interviews->recommendation}}</textarea>
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="form-group ">
                                                    <label for="dob" class="placeholder">Next Step</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group ">
                                                                <label for="police_verification" class="placeholder">Police Clearance/Disclosure & Barring Services Check</label> 
                                                                <select  id="police_verification" name="police_verification" required @if($recruitment_interviews->feedback_submitted=='Y') readonly @endif>
                                                                    <option value="" @if($recruitment_interviews->police_verification=='') selected @endif>Select</option>
                                                                    <option value="Y" @if($recruitment_interviews->police_verification=='Y') selected @endif>Yes</option>
                                                                    <option value="N" @if($recruitment_interviews->police_verification=='N') selected @endif>No</option>
                                                                <select>
                                                            
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group ">
                                                                <label for="tb_test" class="placeholder">Tuberculosis (TB) Test</label> 
                                                                <select  id="tb_test" name="tb_test" required @if($recruitment_interviews->feedback_submitted=='Y') readonly @endif>
                                                                    <option value="" @if($recruitment_interviews->tb_test=='') selected @endif>Select</option>
                                                                    <option value="Y" @if($recruitment_interviews->tb_test=='Y') selected @endif>Yes</option>
                                                                    <option value="N" @if($recruitment_interviews->tb_test=='N') selected @endif>No</option>
                                                                <select>
                                                                <a target="_blank" href="https://www.gov.uk/tb-test-visa">https://www.gov.uk/tb-test-visa</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group ">
                                                                <label for="training_required" class="placeholder">Level 3 Safeguarding Adults Training (If applicable)</label> 
                                                                <select  id="training_required" name="training_required" required @if($recruitment_interviews->feedback_submitted=='Y') readonly @endif>
                                                                    <option value="" @if($recruitment_interviews->training_required=='') selected @endif>Select</option>
                                                                    <option value="Y" @if($recruitment_interviews->training_required=='Y') selected @endif>Yes</option>
                                                                    <option value="N" @if($recruitment_interviews->training_required=='N') selected @endif>No</option>
                                                                <select>
                                                                <a target="_blank" href="https://www.highspeedtraining.co.uk/safeguarding-people/level3-safeguarding-adults-training.aspx">High Seed Training</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-12 btn-up">
                                            @if($recruitment_interviews->feedback_submitted=='Y')
                                            <a class="btn btn-default" href="{{url('recruitment/interviews')}}" style="margin-top: 12px;">Back</a>
                                            @else
                                            <button type="submit" class="btn btn-default" >Submit</button>
                                            @endif
											@if($recruitment_interviews->feedback_submitted=='Y')
											<a class="btn btn-default" style="margin-top: 12px;" href="{{url('recruitment/interview-feedback-report/')}}/{{$recruitment_interviews->id}}"><i class="fa fa-download"></i>&nbsp; Download Summary Report</a>
											@endif
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