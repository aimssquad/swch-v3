<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
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
	<style>
	    p{margin-bottom:0;}
	   td,th{    padding: 10px;} 
	   img {
    -webkit-print-color-adjust: exact;
}
@media print {
  body { 
    -webkit-print-color-adjust: exact; 
  }
  .noprint {
    visibility: hidden;
  }
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
							<li class="nav-item active">
								<a href="{{url('recruitment/offer-letter')}}"> Generate Offer Letter</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-sticky-note"></i> Offer Letter<span><a data-toggle="tooltip" data-placement="bottom" title="Generate Offer Letter" href="{{ url('recruitment/generate-letter') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span>
							</h4>
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
									
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Job Code</th>
													<th>Job Title</th>
													<th>Candidate</th>
													<th>Email</th>
													<th>Contact Number</th>
													<th>Status</th>
													<th>Date</th>
													<th>Offered Salary</th>
													<th>Date Of Joining </th>
													<th>Action</th>
														</tr>
											</thead>
											
											<tbody>
												   <?php $ij = 1; ?>
									@foreach($candidate_rs as $candidate)
                                        <tr>
                                            
											<td>{{ $candidate->soc }}</td>
                                            <td>{{ $candidate->job_title }}</td>
											 <td>{{ $candidate->name }}</td>
											  <td>{{ $candidate->email }}</td>
											   <td>{{ $candidate->phone }}</td>
											    <td>Offer Letter Generated</td>
												<td>
												<?php
												

	echo date('d/m/Y',strtotime($candidate->cr_date));
?></td><td>{{ $candidate->offered_sal }}</td>
	<td>
												<?php
												

	echo date('d/m/Y',strtotime($candidate->date_jo));
?></td>
                                            
<td class="drp">
<div class="dropdown">
  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a download class="dropdown-item" href="{{asset('public/pdf/'.$candidate->dom_pdf)}}"><i class="fas fa-download"></i>&nbsp; Download</a> 
    <!--<a class="dropdown-item" href="{{url('recruitment/send-letter/'.base64_encode($candidate->id))}}"><i class="fas fa-paper-plane"></i>&nbsp; Send</a> -->
   <!--<a class="dropdown-item" href="{{url('recruitment/offer-down-letter/'.base64_encode($candidate->id))}}"><i class="fas fa-eye"></i>&nbsp; View</a>-->
   
   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal<?=$ij;?>"><i class="fas fa-eye"></i>&nbsp; View</a>
  </div>
</div>




                
                  </td>                              
                                            
                                            
<!--            <td><a href="{{asset('public/pdf/'.$candidate->dom_pdf)}}" download title="Download"><img  style="width: 23px;" src="{{ asset('assets/img/download.png')}}"></a>-->
											
<!--<a href="{{url('recruitment/send-letter/'.base64_encode($candidate->id))}}" title="Send"><img  style="width: 23px;" src="{{ asset('assets/img/send.png')}}"></a>-->
<!--	&nbsp &nbsp	<a href="{{url('recruitment/offer-down-letter/'.base64_encode($candidate->id))}}" target="_blank" title="View"><img  style="width: 23px;" src="{{ asset('assets/img/view.png')}}"></a>-->
						
<!--											</td>-->
                                        </tr>
                                        <?php
                                        $ij ++;
                                        ?>
                                    @endforeach  
            
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
				 @include('recruitment.include.footer')
		</div>
		
	</div>
	
	   <?php $ij = 1; ?>
									@foreach($candidate_rs as $candidate)
									<?php
									
									 $email = Session::get('emp_email');
		$Roledata = DB::table('registration')      
                 
                  ->where('email','=',$email) 
                  ->first();
									 $job_d=DB::table('company_job')->where('id', '=',$candidate->job_id )->first();
									 
									 $employee='';
$name='';
$num='';
$email='';
$desig='';

// if(!empty($candidate->reportauthor)){
// //    dd($candidate);
//     $employee=DB::table('employee')->where('emid', '=',$Roledata->reg )->where('emp_code', '=',$candidate->reportauthor)->first();
// //    dd($employee);
//     $name=$employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname;

//     $num=$employee->em_phone;
//     $email=$employee->em_email;
//     $desig=$employee->emp_designation;
// }else{
//    $name=$job_d->author;
//     $num=$job_d->con_num;
//     $email=$job_d->email;
//     $desig=$job_d->desig; 
// }
 
 ?>
	
<!-----offer-letter-modal----------------->

<div class="modal fade" id="exampleModal<?=$ij;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:1000px;">
    <div class="modal-content">
      <div class="modal-header" style="background:#17276d;">
        <h2 class="modal-title text-white" id="exampleModalLabel">Offer Letter</h2>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table style="width:100%;">
  <thead>
    <tr>
         <td>Date :{{date('d/m/Y', strtotime($candidate->cr_date))}}
       </td>
	  <td style="color: #17276d;font-size: 20px;">{{ $Roledata->com_name }}</td>
	  <td style="    text-align: right;"><img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /></td>
	</tr>
  </thead>
</table>
<table style="width:100%;border: 3px solid #17276d;padding: 0 20px;">
  <tr>
     
    <td>
	  <p style="text-align: right;"> {{ $candidate->name }}</p>
	   <p style="text-align: right;"> {{ $candidate->location }} @if(!empty($candidate->zip)),{{ $candidate->zip }} @endif </p>
	  <p>{{date('d/m/Y', strtotime($candidate->cr_date))}}</p>
	   <p>{{ $Roledata->com_name }} </p>
	   <p>{{ $Roledata->address.','.$Roledata->address2.','.$Roledata->road.','.$Roledata->city.','.$Roledata->zip.','.$Roledata->country}} </p>
	  <p>Dear  {{ $candidate->name }},</p>
	  
	<p>  Following your recent interview, I am writing to offer you the post of {{ $candidate->job_title }}  at the salary of {{ $candidate->offered_sal }} per {{ $candidate->payment_type}}, starting on {{ date('d/m/Y',strtotime($candidate->date_jo))}}.
	
 </p>
 <p>Full details of the post’s terms and conditions of employment are in your attached Employment Contract.</p>
	  <p>As explained during the interview, this job offer is made subject to satisfactory results from necessary pre-employment checks.  There will also be a probationary period of three months which will have to be completed satisfactorily.<p>
	  
	 
	  <p> This is a {{ $job_d->job_type }} .On starting, you will report to {{ $name }}.</p>
	  
<p>If you have any queries on the contents of this letter, the attached Employment Contractor the pre-employment checks, please do not hesitate to contact me on 0{{$num}}.</p>

<p>To accept this offer, please sign and date the attached copy of this letter in the spaces indicated, scan it in legible format and send it back to us by replying to   {{$email}}.</p>
<p>We are delighted to offer you this opportunity and look forward to you joining the organisation and working with you.</p>
<p>This letter is part of your contract of employment.</p>

<p>Yours sincerely,</p>

<h5 style="margin-bottom:0;color: #17276d;font-size: 16px;">{{$name}}</h5>
<p style="margin-top:0;margin-bottom:0;">{{$desig}}</p>
<p><b>I am very pleased to accept the job offer on the terms and conditions detailed in this letter and the Written Statement of Terms and Conditions of Employment</b></p>
<p><b>Signed and date ………………………………………………………………………………………………</b><p>
   <p><b> [Successful candidate to write their signature with date]</b><p>



 <p><b>Name ……………………………………………………………………………………………………………….</b> </p>

 <p><b>[Successful candidate to print their full name in capital letters]</b><p>


	</td>
  </tr>
</table>
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-primary" onclick="$('#div1<?=$ij;?>').print();"><i class="fa fa-print" aria-hidden="true"></i> Print Offer Letter</button>
         <button type="button" class="btn bg-danger text-white" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------->


<!----------------print-preview------------->
<div id="div1<?=$ij;?>" style="display:none;">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="icon" href="https://workpermitcloud.co.uk/hrms/img/favicon.png" type="image/x-icon"/>

<title>HRMS</title>
</head>

<body>
<table style="width:100%;">
  <thead>
  <tr>
         <td>Date :{{date('d/m/Y', strtotime($candidate->cr_date))}}
       </td>
	  <td style="color: #17276d;font-size: 20px;">{{ $Roledata->com_name }}</td>
	  <td style="    text-align: right;"><img width="100" src="http://workpermitcloud.co.uk/hrms/public/{{ $Roledata->logo }}" alt="" /></td>
	</tr>
  </thead>
</table>
<table style="width:100%;border: 3px solid #17276d;padding: 0 20px;">
  <tr>
     
    <td>
	  <p style="text-align: right;"> {{ $candidate->name }}</p>
	   <p style="text-align: right;"> {{ $candidate->location }} @if(!empty($candidate->zip)),{{ $candidate->zip }} @endif </p>
	  <p>{{date('d/m/Y', strtotime($candidate->cr_date))}}</p>
	   <p>{{ $Roledata->com_name }} </p>
	   <p>{{ $Roledata->address.','.$Roledata->address2.','.$Roledata->road.','.$Roledata->city.','.$Roledata->zip.','.$Roledata->country}} </p>
	  <p>Dear  {{ $candidate->name }},</p>
	  
	<p>  Following your recent interview, I am writing to offer you the post of {{ $candidate->job_title }}  at the salary of {{ $candidate->offered_sal }} per {{ $candidate->payment_type}}, starting on {{ date('d/m/Y',strtotime($candidate->date_jo))}}.
	
 </p>
 <p>Full details of the post’s terms and conditions of employment are in your attached Employment Contract.</p>
	  <p>As explained during the interview, this job offer is made subject to satisfactory results from necessary pre-employment checks.  There will also be a probationary period of three months which will have to be completed satisfactorily.<p>
	  
	 
	  <p> This is a {{ $job_d->job_type }} .On starting, you will report to {{ $name }}.</p>
	  
<p>If you have any queries on the contents of this letter, the attached Employment Contractor the pre-employment checks, please do not hesitate to contact me on 0{{$num}}.</p>

<p>To accept this offer, please sign and date the attached copy of this letter in the spaces indicated, scan it in legible format and send it back to us by replying to   {{$email}}.</p>
<p>We are delighted to offer you this opportunity and look forward to you joining the organisation and working with you.</p>
<p>This letter is part of your contract of employment.</p>

<p>Yours sincerely,</p>

<h5 style="margin-bottom:0;color: #17276d;font-size: 16px;">{{$name}}</h5>
<p style="margin-top:0;margin-bottom:0;">{{$desig}}</p>
<p><b>I am very pleased to accept the job offer on the terms and conditions detailed in this letter and the Written Statement of Terms and Conditions of Employment</b></p>
<p><b>Signed and date ………………………………………………………………………………………………</b><p>
   <p><b> [Successful candidate to write their signature with date]</b><p>



 <p><b>Name ……………………………………………………………………………………………………………….</b> </p>

 <p><b>[Successful candidate to print their full name in capital letters]</b><p>


	</td>
  </tr>
</table>
</body>
</html>
</div>
  <?php
                                        $ij ++;
                                        ?>
                                    @endforeach  
<!------------------------------------------>
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
	
	
	<script type="text/javascript">
		$.fn.extend({
			print: function() {
				var frameName = 'printIframe';
				var doc = window.frames[frameName];
				if (!doc) {
					$('<iframe>').hide().attr('name', frameName).appendTo(document.body);
					doc = window.frames[frameName];
				}
				doc.document.body.innerHTML = this.html();
				doc.window.print();
				return this;
			}
		});
	</script>
</body>
</html>