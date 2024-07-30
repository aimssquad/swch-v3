<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <style>
    .main-table tr td,
    .main-table tr th {
        padding: 5px;
    }

    .main-table tr:nth-child(even) {
        background-color: #dbe5f1;
    }

    td {
        font-size: 13px;
    }
    </style>
	
</head>
<body style="position: relative;">
	<div class="wrapper">
        <div style="padding:10px">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="text-align:center">Interview Feedback Report</h1>
                </div>
                <!-- <div class="col-md-12">&nbsp;</div> -->
                <div class="col-md-12">
                    <table  width="100%" style="font-family:calibri;padding: 0 15px;">
                        <tr>
                            <th width="50%" style="background-color:#134f5c;color:#fff;">Candidate Name</th>
                            <th width="50%" style="background-color:#134f5c;color:#fff;">Interview Date</th>
                        </tr>
                        <tr>
                            <td style="text-align:center;">{{$recruitment_interviews->candidate_name}}</td>
                            <td style="text-align:center;">@if($recruitment_interviews->interview_date!=null){{date('d/m/Y',strtotime($recruitment_interviews->interview_date))}}@endif</td>
                        </tr>
                        <tr>
							<th width="50%" style="background-color:#134f5c;color:#fff;">Position Applied For</th>
                            <th width="50%" style="background-color:#134f5c;color:#fff;">Interview Time</th>
                        </tr>
                        <tr>
                            <td style="text-align:center;">{{$recruitment_interviews->title}}</td>
                            <td style="text-align:center;">{{$recruitment_interviews->interview_time}}</td>
                        </tr>
                        <tr>
							<th width="50%" style="background-color:#134f5c;color:#fff;">Company Name</th>
                            <th width="50%" style="background-color:#134f5c;color:#fff;">Date of Birth</th>
                        </tr>
                        <tr>
                            <td style="text-align:center;">{{$Roledata->com_name}}</td>
                            <td style="text-align:center;">@if($candidate_info->dob!=null){{date('d/m/Y',strtotime($candidate_info->dob))}}@endif</td>
                        </tr>
                    </table>
                </div>
                <!-- <div class="col-md-12">&nbsp;</div> -->
                <div class="col-md-12">
                    <table  width="100%" style="font-family:calibri;padding: 0 15px;">
                        <thead>
                            <tr style="background-color:pink;">
                                <th width="80%">Capstone</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $total=0;
                        @endphp
                        @foreach($mock_capstone_details as $capstone)
                            <tr>
                                <td>{{$capstone->capstone_name}}</td>
                                <td style="text-align:center;">{{$capstone->capstone_score}}</td>
                            </tr>
                        @php
                            $total=$total+$capstone->capstone_score;
                        @endphp
                        @endforeach
                            <tr>
                                <th style="text-align:left;">Grand Total</th>
                                <th>{{$total}}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="col-md-12">&nbsp;</div> -->
                <div class="col-md-12">
                    <table  width="100%" style="font-family:calibri;padding: 0 15px;">
                        <thead>
                            <tr style="background-color:skyblue;">
                                <th width="80%">Cognitive Ability</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $total=0;
                        @endphp
                        @foreach($mock_factor_details as $factor)
                            <tr>
                                <td>{{$factor->cognitive_ability_name}}</td>
                                <td style="text-align:center;">{{$factor->caf_score}}</td>
                            </tr>
                        @php
                            $total=$total+$factor->caf_score;
                        @endphp
                        @endforeach
                            <tr>
                                <th style="text-align:left;">Grand Total</th>
                                <th>{{$total}}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="col-md-12">&nbsp;</div> -->
                <div class="col-md-12">
                    <h2 style="text-align:center">Recommendation</h2>
                    <div style="border:1px solid #ccc;padding:10px;">{{$recruitment_interviews->recommendation}}</div>
                </div>
                <div class="col-md-12">
                    <h2 style="text-align:center">Next Step</h2>
                    <div style="border:1px solid #ccc;padding:10px;">
						<table  width="100%" style="font-family:calibri;padding: 0 15px;">
							<tr>
								<td>Police Clearance/Disclosure & Barring Services Check</td>
								<td>@if($recruitment_interviews->police_verification=='Y') <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/green-tick.png" style="width:2%"> @else <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/red-cross.jpg" style="width:2%"> @endif</td>
								<td></td>
							</tr>
							<tr>
								<td>Tuberculosis (TB) Test</td>
								<td>@if($recruitment_interviews->tb_test=='Y') <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/green-tick.png" style="width:2%"> @else <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/red-cross.jpg" style="width:2%"> @endif</td>
								<td><a target="_blank" href="https://www.gov.uk/tb-test-visa">https://www.gov.uk/tb-test-visa</a></td>
							</tr>
							<tr>
								<td>Level 3 Safeguarding Adults Training (If applicable)</td>
								<td>@if($recruitment_interviews->training_required=='Y') <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/green-tick.png" style="width:2%"> @else <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/red-cross.jpg" style="width:2%"> @endif</td>
								<td><a target="_blank" href="https://www.highspeedtraining.co.uk/safeguarding-people/level3-safeguarding-adults-training.aspx">High Seed Training</a></td>
							</tr>
							
						</table>
                        <!-- <div class="row">
                            <div class="col-md-5">Police Clearance/Disclosure & Barring Services Check</div>
                            <div class="col-md-2">@if($recruitment_interviews->police_verification=='Y') <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/green-tick.png" style="width:5%"> @else <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/red-cross.jpg" style="width:5%"> @endif </div>
                            <div class="col-md-5"></div>
                            <div class="col-md-5">Tuberculosis (TB) Test</div>
                            <div class="col-md-2">@if($recruitment_interviews->tb_test=='Y') <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/green-tick.png" style="width:5%"> @else <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/red-cross.jpg" style="width:5%"> @endif</div>
                            <div class="col-md-5"><a target="_blank" href="https://www.gov.uk/tb-test-visa">https://www.gov.uk/tb-test-visa</a></div>
                            <div class="col-md-5">Level 3 Safeguarding Adults Training (If applicable)</div>
                            <div class="col-md-2">@if($recruitment_interviews->training_required=='Y') <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/green-tick.png" style="width:5%"> @else <img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/red-cross.jpg" style="width:5%"> @endif</div>
                            <div class="col-md-5"><a target="_blank" href="https://www.highspeedtraining.co.uk/safeguarding-people/level3-safeguarding-adults-training.aspx">High Seed Training</a></div>
                        </div> -->
                    </div>
                </div>
                
            </div>
            
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