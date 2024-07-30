<?php
//$incfile="{{ asset()}}";dd(public_path());
include(public_path().'/hosted/gateway.php');
$CSGW = new P3\SDK\Gateway;
//$key = '9GXwHNVC87VqsqNM';
$key = 'B2khwH9swXz8';
$merchantID='231035';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon" />
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ["{{ asset('assets/css/fonts.min.css')}}"]
        },
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

        @include('billingorganization.include.header')
        <!-- Sidebar -->

        @include('billingorganization.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{url('billingorganizationdashboard')}}">
                            Home
                        </a>
                    </li>
                    <li class="separator">
                        /
                    </li>
                    <!-- <li class="nav-home">
								<a href="{{url('dashboarddetails')}}">Sponsor Complaience</a>
							</li>
							<li class="separator">
								/
							</li> -->
                    <li class="nav-item active">
                        <a href="{{url('billingorganization/billinglist')}}">Billing</a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="far fa-credit-card" aria-hidden="true"
                                            style="color:#10277f;"></i> &nbsp;Billing </h4>
                                    @if(Session::has('message'))
                                    <div class="alert alert-success" style="text-align:center;"><span
                                            class="glyphicon glyphicon-ok"></span><em>
                                            {{ Session::get('message') }}</em></div>
                                    @endif
                                    @if(Session::has('error'))
                                    <div class="alert alert-danger" style="text-align:center;"><span
                                            class="glyphicon glyphicon-ok"></span><em>
                                            {{ Session::get('error') }}</em></div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="3%">Sl.No.</th>
                                                    <th width="5%">Invoice Number</th>
                                                    <th width="15%">Amount</th>
                                                    <th width="30%">Description</th>


                                                    <th>Billing Date</th>
                                                    <th>Status</th>

                                                    <th>Dowlnload Invoice</th>
                                                    <th>Pay</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $i = 1;?>
                                                @foreach($bill_rs as $company)
                                                <?php
$pass = DB::Table('registration')

    ->where('reg', '=', $company->emid)

    ->first();

    //dd($pass);
$bil_name = DB::Table('billing')

    ->where('in_id', '=', $company->in_id)

    ->get();
$nameb = array();
if (count($bil_name) != 0) {
    foreach ($bil_name as $biname) {
        $nameb[] = $biname->des;

    }
}
$strbil = implode(',', $nameb);
?>
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $company->in_id }}</td>
                                                    <td>{{ $company->amount }}</td>


                                                    <td>{{ $strbil}}</td>



                                                    <td>{{ date('d/m/Y',strtotime($company->date)) }}</td>



                                                    <td>{{ strtoupper($company->status) }}</td>


                                                    <td class="icon" style="text-align: center;"><a
                                                            href="{{asset('public/billpdf/'.$company->dom_pdf)}}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Download" download><img style="width: 14px;"
                                                                src="{{asset('assets/img/download.png')}}"> </a>


                                                    </td>
                                                    <td style="text-align: center;padding: 0px 1px !important;">
                                                        @if($company->status!='paid') @if($company->pay_mode!='Ofline')
                                                        <!-- <a href="{{ url('billingorganization/pay-now/'.base64_encode($Roledata->reg).'/'.base64_encode($company->in_id)) }}"
                                                            style="font-size:16px;margin-bottom:10px;background: #1572e8; color: #fff;border-radius: 4px;  padding: 6px 8px;font-size:13px;"><i
                                                                class="far fa-file-text"></i> Pay Now</a> -->
                                                                <a href="{{ url('billingorganization/pay-now/'.base64_encode($company->in_id)) }}"
                                                            style="font-size:16px;margin-bottom:10px;background: #1572e8; color: #fff;border-radius: 4px;  padding: 6px 8px;font-size:13px;"><i
                                                                class="far fa-file-text"></i> Pay Now</a>
                                                                <?php

// include(public_path().'/hosted/gateway.php');
// $CSGW = new P3\SDK\Gateway;
// //$key = '9GXwHNVC87VqsqNM';
// $key = 'B2khwH9swXz8';

// $tran = array (
//     'merchantID' => $merchantID,
//     'merchantSecret' => $key,
//     'action' => 'SALE',
//     //'threeDSRequired' => 'N',
//     'type' => 1,
//     'countryCode' => 826,
//     'currencyCode' => 826,
//     //'amount' => $company->amount*100,
//     'amount' => 1001,
//     'orderRef' => $company->in_id,
//     'orderDes' => $strbil,
//     'formResponsive' => 'Y',
//     'customerName' => $pass->f_name.' '.$pass->l_name,
//     'customerEmail' => $pass->email,
//     'customerPhone' => $pass->p_no,
//     'customerAddress' => $pass->address,
//     'customerPostcode' => $pass->zip,
//     'transactionUnique' => uniqid(),
//     'redirectURL' =>  'https://workpermitcloud.co.uk/hrms/billingorganization/online-payment' ,
// );

// echo $CSGW->hostedRequest($tran);
?>
                                                        @endif
                                                        @endif
                                                    </td>
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
            @include('billingorganization.include.footer')
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
    <script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({});

        $('#multi-filter-select').DataTable({
            "pageLength": 5,
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d +
                            '</option>')
                    });
                });
            }
        });

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

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