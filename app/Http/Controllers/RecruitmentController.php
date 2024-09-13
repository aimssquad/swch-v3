<?php

namespace App\Http\Controllers;

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
    public function viewdash()
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
                // dd($data['company_job_post_external']);
            return View('recruitment/dashboard', $data);
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
               return view('recruitment/add-new-job-list', $data);
            }else{
                $jobId=$data['oldcust']['0']->id;
                   $dt = DB::table('company_job_list')->where('id', '=',  $jobId)->get();
                if (count($dt) > 0) {
                    $data['departments'] = DB::table('company_job_list')->where('id', '=',  $jobId)->get();

                    return view('recruitment/add-new-job-list', $data);
                } else {

                    return redirect('recruitment/add-new-job-list', $data);
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
                return redirect('recruitment/job-list');

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

                return redirect('recruitment/job-list');

            }
        } else {
            return redirect('/');
        }
    }

    public function viewjobpost()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['company_job_rs'] = DB::Table('company_job')
                ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.soc')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('company_job.*', 'company_job_list.soc')
                ->get();
                // dd($data['company_job_rs']);

            return view('recruitment/job-post', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewjobpublished()
    {
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
                
             
          
            return view('recruitment/job-published', $data);
        } else {
            return redirect('/');
        }
    }

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
               
                return view('recruitment/add-new-job-post', $data);
            } else {

                $data['department_rs'] = DB::Table('company_job_list')->where('emid', '=', $Roledata->reg)->get();
                return view('recruitment/add-new-job-post', $data);
            }
        } else {
            return redirect('/');
        }
    }
    public function viewAddNewpublished()
    {
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
                    // dd($data['designation']);

                return view('recruitment/add-new-job-published', $data);
            } else {

                return view('recruitment/add-new-job-published', $data);
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
                    return redirect('recruitment/job-post');
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
                return redirect('recruitment/job-post');
            } else {
                $ckeck_dept = DB::table('company_job')->where('soc',$request->soc)->first();
                // dd($ckeck_dept);
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Job Code  Already Exists.');
                    return redirect('recruitment/job-post');
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

                return redirect('recruitment/job-post');
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
                return redirect('recruitment/job-published');
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

                return redirect('recruitment/job-published');
            }

        } else {
            return redirect('/');
        }

    }
  
    public function filterDaterange(){
     
        if (Input::has('go')) {
            $formDate = Input::get('formDate');
           
            $formdateArray=$formDate;
            $toDate = Input::get('toDate'); 
            $todateArray=$toDate;
            $data['candidate_rs']= DB::table('candidate')->whereBetween('date', [$formDate, $toDate])->get();
       
           $userlist = [];
            foreach ($data['candidate_rs'] as $user) {
                $userlist[] = 'public/'.$user->resume;
            }
           
           
            $zip = new ZipArchive();
           
            $fileName = 'zipFile.zip';
            if ($zip->open(public_path($fileName), \ZipArchive::CREATE)== TRUE)
            {
                foreach ($userlist as $key => $value){
                    $relativeName = basename($value);
                    $zip->addFile($value, $relativeName);
                }
                $zip->close();
            }

            return response()->download(public_path($fileName));
          
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
            return view('recruitment/candidate-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewcandidatedetails($candidate_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $data['job'] = DB::table('candidate')->where('id', '=', base64_decode($candidate_id))->first();

            $data['job_details'] = DB::table('candidate_history')->where('user_id', '=', base64_decode($candidate_id))->orderBy('id', 'DESC')->first();

            return View('recruitment/candidate-edit', $data);
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

            return redirect('recruitment/candidate');
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

            return view('recruitment/candidate-short-list', $data);
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

        return View('recruitment/short-edit', $data);
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

            return redirect('recruitment/short-listing');
        } else {
            return redirect('/');
        }

    }

    public function viewrejectcandidate()
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
                ->where('candidate.status', '=', 'Rejected')

                ->select('candidate.*', 'company_job.soc')
                ->get();
                // dd($data['candidate_rs']);

            return view('recruitment/candidate-reject', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewrejectcandidatedetails($reject_id)
    {
      
        if (!empty(Session::get('emp_email'))) {

            $data['job'] = DB::table('candidate')->where('id', '=', base64_decode($reject_id))->where('status', '=', 'Rejected')->first();

            $data['job_details'] = DB::table('candidate_history')->where('user_id', '=', base64_decode($reject_id))->orderBy('id', 'DESC')->first();

            return View('recruitment/reject-edit', $data);
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

            return view('recruitment/candidate-interview', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewinterviewcandidatedetails($interview_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $data['job'] = DB::table('candidate')->where('id', '=', base64_decode($interview_id))->where(function ($query) {
                $query->where('candidate.status', '=', 'Interview')
                    ->orWhere('candidate.status', '=', 'Online Screen Test')
                    ->orWhere('candidate.status', '=', 'Written Test')
                    ->orWhere('candidate.status', '=', 'Telephone Interview')
                    ->orWhere('candidate.status', '=', 'Face to Face Interview')
                    ->orWhere('candidate.status', '=', 'Job Offered');
            })
                ->first();

            $data['job_details'] = DB::table('candidate_history')->where('user_id', '=', base64_decode($interview_id))->orderBy('id', 'DESC')->first();

            return View('recruitment/interview-edit', $data);
        } else {
            return redirect('/');
        }

    }

    public function saveinterviewcandidatedetails(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $job = DB::table('candidate')->where('id', '=', $request->id)->first();
            if ($request->has('upload_sh')) {

                $file_per_doc = $request->file('upload_sh');
                $extension_per_doc = $request->upload_sh->extension();
                $path_per_doc = $request->upload_sh->store('candidate_up_doc', 'public');

            } else {

                $path_per_doc = '';

            }
            $data = array(
                'job_id' => $request->job_id,
                'job_title' => $job->job_title,
                'user_id' => $job->id,
                'name' => $job->name,
                'gender' => $job->gender,
                'exp_month' => $job->exp_month,
                'skill_level' => $job->skill_level,
                'upload_sh' => $path_per_doc,
                'email' => $job->email,
                'phone' => $job->phone,
                'cover_letter' => $job->cover_letter,
                'dob' => $job->dob,
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
                'apply' => $job->apply,
                'recruited' => $job->recruited,
                'other' => $job->other,
                'resume' => $job->resume,
                'date_up' => date('Y-m-d H:i:s'),
            );

            DB::table('candidate_history')->insert($data);
            $dataupdate = array(

                'status' => $request->status,
                'remarks' => $request->remarks,

            );
            if ($request->has('upload_sh')) {

                $file_visa_doc = $request->file('upload_sh');
                $extension_visa_doc = $request->upload_sh->extension();
                $path_visa_doc = $request->upload_sh->store('candidate_up_doc', 'public');
                $dataimgvis = array(
                    'upload_sh' => $path_visa_doc,
                );

                DB::table('candidate')->where('id', '=', $request->id)
                    ->update($dataimgvis);

            }

            $job_d = DB::table('company_job')->where('id', '=', $request->job_id)->first();

            if ($request->status == 'Rejected') {

            } else {

            }

            DB::table('candidate')->where('id', '=', $request->id)->update($dataupdate);

            Session::flash('message', 'Candidate Information Successfully Updated.');

            return redirect('recruitment/interview');
        } else {
            return redirect('/');
        }

    }

    public function viewhiredcandidate()
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
                // dd($data);
            return view('recruitment/candidate-hired', $data);
            
        } else {
            return redirect('/');
        }
    }

    public function viewhiredcandidatedetails($hired_id)
    {
        dd("hii");
        if (!empty(Session::get('emp_email'))) {
            $data['job'] = DB::table('candidate')->where('id', '=', base64_decode($hired_id))->where('status', '=', 'Hired')->first();

            $data['job_details'] = DB::table('candidate_history')->where('user_id', '=', base64_decode($hired_id))->orderBy('id', 'DESC')->first();

            return View('recruitment/hired-edit', $data);
            
        } else {
            return redirect('/');
        }

    }

    public function viewsearchcandidate()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
                // dd($Roledata->reg);
            $data['company_job_rs'] = DB::Table('company_job')
                ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.soc')
                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('company_job.*')
                ->get();
                // dd($data['company_job_rs']);

            return View('recruitment/search', $data);
        } else {
            return redirect('/');
        }

    }

    public function getsearchcandidate(Request $request)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $status = $request->status;
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            if ($request->job_id != '') {
                $data['candidate_rs'] = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)
                    ->where('company_job.id', '=', $request->job_id)
                    ->where('candidate.status', '=', $status)
                    ->whereBetween('candidate.date', [$start_date, $end_date])
                    ->select('candidate.*', 'company_job.job_code')
                    ->get();
            } else {
                $data['candidate_rs'] = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)
                    ->where('candidate.status', '=', $status)
                    ->whereBetween('candidate.date', [$start_date, $end_date])
                    ->select('candidate.*', 'company_job.job_code')
                    ->get();
            }

            $data['result'] = '';
            if ($data['candidate_rs']) {$f = 1;
                foreach ($data['candidate_rs'] as $leave_allocation) {$job_details = DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->first();

                    if (!empty($job_details)) {
                        $end = date('d/m/Y', strtotime($job_details->date));
                        $dte_end = $job_details->date;

                    } else {
                        $end = date('d/m/Y', strtotime($leave_allocation->date));
                        $dte_end = $leave_allocation->date;
                    }

                    $data['result'] .= '<tr>


													<td>' . $leave_allocation->job_code . '</td>
													<td>' . $leave_allocation->job_title . '</td>
													<td>' . $leave_allocation->name . '</td>
													<td>' . $leave_allocation->email . '</td>

													<td>' . $leave_allocation->phone . '</td>
													<td>' . $leave_allocation->status . '</td>
													<td>' . $end . '</td>


									<td>
									<a href="' . env("BASE_URL") . 'public/' . $leave_allocation->resume . '" download><i class="fas fa-download"></i></a>	</td>

						</tr>';
                    $f++;
                }
            }

            $data['job_id'] = $request->job_id;

            $data['status'] = $request->status;
            $data['start_date'] = $request->start_date;
            $email = Session::get('emp_email');

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['company_job_rs'] = DB::Table('company_job')
                ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('company_job.*')
                ->get();

            $data['end_date'] = $request->end_date;
            return view('recruitment/search', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewsoffercandidate()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['candidate_rs'] = DB::Table('candidate_offer')
                ->join('company_job', 'candidate_offer.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate_offer.status', '=', 'Hired')

                ->select('candidate_offer.*', 'company_job.soc')
                ->get();
                // dd($data['candidate_rs']);

            return view('recruitment/candidate-offer', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewsofferlattercandidate()
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['employeeslist'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where(function ($query) {
                    $query->where('candidate.status', '=', 'Hired')
                        ->orWhere('candidate.status', '=', 'Job Offered');
                })

                ->select('candidate.*', 'company_job.job_code')
                ->get();

            $data['candidate_rs'] = DB::table('candidate_offer')->join('candidate', 'candidate_offer.user_id', '=', 'candidate.id')
                ->join('company_job', 'candidate_offer.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)

                ->select('candidate_offer.*')->get();

            $userlist = array();
            foreach ($data['candidate_rs'] as $user) {
                $userlist[] = $user->user_id;
            }

            $data['employees'] = array();
            foreach ($data['employeeslist'] as $employee) {
                if (in_array($employee->id, $userlist)) {

                } else {
                    $data['employees'][] = (object) array("user_id" => $employee->id, "name" => $employee->name);
                }

            }
            $data['employeelists'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
            return view('recruitment/candidate-add-offer', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveofferlat(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $job = DB::table('candidate')->where('id', '=', $request->user_id)->first();

            $filename = $job->name . time() . '.pdf';

            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country,
                'date' => date('Y-m-d'), 'name' => $job->name, 'job_title' => $job->job_title, 'st_date' => date('Y-m-d', strtotime($request->date_jo)), 'em_name' => $job->name, 'em_pos' => $job->job_title];
            $pdf = PDF::loadView('myPDF', $datap);

            $pdf->save(public_path() . '/pdf/' . $filename);
            $data = array(
                'job_id' => $job->job_id,
                'job_title' => $job->job_title,
                'user_id' => $job->id,
                'name' => $job->name,
                'gender' => $job->gender,
                'exp_month' => $job->exp_month,
                'skill_level' => $job->skill_level,

                'email' => $job->email,
                'phone' => $job->phone,
                'resume' => $job->resume,
                'cover_letter' => $job->cover_letter,
                'exp' => $job->exp,
                'cur_or' => $job->cur_or,
                'cur_deg' => $job->cur_deg,
                'country' => $job->country,
                'zip' => $job->zip,
                'location' => $job->location,
                'exp_sal' => $job->exp_sal,
                'sal' => $job->sal,
                'status' => $job->status,
                'remarks' => $job->remarks,
                'edu' => $job->edu,
                'skill' => $job->skill,
                'date' => $job->date,
                'offered_sal' => $request->offered_sal,
                'payment_type' => $request->payment_type,

                'reportauthor' => $request->reportauthor,
                'date_jo' => date('Y-m-d', strtotime($request->date_jo)),
                'cr_date' => date('Y-m-d H:i:s'),
                'dom_pdf' => $filename,
            );

            DB::table('candidate_offer')->insert($data);

            Session::flash('message', 'Job Offer Letter Generated.');

            return redirect('recruitment/offer-letter');
        } else {
            return redirect('/');
        }

    }

    public function viewsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('candidate_offer')->where('id', '=', base64_decode($send_id))->first();
            $job_d = DB::table('company_job')->where('id', '=', $job->job_id)->first();

            $pathToFile = env("BASE_URL") . 'public/pdf/' . $job->dom_pdf;
            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'date' => $job->cr_date, 'name' => $job->name, 'job_title' => $job->job_title, 'st_date' => $job->date_jo, 'em_name' => $job->name,
                'em_pos' => $job->job_title];

            $pdf = PDF::loadView('myPDF', $datap);
            $path = '';
            $path = public_path() . '/pdf/' . $job->dom_pdf;
            $data = array('name_main' => $job->name, 'com_name' => $Roledata->com_name, 'job_title' => $job->job_title, 'date_jo' => $job->date_jo, 'Roledata' => $Roledata, 'offer' => $job, 'job_d' => $job_d);
            $toemail = $job->email;

            Mail::send('mailsend', $data, function ($message) use ($toemail, $path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Job Offer');
                $message->attach($path);
                $message->from('infoswc@skilledworkerscloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('mailsend', $data, function ($message) use ($toemail, $path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Job Offer');
                $message->attach($path);
                $message->from('infoswc@skilledworkerscloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Job Offer Letter send Successfully.');

            return redirect('recruitment/offer-letter');
        } else {
            return redirect('/');
        }

    }

    public function savesearchop(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $status = $request->status;
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            if ($request->job_id != '') {
                $candidate_rs = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)
                    ->where('company_job.id', '=', $request->job_id)
                    ->where('candidate.status', '=', $status)
                    ->whereBetween('candidate.date', [$start_date, $end_date])

                    ->select('candidate.*', 'company_job.job_code')
                    ->get();
            } else {
                $candidate_rs = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)
                    ->where('candidate.status', '=', $status)
                    ->whereBetween('candidate.date', [$start_date, $end_date])

                    ->select('candidate.*', 'company_job.job_code')
                    ->get();

            }
            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'status' => $request->status, 'candidate_rs' => $candidate_rs, 'start_date' => $start_date, 'end_date' => $end_date];

            $pdf = PDF::loadView('mypdfsearch', $datap);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('report.pdf');

            $data['result'] = '';
            if ($candidate_rs) {$f = 1;
                foreach ($candidate_rs as $leave_allocation) {$job_details = DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->first();

                    if (!empty($job_details)) {
                        $end = date('d/m/Y', strtotime($job_details->date));} else {
                        $end = date('d/m/Y', strtotime($leave_allocation->date));
                    }
                    $data['result'] .= '<tr>


													<td>' . $leave_allocation->job_code . '</td>
													<td>' . $leave_allocation->job_title . '</td>

													<td>' . $leave_allocation->name . '</td>
																										<td>' . $leave_allocation->email . '</td>
													<td>' . $leave_allocation->phone . '</td>
													<td>' . $leave_allocation->status . '</td>
													<td>' . $end . '</td>


									<td>
									<a href="' . env("BASE_URL") . 'public/' . $leave_allocation->resume . '" download><i class="fas fa-download"></i></a>	</td>

						</tr>';
                    $f++;}
            }

            $data['job_id'] = $request->job_id;

            $data['status'] = $request->status;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('recruitment/search', $data);
        } else {
            return redirect('/');
        }

    }

    public function savesearchopexcel(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $status = $request->status;
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));

            $candidate_rs = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->where('candidate.status', '=', $status)

                ->select('candidate.*', 'company_job.job_code')
                ->get();

            $customer_array[] = array('Job Code', 'Job Title', 'Candidate', 'Email', 'Contact No.', 'Status', 'Date', 'Remarks');
            foreach ($candidate_rs as $leave_allocation) {
                $job_details = DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->first();

                if (!empty($job_details)) {
                    $end = date('d/m/Y', strtotime($job_details->date));
                    $dte_end = $job_details->date;

                } else {
                    $end = date('d/m/Y', strtotime($leave_allocation->date));
                    $dte_end = $leave_allocation->date;
                }
                if ($dte_end >= $start_date && $dte_end <= $end_date) {
                    $customer_array[] = array(
                        'Job Code' => $leave_allocation->job_code,
                        'Job Title' => $leave_allocation->job_title,
                        'Candidate' => $leave_allocation->name,
                        'Email' => $leave_allocation->email,
                        'Contact No.' => $leave_allocation->phone,
                        'Status' => $leave_allocation->status,
                        'Date' => $end,
                        'Remarks' => $leave_allocation->remarks,
                    );
                }
            }

            return Excel::download(new ExcelFileExport($start_date, $end_date, $status, $Roledata->reg, $request->job_id), 'search.xlsx');

            $data['result'] = '';
            if ($candidate_rs) {$f = 1;
                foreach ($candidate_rs as $leave_allocation) {$job_details = DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->first();

                    if (!empty($job_details)) {
                        $end = date('d/m/Y', strtotime($job_details->date));} else {
                        $end = date('d/m/Y', strtotime($leave_allocation->date));
                    }
                    $data['result'] .= '<tr>


													<td>' . $leave_allocation->job_code . '</td>
													<td>' . $leave_allocation->job_title . '</td>

													<td>' . $leave_allocation->name . '</td>
																										<td>' . $leave_allocation->email . '</td>
													<td>' . $leave_allocation->phone . '</td>
													<td>' . $leave_allocation->status . '</td>
													<td>' . $end . '</td>


									<td>
									<a href="https://hrmplus.co.uk/public/' . $leave_allocation->resume . '" download><i class="fas fa-download"></i></a>	</td>

						</tr>';
                    $f++;}
            }

            $data['status'] = $request->status;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('recruitment/search', $data);

        } else {
            return redirect('/');
        }
    }

    public function viewmsgcen()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['msg_rs'] = DB::Table('recruitment_messaage_center')
                ->where('emid', '=', $Roledata->reg)
                ->orderBy('id', 'desc')
                ->get();

            return View('recruitment/msg-list', $data);
        } else {
            return redirect('/');
        }
    }
    public function addmscen()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['or_rs'] = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)

                ->select('candidate.*', 'company_job.job_code')
                ->get();

            return View('recruitment/msg-add', $data);
        } else {
            return redirect('/');
        }
    }

    public function savemscen(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $data = array(

                'emid' => $Roledata->reg,
                'employee_id' => $request->user_id,
                'subject' => $request->subject,
                'msg' => $request->msg,
                'email' => $request->email,
                'cc' => $request->cc,
                'date' => date('Y-m-d'),

            );

            DB::table('recruitment_messaage_center')->insert($data);

            $id = DB::getPdo()->lastInsertId();

            if ($request->hasFile('photos')) {
                $files = $request->file('photos');

                foreach ($request->photos as $photo) {
                    $filename = $photo->store('can_file_user', 'public');
                    $dataimf = array();
                    $dataimf = array(

                        'm_id' => $id,
                        'file' => $filename,

                    );

                    DB::table('msg_file')->insert($dataimf);

                }

            }

            $Roleempdata = DB::Table('candidate')
                ->where('id', '=', $request->user_id)
                ->first();

            if ($request->hasFile('photos')) {
                $candidate = DB::Table('msg_file')
                    ->where('m_id', '=', $id)
                    ->get();

                $path = array();
                foreach ($candidate as $photoll) {
                    $path[] = public_path() . '/' . $photoll->file;
                }

                $sub = $request->subject;
                $data = array('name' => $Roleempdata->name, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->phone,
                    'email' => $Roleempdata->email, 'msg' => $request->msg);
                $toemail = $request->email;
                Mail::send('mailormsgcenrecru', $data, function ($message) use ($toemail, $sub, $path) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ($sub);
                    foreach ($path as $filePath) {

                        $message->attach($filePath);
                    }

                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });

                if ($request->cc != '') {
                    $sub = $request->subject;
                    $data = array('name' => $Roleempdata->name, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->phone,
                        'email' => $Roleempdata->email, 'msg' => $request->msg);
                    $toemail = $request->cc;
                    Mail::send('mailormsgcenrecru', $data, function ($message) use ($toemail, $sub, $path) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ($sub);
                        foreach ($path as $filePath) {

                            $message->attach($filePath);
                        }

                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                }
            } else {
                $sub = $request->subject;
                $data = array('name' => $Roleempdata->name, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->phone,
                    'email' => $Roleempdata->email, 'msg' => $request->msg);
                $toemail = $request->email;
                Mail::send('mailormsgcenrecru', $data, function ($message) use ($toemail, $sub) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ($sub);
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });

                if ($request->cc != '') {

                    $sub = $request->subject;
                    $data = array('name' => $Roleempdata->name, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->phone,
                        'email' => $Roleempdata->email, 'msg' => $request->msg);
                    $toemail = $request->cc;
                    Mail::send('mailormsgcenrecru', $data, function ($message) use ($toemail, $sub) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ($sub);
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                }
            }

            Session::flash('message', 'Message Send Successfully .');

            return redirect('recruitment/message-centre');
        } else {
            return redirect('/');
        }
    }

    public function viewapplysendcandidatedetails($send_id)
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

            $data = array('name' => $job->name, 'pos' => $job->job_title, 'job_code' => $job_d->job_code, 'Roledata' => $Roledata, 'job' => $job_d, 'canjob' => $job);

            return View('recruitment/jobapply', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewinterviewsendcandidatedetails($send_id)
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
            $can_d = DB::table('candidate_history')->where('user_id', '=', $job->id)->where('status', '=', 'Interview')->orderBy('id', 'DESC')->first();

            $data = array('name' => $job->name, 'pos' => $job->job_title, 'job_code' => $job_d->job_code, 'status' => 'Interview',
                'date' => $can_d->date, 'from_time' => $job->from_time, 'to_time' => $job->to_time, 'place' => $job->place, 'panel' => $job->panel, 'Roledata' => $Roledata, 'job_d' => $job_d, 'can_d' => $can_d);

            return View('recruitment/interview', $data);
            dd($data);
        } else {
            return redirect('/');
        }

    }
    public function viewofferdownsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('candidate_offer')->where('id', '=', base64_decode($send_id))->first();
            $job_d = DB::table('company_job')->where('id', '=', $job->job_id)->first();

            $data = array('name_main' => $job->name, 'com_name' => $Roledata->com_name, 'job_title' => $job->job_title, 'date_jo' => $job->date_jo, 'Roledata' => $Roledata, 'offer' => $job, 'job_d' => $job_d);

            return View('recruitment/offerletter', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewsearchcandidatestatus()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['company_job_rs'] = DB::Table('company_job')
                ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.soc')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('company_job.*')
                ->get();

            return View('recruitment/search-status', $data);
        } else {
            return redirect('/');
        }

    }

    public function getsearchcandidatestatus(Request $request)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            if ($request->job_id != '') {
                $data['candidate_rs'] = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)
                    ->where('company_job.id', '=', $request->job_id)

                    ->whereBetween('candidate.date', [$start_date, $end_date])
                    ->select('candidate.*', 'company_job.job_code')
                    ->get();
            } else {
                $data['candidate_rs'] = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)

                    ->whereBetween('candidate.date', [$start_date, $end_date])
                    ->select('candidate.*', 'company_job.job_code')
                    ->get();
            }

            $data['result'] = '';
            if ($data['candidate_rs']) {$f = 1;
                foreach ($data['candidate_rs'] as $leave_allocation) {

                    $job_details = DB::table('candidate_history')->where('user_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->first();

                    if (!empty($job_details)) {
                        $job_ff = DB::table('candidate_history')
                            ->join('company_job', 'candidate_history.job_id', '=', 'company_job.id')

                            ->where('candidate_history.user_id', '=', $leave_allocation->id)
                            ->where('company_job.emid', '=', $Roledata->reg)

                            ->select('candidate_history.*', 'company_job.job_code')
                            ->orderBy('candidate_history.id', 'ASC')
                            ->get();

                        $o = 1;
                        $end = date('d/m/Y', strtotime($leave_allocation->date));
                        $dte_end = $leave_allocation->date;

                        $data['result'] .= '<tr>


													<td>' . $leave_allocation->job_code . '</td>
													<td>' . $leave_allocation->job_title . '</td>
													<td>' . $leave_allocation->name . '</td>
													<td>' . $leave_allocation->email . '</td>

													<td>' . $leave_allocation->phone . '</td>
													<td>Application Received</td>

													<td>' . $end . '</td>
															<td><a href="' . env("BASE_URL") . 'recruitment/apply-letter/' . base64_encode($leave_allocation->id) . '" target="_blank" ><i class="fas fa-paper-plane"></i></a></td>

									<td>
									<a href="' . env("BASE_URL") . 'public/' . $leave_allocation->resume . '" download><i class="fas fa-download"></i></a>	</td>

						</tr>';

                        foreach ($job_ff as $leave_allocationjj) {

                            $end = date('d/m/Y', strtotime($leave_allocationjj->date));
                            $dte_end = $leave_allocationjj->date;
                            if ($leave_allocationjj->status == 'Interview') {
                                $url = '<a href="' . env("BASE_URL") . 'recruitment/interview-letter/' . base64_encode($leave_allocation->id) . '" target="_blank" ><i class="fas fa-paper-plane"></i></a>';
                            } else {
                                $url = '';
                            }

                            $data['result'] .= '<tr>


													<td>' . $leave_allocationjj->job_code . '</td>
													<td>' . $leave_allocationjj->job_title . '</td>
													<td>' . $leave_allocationjj->name . '</td>
													<td>' . $leave_allocationjj->email . '</td>

													<td>' . $leave_allocationjj->phone . '</td>
													<td>' . $leave_allocationjj->status . '</td>
													<td>' . $end . '</td>

											<td>' . $url . '</td>
									<td>
									<a href="' . env("BASE_URL") . 'public/' . $leave_allocation->resume . '" download><i class="fas fa-download"></i></a>	</td>

						</tr>';

                            $o++;
                        }

                    } else {
                        $end = date('d/m/Y', strtotime($leave_allocation->date));
                        $dte_end = $leave_allocation->date;

                        $data['result'] .= '<tr>


													<td>' . $leave_allocation->job_code . '</td>
													<td>' . $leave_allocation->job_title . '</td>
													<td>' . $leave_allocation->name . '</td>
													<td>' . $leave_allocation->email . '</td>

													<td>' . $leave_allocation->phone . '</td>
													<td>' . $leave_allocation->status . '</td>
													<td>' . $end . '</td>
										<td><a href="' . env("BASE_URL") . 'recruitment/apply-letter/' . base64_encode($leave_allocation->id) . '" target="_blank" ><i class="fas fa-paper-plane"></i></a></td>

									<td>
									<a href="' . env("BASE_URL") . 'public/' . $leave_allocation->resume . '" download><i class="fas fa-download"></i></a>	</td>

						</tr>';
                    }

                    $f++;
                }
            }

            $data['job_id'] = $request->job_id;

            $data['start_date'] = $request->start_date;
            $email = Session::get('emp_email');

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['company_job_rs'] = DB::Table('company_job')
                ->join('company_job_list', 'company_job.soc', '=', 'company_job_list.id')

                ->where('company_job.emid', '=', $Roledata->reg)
                ->select('company_job.*')
                ->get();

            $data['end_date'] = $request->end_date;
            return view('recruitment/search-status', $data);
        } else {
            return redirect('/');
        }
    }

    public function savesearchopstatus(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            if ($request->job_id != '') {
                $candidate_rs = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)
                    ->where('company_job.id', '=', $request->job_id)

                    ->whereBetween('candidate.date', [$start_date, $end_date])
                    ->select('candidate.*', 'company_job.job_code')
                    ->get();
            } else {
                $candidate_rs = DB::Table('candidate')
                    ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                    ->where('company_job.emid', '=', $Roledata->reg)

                    ->whereBetween('candidate.date', [$start_date, $end_date])
                    ->select('candidate.*', 'company_job.job_code')
                    ->get();

            }
            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'candidate_rs' => $candidate_rs, 'start_date' => $start_date, 'end_date' => $end_date, 'reg' => $Roledata->reg];

            $pdf = PDF::loadView('mypdfsearchstatus', $datap);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('report.pdf');

            $data['result'] = '';

            $data['job_id'] = $request->job_id;

            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('recruitment/search', $data);
        } else {
            return redirect('/');
        }

    }

    public function savesearchopexcelstatus(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));

            $candidate_rs = DB::Table('candidate')
                ->join('company_job', 'candidate.job_id', '=', 'company_job.id')

                ->where('company_job.emid', '=', $Roledata->reg)

                ->select('candidate.*', 'company_job.job_code')
                ->get();

            return Excel::download(new ExcelFileExportStatus($start_date, $end_date, $Roledata->reg, $request->job_id), 'search.xlsx');

            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('recruitment/search-status', $data);

        } else {
            return redirect('/');
        }
    }

    public function viewsendcandidatedetailsjobshorting($send_id)
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

            $job_history = DB::table('candidate_history')->where('user_id', '=', base64_decode($send_id))

                ->where('status', '=', 'Interview')

                ->orderBy('id', 'desc')->first();

            //dd($job_history);

            $dataup = array('name' => $job->name, 'pos' => $job->job_title, 'job_code' => $job_d->job_code, 'status' => $job->status,
                'date' => date('Y-m-d', strtotime($job_history->date)), 'from_time' => $job->from_time, 'to_time' => $job->to_time,
                'place' => $job->place, 'panel' => $job->panel, 'Roledata' => $Roledata, 'job_d' => $job_d);

            // dd($Roledata);
            if (isset($job->email) && $job->email != '' && $job->email != null) {

                $toemail = $job->email;
                //$toemail = 'm.subhasish@gmail.com';

                Mail::send('mailjobapplyinterview', $dataup, function ($message) use ($toemail) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ('Interview Confirmation');

                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });
            }

            if (isset($Roledata->authemail) && $Roledata->authemail != '' && $Roledata->authemail != null) {

                $toemail = $Roledata->authemail;
                //$toemail = 'm.subhasish@gmail.com';

                Mail::send('mailjobapplyinterview', $dataup, function ($message) use ($toemail) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ('Interview Confirmation');

                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });
            }

            Session::flash('message', 'Job Interview  send Successfully.');

            return redirect('recruitment/interview');
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

            return redirect('recruitment/candidate');
        } else {
            return redirect('/');
        }

    }

    public function viewInterviewForms()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['recruitment_interviewforms_rs'] = DB::table('interview_forms')
                        ->select('interview_forms.*','company_job.title', DB::raw('(select count(*) from form_questions where 	form_questions.interview_form_id=interview_forms.id) as no_questions'), DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'))
                        ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                        ->where('interview_forms.emid', '=', $Roledata->reg)
                        ->get();

            return view('recruitment/interview-form-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function addInterviewForm()
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

                
            $data['joblist'] = DB::table('company_job')->where('emid', $data['Roledata']->reg)->get();
            $data['categories'] = QuestionCategory::where('common', 0)->orderBy('category_name', 'asc')->get();
        //    dd($data);

            $data['status'] = array('A' => 'Active', 'I' => 'Inactive');

            if (Input::get('id')) {
                $dt = DB::table('interview_forms')->where('id', '=', Input::get('id'))->get();
                if (count($dt) > 0) {
                    $data['interview_form'] = DB::table('interview_forms')->where('id', '=', Input::get('id'))->first();
                    $data['interview_form_capstone'] = DB::table('form_capstones')->where('interview_form_id', '=', Input::get('id'))->orderBy('form_capstones.id', 'asc')->get();
                    $data['interview_form_ca'] = DB::table('form_cognitive_abilities')->where('interview_form_id', '=', Input::get('id'))->orderBy('form_cognitive_abilities.id', 'asc')->get();

                    $data['interview_form_inuse']=DB::table('mock_interviews')->where('form_id', Input::get('id'))->whereNull('mock_interviews.deleted_at')->count();

                    //dd($data);
                    return view('recruitment/add-new-interview-form', $data);
                } else {

                    return view('recruitment/add-new-interview-form', $data);
                }

            } else {
                return view('recruitment/add-new-interview-form', $data);
            }
        } else {
            return redirect('/');
        }

    }

    public function saveInterviewForm(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

                //dd($request->all()); 

            if (Input::get('id')) {
                //dd($request->all()); 

                $interview_form = InterviewForm::find($request->id);
                $interview_form->job_id    = $request->job_id;
                $interview_form->emid    = $Roledata->reg;
                $interview_form->form_name    = $request->form_name;
                $interview_form->rating_out_off    = $request->rating_out_off;
                $interview_form->category_id    = $request->category_id;
                $interview_form->status    = $request->status;
                $interview_form->save();

                $interview_form_id=$interview_form->id;

                //if existing record removed from frontend then need to be deleted from db
                $exist_rem_cap=null;
                if(isset($request->exist_rem_cap)){
                    $exist_rem_cap=$request->exist_rem_cap;
                }
                if($exist_rem_cap!=null){
                    $exist_rem_cap=substr($exist_rem_cap,0,strlen($exist_rem_cap)-1);
                    $exist_rem_cap_arr=explode(',',$exist_rem_cap);
                    foreach($exist_rem_cap_arr as $rec){
                        $interview_form_cap_del = FormCapstone::find($rec);
                        if(!empty($interview_form_cap_del)){
                            $interview_form_cap_del->delete();
                        }
                    }
                }


                for ($i = 0; $i < count($request->capstone_name); $i++){
                    if(isset($request->capstone_id[$i]) && $request->capstone_id[$i]!=""){
                        //update
                        $interview_form_capstone = FormCapstone::find($request->capstone_id[$i]);
                        $interview_form_capstone->interview_form_id    = $interview_form_id;
                        $interview_form_capstone->capstone_name    = $request->capstone_name[$i];
                        $interview_form_capstone->weightage    = $request->weightage[$i];
                        $interview_form_capstone->save();
                    }else{
                        //add
                        $modelFC  = new FormCapstone;
                        $modelFC->interview_form_id    = $interview_form_id;
                        $modelFC->capstone_name    = $request->capstone_name[$i];
                        $modelFC->weightage    = $request->weightage[$i];
                        $modelFC->save();

                    }
                }
                //if existing record removed from frontend then need to be deleted from db
                $exist_rem_caf=null;
                if(isset($request->exist_rem_caf)){
                    $exist_rem_caf=$request->exist_rem_caf;
                }
                if($exist_rem_caf!=null){
                    $exist_rem_caf=substr($exist_rem_caf,0,strlen($exist_rem_caf)-1);
                    $exist_rem_caf_arr=explode(',',$exist_rem_caf);
                    foreach($exist_rem_caf_arr as $rec){
                        $interview_form_ca_del = FormCognitiveAbility::find($rec);
                        if(!empty($interview_form_ca_del)){
                            $interview_form_ca_del->delete();
                        }
                    }
                }

                for ($i = 0; $i < count($request->cognitive_ability_name); $i++){
                    if(isset($request->cognitive_ability_id[$i]) && $request->cognitive_ability_id[$i]!=""){
                        //update
                        $interview_form_ca = FormCognitiveAbility::find($request->cognitive_ability_id[$i]);
                        $interview_form_ca->interview_form_id    = $interview_form_id;
                        $interview_form_ca->cognitive_ability_name    = $request->cognitive_ability_name[$i];
                        $interview_form_ca->weightage    = $request->weightage_caf[$i];
                        $interview_form_ca->save();
                    }else{
                        //add
                        $modelFCA  = new FormCognitiveAbility;
                        $modelFCA->interview_form_id    = $interview_form_id;
                        $modelFCA->cognitive_ability_name    = $request->cognitive_ability_name[$i];
                        $modelFCA->weightage    = $request->weightage_caf[$i];
                        $modelFCA->save();
                    }
                }


                //dd($interview_form);

                Session::flash('message', 'Interview Form Information Successfully Updated.');
                return redirect('recruitment/interview-forms');

            } else {
                $model  = new InterviewForm;
                $model->job_id    = $request->job_id;
                $model->emid    = $Roledata->reg;
                $model->form_name    = $request->form_name;
                $model->rating_out_off    = $request->rating_out_off;
                $model->category_id    = $request->category_id;
                $model->save();

                $interview_form_id=$model->id;

                for ($i = 0; $i < count($request->capstone_name); $i++){
                    $modelFC  = new FormCapstone;
                    $modelFC->interview_form_id    = $interview_form_id;
                    $modelFC->capstone_name    = $request->capstone_name[$i];
                    $modelFC->weightage    = $request->weightage[$i];
                    $modelFC->save();
                }

                for ($i = 0; $i < count($request->cognitive_ability_name); $i++){
                    $modelFCA  = new FormCognitiveAbility;
                    $modelFCA->interview_form_id    = $interview_form_id;
                    $modelFCA->cognitive_ability_name    = $request->cognitive_ability_name[$i];
                    $modelFCA->weightage    = $request->weightage_caf[$i];
                    $modelFCA->save();
                }



                Session::flash('message', 'Interview Form Information Successfully Saved.');
                return redirect('recruitment/interview-forms');
            }
        } else {
            return redirect('/');
        }
    }

    public function addFormQuestion($form_id)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $common_categories = QuestionCategory::where('common', 1)->orderBy('category_name', 'asc')->pluck('id');
            
            $data['interview_form'] = DB::table('interview_forms')
                    ->select('interview_forms.*', DB::raw('(select title from company_job where company_job.id=interview_forms.job_id) as job_title'), DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'))
                    ->where('id', '=', $form_id)
                    ->first();

            $data['interview_form_capstone'] = DB::table('form_capstones')->where('interview_form_id', '=', $form_id)->orderBy('form_capstones.id', 'asc')->get();

            $data['interview_form_ca'] = DB::table('form_cognitive_abilities')->where('interview_form_id', '=', $form_id)->orderBy('form_cognitive_abilities.id', 'asc')->get();

            $data['questions'] = Question::where('category_id','=',$data['interview_form']->category_id)
                ->orWhereIn('category_id',$common_categories)
                ->orderBy('question', 'asc')
                ->get();
        
            $data['interview_form_question'] = DB::table('form_questions')->where('interview_form_id', '=', $form_id)->orderBy('form_questions.id', 'asc')->get();

            $data['interview_form_inuse']=DB::table('mock_interviews')->where('form_id', $form_id)->whereNull('mock_interviews.deleted_at')->count();

            $data['status'] = array('A' => 'Active', 'I' => 'Inactive');

            //dd($data['interview_form_question']);


            return view('recruitment/add-edit-form-question', $data);
        } else {
            return redirect('/');
        }

    }

    public function saveFormQuestion($form_id,Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            // echo $form_id;
            // dd($request->all()); 


            //if existing record removed from frontend then need to be deleted from db
            $exist_rem_question=null;
            // if(isset($request->exist_rem_question)){
            //     $exist_rem_question=$request->exist_rem_question;
            // }
            // if($exist_rem_question!=null){
            //     $exist_rem_question=substr($exist_rem_question,0,strlen($exist_rem_question)-1);
            //     $exist_rem_question_arr=explode(',',$exist_rem_question);
            //     foreach($exist_rem_question_arr as $rec){
            //         $interview_form_ques_del = FormQuestion::find($rec);
            //         if(!empty($interview_form_ques_del)){
            //             $interview_form_ques_del->delete();
            //         }
            //     }
            // }


            for ($i = 0; $i < count($request->question); $i++){
                if(isset($request->form_question_id[$i]) && $request->form_question_id[$i]!=""){
                    //update
                    echo($request->form_question_id[$i]);
                    $form_question = FormQuestion::find($request->form_question_id[$i]); 
                    $form_question->interview_form_id    = $form_id;
                    $form_question->form_capstone_id    = $request->capstone[$i];
                    $form_question->form_cognitive_ability_id    = $request->factor[$i];
                    $form_question->question_id    = $request->question[$i];
                    $form_question->save();
                }else{
                    //add
                    $model  = new FormQuestion;
                    $model->interview_form_id    = $form_id;
                    $model->form_capstone_id    = $request->capstone[$i];
                    $model->form_cognitive_ability_id    = $request->factor[$i];
                    $model->question_id    = $request->question[$i];
                    $model->save();

                }
            }
            //dd($interview_form);

            Session::flash('message', 'Interview Form Question Information Successfully Mapped.');
            return redirect('recruitment/interview-forms');

        } else {
            return redirect('/');
        }
    }

    public function addInterview($form_id)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $data['form_id'] = $form_id;

            $interview_form_details = DB::table('interview_forms')->where('id', '=', $form_id)->first();
            $data['interview_form_details']=$interview_form_details;

            $appearedCandidates=DB::table('mock_interviews')->where('form_id', $form_id)->whereNull('mock_interviews.deleted_at')->pluck('candidate_id');
                
            $data['joblist'] = DB::table('company_job')
                    ->where('emid', $data['Roledata']->reg)
                    ->where('id', $interview_form_details->job_id)
                    ->first();

            $data['candidates'] = DB::table('candidate')
                    ->select('candidate.*')
                    ->join('company_job','company_job.id','=','candidate.job_id')
                    ->where('company_job.emid', $data['Roledata']->reg)
                    ->where('candidate.status','!=','Application Received')
                    ->whereNotIn('candidate.id',$appearedCandidates)
                    ->get();

            
            $data['interview_form_capstone'] = DB::table('form_capstones')->where('interview_form_id', '=', $form_id)->orderBy('form_capstones.id', 'asc')->get();

            $section_ids='';
            foreach($data['interview_form_capstone'] as $section){
                $section_ids=$section_ids.$section->id.',';
            }
            $data['section_ids']=substr($section_ids,0 ,strlen($section_ids) - 1);

            $data['interview_form_ca'] = DB::table('form_cognitive_abilities')->where('interview_form_id', '=', $form_id)->orderBy('form_cognitive_abilities.id', 'asc')->get();

            $factor_ids='';
            foreach($data['interview_form_ca'] as $factor){
                $factor_ids=$factor_ids.$factor->id.',';
            }
            $data['factor_ids']=substr($factor_ids,0 ,strlen($factor_ids) - 1);

            $data['interview_form_questions'] = DB::table('form_questions')
                ->select('form_questions.*','questions.question')
                ->join('questions','questions.id','=','form_questions.question_id')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_questions.id', 'asc')
                ->get();

        //    dd($data);

            $data['status'] = array('A' => 'Active', 'I' => 'Inactive');

            return view('recruitment/add-new-mock-interview', $data);
        } else {
            return redirect('/');
        }

    }

    public function saveInterview($form_id,Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

           //dd($request->all());
            //dd($request[$request->expected_salary]);
            if (empty($request->id)) {
                $check_interview=MockInterview::where('candidate_id', '=', $request->candidate_id)->first();
                //dd(empty($check_interview));
                if(!empty($check_interview)){
                    Session::flash('error', 'Interview Already taken for the selected candidate.');
                    return redirect('recruitment/interview-forms');
                }

                $expected_salary_value =0;
                if(isset($request[$request->expected_salary])){
                    $expected_salary_value=$request[$request->expected_salary];
                }
                $work_arrangement_value =0;
                if(isset($request[$request->work_arrangement])){
                    $work_arrangement_value=$request[$request->work_arrangement];
                }

                $model  = new MockInterview;
                $model->candidate_id    = $request->candidate_id;
                $model->form_id    = $request->form_id;
                $model->job_id    = $request->job_id;
                $model->interviewer    = $request->interviewer;
                $model->interview_date    = $request->interview_date;
                $model->interview_time    = $request->interview_time;
                $model->institution    = $request->institution;
                $model->capstone_value    = $request->cap_value;
                $model->capstone_rscore    = $request->cap_rscore;
                $model->capstone_score    = $request->cap_score;
                $model->caf_value    = $request->caf_value;
                $model->caf_rscore    = $request->caf_rscore;
                $model->caf_score    = $request->caf_score;
                $model->comment    = $request->comment;

                $model->outcome    = $request->outcome;
                $model->expected_salary    = $request->expected_salary;
                $model->expected_salary_value    = $expected_salary_value;
                $model->work_arrangement     = $request->work_arrangement ;
                $model->work_arrangement_value     = $work_arrangement_value ;
                $model->expected_start_date    = $request->expected_start_date;
                $model->save();

                $interview_id=$model->id;

                // dd($model);

                $questions=DB::table('form_questions')
                    ->select('form_questions.*','questions.question')
                    ->join('questions','questions.id','=','form_questions.question_id')
                    ->where('interview_form_id', '=', $request->form_id)
                    ->orderBy('form_questions.id', 'asc')
                    ->get();

                foreach($questions as $question){
                    $model1  = new MockInterviewDetail;
                    $model1->mock_interview_id    = $interview_id;
                    $model1->form_question_id    = $question->id;
                    $model1->rating    = (isset($request['rating_'.$question->id]))? $request['rating_'.$question->id]:0;
                    $model1->comment    = (isset($request['comment_'.$question->id]))? $request['comment_'.$question->id]:'';
                    
                    $model1->save();
                        
                }
                $sections=DB::table('form_capstones')->where('interview_form_id', '=', $request->form_id)->orderBy('form_capstones.id', 'asc')->get();
                    
                foreach($sections as $section){
                    $model2  = new MockCapstoneDetail;
                    $model2->mock_interview_id    = $interview_id;
                    $model2->form_capstone_id    = $section->id;
                    $model2->capstone_value    = (isset($request['cap_value_'.$section->id]))? $request['cap_value_'.$section->id]:0;
                    $model2->capstone_rscore    = (isset($request['cap_rscore_'.$section->id]))? $request['cap_rscore_'.$section->id]:0;
                    $model2->capstone_load    = (isset($request['cap_load_'.$section->id]))? $request['cap_load_'.$section->id]:0;
                    $model2->capstone_score    = (isset($request['cap_score_'.$section->id]))? $request['cap_score_'.$section->id]:0;
                    
                    $model2->save();
                    
                }

                $factors=DB::table('form_cognitive_abilities')->where('interview_form_id', '=', $request->form_id)->orderBy('form_cognitive_abilities.id', 'asc')->get();
                    
                foreach($factors as $factor){
                    $model3  = new MockFactorDetail;
                    $model3->mock_interview_id    = $interview_id;
                    $model3->form_cognitive_ability_id    = $factor->id;
                    $model3->caf_value    = (isset($request['caf_value_'.$factor->id]))? $request['caf_value_'.$factor->id]:0;
                    $model3->caf_rscore    = (isset($request['caf_rscore_'.$factor->id]))? $request['caf_rscore_'.$factor->id]:0;
                    $model3->caf_load    = (isset($request['caf_load_'.$factor->id]))? $request['caf_load_'.$factor->id]:0;
                    $model3->caf_score    = (isset($request['caf_score_'.$factor->id]))? $request['caf_score_'.$factor->id]:0;
                    
                    $model3->save();
                    
                }
            
                Session::flash('message', 'Mock Interview Information Successfully saved.');


            }else{

            }

            return redirect('recruitment/interview-forms');
        } else {
            return redirect('/');
        }

    }

    public function viewInterviews()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->whereNull('mock_interviews.deleted_at')
                ->get();

                //$a=DB::table('mock_interviews')->get();

            // dd($data);

            return view('recruitment/interview-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewInterviewDetail($id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.id', '=', $id)
                ->whereNull('mock_interviews.deleted_at')
                ->first();

            $data['mock_interview_details'] = DB::table('mock_interview_details')
                ->where('mock_interview_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_capstone_details'] = DB::table('mock_capstone_details')
                ->where('mock_capstone_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_factor_details'] = DB::table('mock_factor_details')
                ->where('mock_factor_details.mock_interview_id', '=', $id)
                ->get();

            $form_id=$data['recruitment_interviews']->form_id;

            $interview_form_details = DB::table('interview_forms')->where('id', '=', $form_id)->first();
            $data['interview_form_details']=$interview_form_details;

            $data['interview_form_capstone'] = DB::table('form_capstones')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_capstones.id', 'asc')
                ->get();

            $section_ids='';
            foreach($data['interview_form_capstone'] as $section){
                $section_ids=$section_ids.$section->id.',';
            }
            $data['section_ids']=substr($section_ids,0 ,strlen($section_ids) - 1);
    
            $data['interview_form_ca'] = DB::table('form_cognitive_abilities')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_cognitive_abilities.id', 'asc')
                ->get();
    
            $factor_ids='';
            foreach($data['interview_form_ca'] as $factor){
                $factor_ids=$factor_ids.$factor->id.',';
            }
            $data['factor_ids']=substr($factor_ids,0 ,strlen($factor_ids) - 1);
    
            $data['interview_form_questions'] = DB::table('form_questions')
                ->select('form_questions.*','questions.question')
                ->join('questions','questions.id','=','form_questions.question_id')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_questions.id', 'asc')
                ->get();
    
            $data['candidate_info'] = DB::table('candidate')
                ->join('company_job','company_job.id','=','candidate.job_id')
                ->where('company_job.emid', $Roledata->reg)
                ->where('candidate.id','=',$data['recruitment_interviews']->candidate_id)
                ->first();

            return view('recruitment/view-mock-interview', $data);
        } else {
            return redirect('/');
        }

    }

    public function editInterviewDetail($id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['mock_interview_id']=$id;

            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.id', '=', $id)
                ->whereNull('mock_interviews.deleted_at')
                ->first();

            $data['mock_interview_details'] = DB::table('mock_interview_details')
                ->where('mock_interview_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_capstone_details'] = DB::table('mock_capstone_details')
                ->where('mock_capstone_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_factor_details'] = DB::table('mock_factor_details')
                ->where('mock_factor_details.mock_interview_id', '=', $id)
                ->get();

            $data['form_id']=$form_id=$data['recruitment_interviews']->form_id;

            $interview_form_details = DB::table('interview_forms')->where('id', '=', $form_id)->first();
            $data['interview_form_details']=$interview_form_details;

            $data['interview_form_capstone'] = DB::table('form_capstones')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_capstones.id', 'asc')
                ->get();

            $section_ids='';
            foreach($data['interview_form_capstone'] as $section){
                $section_ids=$section_ids.$section->id.',';
            }
            $data['section_ids']=substr($section_ids,0 ,strlen($section_ids) - 1);
    
            $data['interview_form_ca'] = DB::table('form_cognitive_abilities')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_cognitive_abilities.id', 'asc')
                ->get();
    
            $factor_ids='';
            foreach($data['interview_form_ca'] as $factor){
                $factor_ids=$factor_ids.$factor->id.',';
            }
            $data['factor_ids']=substr($factor_ids,0 ,strlen($factor_ids) - 1);
    
            $data['interview_form_questions'] = DB::table('form_questions')
                ->select('form_questions.*','questions.question')
                ->join('questions','questions.id','=','form_questions.question_id')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_questions.id', 'asc')
                ->get();
    
            $data['candidate_info'] = DB::table('candidate')
                ->join('company_job','company_job.id','=','candidate.job_id')
                ->where('company_job.emid', $Roledata->reg)
                ->where('candidate.id','=',$data['recruitment_interviews']->candidate_id)
                ->first();

            $appearedCandidates=DB::table('mock_interviews')->where('form_id', $form_id)->where('candidate_id','!=',$data['recruitment_interviews']->candidate_id)->whereNull('mock_interviews.deleted_at')->pluck('candidate_id');
                
            $data['joblist'] = DB::table('company_job')
                    ->where('emid', $data['Roledata']->reg)
                    ->where('id', $interview_form_details->job_id)
                    ->first();

            $data['candidates'] = DB::table('candidate')
                    ->select('candidate.*')
                    ->join('company_job','company_job.id','=','candidate.job_id')
                    ->where('company_job.emid', $data['Roledata']->reg)
                    ->where('candidate.status','!=','Application Received')
                    ->whereNotIn('candidate.id',$appearedCandidates)
                    ->get();

            // dd($data);

            return view('recruitment/edit-mock-interview', $data);
        } else {
            return redirect('/');
        }

    }

    public function updateInterviewDetail($id,Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

           
            //dd($request[$request->expected_salary]);
            if (!empty($request->id)) {
               // dd($request->all());

                $expected_salary_value =0;
                if(isset($request[$request->expected_salary])){
                    $expected_salary_value=$request[$request->expected_salary];
                }
                $work_arrangement_value =0;
                if(isset($request[$request->work_arrangement])){
                    $work_arrangement_value=$request[$request->work_arrangement];
                }

                
                $model = MockInterview::find($request->id);
                $model->candidate_id    = $request->candidate_id;
                $model->form_id    = $request->form_id;
                $model->job_id    = $request->job_id;
                $model->interviewer    = $request->interviewer;
                $model->interview_date    = $request->interview_date;
                $model->interview_time    = $request->interview_time;
                $model->institution    = $request->institution;
                $model->capstone_value    = $request->cap_value;
                $model->capstone_rscore    = $request->cap_rscore;
                $model->capstone_score    = $request->cap_score;
                $model->caf_value    = $request->caf_value;
                $model->caf_rscore    = $request->caf_rscore;
                $model->caf_score    = $request->caf_score;
                $model->comment    = $request->comment;

                $model->outcome    = $request->outcome;
                $model->expected_salary    = $request->expected_salary;
                $model->expected_salary_value    = $expected_salary_value;
                $model->work_arrangement     = $request->work_arrangement ;
                $model->work_arrangement_value     = $work_arrangement_value ;
                $model->expected_start_date    = $request->expected_start_date;
                $model->save();

                $interview_id=$request->id;

                // dd($model);
                DB::table('mock_interview_details')->where('mock_interview_details.mock_interview_id', '=', $interview_id)->delete();
                DB::table('mock_capstone_details')->where('mock_capstone_details.mock_interview_id', '=', $interview_id)->delete();
                DB::table('mock_factor_details')->where('mock_factor_details.mock_interview_id', '=', $interview_id)->delete();

                $questions=DB::table('form_questions')
                    ->select('form_questions.*','questions.question')
                    ->join('questions','questions.id','=','form_questions.question_id')
                    ->where('interview_form_id', '=', $request->form_id)
                    ->orderBy('form_questions.id', 'asc')
                    ->get();

                foreach($questions as $question){
                    $model1  = new MockInterviewDetail;
                    $model1->mock_interview_id    = $interview_id;
                    $model1->form_question_id    = $question->id;
                    $model1->rating    = (isset($request['rating_'.$question->id]))? $request['rating_'.$question->id]:0;
                    $model1->comment    = (isset($request['comment_'.$question->id]))? $request['comment_'.$question->id]:'';
                    
                    $model1->save();
                        
                }
                $sections=DB::table('form_capstones')->where('interview_form_id', '=', $request->form_id)->orderBy('form_capstones.id', 'asc')->get();
                    
                foreach($sections as $section){
                    $model2  = new MockCapstoneDetail;
                    $model2->mock_interview_id    = $interview_id;
                    $model2->form_capstone_id    = $section->id;
                    $model2->capstone_value    = (isset($request['cap_value_'.$section->id]))? $request['cap_value_'.$section->id]:0;
                    $model2->capstone_rscore    = (isset($request['cap_rscore_'.$section->id]))? $request['cap_rscore_'.$section->id]:0;
                    $model2->capstone_load    = (isset($request['cap_load_'.$section->id]))? $request['cap_load_'.$section->id]:0;
                    $model2->capstone_score    = (isset($request['cap_score_'.$section->id]))? $request['cap_score_'.$section->id]:0;
                    
                    $model2->save();
                    
                }

                $factors=DB::table('form_cognitive_abilities')->where('interview_form_id', '=', $request->form_id)->orderBy('form_cognitive_abilities.id', 'asc')->get();
                    
                foreach($factors as $factor){
                    $model3  = new MockFactorDetail;
                    $model3->mock_interview_id    = $interview_id;
                    $model3->form_cognitive_ability_id    = $factor->id;
                    $model3->caf_value    = (isset($request['caf_value_'.$factor->id]))? $request['caf_value_'.$factor->id]:0;
                    $model3->caf_rscore    = (isset($request['caf_rscore_'.$factor->id]))? $request['caf_rscore_'.$factor->id]:0;
                    $model3->caf_load    = (isset($request['caf_load_'.$factor->id]))? $request['caf_load_'.$factor->id]:0;
                    $model3->caf_score    = (isset($request['caf_score_'.$factor->id]))? $request['caf_score_'.$factor->id]:0;
                    
                    $model3->save();
                    
                }
            
                Session::flash('message', 'Mock Interview Information Successfully updated.');


            }else{

            }

            return redirect('recruitment/interviews');
        } else {
            return redirect('/');
        }

    }


    public function viewInterviewFeedback($id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['interview_id']=$id;

            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.id', '=', $id)
                ->whereNull('mock_interviews.deleted_at')
                ->first();

            $data['mock_interview_details'] = DB::table('mock_interview_details')
                ->where('mock_interview_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_capstone_details'] = DB::table('mock_capstone_details')
                ->where('mock_capstone_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_factor_details'] = DB::table('mock_factor_details')
                ->where('mock_factor_details.mock_interview_id', '=', $id)
                ->get();

            $form_id=$data['recruitment_interviews']->form_id;

            $interview_form_details = DB::table('interview_forms')->where('id', '=', $form_id)->first();
            $data['interview_form_details']=$interview_form_details;

            $data['interview_form_capstone'] = DB::table('form_capstones')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_capstones.id', 'asc')
                ->get();

            $section_ids='';
            foreach($data['interview_form_capstone'] as $section){
                $section_ids=$section_ids.$section->id.',';
            }
            $data['section_ids']=substr($section_ids,0 ,strlen($section_ids) - 1);
    
            $data['interview_form_ca'] = DB::table('form_cognitive_abilities')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_cognitive_abilities.id', 'asc')
                ->get();
    
            $factor_ids='';
            foreach($data['interview_form_ca'] as $factor){
                $factor_ids=$factor_ids.$factor->id.',';
            }
            $data['factor_ids']=substr($factor_ids,0 ,strlen($factor_ids) - 1);
    
            $data['interview_form_questions'] = DB::table('form_questions')
                ->select('form_questions.*','questions.question')
                ->join('questions','questions.id','=','form_questions.question_id')
                ->where('interview_form_id', '=', $form_id)
                ->orderBy('form_questions.id', 'asc')
                ->get();
    
            $data['candidate_info'] = DB::table('candidate')
                ->join('company_job','company_job.id','=','candidate.job_id')
                ->where('company_job.emid', $Roledata->reg)
                ->where('candidate.id','=',$data['recruitment_interviews']->candidate_id)
                ->first();

                

            //  dd($data);

            return view('recruitment/feedback-mock-interview', $data);
        } else {
            return redirect('/');
        }

    }

    public function getInterviewFeedbackReport($id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['interview_id']=$id;

            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.id', '=', $id)
                ->whereNull('mock_interviews.deleted_at')
                ->first();

            $data['candidate_info'] = DB::table('candidate')
                ->join('company_job','company_job.id','=','candidate.job_id')
                ->where('company_job.emid', $Roledata->reg)
                ->where('candidate.id','=',$data['recruitment_interviews']->candidate_id)
                ->first();


            $data['mock_interview_details'] = DB::table('mock_interview_details')
                ->where('mock_interview_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_capstone_details'] = DB::table('mock_capstone_details')
                ->select('mock_capstone_details.*','form_capstones.capstone_name')
                ->join('form_capstones','form_capstones.id','=','mock_capstone_details.form_capstone_id')
                ->where('mock_capstone_details.mock_interview_id', '=', $id)
                ->get();

            $data['mock_factor_details'] = DB::table('mock_factor_details')
                ->select('mock_factor_details.*','form_cognitive_abilities.cognitive_ability_name')
                ->join('form_cognitive_abilities','form_cognitive_abilities.id','=','mock_factor_details.form_cognitive_ability_id')
                ->where('mock_factor_details.mock_interview_id', '=', $id)
                ->get();

            $form_id=$data['recruitment_interviews']->form_id;

            //  dd($data);
            
            $pdf = PDF::loadView('recruitment/feedback-report-mock-interview', $data);

            return $pdf->download('feedback-report-mock-interview.pdf');
            // return view('recruitment/feedback-report-mock-interview', $data);
        } else {
            return redirect('/');
        }

    }

    public function saveInterviewFeedback($id,Request $request){
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = $Roledata;
            $model = MockInterview::find($request->interview_id);
            if(!$model){
                throw new Exception("No result was found for id: $request->interview_id");
            }
            //dd($request->all());
            
            $model->recommendation    = $request->recommendation;
            $model->police_verification    = $request->police_verification;
            $model->tb_test    = $request->tb_test;
            $model->training_required    = $request->training_required;
            $model->feedback_submitted    = 'Y';
            
            $model->save();
            Session::flash('message', 'Mock Interview Feedback Information Successfully saved.');
            return redirect('recruitment/interviews');
        } else {
            return redirect('/');
        }

    }

    public function deleteInterview($id){
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = $Roledata;
            //dd($id);
            $model = MockInterview::find($id);
            if(!$model){
                throw new Exception("No result was found for id: $id");
            }
            
            $model->delete();
            Session::flash('message', 'Mock Interview Information Deleted Successfully.');
            return redirect('recruitment/interviews');
        } else {
            return redirect('/');
        }

    }

    public function copyInterviewForm($form_id){
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = $Roledata;
            //dd($id);
            $interview_form = InterviewForm::find($form_id);
            
            if(!$interview_form){
                throw new Exception("No result was found for id: $form_id");
            }
            //dd($interview_form);
            $newFormName=$interview_form->form_name.'-'.date('dHmiY');
            $copy = $interview_form->replicate()->fill(
                [
                    'form_name' => $newFormName,
                ]
            );
            $copy->save();
            $new_interview_form_id = $copy->id;
            
            $form_capstones = FormCapstone::where('interview_form_id','=',$form_id)->get();
            foreach($form_capstones as $record){
               // dd($record->id);
                $form_capstone = FormCapstone::find($record->id);
                $copyfc = $form_capstone->replicate()->fill(
                    [
                        'interview_form_id' => $new_interview_form_id,
                    ]
                );
                $copyfc->save();
            }
            
            
            $form_cafs = FormCognitiveAbility::where('interview_form_id','=',$form_id)->get();
            foreach($form_cafs as $record){
                $form_caf = FormCognitiveAbility::find($record->id);
                $copyfca = $form_caf->replicate()->fill(
                    [
                        'interview_form_id' => $new_interview_form_id,
                    ]
                );
                $copyfca->save();
            }

          
            Session::flash('message', 'Interview Form Information Successfully copied.');
            return redirect('recruitment/interview-forms');
        } else {
            return redirect('/');
        }

    }

    public function viewCapstoneReport()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $intv_jobs=  DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->pluck('job_id');                   

            $data['joblist'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->whereIn('company_job.id', $intv_jobs)
                ->get();     

            $data['int_forms'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->get();   

                
            //dd($data);

            return view('recruitment/capstone-assesment-report', $data);
        } else {
            return redirect('/');
        }

    }

    public function getCapstoneReport(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $intv_jobs=  DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->pluck('job_id');                   

            $data['joblist'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->whereIn('company_job.id', $intv_jobs)
                ->get(); 

            $data['int_forms'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->get();   

            $data['interview_form_capstone'] = DB::table('form_capstones')
                ->where('interview_form_id', '=', $request->form_id)
                ->orderBy('form_capstones.id', 'asc')
                ->get();         
                
            $data['form_id'] = $request->form_id;
            $data['job_id'] = $request->job_id;

            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.job_id', '=', $request->job_id)
                ->where('mock_interviews.form_id', '=', $request->form_id)
                ->where('mock_interviews.feedback_submitted', '=', 'Y')
                ->whereNull('mock_interviews.deleted_at')
                ->get();

            // $data['mock_interview_details'] = DB::table('mock_interview_details')
            //     ->where('mock_interview_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_capstone_details'] = DB::table('mock_capstone_details')
            //     ->where('mock_capstone_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_factor_details'] = DB::table('mock_factor_details')
            //     ->where('mock_factor_details.mock_interview_id', '=', $id)
            //     ->get();


            // dd($request->all());      
                
            // dd($data);

            return view('recruitment/capstone-assesment-report', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewCaReport()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $intv_jobs=  DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->pluck('job_id');                   

            $data['joblist'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->whereIn('company_job.id', $intv_jobs)
                ->get();     

            $data['int_forms'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->get();   

                
            //dd($data);

            return view('recruitment/ca-assesment-report', $data);
        } else {
            return redirect('/');
        }

    }

    public function getCaReport(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $intv_jobs=  DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->pluck('job_id');                   

            $data['joblist'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->whereIn('company_job.id', $intv_jobs)
                ->get(); 

            $data['int_forms'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->get();   

            $data['interview_form_ca'] = DB::table('form_cognitive_abilities')
                ->where('interview_form_id', '=', $request->form_id)
                ->orderBy('form_cognitive_abilities.id', 'asc')
                ->get();         
                
            $data['form_id'] = $request->form_id;
            $data['job_id'] = $request->job_id;

            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.job_id', '=', $request->job_id)
                ->where('mock_interviews.form_id', '=', $request->form_id)
                ->where('mock_interviews.feedback_submitted', '=', 'Y')
                ->whereNull('mock_interviews.deleted_at')
                ->get();

            // $data['mock_interview_details'] = DB::table('mock_interview_details')
            //     ->where('mock_interview_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_capstone_details'] = DB::table('mock_capstone_details')
            //     ->where('mock_capstone_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_factor_details'] = DB::table('mock_factor_details')
            //     ->where('mock_factor_details.mock_interview_id', '=', $id)
            //     ->get();


            // dd($request->all());      
                
            // dd($data);

            return view('recruitment/ca-assesment-report', $data);
        } else {
            return redirect('/');
        }

    }

    public function pdfCapstoneReport(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $intv_jobs=  DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->pluck('job_id');                   

            $data['joblist'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->whereIn('company_job.id', $intv_jobs)
                ->get(); 

            $data['int_forms'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->get();   

            $data['interview_form_capstone'] = DB::table('form_capstones')
                ->where('interview_form_id', '=', $request->form_id)
                ->orderBy('form_capstones.id', 'asc')
                ->get();         
                
            $data['form_id'] = $request->form_id;
            $data['job_id'] = $request->job_id;

            $data['jobinfo'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->where('company_job.id','=', $request->job_id)
                ->first(); 

            $data['forminfo'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->where('interview_forms.id','=', $request->form_id)
                ->first();   


            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.job_id', '=', $request->job_id)
                ->where('mock_interviews.form_id', '=', $request->form_id)
                ->where('mock_interviews.feedback_submitted', '=', 'Y')
                ->whereNull('mock_interviews.deleted_at')
                ->get();

            // $data['mock_interview_details'] = DB::table('mock_interview_details')
            //     ->where('mock_interview_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_capstone_details'] = DB::table('mock_capstone_details')
            //     ->where('mock_capstone_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_factor_details'] = DB::table('mock_factor_details')
            //     ->where('mock_factor_details.mock_interview_id', '=', $id)
            //     ->get();


            // dd($request->all());      
                
            // dd($data);
            $pdf = PDF::loadView('recruitment/capstone-report-pdf', $data)->setPaper('letter', 'landscape');
            
            return $pdf->download('capstone-report-pdf.pdf');
            // return view('recruitment/capstone-report-pdf', $data);
        } else {
            return redirect('/');
        }

    }

    public function pdfCaReport(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $intv_jobs=  DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->pluck('job_id');                   

            $data['joblist'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->whereIn('company_job.id', $intv_jobs)
                ->get(); 

            $data['int_forms'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->get();   

            $data['interview_form_ca'] = DB::table('form_cognitive_abilities')
                ->where('interview_form_id', '=', $request->form_id)
                ->orderBy('form_cognitive_abilities.id', 'asc')
                ->get();         
                
            $data['form_id'] = $request->form_id;
            $data['job_id'] = $request->job_id;

            $data['jobinfo'] = DB::table('company_job')
                ->where('company_job.emid', $data['Roledata']->reg)
                ->where('company_job.id','=', $request->job_id)
                ->first(); 

            $data['forminfo'] = DB::table('interview_forms')
                ->where('interview_forms.emid', $data['Roledata']->reg)
                ->where('interview_forms.id','=', $request->form_id)
                ->first();   


            $data['recruitment_interviews'] = DB::table('mock_interviews')
                ->select(
                    'mock_interviews.*',
                    'company_job.title', 
                    DB::raw('(select count(*) from form_questions where form_questions.interview_form_id=interview_forms.id) as no_questions'), 
                    DB::raw('(select category_name from question_categories where question_categories.id=interview_forms.category_id) as category_name'),
                    'candidate.name as candidate_name',
                    'interview_forms.form_name'
                )
                ->join('interview_forms','interview_forms.id', '=', 'mock_interviews.form_id')
                ->join('company_job','company_job.id', '=', 'interview_forms.job_id')
                ->join('candidate','candidate.id', '=', 'mock_interviews.candidate_id')
                ->where('interview_forms.emid', '=', $Roledata->reg)
                ->where('mock_interviews.job_id', '=', $request->job_id)
                ->where('mock_interviews.form_id', '=', $request->form_id)
                ->where('mock_interviews.feedback_submitted', '=', 'Y')
                ->whereNull('mock_interviews.deleted_at')
                ->get();

            // $data['mock_interview_details'] = DB::table('mock_interview_details')
            //     ->where('mock_interview_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_capstone_details'] = DB::table('mock_capstone_details')
            //     ->where('mock_capstone_details.mock_interview_id', '=', $id)
            //     ->get();

            // $data['mock_factor_details'] = DB::table('mock_factor_details')
            //     ->where('mock_factor_details.mock_interview_id', '=', $id)
            //     ->get();


            // dd($request->all());      
                
            // dd($data);
            $pdf = PDF::loadView('recruitment/ca-report-pdf', $data)->setPaper('letter', 'landscape');
            
            return $pdf->download('ca-report-pdf.pdf');
            // return view('recruitment/ca-report-pdf', $data);
        } else {
            return redirect('/');
        }

    }


}//end class
