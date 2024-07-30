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
</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		    <div class="page-header">
						<!--<h4 class="page-title">Organisation</h4>-->

					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-money-bill-wave-alt"></i> Payment Received <span><a data-toggle="tooltip" data-placement="bottom" title="Recieved Payment" href="{{ url('superadmin/add-received-payment') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
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
													<th>Description</th>

													<th>Billing Amount</th>
													<th>Bill Date</th>
													<th>Received Amount</th>
													<th>Payment Entry Date</th>
													<th>Payment Receive Date</th>
													<th>Status</th>


												<th>Payment Receipt</th>
												<th>TP Ref#</th>

												</tr>
											</thead>

											<tbody>
											  <?php $i = 1;?>
							@foreach($pay_rs as $company)
								<?php
$pass = DB::Table('registration')

    ->where('reg', '=', $company->emid)

    ->first();

	$billing_loop= DB::Table('billing')
                    ->where('in_id', '=', $company->in_id)
                    ->first();

					$billing_to='';
if(!empty($billing_loop)){

	
	if($billing_loop->billing_type=='Organisation'){
		if($billing_loop->bill_for=='first invoice recruitment service'){
			if($billing_loop->bill_to=='Organisation'){
				
			if(isset($pass->com_name))
			{
				
				$billing_to=$pass->com_name;
                         }
                         else{
                              $billing_to='';
                           }


			}else{
				$billing_to=$billing_loop->canidate_name;
			}

		}elseif($billing_loop->bill_for=='second invoice visa service'){
			if($billing_loop->bill_to=='Organisation'){
				$billing_to=$pass->com_name;
			}else{
				$billing_to=$billing_loop->canidate_name;
			}

		}else{
			if(isset($pass->com_name))
			{
				
				$billing_to=$pass->com_name;
                         }
                         else{
                              $billing_to='';
                           }

			//$billing_to=$pass->com_name;
		}
	}elseif($billing_loop->billing_type=='Candidate'){
		$billing_to=$billing_loop->canidate_name;
	}


}

	
	

?>
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $company->in_id }}</td>
							<td>
							{{$billing_to}}
							

							</td>

							<td>{{ $company->des }}</td>



                              <td>{{ $company->amount }}</td>
                              <td>{{ date('d/m/Y',strtotime($company->date)) }}</td>
                                <td>{{ $company->re_amount }}</td>
                              <td>{{ date('d/m/Y',strtotime($company->payment_date)) }}</td>
                              <td>{{ date('d/m/Y',strtotime($company->actual_payment_date)) }}</td>


							<td>{{ strtoupper($company->status) }}</td>

                            <td class="icon" style="text-align: center;">
							
                                          <a href="{{url('download-invoice').'/'.base64_encode($company->id)}}" data-toggle="tooltip" data-placement="bottom" title="Download" download>
<img style="width: 14px;" src="{{asset('assets/img/download.png')}}">	</a>
                                          <!-- <a href="{{asset('public/paypdf/'.$company->pay_recipt_pdf)}}" data-toggle="tooltip" data-placement="bottom" title="Download" download>
<img style="width: 14px;" src="{{asset('assets/img/download.png')}}">	</a> -->
						@if($company->pay_recipt_pdf!='')	@endif</td>
						<td>{{ $company->tp_xref }}</td>

						</tr>

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
</body>
</html>