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
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{ asset('assets/css/fonts.min.css')}}"]},
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
.vt td, .vt th{border-right:1px solid #ccc;border-left:none}
.vt td, .vt th {
    border-right: 1px solid #000 !important;
    border-left: none;
}</style>
</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">


					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-newspaper"></i> Billing <span><a href="{{ url('superadmin/add-billing') }}" data-toggle="tooltip" data-placement="bottom" title="Generate Bill" style="padding: 8px 0;"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
									@if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl.No.</th>
														<th>Invoice Number</th>
													<th>Bill To</th>
													<th>Bill For</th>
													<th>Description</th>

													<th>Amount</th>
													<th>Date</th>
													<th>Status</th>
													<th>Payment Mode</th>
													<th>Invoice Cancel</th>

													<!-- <th>View Invoice</th>
												        <th>Email	Send</th> -->
														<th>Email Send Date</th>
														<th>Action</th>
												</tr>
											</thead>

											<tbody>
											   
											 <?php $t = 1;?>
											  <?php $i = 1;?>
							@foreach($bill_rs as $company)
								<?php
if ($company->billing_type == 'Organisation') {
    $pass = DB::Table('registration')

        ->where('reg', '=', $company->emid)

        ->first();}

$bil_name = DB::Table('billing')

    ->where('in_id', '=', $company->in_id)

    ->get();
$nameb = array();
if (count($bil_name) != 0) {
    foreach ($bil_name as $biname) {
        $nameb[] = $biname->des;

    }
}
$strbil = implode(',', $nameb);
?>
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $company->in_id }}</td>
							<td>
								@if($company->billing_type=='Organisation')
									@if($company->bill_for=='first invoice recruitment service')
										{{ $company->canidate_name }}
										<p><small>({{ $pass->com_name }})</small></p>
									@elseif($company->bill_for=='second invoice visa service')
										{{ $company->canidate_name }}
										<p><small>({{ $pass->com_name }})</small></p>
									@else
										{{ $pass->com_name }}
									@endif
								@else
									{{ $company->canidate_name }}
								@endif
							</td>

							<td>{{ ucwords($company->bill_for)}}</td>
							<td>{{ $strbil}}</td>



                              <td>{{ $company->amount }}</td>
                              <td>{{ date('d/m/Y',strtotime($company->date)) }}</td>



							<td>{{ strtoupper($company->status) }}</td>
								<td>{{ ($company->pay_mode=='Ofline')? 'Offline': $company->pay_mode }}</td>
							       <td>
							 <script language="JavaScript" type="text/javascript">
                                function checkDelete(){
                                return confirm('Are you sure you want to cancel this invoice?');
                                }
                                </script>
<a href="{{url('superadmin/invoice-bill/'.base64_encode($company->in_id))}}" onClick="return checkDelete()">Yes</a>
						</td>
						 <td> @if($company->bill_send!='')
							     {{ date('d/m/Y',strtotime($company->bill_send)) }}
							     @endif</td>
							    <td class="drp">


<div class="dropdown">
  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="{{url('superadmin/edit-billing/'.base64_encode($company->in_id))}}"><i class="far fa-edit"></i>&nbsp; Edit</a>
     <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal<?php echo $t; ?>"><i class="fas fa-eye"></i>&nbsp; View Invoice</a> 
	<a class="dropdown-item" target="_blank" href="{{asset('public/billpdf/'.$company->dom_pdf)}}" ><i class="fas fa-eye"></i>&nbsp; Download Invoice</a>
   <a class="dropdown-item" href="{{url('superadmin/send-bill/'.base64_encode($company->in_id))}}"><i class="fas fa-paper-plane"></i>&nbsp; Send Email</a>
   <a class="dropdown-item" href="{{url('superadmin/remarks-billing/'.base64_encode($company->id))}}"><i class="fa fa-comments"></i>&nbsp; Remarks</a>
  </div>
</div>





                  </td>

						</tr>

						 <?php $t++;?>



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
			 @include('admin.include.footer')
		</div>

	</div>


<!---------------------------------------------------------->
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