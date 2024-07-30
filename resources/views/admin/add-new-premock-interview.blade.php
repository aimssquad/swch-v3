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

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
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
									<h4 class="card-title"><i class="fas fa-archive"></i> <?php if (!empty($premock_interview->id)) {echo 'Edit';}else{ echo 'Add';}?> Pre-Mock Interview</h4>
								</div>
								<div class="card-body" style="">
									<form action="{{ url('superadmin/add-premock-interview') }}" method="post" enctype="multipart/form-data">
			                        {{csrf_field()}}
			                            <input type="hidden" name="id"  class="form-control" value="<?php if (!empty($premock_interview->id)) {echo $premock_interview->id;}?>">
										<div class="row">
		 	                                <div class="col-md-12">
										        <div class="form-group ">
										            <label for="candidate_id" class="placeholder">Candidate </label>
                                                    <select class="form-control" name="candidate_id" id="candidate_id" required onchange="getCandidateInfo(this.value);">
                                                        <option value="">Select Candidate</option>   
                                                        @foreach($candidates as $item)
                                                        <option value="{{$item->id}}" <?php if (isset($premock_interview->candidate_id) && $premock_interview->candidate_id == $item->id) {echo 'selected';}?>>{{$item->candidate_name}} | {{$item->client_name}} | {{$item->position->postion_name}}</option>
                                                        @endforeach 
                                   
                                                    </select>
											    </div>
										    </div>
		 	                                <div class="col-md-6">
										        <div class="form-group ">
										            <label for="position" class="placeholder">Position Title</label>
                                                    <input type="text" id="position" name="position"  class="form-control" disabled>
											    </div>
										    </div>
		 	                                <div class="col-md-6">
										        <div class="form-group ">
										            <label for="client_name" class="placeholder">Client Name</label>
                                                    <input type="text" id="client_name" name="client_name"  class="form-control" disabled>
											    </div>
										    </div>
		 	                                <div class="col-md-6">
										        <div class="form-group ">
										            <label for="interviewer" class="placeholder">Interviewer Name</label>
										      	        <input type="text" id="interviewer" name="interviewer"  class="form-control "   value="<?php if (!empty($premock_interview->interviewer)) {echo $premock_interview->interviewer;}?>" required>
											    </div>
										    </div>
		 	                                <div class="col-md-6">
										        <div class="form-group ">
										            <label for="interview_date" class="placeholder">Interview Date</label>
										      	        <input type="date" id="interview_date" name="interview_date"  class="form-control "   value="<?php if (!empty($premock_interview->interview_date)) {echo $premock_interview->interview_date;}?>" required>
											    </div>
										    </div>

                                            <div class="col-md-12">
                                                <div class="table-responsive">
										            <table class="display table table-hover" border=1 style="border-color:#ccc;">
                                                        
														<input type="hidden" name="section_ids" id="section_ids" value="{{$section_ids}}" readonly=true>
                                                        @foreach($sections as $section)
                                                            <tr style="background-color:#ddd;">
                                                                <th rowspan=2>Sl. No.</th>
                                                                <th rowspan=2>{{$section->section_name}}</th>
                                                                <th colspan=4 style="text-align:center;">Rating</th>
                                                                <th rowspan=2>Candidate Profiling Factors</th>
                                                                <th rowspan=2>Comment</th>
                                                                <th rowspan=2>Check</th>
                                                            </tr>
                                                            <tr style="background-color:#ddd;">
                                                                <th style="text-align:center;">0</th>
                                                                <th style="text-align:center;">1</th>
                                                                <th style="text-align:center;">2</th>
                                                                <th style="text-align:center;">3</th>
                                                            </tr>
                                                            @php
                                                                $section_ques_ctr=1;
                                                            @endphp
                                                            @foreach($questions as $ques)
                                                            @if($section->section_name==$ques->section)
                                                            <tr>
                                                                <td>{{$section_ques_ctr}}</td>
                                                                <td>{{$ques->question}}</td>
																@if (!empty($premock_interview_detail))
																	@foreach($premock_interview_detail as $record)
																		@if($record->question_id==$ques->id)
																			<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_0" value="0" onclick="setRating({{$ques->id}});" <?php if ($record->rating==0) { echo 'checked';}?>></td>

																			<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_1" value="1" onclick="setRating({{$ques->id}});" <?php if ($record->rating==1) { echo 'checked';}?>></td>

																			<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_2" value="2" onclick="setRating({{$ques->id}});" <?php if ($record->rating==2) { echo 'checked';}?>></td>

																			<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_3" value="3" onclick="setRating({{$ques->id}});" <?php if ($record->rating==3) { echo 'checked';}?>></td>

																			<td><input type="text" name="factor_{{$ques->id}}" id="factor_{{$ques->id}}" value="{{$record->profile_factor}}"></td>

																			<td><input type="text" name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" value="{{$record->comment}}"></td>

																			<td><input type="text" name="rating_{{$ques->id}}" id="rating_{{$ques->id}}" value="{{$record->rating}}" readonly=true class="secrate_{{$section->id}}">
																			<input type="hidden" name="standard_{{$ques->id}}" id="standard_{{$ques->id}}" value="1" readonly=true class="secstand_{{$section->id}}"></td>
																		@endif
																	@endforeach
																@else

																	<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_0" value="0" onclick="setRating({{$ques->id}});"></td>

																	<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_1" value="1" onclick="setRating({{$ques->id}});"></td>

																	<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_2" value="2" onclick="setRating({{$ques->id}});"></td>

																	<td style="text-align:center;"><input type="radio" name="rate_{{$ques->id}}" id="rate_{{$ques->id}}_3" value="3" onclick="setRating({{$ques->id}});"></td>

																	<td><input type="text" name="factor_{{$ques->id}}" id="factor_{{$ques->id}}" value=""></td>

																	<td><input type="text" name="comment_{{$ques->id}}" id="comment_{{$ques->id}}" value=""></td>

																	<td><input type="text" name="rating_{{$ques->id}}" id="rating_{{$ques->id}}" value="0" readonly=true class="secrate_{{$section->id}}"><input type="hidden" name="standard_{{$ques->id}}" id="standard_{{$ques->id}}" value="1" readonly=true class="secstand_{{$section->id}}"></td>
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
                                                        @foreach($sections as $section)
															<tr>
																<td>{{$section->section_name}}</td>

																@if (!empty($premock_capstone_detail))
																	@foreach($premock_capstone_detail as $record)
																		@if($record->section_id==$section->id)
																			<td><input type="text" name="cap_value_{{$section->id}}" id="cap_value_{{$section->id}}" value="{{$record->capstone_value}}" readonly></td>
																			<td><input type="text" name="cap_rscore_{{$section->id}}" id="cap_rscore_{{$section->id}}" value="{{$record->capstone_rscore}}" readonly></td>
																			<td><input type="number" step="any" name="cap_load_{{$section->id}}" id="cap_load_{{$section->id}}" value="{{$record->capstone_load}}" readonly></td>
																			<td><input type="text" name="cap_score_{{$section->id}}" id="cap_score_{{$section->id}}" value="{{$record->capstone_score}}" readonly></td>
																		@endif
																	@endforeach
																@else
																	<td><input type="text" name="cap_value_{{$section->id}}" id="cap_value_{{$section->id}}" value="" readonly></td>
																	<td><input type="text" name="cap_rscore_{{$section->id}}" id="cap_rscore_{{$section->id}}" value="" readonly></td>
																	<td><input type="number" step="any" name="cap_load_{{$section->id}}" id="cap_load_{{$section->id}}" value="{{$section->section_load}}" readonly></td>
																	<td><input type="text" name="cap_score_{{$section->id}}" id="cap_score_{{$section->id}}" value="" readonly></td>
																@endif

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
										    <div class="col-md-10">
										        <div class="form-group ">
										            <label for="interviewer" class="placeholder">Comment</label>
										      	        
														<textarea name="comment" id="comment" rows="3" style="width:100%"><?php if (!empty($premock_interview->comment)) {echo $premock_interview->comment;}?></textarea>  
											    </div>
										    </div>
										    <div class="col-md-2">
										        <div class="form-group text-center">
										            <label for="interviewer" class="placeholder">Qualifying Score</label>
										      	        
														<h1>60%</h1>  
											    </div>
										    </div>
                                            <div class="col-md-12 btn-up">
                                                <button type="submit" class="btn btn-default" >Submit</button></div>
                                            </div>
                                        </div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@include('admin.include.footer')
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
            <?php }else{ ?>
            	calc_capstone();
			<?php } ?>
            
		});

        function setRating(question_id)
        {
            var check=$('input[name="rate_'+question_id+'"]:checked').val();
			$('input[name="rating_'+question_id+'"]').val(check);
			calc_capstone();
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
				cap_value=cap_value*3;
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

        function getCandidateInfo(candidate_id)
        {
            $.ajax({
                type:'GET',
                url:"{{url('pis/get-candidate-position-client')}}/"+candidate_id,
                beforeSend: function() {
                    //$('#section').attr('disabled', true);
                },
                success: function(response){
                    var obj = jQuery.parseJSON(response);
                   //console.log(Object.keys(obj).length);
                    if(Object.keys(obj).length>0){
                        $("#position").val(obj.position_name);
                        $("#client_name").val(obj.client_name);
                    }
                    
                }
            });
        }



	</script>

</body>
</html>