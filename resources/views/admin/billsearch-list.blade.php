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

	<style> .add-shift {
    float: right;
} .add-shift .add-shift-btn {
    padding: 6px 24px !important;
    font-size: 14px !important;
    margin: 0px 20px 15px 0px !important;
    background-color: #9e9797 !important;
    color: #fff !important;
}  </style>
</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">Billing Report</h4> -->

					</div>
			<div class="content">
				<div class="page-inner">

							<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-newspaper"></i> Billing Search</h4>
									@if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									 <form  method="post" action="{{ url('superadmin/billing-search') }}" enctype="multipart/form-data" >
									 {{csrf_field()}}
										<div class="row">

										  	<div class="col-md-4">
												<div class=" form-group">
												<label for="start_date"  class="placeholder">Form Date</label>
												<input id="start_date"  type="date"  name="start_date" class="form-control input-border-bottom"  onchange="checkreff(this.value);" value="<?php if (isset($start_date)) {echo $start_date;}?>">


									        	</div>
								     		</div>

								     		   <div class="col-md-4">
												<div class=" form-group">
												<label for="end_date"  class="placeholder">To Date</label>
												<input id="end_date"  type="date" name="end_date" class="form-control input-border-bottom"  value="<?php if (isset($end_date)) {echo $end_date;}?>" onchange="checkreff(this.value);">

<input id="amount"  type="hidden" name="amount" class="form-control input-border-bottom" >

<input id="status"  type="hidden" name="status" class="form-control input-border-bottom" >

					<input id="or_name"  type="hidden" name="or_name" class="form-control input-border-bottom" >

									        	</div>
								     		</div>
									<!--	<div class="col-md-4">
										  	<div class=" form-group">
										  <label for="amount" class="placeholder"> Select Amount</label>

										  <select class="form-control input-border-bottom" id="amount" name="amount">

							<option value="">&nbsp;</option>

			                 @foreach($bill_amout_rs as $dept)
                            <option value='{{ $dept->amount }}' <?php if (isset($amount)) {if ($amount == $dept->amount) {echo 'selected';}}?> >{{ $dept->amount }}</option>

                            @endforeach

						</select>


										  </div>
										  </div>
										 	<div class="col-md-4">
										  	<div class=" form-group">
										  <label for="status" class="placeholder"> Select Status</label>

										  	  				<select class="form-control input-border-bottom" id="status" name="status">

							<option value="">&nbsp;</option>

			                 @foreach($bill_sta_rs as $dept)
                            <option value='{{ $dept->status }}' <?php if (isset($status)) {if ($status == $dept->status) {echo 'selected';}}?> >{{ strtoupper($dept->status )}}</option>

                            @endforeach

						</select>


										  </div>
										  </div>



											<div class="col-md-4">
										  	<div class=" form-group">

<label for="status" class="placeholder"> Select Organisation</label>
										  	  				<select class="form-control input-border-bottom" id="or_name" name="or_name">

							<option value="">&nbsp;</option>

			                 @foreach($orname as $deptgg)
                            <option value='{{ $deptgg->reg }}' <?php if (isset($or_name)) {if ($or_name == $deptgg->reg) {echo 'selected';}}?> >{{ $deptgg->com_name }}</option>

                            @endforeach

						</select>


										  </div>
										  </div>


									-->

										</div>


											<div class="row form-group">
										    <div class="col-md-4">
										    <div class="sub-reset-btn">
								     		<a href="#">
    										    <button class="btn btn-default" type="submit" style="margin-top: 28px; background-color: #1572E8!important; color: #fff!important;">View Search</button></a>


										    </div>

								     		</div>
											</div>



									</form>
								</div>
							</div>
						</div>
					</div>

						<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-newspaper"></i> Billing Search @if(isset($result) && $result != '')

<form  method="post" action="{{ url('superadmin/billing-search-export') }}" enctype="multipart/form-data" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="s_start_date" value="{{ $start_date }}">
<input type="hidden" name="s_end_date" value="{{ $end_date }}">
<input type="hidden" name="s_amount" value="{{ $amount }}">
<input type="hidden" name="s_status" value="{{ $status }}">

	 <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="background:none !important;padding: 10px 15px;margin-top: -30px;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
		</form>

		@endif</h4>


								</div>
								<div class="card-body">

									<div class="table-responsive">

										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
												    	<th>Sl No</th>
												    	<th>Invoice Number</th>
											            <th>Bill  To</th>
													    <th>Bill Amount</th>
														<th> Payment Received</th>
														<th> Due Amount</th>
														<th>Status</th>
													    <th>Bill Date</th>
														<th>License Applied</th>
														<th>Action</th>
													</tr>
											</thead>

											<tbody>
															 <?php

if (isset($result) && $result != '') {
    print_r($result);
}?>

											</tbody>
												<tfoot>
												     <?php

if (isset($result) && $result != '') {
    ?>
													  <td></td>

													  <td></td>


         <td  >Total :</td>

         <td>		 <?php

    if (isset($result) && $result != '') {echo $totam;}?></td>
  <td> <?php

    if (isset($result) && $result != '') {echo $topayre;}?></td>
         <td> <?php

    if (isset($result) && $result != '') {echo $totdue;}?></td>
<?php
}
?>
  <td></td>

													  <td></td>
													  <td></td>
													</tfoot>
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

	 <?php

if (isset($result) && $result != '') {
    ?>
	  <?php $t = 1;?>
	@foreach($billing_search_result as $company)
	<?php
$bill = DB::table('billing')

        ->where('in_id', '=', $company->in_id)
        ->get();
    $data['package_rs'] = DB::Table('package')
        ->where('status', '=', 'active')
        ->get();
    $Roledata = DB::table('registration')

        ->where('reg', '=', $bill[0]->emid)
        ->first();?>
<!----------------------view-invoice-popup-------------------->
<div class="modal" id="myModal<?=$company->id?>">
  <div class="modal-dialog" style="max-width: 1100px;">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="padding-top:0px; padding-bottom:0px; border-bottom: 0;">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-0">
        <table class="main-dash" style="width: 100%;font-family: calibri;border-bottom:1px solid #000;max-width: 1000px;margin: auto; padding-bottom:5px;">
		<thead>
			<tr>
				<th colspan="2"><h1 style="margin-top: 0;margin-bottom: 0;text-align: center;"><b>INVOICE</b></h1></th>
			</tr>

		</thead>
		<tbody>
			<tr>
				<td>
				    
				    <h3 style="color: #d27eff; margin-bottom:0px;"><b>WORKPERMITCLOUD LIMITED</b></h3>
                <p style="color: #000; margin-bottom:0px;">1st Floor, 112-116 Whitechapel Road<br>London, E1 1JE</p>
                <p style="color: #000; margin-bottom:0px;">Phone: 02080872343<br>Email:info@workpermitcloud.co.uk<br>
                	<a href="http://workpermitcloud.co.uk/" target="_blank">www.workpermitcloud.co.uk</a></p>
				</td>

				<td style="text-align: right;">
				    <p style="margin-bottom:0px;"><img src="https://skilledworkerscloud.co.uk/img/swch_logo.png" alt=""></p>
				    <p style="color: #000;"><b>VAT Registration Number:</b> <b>384 3919 60</b></p>
				</td>
			</tr>
		</tbody>
	</table>

	<table style="width: 100%;font-family: calibri;max-width: 1000px;margin: auto;">
		<thead>
			<tr>
				<th style="text-align: left;width:300px;"><h3>Bill To</h3>


               @if($bill[0]->billing_type=='Organisation')


                   <p style="margin-bottom: 0;">{{$Roledata->com_name}}</p>
				   @elseif($bill[0]->billing_type=='Candidate')
				   <p style="margin-bottom: 0;">{{$bill[0]->canidate_name}}</p>
				   @endif
				  	@if($bill[0]->billing_type=='Organisation')
				   <p style="margin-bottom: 0;">{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}} @if($Roledata->road!='') , @endif {{ $Roledata->road}}  @if($Roledata->city!='') , @endif {{$Roledata->city}}  @if($Roledata->zip!='') , @endif {{$Roledata->zip}}  @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>

	  @elseif($bill[0]->billing_type=='Candidate')
	  <?php
//   $newadd=DB::table('candidate')

    //               ->where('id','=',$bill[0]->candidate_id)
    //               ->first();
    ?>
	   <p style="margin-bottom: 0;">{{ $bill[0]->canidate_name}}</p>

	  @endif


				</th>
				<th style="float: right; margin-top:15px;"><h4 style="margin-bottom: 0;">Invoice no:{{$bill[0]->in_id}}</h4>
                 <h4 style="margin: 0;">Issue Date: {{ date('d/m/Y',strtotime($bill[0]->date)) }}</h4>
				</th>
			</tr>
		</thead>
	</table>
	<?php $amount = 0;
    $disc = 0;
    $vatc = 0;
    $subtot = 0;
    $vatexclu = 0;
    $vatam = 0;
    $vatnew = 0;
    if ($bill && count($bill) != 0) {
        foreach ($bill as $value) {

            $amount = $amount + $value->net_amount;
            $disc = $disc + $value->discount;

            $vatc = $vatc + $value->vat;
            $subtot = $subtot + $value->anount_ex_vat;
            if ($value->discount != 0) {
                $vatexclu = $vatexclu + $value->discount_amount;
            } else {
                $vatexclu = $vatexclu + $value->anount_ex_vat;
            }
            $vatam = $amount - $vatexclu;
        }
    }
    $vatvalt = DB::table('tax_bill')

        ->where('id', '=', '1')
        ->first();
    $vatnew = $vatvalt->percent;

    ?>
<div class="table-responsive">
	<table class="vt" border="1" style="width: 100%;font-family: calibri;border:1px solid #ecebfd;border-collapse: collapse;max-width: 1000px;margin: auto;">
	<thead style="background:#d27eff;color: #fff;">
	<tr>
		<th>Sl. no</th>
		<th>Description</th>
		<th>Quantity</th>
		<th>Unit Price Excluding VAT</th>
		 @if($disc!=0)
		<th>Discount</th>
		@endif
		<th>Taxable Unit Price</th>
		@if($vatc!=0)
		<th>VAT @ {{$vatnew}}%</th>
		@endif
		<th>Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
$i = 0;
    if ($bill && count($bill) != 0) {
        foreach ($bill as $value) {

            ?>
		<tr>
		<td>{{($i+1)}}</td>
		<td>{{$value->des}}</td>
		<td>1</td>
		<td>£{{$value->anount_ex_vat}}</td>
		 @if($disc!=0)
		<td>£{{$value->discount}}</td>
		@endif
		<td> @if($value->discount!=0) £ {{$value->discount_amount}} @else £ {{$value->anount_ex_vat}} @endif</td>
			@if($vatc!=0)<td>£ <?php if ($value->discount != 0) {$newval = $value->discount_amount;} else { $newval = $value->anount_ex_vat;}

            echo ($value->net_amount - $newval);?></td>@endif
		<td>£{{$value->net_amount}}</td>
	</tr>
		<?php
$i++;
        }
    }
    ?>

<tr>	<td></td>
	<td>Subtotal</td>
	<td>{{count($bill )}}</td>
	<td>£ {{$subtot}}</td>

	@if($disc!=0)
	<td>£ {{$disc}}</td>
@endif
	<td>£ {{$vatexclu}}</td>


	@if($vatc!=0)
<td>£ {{($amount-$vatexclu)}}</td>
@endif
	<td>£{{$amount}}</td>
</tr>


<tr>	<td></td>
		<td><b>Total Payable</b></td>
	<td></td>
	<td></td>

	@if($disc!=0)
	<td></td>
@endif

	<td></td>
	@if($vatc!=0)
<td></td>
@endif
	<td><b>£{{$amount}}</b></td>
</tr>
	</tbody>
</table>
</div>
<?php
$number = $amount;
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else {
            $str[] = null;
        }

    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
    "." . $words[$point / 10] . " " .
    $words[$point = $point % 10] : '';

    ?>

   <div class="table-responsive">
<table style="width: 100%;font-family: calibri;max-width: 1000px;margin: auto;">
	<tbody><tr>
		<td>Amount in words: GBP <?=trim($result . $points);?> Only</td>
	</tr>
	<tr>
		<td><p><b>Workpermitcloud Limited</b><br>Sort Code: 60-83-71<br>Account Number: 56413088</p></td>
	</tr>
	<tr>
		<td><p style="text-align: center;font-size:14px;">Thank you for selecting WORKPERMITCLOUD LIMITED as your preferred business partner!  This is a system generated invoice and require no signature.</p>
</td>
	</tr>

</tbody></table>
</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      	<a class="print-invoice btn btn-primary" onclick="$('#div2<?=$company->id?>').print();" data-href="https://workpermitcloud.co.uk/hrms/view-billing/MjAyMS8wNy8wMjA=" style="color: #fff;"><i class="fa fa-print" aria-hidden="true"></i> Print Invoice</a>
     <a class="print-invoice btn btn-info" href="{{asset('public/billpdf/'.$bill[0]->dom_pdf)}}" download><i class="fas fa-file-download"></i> Download</a>
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<div id="div2<?=$company->id?>" style="display:none;">

<!doctype html>
<html lang="en">
<head>
	<title>WorkPermitCloud</title>
	<style type="text/css">
		td, th{vertical-align: top;padding: 3px;}
.vt td, .vt th{border-right: none;border-left: none;}
.vt tr:nth-child(odd) {background-color: #ecebfd;}.vt thead tr th{background:#d27eff !important;color: #fff;text-align: left;}
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
	<table class="main-head" style="width: 100%;font-family: calibri; border-bottom: 1px solid #000;max-width: 900px;margin: auto; padding-bottom:10px;">
		<thead>
			<tr>
				<th colspan="2"><h1 style="margin-top: 0;margin-bottom: 0;">INVOICE</h1></th>
			</tr>

		</thead>
		<tbody>
			<tr>
				<td><h3 style="color: #28acf4;"><b>WORKPERMITCLOUD LIMITED</b></h3>
                <p>1st Floor, 112-116 Whitechapel Road<br>London, E1 1JE</p>
                <p>Phone: 02080872343<br>Email:info@workpermitcloud.co.uk<br>
                	<a href="http://workpermitcloud.co.uk/" target="_blank">www.workpermitcloud.co.uk</a></p>
                <p>VAT Registration Number: <b>384 3919 60</b></p>
				</td>

				<td style="text-align: right;"><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/comp-logo.jpg" alt=""></td>
			</tr>
		</tbody>
	</table>
	<table style="width: 100%;font-family: calibri;max-width: 900px;margin: auto;">
		<thead>
			<tr>
					<th style="text-align: left;width:300px;"><h3>Bill To</h3>
				@if($bill[0]->billing_type=='Organisation')


                  <p style="margin-bottom: 0;">{{$Roledata->com_name}}</p>
				   @elseif($bill[0]->billing_type=='Candidate')
				   <p style="margin-bottom: 0;">{{$bill[0]->canidate_name}}</p>
				   @endif
				  	@if($bill[0]->billing_type=='Organisation')
				   <p style="margin-bottom: 0;">{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}} @if($Roledata->road!='') , @endif {{ $Roledata->road}}  @if($Roledata->city!='') , @endif {{$Roledata->city}}  @if($Roledata->zip!='') , @endif {{$Roledata->zip}}  @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>

	  @elseif($bill[0]->billing_type=='Candidate')
	  <?php
//   $newadd = DB::table('candidate')

    //     ->where('id', '=', $bill[0]->candidate_id)
    //     ->first();
    ?>
	   <p style="margin-bottom: 0;">{{ $bill[0]->canidate_name}}</p>

	  @endif

				</th>
				<th style="float: right; margin-top:15px;"><h4 style="margin-bottom: 0;">Invoice no:{{$bill[0]->in_id}}</h4>
                 <h4 style="margin: 0;">Issue Date: {{ date('d/m/Y',strtotime($bill[0]->date)) }}</h4>
				</th>
			</tr>
		</thead>
	</table>
<?php $amount = 0;
    $disc = 0;
    $vatc = 0;
    $subtot = 0;
    $vatexclu = 0;
    $vatam = 0;
    $vatnew = 0;
    if ($bill && count($bill) != 0) {
        foreach ($bill as $value) {

            $amount = $amount + $value->net_amount;
            $disc = $disc + $value->discount;
            $vatc = $vatc + $value->vat;
            $subtot = $subtot + $value->anount_ex_vat;
            if ($value->discount != 0) {
                $vatexclu = $vatexclu + $value->discount_amount;
            } else {
                $vatexclu = $vatexclu + $value->anount_ex_vat;
            }
            $vatam = $amount - $vatexclu;
        }
    }
    $vatvalt = DB::table('tax_bill')

        ->where('id', '=', '1')
        ->first();
    $vatnew = $vatvalt->percent;
    ?>

<table class="vt" border="1" style="width: 100%;font-family: calibri;border:1px solid #ecebfd;border-collapse: collapse;max-width: 900px;margin: auto;">
	<thead style="background:#d27eff;color: #fff;">
	<tr>
		<th>Sl. no</th>
		<th>Description</th>
		<th>Quantity</th>
		<th>Unit Price Excluding VAT</th>
		 @if($disc!=0)
		<th>Discount</th>
		@endif
		<th>Taxable Unit Price</th>
		@if($vatc!=0)
		<th>VAT @ {{$vatnew}}%</th>
		@endif
		<th>Total</th>
		</tr>
	</thead>
	<tbody>

	<?php
$i = 0;
    if ($bill && count($bill) != 0) {
        foreach ($bill as $value) {

            ?>
		<tr>
		<td>{{($i+1)}}</td>
		<td>{{$value->des}}</td>
		<td>1</td>
		<td>£{{$value->anount_ex_vat}}</td>
		 @if($disc!=0)
		<td>£{{$value->discount}}</td>
		@endif
		<td> @if($value->discount!=0) £ {{$value->discount_amount}} @else £ {{$value->anount_ex_vat}} @endif</td>
			@if($vatc!=0)<td>£ <?php if ($value->discount != 0) {$newval = $value->discount_amount;} else { $newval = $value->anount_ex_vat;}

            echo ($value->net_amount - $newval);?></td>@endif
		<td>£{{$value->net_amount}}</td>
	</tr>
		<?php
$i++;
        }
    }
    ?>
<tr>	<td></td>
	<td>Subtotal</td>
	<td>{{count($bill )}}</td>
	<td>£ {{$subtot}}</td>

	@if($disc!=0)
	<td>£ {{$disc}}</td>
@endif
	<td>£ {{$vatexclu}}</td>


	@if($vatc!=0)
<td>£ {{($amount-$vatexclu)}}</td>
@endif
	<td>£{{$amount}}</td>
</tr>


<tr>	<td></td>
	<td><b>Total Payable</b></td>
	<td></td>
	<td></td>

	@if($disc!=0)
	<td></td>
@endif

	<td></td>
	@if($vatc!=0)
<td></td>
@endif
	<td>£{{$amount}}</td>
</tr>
	</tbody>
</table>
<?php
$number = $amount;
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else {
            $str[] = null;
        }

    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
    "." . $words[$point / 10] . " " .
    $words[$point = $point % 10] : '';

    ?>
<table style="width: 100%;font-family: calibri;max-width: 900px;margin: auto;">
	<tr>
		<td>Amount in words: GBP <?=trim($result . $points);?> Only</td>
	</tr>
	<tr>
		<td><p>Workpermitcloud Limited<br>Sort Code: 60-83-71<br>Account Number: 56413088</p></td>
	</tr>
	<tr>
		<td><p style="text-align: center;font-size:14px;">Thank you for selecting WORKPERMITCLOUD LIMITED as your preferred business partner! This is a system generated invoice and require no signature.</p>
</td>
	</tr>

</table>
</body>

</html>

</div>

<?php $t++;?>
  @endforeach

	<?php

}?>

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
		  function chngdepartmentshift(empid){



			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedailyattandeaneshightById')}}/'+empid,
        cache: false,
		success: function(response){


			document.getElementById("employee_code").innerHTML = response;
		}
		});
   }
     function chngdepartment(empid){

	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
        cache: false,
		success: function(response){


			document.getElementById("designation").innerHTML = response;
		}
		});
   }
   	 function checkreff(val) {
	if(val!=''){

		$("#start_date").prop('required',true);
		$("#end_date").prop('required',true);
	}else{

				$("#start_date").prop('required',false);
		$("#end_date").prop('required',false);
	}

}
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