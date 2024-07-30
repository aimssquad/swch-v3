<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    


    <title>SWCH</title>
    <style>
        .main-table tr td,
        .main-table tr th {
            padding: 5px;
            font-family:arial;
            font-family: NeutraText-Book !important;
        }

        .main-table tr:nth-child(even) {
            background-color: #ecebfd;
        }

        td {
            font-size: 13px;
        }

        th {
            color: #000;
        }
        p,h1,h2,h3,h4,h5,h6{
            margin:0;
            padding:0;
            font-family: NeutraText-Book !important;
            margin-bottom:5px;
        }
        th{
            color:#fff;
        }
    </style>
</head>

<body style="position: relative; font-family: arial!important;">
    <div style="width: 98%; margin: 0 auto;">
      <table class="table_col" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 65%;"><img src="https://skilledworkerscloud.co.uk/img/swch_logo.png" /></td>
                <td>
                    <h3>167-169 Great Portland Street</h3>
                    <h4>5th Floor, London, W1W 5PF UK</h4>
                    <p>Call: +44 0208 129 1655</p>
                    <p>Call: 44 074 672 84718</p>
                    <p>Email: Info@skilledworkerscloud.co.uk</p>
                </td>
            </tr>
        </table>

      <div style="background-color: #141c64; height: 20px; margin-bottom:10px"></div>
        <table width="100%" style="font-family:arial;">
            <tbody>
                <tr>
                    <td>
                        <p><b>Bill To:</b></p>
                        @if($billing_type=='Organisation')
                        @if($bill_for=='first invoice recruitment service')
                        @if($bill_to=='Organisation')
                        <p>{{$Roledata->com_name}}</p>
                        @else
                        <p>{{ $rec_candidate_info->employee_name}}</p>
                        @endif
                        @elseif($bill_for=='second invoice visa service')
                        @if($bill_to=='Organisation')
                        <p>{{$Roledata->com_name}}</p>
                        @else
                        <p>{{ $rec_candidate_info->employee_name}}</p>
                        @endif
                        @else
                        <p>{{$Roledata->com_name}}</p>
                        @endif

                        @elseif($billing_type=='Candidate')
                        <p>{{$canidate_name}}</p>
                        @endif
                        @if($billing_type=='Organisation')
                        @if($bill_for=='first invoice recruitment service')
                        @if($bill_to=='Organisation')
                        <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}}
                            @if($Roledata->road!='') , @endif {{ $Roledata->road}} @if($Roledata->city!='') , @endif
                            {{$Roledata->city}} @if($Roledata->zip!='') , @endif {{$Roledata->zip}}
                            @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
                        @else
                        <p>{{ $rec_candidate_info->employee_address}}</p>
                        @endif


                        @elseif($bill_for=='second invoice visa service')
                        @if($bill_to=='Organisation')
                        <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}}
                            @if($Roledata->road!='') , @endif {{ $Roledata->road}} @if($Roledata->city!='') , @endif
                            {{$Roledata->city}} @if($Roledata->zip!='') , @endif {{$Roledata->zip}}
                            @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
                        @else
                        <p>{{ $rec_candidate_info->employee_address}}</p>
                        @endif
                        @else
                        <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}}
                            @if($Roledata->road!='') , @endif {{ $Roledata->road}} @if($Roledata->city!='') , @endif
                            {{$Roledata->city}} @if($Roledata->zip!='') , @endif {{$Roledata->zip}}
                            @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
                        @endif


                        @elseif($billing_type=='Candidate')
                        <?php $newadd = DB::table('invoice_candidates')->where('id', '=', $candidate_id)->first();

?>
                        <p>{{ $newadd->address}}</p>

                        @endif
                    </td>
                    <td style="text-align: right; float: right;">
                        <p style="margin-bottom: 0;"><span style="font-weight: 600;">Pro Forma Invoice. no.:</span>
                            {{$in_id}}</p>
                        <p style="margin-top: 0;"><span style="font-weight: 600;">Bill Date:</span>
                            {{ date('d/m/Y',strtotime($date)) }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php $amount = 0;
$disc = 0;
$vatc = 0;
$subtot = 0;
$vatexclu = 0;
$vatam = 0;
$vatnew = 0;
if ($package && count($package) != 0) {
    for ($i = 0; $i < count($package); $i++) {

        $amount = $amount + $net_amount[$i];

        $invt_discount = $discount[$i];
        $invt_discount_p = 0;
        if ($discount_type[$i] == 'P') {

            $invt_discount = 0;
            $invt_discount_p = $discount[$i];

            $invt_discount = round(((((float) $anount_ex_vat[$i]) * ((float) $invt_discount_p)) / 100), 2);
        }

        $disc = $disc + $invt_discount;

        $vatc = $vatc + $vat[$i];
        $subtot = $subtot + $anount_ex_vat[$i];

        if ($discount[$i] != 0) {
            $vatexclu = $vatexclu + $discount_amount[$i];
        } else {
            $vatexclu = $vatexclu + $anount_ex_vat[$i];
        }
        $vatam = $amount - $vatexclu;

    }
}
$vatvalt = DB::table('tax_bill')

    ->where('id', '=', '1')
    ->first();
$vatnew = $vatvalt->percent;
?>

        <table class="main-table" border="1" width="100%"
            style="font-family:arial;margin: auto;border-collapse: collapse;">
            <thead style="background: #2ea8eb !important;color:#2ea8eb;">
                <tr>
                    <th>Sl. no</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price Excluding VAT</th>
                    @if($disc!=0)
                    <th>Discount</th>
                    @endif
                    <th>Taxable Unit Price</th>
                    <th>Total</th>

                </tr>
            </thead>

            <tbody>

                <?php if ($package && count($package) != 0) {
    for ($i = 0; $i < count($package); $i++) {
        $packders = DB::Table('package')->where('id', '=', $package[$i])->first();
        $inv_discount = $discount[$i];
        $inv_discount_p = 0;
        if ($discount_type[$i] == 'P') {

            $inv_discount = 0;
            $inv_discount_p = $discount[$i];

            $inv_discount = round(((((float) $anount_ex_vat[$i]) * ((float) $inv_discount_p)) / 100), 2);
        }

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
                    <td style="text-align: right;">
                        @if($discount_type[$i] == 'P')
                        £{{$inv_discount}} ({{$inv_discount_p}}%)
                        @else
                        £{{$inv_discount}}
                        @endif

                    </td>
                    @endif
                    <td style="text-align: right;"> @if($inv_discount!=0) £ {{$discount_amount[$i]}} @else £
                        {{$anount_ex_vat[$i]}} @endif</td>
                   
                    <td style="text-align: right;">£{{$net_amount[$i]}}</td>
                </tr>
                <?php
}
}
?>


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
       <br />
        <br />
        <table class="table_col" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:50%;">
                    <h3>Billing Address:</h3>
                    <h3> Bank Name: Barclays Bank PLC</h3>
                    <h3> Skilled Workers Cloud Ltd</h3>
                    <h3> Sort Code: 20 – 41- 50</h3>
                    <h3> Account Number: 730 30 849</h3>

                </td>
                <td>

                </td>
            </tr>
        </table>
        
        <div style="margin-top: 30px; border-top: 2px solid #ccc; padding-top: 20px;">
            <table class="table_col" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:80%;">
                        <h3>Location: 167-169 Great Portland Street, 5th Floor, London, W1W 5PF UK</h3>
                        <h3>Call: +44 0208 129 1655</h3>
                        <h3>Call: +44 074 672 84718</h3>
                        <h3>Email: Info@skilledworkerscloud.co.uk</h3>
                        <h3>Website: www.skilledworkerscloud.co.uk</h3>
                    </td>
                    <td style="text-align: right;">
                        <img src="https://skilledworkerscloud.co.uk/hrms/public/image/WhatsApp%20Image%202024-04-02%20at%204.43.25%20PM.jpeg" />
                    </td>
                </tr>
            </table>
        </div>
        <div style="background-color: #141c64; height: 20px; margin-top:10px;"></div>
    </div>


</body>

</html>