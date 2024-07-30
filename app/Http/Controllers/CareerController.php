<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use Session;
use view;

class CareerController extends Controller
{
    public function viewdash($career_id)
    {
        try {

            $data['job'] = DB::table('company_job')->where('id', '=', base64_decode($career_id))->first();
            // print_r(base64_decode($career_id));die;
            return View('career/career', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }
    public function viewapp($career_id)
    {
        try {

            $data['job'] = DB::table('company_job')->where('id', '=', base64_decode($career_id))->first();

            $data['cuurenci_master'] = DB::table('currencies')->get();
            return View('career/application', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveapp(Request $request)
    {
        try {

            $ckeck_dept = DB::table('candidate')->where('job_id', $request->job_id)->where('email', $request->email)->first();
            if (!empty($ckeck_dept)) {
                Session::flash('message', 'You are Already Applied For this Post.');
                return redirect('career/application/' . base64_encode($request->job_id));
            } else {

                if ($request->has('resume')) {

                    $file = $request->file('resume');
                    
                    $extension = $request->resume->extension();
                  
                   $imageName = time() . '.' . $file->getClientOriginalExtension();
                    $paths =$file->move(public_path('/candidate_resume'), $imageName);
                    // dd($paths);
                   $path='candidate_resume'.'/'.$paths->getFilename();
                   
                }
                // if ($request->has('cover_letter')) {

                //     $file_cover_letter = $request->file('cover_letter');
                //     $extension_cover_letter = $request->cover_letter->extension();
                //     // $path_cover_letter = $request->cover_letter->store('candidate_cover_letter', 'public');


                //     $imageName = time() . '.' . $file_cover_letter->getClientOriginalExtension();
                //     $paths =$file->move(public_path('/candidate_cover_letter'), $imageName);
                //     $path_cover_letter='candidate_cover_letter'.'/'.$paths->getFilename();
                // } else {
                //     $path_cover_letter = '';
                // }
                // dd("hello");
                if ($request->dob != '') {
                    $dob = date('Y-m-d', strtotime($request->dob));
                } else {
                    $dob = '';
                }
                
               
                $data = array(
                    'job_id' => $request->job_id,
                    'job_title' => $request->job_title,

                    'name' => $request->name,
                    'gender' => $request->gender,
                    'exp_month' => $request->exp_month,
                    'skill_level' => $request->skill_level,

                    'email' => $request->email,
                    'phone' => $request->phone,
                    
                    'exp' => $request->exp,
                    'cur_or' => $request->cur_or,
                    'cur_deg' => $request->cur_deg,
                    'country' => $request->country,
                    'dob' => $dob,
                    'zip' => $request->zip,
                    'location' => $request->location,
                    'exp_sal' => trim($request->exp_sal),
                    'sal' => trim($request->sal),
                    'status' => 'Application Received',
                    'edu' => $request->edu,
                    'skill' => $request->skill,
                    'date' => date('Y-m-d H:i:s'),
                    'resume' => $path,
                    'createDate'=>date('Y-m-d'),
                    'updateDate'=>date('Y-m-d'),
                );
            //  dd($data);

                DB::table('candidate')->insert($data);

                return redirect('thank-you');

            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function appthankyou()
    {
        try {
            return View('career/thank-you');
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

}
