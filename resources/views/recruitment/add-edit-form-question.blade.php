<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->
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
    <link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
	<style>
		.btn-danger {
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<div class="wrapper">
	  	@include('recruitment.include.header')
		<!-- Sidebar -->
		
		@include('recruitment.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
				<ul class="breadcrumbs">
					<li class="nav-home">
						<a href="#">
							Home
						</a>
					</li>
					
					<li class="separator">
						/
					</li>
					<li class="nav-item">
					<a href="{{url('recruitment/interview-forms')}}">Interview Forms</a>
					</li>
					<li class="separator">
					/
					</li>
					<li class="nav-item active">
						Interview Form Questions
					</li>
				</ul>
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									
									<h4 class="card-title"><i class="fas fa-briefcase"></i> Map Interview Form Questions</h4>
                                	
								</div>
								<div class="card-body" style="">
									<form action="" method="post" enctype="multipart/form-data">
										<input type="hidden" id="exist_rem_question" name="exist_rem_question" value="">
										
			 							{{csrf_field()}}
										<div class="row">
											<div class="col-md-3">
												<div class=" form-group">
													<label for="job_id" class="placeholder">Job Position</label><br/>
													{{$interview_form->job_title}}
												</div>
											</div>
											<div class="col-md-3">
												<div class=" form-group">
													<label for="form_name" class="placeholder">Form Name  </label><br/>
													{{$interview_form->form_name}}
													
												</div>
											</div>
											<div class="col-md-3">
												<div class=" form-group">
													<label for="rating_out_off" class="placeholder">Scaling  </label><br/>
                                                    0 - {{$interview_form->rating_out_off}}
													
												</div>
											</div>
											<div class="col-md-3">
												<div class=" form-group">
                                                    <label for="category_id" class="placeholder">Industry</label><br/>
                                                    {{$interview_form->category_name}}
													
												</div>
											</div>
											
										</div>	
										<div class="answer">
											<div class="row form-group">
												<div class="col-md-12">
													<div class="hd-hd"
														style="border-bottom: 2px solid #1572e8;width: 100%;margin: 20px auto -24px;">
													</div>
													<div class="hd1-hd" style="text-align: center;">
														<div
															style="display: inline-block;background: #ffffff;padding: 0 20px;">
															<h2
																style="text-align: center;font-size: 27px;color: #5f6061;font-weight: 500;margin: 5px 0px 30px 0px;">
																Questions</h2>
																<input id="question_room" type="hidden" name="question_room" value="<?php if(isset($interview_form_question) && $interview_form_question!=null){  echo count($interview_form_question);  }else{ echo "1";}?>">
														</div>
													</div>
												</div>
											</div>	
											<div id="question_set">
                                                @if(count($interview_form_question)>0)
                                                    @foreach($interview_form_question as $ifques=>$fques)
                                                        <input id="form_question_id_<?php echo $ifques+1; ?>" type="hidden" name="form_question_id[]" value="{{$fques->id}}">
                                                        @if($ifques==0)
                                                        <div class="row form-group removeclass<?php echo $ifques+1; ?>">
                                                            <div class="col-md-4">
                                                                <label for="question_<?php echo $ifques+1; ?>" class="placeholder">Question</label>
                                                                <select class="form-control select2_el" name="question[]" id="question_<?php echo $ifques+1; ?>" required>
                                                                    <option value="">Select Question</option>   
                                                                    @foreach($questions as $item)
                                                                    <option value="{{$item->id}}" <?php if ($fques->question_id == $item->id) {echo 'selected';}?>>{{$item->question}} </option>
                                                                    @endforeach 
                                            
                                                                </select>
                                                                
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="capstone_<?php echo $ifques+1; ?>" class="placeholder">Capstone</label>
                                                                <select class="form-control" name="capstone[]" id="capstone_<?php echo $ifques+1; ?>" required>
                                                                    <option value="">Select Capstone</option>   
                                                                    @foreach($interview_form_capstone as $item)
                                                                    <option value="{{$item->id}}" <?php if ($fques->form_capstone_id == $item->id) {echo 'selected';}?>>{{$item->capstone_name}} </option>
                                                                    @endforeach 
                                            
                                                                </select>
                                                                
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="factor_<?php echo $ifques+1; ?>" class="placeholder">Cognitive Ability Factor</label>
                                                                <select class="form-control" name="factor[]" id="factor_<?php echo $ifques+1; ?>" required>
                                                                    <option value="">Select Factor</option>   
                                                                    @foreach($interview_form_ca as $item)
                                                                    <option value="{{$item->id}}" <?php if ($fques->form_cognitive_ability_id == $item->id) {echo 'selected';}?>>{{$item->cognitive_ability_name}} </option>
                                                                    @endforeach 
                                            
                                                                </select>
                                                                
                                                            </div>
                                                            
                                                            <div class="col-md-2" style="margin-top:28px;">
                                                                <button class="btn btn-success" type="button"
                                                                    onclick="addRowQuestion();"><i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>	
                                                        @else
                                                        <div class="row form-group removeclass<?php echo $ifques+1; ?>">
                                                            <div class="col-md-4">
                                                                <label for="question_<?php echo $ifques+1; ?>" class="placeholder">Question</label>
                                                                <select class="form-control select2_el" name="question[]" id="question_<?php echo $ifques+1; ?>" required>
                                                                    <option value="">Select Question</option>   
                                                                    @foreach($questions as $item)
                                                                    <option value="{{$item->id}}" <?php if ($fques->question_id == $item->id) {echo 'selected';}?>>{{$item->question}} </option>
                                                                    @endforeach 
                                            
                                                                </select>
                                                                
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="capstone_<?php echo $ifques+1; ?>" class="placeholder">Capstone</label>
                                                                <select class="form-control" name="capstone[]" id="capstone_<?php echo $ifques+1; ?>" required>
                                                                    <option value="">Select Capstone</option>   
                                                                    @foreach($interview_form_capstone as $item)
                                                                    <option value="{{$item->id}}" <?php if ($fques->form_capstone_id == $item->id) {echo 'selected';}?>>{{$item->capstone_name}} </option>
                                                                    @endforeach 
                                            
                                                                </select>
                                                                
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="factor_<?php echo $ifques+1; ?>" class="placeholder">Cognitive Ability Factor</label>
                                                                <select class="form-control" name="factor[]" id="factor_<?php echo $ifques+1; ?>" required>
                                                                    <option value="">Select Factor</option>   
                                                                    @foreach($interview_form_ca as $item)
                                                                    <option value="{{$item->id}}" <?php if ($fques->form_cognitive_ability_id == $item->id) {echo 'selected';}?>>{{$item->cognitive_ability_name}} </option>
                                                                    @endforeach 
                                            
                                                                </select>
                                                                
                                                            </div>
                                                            
                                                            <div class="col-md-2" style="margin-top:28px;">
                                                                <button class="btn btn-success" type="button"
                                                                    onclick="addRowQuestion();"><i class="fas fa-plus"></i>
                                                                </button>
                                                                @if($ifques+1==count($interview_form_question))
																<button class="btn btn-danger btn-question-remove" id="btn_question_remove_<?php echo $ifques+1; ?>" type="button" onclick="remove_question_set(<?php echo $ifques+1; ?>);"><i class="fas fa-minus"></i></button>
																@else
																<button class="btn btn-danger btn-question-remove" style="display:none;" id="btn_question_remove_<?php echo $ifques+1; ?>" type="button" onclick="remove_question_set(<?php echo $ifques+1; ?>);"><i class="fas fa-minus"></i></button>
																@endif
                                                                
                                                                
                                                            </div>
                                                        </div>	
                                                        @endif
                                                    @endforeach
                                                @else
												<div class="row form-group">
													<div class="col-md-4">
														<label for="question_1" class="placeholder">Question</label>
                                                        <select class="form-control select2_el" name="question[]" id="question_1" required>
                                                            <option value="">Select Question</option>   
                                                            @foreach($questions as $item)
                                                            <option value="{{$item->id}}" >{{$item->question}} </option>
                                                            @endforeach 
                                    
                                                        </select>
														
													</div>
													<div class="col-md-3">
														<label for="capstone_1" class="placeholder">Capstone</label>
                                                        <select class="form-control" name="capstone[]" id="capstone_1" required>
                                                            <option value="">Select Capstone</option>   
                                                            @foreach($interview_form_capstone as $item)
                                                            <option value="{{$item->id}}" >{{$item->capstone_name}} </option>
                                                            @endforeach 
                                    
                                                        </select>
														
													</div>
													<div class="col-md-3">
														<label for="factor_1" class="placeholder">Cognitive Ability Factor</label>
                                                        <select class="form-control" name="factor[]" id="factor_1" required>
                                                            <option value="">Select Factor</option>   
                                                            @foreach($interview_form_ca as $item)
                                                            <option value="{{$item->id}}" >{{$item->cognitive_ability_name}} </option>
                                                            @endforeach 
                                    
                                                        </select>
														
													</div>
													
													<div class="col-md-2" style="margin-top:28px;">
														<button class="btn btn-success" type="button"
															onclick="addRowQuestion();"><i class="fas fa-plus"></i>
														</button>
													</div>
												</div>	
                                                @endif
																			
											</div>									
										</div>	
										
										
										<div class="row form-group">
											
											<div class="col-md-6">
												@if($interview_form_inuse>0)
												<a class="btn btn-default" href="{{url('recruitment/interview-forms')}}" style="margin-top: 12px;">Back</a>
												@else
												<button type="submit" class="btn btn-default" style="margin-top: 12px;">Submit</button>
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
    <script src="{{ asset('assets/js/select2.min.js')}}"></script>
	<script >
		$(document).ready(function() {
			initailizeSelect2();
		});
        // Initialize select2
        function initailizeSelect2() {

            $(".select2_el").select2();
        }
		var room = document.getElementById('question_room').value;
		//alert(room);

		function addRowQuestion() {
			// alert(room);

			room++;
			var objTo = document.getElementById('question_set')
			var divtest = document.createElement("div");
			divtest.setAttribute("class", "form-group removeclass" + room);
			var rdiv = 'removeclass' + room;

			$('.btn-question-remove').hide();

			divtest.innerHTML =
				'<div class="row form-group"><div class="col-md-4"><label for="question_' + room +'" class="placeholder">Question</label><select class="form-control select2_el" name="question[]" id="question_' + room +'" required><option value="">Select Question</option>@foreach($questions as $item)<option value="{{$item->id}}" >{{$item->question}} </option>@endforeach</select></div><div class="col-md-3"><label for="capstone_' + room +'" class="placeholder">Capstone</label><select class="form-control" name="capstone[]" id="capstone_' + room +'" required><option value="">Select Capstone</option>@foreach($interview_form_capstone as $item)<option value="{{$item->id}}" >{{$item->capstone_name}} </option>@endforeach</select></div><div class="col-md-3"><label for="factor_' + room +'" class="placeholder">Cognitive Ability Factor</label><select class="form-control" name="factor[]" id="factor_' + room +'" required><option value="">Select Factor</option>@foreach($interview_form_ca as $item)<option value="{{$item->id}}" >{{$item->cognitive_ability_name}} </option>@endforeach</select></div><div class="col-md-2" style="margin-top:28px;"><button class="btn btn-success" type="button" onclick="addRowQuestion();"><i class="fas fa-plus"></i></button> <button class="btn btn-danger btn-question-remove" id="btn_question_remove_' + room +'" type="button" onclick="remove_question_set(' + room + ');"><i class="fas fa-minus"></i></button></div></div>';

			objTo.appendChild(divtest);
			$('#question_room').val(room);
            initailizeSelect2();
		}

		function remove_question_set(rid) {
			var prevrid=rid-1;
			if(prevrid>1){
				$('#btn_question_remove_'+prevrid).show();
			}
			//alert($('#question_id_' + rid).val());
			if($('#form_question_id_' + rid).val() !=undefined){
				//alert('hi');
				$('#exist_rem_question').val($('#exist_rem_question').val()+$('#form_question_id_' + rid).val()+",");
			}
			$('.removeclass' + rid).remove();
			room--;
			$('#question_room').val(room);
		}


	</script>
	
</body>
</html>