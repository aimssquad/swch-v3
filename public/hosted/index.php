<?php
include('gateway.php');
$CSGW = new P3\SDK\Gateway;
$key = '9GXwHNVC87VqsqNM';
$tran = array (
    'merchantID' => '119837',
    'merchantSecret' => $key,
    'action' => 'SALE',
    'type' => 1,
    'countryCode' => 826,
    'currencyCode' => 826,
    'amount' => 1001,
    'orderRef' => 'Test purchase',
    'formResponsive' => 'Y',
     'transactionUnique' => uniqid(),
     'redirectURL' =>  'http://' .
     $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
);

echo $CSGW->hostedRequest($tran);
