<?php
function calculateHashDigest($stringtohash, $key, $hashmethod)
{
    switch($hashmethod)
    {
        case "MD5":
            $hash = md5($stringtohash);
            break;
        case "SHA1":
            $hash = sha1($stringtohash);
            break;
        case "HMACMD5":
            $hash = hash_hmac("md5", $stringtohash, $key);
            break;
        case "HMACSHA1":
            $hash = hash_hmac("sha1", $stringtohash, $key);
            break;
    }
    return ($hash);
}

function getHash($formVariables){
    // $mid = $formVariables[MerchantID];
    // $amt = $formVariables[Amount];
    // $currencycode = $formVariables[CurrencyCode];
    // $orderid = $formVariables[OrderID];
    // $transactiontype = $formVariables[TransactionType];
    // $transactiondatetime = $formVariables[TransactionDateTime];
    // $orderdesc = $formVariables[OrderDescription];
    // $customername = $formVariables[CustomerName];
    // $displaybillingaddress = $formVariables[DisplayBillingAddress];
    // $address1 = $formVariables[Address1];
    // $address2 = $formVariables[Address2];
    // $address3 = $formVariables[Address3];
    // $address4 = $formVariables[Address4];
    // $city = $formVariables[City];
    // $state = $formVariables[State];
    // $postcode = $formVariables[PostCode];
    // $countrycode = $formVariables[CountryCode];
    // $hashmethod = $formVariables[HashMethod];
    // $callbackurl = $formVariables[CallbackURL];
    // $echoavs = $formVariables[EchoAVSCheckResult];
    // $echocv2 = $formVariables[EchoCV2CheckResult];
    // $echothreed = $formVariables[EchoThreeDSecureAuthenticationCheckResult];
    // $echocardtype = $formVariables[EchoCardType];
    // $cv2mandatory = $formVariables[CV2Mandatory];
    // $address1mandatory = $formVariables[Address1Mandatory];
    // $citymandatory = $formVariables[CityMandatory];
    // $postcodemandatory = $formVariables[PostCodeMandatory];
    // $statemandatory = $formVariables[StateMandatory];
    // $countrymandatory = $formVariables[CountryMandatory];
    // $resultdeliverymethod = $formVariables[ResultDeliveryMethod];
    // $serverresulturl = $formVariables[ServerResultURL];
    // $paymentformsdisplaysresult = $formVariables[PaymentFormDisplaysResult];
    // $serverresulturlcookievariables = $formVariables[ServerResultURLCookieVariables];
    // $serverresulturlformvariables = $formVariables[ServerResultURLFormVariables];
    // $serverresulturlquerystringvariables = $formVariables[ServerResultURLQueryStringVariables];
  
    #password and preshard key (not in form)
    $presharedkey='OhwvFzGamrOu4VEDj4H1o8';
    $pw = "TakePayments321";
  
    // $StringToHash = "PreSharedKey=$presharedkey&MerchantID=$mid&Password=$pw&Amount=$amt&CurrencyCode=$currencycode&EchoAVSCheckResult=$echoavs&EchoCV2CheckResult=$echocv2&EchoThreeDSecureAuthenticationCheckResult=$echothreed&EchoCardType=$echocardtype&OrderID=$orderid&TransactionType=$transactiontype&TransactionDateTime=$transactiondatetime&CallbackURL=$callbackurl&OrderDescription=$orderdesc&CustomerName=$customername&DisplayBillingAddress=$displaybillingaddress&Address1=$address1&Address2=$address2&Address3=$address3&Address4=$address4&City=$city&State=$state&PostCode=$postcode&CountryCode=$countrycode&CV2Mandatory=$cv2mandatory&Address1Mandatory=$address1mandatory&CityMandatory=$citymandatory&PostCodeMandatory=$postcodemandatory&StateMandatory=$statemandatory&CountryMandatory=$countrymandatory&ResultDeliveryMethod=$resultdeliverymethod&ServerResultURL=$serverresulturl&PaymentFormDisplaysResult=$paymentformsdisplaysresult&ServerResultURLCookieVariables=$serverresulturlcookievariables&ServerResultURLFormVariables=$serverresulturlformvariables&ServerResultURLQueryStringVariables=$serverresulturlquerystringvariables";

    $StringToHash = $formVariables;
    $hashmethod= 'SHA1';
    $HashDigest = calculateHashDigest($StringToHash,$presharedkey,$hashmethod);
  
    // error_log(print_r($StringToHash, TRUE)."\n", 3, $php_log_dest);
  
    // error_log(print_r($HashDigest, TRUE)."\n", 3, $php_log_dest);
  
    return $HashDigest;
  }
?>
<doctype html>
<html>
    <head>

    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                @php
                    $cdate=date('Y-m-d H:i:s P');
                @endphp
                <form method="POST" action="https://mms.tponlinepayments2.com/Pages/PublicPages/PaymentForm.aspx">
                    <input type="" id="HashMethod" name="HashMethod" value="SHA1">
                    <label>MerchantID</label> <input type="text" name="MerchantID" value="WORKPE-2936812"> <br/>
                    <label>HashDigest</label> <input type="text" name="HashDigest" value="<?php echo getHash("PreSharedKey=OhwvFzGamrOu4VEDj4H1o8&MerchantID=WORKPE-2936812&Password=TakePayments321&Amount=3311&CurrencyCode=826&EchoAVSCheckResult=true&EchoCV2CheckResult=true&EchoThreeDSecureAuthenticationCheckResult=true&EchoCardType=true&OrderID=Order-963&TransactionType=SALE&TransactionDateTime=".$cdate."&CallbackURL=https://workpermitcloud.co.uk/hrms/sm-get-payment&OrderDescription=Order description&CustomerName=Subhasish Mukherjee&Address1=113 Broad Street West&Address2=&Address3=&Address4=&City=Oldpine&State=Strongbarrow&PostCode=SB42 1SX&CountryCode=826&CV2Mandatory=true&Address1Mandatory=true&CityMandatory=true&PostCodeMandatory=true&StateMandatory=true&CountryMandatory=true&ResultDeliveryMethod=POST&ServerResultURL= &PaymentFormDisplaysResult=false&ServerResultURLCookieVariables=&ServerResultURLFormVariables=&ServerResultURLQueryStringVariables=")?>">  <br/><br/>

                    <b>HashString for SHA1::</b> <span style="color:blue;">{{"PreSharedKey=OhwvFzGamrOu4VEDj4H1o8&MerchantID=WORKPE-2936812&Password=TakePayments321&Amount=3311&CurrencyCode=826&EchoAVSCheckResult=true&EchoCV2CheckResult=true&EchoThreeDSecureAuthenticationCheckResult=true&EchoCardType=true&OrderID=Order-963&TransactionType=SALE&TransactionDateTime=".$cdate."&CallbackURL=https://workpermitcloud.co.uk/hrms/sm-get-payment&OrderDescription=Order description&CustomerName=Subhasish Mukherjee&Address1=113 Broad Street West&Address2=&Address3=&Address4=&City=Oldpine&State=Strongbarrow&PostCode=SB42 1SX&CountryCode=826&CV2Mandatory=true&Address1Mandatory=true&CityMandatory=true&PostCodeMandatory=true&StateMandatory=true&CountryMandatory=true&ResultDeliveryMethod=POST&ServerResultURL= &PaymentFormDisplaysResult=false&ServerResultURLCookieVariables=&ServerResultURLFormVariables=&ServerResultURLQueryStringVariables="}}</span> <br/><br/>

                    <label>TransactionType</label> <input type="text" name="TransactionType" value="SALE">  <br/>
                    <label>CallbackURL</label> <input type="text" name="CallbackURL" value="https://workpermitcloud.co.uk/hrms/sm-get-payment">  <br/>
                    <label>ServerResultURL</label> <input type="text" name="ServerResultURL" value="">  <br/>
                    <label>Amount</label> <input type="text" name="Amount" value="3311">  <br/>
                    <label>CurrencyCode</label> <input type="text" name="CurrencyCode" value="826">  <br/>
                    <label>OrderID</label> <input type="text" name="OrderID" value="Order-963">  <br/>
                    <label>TransactionDateTime</label> <input type="text" name="TransactionDateTime" value="{{ $cdate }}">  <br/>
                    <label>OrderDescription</label> <input type="text" name="OrderDescription" value="Order description ">  <br/>
                    <label>CustomerName</label> <input type="text" name="CustomerName" value="Subhasish Mukherjee">  <br/>
                    <label>Address1</label> <input type="text" name="Address1" value="113 Broad Street West">  <br/>
                    <label>Address2</label> <input type="text" name="Address2" value="">  <br/>
                    <label>Address3</label> <input type="text" name="Address3" value="">  <br/>
                    <label>Address4</label> <input type="text" name="Address4" value="">  <br/>
                    <label>City</label> <input type="text" name="City" value="Oldpine">  <br/>
                    <label>State</label> <input type="text" name="State" value="Strongbarrow">  <br/>
                    <label>PostCode</label> <input type="text" name="PostCode" value="SB42 1SX">  <br/>
                    <label>CountryCode</label> <input type="text" name="CountryCode" value="826">  <br/>
                    <label>EchoAVSCheckResult</label> <input type="text" name="EchoAVSCheckResult" value="true">  <br/>
                    <label>EchoCV2CheckResult</label> <input type="text" name="EchoCV2CheckResult" value="true">  <br/>
                    <label>EchoThreeDSecureAuthenticationCheckResult</label> <input type="text" name="EchoThreeDSecureAuthenticationCheckResult" value="true">  <br/>
                    <label>CV2Mandatory</label> <input type="text" name="CV2Mandatory" value="true">  <br/>
                    <label>Address1Mandatory</label> <input type="text" name="Address1Mandatory" value="true">  <br/>
                    <label>CityMandatory</label> <input type="text" name="CityMandatory" value="true">  <br/>
                    <label>PostCodeMandatory</label> <input type="text" name="PostCodeMandatory" value="true">  <br/>
                    <label>StateMandatory</label> <input type="text" name="StateMandatory" value="true">  <br/>
                    <label>CountryMandatory</label> <input type="text" name="CountryMandatory" value="true">  <br/>
                    <label>ResultDeliveryMethod</label> <input type="text" name="ResultDeliveryMethod" value="POST">  <br/>
                    <label>PaymentFormDisplaysResult</label> <input type="text" name="PaymentFormDisplaysResult" value="false">  <br/>
                    <label>ServerResultURLCookieVariables</label> <input type="text" name="ServerResultURLCookieVariables" value="">  <br/>
                    <label>ServerResultURLFormVariables</label> <input type="text" name="ServerResultURLFormVariables" value="">  <br/>
                    <label>ServerResultURLQueryStringVariables</label> <input type="text" name="ServerResultURLQueryStringVariables" value=""> <br/>
                    <label>ServerResultURL</label> <input type="" id="ServerResultURL" name="ServerResultURL" value="https://workpermitcloud.co.uk/hrms/sm-get-payment"><br/>
                    <input type="submit" value="submit to gateway" name="btnSubmit">
                </form>
            </div>
        </div>
    </body>
</html>
