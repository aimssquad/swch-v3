<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../../assets/css/fonts.min.css']},
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
	.btn-default, .btn-default:disabled, .btn-default:focus, .btn-default:hover{background:none !important;}
	.create-link-mob{
    border-radius: 5px;
}
.main-panel{margin-top:0;}
.create-link-mob ul{padding: 0 0 0 0px;}
.create-link-mob ul li {
    list-style: none;
    font-size: 15px;
    margin-bottom: 8px;
    border-bottom: 1px dotted #ddd;
    padding-bottom: 8px;
}
.create-link-mob ul li:last-child{border-bottom:none;}
.create-link-mob ul li span{color: #4c76d2;
    font-weight: 600;}
	</style>
</head>
<body style="    background: #eae8e8;">
	<div class="wrapper">
		
  
		<!-- End Sidebar -->
		<div class="main-panel" style="width:100%">
			<div class="content" style="margin-top:0;">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header" style="background:#4c76d2;border-top-left-radius: 5px;    border-top-right-radius: 5px;">
									<h4 class="card-title" style="color:#fff;">Employee Creation Link </h4>
									@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
				<!--					<div class="table-responsive">-->
				<!--						<table id="basic-datatables" class="display table table-striped table-hover" >-->
				<!--							<thead>-->
				<!--								<tr>-->
				<!--									<th>Sl.No.</th>-->
				<!--									<th>Organisation Name</th>-->
				<!--									<th>Organisation Address</th>-->
													
				<!--									<th>Website</th>-->
				<!--									<th>Email ID</th>-->
				<!--									<th>Phone No.</th>-->
				<!--									<th>Employee Creation Link.</th>-->
												
				<!--								</tr>-->
				<!--							</thead>-->
											
				<!--							<tbody>-->
												
				<!--		<tr>-->
				<!--			<td>1</td>-->
				<!--			<td>{{ $companies_rs->com_name }}</td>-->
                                                                           
				<!--			<td>{{ $companies_rs->address }}</td>-->
							
                           
    <!--                        <td>{{ $companies_rs->website }}</td>-->
    <!--                          <td>{{ $companies_rs->email }}</td>-->
                              
    <!--                        <td>{{ $companies_rs->p_no }}</td>-->
    <!--                          <td style="text-align:center" id="myInput">-->
    <!--                              @if($companies_rs->employee_link!='')-->
                                  
    <!--                              <a href="{{ $companies_rs->employee_link }}">{{ $companies_rs->employee_link }}</a><button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="{{ $companies_rs->employee_link }}" title="Copy Link">-->
      <!-- icon from google's material design library -->
    <!--  <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24"><path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" /></svg>-->
    <!--</button>-->
    <!--@endif</td>-->
                            
                           
				<!--		</tr>-->
				<!--							</tbody>-->
				<!--						</table>-->
				<!--					</div>-->
									
									
									<div class="create-link-mob">
									    <ul>
									        <?php  
											     $employee_or_rs = DB::table('company_employee')
                      ->where('emid','=',$companies_rs->reg)
                 ->get();
											    
											    $truplouii_id=1;
$countwmploor= count($employee_or_rs)			;?>
		@if ($countwmploor!=0)
		@foreach($employee_or_rs as $empuprotgans)
		 @if($companies_rs->licence=='yes')
					@if ($empuprotgans->name!='')		
									        <li><h3 style="color: #0844c8;font-size: 16px;font-weight: 600;">{{ $companies_rs->com_name }}</h3></li>
									        <li><span>Organization Address: </span> @if($companies_rs->address!=''){{ $companies_rs->address }} @if($companies_rs->address2!='null'),{{ $companies_rs->address2 }}@endif,{{  $companies_rs->road }},{{  $companies_rs->city }},{{  $companies_rs->zip }},{{  $companies_rs->country }}@endif</li>
									        <li><span>Employee Name: </span> {{ $empuprotgans->name }}</li>
									        <li><span>Department: </span> {{ $empuprotgans->department }}</li>
									        <li><span>Job Type: </span>{{ $empuprotgans->job_type }}</spna></li>
									         <li><span>Job Title: </span> {{ $empuprotgans->designation }}</spna></li>
									         <li><span>Employee Creation Link:  </span><br>   @if($companies_rs->employee_link!='')
                                  
                                  <a href="{{ $companies_rs->employee_link }}/{{ base64_encode($empuprotgans->id) }}" target="_blank">{{ $companies_rs->employee_link }}/{{ base64_encode($empuprotgans->id) }}</a><button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="{{ $companies_rs->employee_link }}/{{ base64_encode($empuprotgans->id) }}" title="Copy Link">
      <!-- icon from google's material design library -->
      <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24"><path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" /></svg>
    </button>
    @endif
									         </li>
									         <?php $truplouii_id++;?>
							@endif
								@endif
										@endforeach   
		
		@endif
									    </ul>
									</div>
								</div>
							</div>
						</div>

						

						
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
		
		
		function copyToClipboard(text, el) {
  var copyTest = document.queryCommandSupported('copy');
  var elOriginalText = el.attr('data-original-title');

  if (copyTest === true) {
    var copyTextArea = document.createElement("textarea");
    copyTextArea.value = text;
    document.body.appendChild(copyTextArea);
    copyTextArea.select();
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'Copied!' : 'Whoops, not copied!';
      el.attr('data-original-title', msg).tooltip('show');
    } catch (err) {
      console.log('Oops, unable to copy');
    }
    document.body.removeChild(copyTextArea);
    el.attr('data-original-title', elOriginalText);
  } else {
    // Fallback if browser doesn't support .execCommand('copy')
    window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
  }
}

$(document).ready(function() {
  // Initialize
  // ---------------------------------------------------------------------

  // Tooltips
  // Requires Bootstrap 3 for functionality
  $('.js-tooltip').tooltip();

  // Copy to clipboard
  // Grab any text in the attribute 'data-copy' and pass it to the 
  // copy function
  $('.js-copy').click(function() {
    var text = $(this).attr('data-copy');
    var el = $(this);
    copyToClipboard(text, el);
  });
});
	</script>
</body>
</html>