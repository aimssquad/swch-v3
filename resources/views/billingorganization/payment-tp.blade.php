@extends('master')

@section('javascripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
document.getElementById("my_captcha_form").addEventListener("submit",function(evt)
  {

  var response = grecaptcha.getResponse();
  if(response.length == 0)
  {
    //reCaptcha not verified
     document.getElementById('recaptcha-error').innerHTML = "You can't leave Captcha Code empty";

    evt.preventDefault();
    return false;
  }
  //captcha verified
  //do the rest of your validations here

});

</script>

@endsection


<style>
    body {
        background: #f3f3f3 !important;
    }

    .pay-inr {
        background: #fff;
        padding: 10px 20px;
        margin: 20px 0;
        border-radius: 7px;
    }

    .pay-inr .form-control,
    .pay-inr select.form-control {
        border: 1px solid #ddd;
        padding-left: 10px;
        font-size: 14px;
        box-shadow: none;
        border-radius: 5px;
    }
</style>
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-5 col-md-offset-4">
            <div class="pay-inr">
            @if(isset($mode) && $mode=='posted')
                <h2 class="text-left" style="color: #0053dc;"> Confirm Payment Details </h2>
            @else
                <h2 class="text-left" style="color: #0053dc;"> Payment Details </h2>
            @endif
                <hr>
                @if (session()->has('error'))
                <div class="text-danger font-italic">{{ session()->get('error') }}</div>
                @endif
                @if(isset($mode) && $mode=='posted')
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label>Due Amount </label>
                            <input type="number" value="{{$paid_amount}}"  class="form-control" readonly><br>
                        </div>
                    </div>
                <?php
$pass = DB::Table('registration')

    ->where('reg', '=', $bill_rs->emid)

    ->first();

    //dd($pass);
$bil_name = DB::Table('billing')

    ->where('in_id', '=', $bill_rs->in_id)

    ->get();
$nameb = array();
if (count($bil_name) != 0) {
    foreach ($bil_name as $biname) {
        $nameb[] = $biname->des;

    }
}
$strbil = implode(',', $nameb);
?>                            
                            <?php

include(public_path().'/hosted/gateway.php');
$CSGW = new P3\SDK\Gateway;
//$key = '9GXwHNVC87VqsqNM';
$key = 'C7CJH5I1BB2UEf1APj05';
$merchantID='226737';
// $key = 'B2khwH9swXz8';
// $merchantID='231035';

//$req_amount=1001;

$tran = array (
    'merchantID' => $merchantID,
    'merchantSecret' => $key,
    'action' => 'SALE',
    //'threeDSRequired' => 'N',
    'type' => 1,
    'countryCode' => 826,
    'currencyCode' => 826,
    //'amount' => $company->amount*100,
    'amount' => $req_amount,
    'orderRef' => $bill_rs->in_id,
    'orderDes' => $strbil,
    'formResponsive' => 'Y',
    'customerName' => '',
    'customerEmail' => '',
    'customerPhone' => '',
    'customerAddress' => '',
    'customerPostcode' => '',
    // 'customerName' => $pass->f_name.' '.$pass->l_name,
    // 'customerEmail' => $pass->email,
    // 'customerPhone' => $pass->p_no,
    // 'customerAddress' => $pass->address,
    // 'customerPostcode' => $pass->zip,
    'transactionUnique' => uniqid(),
    'redirectURL' =>  'https://workpermitcloud.co.uk/hrms/billingorganization/online-payment' ,
);

echo $CSGW->hostedRequest($tran);
?>
                @else
                <form action="" method="post" id="my_captcha_form">
                    @csrf
                    <div class="row form-group">
                        <!-- <div class="col-md-12">
                            <label>Due Amount</label>
                            <input type="number" value="{{$bill_rs->due}}" name="due_amount" id="due_amount" class="form-control" readonly><br>
                        </div> -->
                        <div class="col-md-12">
                            <label>Due Amount</label>
                            <input type="hidden" value="{{$bill_rs->due}}" name="due_amount" id="due_amount" class="form-control" readonly>
                            <input type="number" value="{{$bill_rs->due}}" name="paid_amount" id="paid_amount" class="form-control" step="any" readonly><br>
                        </div>
					    <div class="col-md-12">
							<div class="capcha">
      				            <div class="g-recaptcha" id="rcaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"  data-theme="light"></div>
				            </div>
				            <div id="recaptcha-error" style="color:red;">
				    	</div><br>
                    <div class="row form-group">
                        <div class="col-md-6">
                            
                            <input type="submit" value="Proceed To Pay" class="btn btn-primary pay-via-stripe-btn">
                           
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection