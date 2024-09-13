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

    public function sample(){
        return view($this->_routePrefix . '.sample');
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

    public function viewcandidatedetails($candidate_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $data['job'] = DB::table('candidate')->where('id', '=', base64_decode($candidate_id))->first();

            $data['job_details'] = DB::table('candidate_history')->where('user_id', '=', base64_decode($candidate_id))->orderBy('id', 'DESC')->first();
            return view($this->_routePrefix . '.candidate-edit',$data);
            //return View('recruitment/candidate-edit', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewjoblist()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['recruitment_job_rs'] = DB::table('company_job_list')->where('emid', '=', $Roledata->reg)->get();
            return view('recruitment/job-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewAddNewJobList()
    {

        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
                
            $data['oldcust'] = DB::table('company_job_list')->where('emid', $data['Roledata']->reg)->get();
            $data['depert'] = DB::table('department')->get();
            if(count($data['oldcust'])==0){
                //dd('o');
                return view($this->_routePrefix . '.add-new-job-list');
               //return view('recruitment/add-new-job-list', $data);
            }else{
                $jobId=$data['oldcust']['0']->id;
                   $dt = DB::table('company_job_list')->where('id', '=',  $jobId)->get();
                if (count($dt) > 0) {
                    $data['departments'] = DB::table('company_job_list')->where('id', '=',  $jobId)->get();
                    //dd($data['departments']);
                    return view($this->_routePrefix . '.add-new-job-list');
                    //return view('recruitment/add-new-job-list', $data);
                } else {
                    return redirect('org-recruitment/add-new-job-list', $data);
                }
            }
            
        } else {
            return redirect('/');
        }

    }

    public function soccodess($id){
        $data=DB::table('company_job_list')
        ->where("soc",$id)
        ->get();
        echo json_encode($data);
        die;
    }
    //employeer/recruitment/add-new-job-

    public function viewAddNewJobPost(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['cuurenci_master'] = DB::table('country_new')->get();
            $data['location'] = DB::table('location_uk')->get();
            if (Input::get('id')) {
            //    dd(Input::get('id'));
                $data['designation'] = DB::Table('company_job')
                    ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.soc')

                    ->where('company_job.id', '=', Input::get('id'))
                    ->select('company_job.*')
                    ->get();

                $data['department_rs'] = DB::Table('company_job_list')->where('emid', '=', $Roledata->reg)->get();
                return view($this->_routePrefix . '.add-new-job-post',$data);
                //return view('recruitment/add-new-job-post', $data);
            } else {

                $data['department_rs'] = DB::Table('company_job_list')->where('emid', '=', $Roledata->reg)->get();
                return view($this->_routePrefix . '.add-new-job-post',$data);
                //return view('recruitment/add-new-job-post', $data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveJobListData(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
           
            $soc = strtoupper(trim($request->soc));
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $lsatdeptnmdb = DB::table('department')->orderBy('id', 'DESC')->first();
            if (empty($lsatdeptnmdb)) {
                $pid = 'D1';
            } else {
                $pid = 'D' . ($lsatdeptnmdb->id + 1);
            }

            $datadeprt = array(
                'department_name' => strtoupper($request->department),
                'emid' => $Roledata->reg,
                'department_code' => $pid,
            );

            $deptnmdb = DB::table('department')->where('department_name', '=', strtoupper($request->department))->where('emid', $Roledata->reg)->first();

            if (empty($deptnmdb)) {
                DB::table('department')->insert($datadeprt);

            }
            $deptnmdbname = DB::table('department')->where('department_name', '=', strtoupper($request->department))->where('emid', $Roledata->reg)->first();

            $lsatdeptnmdgb = DB::table('designation')->orderBy('id', 'DESC')->first();
            if (empty($lsatdeptnmdgb)) {
                $pidf = 'DE1';
            } else {
                $pidf = 'DE' . ($lsatdeptnmdgb->id + 1);
            }

            $datadesig = array(
                'department_code' => $deptnmdbname->id,
                'designation_code' => $pidf,
                'designation_name' => strtoupper($request->title),
                'emid' => $Roledata->reg,
                'designation_status' => 'active',
            );

            $check_designation = DB::table('designation')->where('department_code', $deptnmdbname->id)->where('designation_name', strtoupper($request->title))
                ->where('emid', '=', $Roledata->reg)->first();

            if (empty($check_designation)) {
                DB::table('designation')->insert($datadesig);

            }
           
            if (Input::get('id')) {

            // $ckeck_dept=DB::table('company_job_list')->where('soc', $soc)->where('id','!=', Input::get('id'))->where('emid', $Roledata ->reg)->first();
                //         if(!empty($ckeck_dept)){
                //             Session::flash('message','Soc Code  Already Exists.');
                //             return redirect('recruitment/job-list');
                //         }

                $data = array(
                    'soc' => $soc,
                    'department' => $request->department,
                    'title' => $request->title,
                    'skil_set' => $request->skil_set,
                    'des_job' => $request->des_job,
                );
                //print_r($data); exit;

                $dataInsert = DB::table('company_job_list')
                    ->where('id', Input::get('id'))
                    ->update($data);
                $ckeck_job_new = DB::table('company_job')->where('soc', Input::get('id'))->where('title', $request->title)->where('department', $request->department)->where('emid', $Roledata->reg)->first();

                if (!empty($ckeck_job_new)) {
                    $datajoblist = array(

                        'job_desc' => $request->des_job,

                    );

                    DB::table('company_job')->where('soc', Input::get('id'))->where('title', $request->title)->where('department', $request->department)->update($datajoblist);
                }

                Session::flash('message', 'Job List Information Successfully Updated.');
                return redirect('recruitment/job_list');

            } else {
                if ($request->type == 'new') {

                    $soc = $request->socnew;
                }
                if ($request->type == 'exiting') {

                    $soc = $request->socold;
                }

                $data = array(
                    'soc' => $soc,
                    'department' => $request->department,
                    'title' => $request->title,
                    'skil_set' => $request->skil_set,
                    'des_job' => $request->des_job,
                    'emid' => $Roledata->reg,

                );

                DB::table('company_job_list')->insert($data);
                Session::flash('message', 'Job List Information Successfully Saved.');

                return redirect('recruitment/job_list');

            }
        } else {
            return redirect('/');
        }
    }

    public function saveJobPostData(Request $request)
    {
       
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
           
            if (Input::get('id')) {$ckeck_dept = DB::table('company_job')->where('soc',$request->soc)->where('id', '!=', Input::get('id'))->where('emid', $Roledata->reg)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Job Code  Already Exists.');
                    return redirect('recruitment/job_posting');
                }

                $data = array(
                    'soc' => $request->soc,
                    'title' => $request->title,
                    'department' => $request->department,
                    'job_code' => strtoupper(trim($request->job_code)),
                    'job_desc' => $request->job_desc,
                    'job_type' => $request->job_type,
                    'work_min' => $request->work_min,
                    'work_max' => $request->work_max,
                    'basic_min' => $request->basic_min,
                    'basic_max' => $request->basic_max,
                    'no_vac' => $request->no_vac,
                    'job_loc' => $request->job_loc,
                    'quli' => $request->quli,
                    'skill' => $request->skill,
                    'age_min' => $request->age_min,
                    'age_max' => $request->age_max,
                    'gender' => $request->gender,
                    'role' => $request->role,
                    'author' => $request->author,
                    'desig' => $request->desig,
                    'english_pro' => $request->english_pro,
                    'other' => $request->other,
                    'post_date' => date('Y-m-d', strtotime($request->post_date)),
                    'clos_date' => date('Y-m-d', strtotime($request->clos_date)),
                    'email' => $request->email,
                    'con_num' => $request->con_num,
                    'status' => $request->status,
                    'gender_male' => $request->gender_male,
                    'working_hour' => $request->working_hour,
                    'skil_set' => $request->skil_set,
                    'time_pre' => $request->time_pre,
                );
              

                DB::table('company_job')->where('id', Input::get('id'))->update($data);
                $datajoblist = array(
                    'des_job' => $request->job_desc,
                );

                DB::table('company_job_list')->where('id', $request->soc)->update($datajoblist);
                Session::flash('message', 'Job Post Information Successfully Updated.');
                return redirect('recruitment/job_posting');
            } else {
                $ckeck_dept = DB::table('company_job')->where('soc',$request->soc)->first();
                // dd($ckeck_dept);
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Job Code  Already Exists.');
                    return redirect('recruitment/job_posting');
                }
                $last_dept = DB::table('company_job')->orderBy('id', 'DESC')->first();
               
                if (!empty($last_dept)) {
                    $l_id = $last_dept->id;
                } else {
                    $l_id = 6;
                }

                $data = array(
                    'soc' => $request->soc,

                    'department' => $request->department,
                    'title' => $request->title,
                    'job_code' => strtoupper(trim($request->job_code)),
                    'job_desc' => $request->job_desc,
                    'job_type' => $request->job_type,
                    'work_min' => $request->work_min,
                    'work_max' => $request->work_max,
                    'basic_min' => $request->basic_min,
                    'basic_max' => $request->basic_max,
                    'no_vac' => $request->no_vac,
                    'job_loc' => $request->job_loc,
                    'quli' => $request->quli,
                    'skill' => $request->skill,
                    'age_min' => $request->age_min,
                    'age_max' => $request->age_max,
                    'gender' => $request->gender,
                    'role' => $request->role,
                    'author' => $request->author,
                    'desig' => $request->desig,
                    'english_pro' => $request->english_pro,
                    'other' => $request->other,
                    'post_date' => date('Y-m-d', strtotime($request->post_date)),
                    'clos_date' => date('Y-m-d', strtotime($request->clos_date)),
                    'email' => $request->email,
                    'con_num' => $request->con_num,
                    // 'job_link' => env("BASE_URL") . 'career/' . base64_encode(($l_id)),
                    'emid' => $Roledata->reg,
                    'status' => 'Job Created',
                    'gender_male' => $request->gender_male,
                    'working_hour' => $request->working_hour,
                    'skil_set' => $request->skil_set,
                    'time_pre' => $request->time_pre,

                );
                // print_r($data);die;

               $isertId=DB::table('company_job')->insertGetId($data);
               $arrayvalu=[
                "job_link"=>env("BASE_URL") . 'career/' . base64_encode(($isertId)),
               ];
               DB::table('company_job')->where('id',$isertId)->update($arrayvalu);
                $datajoblist = array(

                    'des_job' => $request->job_desc,

                );

                DB::table('company_job_list')->where('id', $request->soc)->update($datajoblist);

                Session::flash('message', 'Job Post Information Successfully saved.');

                return redirect('recruitment/job_posting');
            }

        } else {
            return redirect('/');
        }

    }

    public function viewAddNewpublished()
    {
        //dd('kk');
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['department_rs'] = DB::Table('company_job_list')->where('emid', '=', $Roledata->reg)->get();
            if (Input::get('id')) {
                $data['designation'] = DB::Table('job_post')

                    ->where('id', '=', Input::get('id'))

                    ->get();
                return view($this->_routePrefix . '.add-new-job-published',$data);
                //return view('recruitment/add-new-job-published', $data);
            } else {
                //dd($data);
                return view($this->_routePrefix . '.add-new-job-published',$data);
            }
        } else {
            return redirect('/');
        }
    }

    public function saveJobpublishedData(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            if (Input::get('id')) {

                if (!empty($request->id_up_doc)) {

                    $tot_item_nat_edit = count($request->id_up_doc);

                    foreach ($request->id_up_doc as $valuee) {

                        if ($request->has('scren_' . $valuee)) {
                            $size = $request->file('scren_' . $valuee)->getSize();

                            $extension_doc_edit_up = $request->file('scren_' . $valuee)->extension();

                            $path_quli_doc_edit_up = $request->file('scren_' . $valuee)->store('job_post', 'public');
                            $dataimgeditup = array(
                                'scren' => $path_quli_doc_edit_up,
                            );

                            DB::table('job_post')
                                ->where('id', $valuee)
                                ->update($dataimgeditup);

                        }

                        $datauploadedit = array(

                            'url' => $request->input('url_' . $valuee),

                        );
                        DB::table('job_post')
                            ->where('id', $valuee)
                            ->update($datauploadedit);

                    }

                }

                if (!empty($request->url)) {
                    $tot_item_nat = count($request->url);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->url[$i] != '') {
                            if (!empty($request->scren[$i])) {

                                $extension_upload_doc = $request->scren[$i]->extension();
                                $path_upload_doc = $request->scren[$i]->store('job_post', 'public');

                            } else {
                                $path_upload_doc = '';
                            }

                            $data = array(
                                'job_id' => $request->job_id,
                                'title' => $request->title,
                                'emid' => $Roledata->reg,
                                'url' => $request->url[$i],

                                'scren' => $path_upload_doc,
                                'department' => $request->department,

                                'job_desc' => $request->job_desc,

                            );
                            DB::table('job_post')->insert($data);

                        }

                    }
                }

                Session::flash('message', 'Job Published Information Successfully Updated.');
                return redirect('recruitment/job_published');
            } else {
                if (!empty($request->url)) {
                    $tot_item_nat = count($request->url);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->url[$i] != '') {
                            if (!empty($request->scren[$i])) {

                                $extension_upload_doc = $request->scren[$i]->extension();
                                $path_upload_doc = $request->scren[$i]->store('job_post', 'public');

                            } else {
                                $path_upload_doc = '';
                            }

                            $data = array(
                                'job_id' => $request->job_id,
                                'title' => $request->title,
                                'emid' => $Roledata->reg,
                                'url' => $request->url[$i],

                                'scren' => $path_upload_doc,
                                'department' => $request->department,

                                'job_desc' => $request->job_desc,

                            );
                            DB::table('job_post')->insert($data);

                        }

                    }
                }
                Session::flash('message', 'Job Published Information Successfully saved.');

                return redirect('recruitment/job_published');
            }

        } else {
            return redirect('/');
        }
    }

    public  function viewcandidate()
    {
       
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
            return view($this->_routePrefix . '.candidate-list',$data);
            //return view('recruitment/candidate-list', $data);
        } else {
            return redirect('/');
        }
    }


    public function viewsendcandidatedetailsjobapplied($send_id)
    { 
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('candidate')->where('id', '=', base64_decode($send_id))->first();
            $job_d = DB::table('company_job')->where('id', '=', $job->job_id)->first();

            $data = array('name' => $job->name, 'pos' => $job->job_title, 'job_code' => $job_d->job_code, 'Roledata' => $Roledata, 'job' => $job_d);

            $toemail = $job->email;

            Mail::send('mailjob', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Confirmation of Your Application ');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;

            Mail::send('mailjob', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Confirmation of Your Application ');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Job Applied  send Successfully.');

            return redirect('org-recruitment/candidate');
        } else {
            return redirect('/');
        }

    }

    public function savecandidatedetails(Request $request)
    {

        if (!empty(Session::get('emp_email'))) {
            $job = DB::table('candidate')->where('id', '=', $request->id)->first();
            //$jobHistory = DB::table('candidate_history')->where('id', '=', $request->id)->where('email', '=', $job->email)->get();
            //dd($request->all());
            if(isset($request->status)){
                $data = array(
                    'job_id' => $request->job_id,
                    'job_title' => $job->job_title,
                    'user_id' => $job->id,
                    'name' => $job->name,
                    'gender' => $job->gender,
                    'exp_month' => $job->exp_month,
                    'skill_level' => $job->skill_level,
                    'dob' => $job->dob,
                    'email' => $job->email,
                    'phone' => $job->phone,
                    'cover_letter' => $job->cover_letter,
                    'exp' => $job->exp,
                    'cur_or' => $job->cur_or,
                    'cur_deg' => $job->cur_deg,
                    'country' => $job->country,
                    'zip' => $job->zip,
                    'location' => $job->location,
                    'exp_sal' => $job->exp_sal,
                    'sal' => $job->sal,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                    'edu' => $job->edu,
                    'skill' => $job->skill,
                    'date' => date('Y-m-d', strtotime($request->date)),
                    'date_up' => date('Y-m-d H:i:s'),
                    'apply' => $request->apply,
                    'resume' => $job->resume,
                );
    
                DB::table('candidate_history')->insert($data);
                $dataupdate = array(
                    'apply' => $request->apply,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
    
                );
                $job_d = DB::table('company_job')->where('id', '=', $request->job_id)->first();
    
                DB::table('candidate')->where('id', '=', $request->id)->update($dataupdate);
    
            }else{
                $dataupdate = array(
                   
                    'date' => $request->application_date.' '.date('H:i:s',strtotime($job->date)),
                   
    
                );
                $job_d = DB::table('company_job')->where('id', '=', $request->job_id)->first();
    
                DB::table('candidate')->where('id', '=', $request->id)->update($dataupdate);

            }

            Session::flash('message', 'Candidate Information Successfully Updated.');

            return redirect('org-recruitment/candidate');
        } else {
            return redirect('/');
        }
    }

    public function viewshortcandidate()
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
            return view($this->_routePrefix . '.candidate-short-list',$data);
            //return view('recruitment/candidate-short-list', $data);
        } else {
            return redirect('/');
        }
    }


    public function viewshortcandidatedetails($short_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $data['job'] = DB::table('candidate')->where('id', '=', base64_decode($short_id))->where(function ($query) {
                $query->where('candidate.status', '=', 'Short listed')
                    ->orWhere('candidate.status', '=', 'Hold');
            })->first();
            $data['job_details'] = DB::table('candidate_history')->where('user_id', '=', base64_decode($short_id))->orderBy('id', 'DESC')->first();
            return view($this->_routePrefix . '.short-edit',$data);
        } else {
            return redirect('/');
        }

    }

    public function saveshortcandidatedetails(Request $request)
    {

        if (!empty(Session::get('emp_email'))) {
            $job = DB::table('candidate')->where('id', '=', $request->id)->first();

            $data = array(
                'job_id' => $request->job_id,
                'job_title' => $job->job_title,
                'user_id' => $job->id,
                'name' => $job->name,
                'gender' => $job->gender,
                'exp_month' => $job->exp_month,
                'skill_level' => $job->skill_level,
                'dob' => $job->dob,
                'email' => $job->email,
                'phone' => $job->phone,
                'cover_letter' => $job->cover_letter,
                'exp' => $job->exp,
                'cur_or' => $job->cur_or,
                'cur_deg' => $job->cur_deg,
                'country' => $job->country,
                'zip' => $job->zip,
                'location' => $job->location,
                'exp_sal' => $job->exp_sal,
                'sal' => $job->sal,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'edu' => $job->edu,
                'skill' => $job->skill,
                'date' => date('Y-m-d', strtotime($request->date)),
                'from_time' => $request->from_time,
                'place' => $request->place,
                'to_time' => $request->to_time,
                'panel' => $request->panel,
                'recruited' => $request->recruited,
                'other' => $request->other,
                'apply' => $job->apply,
                'date_up' => date('Y-m-d H:i:s'),
                'resume' => $job->resume,
            );

            DB::table('candidate_history')->insert($data);
            $dataupdate = array(
                'recruited' => $request->recruited,
                'other' => $request->other,
                'status' => $request->status,
                'from_time' => $request->from_time,
                'place' => $request->place,
                'to_time' => $request->to_time,
                'panel' => $request->panel,
                'remarks' => $request->remarks,

            );
            DB::table('candidate')->where('id', '=', $request->id)->update($dataupdate);
            $job_d = DB::table('company_job')->where('id', '=', $request->job_id)->first();

            if ($request->status != 'Interview') {

            }
            if ($request->status == 'Interview') {

            }

            Session::flash('message', 'Candidate Information Successfully Updated.');

            return redirect('org-recruitment/short-listing');
        } else {
            return redirect('/');
        }

    }

    public function viewinterviewcandidate()
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
                    $query->where('candidate.status', '=', 'Interview')
                        ->orWhere('candidate.status', '=', 'Online Screen Test')
                        ->orWhere('candidate.status', '=', 'Written Test')
                        ->orWhere('candidate.status', '=', 'Telephone Interview')
                        ->orWhere('candidate.status', '=', 'Face to Face Interview')
                        ->orWhere('candidate.status', '=', 'Job Offered');
                })

                ->select('candidate.*', 'company_job.soc')
                ->get();
            return view($this->_routePrefix . '.candidate-interview',$data);
            //return view('recruitment/candidate-interview', $data);
        } else {
            return redirect('/');
        }
    }

    


} // End Class
//return view($this->_routePrefix . '.sample');
