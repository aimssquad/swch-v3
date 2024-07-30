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
						@if(isset($_GET['id']))
						<a href="#"> Edit Interview Form</a>
						@else
						<a href="#"> New Interview Form</a>
						@endif
					</li>
				</ul>
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									@if(isset($_GET['id']))
									<h4 class="card-title"><i class="fas fa-briefcase"></i> Edit Interview Form</h4>
                            		@else
									<h4 class="card-title"><i class="fas fa-briefcase"></i> Add Interview Form</h4>
                                	@endif 
								</div>
								<div class="card-body" style="">
									<form action="" method="post" enctype="multipart/form-data">
										<input type="hidden" id="exist_rem_caf" name="exist_rem_caf" value="">
										<input type="hidden" id="exist_rem_cap" name="exist_rem_cap" value="">
			 							{{csrf_field()}}
										<div class="row">
											<div class="col-md-4">
												<div class=" form-group">
													<label for="job_id" class="placeholder">Job Position</label>
													<select id="job_id" type="text" class="form-control input-border-bottom"  name="job_id">
														<option value="" >&nbsp;</option>
														@if(count($joblist)!=0)
															@foreach($joblist as $recruitment_job)
																@if(isset($_GET['id']))
																<option value="{{ $recruitment_job->id }}" <?php if($recruitment_job->id==$interview_form->job_id){ ?> selected <?php } ?>>{{ $recruitment_job->title }}</option>
																@else
																<option value="{{ $recruitment_job->id }}" >{{ $recruitment_job->title }}</option>
																@endif
															@endforeach  
														@endif
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label for="form_name" class="placeholder">Form Name  </label>
													<input id="form_name" type="text" class="form-control input-border-bottom" required="" name="form_name" value="<?php if(isset($_GET['id'])){  echo $interview_form->form_name;  }?>{{ old('form_name') }}">
													
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label for="rating_out_off" class="placeholder">Scaling  </label>
													<input id="rating_out_off" type="number" step=1 class="form-control input-border-bottom" required="" name="rating_out_off" value="<?php if(isset($_GET['id'])){  echo $interview_form->rating_out_off;  }?>{{ old('rating_out_off') }}">
													
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
                                                    <label for="category_id" class="placeholder">Industry</label>
                                                    <select class="form-control" name="category_id" id="category_id" required>
                                                        <option value="">Select Industry</option>   
                                                        @foreach($categories as $item)
                                                        <option value="{{$item->id}}" <?php if(isset($_GET['id']) && $item->id==$interview_form->category_id){ ?> selected <?php } ?>>{{$item->category_name}} </option>
                                                        @endforeach 
                                   
                                                    </select>
													
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
                                            		<label for="status">Status</label>
                                            
													<select class="form-control" name="status" id="status" required>
                                                        <option value="">Select Status</option>   
                                                        @foreach($status as $indx=>$item)
                                                        <option value="{{$indx}}" <?php if (isset($_GET['id']) && $interview_form->status == $indx) {echo 'selected';}?>>{{$item}} </option>
                                                        @endforeach 
                                   
                                                    </select>
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
																Capstones</h2>
																<input id="capstone_room" type="hidden" name="capstone_room" value="<?php if(isset($_GET['id'])){  echo count($interview_form_capstone);  }else{ echo "1";}?>">
														</div>
													</div>
												</div>
											</div>	
											<div id="capstone_set">
												@if(isset($_GET['id']))
													@foreach($interview_form_capstone as $ifcap=>$fcap)
														<input id="capstone_id_<?php echo $ifcap+1; ?>" type="hidden" name="capstone_id[]" value="<?php if(isset($_GET['id'])){  echo $fcap->id;  }else{ echo "";}?>">

														@if($ifcap==0)
														<div class="row form-group removeclass<?php echo $ifcap+1; ?>">
															<div class="col-md-5">
																<label for="capstone_name_<?php echo $ifcap+1; ?>" class="placeholder">Capstone Title</label>
																<input id="capstone_name_<?php echo $ifcap+1; ?>" type="text" class="form-control input-border-bottom" required="" name="capstone_name[]" value="{{$fcap->capstone_name}}">
															</div>
															<div class="col-md-5">
																<label for="weightage_<?php echo $ifcap+1; ?>" class="placeholder">Weightage %</label>
																<input id="weightage_<?php echo $ifcap+1; ?>" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage[]" value="{{$fcap->weightage}}">
															</div>
															<div class="col-md-2" style="margin-top:28px;">
																<button class="btn btn-success" type="button"
																	onclick="addRowCapstone();"><i class="fas fa-plus"></i>
																</button>
															</div>
														</div>	
														@else
														<div class="row form-group removeclass<?php echo $ifcap+1; ?>">
															<div class="col-md-5">
																<label for="capstone_name_<?php echo $ifcap+1; ?>" class="placeholder">Capstone Title</label>
																<input id="capstone_name_<?php echo $ifcap+1; ?>" type="text" class="form-control input-border-bottom" required="" name="capstone_name[]" value="{{$fcap->capstone_name}}">
															</div>
															<div class="col-md-5">
																<label for="weightage_<?php echo $ifcap+1; ?>" class="placeholder">Weightage %</label>
																<input id="weightage_<?php echo $ifcap+1; ?>" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage[]" value="{{$fcap->weightage}}">
															</div>
															<div class="col-md-2" style="margin-top:28px;">
																<button class="btn btn-success" type="button"
																	onclick="addRowCapstone();"><i class="fas fa-plus"></i>
																</button> 
																@if($ifcap+1==count($interview_form_capstone))
																<button class="btn btn-danger btn-cap-remove" id="btn_cap_remove_<?php echo $ifcap+1; ?>" type="button" onclick="remove_capstone_set(<?php echo $ifcap+1; ?>);"><i class="fas fa-minus"></i></button>
																@else
																<button class="btn btn-danger btn-cap-remove" style="display:none;" id="btn_cap_remove_<?php echo $ifcap+1; ?>" type="button" onclick="remove_capstone_set(<?php echo $ifcap+1; ?>);"><i class="fas fa-minus"></i></button>
																@endif
															</div>
														</div>	

														@endif
													@endforeach
												@else
												<div class="row form-group">
													<div class="col-md-5">
														<label for="capstone_name_1" class="placeholder">Capstone Title</label>
														<input id="capstone_name_1" type="text" class="form-control input-border-bottom" required="" name="capstone_name[]" value="">
													</div>
													<div class="col-md-5">
														<label for="weightage_1" class="placeholder">Weightage %</label>
														<input id="weightage_1" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage[]" value="">
													</div>
													<div class="col-md-2" style="margin-top:28px;">
														<button class="btn btn-success" type="button"
															onclick="addRowCapstone();"><i class="fas fa-plus"></i>
														</button>
													</div>
												</div>	
												@endif								
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
																Cognitive Abilities</h2>
																<input id="caf_room" type="hidden" name="caf_room" value="<?php if(isset($_GET['id'])){  echo count($interview_form_ca);  }else{ echo "1";}?>">
														</div>
													</div>
												</div>
											</div>	
											<div id="caf_set">
												@if(isset($_GET['id']))
													@foreach($interview_form_ca as $ifca=>$fca)
														<input id="cognitive_ability_id_<?php echo $ifca+1; ?>" type="hidden" name="cognitive_ability_id[]" value="<?php if(isset($_GET['id'])){  echo $fca->id;  }else{ echo "";}?>">

														@if($ifca==0)
														<div class="row form-group removeclasscaf<?php echo $ifca+1; ?>">
															<div class="col-md-5">
																<label for="cognitive_ability_name_<?php echo $ifca+1; ?>" class="placeholder">Factor Name</label>
																<input id="cognitive_ability_name_<?php echo $ifca+1; ?>" type="text" class="form-control input-border-bottom" required="" name="cognitive_ability_name[]" value="{{$fca->cognitive_ability_name}}">
															</div>
															<div class="col-md-5">
																<label for="weightage_caf_<?php echo $ifca+1; ?>" class="placeholder">Weightage %</label>
																<input id="weightage_caf_<?php echo $ifca+1; ?>" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage_caf[]" value="{{$fca->weightage}}">
															</div>
															<div class="col-md-2" style="margin-top:28px;">
																<button class="btn btn-success" type="button"
																	onclick="addRowCaf();"><i class="fas fa-plus"></i>
																</button>
															</div>
														</div>
														@else
														<div class="row form-group removeclasscaf<?php echo $ifca+1; ?>">
															<div class="col-md-5">
																<label for="cognitive_ability_name_<?php echo $ifca+1; ?>" class="placeholder">Factor Name</label>
																<input id="cognitive_ability_name_<?php echo $ifca+1; ?>" type="text" class="form-control input-border-bottom" required="" name="cognitive_ability_name[]" value="{{$fca->cognitive_ability_name}}">
															</div>
															<div class="col-md-5">
																<label for="weightage_caf_<?php echo $ifca+1; ?>" class="placeholder">Weightage %</label>
																<input id="weightage_caf_<?php echo $ifca+1; ?>" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage_caf[]" value="{{$fca->weightage}}">
															</div>
															<div class="col-md-2" style="margin-top:28px;">
																<button class="btn btn-success" type="button"
																	onclick="addRowCaf();"><i class="fas fa-plus"></i>
																</button>
																
																@if($ifca+1==count($interview_form_ca))
																<button class="btn btn-danger btn-caf-remove" id="btn_caf_remove_<?php echo $ifca+1; ?>" type="button" onclick="remove_caf_set(<?php echo $ifca+1; ?>);"><i class="fas fa-minus"></i></button>
																@else
																<button class="btn btn-danger btn-caf-remove" style="display:none;" id="btn_caf_remove_<?php echo $ifca+1; ?>" type="button" onclick="remove_caf_set(<?php echo $ifca+1; ?>);"><i class="fas fa-minus"></i></button>
																@endif
															</div>
														</div>
														@endif
													@endforeach
												@else
												<div class="row form-group">
													<div class="col-md-5">
														<label for="cognitive_ability_name_1" class="placeholder">Factor Name</label>
														<input id="cognitive_ability_name_1" type="text" class="form-control input-border-bottom" required="" name="cognitive_ability_name[]" value="">
													</div>
													<div class="col-md-5">
														<label for="weightage_caf_1" class="placeholder">Weightage %</label>
														<input id="weightage_caf_1" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage_caf[]" value="">
													</div>
													<div class="col-md-2" style="margin-top:28px;">
														<button class="btn btn-success" type="button"
															onclick="addRowCaf();"><i class="fas fa-plus"></i>
														</button>
													</div>
												</div>
												@endif									
											</div>									
										</div>	
										
										<div class="row form-group">
											
											<div class="col-md-6">
												@if(isset($interview_form_inuse) && $interview_form_inuse>0)
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
	<script >
		$(document).ready(function() {
			
		});

		var room = document.getElementById('capstone_room').value;
		//alert(room);

		function addRowCapstone() {
			// alert(room);

			room++;
			var objTo = document.getElementById('capstone_set')
			var divtest = document.createElement("div");
			divtest.setAttribute("class", "form-group removeclass" + room);
			var rdiv = 'removeclass' + room;

			$('.btn-cap-remove').hide();

			divtest.innerHTML =
				'<div class="row form-group"><div class="col-md-5"><label for="capstone_name_' + room +'" class="placeholder">Capstone Title</label><input id="capstone_name_' + room +'" type="text" class="form-control input-border-bottom" required="" name="capstone_name[]" value=""></div><div class="col-md-5"><label for="weightage_' + room +'" class="placeholder">Weightage %</label><input id="weightage_' + room +'" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage[]" value=""></div><div class="col-md-2" style="margin-top:28px;"><button class="btn btn-success" type="button" onclick="addRowCapstone();"><i class="fas fa-plus"></i></button> <button class="btn btn-danger btn-cap-remove" id="btn_cap_remove_' + room +'" type="button" onclick="remove_capstone_set(' +
				room + ');"><i class="fas fa-minus"></i></button></div></div>';


			objTo.appendChild(divtest);
			$('#capstone_room').val(room);
		}

		function remove_capstone_set(rid) {
			var prevrid=rid-1;
			if(prevrid>1){
				$('#btn_cap_remove_'+prevrid).show();
			}
			//alert($('#capstone_id_' + rid).val());
			if($('#capstone_id_' + rid).val() !=undefined){
				//alert('hi');
				$('#exist_rem_cap').val($('#exist_rem_cap').val()+$('#capstone_id_' + rid).val()+",");
			}
			$('.removeclass' + rid).remove();
			room--;
			$('#capstone_room').val(room);
		}

		var room_caf = document.getElementById('caf_room').value;
		//alert(room_caf);

		function addRowCaf() {
			// alert(room);

			room_caf++;
			var objTo = document.getElementById('caf_set')
			var divtest = document.createElement("div");
			divtest.setAttribute("class", "form-group removeclasscaf" + room_caf);
			var rdiv = 'removeclasscaf' + room_caf;

			$('.btn-caf-remove').hide();

			divtest.innerHTML =
				'<div class="row form-group"><div class="col-md-5"><label for="cognitive_ability_name_' + room_caf +'" class="placeholder">Factor Name</label><input id="cognitive_ability_name_' + room_caf +'" type="text" class="form-control input-border-bottom" required="" name="cognitive_ability_name[]" value=""></div><div class="col-md-5"><label for="weightage_caf_' + room_caf +'" class="placeholder">Weightage %</label><input id="weightage_caf_' + room_caf +'" type="number" step=1 class="form-control input-border-bottom" required="" name="weightage_caf[]" value=""></div><div class="col-md-2" style="margin-top:28px;"><button class="btn btn-success" type="button" onclick="addRowCaf();"><i class="fas fa-plus"></i></button> <button class="btn btn-danger btn-caf-remove" id="btn_caf_remove_' + room_caf +'" type="button" onclick="remove_caf_set(' +
				room_caf + ');"><i class="fas fa-minus"></i></button></div></div>';


			objTo.appendChild(divtest);
			$('#caf_room').val(room_caf);
		}

		function remove_caf_set(rid) {
			var prevrid=rid-1;
			if(prevrid>1){
				$('#btn_caf_remove_'+prevrid).show();
			}
			if($('#capstone_id_' + rid).val() !=undefined){
				//alert('hi');
				$('#exist_rem_caf').val($('#exist_rem_caf').val()+$('#cognitive_ability_id_' + rid).val()+",");
			}

			$('.removeclasscaf' + rid).remove();
			room_caf--;
			$('#caf_room').val(room_caf);
		}
	
	</script>
	
</body>
</html>