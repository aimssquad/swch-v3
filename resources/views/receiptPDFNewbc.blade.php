<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <style>
    .main-table tr td,
    .main-table tr th {
        padding: 5px;
    }

    .main-table tr:nth-child(even) {
        background-color: #dbe5f1;
    }

    td {
        font-size: 13px;
    }
    </style>
</head>

<body style="position: relative;">

    <div class="new-invc">
        <table width="100%" style="font-family:calibri;background: #93abc1;color: #fff;padding: 0 15px;">
            <thead>
                <tr>
                    <th style="text-align: left;">
                        <h3 style="font-size: 25px;">WorkPermitCloud Limited </h3>
                    </th>
                    <th style="text-align: right;">
                        <h3 style="font-size: 20px;padding-right: 38px;">Tax Invoice</h3>
                    </th>
                </tr>
                <tr>
                    <th style="text-align: left;">2nd Floor, 112-116, Whitechapel Road, London, E1 1JE
                        <br>+44-020-8087-2343<br>
                        info@workpermitcloud.co.uk<br>
                        www.workpermitcloudlimited.co.uk<br>
                        VAT Registration# 3843391960
                    </th>

                    <th style="text-align: right;"><img
                            src="https://workpermitcloud.co.uk/hrms/public/assets/img/logo.png"></th>
                    <!-- <th style="text-align: right;"><img
                            src="http://localhost/hrms/public/assets/img/logo.png"></th> -->
                </tr>
            </thead>
        </table>
        <table width="100%" style="font-family:calibri;">
            <tbody>
                <tr>
                    <td>
                        <p><b>Bill To:</b></p>
                        @if($billing->billing_type=='Organisation')
                            @if($billing->bill_for=='first invoice recruitment service')
                                @if($billing->bill_to=='Organisation')
                                <p>{{$Roledata->com_name}}</p>
                                @else
                                <p>{{ $billing->canidate_name}}</p>
                                @endif
                            @elseif($billing->bill_for=='second invoice visa service')
                                @if($billing->bill_to=='Organisation')
                                <p>{{$Roledata->com_name}}</p>
                                @else
                                <p>{{ $billing->canidate_name}}</p>
                                @endif
                            @else
                            <p>{{$Roledata->com_name}}</p>
                            @endif

                       
                        @elseif($billing->billing_type=='Candidate')
                        <p>{{$billing->canidate_name}}</p>
                        @endif
                        @if($billing->billing_type=='Organisation')
                            @if($billing->bill_for=='first invoice recruitment service')
                                @if($billing->bill_to=='Organisation')
                                <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}}
                            @if($Roledata->road!='') , @endif {{ $Roledata->road}} @if($Roledata->city!='') , @endif
                            {{$Roledata->city}} @if($Roledata->zip!='') , @endif {{$Roledata->zip}}
                            @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
                                @else
                                <p>{{ $billing->candidate_address}}</p>
                                @endif


                            @elseif($billing->bill_for=='second invoice visa service')
                                @if($billing->bill_to=='Organisation')
                                <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}}
                                @if($Roledata->road!='') , @endif {{ $Roledata->road}} @if($Roledata->city!='') , @endif
                                {{$Roledata->city}} @if($Roledata->zip!='') , @endif {{$Roledata->zip}}
                                @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
                                @else
                                <p>{{ $billing->candidate_address}}</p>
                                @endif
                            @else
                            <p>{{ $Roledata->address}} @if($Roledata->address2!='') , @endif {{$Roledata->address2}}
                            @if($Roledata->road!='') , @endif {{ $Roledata->road}} @if($Roledata->city!='') , @endif
                            {{$Roledata->city}} @if($Roledata->zip!='') , @endif {{$Roledata->zip}}
                            @if($Roledata->country!='') , @endif {{$Roledata->country}}</p>
                            @endif
                        

                        @elseif($billing->billing_type=='Candidate')

                        <p>{{ $billing->candidate_address}}</p>

                        @endif
                    </td>
                    <td style="text-align: right; float: right;">
                        <!-- <p style="margin-bottom: 0;"><span style="font-weight: 600;">Per forma Invoice. no.:</span> {{$inv_invoiceno}}</p>
                        <p style="margin-top: 0;"><span style="font-weight: 600;">Issue Date:</span>
                            {{ $inv_issue_date }}</p>
                        <p style="margin-bottom: 0;"><span style="font-weight: 600;">Invoice. no.:</span> {{$pay_receipt}}</p> -->
                        <p style="margin-top: 0;"><span style="font-weight: 600;">Invoice. no.:</span>
                            {{$pay_recipt}}</p>
                        <!-- <p style="margin-top: 0;"><span style="font-weight: 600;">Payment Method:</span>
                            {{$method}}</p> -->
                        <p style="margin-top: 0;"><span style="font-weight: 600;">Bill Date:</span>
                            {{$date}}</p>
                        <p style="margin-top: 0;"><span style="font-weight: 600;">Payment Type:</span>
                            {{$payment_type}}</p>

                    </td>
                </tr>
            </tbody>
        </table>


        <table class="main-table" width="100%"
            style="border:1px solid #000;font-family:calibri;margin: auto;border-collapse: collapse;">
            <thead style="background: #4f81bd !important;color: #fff;font-size:11px;">
                <tr>
                    <th style="border-right: 1px solid #000;border-bottom: 1px solid #000;">Sl. no</th>
                    <th style="border-right: 1px solid #000;border-bottom: 1px solid #000;">Description</th>
                    <th style="border-right: 1px solid #000;border-bottom: 1px solid #000;">Quantity</th>
                    <th style="border-right: 1px solid #000;border-bottom: 1px solid #000;">Unit Price Excluding VAT
                    </th>

                    @if($show_discount!=0)
                    <th style="border-right: 1px solid #000;border-bottom: 1px solid #000;">Discount</th>
                    @endif

                    <th style="border-right: 1px solid #000;border-bottom: 1px solid #000;">Taxable Unit Price</th>
                    @if($billing->vat!=0)
                    <th style="border-right: 1px solid #000;border-bottom: 1px solid #000;">VAT @ {{$billing->vat}} %
                    </th>
                    @endif
                    <th style="border-bottom: 1px solid #000;">Total</th>

                </tr>
            </thead>

            <tbody>

                <tr>
                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">1</td>
                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><b>{{$des}}</b>
                        {!! $package_details !!}
                    </td>
                    <td style="border-right: 1px solid #000;text-align: center;border-bottom: 1px solid #000;">1</td>
                    <td style="border-right: 1px solid #000;text-align: right;border-bottom: 1px solid #000;">
                        £{{$taxable_amount}}</td>

                    @if($show_discount!=0)
                    <td style="border-right: 1px solid #000;text-align: right;border-bottom: 1px solid #000;">
                        £{{$billing->discount}}</td>
                    @endif

                    <td style="border-right: 1px solid #000;text-align: right;border-bottom: 1px solid #000;">
                        £{{$taxable_amount}}
                    </td>
                    @if($billing->vat!=0)
                    <td style="border-right: 1px solid #000;text-align: right;border-bottom: 1px solid #000;">£
                        {{$vaton_re_amount}}</td>
                    @endif
                    <td style="text-align: right;border-bottom: 1px solid #000;">£{{$re_amount}}</td>
                </tr>


                <tr>
                    <td style="text-align: center;border-bottom: 1px solid #000;border-top: 1px solid #000;"></td>
                    <td
                        style="text-align: center;border-bottom: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;">
                        Subtotal</td>
                    <td
                        style="text-align: center;border-bottom: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;">
                        1</td>
                    <td
                        style="text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;">
                        £{{$taxable_amount}}</td>


                    @if($show_discount!=0)
                    <td style="text-align: right;border-bottom: 1px solid #000;border-right: 1px solid #000;">£</td>
                    @endif

                    <td style="text-align: right;border-bottom: 1px solid #000;border-right: 1px solid #000;">£
                        {{$taxable_amount}}</td>


                    @if($billing->vat!=0)
                    <td style="text-align: right;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                        £{{$vaton_re_amount}}</td>
                    @endif
                    <td style="text-align: right;border-bottom: 1px solid #000;">£{{$re_amount}}</td>
                </tr>

                <tr style="background-color: transparent;border: none;">
                    <td @if($billing->vat!=0) colspan="5" @else colspan="4" @endif
                        style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;">
                    </td>
                    <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;" @if($show_discount!=0)
                        colspan="2" @else colspan="1" @endif>Total
                        Excluding VAT</td>

                    <td style="text-align: right;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                        &pound;{{$taxable_amount}}
                    </td>
                </tr>
                @if($billing->vat!=0)
                <tr style="background-color: transparent;border: none;">
                    <td @if($billing->vat!=0) colspan="5" @else colspan="4" @endif
                        style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;">
                    </td>
                    <td style="background: #dbe5f1;border-bottom: 1px solid #000;border-right: 1px solid #000;"
                        @if($show_discount!=0) colspan="2" @else colspan="1" @endif>VAT (GB VAT {{$billing->vat}}%)</td>

                    <td
                        style="text-align: right;background: #dbe5f1;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                        &pound;{{$vaton_re_amount}} </td>
                </tr>
                @endif
                <tr style="background-color: transparent;border: none;">
                    <td @if($billing->vat!=0) colspan="5" @else colspan="4" @endif
                        style="border-left: none;border-bottom: none;border-right: 1px solid #000;border-top: none;">
                    </td>
                    <td style="border-right: 1px solid #000;" @if($show_discount!=0) colspan="2" @else colspan="1"
                        @endif>Total Including VAT</td>

                    <td style="text-align: right;border-right: 1px solid #000;">&pound; {{$re_amount}}</td>
                </tr>
            </tbody>
        </table>


        <table style="width: 100%;margin-top: 10px;">
            <tr>
                @if($re_amount!=0)
                <td style="border:none;border-bottom: none" colspan="3">Amount in words: GBP
                    {{ ucwords($re_amount_words) }} Only.</td>
                @endif
                @if($re_amount==0)
                <td style="border:none;border-bottom: none" colspan="3">Amount in words: GBP Zero Only.</td>
                @endif .
            </tr>
        </table>

        <table class="main-table" width="100%" border="1"
            style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
            <thead>
                <tr style="background-color: #daeef3;">
                    <th style="background-color: #fff;">Please make payment to below account details within next 5 days
                    </th>
                </tr>

                <tr style="background-color: #daeef3;">
                    <th>WORKPERMITCLOUD LIMITED</th>
                </tr>
                <tr>
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
                <td>Thank you for selecting WorkPermitCloud Limited as your preferred business partner! </td>

            </tr>
            <tr>
                <td>This is a system generated invoice and require no signature.</td>

            </tr>
        </table>

        <table width="100%" style="font-family: calibri;margin: 25px auto;text-align: left;border-collapse:collapse;">
            <tfoot style="position: fixed;bottom: 0;">
                <tr>
                    <!-- <td><img src="http://localhost/hrms/public/assets/img/ftr-logo.png"></td> -->
                    <td><img src="https://workpermitcloud.co.uk/hrms/public/assets/img/ftr-logo.png"></td>
                    <td>
                        <p style="margin-bottom: 0;">WorkPermitCloud Limited is Regulated to provide immigration
                            services by the</p>
                        <p style="margin-top: 0;">Immigration Ser-vices Commissioner. Registration No. F202100311.</p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>