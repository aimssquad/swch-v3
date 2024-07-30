<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use Mail;
use PDF;
use Session;
use view;
use ZipArchive;
use File;

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
    public function jobList(Request $request){

        return view($this->_routePrefix . '.job-list');
    }
    public function jobPosting(Request $request){
        return view($this->_routePrefix . '.job-posting');
    }
    public function jobPublished(Request $request){
        return view($this->_routePrefix . '.job-published');
    }

    public function jobApplied(Request $request){
        return view($this->_routePrefix . '.job-applied');
    }
    public function shortListing(Request $request){
        return view($this->_routePrefix . '.short-listing');
    }
    public function interview(Request $request){
        return view($this->_routePrefix . '.interview');
    }
    public function hired(Request $request){
        return view($this->_routePrefix . '.hired');
    }
    public function offerLetter(Request $request){
        return view($this->_routePrefix . '.offer-letter');
    }
    public function rejected(Request $request){
        return view($this->_routePrefix . '.rejected');
    }

}
