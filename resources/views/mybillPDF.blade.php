<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   
    <title>SWCH</title>
    <style>
      .main-table tr td, .main-table tr th{padding: 5px;}
      .main-table tr:nth-child(even) {background-color: #dbe5f1;}
	   td {font-size:13px;}
    </style>
  </head>
  <body style="position: relative;">
   <div class="new-invc">
  <table width="100%" style="font-family:calibri;background: #93abc1;color: #fff;padding: 0 15px;">
   <thead>
       <tr>
           <th style="text-align: left;"><h3 style="font-size: 25px;">CLIMBR</h3></th>
           <th style="text-align: right;"><h3 style="font-size: 25px;padding-right: 38px;">INVOICE</h3></th>
       </tr>
       <tr>
           <th style="text-align: left;">VIP Road, Kaikhali, Kolkata - 700052
            <br>+91 8336933522<br>
            info@climbr.in<br>
            www.climbr.in<br>
            VAT Registration# 3843391960</th>

           <th style="text-align: right;"><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/logo.png"></th>
       </tr>
   </thead>
</table>


<table width="100%" style="font-family:calibri;">
  <tbody>
    <tr>
      <td><p><b>Bill To:</b></p>
      @if($billing_type=='Organisation')
					
				
                   <p >{{$Roledata->com_name}}</p>
				   @elseif($billing_type=='Candidate')
				   <p>{{$canidate_name}}</p>
				   @endif
				   @if($billing_type=='Organisation')
				   <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}} @if($Roledata->road!='') , @endif {{ $Roledata->road}}  @if($Roledata->city!='') , @endif {{$Roledata->city}}  @if($Roledata->zip!='') , @endif {{$Roledata->zip}}  @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
	 
	 @elseif($billing_type=='Candidate')
	  <?php $newadd=DB::table('candidate')      
                 
                  ->where('id','=',$candidate_id) 
                  ->first();
				
				  
				  ?>
	   <p>{{ $newadd->location}}</p>
	 
	  @endif
      </td>
<td style="text-align: right; float: right;">
  <p style="margin-bottom: 0;"><span style="font-weight: 600;">Invoice no:</span> {{$in_id}}</p>
  <p style="margin-top: 0;"><span style="font-weight: 600;">Issue Date:</span> {{ date('d/m/Y',strtotime($date)) }}</p>
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
	if($package && count($package )!=0){
	for($i=0;$i<count($package );$i++)
    {
		
		$amount=$amount+$net_amount[$i];
		$disc=$disc+$discount[$i];
		$vatc=$vatc+$vat[$i];
		$subtot=$subtot+$anount_ex_vat[$i];
		if($discount[$i]!=0){
		$vatexclu=$vatexclu+$discount_amount[$i];
		}else{
		$vatexclu=$vatexclu+$anount_ex_vat[$i];
		}
		$vatam=$amount-$vatexclu;
		
	}
	}
	$vatvalt=DB::table('tax_bill')      
                 
                  ->where('id','=','1') 
                  ->first();
	$vatnew=$vatvalt->percent;
	?>

<table class="main-table" border="1" width="100%" style="border:2px solid #000;font-family:calibri;margin: auto;border-collapse: collapse;">
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

<?php if($package && count($package )!=0){
	for($i=0;$i<count($package );$i++)
    {
		$packders=DB::Table('package')
              ->where('id','=',$package[$i]) 
				->first();
		?>
		<tr>
		<td>{{($i+1)}}</td>
		<td><b>{{$des[$i]}}</b>
		@if(!empty($packders))
		{!! $packders->description !!}
			@endif
		</td>
		<td style="text-align: center;">1</td>
		<td style="text-align: right;">£{{$anount_ex_vat[$i]}}</td>
		 @if($disc!=0)
		<td style="text-align: right;">£{{$discount[$i]}}</td>
		@endif
		<td style="text-align: right;"> @if($discount[$i]!=0) £ {{$discount_amount[$i]}} @else £ {{$anount_ex_vat[$i]}} @endif</td>
			@if($vatc!=0)<td style="text-align: right;">£ <?php if($discount[$i]!=0){ $newval=$discount_amount[$i];}else{  $newval=$anount_ex_vat[$i];} 

echo ($net_amount[$i]-$newval) ;			?></td>@endif
		<td style="text-align: right;">£{{$net_amount[$i]}}</td>	
	</tr>
		<?php
	}
	}
	?>
		
 		
<tr>	<td></td>
	<td>Subtotal</td>
	<td style="text-align: center;">{{count($package )}}</td>
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
    <td style="border-bottom: 1px solid #000;" @if($disc!=0) colspan="2" @else colspan="1" @endif >Total Excluding VAT</td>
	
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
<table width="100%" style="font-family: calibri;margin: 25px auto;">
<tr>
  <td style="text-align: left;"><b>Amount in words: GBP. <?=trim($result.$points);?> Only. </b></td>
</tr>
</table>

<table class="main-table" width="100%" border="1" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
<thead>
  <tr style="background-color: #daeef3;">
    <th style="background-color: #fff;">Please make payment to below account details within next 7 days</th>
  </tr>
 
  <tr style="background-color: #daeef3;">
    <th>CLIMBR</th>
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

<table width="100%" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
  <tr>
    <td>Thank you for selecting WorkPermitCloud Limited as your preferred business partner!  </td>

  </tr>
  <tr>
    <td>This is a system generated invoice and require no signature.</td>
    
  </tr>
</table>

<table width="100%" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
  <tfoot style="position: fixed;bottom: 0;">
    <tr>
      <td><img src="https://climbr.co.in/public/assets/img/ftr-logo.png"></td>
      <td><p style="margin-bottom: 0;">Climbr is Regulated to provide immigration services by the</p>      
        <p style="margin-top: 0;">Immigration Ser-vices Commissioner. Registration No. F202100311.</p></td>
    </tr>
  </tfoot>
</table>
   </div>

   
  </body>
</html>