<?php
$number=$re_amount;
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
          ?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
    <title>WorkpermitCloud</title>
    <style type="text/css">
    body{background:#fff;}
      th, td{padding: 5px 10px;vertical-align: top;}
    </style>
  </head>
  <body>
    
<!--browse job---->
<div class="invoice" style="border:1px solid #000;max-width: 950px;width: 100%;margin:30px auto;padding: 30px 30px;">
	<table style="width: 100%;">
		<thead>
			<tr>
			<th style="vertical-align: middle;">
				<h4 style="font-weight: 600;color: #0070c0;text-align:left;">PAYMENT RECEIPT</h4></th>
            <th style="text-align: right;"><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/comp-logo.jpg" alt=""></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2"><h5 style="color: #2170c0;font-weight: 500;">WORKPERMITCLOUD LIMITED
				<span style="float: right;"><img src="https://workpermitcloud.co.uk/hrms/public/img/paidm.png" alt="" width="100"></span></h5>
			<p>1st Floor, 112-116 Whitechapel Road<br>London, E1 1JE<br>
			Phone: 02080872343<br>Email: invoice@workpermitcloud.co.uk<br>www.workpermitcloud.co.uk</p>
			</td>
</tr>
			<tr><td colspan="2" style="padding-top: 20px;"><h5>Customer</h5></td></tr>

			<tr>
				<td>{{ucfirst($Roledata->f_name)}} {{ucfirst($Roledata->l_name)}}</td>
                <td style="float: right;">Invoice No:{{$billing->in_id}} </td>	
			</tr>
			<tr>
					<td>{{$Roledata->com_name}}</td>
				<td style="float: right;">Issue Date:{{date('d/m/Y',strtotime($billing->date))}} </td>

			</tr>
			<tr>
					<td>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}} @if($Roledata->road!='') , @endif {{ $Roledata->road}}  @if($Roledata->city!='') , @endif {{$Roledata->city}}  @if($Roledata->zip!='') , @endif {{$Roledata->zip}}  @if($Roledata->country!='') , @endif {{$Roledata->country}}</td>
				<td style="float: right;">Payment Receipt No:{{$pay_recipt}} </td>
				</tr>
			<tr>
			<td>Payment Method: {{$method}}</td>
			<td style="float: right;">Payment  Received Date:{{$date}} </td>
				
			</tr>
		</tbody>
	</table>


	<table border="1" style="width: 100%;border-collapse: collapse;">
		
		<thead>
			<tr>
				<th style="background:#8CB2E3;width: 50%;border-right:none;">Description</th>
				<th style="background:#8CB2E3;border-left: none;border-right:none;width: 20%;"></th>
				<th style="background:#8CB2E3;width: 30%;border-left: none;">Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="height: 200px;border-right:none;border-bottom: none;border-left: none;">{{$des}} </td>
				<td style="border-left: none;"></td>
				<td style="height: 200px;text-align:right;">&pound; {{number_format($billing->amount,2)}}</td>
			</tr>
			<tr>
				<td style="border:none;border-top:none;border-bottom: none"></td>
				<td style="background:#8CB2E3;">Amount paid</td>
				<td style="text-align:right;">&pound; {{number_format($re_amount,2)}}</td>
			</tr>
			
		</tbody>
	</table>
	<table style="width: 100%;    margin-top: 30px;">
		<tr>
				 @if($re_amount!=0)
				<td style="border:none;border-bottom: none" colspan="3">Amount in words: GBP <?=trim($result.$points);?> Only.</td>
				@endif
				 @if($re_amount==0)
				<td style="border:none;border-bottom: none" colspan="3">Amount in words:  GBP Zero Only.</td>
				@endif .
			</tr>
	</table>
<table style="width: 100%;    margin-top: 50px;">
	<tr>
	<td style="text-align: center;">Thank you for selecting WORKPERMITCLOUD Limited as your hrms service provider!<br> This is a system generated payment receipt and require no signature.</td>
</tr>
</table>
</div>
<!--end-->



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>