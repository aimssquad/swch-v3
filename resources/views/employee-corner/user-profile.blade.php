<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assetsemcor/img/icon.ico" type="image/x-icon"/>
	<style>
	    
	    .personal-details{display:block;overflow:hidden;}
	    .personal-details:last-child{border-bottom:none;}
	</style>
	<!-- Fonts and icons -->
<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assetsemcor/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>


	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/demo.css')}}">
</head>
<body>
	<div class="wrapper">
	 @include('employee-corner.include.header')
		<!-- Sidebar -->
		
		  @include('employee-corner.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Employee Access Value</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('employee-corner/user-profile')}}">User Profile</a>
							</li>
							
						</ul>
					</div>
					
       <div class="row">
        <div class="col-md-12">
          <div class="user-profile">
           <div class="col-md-8 ">
            <div class="profile">
               <h1><?php echo $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname;  ?></h1>

                 <div class="user-list">
                  <ul>
                    <li><i class="fa fa-user  user-icon" aria-hidden="true"></i><?php echo $employee->emp_department;  ?></li>
                    <li><i class="fa fa-eye user-icon" aria-hidden="true"></i><?php echo $employee->emp_designation;  ?></li>
                    <li><i class="fa fa-phone-square user-icon" aria-hidden="true"></i> <?php echo $employee->emp_ps_phone;  ?></li>
                  </ul> 
                </div>  
            </div>
            
             
           </div>

          </div>
 <div class="row">
        <div class="col-md-8">

           <div class="personal-details-field">
               <div class="personal-details">
                  <h2><i class="fas fa-male personal-icon"></i>Profile Details</h2>
                  <div class="row">
                  <div class="col-6 col-md-3">
                   <div class="profile-list-1">
                      <p>Employee Code : </p>
                    <!--  <p>Fathers Name : </p>-->
                      <p>Date Of Birth : </p>
                   </div>

                  </div>

                  <div class="col-6 col-md-9">
                    <div class="profile-list-2">
                    <p><?php echo $employee->emp_code; ?></p>
                  <!--  <p><?php echo $employee->emp_father_name; ?></p>-->
                    <p><?php echo date("d/m/Y",strtotime($employee->emp_dob)); ?></p>
                    </div>
                   
                </div>
                </div>
               </div>

               <!-- ------2nd-------------- -->

                <div class="personal-details">
                  <h2><i class="fas fa-server server-icon"></i>Service Details</h2>
                  <div class="row">
                  <div class="col-6 col-md-3">
                   <div class="profile-list-1">
                        <?php  if($employee->emp_doj!='' && $employee->emp_doj!='1970-01-01'){ 
                            ?>
                      <p>Date Of Joining : </p>
                    <?php  }?>
                      <?php  if($employee->emp_status!='' ){ 
                            ?>
                       <p>Employment Type : </p>
                         <?php  }?>
                   </div>

                  </div>

                  <div class="col-6 col-md-9">
                    <div class="profile-list-2">
                    <p>
                        
                        <?php  if($employee->emp_doj!='' && $employee->emp_doj!='1970-01-01'){ 
                      
                      echo date('d/m/Y',strtotime($employee->emp_doj)); }?>
                      </p>
                   
                    <p><?php echo $employee->emp_status; ?></p>
                    </div>
                   
                  </div>
                  </div>

                </div>

                <!-- -----3rd---------- -->

              

                <!-- ---4th---- -->
<div class="clearfix"></div>
                <div class="personal-details">
                  <h2><i class="fas fa-map-marker-alt add-icon"></i>Present Address</h2>
                  <div class="row">
                  <div class="col-6 col-md-3">
                   <div class="profile-list-1">
                       <?php  if($employee->emp_pr_street_no!='' ){ 
                            ?>
                      <p>Address Line 1 : </p>
                        <?php  }?>
                        <?php  if($employee->emp_per_village!='' ){ 
                            ?>
                      <p>Address Line 2 : </p>
                        <?php  }?>
                        <?php  if($employee->emp_pr_state!='' ){ 
                            ?>
                      <p>Address Line 3 : </p>
                        <?php  }?>
                        <?php  if($employee->emp_pr_city!='' ){ 
                            ?>
                      <p>City / County : </p>
                        <?php  }?>
                        <?php  if($employee->emp_pr_pincode!='' ){ 
                            ?>
                      <p>Post Code : </p>
                        <?php  }?>
                        <?php  if($employee->emp_pr_country!='' ){ 
                            ?>
                      <p>Country : </p>
                        <?php  }?>
                   </div>

                  </div>

                  <div class="col-6 col-md-9">
                    <div class="profile-list-2">
                     <p><?php echo $employee->emp_pr_street_no; ?></p>
                      <p><?php echo $employee->emp_per_village; ?></p>
                      <p><?php echo $employee->emp_pr_state; ?></p>
                      <p><?php echo $employee->emp_pr_city; ?></p>
                      <p><?php echo $employee->emp_pr_pincode; ?></p>
                      <p><?php echo $employee->emp_pr_country; ?></p>
                    </div>
                   
                  </div>
                  </div>

                </div>
  <div class="personal-details">
                  <h2><i class="fas fa-map-marker-alt add-icon"></i>Immigration Details</h2>
                  <div class="row">
                  <div class="col-md-3">
                   <div class="profile-list-1">
                       <?php  if($employee->ni_no!='' ){ 
                            ?>
                      <p>National ID No : </p>
                       <?php  }?>
                        <?php  if($employee->pass_nat!='' ){ 
                            ?>
                      <p>Nationality : </p>
                     <?php  }?>
                     <?php  if($employee->pass_doc_no!='' ){ 
                            ?>
                      <p>Passport No : </p>
                       <?php  }?>
                       <?php  if($employee->pas_iss_date!='' && $employee->pas_iss_date!='1970-01-01'){ 
                            ?>
                      <p> Passport Issued Date : </p>
                       <?php  }?>
                        <?php if($employee->pass_exp_date!='' && $employee->pass_exp_date!='1970-01-01'){ 
                            ?>
                      <p>Passport Expiry Date : </p>
                       <?php  }?>
                       <?php  if($employee->issue_by!='' ){ 
                            ?>
                      <p>Passport  Issued By : </p>
                       <?php  }?>
                        <?php if($employee->pass_review_date!='' && $employee->pass_review_date!='1970-01-01'){ 
                            ?>
                       <p> Passport Eligible Review Date : </p>
                     <?php  }?>
                      <?php  if($employee->visa_doc_no!='' ){ 
                            ?>
                       <p>BRP No : </p>
                        <?php  }?>
                          <?php if($employee->visa_issue_date!='' && $employee->visa_issue_date!='1970-01-01'){ 
                            ?>
                      <p> Visa  Issued Date : </p>
                       <?php  }?>
                         <?php  if($employee->visa_exp_date!='' && $employee->visa_exp_date!='1970-01-01'){ 
                            ?>
                      <p>Visa  Expiry Date : </p>
                       <?php  }?>
                       <?php  if($employee->visa_issue!='' ){ 
                            ?>
                      <p>Visa   Issued By : </p>
                       <?php  }?>
                         <?php if($employee->visa_review_date!='' && $employee->visa_review_date!='1970-01-01'){
                            ?>
                       <p> Visa  Eligible Review Date : </p>
                     <?php  }?>
                    
                   </div>

                  </div>

                  <div class="col-md-9">
                    <div class="profile-list-2">
                     <p><?php echo $employee->ni_no; ?></p>
                      <p><?php echo $employee->pass_nat; ?></p>
                     
                      <p><?php echo $employee->pass_doc_no; ?></p>
                      <p><?php  if($employee->pas_iss_date!='' && $employee->pas_iss_date!='1970-01-01'){ 
                     
                      echo date('d/m/Y',strtotime($employee->pas_iss_date)); }?></p>
                       <p><?php  if($employee->pass_exp_date!='' && $employee->pass_exp_date!='1970-01-01'){ 
                      
                      echo date('d/m/Y',strtotime($employee->pass_exp_date)); }?></p>
                      <p><?php echo $employee->issue_by; ?></p>
                        <p><?php  if($employee->pass_review_date!='' && $employee->pass_review_date!='1970-01-01'){ 
                      
                      echo date('d/m/Y',strtotime($employee->pass_review_date)); }?></p>
                    
                       <p><?php echo $employee->visa_doc_no; ?></p>
                      <p><?php  if($employee->visa_issue_date!='' && $employee->visa_issue_date!='1970-01-01'){ 
                      
                      echo date('d/m/Y',strtotime($employee->visa_issue_date)); }?></p>
                       <p><?php  if($employee->visa_exp_date!='' && $employee->visa_exp_date!='1970-01-01'){ 
                      
                      echo date('d/m/Y',strtotime($employee->visa_exp_date)); }?></p>
                      <p><?php echo $employee->visa_issue; ?></p>
                        <p><?php  if($employee->visa_review_date!='' && $employee->visa_review_date!='1970-01-01'){ 
                      
                      echo date('d/m/Y',strtotime($employee->visa_review_date)); }?></p>
                     
                    </div>
                   
                  </div>
                  </div>

                </div>

        </div>

     </div>


           <div class="col-md-4">
            <div class="user-img">
              <figure>
               <?php if(!empty($employee->emp_image)){ ?>
					<img src="{{ asset($employee->emp_image) }}" alt="" width="248">
				     <?php }else{ ?>
				  
				    <?php } ?>	
              </figure>
            </div>
             <form action="{{ url('employee-corner/user-image') }}" method="post" enctype="multipart/form-data">
							<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
							<div class="row form-group">
								<div class="col-8 col-md-8 pr0">
							  <input  type="file"  name="emp_image" class="form-control"  id="emp_image" required=""   placeholder="" style="margin-top: 22px;">
							  	</div>
							  	<div class="col-4 col-md-4 pl0" style="margin-top:24px;">
							  	    
										    	<a class="apply" href="#">	
										        <button class="btn btn-default apply" type="submit">Upload</button>
										       </a>
										      
										</div>
										</div>
							
</form>
          <div class="pay-details-field">
               <div class="pay-details">
                    <h2><i class="far fa-thumbs-up pay-icon"></i>Pay Details</h2>
                <div class="profile-list-1-pay">
                    <?php  if($employee->emp_group_name!='' ){ 
                            ?>
                  <p>Pay Level : </p>
                  <?php } ?>
                    <?php  if($employee->emp_pay_scale!='' ){ 
                            ?>
                  <p>Basic Pay : </p>
                  <?php } ?>
                 
                </div>
                  <div class="profile-list-2-pay">
                    <p><?php 
					
					$job_details=DB::table('grade')->where('id', '=', $employee->emp_group_name )->orderBy('id', 'DESC')->first();
  			if(!empty($job_details)){
  			    echo $job_details->grade_name;
  			}
					 ?></p>
                    <p><?php echo $employee->emp_pay_scale; ?></p>
                  
                   </div> 

               </div>  
                 
        </div>


        <!-- ----------------------------------------------------- -->

           <div class="bank-details-field">

                <div class="pay-details">
                   <h2><i class="fas fa-university bank-icon"></i>Bank Details</h2>
                  <div class="profile-list-1-pay">
                         <?php   if(!empty($bank_name)){
                            ?>
                     <p>Bank Name : </p>
                      <?php } ?>
                      <?php  if($employee->emp_sort_code!='' ){ 
                            ?>
					  <p>Sort Code :</p>
					  
					   <?php } ?>
					   <?php  if($employee->bank_branch_id!='' ){ 
                            ?>
					  <p>Branch Name. :</p>
					   <?php } ?>
					   <?php  if($employee->emp_account_no!='' ){ 
                            ?>
                     <p>A/C No : </p>
                      <?php } ?>
                    
                    
                </div>
                 <div class="profile-list-2-pay">
                    <p><?php 
                    if(!empty($bank_name)){
                         echo $bank_name->master_bank_name;
                    }
                    ?></p>
                    <p><?php echo $employee->emp_sort_code; ?></p>
                    <p><?php echo $employee->bank_branch_id; ?></p>
                    <p><?php echo $employee->emp_account_no; ?></p>
                </div> 

             </div> 
           </div> 
      
<!-- ------------------------------------------------------------------------------ -->

           <div class="bank-details-field">
            
               <div class="pay-details">
                  <h2><i class="fas fa-user-tie pay-icon" style="color:#33BF08"></i> Authority</h2>
                <div class="profile-list-1-role">
                    
                    <?php
                    	$user_id = Session::get('users_id');
		 $usersf=DB::table('users')->where('id','=',$user_id)->first();
					 $employee_re=DB::table('employee')->where('emp_code','=',$employee->emp_reporting_auth)->where('emid','=',$usersf->emid)->first();
                    	if(!empty($employee_re)){
                    	    ?>
				<p style="margin:0"><b>Reporting Authority:</b> </p>
				<?php }
				?>
				 <span style="margin-bottom:15px">
				 <?php 
				
					if(!empty($employee_re)){
					echo $employee_re->emp_fname.' '.$employee_re->emp_mname.' '.$employee_re->emp_lname;} ?></span>
				 <br><br>
				  
                    <?php
                    $employee_sa=DB::table('employee')->where('emp_code','=',$employee->emp_lv_sanc_auth)->where('emid','=',$usersf->emid)->first();
                    	if(!empty($employee_sa)){
                    	    ?>
				<p style="margin:0"><b>Leave Sanction: Authority: </b></p>
					<?php }
				?>
				<span><?php $employee_sa=DB::table('employee')->where('emp_code','=',$employee->emp_lv_sanc_auth)->where('emid','=',$usersf->emid)->first();
					if(!empty($employee_sa)){
					echo $employee_sa->emp_fname.' '.$employee_sa->emp_mname.' '.$employee_sa->emp_lname;}  ?></span>
                
                </div>
  
              </div>  
           </div> 
      
	<?php if(!empty($module_name)){ ?>
           <div class="bank-details-field">
            
               <div class="pay-details">
                  <h2><i class="fas fa-user-alt role-icon"></i> Role</h2>
                <div class="profile-list-1-role">
				<?php if(!empty($module_name)){ ?>
				<p ><?php echo $module_name; ?></p>
			    <?php } ?>
                
                </div>
  
              </div>  
           </div> 
        <?php } ?>
<!-- --------------------------------------------------------------------------- -->

           </div>
              
       </div>


            
          </div>
          
        </div>
         
				</div>
			</div>
		
	<!--   Core JS Files   -->
 @include('employee-corner.include.footer')
		</div>
		
	</div>
	<!--   Core JS Files   -->
<script src="{{ asset('assetsemcor/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assetsemcor/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assetsemcor/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assetsemcor/js/setting-demo2.js')}}"></script>
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>
</body>
</html>