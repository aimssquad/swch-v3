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
									<h4 class="card-title"><i class="far fa-newspaper"></i> Billing Remarks <span><a href="{{ url('superadmin/billing') }}" style="padding:8px;" class="btn btn-default" title="Back to billing">Back</a></span></h4>
									@if(Session::has('message'))
							            <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					                @endif
								</div>
								<div class="card-body">
                                    <?php
                                    if ($bill_rs->billing_type == 'Organisation') {
                                        $pass = DB::Table('registration')
                                    
                                            ->where('reg', '=', $bill_rs->emid)
                                    
                                            ->first();}
                                    ?>
                                    <div class="row">
                                        <div class="col-md-3"><div class="form-group"><label>Invoice Number:</label> {{$bill_rs->in_id}}</div></div>
                                        <div class="col-md-3"><div class="form-group"><label>Bill To:</label> @if($bill_rs->billing_type=='Organisation')
                                            @if($bill_rs->bill_for=='first invoice recruitment service')
                                                {{ $bill_rs->canidate_name }}
                                                <p><small>({{ $pass->com_name }})</small></p>
                                            @elseif($bill_rs->bill_for=='second invoice visa service')
                                                {{ $bill_rs->canidate_name }}
                                                <p><small>({{ $pass->com_name }})</small></p>
                                            @else
                                                {{ $pass->com_name }}
                                            @endif
                                        @else
                                            {{ $bill_rs->canidate_name }}
                                        @endif
                                        </div></div>
                                        <div class="col-md-3"><div class="form-group"><label>Invoice Date:</label> {{ date('d/m/Y',strtotime($bill_rs->date)) }}</div></div>
                                        <div class="col-md-3"><div class="form-group"><label>Amount:</label> &pound;{{ $bill_rs->amount }}</div></div>
                                    </div>
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th width="2%">Sl.No.</th>
													<th>Remarks</th>
													<th width="10%">Added By</th>
													<th width="8%">Added On</th>
													<th width="2%">Action</th>
												</tr>
											</thead>

											<tbody>
											 
							                @foreach($billing_remarks as $record)
								
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $record->remarks }}</td>
                                                    <td>{{ ($record->added_by=='')? 'Superadmin' :$record->added_by }}</td>
                                                    <td>{{ date('d/m/Y',strtotime($record->created_at))  }}</td>
                                                    <td class="drp">
                                                        <script language="JavaScript" type="text/javascript">
                                                            function checkDelete(){
                                                            return confirm('Are you sure you want to delete this remarks?');
                                                            }
                                                        </script>
                                                        <a href="{{url('superadmin/delete-remarks-billing/'.base64_encode($record->id))}}" onClick="return checkDelete()"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
            								</tbody>
										</table>
									</div>
								</div>
                                <hr/>
                                <div class="card-body">
                                    <h2>Add New Remarks</h2>
                                    <form action="{{url('superadmin/save-remarks-billing')}}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="billing_id" value="{{ $bill_rs->id }}">
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="remarks" class="placeholder">Remarks</label>
                                                    <textarea class="form-control" required="" name="remarks" id="remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-default">Submit</button>
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