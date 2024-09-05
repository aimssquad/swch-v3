<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Exception;
use File;
use Session;
use Validator;
use App\Models\HrSupport\HrSupportFileType;
use App\Models\HrSupport\HrSupportFile;

class HrSupportController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.hr-support';
        //$this->_model       = new CompanyJobs();
    }

    public function viewdashboard(Request $request){
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['data'] = HrSupportFileType::all();
            return view($this->_routePrefix . '.dashboard',$data);
            //return View('hrsupport/dashboard', $data);
        } else {
            return redirect('/');
        }

    }

    public function supportFile($id){
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
                $data['data'] = HrSupportFile::with('type')->where('type_id', $id)->get();
                //dd($data['data']);
            return view($this->_routePrefix . '.support-file-list',$data);    
            //return View('hrsupport/support-file-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function supportFileDetails($id){

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
                $data['data'] = HrSupportFile::with('type')->where('id', $id)->first();
                $typeId =  $data['data']->type_id;
                $data['relatedFiles'] = HrSupportFile::with('type')
                                      ->where('type_id', $typeId)
                                      ->where('id', '!=', $id)
                                      ->get();
                 //dd($data['relatedFiles']);
                return view($this->_routePrefix . '.support-file-details',$data);   
                //return View('hrsupport/support-file-details', $data);
        } else {
            return redirect('/');
        }

    }




} // End Class
