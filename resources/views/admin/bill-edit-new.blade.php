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
</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">Organisation</h4> -->

					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-edit"></i> Edit Billing</h4>
								</div>
								<div class="card-body">
									<form action="{{url('superadmin/edit-billing')}}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}

			 	<input type="hidden" class="form-control input-border-bottom" id="dom_pdf" name="dom_pdf" required="" value="{{$bill[0]->dom_pdf}}">
			 	<input type="hidden" class="form-control input-border-bottom" id="emid" name="emid" required="" value="{{$bill[0]->emid}}">
			 		<input type="hidden" class="form-control input-border-bottom" id="date" name="date" required="" value="{{$bill[0]->date}}">
			 		<input type="hidden" class="form-control input-border-bottom" id="in_id" name="in_id" required="" value="{{$bill[0]->in_id}}">
					<input type="hidden" class="form-control input-border-bottom" id="canidate_name" name="canidate_name" required="" value="{{$bill[0]->canidate_name}}">
					<input type="hidden" class="form-control input-border-bottom" id="canidate_email" name="canidate_email" required="" value="{{$bill[0]->canidate_email}}">
					<input type="hidden" class="form-control input-border-bottom" id="candidate_address" name="candidate_address" value="{{$bill[0]->candidate_address}}">
					<input type="hidden" class="form-control input-border-bottom" id="candidate_id" name="candidate_id" required="" value="{{$bill[0]->candidate_id}}">
					<input type="hidden" class="form-control input-border-bottom" id="billing_type" name="billing_type" required="" value="{{$bill[0]->billing_type}}">
										<div class="row form-group">
										    	<div class="col-md-4">
						<div class="form-group ">


						<label for="selectFloatingLabel" class="placeholder"> Organisation</label>
						<?php
$res = DB::table('registration')

    ->where('reg', '=', $bill[0]->emid)
    ->first();

?>
							<input type="text" class="form-control input-border-bottom" id="com_name" name="com_name" required="" value="{{$res->com_name}}" readonly>

										</div>


											</div>
										@if($bill[0]->billing_type=='Organisation')
                                        @if($bill[0]->bill_for=='first invoice recruitment service')
                                        	<div class="col-md-3" id="rec_can_id" >
                                                <div class="form-group">
                                                    <label for="rec_candidate_name" class="placeholder">
                                                        Recruitment Candidate</label>


                                                    <input type="text" class="form-control input-border-bottom" id="rec_candidate_name" name="rec_candidate_name"  value="{{$recruitment_file_emp->employee_name}}" readonly>
                                                </div>


                                            </div>
											<div class="col-md-3">
                                                <div class=" form-group">
                                                    <label for="hold_st" class="placeholder">Bill To </label>
													<input type="text" class="form-control input-border-bottom" id="bill_to" name="bill_to"  value="{{$bill[0]->bill_to}}" readonly>

                                                </div>
                                            </div>
                                            @endif
                                        @if($bill[0]->bill_for=='second invoice visa service')
                                        	<div class="col-md-3" id="rec_can_id" >
                                                <div class="form-group">
                                                    <label for="rec_candidate_name" class="placeholder">
                                                        Recruitment Candidate</label>


                                                    <input type="text" class="form-control input-border-bottom" id="rec_candidate_name" name="rec_candidate_name" required="" value="{{$cos_apply_emp->employee_name}}" readonly>
                                                </div>


                                            </div>
											<div class="col-md-3">
                                                <div class=" form-group">
                                                    <label for="hold_st" class="placeholder">Bill To </label>
													<input type="text" class="form-control input-border-bottom" id="bill_to" name="bill_to"  value="{{$bill[0]->bill_to}}" readonly>

                                                </div>
                                            </div>
                                            @endif
										@elseif($bill[0]->billing_type=='Candidate')
											<div class="col-md-4">
						<div class="form-group ">


						<label for="selectFloatingLabel" class="placeholder"> Candidate</label>

							<input type="text" class="form-control input-border-bottom" id="canidate_name" name="canidate_name" required="" value="{{$bill[0]->canidate_name}}" readonly>

										</div>
										</div>
											@endif

												<div class="col-md-4">
												<div class=" form-group">
													<label for="hold_st" class="placeholder">On Hold </label>
													<select class="form-control input-border-bottom"   id="hold_st" required=""  name="hold_st" onchange="bank_epmloyee(this.value);">
													<option value="">&nbsp;</option>
													<option value="Yes" @if($bill[0]->hold_st=='Yes') selected @endif >Yes</option>
																<option value="No" @if($bill[0]->hold_st=='No') selected @endif @if($bill[0]->hold_st=='') selected  @endif>No</option>





												</select>


												</div>
											</div>
											<div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="bill_for" class="placeholder">Billing For </label>
                                                    <select class="form-control input-border-bottom" id="bill_for"
                                                        required="" name="bill_for" readonly>
                                                        <option value="">&nbsp;</option>
                                                        <option value="invoice for license applied" @if($bill[0]->bill_for=='invoice for license applied') selected  @endif>Invoice for license applied</option>
                                                        <option value="invoice for license granted" @if($bill[0]->bill_for=='invoice for license granted') selected  @endif>Invoice for license granted</option>
                                                        <option value="first invoice recruitment service" @if($bill[0]->bill_for=='first invoice recruitment service') selected  @endif>First invoice for recruitment service</option>
                                                        <option value="second invoice visa service" @if($bill[0]->bill_for=='second invoice visa service') selected  @endif>Second invoice for visa service</option>
                                                        <option value="other" @if($bill[0]->bill_for=='other') selected  @endif>Other</option>
                                                    </select>
                                                    <!-- <input type="text" class="form-control input-border-bottom" id="bill_for" name="bill_for" required="" readonly value="{{$bill[0]->bill_for}}"> -->
                                                </div>
                                            </div>

												<div class="col-md-4">
												<div class=" form-group">
													<label for="hold_st" class="placeholder">Payment Mode </label>
													<select class="form-control input-border-bottom"   id="pay_mode" required=""  name="pay_mode" >
													<option value="">&nbsp;</option>
													<!-- <option value="Online" @if($bill[0]->pay_mode=='Online') selected @endif >Online</option> -->
																<option value="Ofline" @if($bill[0]->pay_mode=='Ofline') selected @endif >Offline</option>





												</select>


												</div>
											</div>

											  <div class="col-md-4 " id="criman_bank_new" @if($bill[0]->hold_st=='Yes') style="display:block;" @else  style="display:none;" @endif >
										    <div class="form-group">
										        	<label for="other" class="placeholder">Give Details </label>
												<input id="other"  type="text" class="form-control input-border-bottom" name="other"  value="{{$bill[0]->other}}" >

											</div>
										   </div>
										   </div>



										   	<div id="dynamic_row">
											<?php $tr_id = 0;?>
											<?php foreach ($bill as $value) {?>
									<div class="row form-group" >
					<div class="col-md-4">
					<div class="form-group">
						<label for="des" class="placeholder">Description</label>
						<select class="form-control input-border-bottom"   id="package{{$tr_id}}" required=""  name="package[]" style="margin-top: 22px;" onchange="checkpackage(this.value,{{$tr_id}});">
													<option value="">&nbsp;</option>

												<?php
foreach ($package_rs as $package) {

    ?>
		<option value="{{$package->id}}"  @if($package->id== $value->package) selected @endif>{{$package->name}}</option>
		<?php
}
    ?>


												</select>

											 <input id="des{{$tr_id}}"  value="{{$value->des}}"  name="des[]"   type="hidden" class="form-control"  required >


											</div>
											</div>
											<?php
$pack = DB::table('package')

        ->where('id', '=', $value->package)
        ->first();

    ?>
											<div class="col-md-4" id="ex_vat_div{{$tr_id}}">
												<div class=" form-group">
													<label for="anount_ex_vat" class="placeholder">Unit Price Excluding VAT</label>
													<input id="anount_ex_vat{{$tr_id}}"  value="{{$value->anount_ex_vat}}"   type="number"  name="anount_ex_vat[]"  readonly   class="form-control input-border-bottom" required="" style="margin-top: 22px;"  >


												</div>
											</div>
											<div class="col-md-2"  id="discount_type_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="discount" class="placeholder">Discount Type</label>
                                                        <select id="discount_type{{$tr_id}}" @if( !empty($pack) && $pack->discount_apply== 'N/A') readonly @elseif( !empty($pack) && $pack->discount_apply== 'Yes') @else readonly @endif  class="form-control input-border-bottom"  style="margin-top: 22px;"
                                                        required name="discount_type[]"  onchange="checkpackagedis(this.value,{{$tr_id}});" >
                                                        <option value="P" @if($value->discount_type=='P') selected @endif >Percentage</option>
                                                        <option value="A" @if($value->discount_type=='A') selected @endif >Absolute</option>
                                                        </select>
                                                    </div>
                                                </div>


											<div class="col-md-2"  id="discount_div{{$tr_id}}">
												<div class=" form-group">
													<label for="discount" class="placeholder">Discount</label>
													@if($value->discount_type=='P')
													<input id="discount{{$tr_id}}"  value="{{$value->discount_percent}}" @if( !empty($pack) && $pack->discount_apply== 'N/A') readonly @elseif( !empty($pack) && $pack->discount_apply== 'Yes') @else readonly @endif   type="number" step=".01"  name="discount[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;" onkeyup="checkpackagedis(this.value,{{$tr_id}});" onclick="checkpackagedis(this.value,{{$tr_id}});">
													@else
													<input id="discount{{$tr_id}}"  value="{{$value->discount}}" @if( !empty($pack) && $pack->discount_apply== 'N/A') readonly @elseif( !empty($pack) && $pack->discount_apply== 'Yes') @else readonly @endif   type="number"  name="discount[]"  step=".01"  class="form-control input-border-bottom" required="" style="margin-top: 22px;" onkeyup="checkpackagedis(this.value,{{$tr_id}});" onclick="checkpackagedis(this.value,{{$tr_id}});">

													@endif



												</div>
											</div>

											<div class="col-md-2" id="discount_amount_div{{$tr_id}}">
												<div class=" form-group">
													<label for="discount_amount" class="placeholder">Discounted Amount</label>
													<input id="discount_amount{{$tr_id}}"  value="{{$value->discount_amount}}" readonly  type="number"  name="discount_amount[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;"  >


												</div>
											</div>
											<div class="col-md-2"  id="vat_div{{$tr_id}}">
												<div class=" form-group">
													<label for="vat" class="placeholder">Vat in %</label>
													<input id="vat{{$tr_id}}" type="number"  name="vat[]"  value="{{$value->vat}}" readonly    value="{{$value->vat}}"  class="form-control input-border-bottom" required="" style="margin-top: 22px;" >


												</div>
											</div>

												<div class="col-md-2" id="amount_after_vat_div{{$tr_id}}">
												<div class=" form-group">
													<label for="amount_after_vat" class="placeholder">Amount After Vat</label>
													<input id="amount_after_vat{{$tr_id}}" type="number"  name="amount_after_vat[]"  readonly  value="{{$value->amount_after_vat}}"    class="form-control input-border-bottom" required="" style="margin-top: 22px;"  onchange="checkcompany();">


												</div>
											</div>
											<div class="col-md-2" id="net_amount_div{{$tr_id}}">
												<div class=" form-group">
													<label for="net_amount" class="placeholder">Net Amount </label>
													<input id="net_amount{{$tr_id}}" type="number"  name="net_amount[]"  readonly  value="{{$value->net_amount}}"    class="form-control input-border-bottom" required="" style="margin-top: 22px;"  >


												</div>
											</div>
<?php $tr_id++;?>
					  @if ($tr_id==count($bill))
											<div class="col-md-2" style="margin-top:30px;"><div class=" form-group btn-pls">
											<!-- <button class="btn btn-success " style="margin-bottom:0;" type="button" id="add<?php echo ($tr_id); ?>"  onClick="addnewrow(<?php echo ($tr_id); ?>)" data-id="<?php echo ($tr_id); ?>"> <i class="fas fa-plus"></i> </button> -->

											</div>
												</div>
						@endif

											</div>
											<?php }
?>
											</div>
										 <div class="row form-group">
										 	<input id="amount" type="hidden"  name="amount" value="{{$bill[0]->amount}}"   class="form-control input-border-bottom" required="" style="margin-top: 22px;"  onchange="checkcompany();">

					<div class="col-md-4 btn-up">
						<button type="submit" class="btn btn-default btn-up">Submit</button>
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
		  function bank_epmloyee(val) {
	if(val=='Yes'){
	document.getElementById("criman_bank_new").style.display = "block";
	}else{
		document.getElementById("criman_bank_new").style.display = "none";
	}

}



   function checkpackage(val,row){
	   var empid=val;

	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getpcakgedeatilsbyId')}}/'+empid,
        cache: false,
		success: function(response){


			var obj = jQuery.parseJSON(response);

			 console.log(obj);
			 $("#des"+row).val(obj[0].name);
			$("#anount_ex_vat"+row).val(obj[0].price);
			$("#anount_ex_vat"+row).prop("readonly", true);

			if(obj[0].discount_apply=='Yes'){
				$("#discount_div"+row).show();
				$("#discount_type_div" + row).show();
				$("#discount"+row).prop("readonly", false);
				$("#discount_amount"+row).val('0');
				 $("#discount_amount"+row).prop("readonly", true);
			}else{
				$("#discount_div"+row).show();
				$("#discount_type_div" + row).show();
				 $("#discount"+row).prop("readonly", true);
			 	$("#discount_amount"+row).prop("readonly", true);
				$("#discount"+row).val('0');
				$("#discount_amount"+row).val('0');

			}

			if(obj[0].vat_apply=='Yes'){

				$("#vat_div"+row).show();
				$("#vat"+row).val(obj[1].percent);
				 $("#vat"+row).prop("readonly", true);
				var percent=obj[1].percent;
			}else{
				$("#vat_div"+row).show();
				 $("#vat"+row).prop("readonly", true);
				$("#vat"+row).val('0');
				var percent='0';
			}

		var price_vat=Number(obj[0].price)* Number(percent)/100;
		price_vat=parseFloat(price_vat).toFixed(2);

 $("#amount_after_vat"+row).prop("readonly", true);
  $("#net_amount"+row).prop("readonly", true);
			var price_after_vat=(parseFloat(price_vat)+parseFloat(obj[0].price));
				$("#ex_vat_div"+row).show();
				$("#discount_amount_div"+row).show();
				$("#amount_after_vat_div"+row).show();
				$("#net_amount_div"+row).show();

			$("#amount_after_vat"+row).val(price_after_vat);
$("#net_amount"+row).val(price_after_vat);
	var totval=document.getElementById("amount").value;
	if(totval==''){
		totval='0';
	}
	if(obj[0].discount_apply=='N/A'){
	var price_amou=parseFloat(totval)+parseFloat(price_after_vat);
 $('#amount').val(price_amou);
		 $("#amount").prop("readonly", true);
	}
		}
		});
   }
   function checkpackagedis(val, row) {

var discount_input = document.getElementById("discount" + row).value;
var discount_type = document.getElementById("discount_type" + row).value;

//    console.log(discount_type);

var discount = 0;

var price_bevat = document.getElementById("anount_ex_vat" + row).value;


if(discount_type=='A'){
	if(parseFloat(discount_input)>parseFloat(price_bevat) || parseFloat(discount_input)<0){
		alert('Invalid discount value.');

	}
	discount =discount_input;
}

if(discount_type=='P'){
	if(parseFloat(discount_input)>100 || parseFloat(discount_input)<0){
		alert('Invalid discount value.');

	}
	discount = Math.round(((parseInt(price_bevat) * parseInt(discount_input))/100),2);
}

var price_amou = parseFloat(price_bevat) - parseFloat(discount);

if (discount != 0) {
	$('#discount_amount' + row).val(price_amou);
} else {
	$('#discount_amount' + row).val('0');
}

var percent = document.getElementById("vat" + row).value;
var price_vat = Number(price_amou) * Number(percent) / 100;
price_vat=parseFloat(price_vat).toFixed(2);
var price_after_vat = (parseFloat(price_vat) + parseFloat(price_amou));

$("#amount_after_vat" + row).val(price_after_vat);
$("#net_amount" + row).val(price_after_vat);

var totvalnn = document.getElementById("amount").value;
if (totvalnn == '') {
	totvalnn = '0';
}

var price_amounew = parseFloat(totvalnn) + parseFloat(price_after_vat);
$('#amount').val(price_amounew);
$("#amount").prop("readonly", true);


}

 function addnewrow(rowid)
	{



		if (rowid != ''){
				$('#add'+rowid).attr('disabled',true);

		}



		$.ajax({

				url:'{{url('billing/get-add-row-item')}}/'+rowid,
				type: "GET",

				success: function(response) {

					$("#dynamic_row").append(response);

				}
			});
	}

	function delRow(rowid)
	{
		var lastrow = $(".itemslot:last").attr("id");

        var active_div = (rowid);
        $('#add'+active_div).attr('disabled',false);

        $(document).on('click','.deleteButton',function() {
            $(this).closest("div.itemslot").remove();
        });


	    /*$(document).on('click','.deleteButton',function(rowid) {
            if (rowid > 1){
                $('#add'+rowid).removeAttr("disabled");

            }
  		    $(this).closest("div.itemslot").remove();
		});*/
	}
	</script>
</body>
</html>