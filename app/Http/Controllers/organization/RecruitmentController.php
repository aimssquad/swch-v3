<?php

namespace App\Http\Controllers\organization;
use App\Http\Controllers\Controller;
use App\Exports\ExcelFileExport;
use App\Exports\ExcelFileExportStatus;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
// use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request as Input;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use PDF;
use Session;
use view;
use ZipArchive;
use File;

use App\InterviewForm;
use App\FormCapstone;
use App\FormCognitiveAbility;
use App\FormQuestion;
use App\QuestionCategory;
use App\Question;
use App\MockInterview;
use App\MockFactorDetail;
use App\MockCapstoneDetail;
use App\MockInterviewDetail;
use App\Models\candidate;
use App\Models\CandidateOffer;
use App\Models\CompanyJobs;
use App\Models\job_post;
use App\Models\Registration;

class RecruitmentController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.recruitment';
        $this->_model       = new CompanyJobs();
    }

    public function dashboard(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $Roledata = Registration::where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
                
            $data['Roledata'] = Registration::where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
               
            $data['candidate_job'] = candidate::join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('candidate.*', 'company_job.job_code')
                ->get();
              
            $data['candidate_offer'] = CandidateOffer::join('company_job', 'candidate_offer.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate_offer.status', '=', 'Hired')

                ->select('candidate_offer.*', 'company_job.job_code')
                ->orderBy('candidate_offer.id', 'DESC')
                ->get();
               
            $data['candidate_short'] = candidate::join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)

                ->where(function ($query) {
                    $query->where('candidate.status', '=', 'Short listed')
                        ->orWhere('candidate.status', '=', 'Hold');
                })
                ->select('candidate.*', 'company_job.job_code')
                ->get();
                

            $data['candidate_rej'] = candidate::join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate.status', '=', 'Rejected')

                ->select('candidate.*', 'company_job.job_code')
                ->get();
              
            $data['candidate_hired'] = candidate::join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate.status', '=', 'Hired')

                ->select('candidate.*', 'company_job.job_code')
                ->get();
               
            $data['candidate_interview'] =candidate::join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where(function ($query) {
                    $query->where('candidate.status', '=', 'Interview')
                        ->orWhere('candidate.status', '=', 'Online Screen Test')
                        ->orWhere('candidate.status', '=', 'Written Test')
                        ->orWhere('candidate.status', '=', 'Telephone Interview')
                        ->orWhere('candidate.status', '=', 'Face to Face Interview')
                        ->orWhere('candidate.status', '=', 'Job Offered');
                })

                ->select('candidate.*', 'company_job.job_code')
                ->get();
               
            $data['company_job_post_internal'] = CompanyJobs::join('company_job_list', 'company_job_list.id', '=', 'company_job.soc')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('company_job.*', 'company_job_list.soc')
                ->get();
            $data['company_job_post_external'] = job_post::join('company_job_list', 'company_job_list.id', '=', 'job_post.job_id')
                ->where('job_post.emid', '=', $Roledata->reg)
                ->select('job_post.*', 'company_job_list.soc')
                // ->groupBy('job_post.title')
                // ->toSql()
                ->get();
                // dd($data);

            $data['company_job_rs'] = DB::Table('company_job')
            ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.soc')
            ->where('company_job.emid', '=', $Roledata->reg)
            ->count();
            // dd($data['company_job_rs']);
            $data['applied_candidate_count'] = DB::Table('candidate')
            ->join('company_job', 'candidate.job_id', '=', 'company_job.id')
            // ->join('company_job_list', 'company_job.id', '=', 'company_job_list.id')

            ->where('company_job.emid', '=', $Roledata->reg)
            ->select('candidate.*', 'company_job.soc')
            ->count();
            // dd($data['applied_candidate_count']);

            $data['shortlisted_count'] = DB::Table('candidate')
            ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

            ->where('company_job.emid', '=', $Roledata->reg)
            ->where(function ($query) {
                $query->where('candidate.status', '=', 'Short listed')
                    ->orWhere('candidate.status', '=', 'Hold');
            })
            ->select('candidate.*', 'company_job.soc')
            ->count();
            // dd($data['shortlisted_count']);

            $data['hired_count'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate.status', '=', 'Hired')

                ->select('candidate.*', 'company_job.soc')
                ->count();

                $data['rejected_count'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate.status', '=', 'Rejected')

                ->select('candidate.*', 'company_job.soc')
                ->count();

                $data['interview_count'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where(function ($query) {
                    $query->where('candidate.status', '=', 'Interview')
                        ->orWhere('candidate.status', '=', 'Online Screen Test')
                        ->orWhere('candidate.status', '=', 'Written Test')
                        ->orWhere('candidate.status', '=', 'Telephone Interview')
                        ->orWhere('candidate.status', '=', 'Face to Face Interview')
                        ->orWhere('candidate.status', '=', 'Job Offered');
                })

                ->select('candidate.*', 'company_job.soc')
                ->count();
            
            $data['company_job_count'] = DB::Table('job_post')
            ->where('emid', '=', $Roledata->reg)
            ->count();

            // return View('recruitment/dashboard', $data);
            return view($this->_routePrefix . '.dashboard',$data);
        } else {
            return redirect('/');
        }
    }

    // public function appliedjob(Request $request){
    //     if (!empty(Session::get('emp_email'))) {
    //         $email = Session::get('emp_email');    
    //         $data['Roledata'] = Registration::where('status', '=', 'active')
    //             ->where('email', '=', $email)
    //             ->first();
    //         $data['recruitment_job_rs'] = DB::table('company_job_list')->where('emid', '=', $data['Roledata']->reg)->get();
    //         //dd($data);
    //         return view($this->_routePrefix . '.job-applied');
    //     } else {
    //         return redirect('/');
    //     }
    // }


    public function jobList(Request $request){ 
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');    
            $data['Roledata'] = Registration::where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['recruitment_job_rs'] = DB::table('company_job_list')->where('emid', '=', $data['Roledata']->reg)->get();
            //dd($data);
            return view($this->_routePrefix . '.job-list',$data);
        } else {
            return redirect('/');
        }
    }

    public function jobPosting(Request $request){
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            //dd($email);
            $Roledata = Registration::where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = Registration::where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['company_job_rs'] = DB::Table('company_job')
                ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.soc')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('company_job.*', 'company_job_list.soc')
                ->get();
            return view($this->_routePrefix . '.job-posting',$data);
        } else {
            return redirect('/');
        }
    }
    // public function jobList(Request $request){

    //     return view($this->_routePrefix . '.job-list');
    // }
    // public function jobPosting(Request $request){
    //     return view($this->_routePrefix . '.job-posting');
    // }
    // public function jobPublished(Request $request){
    //     return view($this->_routePrefix . '.job-published');
    // }

    public function jobPublished(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['company_job_rs'] = DB::Table('job_post')

                ->where('emid', '=', $Roledata->reg)
                ->get();

            // dd($data['company_job_rs']);              
             
          
            // return view('recruitment/job_published', $data);
        return view($this->_routePrefix . '.job_published',$data);
        } else {
            return redirect('/');
        }
    }

    // public function jobApplied(Request $request){
    //     return view($this->_routePrefix . '.job-applied');
    // }

    public function jobApplied(Request $request) {
       
        if (!empty(Session::get('emp_email'))) {
           
            if (Input::has('go')) {
                $formDate = Input::get('formDate');
               
                $formdateArray=$formDate;
                $toDate = Input::get('toDate'); 
                $check=Input::get('checklist');
                $toCheck=$check;
                $todateArray=$toDate;
                $data['candidate_rs']= DB::table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')
                ->whereBetween('date', [$formDate, $toDate])->get();
                
            
            }else{
           
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')
    
                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
    
                    ->where('email', '=', $email)
                    ->first();
    
                $data['candidate_rs'] = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')
                    // ->join('company_job_list', 'company_job.id', '=', 'company_job_list.id')
    
                    ->where('company_job.emid', '=', $Roledata->reg)
                    ->select('candidate.*', 'company_job.soc')
                    ->get();
                    // dd($data['candidate_rs']);
            }
            // return view('recruitment/candidate-list', $data);
            // dd($data['candidate_rs']);
            return view($this->_routePrefix . '.job-applied',$data);
        } else {
            return redirect('/');
        }
    }
    // public function shortListing(Request $request){
    //     return view($this->_routePrefix . '.short-listing');
    // }

    public function shortListing(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['candidate_rs'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where(function ($query) {
                    $query->where('candidate.status', '=', 'Short listed')
                        ->orWhere('candidate.status', '=', 'Hold');
                })
                ->select('candidate.*', 'company_job.soc')
                ->get();
                // dd($data['candidate_rs']);

            // return view('recruitment/candidate-short-list', $data);
            return view($this->_routePrefix . '.short-listing', $data);
        } else {
            return redirect('/');
        }
    }

    // public function interview(Request $request){
    //     return view($this->_routePrefix . '.interview_result');
    // }

    public function interview(Request $request){
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['candidate_rs'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where(function ($query) {
                    $query->where('candidate.status', '=', 'Interview')
                        ->orWhere('candidate.status', '=', 'Online Screen Test')
                        ->orWhere('candidate.status', '=', 'Written Test')
                        ->orWhere('candidate.status', '=', 'Telephone Interview')
                        ->orWhere('candidate.status', '=', 'Face to Face Interview')
                        ->orWhere('candidate.status', '=', 'Job Offered');
                })

                ->select('candidate.*', 'company_job.soc')
                ->get();

            // return view('recruitment/candidate-interview', $data);
            // dd($data['candidate_rs']);
            return view($this->_routePrefix . '.interview_result',$data);
        } else {
            return redirect('/');
        }
    }

    // public function hired(Request $request){
    //     return view($this->_routePrefix . '.hired_list');
    // }
    public function hired(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['candidate_rs'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate.status', '=', 'Hired')

                ->select('candidate.*', 'company_job.soc')
                ->get();
                // dd($data['candidate_rs']);
            // return view('recruitment/candidate-hired', $data);
        return view($this->_routePrefix . '.hired_list',$data);

            
        } else {
            return redirect('/');
        }
    }

    public function offerLetter(Request $request){
        return view($this->_routePrefix . '.offer-letter');
    }
    // public function rejected(Request $request){
    //     return view($this->_routePrefix . '.rejected');
    // }

    public function rejected(Request $request){

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['candidate_rs'] = DB::Table('candidate')
            ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

            ->where('company_job.emid', '=', $Roledata->reg)
            ->where('candidate.status', '=', 'Rejected')

            ->select('candidate.*', 'company_job.soc')
            ->get();
            // dd($data['candidate_rs']);

            return view($this->_routePrefix . '.rejected',$data);
        } else {
            return redirect('/');
        }
    }

    public function viewCandidateDetails($candidate_id){
        if (!empty(Session::get('emp_email'))) {
            $data['job'] = DB::table('candidate')->where('id', '=', base64_decode($candidate_id))->first();

            $data['job_details'] = DB::table('candidate_history')->where('user_id', '=', base64_decode($candidate_id))->orderBy('id', 'DESC')->first();

            return View('recruitment/candidate-edit', $data);
            return view($this->_routePrefix . '.offer-letter');
        } else {
            return redirect('/');
        }
    }
    

}
