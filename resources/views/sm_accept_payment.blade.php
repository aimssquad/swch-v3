<?php
//$incfile="{{ asset()}}";dd(public_path());
include(public_path().'/hosted/gateway.php');
$CSGW = new P3\SDK\Gateway;
//$key = '9GXwHNVC87VqsqNM';
$key = 'B2khwH9swXz8';
$tran = array (
    'merchantID' => '231035',
    'merchantSecret' => $key,
    'action' => 'SALE',
    'type' => 1,
    'countryCode' => 826,
    'currencyCode' => 826,
    'amount' => 1001,
    'orderRef' => 'Test purchase merchant acc',
    'formResponsive' => 'Y',
     'transactionUnique' => uniqid(),
     'redirectURL' =>  'https://workpermitcloud.co.uk/hrms/sm-get-payment' ,
);

echo $CSGW->hostedRequest($tran);


