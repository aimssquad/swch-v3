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
</head>

<body>
    <div class="wrapper">

        @include('admin.include.header')
        <!-- Sidebar -->

        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">

            </div>
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="far fa-newspaper"></i> New Billing</h4>
                                    @if(Session::has('message'))
                                    <div class="alert alert-success" style="text-align:center;"><span
                                            class="glyphicon glyphicon-ok"></span><em>
                                            {{ Session::get('message') }}</em></div>
                                    @endif
                                    @if(Session::has('error'))
                                    <div class="alert alert-danger" style="text-align:center;"><span
                                            class="glyphicon glyphicon-ok"></span><em> {{ Session::get('error') }}</em>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <div class=" form-group">
                                                    <label for="bill_for" class="placeholder">Billing For </label>
                                                    <select class="form-control input-border-bottom" id="bill_for"
                                                        required="" name="bill_for" style="margin-top: 22px;" onchange="checkBillFor(this.value);">
                                                        <option value="">&nbsp;</option>
                                                        <option value="invoice for license applied">Invoice for license applied</option>
                                                        <option value="invoice for license granted">Invoice for license granted</option>
                                                        <option value="first invoice recruitment service">First invoice for recruitment service</option>
                                                        <option value="second invoice visa service">Second invoice for visa service</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-3">
                                                <div class=" form-group">
                                                    <label for="bill_date" class="placeholder">Billing Date </label>
                                                    <input id="bill_date" type="date" name="bill_date" class="form-control input-border-bottom" required="" style="margin-top: 22px;">
                                                </div>
                                            </div> -->
                                            <div class="col-md-3">
                                                <div class=" form-group">
                                                    <label for="hold_st" class="placeholder">Billing Type </label>
                                                    <select class="form-control input-border-bottom" id="billing_type"
                                                        required="" name="billing_type" style="margin-top: 22px;"
                                                        onchange="checktypebillneww(this.value);">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Organisation">Organisation</option>
                                                        <option value="Candidate">Candidate</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <input id="emid" type="hidden" name="emid"
                                                class="form-control input-border-bottom" required=""
                                                style="margin-top: 22px;">

                                            <div class="col-md-3" id="or_id" style="display:none;">
                                                <div class="form-group">
                                                    <label for="emid" class="placeholder">Select Organisation</label>
                                                    <input id="emidname" type="text" name="emidname"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" onchange="checkcompany();">
                                                </div>
                                            </div>
                                            <input id="canidate_email" type="hidden" name="canidate_email"
                                                class="form-control input-border-bottom" style="margin-top: 22px;">
                                            <input id="candidate_address" type="hidden" name="candidate_address"
                                                class="form-control input-border-bottom" style="margin-top: 22px;">
                                            <input id="candidate_id" type="hidden" name="candidate_id"
                                                class="form-control input-border-bottom" style="margin-top: 22px;">

                                            <div class="col-md-3" id="can_id" style="display:none;">
                                                <div class="form-group">
                                                    <label for="canidate_name" class="placeholder">Select
                                                        Candidate</label>
                                                    <!--<input id="canidate_name" type="text"  name="canidate_name"    class="form-control input-border-bottom"  style="margin-top: 22px;"  onchange="checkcandidate();">-->

                                                    <select class="form-control input-border-bottom" id="canidate_name"
                                                        required="" name="canidate_name" style="margin-top: 22px;"
                                                        onchange="checkcandidate(this.value);">
                                                        <option value="">&nbsp;</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3" id="rec_can_id" style="display:none;">
                                                <div class="form-group">
                                                    <label for="rec_candidate_name" class="placeholder">Select
                                                        Candidate</label>

                                                    <select class="form-control input-border-bottom" id="rec_candidate_name"
                                                         name="rec_candidate_name" style="margin-top: 22px;"
                                                        onchange="checkcandidate(this.value);">
                                                        <option value="">&nbsp;</option>
                                                    </select>

                                                </div>


                                            </div>

                                            <div class="col-md-3" id="rec_can_billto" style="display:none;">
                                                <div class=" form-group">
                                                    <label for="hold_st" class="placeholder">Bill To </label>
                                                    <select class="form-control input-border-bottom" id="bill_to"
                                                         name="bill_to" style="margin-top: 22px;">
                                                        <option value="Candidate">Candidate</option>
                                                        <option value="Organisation">Organisation</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class=" form-group">
                                                    <label for="hold_st" class="placeholder">Payment Mode </label>
                                                    <select class="form-control input-border-bottom" id="pay_mode"
                                                        required="" name="pay_mode" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Online">Online</option>
                                                        <option value="Ofline">Offline</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="dynamic_row">
                                            <?php $tr_id = 0;?>
                                            <div class="row form-group">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="des" class="placeholder">Description</label>
                                                        <select class="form-control input-border-bottom"
                                                            id="package{{$tr_id}}" required="" name="package[]"
                                                            style="margin-top: 22px;"
                                                            onchange="checkpackage(this.value,{{$tr_id}});">
                                                            <option value="">&nbsp;</option>

                                                            <?php foreach ($package_rs as $package) {?>
                                                            <option value="{{$package->id}}">{{$package->name}}</option>
                                                            <?php }?>
                                                        </select>

                                                        <input id="des{{$tr_id}}" name="des[]" type="hidden"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4" style="display:none;" id="ex_vat_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="anount_ex_vat" class="placeholder">Unit Price
                                                            Excluding VAT</label>
                                                        <input id="anount_ex_vat{{$tr_id}}" type="number"
                                                            name="anount_ex_vat[]"
                                                            class="form-control input-border-bottom" required=""
                                                            style="margin-top: 22px;">
                                                    </div>
                                                </div>


                                                <div class="col-md-2" style="display:none;" id="discount_type_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="discount" class="placeholder">Discount Type</label>
                                                        <select id="discount_type{{$tr_id}}" class="form-control input-border-bottom"  style="margin-top: 22px;"
                                                        required name="discount_type[]"  onchange="checkpackagedis(this.value,{{$tr_id}});" >
                                                        <option value="P">Percentage</option>
                                                        <option value="A">Absolute</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="display:none;" id="discount_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="discount" class="placeholder">Discount</label>
                                                        <input id="discount{{$tr_id}}" type="number" step=".01" name="discount[]"
                                                            class="form-control input-border-bottom" required="" value="0"
                                                            style="margin-top: 22px;"
                                                            onkeyup="checkpackagedis(this.value,{{$tr_id}});" onclick="checkpackagedis(this.value,{{$tr_id}});" >
                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="display:none;"
                                                    id="discount_amount_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="discount_amount" class="placeholder">Discounted
                                                            Amount</label>
                                                        <input id="discount_amount{{$tr_id}}" type="number"
                                                            name="discount_amount[]"
                                                            class="form-control input-border-bottom" required=""
                                                            style="margin-top: 22px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="display:none;" id="vat_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="vat" class="placeholder">Vat in %</label>
                                                        <input id="vat{{$tr_id}}" type="number" name="vat[]"
                                                            class="form-control input-border-bottom" required=""
                                                            style="margin-top: 22px;">


                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="display:none;"
                                                    id="amount_after_vat_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="amount_after_vat" class="placeholder">Amount After
                                                            Vat</label>
                                                        <input id="amount_after_vat{{$tr_id}}" type="number"
                                                            name="amount_after_vat[]"
                                                            class="form-control input-border-bottom" required=""
                                                            style="margin-top: 22px;">


                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="display:none;"
                                                    id="net_amount_div{{$tr_id}}">
                                                    <div class=" form-group">
                                                        <label for="net_amount" class="placeholder">Net Amount </label>
                                                        <input id="net_amount{{$tr_id}}" type="number"
                                                            name="net_amount[]" class="form-control input-border-bottom"
                                                            required="" style="margin-top: 22px;">


                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="margin-top:30px;">
                                                    <div class=" form-group btn-pls">
                                                        <!-- <button class="btn btn-success " type="button"
                                                            id="add<?php echo ($tr_id + 1); ?>"
                                                            onClick="addnewrow(<?php echo ($tr_id + 1); ?>)"
                                                            data-id="<?php echo ($tr_id + 1); ?>"> <i
                                                                class="fas fa-plus"></i> </button> -->

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row form-group">

                                            <input id="amount" type="hidden" name="amount"
                                                class="form-control input-border-bottom" required="">


                                            <div class="col-md-4">
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



        <?php

            $aryytestsys = array();

            foreach ($or_de as $billdept) {

                $aryytestsys[] = '"' . $billdept->com_name . '"';
            }
            $strpsys = implode(',', $aryytestsys);

            $canarr = array();
            foreach ($candidate_rs as $cans) {

                $canarr[] = '"' . $cans->name . '"';
            }
            $strpcant = implode(',', $canarr);

        ?>
    <script src="{{ asset('js/jquery.autosuggest.js')}}"></script>
    <script>
        var component_name = [<?=$strpsys;?>];
        console.log(component_name);
        $("#emidname").autosuggest({
            sugggestionsArray: component_name
        });

        var can_name = [<?=$strpcant;?>];
        console.log(can_name);
        $("#canidate_name").autosuggest({
            sugggestionsArray: can_name
        });

    function checktypebillneww(val) {
        if (val == 'Organisation') {
            $("#or_id").show();
            $("#can_id").hide();
            $("#emidname").prop('required', true);
            $("#canidate_name").prop('required', false);
        } else {
            if($('#bill_for').val()=='first invoice recruitment service'){
                $('#billing_type').val('Organisation');
                $('#rec_can_id').show();
                $('#rec_can_billto').show();
                getRecruitmentBillCandidate(empid);
            }
            else if($('#bill_for').val()=='second invoice visa service'){
                $('#billing_type').val('Organisation');
                $('#rec_can_id').show();
                $('#rec_can_billto').show();
                getCosBillCandidate(empid);
            }
            else{
                $("#can_id").show();
                $('#rec_can_id').hide();
                $('#rec_can_billto').hide();
                $("#or_id").show();
                $("#emidname").prop('required', true);
                $("#canidate_name").prop('required', true);
            }
        }
    }

    function checkBillFor(billFor){
        //alert(billFor);
        if(billFor=='first invoice recruitment service'){
            $('#billing_type').val('Organisation');
            checktypebillneww('Organisation');
            $('#rec_can_id').show();
            $('#rec_can_billto').show();

        }
        else if(billFor=='second invoice visa service'){
            $('#billing_type').val('Organisation');
            checktypebillneww('Organisation');
            $('#rec_can_id').show();
            $('#rec_can_billto').show();

        }else{
            $('#billing_type').val('Organisation');
            checktypebillneww('Organisation');
            $('#rec_can_id').hide();
            $('#rec_can_billto').hide();

        }
        $('#emidname').val('');
        $("#rec_candidate_name").html("<option value=''>&nbsp;</option>");
    }

    function getRecruitmentBillCandidate(empid){
        //alert(empid);
        $.ajax({
                type:'GET',
                url:"{{url('pis/getrecruitementfirstinvcandidate')}}/"+empid,
                cache: false,
                success: function(responseC){
                    //alert(responseC);
                    if(responseC=='no_recruitement'){
                        $("#rec_candidate_name").html("<option value=''>&nbsp;</option>");
                    }else{
                        $("#rec_candidate_name").html(responseC);
                    }
                }
            });

    }

    function getCosBillCandidate(empid){
        //alert(empid);
        $.ajax({
                type:'GET',
                url:"{{url('pis/getrecruitementsecondinvcandidate')}}/"+empid,
                cache: false,
                success: function(responseC){
                    //alert(responseC);
                    if(responseC=='no_cos'){
                        $("#rec_candidate_name").html("<option value=''>&nbsp;</option>");
                    }else{
                        $("#rec_candidate_name").html(responseC);
                    }
                }
            });

    }
    function checkcompany() {
        var empid = document.getElementById("emidname").value;

        $.ajax({
            type: 'GET',
            url: "{{url('pis/getremidnamepaykkById')}}/" + empid,
            cache: false,
            success: function(response) {


                var obj = jQuery.parseJSON(response);

                console.log(obj);

                var reg = obj[0].reg;


                $("#emid").val(reg);

            }
        });

        if($('#bill_for').val()=='first invoice recruitment service'){
            $('#billing_type').val('Organisation');
            //checktypebillneww('Organisation');
            $('#rec_can_id').show();
            $('#rec_can_billto').show();
            getRecruitmentBillCandidate(empid)

        }
        if($('#bill_for').val()=='second invoice visa service'){
            $('#billing_type').val('Organisation');
            //checktypebillneww('Organisation');
            $('#rec_can_id').show();
            $('#rec_can_billto').show();
            getCosBillCandidate(empid)

        }

        $.ajax({
            type: 'GET',
            url: "{{url('pis/getremidnamepaykkByIdnewtimeinvc')}}/" + empid,
            cache: false,
            success: function(response) {




                $("#canidate_name").html(response);

            }
        });
    }

    function checkcandidate(val) {
        var empid = val;
        var emplpyee = document.getElementById("emid").value;
    //alert("{{url('pis/getremidnamepaykkByIdnecandidatenameinvc')}}/" + empid + '/' + emplpyee);
        $.ajax({
            type: 'GET',
            url: "{{url('pis/getremidnamepaykkByIdnecandidatenameinvc')}}/" + empid + '/' + emplpyee,
            cache: false,
            success: function(response) {


                var obj = jQuery.parseJSON(response);

                console.log(obj);




                $("#canidate_email").val(obj[0].email);
                $("#candidate_id").val(obj[0].id);
                $("#candidate_address").val(obj[0].address);
                $("#pay_mode").attr('readonly', true);
                $("#pay_mode").val('Ofline');



            }
        });
    }



    function checkpackage(val, row) {
        var empid = val;

        $.ajax({
            type: 'GET',
            url: "{{url('pis/getpcakgedeatilsbyId')}}/" + empid,
            cache: false,
            success: function(response) {


                var obj = jQuery.parseJSON(response);

                console.log(obj);
                $("#des" + row).val(obj[0].name);
                $("#anount_ex_vat" + row).val(obj[0].price);
                $("#anount_ex_vat" + row).prop("readonly", true);

                if (obj[0].discount_apply == 'Yes') {
                    $("#discount_div" + row).show();
                    $("#discount_type_div" + row).show();
                    $("#discount" + row).prop("readonly", false);
                    $("#discount_amount" + row).val('0');
                    $("#discount_amount" + row).prop("readonly", true);
                } else {
                    $("#discount_div" + row).show();
                    $("#discount_type_div" + row).show();
                    $("#discount" + row).prop("readonly", true);
                    $("#discount_amount" + row).prop("readonly", true);
                    $("#discount" + row).val('0');
                    $("#discount_amount" + row).val('0');

                }

                if (obj[0].vat_apply == 'Yes') {

                    $("#vat_div" + row).show();
                    $("#vat" + row).val(obj[1].percent);
                    $("#vat" + row).prop("readonly", true);
                    var percent = obj[1].percent;
                } else {
                    $("#vat_div" + row).show();
                    $("#vat" + row).prop("readonly", true);
                    $("#vat" + row).val('0');
                    var percent = '0';
                }

                var price_vat = Number(obj[0].price) * Number(percent) / 100;
                price_vat=parseFloat(price_vat).toFixed(2);
               // alert(price_vat);
                $("#amount_after_vat" + row).prop("readonly", true);
                $("#net_amount" + row).prop("readonly", true);
                var price_after_vat = (parseFloat(price_vat) + parseFloat(obj[0].price));
                $("#ex_vat_div" + row).show();
                $("#discount_amount_div" + row).show();
                $("#amount_after_vat_div" + row).show();
                $("#net_amount_div" + row).show();

                $("#amount_after_vat" + row).val(price_after_vat);
                $("#net_amount" + row).val(price_after_vat);
                var totval = document.getElementById("amount").value;
                if (totval == '') {
                    totval = '0';
                }
                if (obj[0].discount_apply == 'N/A') {
                    var price_amou = parseFloat(totval) + parseFloat(price_after_vat);
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

    function addnewrow(rowid) {



        if (rowid != '') {
            $('#add' + rowid).attr('disabled', true);

        }



        $.ajax({

            url: "{{url('billing/get-add-row-item')}}/" + rowid,
            type: "GET",

            success: function(response) {

                $("#dynamic_row").append(response);

            }
        });
    }

    function delRow(rowid) {
        var lastrow = $(".itemslot:last").attr("id");
        //alert(lastrow);
        var active_div = (rowid);

        $('#add' + active_div).attr('disabled', false);
        $(document).on('click', '.deleteButton', function() {
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