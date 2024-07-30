<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use Session;
use view;


class TestController extends Controller
{

    public function acceptPayment(){


        return view('sm_accept_payment');
    }

    public function getPaymentInfo(Request $request){
        //dd($request->all());
        if(isset($_POST)){
            
            if($request->responseCode==0){
                echo 'Thank you for making the payment';
                dd($request->all());
            }else{
                echo 'Error!!!! '.$request->responseCode.' - '.$request->responseMessage;
                dd($request->all());
            }
            //responseCode=0 means success state=captured
        }else{
            echo 'hello';
        }
    }

}