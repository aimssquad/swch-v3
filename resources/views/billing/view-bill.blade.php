<!doctype html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
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
	<table style="width: 100%;font-family: calibri;border-bottom: 3px solid #000;max-width: 900px;margin: auto;">
		<thead>
			<tr>
				<th colspan="2"><h1 style="margin-top: 0;margin-bottom: 0;">INVOICE</h1></th>
			</tr>
			
		</thead>
		<tbody>
			<tr>
				<td><h3 style="color: #28acf4;">WORKPERMITCLOUD LIMITED</h3>
                <p>1st Floor, 112-116 Whitechapel Road<br>London, E1 1JE</p>
                <p>Phone: 02080872343<br>Mobile/WhatsApp:07968189454 <br>Email:info@workpermitcloud.co.uk<br>
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
				<th style="text-align: left;"><h3>Bill To</h3>
				@if($bill[0]->billing_type=='Organisation')
					
				
                   <p>{{$Roledata->com_name}}</p>
				   @elseif($bill[0]->billing_type=='Candidate')
				   <p>{{$bill[0]->canidate_name}}</p>
				   @endif
				   <p >{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}} @if($Roledata->road!='') , @endif {{ $Roledata->road}}  @if($Roledata->city!='') , @endif {{$Roledata->city}}  @if($Roledata->zip!='') , @endif {{$Roledata->zip}}  @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
	
				</th>
				<th style="text-align: right;"><h3 style="margin-bottom: 0;">Invoice no: {{$bill[0]->in_id}}</h3>
                 <h3 style="margin: 0;">Issue Date: {{ date('d/m/Y',strtotime($bill[0]->date)) }}</h3>
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
		<th>VAT</th>
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
		
		?>
		<tr>
		<td>{{($i+1)}}</td>
		<td>{{$value->des}}</td>
		<td>1</td>
		<td>£{{$value->anount_ex_vat}}</td>
		 @if($disc!=0)
		<td>£{{$value->discount}}</td>
		@endif
		<td> @if($disc!=0) £ {{$value->discount_amount}} @else £ {{$value->anount_ex_vat}} @endif</td>
			@if($vatc!=0)<td>{{$value->vat}}%</td>@endif
		<td>£{{$value->net_amount}}</td>	
	</tr>
		<?php
		$i++;
	}
	}
	?>
		

<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	@if($disc!=0)
	<td></td>
@endif
	
	<td>Subtotal</td>
	@if($vatc!=0)
<td></td>
@endif	
	<td>£{{$subtot}}</td>
</tr>
 @if($disc!=0)
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
@if($disc!=0)
	<td></td>
@endif
	
	<td>Discount</td>
@if($vatc!=0)
<td></td>
@endif		
	<td>£{{$disc}}</td>
</tr>
@endif
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	@if($disc!=0)
	<td></td>
@endif
	
	<td>Total Excluding VAT</td>
@if($vatc!=0)
<td></td>
@endif		
	<td>£{{$vatexclu}}</td>
</tr>
@if($vatc!=0)
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	@if($disc!=0)
	<td></td>
@endif
	
	<td>VAT (GB VAT 20%)</td>
@if($vatc!=0)
<td></td>
@endif		
	<td>£{{$vatam}}</td>
</tr>
@endif
<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	@if($disc!=0)
	<td></td>
@endif
	
	<td>Total Including VAT</td>	
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
		<td><p style="text-align: center;font-size:14px;">Thank you for selecting WORKPERMITCLOUD LIMITED as your preferred business partner!  This is a system generated invoice and require no signature.</p>
</td>
	</tr>
	<tr>
		<td style="text-align: center;padding-top: 23px;">
<a  style="
    background: #4f81bd;
    color: #fff;
    font-size: 23px;
    padding: 9px 14px;
    border-radius: 7px;
" class ="btn btn-default noprint"  onclick="window.print()"  download data-toggle="tooltip"data-placement="bottom" title="Print"><img   src="{{ asset('assets/img/printer.png')}}" style="    width: 22px;
       padding-right: 3px;
    position: relative;
    top: 3px;

   " > 	Print</a>
		<a style="
    background: #4f81bd;
    color: #fff;
    font-size: 23px;
    padding: 9px 14px;
    border-radius: 7px;text-decoration:none;
" href="{{asset('public/billpdf/'.$bill[0]->dom_pdf)}}" download data-toggle="tooltip" class="noprint" data-placement="bottom" title="Dowlnload"><img   src="{{ asset('assets/img/download2.png')}}" style="    width: 22px;
     padding-right: 3px;
    position: relative;
    top: 3px;" > 	Download</a>
							</td>
	</tr>
</table>
</body>

</html>
