<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
      <style>
         @media (max-width: 575.98px)
         .footer {
         position: relative; 
         }
      </style>
      <link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
      <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
      <script>
         WebFont.load({
         	google: {"families":["Lato:300,400,700,900"]},
         	custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}'] },
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
         .app-form-text h5 {    
         margin: 0;
         color: #1572e8;
         padding: 15px 7px;
         }.app-form-text h5 span {
         color: #000;
         padding-left: 10px;
         }.download a {
         color: #fff;
         text-decoration: none;
         }
         .form-group{
         padding:0;
         }
         .row:nth-child(even) {
         background-color: #e9e9e9;
         }
         .row:nth-child(odd) {
         background-color: #f7f7f7;
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
                     <a href="{{url('recruitment/candidate')}}">Job Applied</a>
                  </li>
                  <li class="separator">
                     /
                  </li>
                  <li class="nav-item active">
                     <a href="#">Job Applied Details</a>
                  </li>
               </ul>
            </div>
            <div class="content">
               <div class="page-inner">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card custom-card">
                           <div class="card-header">
                              <h4 class="card-title"><i class="fas fa-briefcase"></i> Job Applied Details</h4>
                           </div>
                           <div class="card-body">
                              <form action="{{url('recruitment/edit-candidate')}}" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
                                 <input id="id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php   echo $job->job_id;  ?>" >
                                 <div class="row form-group">
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Job Title:<span>{{$job->job_title}}</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Candidate Name:<span>{{$job->name}}</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Candidate Address:<span>{{$job->location}} @if(!empty($job->zip)) , {{$job->zip}} @endif</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Email:<span>{{$job->email}}</span></h5>
                                       </div>
                                    </div>
                                    @if($job->dob!='')
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Date Of Birth:<span>{{ date('d/m/Y',strtotime($job->dob))}}</span></h5>
                                       </div>
                                    </div>
                                    @endif
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Contact Number:<span>+{{$job->phone}}</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Gender:<span>{{$job->gender}}</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Total Year of Experience:<span>{{$job->exp}} Years {{$job->exp_month}} Months</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Education Qualification:<span>{{$job->edu}}</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Skill Set:<span>{{$job->skill}}</span></h5>
                                       </div>
                                    </div>
                                    <!--<div class="col-md-4">-->
                                    <!--	<div class="app-form-text">-->
                                    <!--		<h5>Skill level:<span>{{$job->skill_level}}</span></h5>-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Most Recent Employer:<span>{{$job->cur_or}}</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Most Recent Job Title:<span>{{$job->cur_deg}}</span></h5>
                                       </div>
                                    </div>
                                    <!--<div class="col-md-4">-->
                                    <!--		<div class="app-form-text">-->
                                    <!--			<h5>Current Salary:<span> @if($job->sal!='') {{ number_format($job->sal,2)}} @endif</span></h5>-->
                                    <!--		</div>-->
                                    <!--</div>-->
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Expected Salary (GBP):<span> @if($job->exp_sal!='') {{ number_format($job->exp_sal,2)}}  @endif</span></h5>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="app-form-text">
                                          <h5>Application Date:<span> <?php
                                             // 											echo date('d/m/Y',strtotime($job->date));
                                                // if($job->date>='2021-02-22'){
                                                   //  echo ' '.date('h:i A ',strtotime($job->date));
                                                // }
                                                    ?>
                                             <input type="date" name="application_date" id="application_date" value="{{date('Y-m-d',strtotime($job->date))}}" class="form-control">	
                                             </span>
                                          </h5>
                                       </div>
                                    </div>
                                 </div>
                                 <!--------------------  -->
                                 <div class="row form-group" style="padding: 3px 0 15px;">
                                    <div class="col-md-4">
                                       <div class=" form-group current-stage">
                                          <label  >Current Stage of Recruitment</label>
                                          <select class="form-control" required="" name="status"  style="margin-top: 10px;" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                             }
                                             
                                             ?>
                                             >
                                             <option value=""><?php  if($job->status!=''){ echo $job->status;  } ?></option>
                                             <option value="Short listed"  <?php  if($job->status!=''){  if($job->status=='Short listed'){ echo 'selected';} } ?> >Short listed</option>
                                             <option value="Rejected" <?php  if($job->status!=''){  if($job->status=='Rejected'){ echo 'selected';} } ?>>Rejected</option>
                                          </select>
                                       </div>
                                    </div>
                                    @if($job->recruited!='')
                                    <div class="col-md-6">
                                       <div class="app-form-text">
                                          <h5>Are  there suitable settled workers available to be recruited for this role ?:<span>{{ $job->recruited }} @if($job->recruited=='Yes')( {{ $job->other }} ) @endif</span></h5>
                                       </div>
                                    </div>
                                    @endif
                                    <div class="col-md-4">
                                       <div class="form-group current-stage">
                                          <label  >How the candidate applied ? </label>
                                          <select class="form-control" required="" name="apply"  style="margin-top: 10px;" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                             }
                                             
                                             ?>
                                             >
                                             <?php  if($job->apply==''){?>	   
                                             <option value="">Online</option>
                                             <?php } ?>
                                             <option value="Internal Job"  <?php  if($job->apply!=''){  if($job->apply=='Internal Job '){ echo 'selected';} } ?> >Internal Job</option>
                                             <option value="External Job" <?php  if($job->apply!=''){  if($job->apply=='External Job'){ echo 'selected';} } ?>>External Job</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4" style="margin-top:35px;">
                                       <button class="btn btn-default download" type="button" style=""><a href="{{asset($job->resume)}}" download>Download Resume</a></button>
                                    </div>
                                    <div class="col-md-4">
                                       <?php  if($job->cover_letter!=''){   ?>
                                       <button class="btn btn-default download" type="button" style="    margin: 11px 0 0;"><a href="{{asset('public/'.$job->cover_letter)}}" download>Download Cover Letter</a></button>
                                       <?php
                                          }
                                          
                                          ?>
                                    </div>
                                 </div>
                                 <div class="row form-group" style="    padding: 9px 0 15px;">
                                    <div class="col-md-6">
                                       <div class=" form-group">
                                          <label>Remarks</label>	
                                          <input type="text" class="form-control" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                             }
                                             
                                             ?> value="<?php  if($job->remarks!=''){  echo $job->remarks; } ?>"  name="remarks">
                                          <!--<label for="inputFloatingLabel-remarks" class="placeholder remarks"></label>-->
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class=" form-group">
                                          <label>Date</label>	
                                          <input type="date" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                             }
                                             
                                             ?> class="form-control" required=""  value="<?php  if( isset($job_details ) && !empty($job_details) ){  echo date('Y-m-d', strtotime($job_details->date)); }?>"  name="date"  >
                                          <!--<label for="inputFloatingLabel-date" class="placeholder remarks">Date</label>-->
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-group" style="margin-top: 25px;background:none">
                                    <?php  if($job->status!=''){  
                                       if($job->status=='Application Received'){ ?>
                                    <div class="col-md-12">
                                       <button class="btn btn-default sub" type="submit">Submit</button>
                                    </div>
                                    <?php }
                                       else{
                                       ?>
                                    <!-- <div class="col-md-12">
                                       <button class="btn btn-default sub" type="button" onclick="goBack()">Back</button>
                                       </div> -->
                                    <div class="col-md-12">
                                       <button class="btn btn-default sub" type="submit">Submit</button>
                                    </div>
                                    <?php
                                       }
                                       }
                                       ?>
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
      <script>
         function goBack() {
           window.history.back();
         }
      </script>
   </body>
</html>