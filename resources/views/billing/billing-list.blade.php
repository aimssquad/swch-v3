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
		
  @include('billing.include.header')
		<!-- Sidebar -->
		
		  @include('billing.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Billing</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
								Home
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item active">
								<a href="{{url('billing/billinglist')}}"> Billing</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Billing <span><a href="{{ url('billing/add-billing') }}">Generate Bill</a></span></h4>
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
													
													<th>Amount</th>
													<th>Date</th>
													<th>Status</th>
													<th>Payment Mode</th>
													

													<!-- <th>View Invoice</th>
												        <th>Email	Send</th> -->
														<th>Email Send Date</th>	
														<th>Action</th>
												</tr>
											</thead>
											
											<tbody>
											 <?php $t = 1; ?>
											  <?php $i = 1; ?>
							@foreach($bill_rs as $company)
								<?php
								if($company->billing_type=='Organisation'){
								$pass=DB::Table('registration')
		        
				 ->where('reg','=',$company->emid) 
				 
		         
								->first(); }
								
								
				$bil_name=DB::Table('billing')
		        
				 ->where('in_id','=',$company->in_id) 
				 
		         
				->get(); 
				$nameb=array();
				 if(count($bil_name)!=0){
					 foreach($bil_name as $biname){
						$nameb[]=$biname->des;

					 }
				 }
			$strbil=implode(',',$nameb);
							?>
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $company->in_id }}</td>
							<td>@if($company->billing_type=='Organisation') {{ $pass->com_name }} @else {{ $company->canidate_name }}  @endif</td>
                                                                           
							<td>{{ $strbil}}</td>
							
                           
                            
                              <td>{{ $company->amount }}</td>
                              <td>{{ date('d/m/Y',strtotime($company->date)) }}</td>
                              
							     
                           
							<td>{{ strtoupper($company->status) }}</td>
								<td>{{ ($company->pay_mode) }}</td>
							
							    
						 <td> @if($company->bill_send!='')
							     {{ date('d/m/Y',strtotime($company->bill_send)) }}
							     @endif</td>
							     <td class="drp">


<div class="dropdown">
  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="{{url('billing/edit-billing/'.base64_encode($company->in_id))}}"><i class="far fa-edit"></i>&nbsp; Edit</a> 
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal<?php echo $t; ?>"><i class="fas fa-eye"></i>&nbsp; View Invoice</a> 
   <a class="dropdown-item" href="{{url('billing/send-bill/'.base64_encode($company->in_id))}}"><i class="fas fa-paper-plane"></i>&nbsp; Send Email</a>
  
  </div>
</div>




                
                  </td> 
                            
						
						</tr>
								
						 <?php $t ++; ?>		
								
								
								
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
	    <?php $t = 1; ?>
	@foreach($bill_rs as $company)
	<?php 
	$bill = DB::table('billing')      
                 
                  ->where('in_id','=',$company->in_id) 
                  ->get();
				  	$data['package_rs']=DB::Table('package')
              ->where('status','=','active') 
				->get();
				  $Roledata = DB::table('registration')      
                 
                  ->where('reg','=',$bill[0]->emid) 
                  ->first();?>
				  
				  @if($bill[0]->date < '2021-09-14')
<!----------------------view-invoice-popup-------------------->
<div class="modal" id="myModal<?=$t?>">
  <div class="modal-dialog" style="max-width: 1100px;">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
       
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="main-dash" style="width: 100%;font-family: calibri;border-bottom: 3px solid #000;max-width: 1000px;margin: auto;">
		<thead>
			<tr>
				<th colspan="2"><h1 style="margin-top: 0;margin-bottom: 0;text-align: center;">INVOICE</h1></th>
			</tr>
			
		</thead>
		<tbody>
			<tr>
				<td><h3 style="color: #28acf4;">WORKPERMITCLOUD LIMITED</h3>
                <p>1st Floor, 112-116 Whitechapel Road<br>London, E1 1JE</p>
                <p>Phone: 02080872343<br>Email:info@workpermitcloud.co.uk<br>
                	<a href="http://workpermitcloud.co.uk/" target="_blank">www.workpermitcloud.co.uk</a></p>
                <p>VAT Registration Number: <b>384 3919 60</b></p>
				</td>

				<td style="text-align: right;"><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/comp-logo.jpg" alt=""></td>
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
	  <?php $newadd=DB::table('candidate')      
                 
                  ->where('id','=',$bill[0]->candidate_id) 
                  ->first();?>
				 
	   <p style="margin-bottom: 0;">{{ $newadd->location}}</p>
	 
	  @endif
	  
	
	
				</th>
				<th style="float: right; margin-top:15px;"><h4 style="margin-bottom: 0;">Invoice no:{{$bill[0]->in_id}}</h4>
                 <h4 style="margin: 0;">Issue Date: {{ date('d/m/Y',strtotime($bill[0]->date)) }}</h4>
				</th>
			</tr>
		</thead>
	</table>
	<?php    $amount=0;
$disc=0;
$vatc=0;
$subtot=0;
$vatexclu=0;
$vatam=0;
$vatnew=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		
		
		$amount=$amount+$value->net_amount;
		$disc=$disc+$value->discount;
		
		$vatc=$vatc+$value->vat;
		$subtot=$subtot+$value->anount_ex_vat;
		if($value->discount!=0){
		$vatexclu=$vatexclu+$value->discount_amount;
		}else{
		$vatexclu=$vatexclu+$value->anount_ex_vat;
		}
		$vatam=$amount-$vatexclu;
	}
	}
	$vatvalt=DB::table('tax_bill')      
                 
                  ->where('id','=','1') 
                  ->first();
	$vatnew=$vatvalt->percent;
	
	?>
<div class="table-responsive">
	<table class="vt" border="1" style="width: 100%;font-family: calibri;border:1px solid #4f81bd;border-collapse: collapse;max-width: 1000px;margin: auto;">
	<thead style="background:#4f81bd;color: #fff;">
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
	$i=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		 $packders=DB::Table('package')
              ->where('id','=',$value->package) 
				->first();
		
		?>
		<tr>
		<td>{{($i+1)}}</td>
		<td><b>{{$value->des}}</b>
		@if(!empty($packders))
		{!! $packders->description !!}
			@endif
		</td>
		<td>1</td>
		<td>£{{$value->anount_ex_vat}}</td>
		 @if($disc!=0)
		<td>£{{$value->discount}}</td>
		@endif
		<td> @if($value->discount!=0) £ {{$value->discount_amount}} @else £ {{$value->anount_ex_vat}} @endif</td>
			@if($vatc!=0)<td>£ <?php if($value->discount!=0){ $newval=$value->discount_amount;}else{  $newval=$value->anount_ex_vat;} 

echo ($value->net_amount-$newval) ;			?></td>@endif
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
</div>
<?php
$number=$amount;
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
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
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
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
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
		<td>Amount in words: GBP <?=trim($result.$points);?> Only</td>
	</tr>
	<tr>
		<td><p>Workpermitcloud Limited<br>Sort Code: 60-83-71<br>Account Number: 56413088</p></td>
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
      	<a class="print-invoice btn btn-primary" onclick="$('#div2<?=$t?>').print();" data-href="https://workpermitcloud.co.uk/hrms/view-billing/MjAyMS8wNy8wMjA=" style="color: #fff;"><i class="fa fa-print" aria-hidden="true"></i> Print Invoice</a>
     <a class="print-invoice btn btn-info" href="{{asset('public/billpdf/'.$bill[0]->dom_pdf)}}" download><i class="fas fa-file-download"></i> Download</a>
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<div id="div2<?=$t?>" style="display:none;">

<!doctype html>
<html lang="en">
<head>
	<title>WorkPermitCloud</title>
	<style type="text/css">
		td, th{vertical-align: top;padding: 3px;}
.vt td, .vt th{border-right: none;border-left: none;}
.vt tr:nth-child(odd) {background-color: #dbe5f1;}.vt thead tr th{background:#4f81bd !important;color: #fff;text-align: left;}
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
	<table class="main-head" style="width: 100%;font-family: calibri;border-bottom: 3px solid #000;max-width: 900px;margin: auto;">
		<thead>
			<tr>
				<th colspan="2"><h1 style="margin-top: 0;margin-bottom: 0;">INVOICE</h1></th>
			</tr>
			
		</thead>
		<tbody>
			<tr>
				<td><h3 style="color: #28acf4;">WORKPERMITCLOUD LIMITED</h3>
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
	  <?php $newadd=DB::table('candidate')      
                 
                  ->where('id','=',$bill[0]->candidate_id) 
                  ->first();?>
	   <p style="margin-bottom: 0;">{{ $newadd->location}}</p>
	 
	  @endif
	
				</th>
				<th style="float: right; margin-top:15px;"><h4 style="margin-bottom: 0;">Invoice no:{{$bill[0]->in_id}}</h4>
                 <h4 style="margin: 0;">Issue Date: {{ date('d/m/Y',strtotime($bill[0]->date)) }}</h4>
				</th>
			</tr>
		</thead>
	</table>
<?php    $amount=0;
$disc=0;
$vatc=0;
$subtot=0;
$vatexclu=0;
$vatam=0;
$vatnew=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		
		$amount=$amount+$value->net_amount;
		$disc=$disc+$value->discount;
		$vatc=$vatc+$value->vat;
		$subtot=$subtot+$value->anount_ex_vat;
		if($value->discount!=0){
		$vatexclu=$vatexclu+$value->discount_amount;
		}else{
		$vatexclu=$vatexclu+$value->anount_ex_vat;
		}
		$vatam=$amount-$vatexclu;
	}
	}
	$vatvalt=DB::table('tax_bill')      
                 
                  ->where('id','=','1') 
                  ->first();
	$vatnew=$vatvalt->percent;
	?>

<table class="vt" border="1" style="width: 100%;font-family: calibri;border:1px solid #4f81bd;border-collapse: collapse;max-width: 900px;margin: auto;">
	<thead style="background:#4f81bd;color: #fff;">
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
	$i=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		 $packders=DB::Table('package')
              ->where('id','=',$value->package) 
				->first();
		
		?>
		<tr>
		<td>{{($i+1)}}</td>
		<td><b>{{$value->des}}</b>
		@if(!empty($packders))
		{!! $packders->description !!}
			@endif
		</td>
		<td>1</td>
		<td>£{{$value->anount_ex_vat}}</td>
		 @if($disc!=0)
		<td>£{{$value->discount}}</td>
		@endif
		<td> @if($value->discount!=0) £ {{$value->discount_amount}} @else £ {{$value->anount_ex_vat}} @endif</td>
			@if($vatc!=0)<td>£ <?php if($value->discount!=0){ $newval=$value->discount_amount;}else{  $newval=$value->anount_ex_vat;} 

echo ($value->net_amount-$newval) ;			?></td>@endif
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
$number=$amount;
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
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
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
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';

   ?>
<table style="width: 100%;font-family: calibri;max-width: 900px;margin: auto;">
	<tr>
		<td>Amount in words: GBP <?=trim($result.$points);?> Only</td>
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

@else
	


<div class="modal" id="myModal<?=$t?>">
  <div class="modal-dialog" style="max-width: 1100px;">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
       
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
	  <div class="new-invc">
	  <table style="font-family:calibri;background: #93abc1;color: #fff;padding: 0 29px;margin:auto;max-width:1000px;width:100%;">
   <thead>
       <tr>
           <th style="text-align: left;"><h3 style="font-size: 25px;">WorkPermitCloud Limited</h3></th>
           <th style="text-align: right;"><h3 style="font-size: 25px;padding-right: 38px;">INVOICE</h3></th>
       </tr>
       <tr>
           <th style="text-align: left;">2nd Floor, 112-116, Whitechapel Road, London, E1 1JE
            <br>+44-020-8087-2343<br>
            info@workpermitcloud.co.uk<br>
            www.workpermitcloudlimited.co.uk<br>
            VAT Registration# 3843391960</th>

           <th style="text-align: right;"><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/logo.png"></th>
       </tr>
   </thead>
</table>

	<table style="width: 100%;font-family: calibri;max-width: 1000px;margin: auto;">
		<thead>
			<tr>
				<th style="text-align: left;width:300px;"><h3><b>Bill To</b></h3>
									
				
               @if($bill[0]->billing_type=='Organisation')
					
				
                   <p style="margin-bottom: 0;">{{$Roledata->com_name}}</p>
				   @elseif($bill[0]->billing_type=='Candidate')
				   <p style="margin-bottom: 0;">{{$bill[0]->canidate_name}}</p>
				   @endif
				  	@if($bill[0]->billing_type=='Organisation')
				   <p style="margin-bottom: 0;">{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}} @if($Roledata->road!='') , @endif {{ $Roledata->road}}  @if($Roledata->city!='') , @endif {{$Roledata->city}}  @if($Roledata->zip!='') , @endif {{$Roledata->zip}}  @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
	 
	  @elseif($bill[0]->billing_type=='Candidate')
	  <?php $newadd=DB::table('candidate')      
                 
                  ->where('id','=',$bill[0]->candidate_id) 
                  ->first();?>
	   <p style="margin-bottom: 0;">{{ $newadd->location}}</p>
	 
	  @endif
	
	
				</th>
				<th style="float: right; margin-top:15px;"><h4 style="margin-bottom: 0;"><b>Invoice no: </b>{{$bill[0]->in_id}}</h4>
                 <h4 style="margin: 0;"><b>Issue Date: </b> {{ date('d/m/Y',strtotime($bill[0]->date)) }}</h4>
				</th>
			</tr>
		</thead>
	</table>
	<?php    $amount=0;
$disc=0;
$vatc=0;
$subtot=0;
$vatexclu=0;
$vatam=0;
$vatnew=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		
		
		$amount=$amount+$value->net_amount;
		$disc=$disc+$value->discount;
		
		$vatc=$vatc+$value->vat;
		$subtot=$subtot+$value->anount_ex_vat;
		if($value->discount!=0){
		$vatexclu=$vatexclu+$value->discount_amount;
		}else{
		$vatexclu=$vatexclu+$value->anount_ex_vat;
		}
		$vatam=$amount-$vatexclu;
	}
	}
	$vatvalt=DB::table('tax_bill')      
                 
                  ->where('id','=','1') 
                  ->first();
	$vatnew=$vatvalt->percent;
	
	?>
<div class="table-responsive">
	<table class="vt" border="1" style="border:2px solid #000;width: 100%;border:1px solid #000;font-family: calibri;border:1px solid #4f81bd;border-collapse: collapse;max-width: 1000px;margin: auto;">
	<thead style="background:#4f81bd;color: #fff;">
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
	$i=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		 $packders=DB::Table('package')
              ->where('id','=',$value->package) 
				->first();
		
		?>
		<tr>
		<td>{{($i+1)}}</td>
		<td><b>{{$value->des}}</b>
		@if(!empty($packders))
		{!! $packders->description !!}
			@endif
		</td>
		<td style="text-align: center;">1</td>
		<td style="text-align: right;">£{{$value->anount_ex_vat}}</td>
		 @if($disc!=0)
		<td style="text-align: right;">£{{$value->discount}}</td>
		@endif
		<td style="text-align: right;"> @if($value->discount!=0) £ {{$value->discount_amount}} @else £ {{$value->anount_ex_vat}} @endif</td>
			@if($vatc!=0)<td style="text-align: right;">£ <?php if($value->discount!=0){ $newval=$value->discount_amount;}else{  $newval=$value->anount_ex_vat;} 

echo ($value->net_amount-$newval) ;			?></td>@endif
		<td style="text-align: right;">£{{$value->net_amount}}</td>	
	</tr>
		<?php
		$i++;
	}
	}
	?>

  
		
<tr>	<td></td>
	<td>Subtotal</td>
	<td style="text-align: center;">{{count($bill )}}</td>
	<td style="text-align: right;">£ {{$subtot}}</td>

	@if($disc!=0)
	<td style="text-align: right;">£ {{$disc}}</td>
@endif
	<td style="text-align: right;">£ {{$vatexclu}}</td>
	

	@if($vatc!=0)
<td style="text-align: right;">£ {{($amount-$vatexclu)}}</td>
@endif	
	<td style="text-align: right;">£{{$amount}}</td>
</tr>




   <tr style="background-color: transparent;border: none;">
    <td  @if($vatc!=0) colspan="5" @else colspan="4"  @endif  style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;"></td>
    <td style="border-bottom: 1px solid #000;">Total Excluding VAT</td>
	@if($disc!=0)
	 <td style="border-bottom: 1px solid #000;"></td>
@endif
	
    <td style="text-align: right;border-bottom: 1px solid #000;border-right: 1px solid #000;">&pound; {{$vatexclu}}</td>
  </tr>
  @if($vatc!=0)
  <tr style="background-color: transparent;border: none;">
    <td @if($vatc!=0) colspan="5" @else colspan="4"  @endif  style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;"></td>
    <td style="background: #dbe5f1;border-bottom: 1px solid #000;">VAT (GB VAT {{$vatnew}}%)</td>
	 
	 	@if($disc!=0)
	 <td style="background: #dbe5f1;border-bottom: 1px solid #000;"></td>
@endif
    <td style="text-align: right;background: #dbe5f1;border-bottom: 1px solid #000;border-right: 1px solid #000;">&pound; {{($amount-$vatexclu)}}</td>
  </tr>
  @endif
  <tr style="background-color: transparent;border: none;">
    <td @if($vatc!=0) colspan="5" @else colspan="4"  @endif  style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;"></td>
    <td style="" style="border-bottom:none;">Total Including VAT</td>

  	@if($disc!=0)
	 <td style="border-bottom:none;"></td>
@endif
    <td style="text-align: right;border-right: 1px solid #000;border-bottom:none;">&pound; {{$amount}}</td>
  </tr>
				
	</tbody>
</table>
</div>
<?php
$number=$amount;
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
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
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
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
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
		<td><b>Amount in words: GBP <?=trim($result.$points);?> Only</b></td>
	</tr>
	<!-- <tr>
		<td><p>Workpermitcloud Limited<br>Sort Code: 60-83-71<br>Account Number: 56413088</p></td>
	</tr>
	<tr>
		<td><p style="text-align: center;font-size:14px;">Thank you for selecting WORKPERMITCLOUD LIMITED as your preferred business partner!  This is a system generated invoice and require no signature.</p>
</td>
	</tr> -->
	
</tbody></table>

<table class="main-table" border="1" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;max-width:1000px;width:100%;">
<thead>
  <tr style="background-color: #daeef3;">
    <th style="background-color: #fff;">Please make payment to below account details within next 7 days</th>
  </tr>
 
  <tr style="background-color: #daeef3;">
    <th>WORKPERMITCLOUD LIMITED</th>
  </tr>
  <tr >
    <th>Sort Code: 60-83-71</th>
  </tr>
  <tr>
    <th>
      Account Number: 564-130-88
    </th>
  </tr>
</thead>
</table>

<table style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;max-width:1000px;width:100%;">
  <tbody><tr>
    <td>Thank you for selecting WorkPermitCloud Limited as your preferred business partner!  </td>

  </tr>
  <tr>
    <td>This is a system generated invoice and require no signature.</td>
    
  </tr>
</tbody></table>


<table style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;max-width:1000px;width:100%;">
  <tfoot style="position: fixed;bottom: 0;">
    <tr>
      <td><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/ftr-logo.png"></td>
      <td><p style="margin-bottom: 0;">WorkPermitCloud Limited is Regulated to provide immigration services by the</p>      
        <p style="margin-top: 0;">Immigration Ser-vices Commissioner. Registration No. F202100311.</p></td>
    </tr>
  </tfoot>
</table>
</div>
      </div>
</div>

      <!-- Modal footer -->
      <div class="modal-footer">
      	<a class="print-invoice btn btn-primary" onclick="$('#div2<?=$t?>').print();" data-href="https://workpermitcloud.co.uk/hrms/view-billing/MjAyMS8wNy8wMjA=" style="color: #fff;"><i class="fa fa-print" aria-hidden="true"></i> Print Invoice</a>
     <a class="print-invoice btn btn-info" href="{{asset('public/billpdf/'.$bill[0]->dom_pdf)}}" download><i class="fas fa-file-download"></i> Download</a>
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>








 <div id="div2<?=$t?>" style="display:none;">
				<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   
    <title>WorkPermitCloud</title>
    <style>
      .main-table tr td, .main-table tr th{padding: 5px;}
      .main-table tr:nth-child(even) {background-color: #dbe5f1;}
    </style>
  </head>
  <body style="position: relative;">
   <div class="new-invc">
  <table width="900" style="font-family:calibri;background: #93abc1;color: #fff;padding: 0 29px;margin:auto;">
   <thead>
       <tr>
           <th style="text-align: left;"><h3 style="font-size: 25px;">WorkPermitCloud Limited</h3></th>
           <th style="text-align: right;"><h3 style="font-size: 25px;padding-right: 38px;">INVOICE</h3></th>
       </tr>
       <tr>
           <th style="text-align: left;">2nd Floor, 112-116, Whitechapel Road, London, E1 1JE
            <br>+44-020-8087-2343<br>
            info@workpermitcloud.co.uk<br>
            www.workpermitcloudlimited.co.uk<br>
            VAT Registration# 3843391960</th>

           <th style="text-align: right;"><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/logo.png"></th>
       </tr>
   </thead>
</table>


<table width="900" style="font-family:calibri;margin: auto;">
  <tbody>
    <tr>
      <td><p>Bill To:</p>
      @if($bill[0]->billing_type=='Organisation')
					
				
                   <p >{{$Roledata->com_name}}</p>
				   @elseif($bill[0]->billing_type=='Candidate')
				   <p>{{$bill[0]->canidate_name}}</p>
				   @endif
				   @if($bill[0]->billing_type=='Organisation')
				   <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}} @if($Roledata->road!='') , @endif {{ $Roledata->road}}  @if($Roledata->city!='') , @endif {{$Roledata->city}}  @if($Roledata->zip!='') , @endif {{$Roledata->zip}}  @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
	 
	 @elseif($bill[0]->billing_type=='Candidate')
	  <?php $newadd=DB::table('candidate')      
                 
                  ->where('id','=',$bill[0]->candidate_id) 
                  ->first();
				
				  
				  ?>
	   <p>{{ $newadd->location}}</p>
	 
	  @endif
      </td>
<td style="text-align: justify; float: right;">
  <p style="margin-bottom: 0;"><span style="font-weight: 600;">Invoice no:</span> {{$bill[0]->in_id}}</p>
  <p style="margin-top: 0;"><span style="font-weight: 600;">Issue Date:</span> {{ date('d/m/Y',strtotime($bill[0]->date)) }}</p>
</td>
    </tr>
  </tbody>
</table>
<?php    $amount=0;
$disc=0;
$vatc=0;
$subtot=0;
$vatexclu=0;
$vatam=0;
$vatnew=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		
		$amount=$amount+$value->net_amount;
		$disc=$disc+$value->discount;
		$vatc=$vatc+$value->vat;
		$subtot=$subtot+$value->anount_ex_vat;
		if($value->discount!=0){
		$vatexclu=$vatexclu+$value->discount_amount;
		}else{
		$vatexclu=$vatexclu+$value->anount_ex_vat;
		}
		$vatam=$amount-$vatexclu;
	}
	}
	$vatvalt=DB::table('tax_bill')      
                 
                  ->where('id','=','1') 
                  ->first();
	$vatnew=$vatvalt->percent;
	?>
<table class="main-table" border="1" width="900" style="border:2px solid #000;font-family:calibri; border:1px solid #000;margin: auto;border-collapse: collapse;">
  <thead style="background: #4f81bd !important;color: #fff;">
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
	$i=0;
	if($bill && count($bill)!=0){
	foreach($bill as $value)
    {
		
		 $packders=DB::Table('package')
              ->where('id','=',$value->package) 
				->first();
		
		?>
		<tr>
		<td>{{($i+1)}}</td>
		<td><b>{{$value->des}}</b>
		@if(!empty($packders))
		{!! $packders->description !!}
			@endif
		</td>
		<td style="text-align: center;">1</td>
		<td style="text-align: right;">£{{$value->anount_ex_vat}}</td>
		 @if($disc!=0)
		<td style="text-align: right;">£{{$value->discount}}</td>
		@endif
		<td style="text-align: right;"> @if($value->discount!=0) £ {{$value->discount_amount}} @else £ {{$value->anount_ex_vat}} @endif</td>
			@if($vatc!=0)<td style="text-align: right;">£ <?php if($value->discount!=0){ $newval=$value->discount_amount;}else{  $newval=$value->anount_ex_vat;} 

echo ($value->net_amount-$newval) ;			?></td>@endif
		<td style="text-align: right;">£{{$value->net_amount}}</td>	
	</tr>
		<?php
		$i++;
	}
	}
	?>

  

 		
<tr>	<td></td>
	<td>Subtotal</td>
	<td style="text-align: center;"> {{count($bill )}}</td>
<td style="text-align: right;">£ {{$subtot}}</td>

	@if($disc!=0)
	<td style="text-align: right;">£ {{$disc}}</td>
@endif
	<td style="text-align: right;">£ {{$vatexclu}}</td>
	

	@if($vatc!=0)
<td style="text-align: right;">£ {{($amount-$vatexclu)}}</td>
@endif	
	<td style="text-align: right;">£{{$amount}}</td>
</tr>

  
  <tr style="background-color: transparent;border: none;">
    <td @if($vatc!=0) colspan="5" @else colspan="4"  @endif  style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;"></td>
    <td style="border-bottom: 1px solid #000;"  @if($disc!=0) colspan="2" @else colspan="1" @endif  >Total Excluding VAT</td>
	
    <td style="text-align: right;border-bottom: 1px solid #000;border-right: 1px solid #000;">&pound; {{$vatexclu}}</td>
  </tr>
  @if($vatc!=0)
  <tr style="background-color: transparent;border: none;">
    <td @if($vatc!=0) colspan="5" @else colspan="4"  @endif  style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;"></td>
    <td style="background: #dbe5f1;border-bottom: 1px solid #000;" @if($disc!=0) colspan="2" @else colspan="1" @endif >VAT (GB VAT {{$vatnew}}%)</td>
	
    <td style="text-align: right;background: #dbe5f1;border-bottom: 1px solid #000;border-right: 1px solid #000;">&pound; {{($amount-$vatexclu)}}</td>
  </tr>
  @endif
  <tr style="background-color: transparent;border: none;">
    <td @if($vatc!=0) colspan="5" @else colspan="4"  @endif  style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;"></td>
    <td style="" @if($disc!=0) colspan="2" @else colspan="1" @endif >Total Including VAT</td>

    <td style="text-align: right;border-right: 1px solid #000;">&pound; {{$amount}}</td>
  </tr>
				

</tbody>
</table>
<?php
$number=$amount;
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
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
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
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';

   ?>
<table width="900" style="font-family: calibri;margin: 25px auto;">
<tr>
  <td style="text-align: left;"><b>Amount in words: GBP. <?=trim($result.$points);?> Only.</b></td>
</tr>
</table>

<table class="main-table" width="900" border="1" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
<thead>

  <tr style="background-color: #daeef3;">
    <th style="background-color: #fff;">Please make payment to below account details within next 7 days</th>
  </tr>
 
  <tr style="background-color: #daeef3;">
    <th>WORKPERMITCLOUD LIMITED</th>
  </tr>
  <tr >
    <th>Sort Code: 60-83-71</th>
  </tr>
  <tr>
    <th>
      Account Number: 564-130-88
    </th>
  </tr>
</thead>
</table>

<table width="900" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
  <tr>
    <td>Thank you for selecting WorkPermitCloud Limited as your preferred business partner!  </td>

  </tr>
  <tr>
    <td>This is a system generated invoice and require no signature.</td>
    
  </tr>
</table>

<table width="900" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
  <tfoot style="position: fixed;bottom: 0;">
    <tr>
      <td><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/ftr-logo.png"></td>
      <td><p style="margin-bottom: 0;">WorkPermitCloud Limited is Regulated to provide immigration services by the</p>      
        <p style="margin-top: 0;">Immigration Ser-vices Commissioner. Registration No. F202100311.</p></td>
    </tr>
  </tfoot>
</table>
   </div>

   
  </body>
</html>

</div>
@endif 


<?php $t++;?>
  @endforeach
  
  
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