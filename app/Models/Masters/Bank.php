<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $primaryKey='id';
	protected $fillable=['id', 'bank_name', 'branch_name', 'ifsc_code', 'swift_code', 'updated_at', 'created_at','bank_status','account_number'];
    
    public static function getMastersBank()
    {
        $bankMasters = BankMaster::get();
        // print_r($bankMasters); exit;
        if ($bankMasters) {
            return $bankMasters;
        }
    }


    public static function getMasterAndBank()
    {
        $bankMasters = Bank::leftJoin('bank_masters', 'banks.bank_name', '=', 'bank_masters.id')
            ->select('bank_masters.master_bank_name', 'banks.*')
            ->get();

        //  print_r($bankMasters);die;

        return $bankMasters;
    }

    public static function getBranchMaster($emp_name){
      $bankBranch=Bank::where('bank_name',$emp_name)->get();
      return  $bankBranch;
    }
    public static function getIfcsMaster($emp_name){
        $bankBranch=Bank::where('branch_name',$emp_name)->get();
        return  $bankBranch;
      }
}
