<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />


    <!-- Fonts and icons -->
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
            urls: [
                "{{ asset('assets/css/fonts.min.css')}}"
            ]
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
    <style>
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    </style>
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
                <!--<h4 class="page-title">Organisation</h4>-->
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"> <i class="fas fa-pound-sign"></i> New Payment Received</h4>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="row form-group">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emid" class="placeholder">Select Organisation</label>
                                                    <input id="emidname" type="text" name="emidname"
                                                        class="form-control input-border-bottom" required=""
                                                        onchange="checkcompany();">



                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="in_id" class="placeholder">Select Invoice Number</label>
                                                    <select class="form-control input-border-bottom" id="in_id"
                                                        name="in_id" required="" onchange="billvalue(this.value);">
                                                        <option value="">&nbsp;</option>




                                                    </select>

                                                </div>


                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="actual_payment_date" class="placeholder">Payment Receive Date</label>
                                                    <input id="actual_payment_date" type="date" name="actual_payment_date"
                                                        class="form-control input-border-bottom" required="" value="<?php echo date('Y-m-d');?>">
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row form-group" id="payment" style="display:none">
                                            <input id="emid" type="hidden" name="emid"
                                                class="form-control input-border-bottom" required="">
                                            <input id="vatpercent" type="hidden" name="vatpercent"
                                                class="form-control input-border-bottom" required="">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="des" class="placeholder">Description</label>
                                                    <textarea id="des" name="des" rows="5" class="form-control"
                                                        required="" style="resize:none;"> </textarea>


                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="reamount" class="placeholder"> Billing Amount</label>
                                                    <input id="reamount" type="number" name="reamount"
                                                        class="form-control input-border-bottom" required=""  step="any">


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="amount" class="placeholder">Payable Amount</label>
                                                    <input id="amount" type="number" name="amount"
                                                        class="form-control input-border-bottom" required=""  step="any">


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="date" class="placeholder">Bill date</label>
                                                    <input id="date" type="date" name="date"
                                                        class="form-control input-border-bottom" required="">


                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class=" form-group">
                                                    <label for="re_amount" class="placeholder"> Payment Received
                                                        Amount</label>
                                                    <input id="due_amonut" type="hidden" name="due_amonut"
                                                        class="form-control input-border-bottom" required="" step="any">

                                                    <input id="re_amount" type="number" name="re_amount"
                                                        class="form-control input-border-bottom" required=""  step="any"
                                                        onkeyup="vat_amount_distribute();"
                                                        onblur="vat_amount_distribute();">


                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class=" form-group">
                                                    <label for="re_amount" class="placeholder"> Payment Type
                                                        </label>
                                                        <select id="payment_type" class="form-control input-border-bottom"
                                                        required name="payment_type">
                                                        <option value="Cash">Cash</option>
                                                        <option value="Bacs">Bacs</option>
                                                        <option value="Card">Card</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class=" form-group">
                                                    <label for="actual_re_amount" class="placeholder"> Actual Received
                                                        Amount</label>


                                                    <input id="actual_re_amount" type="number" name="actual_re_amount"
                                                        class="form-control input-border-bottom" required=""
                                                        readonly="readonly"  step="any">


                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class=" form-group">
                                                    <label for="actual_vat_amount" class="placeholder"> VAT Received
                                                        Amount</label>


                                                    <input id="actual_vat_amount" type="number" name="actual_vat_amount"
                                                        class="form-control input-border-bottom" required=""
                                                        readonly="readonly"  step="any">


                                                </div>
                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-4">
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

    function billvalue(empid) {

        $.ajax({
            type: 'GET',
            url: "{{url('pis/getbillpaykkById')}}/" + empid,
            cache: false,
            success: function(response) {


                var obj = jQuery.parseJSON(response);
                $("#payment").show();
                console.log(obj);
                var amount = obj[0].due;
                var des = obj[3];

                $("#des").val(des);
                $("#des").attr("readonly", true);

                $("#amount").val(amount);
                $("#amount").attr("readonly", true);

                $("#reamount").val(obj[0].amount);
                $("#reamount").attr("readonly", true);

                $("#date").val(obj[0].date);
                $("#due_amonut").val(obj[0].due);
                $("#date").attr("readonly", true);
                $("#emid").val(obj[1].com_name);
                $("#emid").attr("readonly", true);
                $("#status").val(obj[0].status);

                $("#vatpercent").val(obj[0].vat);


            }
        });
    }

    //27-10-2021 sm
    function vat_amount_distribute() {
        var received_amount = $("#re_amount").val();
        var vatpercent = $("#vatpercent").val();
        //actual_vat_amount
        //actual_re_amount

        (received_amount == '') ? received_amount = 0: received_amount = received_amount;
        var vat = (received_amount * vatpercent) / 100;
        vat = Math.round(vat, 2);

        var actual_vat_amount = received_amount - vat;

        $("#actual_vat_amount").val(vat);
        $("#actual_re_amount").val(actual_vat_amount);


    }
    </script>

    <?php

$aryytestsys = array();

foreach ($or_rs as $billdept) {

    $aryytestsys[] = '"' . $billdept->com_name . '"';
}
$strpsys = implode(',', $aryytestsys);

?>
    <script src="{{ asset('js/jquery.autosuggest.js')}}"></script>
    <script>
    var component_name = [<?=$strpsys;?>];
    console.log(component_name);
    $("#emidname").autosuggest({
        sugggestionsArray: component_name
    });




    autocomplete(document.getElementById("emidname"), countries);

    function checkcompany() {
        var empid = document.getElementById("emidname").value;

        $.ajax({
            type: 'GET',
            url: "{{url('pis/getremidnamepaykkByIdnew')}}/" + empid,
            cache: false,
            success: function(html) {
                $("#in_id").html(html);
            }
        });
    }
    </script>
</body>

</html>