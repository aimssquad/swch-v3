<?php
namespace App\Helpers;

use Request;
use App\Setting;
use Hashids\Hashids;
use DB;

class CommonHelper
{

    public static function getOrganisationStage($organisation_id){
        $stage="Registered";

        $assignedOrgs = DB::Table('role_authorization_admin_organ')
                    ->whereNotNull('role_authorization_admin_organ.module_name')
                    ->pluck('role_authorization_admin_organ.module_name');

        //unassigned org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->whereNotIn('registration.reg', $assignedOrgs)
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'not approved')
            ->where('registration.licence', '=', 'no')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="Unassigned Org.";
        }

        //assigned org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->whereIn('registration.reg', $assignedOrgs)
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'not approved')
            ->where('registration.licence', '=', 'no')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="Assigned Org.";
        }

        //wip org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'no')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="WIP Org.";
        }

        //license applied org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="License Applied Org.";
        }

        $billed1stOrgs = DB::Table('billing')
                    ->where('bill_for', '=', 'invoice for license applied')
                    ->pluck('billing.emid');

        // Unbilled 1st Invoice org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->whereNotIn('reg', $billed1stOrgs)
            ->where('license_type', '=', 'Internal')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="Unbilled 1st Invoice Org.";
        }

        // Billed 1st Invoice org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->whereIn('reg', $billed1stOrgs)
            ->where('license_type', '=', 'Internal')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="Billed 1st Invoice Org.";
        }

        $stage1=$stage;

        $hrFileOrgs = DB::Table('hr_apply')
                    ->pluck('hr_apply.emid');

        // Unassigned HR org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->whereNotIn('reg', $hrFileOrgs)
            ->where('license_type', '=', 'Internal')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."Unassigned HR Org.";
        }

        // Assigned  HR org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->whereIn('reg', $hrFileOrgs)
            ->where('license_type', '=', 'Internal')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."Assigned HR Org.";
        }

        // WIP HR org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->where('hr_apply.status', '=', 'Incomplete')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."HR WIP Org.";
        }

        // HR Complete org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->where('hr_apply.status', '=', 'Complete')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."HR Complete Org.";
        }

        // License Granted org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            //->where('hr_apply.status', '=', 'Complete')
            ->where('hr_apply.licence', '=', 'Granted')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."License Granted Org.";
        }

        // License Rejected org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            //->where('hr_apply.status', '=', 'Complete')
            ->where('hr_apply.licence', '=', 'Rejected')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."License Rejected Org.";
        }

        // License Refused org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            //->where('hr_apply.status', '=', 'Complete')
            ->where('hr_apply.licence', '=', 'Refused')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."License Refused Org.";
        }

        $allLicHr = DB::Table('hr_apply')
        ->where(function ($query) {
            $query->where('hr_apply.licence', '=', 'Refused')
                ->orWhere('hr_apply.licence', '=', 'Granted')
                ->orWhere('hr_apply.licence', '=', 'Rejected');

        })
        ->distinct()
        ->pluck('hr_apply.emid');

        // License Pending org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->whereNotIn('registration.reg', $allLicHr)
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."License Pending Org.";
        }

        $billed2ndOrgs = DB::Table('billing')
            ->where('bill_for', '=', 'invoice for license granted')
            ->where('status', '<>', 'cancel')
            ->pluck('billing.emid');

        // Unbilled 2nd Invoice org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->where('hr_apply.licence', '=', 'Granted')
            ->whereNotIn('registration.reg', $billed2ndOrgs)
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."Unbilled 2nd Invoice Org.";
        }

        // Billed 2nd Invoice org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->where('hr_apply.licence', '=', 'Granted')
            ->whereIn('registration.reg', $billed2ndOrgs)
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage=$stage1." and "."Billed 2nd Invoice Org.";
        }


        return $stage;
    }

    public static function getOrganisationHRStage($emid){
        $stage="";

        $hrFileOrgs = DB::Table('hr_apply')
                    ->pluck('hr_apply.emid');

        // Unassigned HR org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->whereNotIn('reg', $hrFileOrgs)
            ->where('license_type', '=', 'Internal')
            ->where('registration.reg', '=', $emid)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="Unassigned HR Org.";
        }

        // Assigned  HR org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->whereIn('reg', $hrFileOrgs)
            ->where('license_type', '=', 'Internal')
            ->where('registration.reg', '=', $emid)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="Assigned HR Org.";
        }

        // WIP HR org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->where('hr_apply.status', '=', 'Incomplete')
            ->where('registration.reg', '=', $emid)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="HR WIP Org.";
        }

        // HR Complete org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->where('registration.license_type', '=', 'Internal')
            ->where('hr_apply.status', '=', 'Complete')
            ->where('registration.reg', '=', $emid)
            ->orderBy('registration.id', 'desc')
            ->get();
        if(count($company)>0){
            $stage="HR Complete Org.";
        }

        return $stage;
    }

    public static function getLastBillRemarks($in_id){
        $remarks="";

        $billInfo=DB::table('billing')
            ->where('in_id', '=', $in_id)
            ->first();
        
       
        $company=DB::table('billing_remarks')
            ->select('billing_remarks.*')
            
            ->where('billing_remarks.billing_id', '=', $billInfo->id)
            ->orderBy('billing_remarks.id', 'desc')
            ->limit(1)
            ->first();

        if(!empty($company)){
            $remarks=$company->remarks;
        }
        return $remarks;
    }

    public static function getOrgWIPPaymentStatus($organisation_id){
        $stage="Unbilled 1st Invoice";


        $billed1stOrgs = DB::Table('billing')
                    ->where('bill_for', '=', 'invoice for license applied')
                    ->pluck('billing.emid');

        // Billed 1st Invoice org.
        $company=DB::table('registration')
            ->select('registration.*')
            ->where('registration.status', '=', 'active')
            ->where('registration.verify', '=', 'approved')
            ->where('registration.licence', '=', 'yes')
            ->whereIn('reg', $billed1stOrgs)
            ->where('license_type', '=', 'Internal')
            ->where('registration.id', '=', $organisation_id)
            ->orderBy('registration.id', 'desc')
            ->first();
            
        if(!empty($company)){
            $stage="Billed 1st Invoice";

            $billed1stPaid = DB::Table('billing')
                ->where('bill_for', '=', 'invoice for license applied')
                ->where('emid', '=', $company->reg)
                ->orderBy('billing.id', 'desc')
                ->first();
            if(!empty($billed1stPaid)){
                $stage=$billed1stPaid->status . ' 1st Invoice';
            }
        }



        return $stage;
    }

    /*
        * Function Name :  encrypt
        * Purpose       :  This function is use for encrypt a string.
        * Author        :  KB
        * Created Date  :             
        * Input Params  :  string $value
        * Return Value  :  string
   */

    public static function encrypt($value)
    {
        $cipher = 'AES-128-ECB'; 
        $key = \Config::get('app.key');
        return openssl_encrypt($value, $cipher, $key);
    }

    /*
        * Function Name :  decrypt
        * Purpose       :  This function is use for decrypt the encrypted string.
        * Author        :  KB
        * Created Date  :             
        * Input Params  :  string $value
        * Return Value  :  string
   */

    public static function decrypt($value)
    {
        $cipher = 'AES-128-ECB'; 
        $key = \Config::get('app.key');
        return openssl_decrypt($value, $cipher, $key);
    }

    /*
        * Function Name :  partialEmailidDisplay
        * Purpose       :  This function is use for hiding some characters of en email id.
        * Author        :  KB
        * Created Date  :             
        * Input Params  :  string $value
        * Return Value  :  string
   */

    public static function partialEmailidDisplay($email){
        $rightPartPos = strpos($email,'@');
        $leftPart = substr($email, 0, $rightPartPos);
        $displayChars = (strlen($leftPart)/2);
        if($displayChars<1){
            $displayChars = 1;
        }
        return substr($leftPart, 0, $displayChars) . '*******' . substr($email, $rightPartPos);
    }

    public static function encryptId($value)
    {
        // $hashids = new Hashids(\Config::get('app.key'));
        // return $hashids->encode($value);     
        $cipher = 'AES-128-ECB'; 
        $key = \Config::get('app.key');
        return base64_encode(openssl_encrypt($value, $cipher, $key));          
    }

    public static function decryptId($value)
    {
        // $hashids = new Hashids(\Config::get('app.key'));
        // return (count($decptid = $hashids->decode($value))? $decptid[0]: '');    
        $cipher = 'AES-128-ECB'; 
        $key = \Config::get('app.key');
        return openssl_decrypt(base64_decode($value), $cipher, $key);           
    }

    
}
