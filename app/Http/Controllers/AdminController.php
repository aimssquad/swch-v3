<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileExportApplicationStatus;
use App\Exports\ExcelFileExportAwardgrant;
use App\Exports\ExcelFileExportBillReport;
use App\Exports\ExcelFileExportBillSearch;
use App\Exports\ExcelFileExportComplain;
use App\Exports\ExcelFileExportCosGrant;
use App\Exports\ExcelFileExportCosRequest;
use App\Exports\ExcelFileExportHomeOffice;
use App\Exports\ExcelFileExportLagTime;
use App\Exports\ExcelFileExportLicence;
use App\Exports\ExcelFileExportOrganEmployee;
use App\Exports\ExcelFileExportOrganisation;
use App\Exports\ExcelFileExportSubscription;
use App\Exports\ExcelFileExportHrReply;
use App\Traits\GeneralMethods;
use Carbon\Carbon;
use DB;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use PDF;
use Session;
use Validator;
use view;
use App\InterviewPostion;
use App\InterviewQuestion;
use App\InterviewCandidate;
use App\PreMockInterview;
use App\PreMockInterviewDetail;
use App\PreMockCapstoneDetail;

use App\QuestionCategory;
use App\Question;
use App\BillingRemark;
use App\Models\fileManager;
use App\Models\UserModel;

class AdminController extends Controller
{
    use GeneralMethods;

    public function index()
    {
        try {

            return view('admin/index');

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addadddress()
    {
        try {

            return view('admin/address');
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function Dashboard(Request $request)
    {

        try {
            //dd(Session::all());
            //echo $this->addAdminLog(1, 'Dashboard visited.');

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $usersu_type = Session::get('usersu_type');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                 //dd($data);

                if ($usersu_type == 'admin' || $usersu_type == 'user') {

                    $assignedOrgs = DB::Table('role_authorization_admin_organ')
                        ->whereNotNull('role_authorization_admin_organ.module_name')
                        ->pluck('role_authorization_admin_organ.module_name');

                    $billed1stOrgs = DB::Table('billing')
                        ->where('bill_for', '=', 'invoice for license applied')
                        ->where('status', '<>', 'cancel')
                        ->pluck('billing.emid');

                    $hrFileOrgs = DB::Table('hr_apply')
                        ->pluck('hr_apply.emid');

                    $allLicHr = DB::Table('hr_apply')
                        ->where(function ($query) {
                            $query->where('hr_apply.licence', '=', 'Refused')
                                ->orWhere('hr_apply.licence', '=', 'Granted')
                                ->orWhere('hr_apply.licence', '=', 'Rejected');
                        })
                        ->distinct()
                        ->pluck('hr_apply.emid');

                    $billed2ndOrgs = DB::Table('billing')
                        ->where('bill_for', '=', 'invoice for license granted')
                        ->where('status', '<>', 'cancel')
                        ->pluck('billing.emid');

                    $licensedOrg = DB::Table('registration')
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->where('license_type', '=', 'Internal')
                        ->pluck('registration.reg');

                    $recruitment1stbillOrg = DB::Table('billing')
                        ->where('bill_for', '=', 'first invoice recruitment service')
                        ->where('status', '<>', 'cancel')
                        ->pluck('billing.emid');

                    $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                        ->where('recruitment_file_emp.status', '=', 'Hired')
                        ->pluck('recruitment_file_emp.emid');

                    $recruitmentOrg = DB::Table('recruitment_file_emp')
                    //->where('recruitment_file_emp.status', '=', 'Hired')
                        ->pluck('recruitment_file_emp.emid');

                    $cosGrantedOrg = DB::Table('cos_apply_emp')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->pluck('cos_apply_emp.emid');

                    $cosInactiveId = DB::Table('cos_apply_emp')
                        ->where('cos_apply_emp.status', '=', 'Inactive')
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->pluck('cos_apply_emp.id');

                    $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->pluck('cos_apply_emp.emid');

                    $recruitment2ndbillOrg = DB::Table('billing')
                        ->where('bill_for', '=', 'second invoice visa service')
                        ->where('status', '<>', 'cancel')
                        ->pluck('billing.emid');



                    if (isset($start_date) && isset($end_date)) {

                        $data['or_active'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                        // ->where('verify', '=', 'not approved')
                        // ->where('licence', '=', 'no')
                            ->whereBetween(DB::raw("(DATE(registration.created_at))"), [$request->start_date, $request->end_date])
                            ->get();



                        $data['or_notassigned'] = DB::Table('registration')
                            ->whereNotIn('registration.reg', $assignedOrgs)
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'not approved')
                            ->where('registration.licence', '=', 'no')
                            ->whereBetween(DB::raw("(DATE(registration.created_at))"), [$request->start_date, $request->end_date])
                            ->get();

                        $data['or_assigned'] = DB::Table('registration')
                            ->whereIn('registration.reg', $assignedOrgs)
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'not approved')
                            ->where('registration.licence', '=', 'no')
                            ->whereBetween(DB::raw("(SELECT max(`created_at`) FROM `role_authorization_admin_organ` WHERE `module_name` LIKE  `registration`.`reg`)"), [$request->start_date, $request->end_date])
                            ->get();

                        $data['or_verify'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'no')
                            ->whereBetween(DB::raw("(DATE(registration.verified_on))"), [$request->start_date, $request->end_date])
                            ->get();

                        $data['or_lince'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                        //->whereIn('registration.reg', $assignedOrgs)
                        //->whereBetween('updated_at', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->get();

                        $data['or_lince_internal'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->where('license_type', '=', 'Internal')
                        //->whereIn('registration.reg', $assignedOrgs)
                        //->whereBetween('updated_at', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->get();

                        $data['or_lince_external'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->where('license_type', '=', 'External')
                        // ->whereIn('registration.reg', $assignedOrgs)
                        //->whereBetween('updated_at', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->get();

                        $data['unbill_first_inv_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->whereNotIn('reg', $billed1stOrgs)
                            ->where('license_type', '=', 'Internal')
                        //->whereBetween('updated_at', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->get();

                        $data['bill_first_inv_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            //->where('licence', '=', 'yes')
                            ->whereIn('reg', $billed1stOrgs)
                            ->where('license_type', '=', 'Internal')
                        //->whereBetween('updated_at', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license applied' and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->get();

                        //dd($data['bill_first_inv_org']);

                        $data['unassigned_hr_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->whereNotIn('reg', $hrFileOrgs)
                            ->where('license_type', '=', 'Internal')
                        //->whereBetween('updated_at', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->get();

                        $data['assigned_hr_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->whereIn('reg', $hrFileOrgs)
                            ->where('license_type', '=', 'Internal')
                            ->whereBetween(DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])

                            ->get();

                        $data['wip_hrfile_internal'] = DB::Table('registration')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                            ->where('hr_apply.status', '=', 'Incomplete')
                        //->where('hr_apply.licence', '=', 'Pending Decision')
                            ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->distinct()
                            ->get();

                        $data['complete_hrfile_internal'] = DB::Table('registration')
                        //->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                            ->where('hr_apply.status', '=', 'Complete')
                            //->whereNotIn('registration.reg', $allLicHr)

                            ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->distinct()
                            ->get();

                        $data['license_granted_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Granted')
                            ->whereBetween(DB::raw("(SELECT max(`grant_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->distinct()
                            ->get();

                        $data['license_rejected_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Rejected')
                            ->whereBetween(DB::raw("(SELECT max(`reject_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->distinct()
                            ->get();

                        $data['license_refused_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Refused')
                            ->whereBetween(DB::raw("(SELECT max(`refused_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->distinct()
                            ->get();

                        $data['license_pd_hrfile_internal'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->where('license_type', '=', 'Internal')
                        //->whereBetween('registration.updated_at', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->whereNotIn('registration.reg', $allLicHr)
                            ->get();

                        $data['second_unbilled_invoice_license'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Granted')
                            ->whereNotIn('registration.reg', $billed2ndOrgs)
                            ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                            ->distinct()
                            ->get();

                        $data['second_billed_invoice_license'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Granted')
                            ->whereIn('registration.reg', $billed2ndOrgs)
                            ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license granted' and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                            ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_assigned_rs'] = DB::Table('recruitment_file_apply')
                            ->orderBy('recruitment_file_apply.id', 'desc')
                            ->whereIn('recruitment_file_apply.emid', $licensedOrg)
                            //->whereBetween('recruitment_file_apply.date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(recruitment_file_apply.date))"), [$request->start_date, $request->end_date])
                            ->distinct()
                            ->get();

                        $data['recruitementfile_request_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                            ->where('registration.status', '=', 'active')
                        // ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            //->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(recruitment_file_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_pending_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                            ->where('registration.status', '=', 'active')

                        //  ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->whereNull('recruitment_file_emp.status')
                            //->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(recruitment_file_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_ongoing_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                            ->where('registration.status', '=', 'active')

                        //  ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
                           // ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(recruitment_file_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_hired_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->where('recruitment_file_emp.status', '=', 'Hired')
                            ->where('registration.status', '=', 'active')
                           // ->whereBetween('recruitment_file_emp.candidate_hired_date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(recruitment_file_emp.candidate_hired_date))"), [$request->start_date, $request->end_date])
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_unbilled_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                            ->where('registration.status', '=', 'active')

                            ->where('recruitment_file_emp.status', '=', 'Hired')
                            ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                        //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                        //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                            //->whereBetween('recruitment_file_emp.candidate_hired_date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(recruitment_file_emp.candidate_hired_date))"), [$request->start_date, $request->end_date])
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_billed_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                            ->where('registration.status', '=', 'active')

                            ->where('recruitment_file_emp.status', '=', 'Hired')
                            ->where('recruitment_file_emp.billed_first_invoice', '=', 'Yes')
                        // ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->whereIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        //->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='first invoice recruitment service' and `emid` LIKE  `recruitment_file_emp`.`emid`)"), [$start_date, $end_date])
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_unassigned_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->whereNull('cos_apply_emp.employee_id')
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.date))"), [$request->start_date, $request->end_date])
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_assigned_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->whereNotNull('cos_apply_emp.employee_id')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_pending_rs'] = DB::Table('cos_apply_emp')
                            ->whereNull('cos_apply_emp.status')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->whereNotNull('cos_apply_emp.employee_id')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_granted_rs'] = DB::Table('cos_apply_emp')
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->where(function ($query) {

                                $query->whereNull('cos_apply_emp.cos_assigned')
                                    ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                            })
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_granted_unassigned_rs'] = DB::Table('cos_apply_emp')
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                           // ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->where(function ($query) {

                                $query->whereNull('cos_apply_emp.cos_assigned')
                                    ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                            })
                        //->whereNull('cos_apply_emp.cos_assigned_date')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_granted_assigned_rs'] = DB::Table('cos_apply_emp')
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                            //->whereBetween('cos_apply_emp.cos_assigned_date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.cos_assigned_date))"), [$request->start_date, $request->end_date])
                        //->whereNotNull('cos_apply_emp.cos_assigned_date')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_rejected_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.status', '=', 'Rejected')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cosfile_unbilled_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        //->whereNotIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                            ->where('cos_apply_emp.billed_second_invoice', '=', 'No')
                            //->whereBetween('cos_apply_emp.cos_assigned_date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.cos_assigned_date))"), [$request->start_date, $request->end_date])
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cosfile_billed_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                            ->whereIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                            ->where('cos_apply_emp.billed_second_invoice', '=', 'Yes')
                           // ->whereBetween('cos_apply_emp.cos_assigned_date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(cos_apply_emp.cos_assigned_date))"), [$request->start_date, $request->end_date])
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_unassigned_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNull('visa_file_emp.employee_id')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            //->whereBetween('visa_file_emp.date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(visa_file_emp.date))"), [$request->start_date, $request->end_date])
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_assigned_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNotNull('visa_file_emp.employee_id')
                            ->whereNull('visa_file_emp.status')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            //->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(visa_file_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->where(function ($query) {

                                $query->whereNull('visa_file_emp.visa_application_submitted')
                                    ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                            })
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_pending_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNull('visa_file_emp.status')
                            ->whereNotNull('visa_file_emp.employee_id')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->where(function ($query) {

                                $query->whereNull('visa_file_emp.visa_application_submitted')
                                    ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                            })
                            //->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(visa_file_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_submitted_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNull('visa_file_emp.status')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->where('visa_file_emp.visa_application_submitted', '=', 'Yes')
                            //->whereBetween('visa_file_emp.visa_application_submit_date', [$start_date, $end_date])
                            ->whereBetween(DB::raw("(DATE(visa_file_emp.visa_application_submit_date))"), [$request->start_date, $request->end_date])
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_granted_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->where('visa_file_emp.status', '=', 'Granted')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->whereBetween('visa_file_emp.visa_granted_date', [$start_date, $end_date])
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_rejected_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->where('visa_file_emp.status', '=', 'Rejected')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                    } else {

                        $data['or_active'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                        // ->where('verify', '=', 'not approved')
                        // ->where('licence', '=', 'no')
                            ->get();

                        $data['or_notassigned'] = DB::Table('registration')
                            ->whereNotIn('registration.reg', $assignedOrgs)
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'not approved')
                            ->where('registration.licence', '=', 'no')
                            ->get();

                        $data['or_assigned'] = DB::Table('registration')
                            ->whereIn('registration.reg', $assignedOrgs)
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'not approved')
                            ->where('registration.licence', '=', 'no')
                            ->get();

                        $data['or_verify'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'no')
                            ->get();

                        $data['or_lince'] = DB::Table('registration')
                        //->whereIn('registration.reg', $assignedOrgs)
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->get();

                        $data['or_lince_internal'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->where('license_type', '=', 'Internal')
                            ->get();

                        $data['or_lince_external'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->where('license_type', '=', 'External')
                            ->get();

                        $data['unbill_first_inv_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            //->where('licence', '=', 'yes')
                            ->whereNotIn('reg', $billed1stOrgs)
                            ->where('license_type', '=', 'Internal')
                            ->get();

                        $data['bill_first_inv_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            //->where('licence', '=', 'yes')
                            ->whereIn('reg', $billed1stOrgs)
                            ->where('license_type', '=', 'Internal')
                            ->get();

                        $data['unassigned_hr_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->whereNotIn('reg', $hrFileOrgs)
                            ->where('license_type', '=', 'Internal')
                            ->get();

                        $data['assigned_hr_org'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->whereIn('reg', $hrFileOrgs)
                            ->where('license_type', '=', 'Internal')
                            ->get();

                        $data['wip_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid', 'inner')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                            ->where('hr_apply.status', '=', 'Incomplete')
                        //->where('hr_apply.licence', '=', 'Pending Decision')
                            ->distinct()
                            ->get();

                        $data['complete_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        //->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid', 'inner')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                            ->where('hr_apply.status', '=', 'Complete')
                            //->whereNotIn('registration.reg', $allLicHr)

                            ->distinct()
                            ->get();

                        $data['license_granted_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Granted')
                            ->distinct()
                            ->get();

                        $data['license_rejected_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Rejected')
                            ->distinct()
                            ->get();

                        $data['license_refused_hrfile_internal'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Refused')
                            ->distinct()
                            ->get();

                        $data['license_pd_hrfile_internal'] = DB::Table('registration')
                            ->where('status', '=', 'active')
                            ->where('verify', '=', 'approved')
                            ->where('licence', '=', 'yes')
                            ->where('license_type', '=', 'Internal')
                            ->whereNotIn('registration.reg', $allLicHr)
                            ->get();

                        $data['second_unbilled_invoice_license'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Granted')
                            ->whereNotIn('registration.reg', $billed2ndOrgs)
                            ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                            ->distinct()
                            ->get();

                        $data['second_billed_invoice_license'] = DB::Table('registration')
                            ->select('registration.*')
                        // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                            ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                            ->where('registration.status', '=', 'active')
                            ->where('registration.verify', '=', 'approved')
                            ->where('registration.licence', '=', 'yes')
                            ->where('registration.license_type', '=', 'Internal')
                        // ->where('hr_apply.status', '=', 'Complete')
                            ->where('hr_apply.licence', '=', 'Granted')
                            ->whereIn('registration.reg', $billed2ndOrgs)
                            ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_assigned_rs'] = DB::Table('recruitment_file_apply')
                            ->orderBy('recruitment_file_apply.id', 'desc')
                            ->whereIn('recruitment_file_apply.emid', $licensedOrg)
                            ->distinct()
                            ->get();

                        $data['recruitementfile_request_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        // ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_pending_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        //  ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->whereNull('recruitment_file_emp.status')
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_ongoing_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        //  ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_hired_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->where('recruitment_file_emp.status', '=', 'Hired')
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_unbilled_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->where('recruitment_file_emp.status', '=', 'Hired')
                            ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                        //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                        //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['recruitementfile_billed_rs'] = DB::Table('recruitment_file_emp')
                            ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                            ->where('recruitment_file_emp.status', '=', 'Hired')
                            ->where('recruitment_file_emp.billed_first_invoice', '=', 'Yes')
                        // ->whereIn('recruitment_file_emp.emid', $licensedOrg)
                            ->whereIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                            ->orderBy('recruitment_file_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_unassigned_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->whereNull('cos_apply_emp.employee_id')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_assigned_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->whereNotNull('cos_apply_emp.employee_id')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_pending_rs'] = DB::Table('cos_apply_emp')
                            ->whereNull('cos_apply_emp.status')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->whereNotNull('cos_apply_emp.employee_id')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_granted_rs'] = DB::Table('cos_apply_emp')
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->where(function ($query) {

                                $query->whereNull('cos_apply_emp.cos_assigned')
                                    ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                            })
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_granted_unassigned_rs'] = DB::Table('cos_apply_emp')
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')

                            ->where(function ($query) {

                                $query->whereNull('cos_apply_emp.cos_assigned')
                                    ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                            })
                        //->whereNull('cos_apply_emp.cos_assigned_date')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_granted_assigned_rs'] = DB::Table('cos_apply_emp')
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                        //->whereNotNull('cos_apply_emp.cos_assigned_date')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cos_rejected_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->where('cos_apply_emp.status', '=', 'Rejected')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cosfile_unbilled_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        //->whereNotIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                            ->where('cos_apply_emp.billed_second_invoice', '=', 'No')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['cosfile_billed_rs'] = DB::Table('cos_apply_emp')
                            ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                            ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                            ->whereIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                            ->where('cos_apply_emp.status', '=', 'Granted')
                            ->where('cos_apply_emp.addn_cos', '=', 'No')
                            ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                            ->where('cos_apply_emp.billed_second_invoice', '=', 'Yes')
                            ->orderBy('cos_apply_emp.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_unassigned_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNull('visa_file_emp.employee_id')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_assigned_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNotNull('visa_file_emp.employee_id')
                            ->whereNull('visa_file_emp.status')
                            ->where(function ($query) {

                                $query->whereNull('visa_file_emp.visa_application_submitted')
                                    ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                            })
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_pending_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNull('visa_file_emp.status')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->whereNotNull('visa_file_emp.employee_id')
                            ->where(function ($query) {

                                $query->whereNull('visa_file_emp.visa_application_submitted')
                                    ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                            })
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_submitted_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->whereNull('visa_file_emp.status')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->where('visa_file_emp.visa_application_submitted', '=', 'Yes')

                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_granted_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->where('visa_file_emp.status', '=', 'Granted')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                        $data['visafile_rejected_rs'] = DB::Table('visa_file_emp')
                            ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                            ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                            ->where('visa_file_emp.status', '=', 'Rejected')
                            ->where('visa_file_emp.addn_visa', '=', 'No')
                            ->orderBy('visa_file_apply.id', 'desc')
                            ->distinct()
                            ->get();

                    }

                    //dd($data['license_rejected_hrfile_internal']);
                    $data['or_notactive'] = DB::Table('registration')
                        ->where('status', '=', 'inactive')
                        ->where('verify', '=', 'not approved')
                        ->where('licence', '=', 'no')
                        ->get();

                    //dd($data['or_assigned']);

                    $data['or_noverify'] = DB::Table('registration')
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'not approved')
                        ->where('licence', '=', 'no')
                        ->get();

                    //dd($data['bill_first_inv_org']);

                    // dd($data['unassigned_hr_org']);

                    $data['or_notlince'] = DB::Table('registration')

                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'no')

                        ->get();

                    //----Application stat
                    $data['assigned_internal'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')

                        ->get();

                    $data['assigned_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')

                        ->get();
                    $data['assigned_wip'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'no')

                        ->get();

                    $data['complete_internal'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('tareq_app.hr_in', '=', 'Yes')
                        ->whereNotNull('tareq_app.last_date')
                        ->get();

                    $data['complete_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                        ->where('tareq_app.hr_in', '=', 'Yes')
                        ->whereNotNull('tareq_app.last_date')

                        ->get();

                    //----hr stat
                    $data['assigned_hrfile'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                    //    ->where('registration.license_type', '=', 'Internal')
                    // ->where('registration.hr_apply', '=', 'Internal')
                        ->distinct()
                        ->get();

                    $data['assigned_hrfile_internal'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                    // ->where('registration.hr_apply', '=', 'Internal')
                        ->distinct()
                        ->get();

                    $data['assigned_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                    // ->where('registration.hr_apply', '=', 'Internal')
                        ->distinct()
                        ->get();

                    //dd($data['wip_hrfile_internal']);

                    $data['wip_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                        ->where('hr_apply.status', '=', 'Incomplete')
                        ->distinct()
                        ->get();

                    $data['complete_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                        ->where('hr_apply.status', '=', 'Complete')
                        ->distinct()
                        ->get();

                    $data['license_granted_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                    //->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->distinct()
                        ->get();

                    $data['license_complete_granted_hrfile_internal'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->distinct()
                        ->get();
                    $data['license_complete_granted_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                        ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->distinct()
                        ->get();
                    $data['needaction_hrfile_internal'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                    //->where('hr_apply.status', '=', 'Complete')
                    //->where('hr_apply.licence', '=', 'Granted')
                        ->where('hr_apply.need_action', '=', 'Yes')
                        ->distinct()
                        ->get();
                    $data['needaction_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                    //->where('hr_apply.status', '=', 'Complete')
                    //->where('hr_apply.licence', '=', 'Granted')
                        ->where('hr_apply.need_action', '=', 'Yes')
                        ->distinct()
                        ->get();

                    $data['license_rejected_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                    //->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Rejected')
                    //->where('hr_apply.need_action', '=', 'Yes')
                        ->distinct()
                        ->get();

                    $data['license_refused_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                    //->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Refused')
                    //->where('hr_apply.need_action', '=', 'Yes')
                        ->distinct()
                        ->get();
                    $data['homeoffice_visit_hrfile_internal'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                    //->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.home_off', '=', 'Yes')
                    //->where('hr_apply.need_action', '=', 'Yes')
                        ->distinct()
                        ->get();
                    $data['homeoffice_visit_hrfile_external'] = DB::Table('registration')
                        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'External')
                    //->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.home_off', '=', 'Yes')
                    //->where('hr_apply.need_action', '=', 'Yes')
                        ->distinct()
                        ->get();

                    // $data['visafile_unbilled_rs'] = DB::Table('visa_file_emp')
                    //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                    //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    //     ->whereNotIn('visa_file_emp.emid', $recruitment2ndbillOrg)
                    //     ->where('visa_file_emp.status', '=', 'Granted')
                    //     ->where('visa_file_emp.addn_visa', '=', 'No')
                    //     ->orderBy('visa_file_apply.id', 'desc')
                    //     ->distinct()
                    //     ->get();

                    // $data['visafile_billed_rs'] = DB::Table('visa_file_emp')
                    //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                    //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    //     ->whereIn('visa_file_emp.emid', $recruitment2ndbillOrg)
                    //     ->where('visa_file_emp.addn_visa', '=', 'No')
                    //     ->where('visa_file_emp.status', '=', 'Granted')
                    //     ->orderBy('visa_file_apply.id', 'desc')
                    //     ->distinct()
                    //     ->get();

                } else {

                }
                //dd($data);
                return View('admin/dashboard', $data);
            } else {
                //dd($data);
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewallcompany()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['employee_rs'] = DB::Table('registration')

                    ->get();

                return View('admin/employee-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function view_activity_log()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['data_rs'] = array();
                $data['data_post'] = 0;

                return View('admin/log-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    //  public function getlistofcountry(Request $request){
    //     try{
    //         $email = Session::get('empsu_email');

    //         if (!empty($email)) {
    //             $paramValue = $request->input('country');
    //             if($paramValue==null){

    //                 $data['country']=DB::table('country')->get();
    //                 $data['country_list'] = DB::table('registration')
    //                 ->where('status', '=', 'active')
    //                 ->orderBy('id', 'desc')
    //                 ->get();
    //                 // dd($data['country']);
    //             return view('admin/country-list', $data);
    //             }else{
    //                 $data['country']=DB::table('country')->get();
    //                 $data['country_list'] = DB::table('registration')
    //                 ->where('country',$paramValue)
    //                 ->where('status', '=', 'active')
    //                 ->orderBy('id', 'desc')
    //                 ->get();
    //                 // dd($data['country_list']);
    //             return view('admin/country-list', $data);
    //                 // dd($paramValue);
    //             }

    //         } else {
    //             return redirect('superadmin');
    //         }
    //     }catch(Exception $e){
    //         throw new \App\Exceptions\AdminException($e->getMessage());

    //     }
    // }

    public function getlistofcountry(){
        try{
            $data['country_list'] = DB::table('registration')
                                ->select('country', DB::raw('COUNT(*) as count'))
                                ->where('status', '=', 'active')
                                ->groupBy('country')
                                ->orderBy('count', 'desc')
                                ->get();
                                // dd($data['country_list']);
             return view('admin/country-list', $data);

        }catch(Exception $e)
        {
            throw new \App\Exceptions\AdminException($e->getMessage());

        }
    }

    public function countrywiselist($id){
        $data['country_list'] = DB::table('registration')
                                ->where('country', '=',$id)
                                ->get();
                                // dd($data['country_list']);
         return view('admin/country-wise-list', $data);
    }

    public function countrywiseorg($id){
        try{
            dd($id);
        }catch(Exception $e){
             throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }


    public function get_activity_log(Request $request)
    {
        try {

            $email = Session::get('empsu_email');

            if (!empty($email)) {

                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if (strtotime($start_date) > strtotime($end_date)) {
                    $data['data_post'] = 0;
                    Session::flash('message', 'Start date must be less than or equal to end date.');

                    return redirect('superadmin/activity-log');
                } else {
                    $data['data_post'] = 1;
                    $data['data_rs'] = DB::Table('activity_logs')
                        ->select('activity_logs.*', 'module_admin.module_name')
                        ->join('module_admin', 'module_admin.id', '=', 'activity_logs.module_id')
                        ->whereBetween('activity_logs.created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                        ->orderBy('activity_logs.id', 'desc')
                        ->get();
                }

                return View('admin/log-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewallcompanyemployee()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType == 'sub-admin'){
                    $org_code = Session::get('org_code');
                } else {
                    $org_code = '';
                }

                $data['employee_rs'] = DB::table('registration')
                ->where('status', 'active')
                ->where(function($query) use ($org_code) {
                    if ($org_code !== '') {
                        $query->where('org_code', $org_code);
                    } else {
                        $query->where('org_code', '')
                            ->orWhereNull('org_code');
                    }
                })
                ->get();

                $this->addAdminLog(3, 'Organisation - Employee list visited.');
                return View('admin/oremployee-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewbillng()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            $org_code = Session::get('org_code');
            // $userType = Session::get('user_type');
            //dd($userType);
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType == 'sub-admin'){
                    $data['bill_rs'] = DB::table('billing')
                    ->join('registration', 'billing.emid', '=', 'registration.reg')
                    ->where('billing.status', '=', 'not paid')
                    ->where('registration.org_code', '=', $org_code)
                    ->groupBy('billing.in_id')
                    ->orderBy('billing.in_id', 'desc')
                    ->select('billing.*', 'registration.*') // Adjust the selected columns as needed
                    ->get();
                } else {
                $data['bill_rs'] = DB::Table('billing')
                    ->where('status', '=', 'not paid')
                    ->groupBy('in_id')
                    ->orderBy('in_id', 'desc')
                    ->get();
                }
                //dd($data['bill_rs']);

                return View('admin/billing-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewpayre()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['pay_rs'] = DB::Table('payment')
                    ->where(function ($query) {
                        $query->where('status', '=', 'paid')
                            ->orWhere('status', '=', 'partially paid');
                    })

                    ->orderBy('id', 'desc')
                    ->get();

                    //dd($data);

                $this->addAdminLog(4, 'Billing- Accessed Payment Received list view.');
                return View('admin/payment-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewmsgcen()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['msg_rs'] = DB::Table('messaage_center')
                    ->orderBy('id', 'desc')
                    ->get();

                return View('admin/msg-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    // public function addbillng()
    // {

    //     try {
    //         $email = Session::get('empsu_email');

    //         $userType = Session::get('usersu_type');
    //         $org_code = Session::get('org_code');
    //         //dd($org_code);
    //         if (!empty($email)) {

    //             if ($userType == 'user') {
    //                 $arrrole = Session::get('empsu_role');
    //                 if (!in_array('4', $arrrole)) {
    //                     throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
    //                 }
    //             }

    //             //All Bills
    //             $data['bill_rs'] = DB::Table('billing')->get();

    //             //organisation details
    //             // if($userType == 'sub-admin'){
    //             //      $data['or_de'] = DB::Table('registration')
    //             //     ->where('status', '=', 'active')
    //             //     ->where('verify', '=', 'approved')
    //             //     ->where('org_code', '=',$org_code )
    //             //     ->get();
    //             // } else {
    //                 $data['or_de'] = DB::Table('registration')
    //                     ->where('status', '=', 'active')
    //                     ->where('verify', '=', 'approved')
    //                     //->where('licence', '=', 'yes')
    //                     ->get();
    //             //}
    //             // $data['candidate_rs'] = DB::Table('invoice_candidates')
    //             //     ->where('status', '=', 'A')
    //             //     ->get();

    //             //hired candidate list
    //             $data['candidate_rs'] = DB::Table('candidate')
    //                 ->where('status', '=', 'Hired')
    //                 ->get();

    //             //dd($data['or_de']);

    //             $userlist = array();
    //             foreach ($data['bill_rs'] as $user) {
    //                 $userlist[] = $user->emid;
    //             }

    //             $data['package_rs'] = DB::Table('package')
    //                 ->where('status', '=', 'active')
    //                 ->get();

    //             $data['tax_rs'] = DB::Table('tax_bill')
    //                 ->where('status', '=', 'active')
    //                 ->get();

    //             return View('admin/billing-add-new', $data);

    //         } else {
    //             return redirect('superadmin');
    //         }
    //     } catch (Exception $e) {
    //         throw new \App\Exceptions\AdminException($e->getMessage());
    //     }
    // }

        public function addbillng()
    {

        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                //All Bills
                $data['bill_rs'] = DB::Table('billing')->get();

                //organisation details
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    //->where('licence', '=', 'yes')
                    ->get();

                // $data['candidate_rs'] = DB::Table('invoice_candidates')
                //     ->where('status', '=', 'A')
                //     ->get();

                //hired candidate list
                $data['candidate_rs'] = DB::Table('candidate')
                    ->where('status', '=', 'Hired')
                    ->get();

                //dd($data['or_de']);

                $userlist = array();
                foreach ($data['bill_rs'] as $user) {
                    $userlist[] = $user->emid;
                }

                $data['package_rs'] = DB::Table('package')
                    ->where('status', '=', 'active')
                    ->get();

                $data['tax_rs'] = DB::Table('tax_bill')
                    ->where('status', '=', 'active')
                    ->get();

                return View('admin/billing-add-new', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addmscen()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_rs'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                return View('admin/msg-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addpayre()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                // dd(url());
                $data['bill_rs'] = DB::Table('billing')
                    ->where(function ($query) {
                        $query->where('status', '=', 'not paid')
                            ->orWhere('status', '=', 'partially paid');
                    })
                    ->orderBy('id', 'desc')
                    ->get();

                $data['or_rs'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->get();

                $userlist = array();
                foreach ($data['bill_rs'] as $user) {
                    $userlist[] = $user->emid;
                }

                $data['or_de'] = array();
                foreach ($data['or_rs'] as $key => $employee) {
                    if (in_array($employee->reg, $userlist)) {
                        $data['or_de'][] = (object) array("reg" => $employee->reg, "com_name" => $employee->com_name);
                    } else {

                    }

                }

                return View('admin/payment-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savebillng(Request $request)
    {
        try {
        //dd('554');
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                 //dd($request->all());

                $recruitmentFirstBillValid = false;
                $recruitmentSecondBillValid = false;

                if ($request->bill_for == 'first invoice recruitment service') {
                    if ($request->billing_type == 'Organisation') {
                        if ($request->rec_candidate_name == '') {
                            Session::flash('error', 'Please select candidate for recruitment first invoice.');
                            return redirect('superadmin/add-billing');
                        } else {
                            $recruitmentFirstBillValid = true;
                        }

                    } else {
                        Session::flash('error', 'Bill Type should be Organisation for recruitment first invoice.');
                        return redirect('superadmin/add-billing');
                    }
                }

                if ($request->bill_for == 'second invoice visa service') {
                    if ($request->billing_type == 'Organisation') {
                        if ($request->rec_candidate_name == '') {
                            Session::flash('error', 'Please select candidate for recruitment second invoice.');
                            return redirect('superadmin/add-billing');
                        } else {
                            $recruitmentSecondBillValid = true;
                        }

                    } else {
                        Session::flash('error', 'Bill Type should be Organisation for recruitment second invoice.');
                        return redirect('superadmin/add-billing');
                    }
                }

                $allValidDiscountVals = true;
                //validate all discount value to be proper
                if ($request->package && count($request->package) != 0) {
                    for ($i = 0; $i < count($request->package); $i++) {

                        if ($request->discount_type[$i] == 'P') {

                            if (((float) $request->discount[$i]) > 100 || ((float) $request->discount[$i]) < 0) {
                                $allValidDiscountVals = false;
                            }
                        }
                        if ($request->discount_type[$i] == 'A') {

                            if (((float) $request->discount[$i]) > ((float) $request->anount_ex_vat[$i]) || ((float) $request->discount[$i]) < 0) {
                                $allValidDiscountVals = false;
                            }
                        }

                    }
                }
                if ($allValidDiscountVals == false) {
                    Session::flash('error', 'Discount is not in proper format.');
                    return redirect('superadmin/add-billing');
                }

                $ckeck_email = DB::Table('registration')

                    ->where('reg', '=', $request->emid)
                    ->first();

                if (empty($ckeck_email)) {
                    Session::flash('error', 'Organisation name is not in proper format.');
                    return redirect('superadmin/add-billing');
                } else {

                    $lsatdeptnmdb = DB::table('billing')->whereYear('date', '=', date('Y'))->whereMonth('date', '=', date('m'))
                        ->groupBy('in_id')->orderBy('in_id', 'DESC')->first();

                    if (empty($lsatdeptnmdb)) {
                        $pid = date('Y') . '/' . date('m') . '/001';
                    } else {
                        $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdb->in_id);
                        if ($str <= 8) {
                            $pid = date('Y') . '/' . date('m') . '/00' . ($str + 1);
                        } else if ($str < 99) {
                            $pid = date('Y') . '/' . date('m') . '/0' . ($str + 1);
                        } else {
                            $pid = date('Y') . '/' . date('m') . '/' . ($str + 1);
                        }

                    }
                    $lsatdeptnmdbexit = DB::table('billing')->where('in_id', '=', $pid)->orderBy('in_id', 'DESC')->first();

                    if ($recruitmentFirstBillValid == false && $recruitmentSecondBillValid == false) {
                        $request->bill_to = $request->billing_type;
                    }

                    if (!empty($lsatdeptnmdbexit)) {
                        Session::flash('error', 'Invoice Number already Exits. ');
                        return redirect('superadmin/add-billing');
                    } else {
                        $rec_candidate_info = array();
                        if ($recruitmentFirstBillValid) {
                            // $dummyDes = $request->des;
                            // for ($j = 0; $j < count($request->des); $j++) {
                            //     $dummyDes[$j] = $request->des[$j] . ' (Candidate : ' . $request->rec_candidate_name . ')';
                            //     //$request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';

                            // }
                            // $request->des = $dummyDes;
                            $rec_candidate_info = DB::table('recruitment_file_emp')
                                ->where('emid', $request->emid)
                                ->where('employee_name', $request->rec_candidate_name)
                                ->first();

                            $request->canidate_name = $rec_candidate_info->employee_name;
                            $request->canidate_email = $rec_candidate_info->employee_email;
                            $request->candidate_id = '0';
                            $request->candidate_address = $rec_candidate_info->employee_address;
                            //$request->bill_to = $request->rec_can_billto;
                        }
                        if ($recruitmentSecondBillValid) {
                            // $dummyDes = $request->des;
                            // for ($j = 0; $j < count($request->des); $j++) {
                            //     $dummyDes[$j] = $request->des[$j] . ' (Candidate : ' . $request->rec_candidate_name . ')';
                            //     //$request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';

                            // }
                            // $request->des = $dummyDes;
                            $rec_candidate_info = DB::table('recruitment_file_emp')
                                ->where('emid', $request->emid)
                                ->where('employee_name', $request->rec_candidate_name)
                                ->first();
                            $request->canidate_name = $rec_candidate_info->employee_name;
                            $request->canidate_email = $rec_candidate_info->employee_email;
                            $request->candidate_id = '0';
                            $request->candidate_address = $rec_candidate_info->employee_address;
                            //$request->bill_to = $request->rec_can_billto;
                            //                            $request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';
                        }
                        // dd('road block');
                        $pidhh = str_replace("/", "-", $pid);
                        $filename = $pidhh . '.pdf';
                        $Roledata = DB::Table('registration')
                            ->where('reg', '=', $request->emid)
                            ->first();

                        $datap = [
                            'Roledata' => $Roledata,
                            'in_id' => $pid,
                            'des' => $request->des,
                            'date' => date('Y-m-d'),
                            'package' => $request->package,
                            'net_amount' => $request->net_amount,
                            'discount_type' => $request->discount_type,
                            'discount' => $request->discount,
                            'discount_amount' => $request->discount_amount,
                            'anount_ex_vat' => $request->anount_ex_vat,
                            'vat' => $request->vat,
                            'amount_after_vat' => $request->amount_after_vat,
                            'billing_type' => $request->billing_type,
                            'canidate_name' => $request->canidate_name,
                            'candidate_id' => $request->candidate_id,
                            'candidate_address' => $request->candidate_address,
                            'bill_for' => $request->bill_for,
                            'bill_to' => $request->bill_to,
                            'rec_candidate_info' => $rec_candidate_info,
                        ];

                        // dd($datap);

                        $pdf = PDF::loadView('mybillPDFNew', $datap);
                        // dd(public_path());
                        $pdf->save(public_path() . '/billpdf/' . $filename);
                        // dd("hello");
                        // echo $pid;
                        // dd($datap);
                        // dd($request->all());
                        $totamount = 0;
                        if ($request->package && count($request->package) != 0) {
                            for ($i = 0; $i < count($request->package); $i++) {

                                $totamount = $totamount + $request->net_amount[$i];

                            }
                        }

                        if ($request->package && count($request->package) != 0) {
                            for ($i = 0; $i < count($request->package); $i++) {

                                $discount = $request->discount[$i];
                                $discount_p = 0;
                                if ($request->discount_type[$i] == 'P') {

                                    $discount = 0;
                                    $discount_p = $request->discount[$i];

                                    $discount = round(((((float) $request->anount_ex_vat[$i]) * ((float) $discount_p)) / 100), 2);
                                }

                                $data = array(

                                    'in_id' => $pid,
                                    'emid' => $request->emid,
                                    'pay_mode' => $request->pay_mode,
                                    'status' => 'not paid',
                                    'amount' => $totamount,
                                    'due' => $totamount,
                                    'des' => htmlspecialchars($request->des[$i]),
                                    'date' => date('Y-m-d'),
                                    'dom_pdf' => $filename,
                                    'discount' => $discount,
                                    'discount_percent' => $discount_p,
                                    'discount_type' => $request->discount_type[$i],
                                    'discount_amount' => $request->discount_amount[$i],
                                    'anount_ex_vat' => $request->anount_ex_vat[$i],
                                    'vat' => $request->vat[$i],
                                    'amount_after_vat' => $request->amount_after_vat[$i],
                                    'net_amount' => $request->net_amount[$i],
                                    'package' => $request->package[$i],
                                    'hold_st' => '',
                                    'canidate_name' => $request->canidate_name,
                                    'canidate_email' => $request->canidate_email,
                                    'candidate_id' => $request->candidate_id,
                                    'candidate_address' => $request->candidate_address,
                                    'billing_type' => $request->billing_type,
                                    'bill_for' => $request->bill_for,
                                    'bill_to' => $request->bill_to,
                                );
                                //dd($data);
                                DB::table('billing')->insert($data);

                                if ($recruitmentFirstBillValid) {
                                    $recruitment_file_emp = DB::table('recruitment_file_emp')->where('emid', '=', $request->emid)->where('employee_name', '=', $request->rec_candidate_name)->first();

                                    //dd($recruitment_file_emp);
                                    $dataRecruitmentUpdate = array(
                                        'billed_first_invoice' => 'Yes',
                                        'bill_no' => $pid,
                                        'update_new_ct' => date('Y-m-d'),
                                    );

                                    DB::table('recruitment_file_emp')->where('id', $recruitment_file_emp->id)->update($dataRecruitmentUpdate);
                                }
                                if ($recruitmentSecondBillValid) {
                                    $cos_apply_emp = DB::table('cos_apply_emp')->where('emid', '=', $request->emid)->where('employee_name', '=', $request->rec_candidate_name)->first();

                                    //dd($cos_apply_emp);
                                    $dataCosUpdate = array(
                                        'billed_second_invoice' => 'Yes',
                                        'bill_no' => $pid,
                                        'update_new_ct' => date('Y-m-d'),
                                    );

                                    DB::table('cos_apply_emp')->where('id', $cos_apply_emp->id)->update($dataCosUpdate);
                                }

                            }
                        }

                        $this->addAdminLog(4, 'Billing - Created new invoice with invoice no.: ' . $pid);
                        Session::flash('message', 'Bill Added Successfully .');

                        return redirect('superadmin/billing');

                    }

                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savemscen(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->has('file')) {

                    $file_visa_doc = $request->file('file');
                    $extension_visa_doc = $request->file->extension();
                    $path_visa_doc = $request->file->store('msg_file', 'public');

                } else {

                    $path_visa_doc = '';

                }
                $data = array(

                    'emid' => $request->emid,
                    'file' => $path_visa_doc,
                    'subject' => $request->subject,
                    'msg' => $request->msg,
                    'email' => $request->email,
                    'date' => date('Y-m-d'),

                );

                DB::table('messaage_center')->insert($data);
                $Roledata = DB::table('registration')

                    ->where('reg', '=', $request->emid)
                    ->first();
                if ($path_visa_doc != '') {
                    $path = public_path() . '/' . $path_visa_doc;
                    $sub = $request->subject;
                    $data = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'msg' => $request->msg);
                    $toemail = $Roledata->email;
                    Mail::send('mailormsgcen', $data, function ($message) use ($toemail, $sub, $path) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ($sub);
                        $message->attach($path);
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });
                    $sub = $request->subject;
                    $data = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'msg' => $request->msg);
                    $toemail = $Roledata->organ_email;
                    Mail::send('mailormsgcen', $data, function ($message) use ($toemail, $sub, $path) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ($sub);
                        $message->attach($path);
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });

                    if ($request->cc != '') {
                        $sub = $request->subject;
                        $data = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'msg' => $request->msg);
                        $toemail = $request->cc;
                        Mail::send('mailormsgcen', $data, function ($message) use ($toemail, $sub, $path) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ($sub);
                            $message->attach($path);
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });

                    }
                } else {
                    $sub = $request->subject;
                    $data = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'msg' => $request->msg);
                    $toemail = $Roledata->email;
                    Mail::send('mailormsgcen', $data, function ($message) use ($toemail, $sub) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ($sub);

                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });
                    $sub = $request->subject;
                    $data = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'msg' => $request->msg);
                    $toemail = $Roledata->organ_email;
                    Mail::send('mailormsgcen', $data, function ($message) use ($toemail, $sub) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ($sub);

                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });

                    if ($request->cc != '') {
                        $sub = $request->subject;
                        $data = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'msg' => $request->msg);
                        $toemail = $request->cc;
                        Mail::send('mailormsgcen', $data, function ($message) use ($toemail, $sub) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ($sub);

                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });

                    }

                }

                Session::flash('message', 'Message Send Successfully .');

                return redirect('superadmin/message-center');
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savepayre(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

            //    dd($request->all());
                //dd($request->in_id);

                //getting invoice details
                $lsatdeptnmdb = DB::table('billing')->where('id', '=', $request->in_id)->orderBy('id', 'DESC')->first();

                // dd($lsatdeptnmdb);
                $recruitment_inv_payment_recv=false;
                if($lsatdeptnmdb->bill_for=='first invoice recruitment service'){
                    $recruitment_inv_payment_recv=true;
                }

                $lsatdeptnmdbnew = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                    ->whereMonth('payment_date', '=', date('m'))
                    ->orderBy('id', 'DESC')->first();

                $lsatdeptnmdbnew1 = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                    ->whereMonth('payment_date', '=', date('m'))
                    ->orderBy('id', 'DESC')->get();

                //dd($lsatdeptnmdbnew);
                //dd(count($lsatdeptnmdbnew1));

                $invStr = str_replace("/", "", $request->in_id);
                //generating pay_recipt no. below --start
                if (empty($lsatdeptnmdbnew)) {
                    $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/001';
                } else {
                    // $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdbnew->pay_recipt);
                    $str = count($lsatdeptnmdbnew1) + 1;

                    if ($str == '') {
                        $str = count($lsatdeptnmdbnew1);
                    }

                    if ($str <= 8) {
                        $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/00' . ($str + 1);
                    } else if ($str < 99) {
                        $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/0' . ($str + 1);
                    } else {
                        $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/' . ($str + 1);
                    }

                }

                //generating pay_recipt no. above --end
                // dd($pid);
                $lsatdeptnmdbexit = DB::table('payment')->where('pay_recipt', '=', $pid)->orderBy('pay_recipt', 'DESC')->first();

                if (!empty($lsatdeptnmdbexit)) {
                    Session::flash('messaage', 'Payment Id already Exits. ');
                    return redirect('superadmin/payment-received');
                } else {

                    //checking payable amount & received amount
                    if ($request->amount == $request->re_amount) {

                        $lsatdeptnmdbnew = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                            ->whereMonth('payment_date', '=', date('m'))
                            ->orderBy('id', 'DESC')->first();

                        $lsatdeptnmdbnew1 = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                            ->whereMonth('payment_date', '=', date('m'))
                            ->orderBy('id', 'DESC')->get();

                        //dd($lsatdeptnmdbnew);
                        //dd(count($lsatdeptnmdbnew1));

                        $invStr = str_replace("/", "", $request->in_id);
                        //generating pay_recipt no. below --start
                        if (empty($lsatdeptnmdbnew)) {
                            $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/001';
                        } else {
                            // $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdbnew->pay_recipt);
                            $str = count($lsatdeptnmdbnew1) + 1;

                            if ($str == '') {
                                $str = count($lsatdeptnmdbnew1);
                            }

                            if ($str <= 8) {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/00' . ($str + 1);
                            } else if ($str < 99) {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/0' . ($str + 1);
                            } else {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/' . ($str + 1);
                            }

                        }
                        //generating pay_recipt no. above --end
                        // dd($pid);
                        $max_idnew = DB::table('payment')
                            ->orderBy('id', 'DESC')->first();

                        $max_id = ($max_idnew->id + 1);

                        //pdf file name
                        $pidhh = str_replace("/", "-", $max_id . $pid);

                        $filename = $pidhh . '.pdf';
                        $lsatdeptnmdb = DB::table('billing')->where('id', '=', $request->in_id)->orderBy('id', 'DESC')->first();

                        $Roledata = DB::table('registration')

                            ->where('reg', '=', $lsatdeptnmdb->emid)
                            ->first();

                        $datap = ['Roledata' => $Roledata, 'pay_recipt' => $pid, 're_amount' => $request->re_amount, 'des' => $request->des, 'date' => date('d/m/Y',strtotime($request->actual_payment_date)), 'billing' => $lsatdeptnmdb, 'method' => 'Offline'];

                        $pdf = PDF::loadView('myinvoicePDF', $datap);

                        $pdf->save(public_path() . '/paypdf/' . $filename);

                        $data = array(

                            'in_id' => $lsatdeptnmdb->in_id,
                            'emid' => $lsatdeptnmdb->emid,
                            'status' => 'paid',
                            'amount' => $lsatdeptnmdb->amount,
                            're_amount' => $request->re_amount,
                            'due_amonut' => $request->due_amonut,
                            'payable_amount' => $request->due_amonut,
                            'payment_type' => $request->payment_type,
                            'actual_payment_date' => $request->actual_payment_date,
                            'des' => htmlspecialchars($request->des),
                            'date' => $lsatdeptnmdb->date,
                            'payment_date' => date('Y-m-d'),
                            'dom_pdf' => $lsatdeptnmdb->dom_pdf,

                            'pay_recipt' => $pid,
                            'pay_recipt_pdf' => $filename,
                            'remarks' => 'Transaction Success ',

                        );

                        DB::table('payment')->insert($data);

                        $lastPayRec = DB::table('payment')->where('pay_recipt', $pid)->where('in_id', $lsatdeptnmdb->in_id)->first();

                        $dataup = array(
                            'due' => 0,
                            'status' => 'paid',
                        );
                        DB::table('billing')->where('in_id', $lsatdeptnmdb->in_id)->update($dataup);

                        // dd($lastPayRec->id);

                        $Roledata = DB::table('registration')

                            ->where('reg', '=', $lsatdeptnmdb->emid)
                            ->first();
                        $path = public_path() . '/paypdf/' . $filename;
                        $dynamic_invoice_path = "https://workpermitcloud.co.uk/hrms/download-invoice/" . base64_encode($lastPayRec->id);

                        $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                        $toemail = $Roledata->email;

                        if ($toemail != '') {
                            Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                $message->to($toemail, 'skilledworkerscloud')->subject
                                    ('Payment Receive Details');
                                //$message->attach($path);
                                $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                            });
                        }

                        $path = public_path() . '/paypdf/' . $filename;
                        $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                        $toemail = $Roledata->authemail;
                        if ($toemail != '') {
                            Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                $message->to($toemail, 'skilledworkerscloud')->subject
                                    ('Payment Receive   Details');
                                // $message->attach($path);
                                $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                            });
                        }

                        $path = public_path() . '/paypdf/' . $filename;
                        $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                        $toemail = "accounts@workpermitcloud.co.uk";
                        Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Payment Receive   Details');
                            //$message->attach($path);
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });

                        if($recruitment_inv_payment_recv==true){
                            $bill_inv_info = DB::table('billing')->where('id', '=', $request->in_id)->orderBy('id', 'DESC')->first();
                            $toemail = 'recruitment@workpermitcloud.co.uk';

                            $data_email = array('to_name' => '', 'body_content' => 'Payment received for recruitment.
                            <p>Organisation with name "'.$Roledata->com_name.'"</p>
                            <p>Candidate Name: "'.$bill_inv_info->canidate_name.'"</p>
                            <p>Bill Amount: &pound;'.$request->amount.'</p>
                            <p>Received Amount: &pound;'.$request->re_amount.'</p>
                            <p>Due Amount: &pound;'.($request->due_amonut - $request->re_amount).'</p>
                            <p>Date of the payment received: '.date('Y-m-d').'</p>');

                            Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                $message->to($toemail, 'skilledworkerscloud')->subject
                                    ('Payment received for recruitment');
                                $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                            });


                        }



                        $this->addAdminLog(4, 'Billing- Payment receipt generated for invoice no.: ' . $lsatdeptnmdb->in_id);
                        Session::flash('message', 'Payment Received Successfully .');

                    } else if ($request->amount > $request->re_amount) {

                        $lsatdeptnmdbnew = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                            ->whereMonth('payment_date', '=', date('m'))
                            ->orderBy('id', 'DESC')->first();

                        $lsatdeptnmdbnew1 = DB::table('payment')->whereYear('payment_date', '=', date('Y'))
                            ->whereMonth('payment_date', '=', date('m'))
                            ->orderBy('id', 'DESC')->get();

                        //dd($lsatdeptnmdbnew);
                        //dd(count($lsatdeptnmdbnew1));

                        $invStr = str_replace("/", "", $request->in_id);
                        //generating pay_recipt no. below --start
                        if (empty($lsatdeptnmdbnew)) {
                            $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/001';
                        } else {
                            // $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdbnew->pay_recipt);
                            $str = count($lsatdeptnmdbnew1) + 1;

                            if ($str == '') {
                                $str = count($lsatdeptnmdbnew1);
                            }

                            if ($str <= 8) {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/00' . ($str + 1);
                            } else if ($str < 99) {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/0' . ($str + 1);
                            } else {
                                $pid = date('Y') . '/' . date('m') . '/' . $invStr . '/' . ($str + 1);
                            }

                        }
                        $max_idnew = DB::table('payment')
                            ->orderBy('id', 'DESC')->first();

                        $max_id = ($max_idnew->id + 1);

                        $pidhh = str_replace("/", "-", $max_id . $pid);

                        $filename = $pidhh . '.pdf';
                        $lsatdeptnmdb = DB::table('billing')->where('id', '=', $request->in_id)->orderBy('id', 'DESC')->first();

                        $Roledata = DB::table('registration')

                            ->where('reg', '=', $lsatdeptnmdb->emid)
                            ->first();

                        $datap = ['Roledata' => $Roledata, 'pay_recipt' => $pid, 're_amount' => $request->re_amount, 'des' => $request->des, 'date' => date('d/m/Y',strtotime($request->actual_payment_date)), 'billing' => $lsatdeptnmdb, 'method' => 'Ofline'];

                        $pdf = PDF::loadView('myinvoicePDF', $datap);

                        $pdf->save(public_path() . '/paypdf/' . $filename);

                        $data = array(

                            'in_id' => $lsatdeptnmdb->in_id,
                            'emid' => $lsatdeptnmdb->emid,
                            'status' => 'partially paid',
                            'amount' => $lsatdeptnmdb->amount,
                            're_amount' => $request->re_amount,
                            'due_amonut' => $request->due_amonut,
                            'payable_amount' => $request->due_amonut,
                            'payment_type' => $request->payment_type,
                            'actual_payment_date' => $request->actual_payment_date,
                            'des' => $request->des,
                            'date' => $lsatdeptnmdb->date,
                            'payment_date' => date('Y-m-d'),
                            'dom_pdf' => $lsatdeptnmdb->dom_pdf,
                            'pay_recipt' => $pid,
                            'pay_recipt_pdf' => $filename,
                            'remarks' => 'Transaction Success ',
                        );

                        DB::table('payment')->insert($data);

                        $lastPayRec = DB::table('payment')->where('pay_recipt', $pid)->where('in_id', $lsatdeptnmdb->in_id)->first();

                        $dataup = array(
                            'due' => ($request->due_amonut - $request->re_amount),
                            'status' => 'partially paid',
                        );
                        DB::table('billing')->where('in_id', $lsatdeptnmdb->in_id)->update($dataup);

                        $Roledata = DB::table('registration')

                            ->where('reg', '=', $lsatdeptnmdb->emid)
                            ->first();

                        $path = public_path() . '/paypdf/' . $filename;

                        $dynamic_invoice_path = "https://workpermitcloud.co.uk/hrms/download-invoice/" . base64_encode($lastPayRec->id);

                        $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);
                        $toemail = $Roledata->email;

                        if ($toemail != '') {
                            Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                $message->to($toemail, 'skilledworkerscloud')->subject
                                    ('Payment Receive   Details');
                                // $message->attach($path);
                                $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                            });
                        }
                        $path = public_path() . '/paypdf/' . $filename;
                        $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);

                        $toemail = $Roledata->authemail;

                        if ($toemail != '') {
                            Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                                $message->to($toemail, 'skilledworkerscloud')->subject
                                    ('Payment Receive   Details');
                                //  $message->attach($path);
                                $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                            });
                        }

                        $path = public_path() . '/paypdf/' . $filename;
                        $datanew = array('f_name' => $Roledata->f_name, 'l_name' => $Roledata->l_name, 'com_name' => $Roledata->com_name, 'p_no' => $Roledata->p_no, 'email' => $Roledata->email, 'pass' => $Roledata->pass, 'amount' => $request->re_amount, 'bill' => $lsatdeptnmdb->in_id, 'invoice_path' => $dynamic_invoice_path);

                        $toemail = "info@workpermitcloud.co.uk";

                        Mail::send('mailorpayre', $datanew, function ($message) use ($toemail, $path) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Payment Receive   Details');
                            // $message->attach($path);
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });

                        if($recruitment_inv_payment_recv==true){
                            $bill_inv_info = DB::table('billing')->where('id', '=', $request->in_id)->orderBy('id', 'DESC')->first();
                            $toemail = 'recruitment@workpermitcloud.co.uk';

                            $data_email = array('to_name' => '', 'body_content' => 'Payment received for recruitment.
                            <p>Organisation with name "'.$Roledata->com_name.'"</p>
                            <p>Candidate Name: "'.$bill_inv_info->canidate_name.'"</p>
                            <p>Bill Amount: &pound;'.$request->amount.'</p>
                            <p>Received Amount: &pound;'.$request->re_amount.'</p>
                            <p>Due Amount: &pound;'.($request->due_amonut - $request->re_amount).'</p>
                            <p>Date of the payment received: '.date('Y-m-d').'</p>');

                            Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                                $message->to($toemail, 'skilledworkerscloud')->subject
                                    ('Payment received for recruitment');
                                $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                            });




                        }

                        $this->addAdminLog(4, 'Billing- Payment receipt generated for invoice no.: ' . $lsatdeptnmdb->in_id);

                        Session::flash('message', 'Payment Received Successfully .');

                    } else {
                        Session::flash('message', 'Payment Amount Is Bigger Than Amount.');
                    }

                    return redirect('superadmin/payment-received');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function vwreceiptpdf($receipt_id)
    {
        $receipt_id = base64_decode($receipt_id);

        $data['pay_rs'] = DB::Table('payment')
            ->where('id', '=', $receipt_id)
            ->first();

        $Roledata = DB::table('registration')

            ->where('reg', '=', $data['pay_rs']->emid)
            ->first();

        $lsatdeptnmdb = DB::table('billing')->where('in_id', '=', $data['pay_rs']->in_id)->orderBy('id', 'DESC')->first();

        //dd($lsatdeptnmdb);
        $package_details = "";
        if ($lsatdeptnmdb->package != "") {
            $packders = DB::Table('package')->where('id', '=', $lsatdeptnmdb->package)->first();
            $package_details = $packders->description;
        }

        $inv_customer_name = ucfirst($Roledata->f_name) . ' ' . ucfirst($Roledata->l_name);
        $inv_customer_address = '';
        $inv_invoiceno = $data['pay_rs']->in_id;
        $inv_com_name = ucwords($Roledata->com_name);
        $inv_issue_date = date('d/m/Y', strtotime($lsatdeptnmdb->date));

        $vat_percent_in_bill = $lsatdeptnmdb->vat;
        if ($vat_percent_in_bill == null) {
            $vat_percent_in_bill = 0;
        }

        $receipt_amount_without_vat = $data['pay_rs']->re_amount;
        $vat_receipt_amount = 0;
        if ($vat_percent_in_bill > 0) {
            $vat_receipt_amount = round((($data['pay_rs']->re_amount * $vat_percent_in_bill) / 100), 2);
            $receipt_amount_without_vat = $receipt_amount_without_vat - $vat_receipt_amount;
        }
        // die($lsatdeptnmdb->canidate_name);

        if ($lsatdeptnmdb->billing_type == 'Candidate') {
            // $invCandidate = DB::table('invoice_candidates')->where('id', '=', $lsatdeptnmdb->candidate_id)->first();
            //dd($invCandidate);
            $inv_customer_name = $lsatdeptnmdb->canidate_name;
            $inv_customer_address = '';
        }

        $datap = [
            'Roledata' => $Roledata,
            'pay_recipt' => $receipt_id,
            're_amount' => $data['pay_rs']->re_amount,
            're_amount_words' => $this->inwords($data['pay_rs']->re_amount),
            'vat_receipt_amount' => $vat_receipt_amount,
            'receipt_amount_without_vat' => $receipt_amount_without_vat,
            'des' => $data['pay_rs']->des,
            'pay_receipt' => $data['pay_rs']->pay_recipt,
            'payment_type' => $data['pay_rs']->payment_type,
            'date' => date('d/m/Y', strtotime($data['pay_rs']->payment_date)),
            'billing' => $lsatdeptnmdb,
            'package_details' => $package_details,
            'inv_customer_name' => $inv_customer_name,
            'inv_customer_address' => $inv_customer_address,
            'inv_invoiceno' => $inv_invoiceno,
            'inv_com_name' => $inv_com_name,
            'inv_issue_date' => $inv_issue_date,
            'method' => 'Offline',
        ];

        //dd($data);
        //$pdf = PDF::loadView('myinvoicePDF', $datap);
        $pdf = PDF::loadView('receiptPDFNew', $datap);

        return $pdf->download($receipt_id . '.pdf');
    }

    public function vwreceiptpdfbc($receipt_id)
    {
        $receipt_id = base64_decode($receipt_id);

        $data['pay_rs'] = DB::Table('payment')
            ->where('id', '=', $receipt_id)
            ->first();

        $Roledata = DB::table('registration')

            ->where('reg', '=', $data['pay_rs']->emid)
            ->first();

        $lsatdeptnmdb = DB::table('billing')->where('in_id', '=', $data['pay_rs']->in_id)->orderBy('id', 'DESC')->first();

        //dd($lsatdeptnmdb);
        $package_details = "";
        if ($lsatdeptnmdb->package != "") {
            $packders = DB::Table('package')->where('id', '=', $lsatdeptnmdb->package)->first();
            $package_details = $packders->description;
        }


        $recruitmentFirstBillValid = false;
        $recruitmentSecondBillValid = false;

        if ($lsatdeptnmdb->bill_for == 'first invoice recruitment service') {
            if ($lsatdeptnmdb->billing_type == 'Organisation') {
                $recruitmentFirstBillValid = true;

            }
        }

        if ($lsatdeptnmdb->bill_for == 'second invoice visa service') {
            if ($lsatdeptnmdb->billing_type == 'Organisation') {

                $recruitmentSecondBillValid = true;

            }
        }




        $inv_customer_name = ucfirst($Roledata->f_name) . ' ' . ucfirst($Roledata->l_name);
        $inv_customer_address = '';
        $inv_invoiceno = $data['pay_rs']->in_id;
        $inv_com_name = ucwords($Roledata->com_name);
        $inv_issue_date = date('d/m/Y', strtotime($lsatdeptnmdb->date));

        $vat_percent_in_bill = $lsatdeptnmdb->vat;
        if ($vat_percent_in_bill == null) {
            $vat_percent_in_bill = 0;
        }

        $receipt_amount_without_vat = $data['pay_rs']->re_amount;
        $vat_receipt_amount = 0;
        if ($vat_percent_in_bill > 0) {
            $vat_receipt_amount = round((($data['pay_rs']->re_amount * $vat_percent_in_bill) / 100), 2);
            $receipt_amount_without_vat = $receipt_amount_without_vat - $vat_receipt_amount;
        }
        // die($lsatdeptnmdb->canidate_name);

        if ($lsatdeptnmdb->billing_type == 'Candidate') {
            // $invCandidate = DB::table('invoice_candidates')->where('id', '=', $lsatdeptnmdb->candidate_id)->first();
            //dd($invCandidate);
            $inv_customer_name = $lsatdeptnmdb->canidate_name;
            $inv_customer_address = '';
        }


        if ($recruitmentFirstBillValid) {
            $inv_customer_name = $lsatdeptnmdb->canidate_name;
            $inv_customer_address = $lsatdeptnmdb->candidate_address;

        }
        if ($recruitmentSecondBillValid) {
            $inv_customer_name = $lsatdeptnmdb->canidate_name;
            $inv_customer_address = $lsatdeptnmdb->candidate_address;

        }


        $vaton_re_amount = 0;
        $taxable_amount = $data['pay_rs']->re_amount;
        if ($lsatdeptnmdb->vat != 0) {
            $bill_vat_percent = 100 + $lsatdeptnmdb->vat;

            //(received_amount * 100)/(vat_percent+100)
            $reverseReAmountWithoutVat = round((((float) $data['pay_rs']->re_amount) * 100 / ((float) $bill_vat_percent)), 2);
            $vaton_re_amount = (((float) $data['pay_rs']->re_amount) - $reverseReAmountWithoutVat);
            //die($vaton_re_amount);
            $taxable_amount = ((float) $data['pay_rs']->re_amount) - ((float) $vaton_re_amount);
        }

        $datap = [
            'Roledata' => $Roledata,
            'pay_recipt' => $receipt_id,
            're_amount' => $data['pay_rs']->re_amount,
            'vaton_re_amount' => $vaton_re_amount,
            'taxable_amount' => $taxable_amount,
            're_amount_words' => $this->inwords($data['pay_rs']->re_amount),
            'vat_receipt_amount' => $vat_receipt_amount,
            'receipt_amount_without_vat' => $receipt_amount_without_vat,
            'des' => $data['pay_rs']->des,
            'pay_receipt' => $data['pay_rs']->pay_recipt,
            'payment_type' => $data['pay_rs']->payment_type,
            'date' => date('d/m/Y', strtotime($data['pay_rs']->actual_payment_date)),
            'billing' => $lsatdeptnmdb,
            'package_details' => $package_details,
            'inv_customer_name' => $inv_customer_name,
            'inv_customer_address' => $inv_customer_address,
            'inv_invoiceno' => $inv_invoiceno,
            'inv_com_name' => $inv_com_name,
            'inv_issue_date' => $inv_issue_date,
            'method' => 'Offline',
            'show_discount' => '0',
        ];

        //dd($datap);
        //$pdf = PDF::loadView('myinvoicePDF', $datap);
        $pdf = PDF::loadView('receiptPDFNewbc', $datap);

        return $pdf->download($receipt_id . '.pdf');
    }

    private function inwords($re_amount)
    {
        $number = $re_amount;
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = null;
            }

        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
        "." . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';

        return trim($result . $points);
    }

    public function viewsendbilldetails($send_id)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $pdf = '';
                $fo = '';
                $job = DB::table('billing')->where('in_id', '=', base64_decode($send_id))->first();
                $pass = DB::Table('registration')

                    ->where('reg', '=', $job->emid)

                    ->first();
                $com_name = '';
                if ($job->billing_type == 'Organisation') {
                    if ($job->bill_for == 'first invoice recruitment service') {
                        $com_name = $job->canidate_name;
                    } elseif ($job->bill_for == 'second invoice visa service') {
                        $com_name = $job->canidate_name;
                    } else {
                        $com_name = $pass->com_name;

                    }
                } else if ($job->billing_type == 'Candidate') {
                    $com_name = $job->canidate_name;
                }

                $add = '';
                $add = $pass->address;
                if ($pass->address2 != '') {
                    $add .= ' ,' . $pass->address2;
                }
                if ($pass->road != '') {
                    $add .= ' ,' . $pass->road;
                }
                if ($pass->city != '') {
                    $add .= ' ,' . $pass->city;
                }
                if ($pass->zip != '') {
                    $add .= ' ,' . $pass->zip;
                }
                if ($pass->country != '') {
                    $add .= ' ,' . $pass->country;
                }
                $path = public_path() . '/billpdf/' . $job->dom_pdf;
                $usersnew = DB::Table('users')

                    ->where('employee_id', '=', $job->emid)

                    ->first();
                $data = array('name' => $pass->f_name . ' ' . $pass->l_name, 'com_name' => $com_name, 'address' => $add, 'users' => $usersnew, 'billing_type' => $job->billing_type, 'bill_for' => $job->bill_for);

                if ($job->billing_type == 'Organisation') {
                    if ($job->bill_for == 'first invoice recruitment service') {
                        $toemail = $job->canidate_email;
                    } elseif ($job->bill_for == 'second invoice visa service') {
                        $toemail = $job->canidate_email;
                    } else {
                        $toemail = $pass->email;
                    }

                } else if ($job->billing_type == 'Candidate') {
                    $toemail = $job->canidate_email;

                }
            //   dd()
                Mail::send('mailbillsend', $data, function ($message) use ($toemail, $path) {
                    $message->to($toemail, 'skilledworkerscloud')->subject
                        ('Invoice Details');
                    $message->attach($path);
                    $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                });

                $usersnew = DB::Table('users')

                    ->where('employee_id', '=', $job->emid)

                    ->first();
                $data = array('name' => $pass->f_name . ' ' . $pass->l_name, 'com_name' => $com_name, 'address' => $add, 'users' => $usersnew, 'billing_type' => $job->billing_type, 'bill_for' => $job->bill_for);

                $toemail = $pass->authemail;

                if ($toemail != null || $toemail != '') {
                    Mail::send('mailbillsend', $data, function ($message) use ($toemail, $path) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ('Invoice Details');
                        $message->attach($path);
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });
                }
                $data = array('name' => $pass->f_name . ' ' . $pass->l_name, 'com_name' => $com_name, 'address' => $add, 'users' => $usersnew, 'billing_type' => $job->billing_type, 'bill_for' => $job->bill_for);

                $toemail = 'accounts@workpermitcloud.co.uk';
                //dd($toemail);
                Mail::send('mailbillsend', $data, function ($message) use ($toemail, $path) {
                    $message->to($toemail, 'skilledworkerscloud')->subject
                        ('Invoice Details');
                    $message->attach($path);
                    $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                });

                $dataimgedit = array(
                    'bill_send' => date('Y-m-d'),
                );
                DB::table('billing')

                    ->where('in_id', '=', base64_decode($send_id))
                    ->update($dataimgedit);

                $this->addAdminLog(4, 'Billing - Invoice mail sent for invoice no.: ' . base64_decode($send_id));
                Session::flash('message', 'Bill  send Successfully.');

                return redirect('superadmin/billing');
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeede(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $leave_allocation_rs = DB::table('employee')

                    ->where('emid', '=', $request->reg)

                    ->get();

                $data['result'] = '';

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('users')

                            ->where('employee_id', '=', $leave_allocation->emp_code)
                            ->where('emid', '=', $request->reg)

                            ->first();
                        if (!empty($pass)) {
                            $log_id = $pass->email;
                            $pass = $pass->password;
                        } else {
                            $log_id = '';
                            $pass = '';
                        }

                        $data['result'] .= '<tr>

													<td>' . $leave_allocation->emp_code . '</td>
														<td>' . $leave_allocation->emp_fname . ' ' . $leave_allocation->emp_mname . ' ' . $leave_allocation->emp_lname . '</td>
													<td>' . $leave_allocation->emp_department . '</td>
														<td>' . $leave_allocation->emp_designation . '</td>
														  <td>' . $log_id . '</td>
														  	  <td>' . $pass . '</td>




															<td>' . $leave_allocation->emp_ps_phone . '</td>

											 <td>

                   <a  class="btn-tool" data-toggle="tooltip" data-placement="bottom" title="Download" href="employee-report/' . base64_encode($leave_allocation->emid) . '/' . base64_encode($leave_allocation->emp_code) . '"><img style="width: 19px;"  src="' . env("BASE_URL") . 'assets/img/download.png" /></a>

                             </a></td>

						</tr>';
                        $f++;}
                }
                $data['employee_rs'] = DB::Table('registration')

                    ->get();
                $data['reg'] = $request->reg;
                return View('admin/employee-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveallcompanyemployee(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $leave_allocation_rs = DB::table('company_employee')

                    ->where('emid', '=', $request->reg)

                    ->get();

                $data['result'] = '';

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        if ($leave_allocation->name != '') {

                            $data['result'] .= '<tr>
					<td>' . $f . '</td>


														<td>' . $leave_allocation->name . ' </td>
													<td>' . $leave_allocation->department . '</td>
														<td>' . $leave_allocation->job_type . '</td>
														<td>' . $leave_allocation->designation . '</td>
															<td>' . $leave_allocation->immigration . '</td>









						</tr>';
                            $f++;}
                    }
                }

                $data['employee_rs'] = DB::Table('registration')

                    ->get();
                $data['reg'] = $request->reg;

                $this->addAdminLog(3, 'Organisation - Employee list viewed for company code: ' . $request->reg);

                return View('admin/oremployee-list', $data);
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function savereportroDataem(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $leave_allocation_rs = DB::table('company_employee')

                    ->where('emid', '=', $request->reg)

                    ->get();
                $Roledata = DB::table('registration')

                    ->where('reg', '=', $request->reg)
                    ->first();
                $data['Roledata'] = DB::table('registration')

                    ->where('reg', '=', $request->reg)
                    ->first();

                $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'emid' => $Roledata->reg, 'leave_allocation_rs' => $leave_allocation_rs];

                $this->addAdminLog(3, 'Organisation - Employee list for company code: ' . $Roledata->reg . ' downloaded in PDF format');

                $pdf = PDF::loadView('mypdfemployeecom', $datap);
                return $pdf->download('employeelisteport.pdf');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddCompanyreport($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            //dd('subadmin');
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $Roledata = DB::table('registration')

                    ->where('reg', '=', base64_decode($comp_id))
                    ->first();

                $datap = ['Roledata' => $Roledata];

                $this->addAdminLog(3, 'Organisation - Downloaded PDF of company code: ' . $Roledata->reg);

                $pdf = PDF::loadView('mypdforganization', $datap);
                return $pdf->download('organisationreport.pdf');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewAddEmployeereport($comp_id, $emp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $Roledata = DB::table('registration')

                    ->where('reg', '=', base64_decode($comp_id))
                    ->first();
                $employeedata = DB::table('employee')

                    ->where('emid', '=', base64_decode($comp_id))
                    ->where('emp_code', '=', base64_decode($emp_id))
                    ->first();

                $datap = ['Roledata' => $Roledata, 'employeedata' => $employeedata];

                $pdf = PDF::loadView('mypdfemployee', $datap);
                return $pdf->download('employeereport.pdf');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function DoLogin(Request $request)
    {
        try {
            //dd($request->all());
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'psw' => 'required',

            ],

                [
                    'email.required' => 'Email Required',
                    'psw.required' => 'Password Required',
                ]);

            if ($validator->fails()) {
                return redirect('superadmin')->withErrors($validator)->withInput();
            } else {

                // $Employee = DB::table('users')->where('email', '=', $request->email)->where('password', '=', $request->psw)->where('status', '=', 'active')->where('user_type', '=', 'admin')->first();
                $Employee = DB::table('users')->where('email', '=', $request->email)
                        ->where('password', '=', $request->psw)
                        ->where('status', '=', 'active')
                        ->whereIn('user_type', ['admin', 'sub-admin'])
                        ->first();

                //dd($Employee);
                if (!empty($Employee)) {
                    if ($Employee->user_type == 'admin') {
                        Session::put('empsu_name', $Employee->name);
                        Session::put('empsu_email', $request->email);
                        Session::put('usersu_type', $Employee->user_type);
                        Session::put('users_id', $Employee->id);
                        Session::put('empsu_pass', $request->psw);
                    } elseif ($Employee->user_type == 'sub-admin') {
                        //dd('okk');
                        Session::put('empsu_name', $Employee->name);
                        Session::put('empsu_email', $request->email);
                        Session::put('usersu_type', $Employee->user_type);
                        Session::put('users_id', $Employee->id);
                        Session::put('empsu_pass', $request->psw);
                        $data = DB::table('sub_admin_registrations')->where('email','=',$request->email)->where('status','=','active')->get();
                        $organization_code =  $data[0]->org_code;
                        Session::put('org_code', $organization_code);
                        // return redirect()->intended('subadmindasboard');superadmindasboard
                        return redirect()->intended('superadmindasboard');
                    }
                    // dd("hello");
                    // $randomNumber = mt_rand(100000, 999999);
                    // $base_url = env('BASE_URL');
                    // $data = ["otp" =>$randomNumber, "name" => $Employee->name, "url" => $base_url];
                    // $toemail = $request->email;
                    // $Employee = UserModel::where("email", $request->email)->first();

                    // if ($Employee) {
                    //     $Employee->otp = $randomNumber;
                    //     $Employee->save();
                    //     Mail::send("mailotp", $data, function ($message) use ($toemail) {
                    //     $message
                    //         ->to($toemail, env('MAIL_FROM_NAME'))
                    //         ->subject("OTP Validation");
                    //     $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
                    // });

                    // }
                    // dd('helo');
                    // return redirect()->intended("adminotpvalidate");
                     return redirect()->intended('superadmindasboard');
                }else {
                    $Employee = DB::table('users_admin_emp')->where('email', '=', $request->email)->where('password', '=', $request->psw)->where('status', '=', 'active')->first();
                    //dd($Employee);
                    if (!empty($Employee)) {
                        if ($Employee->user_type == 'user') {
                            Session::put('empsu_email', $request->email);
                            Session::put('usersu_type', $Employee->user_type);
                            Session::put('users_id', $Employee->id);
                            Session::put('empsu_pass', $request->psw);
                            Session::put('empsu_name', $Employee->name);
                            $member = $Employee->employee_id;
                            //dd($member);
                            $Roles_auth = DB::table('role_authorization_admin_emp')->where('member_id', '=', $member)->get();
                            $arrrole = array();
                            foreach ($Roles_auth as $valrol) {
                                $arrrole[] = $valrol->module_name;
                            }
                           // dd($arrrole);
                            Session::put('empsu_role', $arrrole);
                        }
                        // $randomNumber = mt_rand(100000, 999999);
                        // $base_url = env('BASE_URL');
                        // $data = ["otp" =>$randomNumber, "name" => $Employee->name, "url" => $base_url];
                        // $toemail = $request->email;
                        // $Employee = UserModel::where("email", $request->email)->first();
                        // if ($Employee) {
                        //     $Employee->otp = $randomNumber;
                        //     $Employee->save();
                        //     Mail::send("mailotp", $data, function ($message) use ($toemail) {
                        //         $message
                        //             ->to($toemail, "SWCH")
                        //             ->subject("OTP Validation");
                        //         $message->from("noreply@eitclimbr.in", "Swch");
                        //     });
                        // }
                        // return redirect()->intended("adminotpvalidate");
                        //dd($Roles_auth);
                        // dd(Session::get('empsu_role'));
                        return redirect()->intended('superadmindasboard');
                    } else {
                        Session::flash('error', 'Your email or password is wrong!!');
                        return redirect('superadmin');
                    }
                }
            }
            //  @if(auth()->check())
            //auth()->user()->name
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function otp(Request $request){
        try {
            $email = Session::get("empsu_email");
            if (!empty($email)) {
                return view("adminotp");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }
    public function otpsend(Request $request){
        try {
            $email = Session::get("empsu_email");
            if (!empty($email)) {
                // dd($email);
                $randomNumber = mt_rand(100000, 999999);
                $base_url = env('BASE_URL');
                $toemail = $email;
                $Employee = UserModel::where("email", $email)->first();
                $data = ["otp" =>$randomNumber, "name" => $Employee->name, "url" => $base_url];
                if ($Employee) {
                    $Employee->otp = $randomNumber;
                    $Employee->save();
                    Mail::send("mailotp", $data, function ($message) use ($toemail) {
                        $message
                            ->to($toemail, "SWCH")
                            ->subject("OTP Validation");
                        $message->from("noreply@eitclimbr.in", "Swch");
                    });
                }

                //return redirect()->intended("employerdashboard");
                Session::flash("message", "Send otp check your mail!!");
                return redirect()->back();
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function otpvalidate(Request $request)
    {
        try {
            $email = Session::get("empsu_email");
            if (!empty($email)) {
                $Employee = UserModel::where("email", $email)
                    ->where("otp", $request->otp)
                    ->first();
                if (!empty($Employee)) {
                    // Successful OTP validation, redirect to employerdashboard
                    return redirect()->intended('superadmindasboard');
                } else {
                    // Invalid OTP
                    Session::flash("error", "Your otp is wrong!!");
                    return redirect()->back();
                }
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function Logout(Request $request)
    {Session::forget('users_id');
        Session::forget('usersu_type');
        Session::forget('empsu_pass');
        Session::forget('empsu_email');
        Session::flash('message', 'You are successfully Logout.');
        return redirect('superadmin');

    }

    public function getCompanies()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['companies_rs'] = DB::table('registration')

                    ->get();

                return view('admin/company', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesactive(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            $org_code = Session::get('org_code');
             //dd($org_code);

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType == 'sub-admin'){
                    //$email =  $data[0]->org_code;
                    $org_code = Session::get('org_code');
                    //dd($org_code);
                } else {
                    $org_code ='';
                }
                //dd($org_code);
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {

                    $data['companies_rs'] = DB::table('registration')
                        ->where('status', '=', 'active')
                    // ->where('verify', '=', 'not approved')
                    // ->where('licence', '=', 'no')
                        ->whereBetween('created_at', [$start_date, $end_date])
                       ->where(function($query) use ($org_code) {
                            if ($org_code !== '') {
                                $query->where('org_code', $org_code);
                            } else {
                                $query->where('org_code', '')
                                    ->orWhereNull('org_code');
                            }
                        })
                        ->orderBy('id', 'desc')
                        ->get();
                    // dd($data['companies_rs']);
                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->where('status', '=', 'active')
                    // ->where('verify', '=', 'not approved')
                        ->where(function($query) use ($org_code) {
                            if ($org_code !== '') {
                                $query->where('org_code', $org_code);
                            } else {
                                $query->where('org_code', '')
                                    ->orWhereNull('org_code');
                            }
                        })
                        ->orderBy('id', 'desc')
                        ->get();
                        // dd($data['companies_rs']);
                }

                $this->addAdminLog(3, 'Organisation - Active Organisation list view.');

                return view('admin/activecompany', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesactive_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                //dd($request->all());
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(3, 'Organisation - Registered Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('active', $start_date, $end_date), 'Registered Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesinactive()
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['companies_rs'] = DB::table('registration')

                    ->where('status', '=', 'inactive')
                    ->where('verify', '=', 'not approved')
                    ->where('licence', '=', 'no')
                    ->orderBy('id', 'desc')

                    ->get();

                return view('admin/inactivecompany', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesverify(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            $org_code = Session::get('org_code');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType=='sub-admin'){
                    //$email =  $data[0]->org_code;
                    $org_code = Session::get('org_code');
                    //dd($org_code);
                } else {
                    $org_code ='';
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select remark_su from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_remarks"), DB::raw("(select assign_date from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_date"))
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'no')
                        ->whereBetween(DB::raw("(DATE(registration.verified_on))"), [$request->start_date, $request->end_date])
                        ->where(function($query) use ($org_code) {
                                    if ($org_code !== '') {
                                        $query->where('org_code', $org_code);
                                    } else {
                                        $query->where('org_code', '')
                                            ->orWhereNull('org_code');
                                    }
                                })
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select remark_su from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_remarks"), DB::raw("(select assign_date from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_date"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'no')
                        ->where(function($query) use ($org_code) {
                            if ($org_code !== '') {
                                $query->where('org_code', $org_code);
                            } else {
                                $query->where('org_code', '')
                                    ->orWhereNull('org_code');
                            }
                        })
                        ->orderBy('id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - Verified Organisation list view.');
        //dd($data);
                return view('admin/verifycompany', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesverify_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(3, 'Organisation - Verified Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('verified', $start_date, $end_date), 'Verified Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesNotAssigned(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $assignedOrgs = DB::Table('role_authorization_admin_organ')
                    ->whereNotNull('role_authorization_admin_organ.module_name')
                    ->pluck('role_authorization_admin_organ.module_name');

                if ($start_date != '' && $end_date != '') {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*')
                        ->whereNotIn('registration.reg', $assignedOrgs)
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'not approved')
                        ->where('registration.licence', '=', 'no')
                        ->whereBetween('registration.created_at', [$start_date, $end_date])
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*')
                        ->whereNotIn('registration.reg', $assignedOrgs)
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'not approved')
                        ->where('registration.licence', '=', 'no')
                        ->orderBy('registration.id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - Not assigned Organisation list view.');

                return view('admin/notassignedcompany', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesAssigned(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $assignedOrgs = DB::Table('role_authorization_admin_organ')
                    ->whereNotNull('role_authorization_admin_organ.module_name')
                    ->pluck('role_authorization_admin_organ.module_name');

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`created_at`) FROM `role_authorization_admin_organ` WHERE `module_name` LIKE  `registration`.`reg`) as assign_date"), DB::raw("(SELECT GROUP_CONCAT(users_admin_emp.name) FROM `role_authorization_admin_organ` INNER JOIN users_admin_emp ON users_admin_emp.employee_id=role_authorization_admin_organ.member_id WHERE `module_name` LIKE  `registration`.`reg`) as caseworker"))
                        ->whereIn('registration.reg', $assignedOrgs)
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'not approved')
                        ->where('registration.licence', '=', 'no')
                        ->whereBetween(DB::raw("(SELECT max(`created_at`) FROM `role_authorization_admin_organ` WHERE `module_name` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->orderBy('registration.id', 'desc')
                        ->get();
                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`created_at`) FROM `role_authorization_admin_organ` WHERE `module_name` LIKE  `registration`.`reg`) as assign_date"), DB::raw("(SELECT GROUP_CONCAT(users_admin_emp.name) FROM `role_authorization_admin_organ` INNER JOIN users_admin_emp ON users_admin_emp.employee_id=role_authorization_admin_organ.member_id WHERE `module_name` LIKE  `registration`.`reg`) as caseworker"))
                        ->whereIn('registration.reg', $assignedOrgs)
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'not approved')
                        ->where('registration.licence', '=', 'no')
                        ->orderBy('registration.id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - Assigned Organisation list view.');

                return view('admin/assignedcompany', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesNotAssigned_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                //ssdd($request->all());

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - Not assigned Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('unassigned', $start_date, $end_date), 'Unassigned Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesAssigned_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - Assigned Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('assigned', $start_date, $end_date), 'Assigned Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesnot()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            $org_code = Session::get('org_code');
            //dd($org_code);
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType=='sub-admin'){
                    $org_code = Session::get('org_code');
                } else {
                    $org_code ='';
                }
                $data['companies_rs'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('verify', '=', 'not approved')
                ->where('licence', '=', 'no')
               ->where(function($query) use ($org_code) {
                    if ($org_code !== '') {
                        $query->where('org_code', $org_code);
                    } else {
                        $query->where('org_code', '')
                            ->orWhereNull('org_code');
                    }
                })
                ->orderBy('id', 'desc')
                ->get();

                $this->addAdminLog(3, 'Organisation - Not Verified Organisation list view.');



                return view('admin/notverifycompany', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getemployerjob()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['companies_rs'] = DB::table('job_emp')
                    ->where('status', '=', 'active')

                    ->get();

                return view('admin/jobemployer', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getfresherjob()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['companies_rs'] = DB::table('can_fresh')
                    ->where('status', '=', 'active')

                    ->get();

                return view('admin/fresher', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getexperiencejob()
    {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            $data['companies_rs'] = DB::table('can_experience')
                ->where('status', '=', 'active')

                ->get();

            return view('admin/experience', $data);
        } else {
            return redirect('superadmin');
        }
    }
    public function getCompanieslice(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType == 'sub-admin'){
                    $org_code = Session::get('org_code');
                } else {
                    $org_code = '';
                }
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                    // ->whereBetween('updated_at', [$start_date, $end_date])
                        ->where(function($query) {
                            $query->where('org_code', '')
                            ->orWhereNull('org_code');
                        })
                        ->orderBy('id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->where(function($query) {
                            $query->where('org_code', '')
                            ->orWhereNull('org_code');
                        })
                        ->orderBy('id', 'desc')
                        ->get();
                }
//dd($data['companies_rs']);
                $this->addAdminLog(3, 'Organisation - License Applied Organisation list view.');

                return view('admin/licencecompany', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompanieslice_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(3, 'Organisation - License Applied Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('license_applied', $start_date, $end_date), 'License Applied Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesWithInternalLicense(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->where('license_type', '=', 'Internal')
                    // ->whereBetween('updated_at', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->orderBy('id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->where('license_type', '=', 'Internal')
                        ->orderBy('id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - License Internal Organisation list view.');

                return view('admin/licencecompany-internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesWithInternalLicense_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License Internal Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('license_internal', $start_date, $end_date), 'License Internal Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesWithExternalLicense_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License External Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('license_external', $start_date, $end_date), 'License External Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesWithExternalLicense(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->where('license_type', '=', 'External')
                    //->whereBetween('updated_at', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->orderBy('id', 'desc')
                        ->get();

                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->where('license_type', '=', 'External')
                        ->orderBy('id', 'desc')
                        ->get();

                }

                $this->addAdminLog(3, 'Organisation - License External Organisation list view.');

                return view('admin/licencecompany-external', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesUnbilledFirstInvInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $billed1stOrgs = DB::Table('billing')
                    ->where('bill_for', '=', 'invoice for license applied')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        //->where('licence', '=', 'yes')
                        ->whereNotIn('reg', $billed1stOrgs)
                        ->where('license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->orderBy('id', 'desc')
                        ->get();

                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                       // ->where('licence', '=', 'yes')
                        ->whereNotIn('reg', $billed1stOrgs)
                        ->where('license_type', '=', 'Internal')
                        ->orderBy('id', 'desc')
                        ->get();

                }

                $this->addAdminLog(3, 'Organisation - Unbilled 1st Invoice list view.');

                return view('admin/unbilled_first_inv_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesBilledFirstInvInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $billed1stOrgs = DB::Table('billing')
                    ->where('bill_for', '=', 'invoice for license applied')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license applied' and `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel') as billing_date"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        //->where('licence', '=', 'yes')
                        ->whereIn('reg', $billed1stOrgs)
                        ->where('license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license applied' and `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel')"), [$start_date, $end_date])
                        ->orderBy('id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license applied' and `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel') as billing_date"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                       // ->where('licence', '=', 'yes')
                        ->whereIn('reg', $billed1stOrgs)
                        ->where('license_type', '=', 'Internal')
                        ->orderBy('id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - Billed 1st Invoice list view.');

                return view('admin/billed_first_inv_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesUnassignedHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $hrFileOrgs = DB::Table('hr_apply')
                    ->pluck('hr_apply.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->whereNotIn('reg', $hrFileOrgs)
                        ->where('license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->orderBy('id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->whereNotIn('reg', $hrFileOrgs)
                        ->where('license_type', '=', 'Internal')
                        ->orderBy('id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - Unassigned HR list view.');

                return view('admin/unassignedhr_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesAssignedHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $hrFileOrgs = DB::Table('hr_apply')
                    ->pluck('hr_apply.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->whereIn('reg', $hrFileOrgs)
                        ->where('license_type', '=', 'Internal')
                    //->whereBetween('updated_at', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->orderBy('id', 'desc')
                        ->get();

                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('status', '=', 'active')
                        ->where('verify', '=', 'approved')
                        ->where('licence', '=', 'yes')
                        ->whereIn('reg', $hrFileOrgs)
                        ->where('license_type', '=', 'Internal')
                        ->orderBy('id', 'desc')
                        ->get();

                }

                //dd( $data['companies_rs'][0]);

                $this->addAdminLog(3, 'Organisation - Assigned HR list view.');

                return view('admin/assignedhr_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesWipHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('hr_apply.status', '=', 'Incomplete')
                        ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                    //->where('hr_apply.licence', '=', 'Pending Decision')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('hr_apply.status', '=', 'Incomplete')
                    //->where('hr_apply.licence', '=', 'Pending Decision')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                }

                $this->addAdminLog(3, 'Organisation - WIP HR list view.');

                return view('admin/wiphr_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesCompleteHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $allLicHr = DB::Table('hr_apply')
                ->where(function ($query) {
                    $query->where('hr_apply.licence', '=', 'Refused')
                        ->orWhere('hr_apply.licence', '=', 'Granted')
                        ->orWhere('hr_apply.licence', '=', 'Rejected');
                })
                ->distinct()
                ->pluck('hr_apply.emid');

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid', 'inner')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('hr_apply.status', '=', 'Complete')
                        ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        //->whereNotIn('registration.reg', $allLicHr)

                    //->where('hr_apply.licence', '=', 'Pending Decision')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid', 'inner')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('hr_apply.status', '=', 'Complete')
                    //->where('hr_apply.licence', '=', 'Pending Decision')
                        //->whereNotIn('registration.reg', $allLicHr)
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - Complete HR list view.');

                return view('admin/completehr_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesGrantedHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT max(`grant_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                    // ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                    // ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                }

                $this->addAdminLog(3, 'Organisation - License Granted list view.');

                return view('admin/grantedhr_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesRejectedHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT max(`reject_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                    // ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Rejected')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                    // ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Rejected')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                }

                $this->addAdminLog(3, 'Organisation - License Rejected list view.');

                return view('admin/rejectedhr_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesRefusedHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT max(`refused_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                    // ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Refused')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {

                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                    // ->where('hr_apply.status', '=', 'Complete')
                        ->where('hr_apply.licence', '=', 'Refused')
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - License Refused list view.');

                return view('admin/refusedhr_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesPdHrInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $allLicHr = DB::Table('hr_apply')
                    ->where(function ($query) {
                        $query->where('hr_apply.licence', '=', 'Refused')
                            ->orWhere('hr_apply.licence', '=', 'Granted')
                            ->orWhere('hr_apply.licence', '=', 'Rejected');

                    })
                    ->distinct()
                    ->pluck('hr_apply.emid');


                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::Table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereNotIn('registration.reg', $allLicHr)
                    //->whereBetween('registration.created_at', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                } else {
                    $data['companies_rs'] = DB::Table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereNotIn('registration.reg', $allLicHr)
                        ->distinct()
                        ->orderBy('registration.id', 'desc')
                        ->get();

                }

                $this->addAdminLog(3, 'Organisation - License Pending list view.');

                return view('admin/license_pending_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesUnbilledSecondInvInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $billed2ndOrgs = DB::Table('billing')
                    ->where('bill_for', '=', 'invoice for license granted')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::Table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->whereNotIn('registration.reg', $billed2ndOrgs)
                        ->distinct()
                        ->get();

                } else {

                    $data['companies_rs'] = DB::Table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->whereNotIn('registration.reg', $billed2ndOrgs)
                        ->distinct()
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - License Unbilled Second Invoice list view.');

                return view('admin/license_unbill_secinv_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesUnbilledSecondInvInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License Unbilled Second Invoice Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('license_unbill_second_inv_internal', $start_date, $end_date), 'License Unbilled Second Invoice Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesBilledSecondInvInternal(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $billed2ndOrgs = DB::Table('billing')
                    ->where('bill_for', '=', 'invoice for license granted')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date) && $request->start_date != '') {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date) && $request->end_date != '') {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::Table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license granted' and `emid` LIKE  `registration`.`reg` and billing.status <> 'cancel') as bill_date"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license granted' and `emid` LIKE  `registration`.`reg` and billing.status <> 'cancel')"), [$start_date, $end_date])
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->whereIn('registration.reg', $billed2ndOrgs)
                        ->distinct()
                        ->get();

                } else {

                    $data['companies_rs'] = DB::Table('registration')
                        ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license granted' and `emid` LIKE  `registration`.`reg`) as bill_date"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                        ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->where('hr_apply.licence', '=', 'Granted')
                        ->whereIn('registration.reg', $billed2ndOrgs)
                        ->distinct()
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - License Billed Second Invoice list view.');

                return view('admin/license_bill_secinv_org_internal', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesBilledSecondInvInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License Billed Second Invoice Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('license_bill_second_inv_internal', $start_date, $end_date), 'License Billed Second Invoice Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesPdHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License Pending Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('license_pending_internal', $start_date, $end_date), 'License Pending Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesRefusedHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License Refused Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('refused_hr_internal', $start_date, $end_date), 'License Refused Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesGrantedHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License Granted Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('granted_hr_internal', $start_date, $end_date), 'License Granted Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesRejectedHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - License Rejected Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('rejected_hr_internal', $start_date, $end_date), 'License Rejected Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesWithExternalLicen_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $this->addAdminLog(3, 'Organisation - License External Organisation list export');
                return Excel::download(new ExcelFileExportOrganisation('license_external'), 'License External Organisation.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCompaniesUnbilledFirstInvInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - Unbilled 1st Invoice list export');
                return Excel::download(new ExcelFileExportOrganisation('unbilled_first_inv_internal', $start_date, $end_date), 'Unbilled 1st Invoice.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesBilledFirstInvInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - Billed 1st Invoice list export');
                return Excel::download(new ExcelFileExportOrganisation('billed_first_inv_internal', $start_date, $end_date), 'Billed 1st Invoice.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesUnassignedHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - Unassigned Hr list export');
                return Excel::download(new ExcelFileExportOrganisation('unassigned_hr_internal', $start_date, $end_date), 'UnassignedHr.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesAssignedHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - Assigned Hr list export');
                return Excel::download(new ExcelFileExportOrganisation('assigned_hr_internal', $start_date, $end_date), 'AssignedHr.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesWipHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - WIP Hr list export');
                return Excel::download(new ExcelFileExportOrganisation('wip_hr_internal', $start_date, $end_date), 'WipHr.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesCompleteHrInternal_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }

                $this->addAdminLog(3, 'Organisation - Complete Hr list export');
                return Excel::download(new ExcelFileExportOrganisation('complete_hr_internal', $start_date, $end_date), 'CompleteHr.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesnotlicen()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType == 'sub-admin'){
                   $org_code = Session::get('org_code');
                   //dd($org_code);
                } else {
                    $org_code = '';
                }

                $data['companies_rs'] = DB::table('registration')

                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'no')
                   ->where(function($query) use ($org_code) {
                        if ($org_code !== '') {
                            $query->where('org_code', $org_code);
                        } else {
                            $query->where('org_code', '')
                                ->orWhereNull('org_code');
                        }
                    })
                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(3, 'Organisation - License Not Applied Organisation list view.');

                return view('admin/notlicencecompany', $data);
            } else {

                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddCompany($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            //dd('subadmin');
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['Roledata'] = DB::table('registration')

                    ->where('id', '=', $comp_id)
                    ->first();
                $data['cuurenci_master'] = DB::table('currencies')->get();
                $data['nat_or_master'] = DB::table('nat_or')->get();
                $data['type_or_master'] = DB::table('type_or')->get();
                $data['employee_upload_rs'] = DB::table('company_upload')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                $data['employee_or_rs'] = DB::table('company_employee')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $this->addAdminLog(3, 'Organisation - Edit form opened for company code: ' . $data['Roledata']->reg);
                return View('admin/edit-company', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveCompany(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            //dd($userType);
            if (!empty($email)) {

                $email = Session::get('empsu_email');

                if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'no') {

                    $data = array(
                        'status' => $request->status,
                        'verify' => $request->verify,
                        'employee_link' => env("BASE_URL") . 'new-employee/' . base64_encode($request->reg),

                    );

                    DB::table('registration')->where('reg', $request->reg)->update($data);
                }
                if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'yes') {
                    //dd($request->all());
                    $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email, 'pass' => $request->pass);
                    $toemail = $request->email;
                    Mail::send('mailorupli', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ('Make your HR file ready');
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });
                    $data = array(
                        'status' => $request->status,
                        'verify' => $request->verify,
                        'licence' => $request->licence,
                        'license_type' => $request->license_type,

                    );
                    DB::table('registration')->where('reg', $request->reg)->update($data);
                } else {

                    $data = array(
                        'status' => $request->status,
                        'verify' => $request->verify,
                        'licence' => $request->licence,
                        'license_type' => $request->license_type,
                    );

                    DB::table('registration')->where('reg', $request->reg)->update($data);
                }

                $datau = array(
                    'status' => $request->status,

                );

                DB::table('users')->where('employee_id', $request->reg)->update($datau);

                $exits = DB::table('users')->where('employee_id', $request->reg)->first();

                if ($request->status == 'inactive') {

                    $datau = array(
                        'email' => $exits->email . 'inactive',

                    );

                    DB::table('users')->where('employee_id', $request->reg)->update($datau);

                    $datau = array(
                        'email' => $exits->email . 'inactive',
                        'inactive_remarks' => $request->inactive_remarks,

                    );

                    DB::table('registration')->where('reg', $request->reg)->update($datau);

                }

                $this->addAdminLog(3, 'Organisation - Updated data for company code: ' . $request->reg);

                $toemail=$request->email;
                // $toemail='boton.cob2@gmail.com';
                //dd($toemail);
                if ($toemail != '') {
                    // dd($exits);
                    $subDtl = DB::table('sub_admin_registrations')->where('email', $email)->where('verify','=','approved')->first();
                    $data = ["name" =>$exits->name, "email" =>$exits->email, "password" =>$exits->password,"sub_comname"=>$subDtl->com_name, "sub_address"=>$subDtl->address, "sub_zip"=>$subDtl->zip, "sub_country"=>$subDtl->country, "sub_email"=>$subDtl->email];
                    Mail::send('org-approved', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ('Organisation Approved');
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });
                }
                if($userType == 'sub-admin'){
                    $verification = DB::table('registration')->where('reg', $request->reg)->where('verify','=','approved')->first();
                    $subDtl = DB::table('sub_admin_registrations')->where('email', $email)->where('verify','=','approved')->first();
                    if($verification ){
                        $toemail = 'infoswc@skilledworkerscloud.co.uk';
                        $data = ["name" =>$exits->name, "email" =>$exits->email, "password" =>$exits->password,"sub_comname"=>$subDtl->com_name, "sub_fname"=>$subDtl->f_name, "sub_lname"=>$subDtl->l_name,"subadmin_email"=>$subDtl->email,"subadmin_phone"=>$subDtl->p_no];
                        Mail::send('child-verify-email', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Sub Admin Child Registration Verification');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }
                }

                Session::flash('message', 'Organisation Information Successfully Updated.');

                if ($request->status == 'active' && $request->verify == 'not approved' && $request->licence == 'no') {
                    return redirect('superadmin/active');
                } else if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'no') {
                    return redirect('superadmin/verify');
                } else if ($request->status == 'inactive' && $request->verify == 'not approved' && $request->licence == 'no') {
                    //return redirect('superadmin/inactive');
                    return redirect('superadmindasboard');
                } else if ($request->status == 'inactive' && $request->verify == 'approved' && $request->licence == 'no') {
                     //return redirect('superadmin/inactive');
                    return redirect('superadmindasboard');
                } else if ($request->status == 'inactive' && $request->verify == 'approved' && $request->licence == 'yes') {
                     //return redirect('superadmin/inactive');
                     return redirect('superadmindasboard');
                } else if ($request->status == 'inactive' && $request->verify == 'not approved' && $request->licence == 'yes') {
                     //return redirect('superadmin/inactive');
                     return redirect('superadmindasboard');
                } else if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'yes') {
                    return redirect('superadmin/license-applied');
                }

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddbillingy($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $data['recruitment_file_emp'] = DB::table('recruitment_file_emp')->where('bill_no', base64_decode($comp_id))->first();
                $data['cos_apply_emp'] = DB::table('cos_apply_emp')->where('bill_no', base64_decode($comp_id))->first();

                $data['bill'] = DB::table('billing')

                    ->where('in_id', '=', base64_decode($comp_id))
                    ->get();
                $data['package_rs'] = DB::Table('package')
                    ->where('status', '=', 'active')
                    ->get();
                //dd($data);
                return View('admin/bill-edit-new', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function saveAddbillingy(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                //dd($request->all());

                $recruitmentFirstBillValid = false;
                $recruitmentSecondBillValid = false;

                if ($request->bill_for == 'first invoice recruitment service') {
                    if ($request->billing_type == 'Organisation') {
                        if ($request->rec_candidate_name == '') {
                            $recruitmentFirstBillValid = false;
                        } else {
                            $recruitmentFirstBillValid = true;
                        }

                    } else {
                        $recruitmentFirstBillValid = false;
                    }
                }

                if ($request->bill_for == 'second invoice visa service') {
                    if ($request->billing_type == 'Organisation') {
                        if ($request->rec_candidate_name == '') {
                            $recruitmentSecondBillValid = false;
                        } else {
                            $recruitmentSecondBillValid = true;
                        }

                    } else {
                        $recruitmentSecondBillValid = false;
                    }
                }

                $allValidDiscountVals = true;
                //validate all discount value to be proper
                if ($request->package && count($request->package) != 0) {
                    for ($i = 0; $i < count($request->package); $i++) {

                        if ($request->discount_type[$i] == 'P') {

                            if (((float) $request->discount[$i]) > 100 || ((float) $request->discount[$i]) < 0) {
                                $allValidDiscountVals = false;
                            }
                        }
                        if ($request->discount_type[$i] == 'A') {

                            if (((float) $request->discount[$i]) > ((float) $request->anount_ex_vat[$i]) || ((float) $request->discount[$i]) < 0) {
                                $allValidDiscountVals = false;
                            }
                        }

                    }
                }
                if ($allValidDiscountVals == false) {
                    Session::flash('error', 'Discount is not in proper format.');
                    return redirect('superadmin/add-billing');
                }

                if (File::exists(public_path('billpdf/' . $request->dom_pdf))) {
                    File::delete(public_path('billpdf/' . $request->dom_pdf));
                }

                $rec_candidate_info = array();
                if ($recruitmentFirstBillValid) {
                    // $dummyDes = $request->des;
                    // for ($j = 0; $j < count($request->des); $j++) {
                    //     $removeStr = ' (Candidate : ' . $request->rec_candidate_name . ')';
                    //     $existingStr = $request->des[$j];
                    //     $existingStr = str_replace($removeStr, '', $existingStr);
                    //     $dummyDes[$j] = $existingStr . ' (Candidate : ' . $request->rec_candidate_name . ')';
                    //     //$request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';

                    // }
                    // $request->des = $dummyDes;
                    $rec_candidate_info = DB::table('recruitment_file_emp')
                        ->where('emid', $request->emid)
                        ->where('employee_name', $request->rec_candidate_name)
                        ->first();

                    $request->canidate_name = $rec_candidate_info->employee_name;
                    $request->canidate_email = $rec_candidate_info->employee_email;
                    $request->candidate_id = '0';
                    $request->candidate_address = $rec_candidate_info->employee_address;

                }
                if ($recruitmentSecondBillValid) {
                    // $dummyDes = $request->des;
                    // for ($j = 0; $j < count($request->des); $j++) {
                    //     $removeStr = ' (Candidate : ' . $request->rec_candidate_name . ')';
                    //     $existingStr = $request->des[$j];
                    //     $existingStr = str_replace($removeStr, '', $existingStr);
                    //     $dummyDes[$j] = $existingStr . ' (Candidate : ' . $request->rec_candidate_name . ')';
                    //     //$request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';

                    // }
                    // $request->des = $dummyDes;
                    //                            $request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';
                    $rec_candidate_info = DB::table('recruitment_file_emp')
                        ->where('emid', $request->emid)
                        ->where('employee_name', $request->rec_candidate_name)
                        ->first();

                    $request->canidate_name = $rec_candidate_info->employee_name;
                    $request->canidate_email = $rec_candidate_info->employee_email;
                    $request->candidate_id = '0';
                    $request->candidate_address = $rec_candidate_info->employee_address;

                }

                if ($recruitmentFirstBillValid == false && $recruitmentSecondBillValid == false) {
                    $request->bill_to = $request->billing_type;
                } else {
                    $request->bill_to = $request->bill_to;
                }

                $Roledata = DB::Table('registration')

                    ->where('reg', '=', $request->emid)
                    ->first();

                $datap = [
                    'Roledata' => $Roledata,
                    'in_id' => $request->in_id,
                    'des' => $request->des,
                    'date' => date('Y-m-d'),
                    'package' => $request->package,
                    'net_amount' => $request->net_amount,
                    'discount_type' => $request->discount_type,
                    'discount' => $request->discount,
                    'discount_amount' => $request->discount_amount,
                    'anount_ex_vat' => $request->anount_ex_vat,
                    'vat' => $request->vat,
                    'amount_after_vat' => $request->amount_after_vat,
                    'billing_type' => $request->billing_type,
                    'canidate_name' => $request->canidate_name,
                    'candidate_id' => $request->candidate_id,
                    'candidate_address' => $request->candidate_address,
                    'bill_for' => $request->bill_for,
                    'bill_to' => $request->bill_to,
                    'rec_candidate_info' => $rec_candidate_info,
                ];

                //dd($datap);

                $pdf = PDF::loadView('mybillPDFNew', $datap);
                $filename = $request->dom_pdf;
                $pdf->save(public_path() . '/billpdf/' . $filename);

                $billexit = DB::Table('billing')

                    ->where('in_id', '=', $request->in_id)
                    ->first();
                $dateex = $billexit->date;
                DB::table('billing')->where('in_id', '=', $request->in_id)->delete();

                $totamount = 0;
                if ($request->package && count($request->package) != 0) {
                    for ($i = 0; $i < count($request->package); $i++) {

                        $totamount = $totamount + $request->net_amount[$i];

                    }
                }

                if ($request->package && count($request->package) != 0) {
                    for ($i = 0; $i < count($request->package); $i++) {

                        $discount = $request->discount[$i];
                        $discount_p = 0;
                        if ($request->discount_type[$i] == 'P') {

                            $discount = 0;
                            $discount_p = $request->discount[$i];

                            $discount = round(((((float) $request->anount_ex_vat[$i]) * ((float) $discount_p)) / 100), 2);
                        }

                        $data = array(

                            'in_id' => $request->in_id,
                            'emid' => $request->emid,
                            'status' => 'not paid',
                            'amount' => $totamount,
                            'due' => $totamount,
                            'des' => htmlspecialchars($request->des[$i]),
                            'date' => $dateex,
                            'dom_pdf' => $filename,
                            'discount' => $discount,
                            'discount_percent' => $discount_p,
                            'discount_type' => $request->discount_type[$i],
                            'discount_amount' => $request->discount_amount[$i],
                            'anount_ex_vat' => $request->anount_ex_vat[$i],
                            'vat' => $request->vat[$i],
                            'amount_after_vat' => $request->amount_after_vat[$i],
                            'net_amount' => $request->net_amount[$i],
                            'package' => $request->package[$i],
                            'hold_st' => $request->hold_st,
                            'other' => $request->other,
                            'pay_mode' => $request->pay_mode,
                            'canidate_name' => $request->canidate_name,
                            'canidate_email' => $request->canidate_email,
                            'candidate_id' => $request->candidate_id,
                            'candidate_address' => $request->candidate_address,
                            'billing_type' => $request->billing_type,
                            'bill_for' => $request->bill_for,
                            'bill_to' => $request->bill_to,
                        );

                        DB::table('billing')->insert($data);
                        $recruitment_file_emp = DB::table('recruitment_file_emp')->where('bill_no', $request->in_id)->first();

                        if (!empty($recruitment_file_emp)) {

                            if ($request->bill_for == 'first invoice recruitment service') {

                                $dataRec = array(
                                    'billed_first_invoice' => 'Yes',
                                    'bill_no' => $request->in_id,
                                );
                                DB::table('recruitment_file_emp')->where('id', $recruitment_file_emp->id)->update($dataRec);
                            }

                        }

                        $cos_apply_emp = DB::table('cos_apply_emp')->where('bill_no', $request->in_id)->first();

                        if (!empty($cos_apply_emp)) {

                            if ($request->bill_for == 'second invoice visa service') {

                                $dataCos = array(
                                    'billed_second_invoice' => 'Yes',
                                    'bill_no' => $request->in_id,
                                );
                                DB::table('cos_apply_emp')->where('id', $cos_apply_emp->id)->update($dataCos);
                            }

                        }

                    }
                }

                $this->addAdminLog(4, 'Billing- Updated invoice with invoice no.: ' . $request->in_id);
                Session::flash('message', 'Bill Changed Successfully .');

                return redirect('superadmin/billing');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    //Billing remarks
    public function viewBillingRemarks($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::table('billing')
                    ->where('id', '=', base64_decode($comp_id))
                    ->first();

                $data['billing_remarks'] = DB::Table('billing_remarks')
                    ->where('billing_id', '=', base64_decode($comp_id))
                    ->get();

                //dd($data['bill']);

                return View('admin/bill-remark-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveBillingRemarks(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            $userId = Session::get('users_id');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $userInfo= DB::table('users')
                    ->where('id', '=', $userId)
                    ->first();

               // dd(session()->all());
                //dd($request->all());

                $model  = new BillingRemark;
                $model->billing_id    = $request->billing_id;
                $model->added_by    = $userInfo->name;
                $model->remarks    = $request->remarks;
                $model->save();

                Session::flash('message', 'Bill Remarks Successfully saved.');
                return redirect('superadmin/remarks-billing/'.base64_encode($request->billing_id));

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function deleteBillingRemarks($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');


            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }


                $id=base64_decode($comp_id);
                $model = BillingRemark::find($id);
                if(!$model){
                    throw new Exception("No result was found for id: $id");
                }

                $billing_id=$model->billing_id;
                $model->delete();

                Session::flash('message', 'Record Deleted Successfully.');

                return redirect('superadmin/remarks-billing/'.base64_encode($billing_id));

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }


    public function savereportroDataemexcel(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $leave_allocation_rs = DB::table('company_employee')

                    ->where('emid', '=', $request->reg)

                    ->get();
                $Roledata = DB::table('registration')

                    ->where('reg', '=', $request->reg)
                    ->first();
                $data['Roledata'] = DB::table('registration')

                    ->where('reg', '=', $request->reg)
                    ->first();

                $this->addAdminLog(3, 'Organisation - Employee list for company code: ' . $Roledata->reg . ' downloaded in EXCEL format');

                return Excel::download(new ExcelFileExportOrganEmployee($request->reg), 'Organisationemployee.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewUserConfig()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['users'] = DB::table('users_admin_emp')->get();
                $this->addAdminLog(5, 'Employee list view.');
                return view('admin/view-users', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewUserConfigForm()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                return view('admin/view-user-config');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function SaveUserConfigForm(Request $request)
    {
        try {
            if (!empty(Session::get('empsu_email'))) {
                $email = Session::get('empsu_email');

                if (!empty($request->id)) {
                    $ckeck_email = DB::table('users_admin_emp')->where('employee_id', '=', $request->employee_id)->where('id', '!=', $request->id)
                        ->first();
                    if (!empty($ckeck_email)) {
                        Session::flash('message', 'Employee id  Already Exists.');
                        return redirect('superadmin/employee-config');
                    }
                    if (!empty($request->employee_id) && !empty($request->user_pass)) {

                        DB::table('users_admin_emp')
                            ->where('employee_id', '=', $request->employee_id)
                            ->where('id', '=', $request->id)
                            ->update(['password' => $request->user_pass,
                                'email' => $request->user_email,
                                'notification_email' => $request->notification_email,
                                'phone' => $request->phone,
                                'name' => $request->name,
                                'address' => $request->address,
                                'login_id' => $request->login_id,
                                'weekly' => $request->weekly,
                                'status' => $request->status]);
                        Session::flash('message', 'Employee info Updated Successfully.');
                        $this->addAdminLog(5, 'Employee updated with name: ' . $request->name);
                        return redirect('superadmin/employee-config');

                    } else {

                        DB::table('users_admin_emp')
                            ->where('employee_id', '=', $request->employee_id)
                            ->where('id', '=', $request->id)
                            ->update(['status' => $request->status, 'email' => $request->user_email,
                                'notification_email' => $request->notification_email,
                                'phone' => $request->phone,
                                'name' => $request->name,
                                'address' => $request->address,
                                'login_id' => $request->login_id, 'weekly' => $request->weekly, 'password' => $request->user_pass]);
                        Session::flash('message', 'Employee info Updated Successfully.');
                        $this->addAdminLog(5, 'Employee updated with name: ' . $request->name);
                        return redirect('superadmin/employee-config');
                    }
                } else {
                    $ckeck_email = DB::table('users_admin_emp')->where('employee_id', '=', $request->employee_id)->first();
                    if (!empty($ckeck_email)) {
                        Session::flash('message', 'Employee id  Already Exists.');
                        return redirect('superadmin/employee-config');
                    }

                    $ins_data = array(
                        'employee_id' => $request->employee_id,
                        'name' => $request->name,
                        'email' => $request->user_email,
                        'notification_email' => $request->notification_email,
                        'user_type' => 'user',
                        'password' => $request->user_pass,
                        'phone' => $request->phone,

                        'address' => $request->address,
                        'login_id' => $request->login_id,
                        'weekly' => $request->weekly,

                    );

                    DB::table('users_admin_emp')->insert($ins_data);
                    Session::flash('message', 'Employee info Saved Successfully.');
                    $this->addAdminLog(5, 'Employee added with name: ' . $request->name);
                    return redirect('superadmin/employee-config');

                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function GetUserConfigForm($user_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['user'] = DB::table('users_admin_emp')->where('id', '=', base64_decode($user_id))->first();

                return view('admin/view-user-config', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function UserAccessRightsFormAuth(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            //dd($email);
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                foreach ($request['member_id'] as $valuemenm) {
                    foreach ($request['module_name'] as $key => $value) {
                        $va = explode('(Code :', $valuemenm);
                        $vag = explode(')', $va['1']);
                        if ($request['module_name'][$key] == 'all') {
                            $module = DB::table('module')->get();

                            foreach ($module as $modulehh) {

                                $ins_data['module_name'] = $modulehh->id;
                                $ins_data['member_id'] = trim($vag[0]);
                                $check_user_access = $this->userWiseAccessList(trim($vag[0]), $modulehh->id);

                                if (is_null($check_user_access)) {

                                    DB::table('role_authorization_admin_emp')->insert($ins_data);
                                    Session::flash('message', 'Role Successfully Saved.');

                                } else {
                                    Session::flash('message', 'User Permission already exist!!');
                                }

                            }

                        } else {
                            $ins_data['module_name'] = $request['module_name'][$key];
                            $ins_data['member_id'] = trim($vag[0]);

                            $check_user_access = $this->userWiseAccessList(trim($vag[0]), $request['module_name'][$key]);

                            if (is_null($check_user_access)) {

                                DB::table('role_authorization_admin_emp')->insert($ins_data);
                                Session::flash('message', 'Role Successfully Saved.');

                            } else {
                                Session::flash('message', 'User Permission already exist!!');
                            }

                        }

                    }

                }
                $this->addAdminLog(5, 'User role added.');

                return redirect('superadmin/view-users-role');
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function AdminAccessRightsFormAuth(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            //dd($userType);
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                foreach ($request['member_id'] as $valuemenm) {
                    foreach ($request['module_name'] as $key => $value) {
                        $va = explode('(Code :', $valuemenm);
                        $vag = explode(')', $va['1']);
                        if ($request['module_name'][$key] == 'all') {
                            $module = DB::table('module')->get();

                            foreach ($module as $modulehh) {

                                $ins_data['module_name'] = $modulehh->id;
                                $ins_data['member_id'] = trim($vag[0]);
                                $check_user_access = $this->adminWiseAccessList(trim($vag[0]), $modulehh->id);

                                if (is_null($check_user_access)) {

                                    DB::table('role_authorization_admin_user')->insert($ins_data);
                                    Session::flash('message', 'Role Successfully Saved.');

                                } else {
                                    Session::flash('message', 'User Permission already exist!!');
                                }

                            }

                        } else {
                            $ins_data['module_name'] = $request['module_name'][$key];
                            $ins_data['member_id'] = trim($vag[0]);

                            $check_user_access = $this->adminWiseAccessList(trim($vag[0]), $request['module_name'][$key]);

                            if (is_null($check_user_access)) {

                                DB::table('role_authorization_admin_user')->insert($ins_data);
                                Session::flash('message', 'Role Successfully Saved.');

                            } else {
                                Session::flash('message', 'User Permission already exist!!');
                            }

                        }

                    }

                }
                $this->addAdminLog(5, 'Admin user role added.');
                return redirect('superadmin/view-admin-role');
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function deleteAdminUserAccess($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $result = DB::table('role_authorization_admin_user')->where('id', '=', base64_decode($id))->delete();
                Session::flash('message', 'Access permission deleted Successfully.');
                $this->addAdminLog(5, 'Admin user role access permission revoked.');
                return redirect('superadmin/view-admin-role');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewUserAccessRights()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['roles'] = DB::table('role_authorization_admin_emp')
                    ->join('module', 'role_authorization_admin_emp.module_name', '=', 'module.id')

                    ->select('role_authorization_admin_emp.*', 'module.module_name')
                    ->groupBy('role_authorization_admin_emp.member_id')

                    ->orderBy('role_authorization_admin_emp.id', 'DESC')
                    ->get();

                $this->addAdminLog(5, 'Role management list view.');
                return view('admin/view-users-role', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    //13-11-2021 SM
    public function viewAdminAccessRights()
    {
        try {
            if (!empty(Session::get('empsu_email'))) {

                $data['roles'] = DB::table('role_authorization_admin_user')
                    ->join('module', 'role_authorization_admin_user.module_name', '=', 'module.id')

                    ->select('role_authorization_admin_user.*', 'module.module_name')
                    ->groupBy('role_authorization_admin_user.member_id')

                    ->orderBy('role_authorization_admin_user.id', 'DESC')
                    ->get();

                $this->addAdminLog(5, 'Admin user role list view.');
                return view('admin/view-admin-role', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewUserAccessRightsForm()
    {
        //dd(Session::get('empsu_email'));
        try {
            if (!empty(Session::get('empsu_email'))) {

                $data['users'] = DB::table('users_admin_emp')
                    ->get();
                $data['module'] = DB::table('module')->get();
                $data['menu'] = DB::table('module_config')->get();
                //dd($data);
                return view('admin/role', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    //sm 13-11-2021
    public function viewAdminAccessRightsForm()
    {

        try {

            $userType = Session::get('usersu_type');
            $email = Session::get('empsu_email');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('5', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['users'] = DB::table('users_admin_emp')
                    ->get();
                $data['module'] = DB::table('module_admin')->get();
                // $data['menu'] = DB::table('module_config')->get();

                return view('admin/role-admin', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function userWiseAccessList($usermailid, $module_name)
    {

        if (!empty(Session::get('empsu_email'))) {

            $useraccessdtl = DB::table('role_authorization_admin_emp')
                ->select('role_authorization_admin_emp.*')
                ->where('role_authorization_admin_emp.member_id', '=', $usermailid)
                ->where('role_authorization_admin_emp.module_name', '=', $module_name)

                ->first();

            return $useraccessdtl;
        } else {
            return redirect('superadmin');
        }
    }

    public function adminWiseAccessList($usermailid, $module_name)
    {

        if (!empty(Session::get('empsu_email'))) {

            $useraccessdtl = DB::table('role_authorization_admin_user')
                ->select('role_authorization_admin_user.*')
                ->where('role_authorization_admin_user.member_id', '=', $usermailid)
                ->where('role_authorization_admin_user.module_name', '=', $module_name)

                ->first();

            return $useraccessdtl;
        } else {
            return redirect('superadmin');
        }
    }

    public function deleteUserAccess($role_authorization_id)
    {
        try {if (!empty(Session::get('empsu_email'))) {
            // echo $role_authorization_id; exit;
            $result = DB::table('role_authorization_admin_emp')->where('id', '=', base64_decode($role_authorization_id))->delete();
            Session::flash('message', 'Access permission deleted Successfully.');
            return redirect('superadmin/view-users-role');
        } else {
            return redirect('superadmin');
        }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewUserassignmentRightsForm()
    {
        try {

            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['users'] = DB::table('users_admin_emp')
                    ->get();
                $data['module'] = DB::Table('registration')
                    ->where('status', '=', 'active')->get();

                $this->addAdminLog(10, 'Organisation list viewed.');

                return view('admin/assignment', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function UserassignmentRightsFormAuth(Request $request)
    {
        try {
            if (!empty(Session::get('empsu_email'))) {

                foreach ($request['module_name'] as $key => $value) {

                    $orgDetails = DB::table('registration')->where('status', '=', 'active')
                        ->where('reg', '=', $request['module_name'][$key])
                        ->first();

                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request['member_id'])
                        ->first();

                    //dd($caseworker);

                    $ins_data['module_name'] = $request['module_name'][$key];
                    $ins_data['member_id'] = $request['member_id'];
                    $ins_data['created_at'] = date('Y-m-d');
                    $ins_data['status'] = 'active';

                    $check_user_access = $this->userWiseassignmentList($request['member_id'], $request['module_name'][$key]);

                    if (is_null($check_user_access)) {

                        DB::table('role_authorization_admin_organ')->insert($ins_data);

                        //mail to case worker for assignment of organisation
                        $data = array('to_name' => '', 'body_content' => 'A new organisation with name "' . $orgDetails->com_name . '" has been assigned to you. Case Worker : ' . $caseworker->name . '. Please proceed with the needful.');

                        //$toemail = 'm.subhasish@gmail.com';
                        $toemail = $caseworker->notification_email;
                        //$toemail = 'info@workpermitcloud.co.uk';
                        if ($toemail != '') {
                            Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                                $message->to($toemail, 'skilledworkerscloud')->subject
                                    ('Organisation Assign');
                                $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                            });
                        }

                        Session::flash('message', 'Organisation Assignment Successfully Saved.');
                        $this->addAdminLog(10, 'Organisation Assignment added.');

                    } else {
                        Session::flash('message', 'User Permission already exist!!');
                    }

                }

                return redirect('superadmin/view-organisation-assignment');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function userWiseassignmentList($usermailid, $module_name)
    {

        if (!empty(Session::get('empsu_email'))) {

            $useraccessdtl = DB::table('role_authorization_admin_organ')
                ->select('role_authorization_admin_organ.*')
                ->where('role_authorization_admin_organ.member_id', '=', $usermailid)
                ->where('role_authorization_admin_organ.module_name', '=', $module_name)

                ->first();

            return $useraccessdtl;
        } else {
            return redirect('superadmin');
        }
    }

    public function viewUserassignmentRights()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['roles'] = DB::table('role_authorization_admin_organ')
                    ->join('registration', 'role_authorization_admin_organ.module_name', '=', 'registration.reg')

                    ->where('registration.status', '=', 'active')
                    ->select('role_authorization_admin_organ.*', 'registration.com_name')
                    ->groupBy('role_authorization_admin_organ.member_id')

                    ->orderBy('role_authorization_admin_organ.id', 'DESC')
                    ->get();

                return view('admin/view-organisation-assignment', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function deleteUserassignment($role_authorization_id)
    {
        try {if (!empty(Session::get('empsu_email'))) {
            // echo $role_authorization_id; exit;
            $result = DB::table('role_authorization_admin_organ')->where('id', '=', base64_decode($role_authorization_id))->delete();
            Session::flash('message', 'Access permission deleted Successfully.');
            return redirect('superadmin/view-organisation-assignment');
        } else {
            return redirect('superadmin');
        }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getetare()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::Table('tareq_app')

                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(10, 'Application Assign list viewed.');

                return View('admin/tareq-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addtareq()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();
                    $data['org_list']=DB::table('registration')->where('status','active')->get();
                    // dd($data['org_list']);
                return View('admin/tareq-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savetareq(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $ckeck_dept = DB::table('tareq_app')->where('emid', $request->emid)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Application Assign Already Exists.');
                    return redirect('superadmin/view-tareq');
                } else {
                    $lsatdeptorganlasr = DB::table('users_admin_emp')
                        ->where('employee_id', '=', $request->ref_id)->orderBy('id', 'DESC')->first();

                    //dd($lsatdeptorganlasr);

                    $as_na = explode(' ', $lsatdeptorganlasr->name);
                    $final_date = substr($as_na[0], 0, 3);

                    $lsatdeptnmdb = DB::table('tareq_app')
                        ->where('in_id', 'like', $final_date . '%')->orderBy('in_id', 'DESC')->first();

                    if (empty($lsatdeptnmdb)) {

                        $pid = $final_date . '-001';
                    } else {
                        $ff = $final_date . '-';
                        $aar = explode($ff, $lsatdeptnmdb->in_id);
                        $lasto = (floatval($aar['1']));

                        if ($lasto < 9) {
                            $pid = $final_date . '-00' . ($lasto + 1);
                        }
                        if ($lasto >= 9 && $lasto < 99) {
                            $pid = $final_date . '-0' . ($lasto + 1);
                        }
                        if ($lasto >= 99) {
                            $pid = $final_date . '-' . ($lasto + 1);
                        }

                    }

                    if ($request->assign == 'Own') {
                        $ref = $request->reffered_own;
                    }
                    if ($request->assign == 'Partner') {
                        $ref = $request->reffered_part;
                    }

                    $data = array(

                        'in_id' => $pid,
                        'emid' => $request->emid,
                        'status' => 'added',

                        'trad' => $request->trad,
                        'address' => $request->address,
                        'assign' => $request->assign,

                        'reffered' => $ref,
                        'relation' => $request->relation,
                        'authorising' => $request->authorising,

                        'desig' => $request->desig,
                        'auth_con' => $request->auth_con,
                        'assign_date' => date('Y-m-d', strtotime($request->assign_date)),

                        'app_date' => date('Y-m-d', strtotime($request->app_date)),

                        'remarks' => $request->remarks,

                        'invoice' => $request->invoice,
                        'ref_id' => $request->ref_id,
                        'asign_name' => $lsatdeptorganlasr->name,
                        'hr_in' => $request->hr_in,
                        'cr_date' => date('Y-m-d'),
                        'update_new_ct' => date('Y-m-d'),
                        'invoice_se' => $request->invoice_se,
                    );

                    DB::table('tareq_app')->insert($data);

                    $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                        ->where('reg', '=', $request->emid)
                        ->first();

                    //mail to case worker for assignment of organisation
                    $data = array('to_name' => '', 'body_content' => 'New sponsor Licence Application assigned to you. <p>Organisation name: "' . $data['Roledata']->com_name . '"</p> . Please start processing their application.');

                    //$toemail = 'm.subhasish@gmail.com';
                    $toemail = $lsatdeptorganlasr->notification_email;
                    //$toemail = 'hr@workpermitcloud.co.uk';

                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ('Organisation Application Assigned');
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });

                    Session::flash('message', ' Application Assign Added Successfully .');

                    $this->addAdminLog(10, 'Application Assign Added.');

                    return redirect('superadmin/view-tareq');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    //file manager
    public function getfilemanager(){
        try{
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $data['response'] = DB::table('file_managers')
                ->select('file_managers.*', 'notes.com_name','note.emp_fname','note.emp_lname')
                ->join('employee as note', 'file_managers.organization_id', '=', 'note.emp_code', 'left')
                ->join('registration as notes', 'note.emid', '=', 'notes.reg', 'left')
                ->orderBy('file_managers.created_at', 'desc')
                ->get();
            //   dd($data['response']);
                return view('admin/file-list',$data);
            }else{
               return redirect("/");
            }

        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function fileapproved($id){
        $email = Session::get('empsu_email');
        if (!empty($email)) {
            DB::table('file_managers')->where('id',$id)->update(["status"=>"approved"]);
            return redirect('superadmin/view-file-manager');
        }else{
           return redirect("/");
        }
    }
    //end file manager

    public function viewtareqgy($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();

                $data['tareq'] = DB::table('tareq_app')

                    ->where('id', '=', base64_decode($comp_id))
                    ->first();
                return View('admin/tareq-edit', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveAddtareqgy(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $ckeck_dept = DB::table('tareq_app')->where('emid', $request->emid)->where('id', '!=', $request->id)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Application Assign Already Exists.');
                    return redirect('superadmin/view-tareq');
                } else {

                    if ($request->assign == 'Own') {
                        $ref = $request->reffered_own;
                    }
                    if ($request->assign == 'Partner') {
                        $ref = $request->reffered_part;
                    }
                    $lsatdepvontorganlasr = DB::table('tareq_app')
                        ->where('id', '=', $request->id)->orderBy('id', 'DESC')->first();

                    if ($lsatdepvontorganlasr->ref_id != $request->ref_id) {
                        $lsatdeptorganlasr = DB::table('users_admin_emp')
                            ->where('employee_id', '=', $request->ref_id)->orderBy('id', 'DESC')->first();
                        $as_na = explode(' ', $lsatdeptorganlasr->name);
                        $final_date = substr($as_na[0], 0, 3);

                        $lsatdeptnmdb = DB::table('tareq_app')
                            ->where('in_id', 'like', $final_date . '%')->orderBy('in_id', 'DESC')->first();

                        if (empty($lsatdeptnmdb)) {

                            $pid = $final_date . '-001';
                        } else {
                            $ff = $final_date . '-';
                            $aar = explode($ff, $lsatdeptnmdb->in_id);
                            $lasto = (floatval($aar['1']));

                            if ($lasto < 9) {
                                $pid = $final_date . '-00' . ($lasto + 1);
                            }
                            if ($lasto >= 9 && $lasto < 99) {
                                $pid = $final_date . '-0' . ($lasto + 1);
                            }
                            if ($lasto >= 99) {
                                $pid = $final_date . '-' . ($lasto + 1);
                            }

                        }
                        $ass_na = $lsatdeptorganlasr->name;
                    } else {

                        $pid = $lsatdepvontorganlasr->in_id;
                        $ass_na = $lsatdepvontorganlasr->asign_name;
                    }

                    $dataggff = array(

                        'trad' => $request->trad,
                        'address' => $request->address,
                        'assign' => $request->assign,

                        'reffered' => $ref,
                        'relation' => $request->relation,
                        'authorising' => $request->authorising,

                        'desig' => $request->desig,
                        'auth_con' => $request->auth_con,
                        'assign_date' => date('Y-m-d', strtotime($request->assign_date)),

                        'app_date' => date('Y-m-d', strtotime($request->app_date)),

                        'remarks' => $request->remarks,
                        'in_id' => $pid,
                        'ref_id' => $request->ref_id,
                        'asign_name' => $ass_na,
                        'invoice' => $request->invoice,
                        'hr_in' => $request->hr_in,
                        'invoice_se' => $request->invoice_se,
                        'up_date' => date('Y-m-d'),

                    );
                    DB::table('tareq_app')->where('id', $request->id)->update($dataggff);

                    Session::flash('message', ' Application Assign Changed Successfully .');

                    $this->addAdminLog(10, 'Application Assign Changed.');

                    return redirect('superadmin/view-tareq');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function getetarereferred()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('7', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::Table('reffer_mas')

                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(7, 'list viewed.');
                return View('admin/reffer-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addreferred()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('7', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->get();

                return View('admin/referred-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savereferred(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $lsatdeptnmdb = DB::table('reffer_mas')->orderBy('id', 'DESC')->first();

                if (empty($lsatdeptnmdb)) {
                    $pid = 'REF-001';
                } else {
                    if ($lsatdeptnmdb->id < 9) {
                        $pid = 'REF-00' . ($lsatdeptnmdb->id + 1);
                    }
                    if ($lsatdeptnmdb->id >= 9 && $lsatdeptnmdb->id < 99) {
                        $pid = 'REF-0' . ($lsatdeptnmdb->id + 1);
                    }
                    if ($lsatdeptnmdb->id >= 99) {
                        $pid = 'REF-' . ($lsatdeptnmdb->id + 1);
                    }

                }

                $data = array(

                    'ref_id' => $pid,
                    'phone' => $request->phone,
                    'status' => $request->status,

                    'name' => $request->name,

                    'email' => $request->email,

                    'address' => $request->address,
                    'bank_account_name' => $request->bank_account_name,
                    'bank_account_no' => $request->bank_account_no,
                    'bank_sort_code' => $request->bank_sort_code,

                    'cr_date' => date('Y-m-d'),

                );

                DB::table('reffer_mas')->insert($data);

                Session::flash('message', 'Referred  Added Successfully .');

                $this->addAdminLog(7, 'New record added with name: ' . $request->name);

                return redirect('superadmin/view-referred');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewreferredgy($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('7', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['tareq'] = DB::table('reffer_mas')

                    ->where('id', '=', base64_decode($comp_id))
                    ->first();
                return View('admin/referred-edit', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddreferredgy(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $datagg = array(

                    'phone' => $request->phone,
                    'status' => $request->status,

                    'name' => $request->name,

                    'email' => $request->email,

                    'address' => $request->address,
                    'bank_account_name' => $request->bank_account_name,
                    'bank_account_no' => $request->bank_account_no,
                    'bank_sort_code' => $request->bank_sort_code,
                    'up_date' => date('Y-m-d'),

                );
                DB::table('reffer_mas')->where('id', $request->id)->update($datagg);
                Session::flash('message', 'Referred Changed Successfully .');

                $this->addAdminLog(7, 'Record edited with changed name: ' . $request->name);

                return redirect('superadmin/view-referred');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function getorgandasboard()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $usersu_type = Session::get('usersu_type');

                $data['or_active'] = DB::Table('registration')

                    ->where('status', '=', 'active')

                    ->where('verify', '=', 'not approved')
                    ->where('licence', '=', 'no')
                    ->get();
                $data['or_notactive'] = DB::Table('registration')

                    ->where('status', '=', 'inactive')
                    ->where('verify', '=', 'not approved')
                    ->where('licence', '=', 'no')

                    ->get();
                $data['or_verify'] = DB::Table('registration')

                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')

                    ->where('licence', '=', 'no')
                    ->get();
                $data['or_noverify'] = DB::Table('registration')

                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'not approved')
                    ->where('licence', '=', 'no')

                    ->get();
                $data['or_lince'] = DB::Table('registration')

                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')

                    ->get();
                $data['or_notlince'] = DB::Table('registration')

                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'no')

                    ->get();

                return View('admin/organisation-dashboard', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getorsearchgandasboard()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $this->addAdminLog(1, 'Employee Tracker dashboard visited.');
                $data['or_active'] = DB::Table('users_admin_emp')

                    ->get();

                return View('admin/organisation-search', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function vieworsearchgandasboard(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['or_notlince'] = DB::Table('registration')

                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'no')

                    ->get();
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;

                $data['employee_id'] = $request->employee_id;
                $this->addAdminLog(1, 'Employee Tracker dashboard viewed.');
                return View('admin/organisation-dashboard', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewallcompanyreminder()
    {

        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('12', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                return View('admin/reminder-list', $data);
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedereminder(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->employee_id != 'all') {
                    $leave_allocation_rs = DB::table('reminder')

                        ->where('employee_id', '=', $request->employee_id)

                        ->get();

                } else {
                    $leave_allocation_rs = DB::table('reminder')

                        ->get();

                }

                $data['result'] = '';

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('users_admin_emp')

                            ->where('employee_id', '=', $leave_allocation->employee_id)

                            ->first();
                        $passreg = DB::Table('registration')

                            ->where('reg', '=', $leave_allocation->emid)

                            ->first();

                        $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $pass->name . '</td>
														<td>' . $passreg->com_name . '</td>
													<td>' . $leave_allocation->type . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->date_new)) . '</td>
														  <td>' . $leave_allocation->time_new . '</td>
														  	  <td>' . $leave_allocation->remarks . '</td>







						</tr>';
                        $f++;}
                }

                $data['employee_id'] = $request->employee_id;
                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                $this->addAdminLog(12, 'list viewed.');
                return View('admin/reminder-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewallcompanyhr()
    {

        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('11', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                return View('admin/hr-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedehr(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->employee_id != 'all') {
                    $leave_allocation_rs = DB::table('hr_apply')

                        ->where('employee_id', '=', $request->employee_id)

                        ->get();

                } else {
                    $leave_allocation_rs = DB::table('hr_apply')

                        ->get();

                }

                $data['result'] = '';

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('users_admin_emp')

                            ->where('employee_id', '=', $leave_allocation->employee_id)

                            ->first();
                        $passreg = DB::Table('registration')

                            ->where('reg', '=', $leave_allocation->emid)

                            ->first();

                        if ($leave_allocation->due_date != '') {
                            $due = date('d/m/Y', strtotime($leave_allocation->due_date));
                        } else {
                            $due = '';
                        }

                        if ($leave_allocation->sub_due_date != '') {
                            $su_due = date('d/m/Y', strtotime($leave_allocation->sub_due_date));
                        } else {
                            $su_due = '';
                        }

                        if ($leave_allocation->target_date != '') {
                            $tar_due = date('d/m/Y', strtotime($leave_allocation->target_date));
                        } else {
                            $tar_due = '';
                        }
                        if ($leave_allocation->visa_date != '') {
                            $vis_due = date('d/m/Y', strtotime($leave_allocation->visa_date));
                        } else {
                            $vis_due = '';
                        }

                        if ($leave_allocation->need_action == 'Yes') {
                            $need = $leave_allocation->need_action . '(' . $leave_allocation->other_action . ' )';
                        } else {
                            $need = 'No';
                        }
                        if ($leave_allocation->fur_query == 'Yes') {
                            $neefurd = $leave_allocation->fur_query . '(' . $leave_allocation->other . ' )';
                        } else {
                            $neefurd = 'No';
                        }
                        if ($leave_allocation->licence == 'Rejected') {
                            $neereject = $leave_allocation->licence . '(' . $leave_allocation->rect_deatils . ' )';
                        } else {
                            $neereject = $leave_allocation->licence;
                        }
                        if ($leave_allocation->licence == 'Refused') {
                            $neereject = $leave_allocation->licence . '(' . date('d/m/Y', strtotime($leave_allocation->refused_date)) . ' )';
                        } else {
                            $neereject = $leave_allocation->licence;
                        }

                        if ($leave_allocation->home_off == 'Yes') {
                            if ($leave_allocation->home_visit_date != '') {
                                $ghg = '(' . date('d/m/Y', strtotime($leave_allocation->home_visit_date)) . ' )';} else {
                                $ghg = '';
                            }
                        } else {
                            $ghg = '';
                        }
                        $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $pass->name . '</td>
														<td>' . $passreg->com_name . '</td>

														<td>' . date('d/m/Y', strtotime($leave_allocation->job_date)) . '</td>
															<td>' . date('d/m/Y', strtotime($leave_allocation->hr_file_date)) . '</td>
														  <td>' . $leave_allocation->job_ad . '</td>
														  	  <td>' . $leave_allocation->remarks . '</td>

												   <td>' . $leave_allocation->inpect . '</td>
												   	<td>' . $due . '</td>

										<td>' . $su_due . '</td>
										 <td>' . $neereject . '</td> 	 <td>' . $leave_allocation->identified . '</td>
											 <td>' . $leave_allocation->preparation . '</td>
											 	<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
											 	<td>' . $need . '</td>
												 <td>' . $leave_allocation->home_off . '' . $ghg . '</td>




																<td>' . $leave_allocation->status . '</td>

						</tr>';
                        $f++;}
                }

                $data['employee_id'] = $request->employee_id;
                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                $this->addAdminLog(11, 'HR File Update list viewed.');

                return View('admin/hr-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistcompletegy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $this->addAdminLog(1, 'Employee Tracker - Application - Completed list view');

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                return View('admin/complete-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewlistwipgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }
                $this->addAdminLog(1, 'Employee Tracker - Application - WIP list view');
                return View('admin/wip-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistneedgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }
                $this->addAdminLog(1, 'Employee Tracker - Application - Need Action list view');
                return View('admin/need-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewlistbilledgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Revenue - Billed list view');

                return View('admin/billed-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistrecievedgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Revenue - Recieved list view');
                return View('admin/recieved-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistdaysgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Revenue - 30 Days+ list view');
                return View('admin/days-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistonholdsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Revenue - On Hold list view');
                return View('admin/onhold-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlisthrcompletesgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - Complete list view');
                return View('admin/hrcomplete-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlisthrwipsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - WIP list view');

                return View('admin/hrwip-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlisthrneedsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - Need Action list view');
                return View('admin/hrneed-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewscheduleRights()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['roleshh'] = DB::table('role_authorization_admin_time')

                    ->get();

                $this->addAdminLog(6, 'Time Schedule list view.');
                return view('admin/view-schedule', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function GetscheduleConfigForm($user_id)
    {
        try {

            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['user'] = DB::table('role_authorization_admin_time')->where('id', '=', base64_decode($user_id))->first();

                return view('admin/view-time-config', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewcheduleConfigForm(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $datagg = array(
                    'type' => $request->type,

                    'time' => $request->time,

                    'updated_at' => date('Y-m-d'),

                );
                DB::table('role_authorization_admin_time')->where('id', $request->id)->update($datagg);
                Session::flash('message', ' Time Schedule Changed Successfully .');

                $this->addAdminLog(6, 'Time schedule modified of current type: ' . $request->type);

                return redirect('superadmin/view-time-schedule');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function vwcheduleConfigForm()
    {try {
        if (!empty(Session::get('empsu_email'))) {

            $data['roleshh'] = DB::table('role_authorization_admin_time')

                ->get();

            return view('admin/add-schedule', $data);
        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function savecheduleConfigForm(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            //dd($request->all());
            if (!empty($email)) {

                $ckeck_email = DB::table('role_authorization_admin_time')->where('type', '=', $request->type)->first();
                if (!empty($ckeck_email)) {
                    Session::flash('message', 'Time Schedule  Already Exists.');
                    return redirect('superadmin/view-time-schedule');
                } else {

                    $datagg = array(

                        'type' => $request->type,

                        'time' => $request->time,
                        'created_at' => date('Y-m-d'),

                    );
                    DB::table('role_authorization_admin_time')->insert($datagg);
                    Session::flash('message', ' Time Schedule Added Successfully .');

                    $this->addAdminLog(6, 'Modified time schedule added of type :' . $request->type);

                    return redirect('superadmin/view-time-schedule');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function deletetimerAccess($role_authorization_id)
    {

        try {if (!empty(Session::get('empsu_email'))) {
            // echo $role_authorization_id; exit;
            $ckeck_email = DB::table('role_authorization_admin_time')->where('id', '=', ($role_authorization_id))->first();
            $result = DB::table('role_authorization_admin_time')->where('id', '=', ($role_authorization_id))->delete();

            $this->addAdminLog(6, 'Time Schedule  deleted for :' . $ckeck_email->type);

            Session::flash('message', 'Time Schedule  deleted Successfully.');
            return redirect('superadmin/view-time-schedule');
        } else {
            return redirect('superadmin');
        }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewoffday()
    {
        try {

            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $email = Session::get('empsu_email');

                $data['employee_type_rs'] = DB::table('offday_emp')->get();

                $this->addAdminLog(6, 'Day of list viewed.');

                return view('admin/offday-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddNewoffday()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $id = base64_decode(Input::get('id'));

                $data['departs'] = DB::table('users_admin_emp')->get();
                if (Input::get('id')) {
                    $dt = DB::table('offday_emp')->where('id', '=', $id)->first();
                    if (!empty($dt)) {
                        $data['shift_management'] = DB::table('offday_emp')->where('id', '=', $id)->first();
                        return view('admin/add-new-offday', $data);
                    } else {
                        return redirect('superadmin/offday');
                    }

                } else {
                    return view('admin/add-new-offday', $data);
                }

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveoffdayData(Request $request)
    {
        try {
            if (!empty(Session::get('empsu_email'))) {
                $email = Session::get('empsu_email');

                if (Input::get('id')) {

                    $id = base64_decode(Input::get('id'));
                    $ckeck_email = DB::table('offday_emp')->where('employee_id', '=', $request->employee_id)->where('id', '!=', $id)->first();
                    if (!empty($ckeck_email)) {
                        Session::flash('message', 'Offday Information For The Employee  Already Exists.');
                        return redirect('superadmin/offday');
                    } else {
                        $data = array(
                            'employee_id' => $request->employee_id,

                            'sun' => $request->sun,
                            'mon' => $request->mon,
                            'tue' => $request->tue,
                            'wed' => $request->wed,

                            'thu' => $request->thu,
                            'fri' => $request->fri,
                            'sat' => $request->sat,

                        );

                        $dataInsert = DB::table('offday_emp')
                            ->where('id', $id)
                            ->update($data);

                        Session::flash('message', 'Offday Information Successfully Updated.');

                        $this->addAdminLog(6, 'New Day Off updated.');

                        return redirect('superadmin/offday');
                    }

                } else {

                    $ckeck_email = DB::table('offday_emp')->where('employee_id', '=', $request->employee_id)->first();
                    if (!empty($ckeck_email)) {
                        Session::flash('message', 'Offday Information For The Employee  Already Exists.');
                        return redirect('superadmin/offday');
                    } else {
                        $data = array(
                            'employee_id' => $request->employee_id,

                            'sun' => $request->sun,
                            'mon' => $request->mon,
                            'tue' => $request->tue,
                            'wed' => $request->wed,

                            'thu' => $request->thu,
                            'fri' => $request->fri,
                            'sat' => $request->sat,

                        );

                        DB::table('offday_emp')->insert($data);
                        Session::flash('message', 'Offday Information Successfully Saved.');

                        $this->addAdminLog(6, 'New Day Off added.');

                        return redirect('superadmin/offday');
                    }
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewroster()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['departs'] = DB::table('users_admin_emp')->get();

                return view('admin/roster-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function dutyrostimerAccess($res_id)
    {
        try {

            $data['departs'] = DB::table('duty_roster_emp')->where('id', '>=', base64_decode($res_id))->first();

            return view('admin/roster-record', $data);

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewAddNewemployeeduty()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $email = Session::get('empsu_email');

                $data['departs'] = DB::table('users_admin_emp')->get();

                return view('admin/add-new-employee-roster', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveemployeedutyData(Request $request)
    {try {
        if (!empty(Session::get('empsu_email'))) {

            $email = Session::get('empsu_email');
            if (date('m', strtotime($request->start_date)) != date('m', strtotime($request->end_date))) {
                Session::flash('message', 'Enter Proper Date');
                return redirect('superadmin/duty-roster');
            } else {
                $employee_duty_ros = DB::table('duty_roster_emp')
                    ->where('employee_id', '=', $request->employee_id)

                    ->where('end_date', '>=', date('Y-m-d', strtotime($request->start_date)))

                    ->first();

                if (!empty($employee_duty_ros)) {
                    Session::flash('message', 'Employee Id  Already Exists For This time Period .');
                    return redirect('superadmin/duty-roster');
                } else {

                    $data['employee_id'] = $request->employee_id;
                    $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
                    $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
                    $data['employee_desigrs'] = DB::table('users_admin_emp')
                        ->where('employee_id', '=', $request->employee_id)

                        ->first();
                    return view('admin/duty-roster-list', $data);

                }

            }
        } else {
            return redirect('superadmin');
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }

    }

    public function saverosterData(Request $request)
    {
        try {
            if (!empty(Session::get('empsu_email'))) {

                $email = Session::get('empsu_email');

                $employee_code = $request->employee_id;

                $date = date('Y-m-d', strtotime($request->date));

                $data['result'] = '';if ($employee_code != '') {

                    $leave_allocation_rs = DB::table('duty_roster_emp')
                        ->join('users_admin_emp', 'duty_roster_emp.employee_id', '=', 'users_admin_emp.employee_id')
                        ->where('duty_roster_emp.employee_id', '=', $employee_code)
                        ->where('users_admin_emp.employee_id', '=', $employee_code)

                        ->whereBetween('duty_roster_emp.start_date', [$request->start_date, $request->end_date])

                        ->select('duty_roster_emp.*')
                        ->get();
                } else {
                    $leave_allocation_rs = DB::table('duty_roster_emp')
                        ->join('users_admin_emp', 'duty_roster_emp.employee_id', '=', 'users_admin_emp.employee_id')

                        ->whereBetween('duty_roster_emp.start_date', [$request->start_date, $request->end_date])

                        ->select('duty_roster_emp.*')
                        ->get();
                }

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {

                        $employee_shift = DB::table('users_admin_emp')
                            ->where('employee_id', '=', $leave_allocation->employee_id)

                            ->first();

                        $data['result'] .= '<tr>
				<td>' . $f . '</td>

														<td>' . $employee_shift->name . ' ( Code :' . $employee_shift->employee_id . ')</td>
												<td>' . date('F', strtotime($leave_allocation->start_date)) . '</td>


														<td>' . date('d/m/Y', strtotime($leave_allocation->start_date)) . '</td>
															<td>' . date('d/m/Y', strtotime($leave_allocation->end_date)) . '</td>
											  <td class="drp">


<div class="dropdown">
  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="' . env("BASE_URL") . 'superadmin/edit-duty-roster/' . base64_encode($leave_allocation->id) . '"><i class="far fa-edit"></i>&nbsp; Edit</a>
    <a class="dropdown-item" href="' . env("BASE_URL") . 'superadmin/view-duty-roster/' . base64_encode($leave_allocation->id) . '" target="_blank"><i class="fas fa-eye"></i>&nbsp; View Roster</a>

  </div>
</div>





                  </td>


						</tr>';
                        $f++;}
                }
                $data['departs'] = DB::table('users_admin_emp')->get();

                $data['employee_code'] = $request->employee_id;

                $data['start_date'] = date('Y-m-d', strtotime($request->start_date));

                $data['end_date'] = date('Y-m-d', strtotime($request->end_date));

                $this->addAdminLog(6, 'Duty Roaster list viewed.');

                return view('admin/roster-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewallcompanycos()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('11', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                //return View('admin/cos-list', $data);
                return View('admin/cos-list-new', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedecos(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->employee_id != 'all') {
                    //$leave_allocation_rs = DB::table('cos_apply')->where('employee_id', '=', $request->employee_id)             ->get();
                    $leave_allocation_rs = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
                        ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
                        ->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'left')
                        ->where('cos_apply.employee_id', '=', $request->employee_id)
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->get();
                } else {
                    $leave_allocation_rs = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
                        ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
                        ->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'left')
                    //->where('cos_apply.employee_id', '=', $request->employee_id)
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->get();
                }
                //dd($leave_allocation_rs);
                $data['result'] = '';

                if ($leave_allocation_rs) {
                    $f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('users_admin_emp')->where('employee_id', '=', $leave_allocation->employee_id)->first();
                        $passreg = DB::Table('registration')->where('reg', '=', $leave_allocation->emid)->first();

                        if ($leave_allocation->applied_cos_date != '' && $leave_allocation->applied_cos_date != '0000-00-00') {
                            $applied_cos_date = date('d/m/Y', strtotime($leave_allocation->applied_cos_date));
                        } else {
                            $applied_cos_date = '';
                        }
                        if ($leave_allocation->additional_info_request_date != '' && $leave_allocation->additional_info_request_date != '0000-00-00') {
                            $additional_info_request_date = date('d/m/Y', strtotime($leave_allocation->additional_info_request_date));
                        } else {
                            $additional_info_request_date = '';
                        }
                        if ($leave_allocation->additional_info_sent_date != '' && $leave_allocation->additional_info_sent_date != '0000-00-00') {
                            $additional_info_sent_date = date('d/m/Y', strtotime($leave_allocation->additional_info_sent_date));
                        } else {
                            $additional_info_sent_date = '';
                        }
                        if ($leave_allocation->cos_assigned_date != '' && $leave_allocation->cos_assigned_date != '0000-00-00') {
                            $cos_assigned_date = date('d/m/Y', strtotime($leave_allocation->cos_assigned_date));
                        } else {
                            $cos_assigned_date = '';
                        }

                        //         $data['result'] .= '<tr>
                        // <td>' . $f . '</td>

                        //                                     <td>' . $pass->name . '</td>
                        //                                         <td>' . $passreg->com_name . '</td>

                        //                                 <td>' . $leave_allocation->cos . '</td>     <td>' . $leave_allocation->client . '</td>
                        //                                  <td>' . $leave_allocation->identified . '</td>
                        //                         <td>' . $leave_allocation->remarks_cos . '</td>
                        //                         <td>' . $tar_due . '</td>
                        //                             <td>' . $leave_allocation->allocation_status . '</td>
                        //                                 <td>' . $leave_allocation->job_offer_status . '</td>
                        //                                     <td>' . $vis_due . '</td>
                        //                 <td>' . $leave_allocation->visa_app . '</td>
                        //                     <td>' . $neefurd . '</td>
                        //                         <td>' . $leave_allocation->visa_stat . '</td>
                        //                             <td>' . $leave_allocation->appeal . '</td>
                        //                                 <td>' . $leave_allocation->responsible . '</td>
                        //                                     <td>' . $leave_allocation->app_stat . '</td>
                        //                                         <td>' . $leave_allocation->app_out . '</td>
                        //                                             <td>' . $leave_allocation->cos_aloca . '</td>

                        //                                                 <td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>

                        //                                                 <td>' . $leave_allocation->status . '</td>

                        //         </tr>';
                        $data['result'] .= '<tr>';
                        $data['result'] .= '<td>' . $f . '</td>';
                        $data['result'] .= '<td>' . $passreg->com_name . '</td>';

                        $data['result'] .= '<td>' . $leave_allocation->emp_fname . ' ' . $leave_allocation->emp_mname . ' ' . $leave_allocation->emp_lname . '</td>';
                        $data['result'] .= '<td>' . $pass->name . '</td>';

                        $data['result'] .= '<td>' . $applied_cos_date . '</td>	 <td>' . $additional_info_request_date . '</td>';
                        $data['result'] .= '<td>' . $additional_info_sent_date . '</td>';
                        $data['result'] .= '<td>' . (($leave_allocation->status == '' && $leave_allocation->status == null) ? 'Pending' : $leave_allocation->status) . '</td>';
                        $data['result'] .= '<td>' . $cos_assigned_date . '</td>';
                        $data['result'] .= '<td>' . $leave_allocation->remarks_cos . '</td>';

                        $data['result'] .= '</tr>';

                        $f++;
                    }
                }

                $data['employee_id'] = $request->employee_id;
                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                $this->addAdminLog(11, 'COS File Update list viewed.');

                //return View('admin/cos-list', $data);
                return View('admin/cos-list-new', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistrequestsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Request list view');

                return View('admin/request-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistpendingsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Pending list view');

                return View('admin/cos-pending-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistpendingvisafile($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Visa File - Pending list view');

                return View('admin/visafile-pending-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistrequestedrecruitementfile($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Recruitment File - Request list view');

                return View('admin/recruitmentfile-request-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistongoingrecruitementfile($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Recruitment File - Ongoing list view');

                return View('admin/recruitmentfile-ongoing-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlisthiredrecruitementfile($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Recruitment File - Hired list view');

                return View('admin/recruitmentfile-hired-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistgrantedvisafile($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Visa File - Granted list view');

                return View('admin/visafile-granted-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistrejectedvisafile($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Visa File - Rejected list view');

                return View('admin/visafile-rejected-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistassignedsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Assigned list view');

                return View('admin/cos-assigned-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistgrantedtsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Granted list view');

                return View('admin/granted-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistrejectedtsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Rejected list view');

                return View('admin/rejected-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function viewallcompanywork()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                return View('admin/work-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedework(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $start_date = date('Y-m-d', strtotime($request->start_date));
                $end_date = date('Y-m-d', strtotime($request->end_date));
                if ($request->employee_id != 'all') {
                    $leave_allocation_rs = DB::table('rota_inst')
                        ->whereBetween('date', [$start_date, $end_date])
                        ->where('employee_id', '=', $request->employee_id)

                        ->get();
                    $leave_allocation__grouprs = DB::table('rota_inst')
                        ->whereBetween('date', [$start_date, $end_date])
                        ->where('employee_id', '=', $request->employee_id)
                        ->groupBy('employee_id')
                        ->get();

                } else {
                    $leave_allocation_rs = DB::table('rota_inst')

                        ->whereBetween('date', [$start_date, $end_date])

                        ->get();
                    $leave_allocation__grouprs = DB::table('rota_inst')
                        ->whereBetween('date', [$start_date, $end_date])

                        ->groupBy('employee_id')
                        ->get();

                }

                $data['result'] = '';
                $sum = 0;
                $hy = 0;
                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation__grouprs as $leave_grouallocation) {
                        $passggg = DB::Table('duty_roster_emp')

                            ->where('employee_id', '=', $leave_grouallocation->employee_id)
                            ->where('start_date', '<=', $start_date)
                            ->orderBy('id', 'desc')
                            ->first();

                        if (!empty($passggg)) {

                            $sumggg = DB::Table('duty_emp_leave')
                                ->select(DB::raw('sum(hours) as hours'))
                                ->where('a_id', '=', $passggg->id)

                                ->whereBetween('date', [$start_date, $end_date])

                                ->first();

                            $hy = $hy + $sumggg->hours;
                        } else {
                            $hy = $hy + 0;
                        }

                    }
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('users_admin_emp')

                            ->where('employee_id', '=', $leave_allocation->employee_id)

                            ->first();
                        $passreg = DB::Table('registration')

                            ->where('reg', '=', $leave_allocation->emid)

                            ->where('reg', 'like', 'EM%')
                            ->first();

                        if (!empty($passreg)) {
                            $name = $passreg->com_name;
                        } else {
                            $name = '';
                        }
                        if ($leave_allocation->type == 'Others') {
                            $jj = '(' . $leave_allocation->rect_deatils . ')';

                        } else {
                            $jj = '';
                        }
                        if ($leave_allocation->w_min != '0') {
                            $min = $leave_allocation->w_min / 60;
                        } else { $min = 0;}
                        $totltime = 0;

                        $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $pass->name . '</td>
														<td>' . $name . '</td>
													  <td>' . $leave_allocation->type . ' ' . $jj . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
										<td>' . $leave_allocation->in_time . '</td>

														<td>' . $leave_allocation->out_time . '</td>


														  	  <td>' . $leave_allocation->w_hours . ' Hours (  ' . $leave_allocation->w_min . ') Minutes</td>
														  	  <td>' . $leave_allocation->remarks . '</td>


						</tr>';
                        $f++;}
                }

                $data['employee_id'] = $request->employee_id;
                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();

                if ($request->employee_id != 'all') {
                    $totalsum_rs = DB::table('rota_inst')
                        ->whereBetween('date', [$start_date, $end_date])
                        ->where('employee_id', '=', $request->employee_id)
                        ->groupBy('date')
                        ->get();

                } else {
                    $totalsum_rs = DB::table('rota_inst')

                        ->whereBetween('date', [$start_date, $end_date])

                        ->groupBy('employee_id', 'date')
                        ->get();

                }

                if ($totalsum_rs) {$f = 1;
                    foreach ($totalsum_rs as $totalsum) {

                        $passggg = DB::Table('rota_inst')
                            ->select(DB::raw('sum(w_hours) as w_hours'), DB::raw('sum(w_min) as w_min'))
                            ->where('employee_id', '=', $totalsum->employee_id)
                            ->where('date', '=', $totalsum->date)

                            ->first();

                        if ($passggg->w_min != '0') {
                            $min = $passggg->w_min / 60;
                        } else { $min = 0;}
                        $totltime = 0;
                        $totltime = $passggg->w_hours + $min;

                        if ($totltime > '6' && $totltime < '7') {
                            $totltime = '7';

                            $totltime = $totltime;
                        } else if ($totltime >= '7') {
                            $totltime = $totltime + 1;

                        } else {
                            $totltime = $totltime;

                        }
                        $sum = $sum + $totltime;

                    }
                }

                $data['sum'] = number_format($sum, 2);
                $data['actual'] = number_format($hy, 2);

                $this->addAdminLog(6, 'Daily work update list viewed.');

                return View('admin/work-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedutyDatasave(Request $request)
    {
        try {
            if (!empty(Session::get('empsu_email'))) {

                $email = Session::get('empsu_email');

                $allocation_list = $request->all();

                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $data = array(

                    'employee_id' => $request->employee_id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'created_at' => date('Y-m-d'),

                );

                $f = DB::table('duty_roster_emp')->insert($data);
                $last_id = DB::table('duty_roster_emp')->where('employee_id', '=', $request->employee_id)->where('start_date', '=', date('Y-m-d', strtotime($request->start_date)))->where('end_date', '=', date('Y-m-d', strtotime($request->end_date)))->orderBy('id', 'desc')->first();

                $g = 1;

                $start_mon = date('m', strtotime($start_date));
                $end_mon = date('m', strtotime($end_date));
                for ($y = $start_mon; $y <= $end_mon; $y++) {

                    if ($y <= 9) {
                        $y = $y;
                    } else {
                        $y = $y;
                    }

                    $my_year = date('Y');
                    $first_day_this_year = date('Y') . '-' . $y . '-01';
                    if ($y == '01' || $y == '03' || $y == '05' || $y == '07' || $y == '08' || $y == '10' || $y == '12') {
                        $last_day_this_year = date('Y') . '-' . $y . '-31';
                        $last_day = '31';
                    }

                    if ($y == '04' || $y == '06' || $y == '09' || $y == '11') {
                        $last_day_this_year = date('Y') . '-' . $y . '-30';
                        $last_day = '30';
                    }

                    if ($y == '02') {
                        if ($my_year % 400 == 0) {
                            $last_day_this_year = date('Y') . '-' . $y . '-29';
                            $last_day = '29';
                        }

                        if ($my_year % 4 == 0) {
                            $last_day_this_year = date('Y') . '-' . $y . '-29';
                            $last_day = '29';
                        } else if ($my_year % 100 == 0) {
                            $last_day_this_year = date('Y') . '-' . $y . '-28';
                            $last_day = '28';
                        } else {
                            $last_day_this_year = date('Y') . '-' . $y . '-28';
                            $last_day = '28';
                        }

                    }

                    for ($m = 1; $m < 32; $m++) {
                        if ($m <= 9) {
                            $m = '0' . $m;
                        } else {
                            $m = $m;
                        }
                        if ($last_day >= $m) {
                            $nfd = date('Y', strtotime($start_date)) . '-' . $y . '-' . $m;

                            if (isset($allocation_list['date' . $g]) && $allocation_list['date' . $g] == $nfd) {
                                $work = 1;
                                $day_tot = 1;

                            } else {
                                $work = 0;
                                $day_tot = 0;
                            }

                            if ($allocation_list['start_time' . $g] != '') {
                                $st_time = $allocation_list['start_time' . $g];
                            } else {
                                $st_time = '';
                            }
                            if ($allocation_list['end_time' . $g] != '') {
                                $end_time = $allocation_list['end_time' . $g];
                            } else {
                                $end_time = '';
                            }
                            if ($allocation_list['start_time' . $g] != '') {

                                $in_time = $st_time;
                                $out_time = $end_time;
                                $sartt_time = date('Y-m-d') . ' ' . $in_time . ':10';

                                $endy_time = date('Y-m-d') . ' ' . $out_time . ':10';
                                $t1 = Carbon::parse($sartt_time);
                                $t2 = Carbon::parse($endy_time);
                                $diff = $t1->diff($t2);
                                $allocation_list['hours' . $g] = $diff->h . '.' . $diff->i;

                            }

                            $datahh = array(

                                'a_id' => $last_id->id,
                                'date' => $nfd,
                                'day' => date('l', strtotime($nfd)),
                                'hours' => $allocation_list['hours' . $g],
                                'start_time' => $st_time,
                                'end_time' => $end_time,
                                'work' => $work,
                                'day_tot' => $day_tot,

                            );

                            $f = DB::table('duty_emp_leave')->insert($datahh);

                            $g++;

                        }
                    }

                }

                Session::flash('message', 'Duty Roster Of Employee Information Successfully Saved.');
                $this->addAdminLog(6, 'New Duty Roaster Added.');
                return redirect('superadmin/duty-roster');

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewlistfurthergy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Further Query list view');

                return View('admin/further-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewlisthrhomegy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - Home Office Client Visit  list view');
                return View('admin/home-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlisthrrejectedgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - Licence Rejected list view');
                return View('admin/hrrejected-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function viewlisthrawardgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }
                $this->addAdminLog(1, 'Employee Tracker - HR - Licence Award Decision (Granted) list view');
                return View('admin/hraward-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewrostereditgy($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('6', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['departs'] = DB::table('users_admin_emp')->get();

                $data['tareq'] = DB::table('duty_roster_emp')

                    ->where('id', '=', base64_decode($comp_id))
                    ->first();

                $data['employee_desigrs'] = DB::table('users_admin_emp')
                    ->where('employee_id', '=', $data['tareq']->employee_id)

                    ->first();

                return view('admin/edit-employee-roster', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function saveAddrosteredy(Request $request)
    {
        try {
            if (!empty(Session::get('empsu_email'))) {

                $email = Session::get('empsu_email');

                $allocation_list = $request->all();

                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $g = 1;

                $start_mon = date('m', strtotime($start_date));
                $end_mon = date('m', strtotime($end_date));
                for ($y = $start_mon; $y <= $end_mon; $y++) {

                    if ($y <= 9) {
                        $y = $y;
                    } else {
                        $y = $y;
                    }

                    $my_year = date('Y');
                    $first_day_this_year = date('Y') . '-' . $y . '-01';
                    if ($y == '01' || $y == '03' || $y == '05' || $y == '07' || $y == '08' || $y == '10' || $y == '12') {
                        $last_day_this_year = date('Y') . '-' . $y . '-31';
                        $last_day = '31';
                    }

                    if ($y == '04' || $y == '06' || $y == '09' || $y == '11') {
                        $last_day_this_year = date('Y') . '-' . $y . '-30';
                        $last_day = '30';
                    }

                    if ($y == '02') {
                        if ($my_year % 400 == 0) {
                            $last_day_this_year = date('Y') . '-' . $y . '-29';
                            $last_day = '29';
                        }

                        if ($my_year % 4 == 0) {
                            $last_day_this_year = date('Y') . '-' . $y . '-29';
                            $last_day = '29';
                        } else if ($my_year % 100 == 0) {
                            $last_day_this_year = date('Y') . '-' . $y . '-28';
                            $last_day = '28';
                        } else {
                            $last_day_this_year = date('Y') . '-' . $y . '-28';
                            $last_day = '28';
                        }

                    }

                    for ($m = 1; $m < 32; $m++) {
                        if ($m <= 9) {
                            $m = '0' . $m;
                        } else {
                            $m = $m;
                        }
                        if ($last_day >= $m) {
                            $nfd = date('Y', strtotime($start_date)) . '-' . $y . '-' . $m;

                            if (isset($allocation_list['date' . $g]) && $allocation_list['date' . $g] == $nfd) {
                                $work = 1;
                                $day_tot = 1;

                            } else {
                                $work = 0;
                                $day_tot = 0;
                            }

                            if ($allocation_list['start_time' . $g] != '') {
                                $st_time = $allocation_list['start_time' . $g];
                            } else {
                                $st_time = '';
                            }
                            if ($allocation_list['end_time' . $g] != '') {
                                $end_time = $allocation_list['end_time' . $g];
                            } else {
                                $end_time = '';
                            }
                            if ($allocation_list['start_time' . $g] != '') {
                                $in_time = $st_time;
                                $out_time = $end_time;
                                $sartt_time = date('Y-m-d') . ' ' . $in_time . ':10';

                                $endy_time = date('Y-m-d') . ' ' . $out_time . ':10';
                                $t1 = Carbon::parse($sartt_time);
                                $t2 = Carbon::parse($endy_time);
                                $diff = $t1->diff($t2);
                                $allocation_list['hours' . $g] = $diff->h . '.' . $diff->i;

                            }
                            $datahh = array(

                                'a_id' => $request->id,
                                'date' => $nfd,
                                'day' => date('l', strtotime($nfd)),
                                'hours' => $allocation_list['hours' . $g],
                                'work' => $work,
                                'day_tot' => $day_tot,
                                'start_time' => $st_time,
                                'end_time' => $end_time,

                            );

                            DB::table('duty_emp_leave')->where('id', $allocation_list['new_id' . $g])->update($datahh);

                            $g++;

                        }
                    }

                }

                Session::flash('message', 'Duty Roster Of Employee Information Successfully Updated.');
                $this->addAdminLog(6, 'Duty Roster Of Employee Information Successfully Updated.');
                return redirect('superadmin/duty-roster');

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewhr()
    {

        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::Table('hr_apply')

                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(10, 'HR File assignment list viewed.');

                return View('admin/hr-add-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddhry()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();
                return View('admin/hr-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddhry(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $ckeck_dept = DB::table('hr_apply')->where('emid', $request->emid)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'HR File Already Exists.');
                    return redirect('superadmin/view-add-hr');
                } else {

                    if ($request->due_date != '') {
                        $due = date('Y-m-d', strtotime($request->due_date));
                    } else {

                        $due = '';
                    }

                    if ($request->sub_due_date != '') {
                        $su_due = date('Y-m-d', strtotime($request->sub_due_date));
                    } else {
                        $su_due = '';
                    }

                    $datahh = array(

                        'emid' => $request->emid,
                        'employee_id' => $request->ref_id,
                        'job_date' => date('Y-m-d', strtotime($request->job_date)),
                        'hr_file_date' => date('Y-m-d', strtotime($request->hr_file_date)),

                        'sub_due_date' => $su_due,

                        'date' => date('Y-m-d'),
                        'status' => 'Incomplete',

                    );

                    DB::table('hr_apply')->insert($datahh);
                    $existingCompanyInfo = DB::table('registration')->where('reg', $request->emid)->first();
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->ref_id)
                        ->first();

                    //$toemail = 'hr@workpermitcloud.co.uk';
                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for HR to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Organisation HR Case Worker Assigned');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    Session::flash('message', ' HR File Added Successfully .');

                    $this->addAdminLog(10, 'HR File Added.');

                    return redirect('superadmin/view-add-hr');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddhrnew($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();

                $data['hr'] = DB::table('hr_apply')

                    ->where('id', '=', base64_decode($comp_id))
                    ->first();
                return View('admin/hr-edit', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddhrgynew(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $ckeck_dept = DB::table('hr_apply')->where('emid', $request->emid)->where('id', '!=', $request->id)->first();

                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'HR File Assign Already Exists.');
                    return redirect('superadmin/view-add-hr');
                } else {

                    if ($request->due_date != '') {
                        $due = date('Y-m-d', strtotime($request->due_date));
                    } else {
                        $due = '';
                    }

                    if ($request->sub_due_date != '') {
                        $su_due = date('Y-m-d', strtotime($request->sub_due_date));
                    } else {
                        $su_due = '';
                    }

                    if ($request->target_date != '') {
                        $tar_due = date('Y-m-d', strtotime($request->target_date));
                    } else {
                        $tar_due = '';
                    }
                    if ($request->visa_date != '') {
                        $vis_due = date('Y-m-d', strtotime($request->visa_date));
                    } else {
                        $vis_due = '';
                    }

                    if ($request->home_visit_date != '') {
                        $home_visit_date = date('Y-m-d', strtotime($request->home_visit_date));
                    } else {
                        $home_visit_date = '';
                    }

                    if ($request->refused_date != '') {
                        $refused_date = date('Y-m-d', strtotime($request->refused_date));
                    } else {
                        $refused_date = '';
                    }

                    $data['hrapply'] = DB::table('hr_apply')->where('id', $request->id)->first();
                    $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                        ->where('reg', '=', $request->emid)
                        ->first();

                    $datagg = array(
                        'employee_id' => $request->employee_id,
                        'licence' => $request->licence,
                        'home_off' => $request->home_off,
                        'home_visit_date' => $home_visit_date,
                        'refused_date' => $refused_date,
                        'rect_deatils' => $request->rect_deatils,
                        'update_new_ct' => date('Y-m-d'),
                    );
                    DB::table('hr_apply')->where('id', $request->id)->update($datagg);

                    //echo $request->licence;
                    //dd($data['Roledata']);
                    if ($request->licence == 'Granted' && $data['hrapply']->licence != 'Granted') {

                        //dd('in');
                        //mail to case worker for assignment of organisation
                        $data_email = array('to_name' => '', 'body_content' => 'License granted for Organisation with name "' . $data['Roledata']->com_name . '" . Please proceed with the needful for recruitment.');

                        //$toemail = 'm.subhasish@gmail.com';
                        $toemail = 'recruitment@workpermitcloud.co.uk';
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Organisation License Granted');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });

                        $data_email = array('to_name' => '', 'body_content' => 'This company sponsorship licence is GRANTED. Please issue the 2nd invoice.<p> Organisation with name "' . $data['Roledata']->com_name . '" .</p><p>Invoice Amount: £750 plus VAT</p>');

                        $toemail = 'invoice@workpermitcloud.co.uk';
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Organisation License Granted');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });

                    }

                    Session::flash('message', ' HR File Changed Successfully .');

                    $this->addAdminLog(10, 'HR File Changed.');

                    return redirect('superadmin/view-add-hr');

                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewcos()
    {
        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::Table('cos_apply_emp')
                    ->whereNotNull('cos_apply_emp.employee_id')
                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(10, 'COS File assignment list viewed.');

                return View('admin/cos-add-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewvisafile()
    {
        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::Table('visa_file_emp')
                    ->whereNotNull('visa_file_emp.employee_id')
                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(10, 'Visa File assignment list viewed.');

                return View('admin/visa-file-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewrecruitmentfile()
    {
        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::Table('recruitment_file_apply')

                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(10, 'Recruitment File assignment list viewed.');

                return View('admin/recruitment-file-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddcosy()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();
                return View('admin/cos-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddAdncosy()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();

                return View('admin/cos-addn', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewAddVisaFile()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                return View('admin/visa-file-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddVisaFileAdn()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                return View('admin/visa-file-add-adn', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddVisaFileDependent($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                $data['parentInfo'] = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*','registration.com_name')
                    ->join('registration', 'registration.reg', '=', 'visa_file_emp.emid')
                    ->where('visa_file_emp.id', '=', base64_decode($id))
                    ->first();

                return View('admin/visa-file-add-dependent', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddVisaFileDependent(Request $request)
    {
        try {
            $email = Session::get('empsu_email');

            if (!empty($email)) {

                // dd($request->all());

                $check_cos = DB::Table('cos_apply_emp')
                    ->where('emid', '=', $request->emid)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!empty($check_cos)) {
                    $ckeck_dept = null;

                } else {
                    $ckeck_dept = DB::Table('visa_file_apply')
                        ->where('emid', '=', $request->emid)
                        ->where('employee_id', '=', $request->ref_id)
                        ->orderBy('id', 'desc')
                        ->first();

                }

                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Visa File Already Exists.');
                    return redirect('superadmin/view-visa-file');
                } else {

                    if (!empty($check_cos)) {

                        $visa_file_applyx = DB::Table('visa_file_apply')
                            ->where('emid', '=', $request->emid)
                        //->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataVisaEmp = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_visa_apply_id' => $visa_file_applyx->id,
                            'cos_assigned' => null,
                            'visa_application_started' => null,
                            'visa_application_start_date' => null,
                            'visa_application_submitted' => null,
                            'visa_application_submit_date' => null,
                            'biometric_appo_date' => null,
                            'documents_uploaded' => null,
                            'interview_date_confirm' => null,
                            'interview_date' => null,
                            'mock_interview_confirm' => null,
                            'mock_interview_date' => null,
                            'remarks' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                            'addn_visa' => 'No',
                            'master_applicant_id' => $request->master_applicant_id,
                        );

                        DB::table('visa_file_emp')->insert($dataVisaEmp);

                        $visa_file_emp = DB::Table('visa_file_emp')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->first();

                        // $dataVisaEmp = array(
                        //     'employee_id' => $request->ref_id,
                        // );

                        // $updateVisaEmp = DB::table('visa_file_emp')->where('id', $visa_file_emp->id)->update($dataVisaEmp);

                        $ckeck_visa = DB::table('visa_file_apply')
                            ->where('id', $visa_file_emp->com_visa_apply_id)
                            ->first();

                        if ($ckeck_visa->employee_id == '') {
                            $updateVisaEmp = DB::table('visa_file_apply')->where('id', $visa_file_emp->com_visa_apply_id)->update($dataVisaEmp);
                        } else {

                            if ($ckeck_visa->employee_id != $request->ref_id) {
                                $datahh = array(
                                    'emid' => $request->emid,
                                    'employee_id' => $request->ref_id,
                                    'date' => date('Y-m-d'),
                                    'status' => 'Request',
                                );

                                $add_cos = DB::table('visa_file_apply')->insert($datahh);

                                $visa_file_apply = DB::Table('visa_file_apply')
                                    ->where('emid', '=', $request->emid)
                                    ->where('employee_id', '=', $request->ref_id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                //dd($add_cos);
                                $dataVisaEmp1 = array(
                                    'com_visa_apply_id' => $visa_file_apply->id,
                                );

                                $updateVisaEmp1 = DB::table('visa_file_emp')->where('id', $visa_file_emp->id)->update($dataVisaEmp1);
                            }
                        }
                    } else {
                        $datahh = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $add_visa = DB::table('visa_file_apply')->insert($datahh);

                        //Add employee to cos with blank case worker

                        $visa_file_apply = DB::Table('visa_file_apply')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataVisaEmp = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_visa_apply_id' => $visa_file_apply->id,
                            'cos_assigned' => null,
                            'visa_application_started' => null,
                            'visa_application_start_date' => null,
                            'visa_application_submitted' => null,
                            'visa_application_submit_date' => null,
                            'biometric_appo_date' => null,
                            'documents_uploaded' => null,
                            'interview_date_confirm' => null,
                            'interview_date' => null,
                            'mock_interview_confirm' => null,
                            'mock_interview_date' => null,
                            'remarks' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                            'addn_visa' => 'No',
                            'master_applicant_id' => $request->master_applicant_id,
                        );

                        DB::table('visa_file_emp')->insert($dataVisaEmp);

                    }
                    Session::flash('message', ' Visa File Added Successfully .');

                    $this->addAdminLog(10, 'Visa File Added.');

                    return redirect('superadmin/view-visa-file');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }


    public function viewAddRecruitmentFile()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')
                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')
                    ->get();

                return View('admin/recruitment-file-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddcosy(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                // dd($request->all());
                $check_recruitment = DB::Table('recruitment_file_emp')
                    ->where('emid', '=', $request->emid)
                    ->orderBy('id', 'desc')
                    ->first();

                // dd($check_recruitment);

                if (!empty($check_recruitment)) {

                    $ckeck_dept = DB::Table('cos_apply_emp')
                        ->where('emid', '=', $request->emid)
                        ->where('employee_name', '=', $request->employee_name)
                        ->whereNotNull('employee_id')
                        ->orderBy('id', 'desc')
                        ->first();

                } else {
                    $ckeck_dept = DB::Table('cos_apply')
                        ->where('emid', '=', $request->emid)
                        ->where('employee_id', '=', $request->ref_id)
                        ->orderBy('id', 'desc')
                        ->first();

                }
                //dd($check_recruitment);
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'cos File Already Exists.');
                    return redirect('superadmin/view-add-cos');
                } else {
                    if (!empty($check_recruitment)) {
                        $cos_apply_emp = DB::Table('cos_apply_emp')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->first();
                        //dd($cos_apply_emp);
                        $dataCosEmp = array(
                            'employee_id' => $request->ref_id,
                            'date' => date('Y-m-d'),
                        );

                        $updateCosEmp = DB::table('cos_apply_emp')->where('id', $cos_apply_emp->id)->update($dataCosEmp);

                        //$updateCosEmp = DB::table('cos_apply')->where('id', $cos_apply_emp->com_cos_apply_id)->update($dataCosEmp);

                        $ckeck_cos = DB::table('cos_apply')
                            ->where('id', $cos_apply_emp->com_cos_apply_id)
                            ->first();

                        if ($ckeck_cos->employee_id == '') {
                            $updateCosEmp = DB::table('cos_apply')->where('id', $cos_apply_emp->com_cos_apply_id)->update($dataCosEmp);
                        } else {

                            if ($ckeck_cos->employee_id != $request->ref_id) {
                                $datahh = array(
                                    'emid' => $request->emid,
                                    'employee_id' => $request->ref_id,
                                    'date' => date('Y-m-d'),
                                    'status' => 'Request',
                                );

                                $add_cos = DB::table('cos_apply')->insert($datahh);

                                $cos_apply = DB::Table('cos_apply')
                                    ->where('emid', '=', $request->emid)
                                    ->where('employee_id', '=', $request->ref_id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                //dd($add_cos);
                                $dataCosEmp1 = array(
                                    'com_cos_apply_id' => $cos_apply->id,
                                );

                                $updateCosEmp1 = DB::table('cos_apply_emp')->where('id', $cos_apply_emp->id)->update($dataCosEmp1);
                            }
                        }
                    } else {
                        $datahh = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $add_cos = DB::table('cos_apply')->insert($datahh);

                        //Add employee to cos with blank case worker

                        $cos_apply = DB::Table('cos_apply')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $dataCosEmp = array(
                            'emid' => $request->emid,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_cos_apply_id' => $cos_apply->id,
                            'employee_id' => $request->ref_id,
                            'cos' => null,
                            'applied_cos_date' => null,
                            'type_of_cos' => null,
                            'additional_info_requested' => null,
                            'additional_info_request_date' => null,
                            'additional_info_sent' => null,
                            'additional_info_sent_date' => null,
                            'cos_assigned' => null,
                            'cos_assigned_date' => null,

                            'remarks_cos' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                        );

                        DB::table('cos_apply_emp')->insert($dataCosEmp);

                    }
                    //dd($cos_apply_emp->com_cos_apply_id);

                    $existingCompanyInfo = DB::table('registration')->where('reg', $request->emid)->first();
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->ref_id)
                        ->first();

                    //$toemail = 'info@workpermitcloud.co.uk';
                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for COS to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Requested COS');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    Session::flash('message', ' COS File Added Successfully .');

                    $this->addAdminLog(10, 'COS File Added.');

                    return redirect('superadmin/view-add-cos');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddcosyn(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                // dd($request->all());
                $check_recruitment = DB::Table('recruitment_file_emp')
                    ->where('emid', '=', $request->emid)
                    ->orderBy('id', 'desc')
                    ->first();

                // dd($check_recruitment);

                if (!empty($check_recruitment)) {

                    $ckeck_dept = null;

                } else {
                    $ckeck_dept = DB::Table('cos_apply')
                        ->where('emid', '=', $request->emid)
                        ->where('employee_id', '=', $request->ref_id)
                        ->orderBy('id', 'desc')
                        ->first();

                }
                // dd($ckeck_dept);
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'cos File Already Exists.');
                    return redirect('superadmin/view-add-cos');
                } else {
                    if (!empty($check_recruitment)) {
                        $cos_applyx = DB::Table('cos_apply')
                            ->where('emid', '=', $request->emid)
                        //->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();

                        //dd($cos_apply);

                        $dataCosEmp = array(
                            'emid' => $request->emid,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_cos_apply_id' => $cos_applyx->id,
                            'employee_id' => $request->ref_id,
                            'cos' => null,
                            'applied_cos_date' => null,
                            'type_of_cos' => null,
                            'additional_info_requested' => null,
                            'additional_info_request_date' => null,
                            'additional_info_sent' => null,
                            'additional_info_sent_date' => null,
                            'cos_assigned' => null,
                            'cos_assigned_date' => null,

                            'remarks_cos' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                            'addn_cos' => 'Yes',
                        );

                        DB::table('cos_apply_emp')->insert($dataCosEmp);

                        $cos_apply_emp = DB::Table('cos_apply_emp')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->first();

                        $ckeck_cos = DB::table('cos_apply')
                            ->where('id', $cos_apply_emp->com_cos_apply_id)
                            ->first();

                        if ($ckeck_cos->employee_id == '') {
                            $updateCosEmp = DB::table('cos_apply')->where('id', $cos_apply_emp->com_cos_apply_id)->update($dataCosEmp);
                        } else {

                            if ($ckeck_cos->employee_id != $request->ref_id) {
                                $datahh = array(
                                    'emid' => $request->emid,
                                    'employee_id' => $request->ref_id,
                                    'date' => date('Y-m-d'),
                                    'status' => 'Request',
                                );

                                $add_cos = DB::table('cos_apply')->insert($datahh);

                                $cos_apply = DB::Table('cos_apply')
                                    ->where('emid', '=', $request->emid)
                                    ->where('employee_id', '=', $request->ref_id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                //dd($add_cos);
                                $dataCosEmp1 = array(
                                    'com_cos_apply_id' => $cos_apply->id,
                                );

                                $updateCosEmp1 = DB::table('cos_apply_emp')->where('id', $cos_apply_emp->id)->update($dataCosEmp1);
                            }
                        }
                    } else {
                        $datahh = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $add_cos = DB::table('cos_apply')->insert($datahh);

                        //Add employee to cos with blank case worker

                        $cos_apply = DB::Table('cos_apply')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $dataCosEmp = array(
                            'emid' => $request->emid,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_cos_apply_id' => $cos_apply->id,
                            'employee_id' => $request->ref_id,
                            'cos' => null,
                            'applied_cos_date' => null,
                            'type_of_cos' => null,
                            'additional_info_requested' => null,
                            'additional_info_request_date' => null,
                            'additional_info_sent' => null,
                            'additional_info_sent_date' => null,
                            'cos_assigned' => null,
                            'cos_assigned_date' => null,

                            'remarks_cos' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                        );

                        DB::table('cos_apply_emp')->insert($dataCosEmp);

                    }
                    //dd($cos_apply_emp->com_cos_apply_id);
                    $existingCompanyInfo = DB::table('registration')->where('reg', $request->emid)->first();
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->ref_id)
                        ->first();

                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for COS to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Requested COS');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    Session::flash('message', ' COS File Added Successfully .');

                    $this->addAdminLog(10, 'COS File Added.');

                    return redirect('superadmin/view-add-cos');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddVisaFile(Request $request)
    {
        try {
            $email = Session::get('empsu_email');

            if (!empty($email)) {

                $check_cos = DB::Table('cos_apply_emp')
                    ->where('emid', '=', $request->emid)
                    ->where('employee_name', '=', $request->employee_name)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!empty($check_cos)) {
                    $ckeck_dept = DB::Table('visa_file_emp')
                        ->where('emid', '=', $request->emid)
                        ->where('employee_name', '=', $request->employee_name)
                        ->whereNotNull('employee_id')
                        ->orderBy('id', 'desc')
                        ->first();

                } else {
                    $ckeck_dept = DB::Table('visa_file_apply')
                        ->where('emid', '=', $request->emid)
                        ->where('employee_id', '=', $request->ref_id)
                        ->orderBy('id', 'desc')
                        ->first();

                }

                // dd($ckeck_dept);

                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Visa File Already Exists.');
                    return redirect('superadmin/view-visa-file');
                } else {

                    if (!empty($check_cos)) {

                        $visa_file_emp = DB::Table('visa_file_emp')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->first();
                        //      dd($visa_file_emp);
                        $dataVisaEmp = array(
                            'employee_id' => $request->ref_id,
                            'date' => date('Y-m-d'),
                        );

                        $updateVisaEmp = DB::table('visa_file_emp')->where('id', $visa_file_emp->id)->update($dataVisaEmp);

                        $ckeck_visa = DB::table('visa_file_apply')
                            ->where('id', $visa_file_emp->com_visa_apply_id)
                            ->first();

                        if ($ckeck_visa->employee_id == '') {
                            $updateVisaEmp = DB::table('visa_file_apply')->where('id', $visa_file_emp->com_visa_apply_id)->update($dataVisaEmp);
                        } else {

                            if ($ckeck_visa->employee_id != $request->ref_id) {
                                $datahh = array(
                                    'emid' => $request->emid,
                                    'employee_id' => $request->ref_id,
                                    'date' => date('Y-m-d'),
                                    'status' => 'Request',
                                );

                                $add_cos = DB::table('visa_file_apply')->insert($datahh);

                                $visa_file_apply = DB::Table('visa_file_apply')
                                    ->where('emid', '=', $request->emid)
                                    ->where('employee_id', '=', $request->ref_id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                //dd($add_cos);
                                $dataVisaEmp1 = array(
                                    'com_visa_apply_id' => $visa_file_apply->id,
                                );

                                $updateVisaEmp1 = DB::table('visa_file_emp')->where('id', $visa_file_emp->id)->update($dataVisaEmp1);
                            }
                        }
                    } else {
                        $datahh = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $add_visa = DB::table('visa_file_apply')->insert($datahh);

                        //Add employee to cos with blank case worker

                        $visa_file_apply = DB::Table('visa_file_apply')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataVisaEmp = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_visa_apply_id' => $visa_file_apply->id,
                            'cos_assigned' => null,
                            'visa_application_started' => null,
                            'visa_application_start_date' => null,
                            'visa_application_submitted' => null,
                            'visa_application_submit_date' => null,
                            'biometric_appo_date' => null,
                            'documents_uploaded' => null,
                            'interview_date_confirm' => null,
                            'interview_date' => null,
                            'mock_interview_confirm' => null,
                            'mock_interview_date' => null,
                            'remarks' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                        );

                        DB::table('visa_file_emp')->insert($dataVisaEmp);

                    }
                    Session::flash('message', ' Visa File Added Successfully .');

                    $existingCompanyInfo = DB::table('registration')->where('reg', $request->emid)->first();
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->ref_id)
                        ->first();

                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data_email = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for VISA to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Organisation VISA Case Worker Assigned');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    $this->addAdminLog(10, 'Visa File Added.');

                    return redirect('superadmin/view-visa-file');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddVisaFileAdn(Request $request)
    {
        try {
            $email = Session::get('empsu_email');

            if (!empty($email)) {

                //dd($request->all());

                $check_cos = DB::Table('cos_apply_emp')
                    ->where('emid', '=', $request->emid)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!empty($check_cos)) {
                    $ckeck_dept = null;

                } else {
                    $ckeck_dept = DB::Table('visa_file_apply')
                        ->where('emid', '=', $request->emid)
                        ->where('employee_id', '=', $request->ref_id)
                        ->orderBy('id', 'desc')
                        ->first();

                }
                // if (!empty($check_recruitment)) {

                //     $ckeck_dept = null;

                // } else {
                //     $ckeck_dept = DB::Table('cos_apply')
                //         ->where('emid', '=', $request->emid)
                //         ->where('employee_id', '=', $request->ref_id)
                //         ->orderBy('id', 'desc')
                //         ->first();

                // }

                //dd($ckeck_dept);

                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Visa File Already Exists.');
                    return redirect('superadmin/view-visa-file');
                } else {

                    if (!empty($check_cos)) {

                        $visa_file_applyx = DB::Table('visa_file_apply')
                            ->where('emid', '=', $request->emid)
                        //->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataVisaEmp = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_visa_apply_id' => $visa_file_applyx->id,
                            'cos_assigned' => null,
                            'visa_application_started' => null,
                            'visa_application_start_date' => null,
                            'visa_application_submitted' => null,
                            'visa_application_submit_date' => null,
                            'biometric_appo_date' => null,
                            'documents_uploaded' => null,
                            'interview_date_confirm' => null,
                            'interview_date' => null,
                            'mock_interview_confirm' => null,
                            'mock_interview_date' => null,
                            'remarks' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                            'addn_visa' => 'Yes',
                        );

                        DB::table('visa_file_emp')->insert($dataVisaEmp);

                        $visa_file_emp = DB::Table('visa_file_emp')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_name', '=', $request->employee_name)
                            ->orderBy('id', 'desc')
                            ->first();

                        // $dataVisaEmp = array(
                        //     'employee_id' => $request->ref_id,
                        // );

                        // $updateVisaEmp = DB::table('visa_file_emp')->where('id', $visa_file_emp->id)->update($dataVisaEmp);

                        $ckeck_visa = DB::table('visa_file_apply')
                            ->where('id', $visa_file_emp->com_visa_apply_id)
                            ->first();

                        if ($ckeck_visa->employee_id == '') {
                            $updateVisaEmp = DB::table('visa_file_apply')->where('id', $visa_file_emp->com_visa_apply_id)->update($dataVisaEmp);
                        } else {

                            if ($ckeck_visa->employee_id != $request->ref_id) {
                                $datahh = array(
                                    'emid' => $request->emid,
                                    'employee_id' => $request->ref_id,
                                    'date' => date('Y-m-d'),
                                    'status' => 'Request',
                                );

                                $add_cos = DB::table('visa_file_apply')->insert($datahh);

                                $visa_file_apply = DB::Table('visa_file_apply')
                                    ->where('emid', '=', $request->emid)
                                    ->where('employee_id', '=', $request->ref_id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                //dd($add_cos);
                                $dataVisaEmp1 = array(
                                    'com_visa_apply_id' => $visa_file_apply->id,
                                );

                                $updateVisaEmp1 = DB::table('visa_file_emp')->where('id', $visa_file_emp->id)->update($dataVisaEmp1);
                            }
                        }
                    } else {
                        $datahh = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'date' => date('Y-m-d'),
                            'status' => 'Request',
                        );

                        $add_visa = DB::table('visa_file_apply')->insert($datahh);

                        //Add employee to cos with blank case worker

                        $visa_file_apply = DB::Table('visa_file_apply')
                            ->where('emid', '=', $request->emid)
                            ->where('employee_id', '=', $request->ref_id)
                            ->orderBy('id', 'desc')
                            ->first();

                        $dataVisaEmp = array(
                            'emid' => $request->emid,
                            'employee_id' => $request->ref_id,
                            'com_employee_id' => null,
                            'employee_name' => $request->employee_name,
                            'com_visa_apply_id' => $visa_file_apply->id,
                            'cos_assigned' => null,
                            'visa_application_started' => null,
                            'visa_application_start_date' => null,
                            'visa_application_submitted' => null,
                            'visa_application_submit_date' => null,
                            'biometric_appo_date' => null,
                            'documents_uploaded' => null,
                            'interview_date_confirm' => null,
                            'interview_date' => null,
                            'mock_interview_confirm' => null,
                            'mock_interview_date' => null,
                            'remarks' => null,
                            'date' => date('Y-m-d'),
                            'status' => null,
                            'update_new_ct' => date('Y-m-d'),
                            'addn_visa' => 'Yes',
                        );

                        DB::table('visa_file_emp')->insert($dataVisaEmp);

                    }
                    Session::flash('message', ' Visa File Added Successfully .');

                    $this->addAdminLog(10, 'Visa File Added.');

                    return redirect('superadmin/view-visa-file');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddRecruitmentFile(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $ckeck_dept = DB::table('recruitment_file_apply')
                    ->where('emid', $request->emid)
                    ->where('employee_id', $request->ref_id)
                    ->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Recruitment File Already Exists.');
                    return redirect('superadmin/view-recruitment-file');
                } else {

                    $datahh = array(

                        'emid' => $request->emid,
                        'employee_id' => $request->ref_id,
                        'date' => date('Y-m-d'),
                        'status' => 'Request',

                    );

                    DB::table('recruitment_file_apply')->insert($datahh);

                    $existingCompanyInfo = DB::table('registration')->where('reg', $request->emid)->first();
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->ref_id)
                        ->first();

                    // $toemail = 'info@workpermitcloud.co.uk';
                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for Recruitment to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Organisation Recruitment Case Worker Assigned');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    Session::flash('message', ' Recruitment File Added Successfully .');

                    $this->addAdminLog(10, 'Recruitment File Added.');

                    return redirect('superadmin/view-recruitment-file');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddcosnew($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();

                $data['hr'] = DB::table('cos_apply_emp')

                    ->where('id', '=', base64_decode($comp_id))
                    ->first();

                //dd(base64_decode($comp_id));

                return View('admin/cos-edit', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewEditVisaFile($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();

                $data['hr'] = DB::table('visa_file_emp')
                    ->where('id', '=', base64_decode($comp_id))
                    ->first();

                return View('admin/visa-file-edit', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewEditRecruitmentFile($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();

                $data['hr'] = DB::table('recruitment_file_apply')
                    ->where('id', '=', base64_decode($comp_id))
                    ->first();

                return View('admin/recruitment-file-edit', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddcosgynew(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                //dd($request->all());

                $ckeck_dept = DB::table('cos_apply_emp')
                    ->where('emid', $request->emid)
                    ->where('employee_name', '=', $request->existing_employee_name)
                    ->where('id', '!=', $request->id)
                    ->first();

                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'COS File Assign Already Exists.');
                    return redirect('superadmin/view-tareq');
                } else {

                    $cos_apply_emp = DB::Table('cos_apply_emp')
                        ->where('id', '=', $request->id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $datagg = array(
                        'employee_id' => $request->employee_id,
                    );
                    DB::table('cos_apply_emp')->where('id', $request->id)->update($datagg);

                    $ckeck_cos = DB::table('cos_apply')
                        ->where('id', $cos_apply_emp->com_cos_apply_id)
                        ->first();

                    if ($ckeck_cos->employee_id != $request->employee_id) {
                        $exist_cos_cw = DB::table('cos_apply')
                            ->where('emid', $request->emid)
                            ->where('employee_id', $request->employee_id)
                            ->first();

                        if (empty($exist_cos_cw)) {
                            $datahh = array(
                                'emid' => $request->emid,
                                'employee_id' => $request->employee_id,
                                'date' => date('Y-m-d'),
                                'status' => 'Request',
                            );

                            // dd($datahh);

                            $add_cos = DB::table('cos_apply')->insert($datahh);

                            $cos_apply = DB::Table('cos_apply')
                                ->where('emid', '=', $request->emid)
                                ->where('employee_id', '=', $request->employee_id)
                                ->orderBy('id', 'desc')
                                ->first();

                            $dataCosEmp1 = array(
                                'com_cos_apply_id' => $cos_apply->id,
                            );

                            $updateCosEmp1 = DB::table('cos_apply_emp')->where('id', $request->id)->update($dataCosEmp1);

                        } else {
                            $dataCosEmp1 = array(
                                'com_cos_apply_id' => $exist_cos_cw->id,
                            );

                            $updateCosEmp1 = DB::table('cos_apply_emp')->where('id', $request->id)->update($dataCosEmp1);
                        }

                    }

                    Session::flash('message', ' COS File Changed Successfully .');

                    $existingCompanyInfo = DB::table('registration')->where('reg', $request->emid)->first();
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->employee_id)
                        ->first();

                    //$toemail = 'info@workpermitcloud.co.uk';
                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for COS to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Requested COS');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    $this->addAdminLog(10, 'COS File Changed.');

                    return redirect('superadmin/view-add-cos');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveEditVisaFile(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                //dd($request->all());

                $fetchEmidFromId=DB::table('visa_file_emp')
                    ->where('employee_name', '=', $request->existing_employee_name)
                    ->where('id', '=', $request->id)
                    ->first();

                    //dd($fetchEmidFromId);
                    $request->emid=$fetchEmidFromId->emid;
                   // dd($request->all());
                $ckeck_dept = DB::table('visa_file_emp')
                    ->where('emid', $request->emid)
                    ->where('employee_name', '=', $request->existing_employee_name)
                    ->where('id', '!=', $request->id)
                    ->first();

                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Visa File Assign Already Exists.');
                    return redirect('superadmin/view-visa-file');
                } else {

                    $visa_file_emp = DB::Table('visa_file_emp')
                        ->where('id', '=', $request->id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $datagg = array(
                        'employee_id' => $request->employee_id,
                    );
                    DB::table('visa_file_emp')->where('id', $request->id)->update($datagg);

                    $ckeck_visa = DB::table('visa_file_apply')
                        ->where('id', $visa_file_emp->com_visa_apply_id)
                        ->first();

                    if ($ckeck_visa->employee_id != $request->employee_id) {
                        $exist_visa_cw = DB::table('visa_file_apply')
                            ->where('emid', $request->emid)
                            ->where('employee_id', $request->employee_id)
                            ->first();

                        if (empty($exist_visa_cw)) {
                            $datahh = array(
                                'emid' => $request->emid,
                                'employee_id' => $request->employee_id,
                                'date' => date('Y-m-d'),
                                'status' => 'Request',
                            );

                            // dd($datahh);

                            $add_visa = DB::table('visa_file_apply')->insert($datahh);

                            $visa_file_apply = DB::Table('visa_file_apply')
                                ->where('emid', '=', $request->emid)
                                ->where('employee_id', '=', $request->employee_id)
                                ->orderBy('id', 'desc')
                                ->first();

                            $dataVisaEmp1 = array(
                                'com_visa_apply_id' => $visa_file_apply->id,
                            );

                            $updateCosEmp1 = DB::table('visa_file_emp')->where('id', $request->id)->update($dataVisaEmp1);

                        } else {
                            $dataVisaEmp1 = array(
                                'com_visa_apply_id' => $exist_visa_cw->id,
                            );

                            $updateCosEmp1 = DB::table('visa_file_emp')->where('id', $request->id)->update($dataVisaEmp1);
                        }

                    }

                    Session::flash('message', ' Visa File Changed Successfully .');

                    $existingCompanyInfo = DB::table('registration')->where('reg', $fetchEmidFromId->emid)->first();
                   // dd($existingCompanyInfo);
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->employee_id)
                        ->first();

                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data_email = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for VISA to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data_email, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Organisation VISA Case Worker Assigned');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    $this->addAdminLog(10, 'Visa File Changed.');

                    return redirect('superadmin/view-visa-file');
                }

            } else {
                return redirect('superadmin');
            }

            // if (!empty($email)) {

            //     $ckeck_dept = DB::table('visa_file_apply')->where('emid', $request->emid)->where('id', '!=', $request->id)->first();
            //     if (!empty($ckeck_dept)) {
            //         Session::flash('message', 'Visa File Assign Already Exists.');
            //         return redirect('superadmin/view-visa-file');
            //     } else {

            //         $datagg = array(
            //             'employee_id' => $request->employee_id,

            //         );
            //         DB::table('visa_file_apply')->where('id', $request->id)->update($datagg);
            //         Session::flash('message', ' Visa File Changed Successfully .');

            //         $this->addAdminLog(10, 'Visa File Changed.');

            //         return redirect('superadmin/view-visa-file');
            //     }

            // } else {
            //     return redirect('superadmin');
            // }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveEditRecruitmentFile(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

            //    dd($request->all());

                $fetchEmidFromId = DB::table('recruitment_file_apply')->where('id', '=', $request->id)->first();

                // dd($fetchEmidFromId);

                $ckeck_dept = DB::table('recruitment_file_apply')->where('employee_id','!=', $request->employee_id)->where('emid', '=', $fetchEmidFromId->emid)->first();

                // echo "EMID".$fetchEmidFromId->emid;
                // dd($ckeck_dept);

                // if (!empty($ckeck_dept)) {
                //     Session::flash('message', 'Recruitment File Assign Already Exists.');
                //     return redirect('superadmin/view-recruitment-file');
                // } else {

                    $datagg = array(
                        'employee_id' => $request->employee_id,

                    );
                    DB::table('recruitment_file_apply')->where('id', $request->id)->update($datagg);
                    Session::flash('message', ' Recruitment File Changed Successfully .');

                    $existingCompanyInfo = DB::table('registration')->where('reg', $fetchEmidFromId->emid)->first();
                    $caseworker = DB::Table('users_admin_emp')
                        ->where('employee_id', '=', $request->employee_id)
                        ->first();

                    // $toemail = 'info@workpermitcloud.co.uk';
                    $toemail = $caseworker->notification_email;

                    if ($toemail != '') {

                        $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been assigned for Recruitment to ' . $caseworker->name . '. Please proceed with the needful.');
                        Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Organisation Recruitment Case Worker Assigned');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }


                    $this->addAdminLog(10, 'Recruitment File Changed.');

                    return redirect('superadmin/view-recruitment-file');
                // }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewallcompanybillingreport()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();
                $data['bill_amout_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(amount)'))
                    ->get();
                $data['bill_sta_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(status)'))
                    ->get();
                $data['orname'] = DB::Table('registration')
                    ->orderBy('com_name', 'asc')
                    ->get();
                    //dd('okk');
                return View('admin/billreport-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedebillingreport(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')

                        ->whereBetween('date', [$start_date, $end_date])
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                    //dd($leave_allocation_rs);

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])

                        ->where('amount', '=', $request->amount)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])

                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('amount', '=', $request->amount)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('billing')
                        ->select('billing.*')

                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                }if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])
                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                }
                $totam = 0;
                $topayre = 0;
                $totdue = 0;

                $data['result'] = '';

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('payment')

                            ->where('in_id', '=', $leave_allocation->in_id)
                            ->select(DB::raw('sum(re_amount) as amount'))
                            ->first();
                        $passreg = DB::Table('registration')

                            ->where('reg', '=', $leave_allocation->emid)

                            ->first();
                        if ($passreg->licence == 'yes') {
                            $ffl = 'Granted';
                        } else {
                            $ffl = 'NOT Granted';
                        }
                        if (!empty($pass->amount)) {

                            $due = $pass->amount;
                        } else {
                            $due = '0';
                        }

                        $totam = $totam + $leave_allocation->amount;
                        $topayre = $topayre + $due;

                        $totdue = $totdue + $leave_allocation->due;
                        $pabillsts = DB::Table('hr_apply')

                            ->where('licence', '=', 'Granted')
                            ->where('emid', '=', $leave_allocation->emid)
                            ->first();
                        if (!empty($pabillsts)) {
                            $ffd = 'Granted';
                        } else {
                            $ffd = 'Not Granted';
                        }
                        if ($request->or_name == '') {

                            $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $leave_allocation->in_id . '</td>
														<td>' . $passreg->com_name . '</td>
												<td>' . $leave_allocation->amount . '</td>
                                                            <td>' . $due . '</td>
                                                             <td>' . $leave_allocation->due . '</td>
                                                             <td>' . strtoupper($leave_allocation->status) . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
														<td>' . $ffd . '</td>


						</tr>';
                            $f++;
                        } else if ($request->or_name != '' && $request->or_name == $leave_allocation->emid) {
                            $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $leave_allocation->in_id . '</td>
														<td>' . $passreg->com_name . '</td>
												<td>' . $leave_allocation->amount . '</td>
                                                            <td>' . $due . '</td>
                                                             <td>' . $leave_allocation->due . '</td>
                                                             <td>' . strtoupper($leave_allocation->status) . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
														<td>' . $ffd . '</td>


						</tr>';
                            $f++;
                        }
                    }
                }

                $data['amount'] = $request->amount;
                $data['status'] = $request->status;
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;
                $data['bill_amout_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(amount)'))
                    ->get();
                $data['bill_sta_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(status)'))
                    ->get();
                $data['totam'] = $totam;
                $data['topayre'] = $topayre;
                $data['totdue'] = $totdue;

                $data['or_name'] = $request->or_name;
                $data['orname'] = DB::Table('registration')
                    ->orderBy('com_name', 'asc')
                    ->get();

                $this->addAdminLog(4, 'Billing- Access Billing Report list view.');
                return View('admin/billreport-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function saveemployeedebillingreport_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $this->addAdminLog(4, 'Billing- Access Billing Report list export');
                return Excel::download(new ExcelFileExportBillReport($request->s_start_date, $request->s_end_date, $request->s_amount, $request->s_status), 'BillReport.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function saveemployeedebillingsearch_export(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $this->addAdminLog(4, 'Billing- Access Billing Search list export');
                return Excel::download(new ExcelFileExportBillSearch($request->s_start_date, $request->s_end_date, $request->s_amount, $request->s_status), 'BillSearchReport.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function savesearchopdfp(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')

                        ->whereBetween('date', [$start_date, $end_date])
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])

                        ->where('amount', '=', $request->amount)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])

                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('amount', '=', $request->amount)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('billing')
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                }if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])
                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->groupBy('in_id')
                        ->orderBy('date', 'asc')
                        ->get();

                }
                $totam = 0;
                $topayre = 0;
                $totdue = 0;
                $datap = ['leave_allocation_rs' => $leave_allocation_rs,
                    'or_name' => $request->or_name];

                $pdf = PDF::loadView('mypdfbillingreport', $datap);
                $pdf->setPaper('A4', 'landscape');
                //dd($datap);
                $this->addAdminLog(4, 'Billing- Downloaded Billing Report PDF.');
                return $pdf->download('billreport.pdf');
                $data['result'] = '';

                if ($leave_allocation_rs) {
                    $f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('payment')

                            ->where('in_id', '=', $leave_allocation->in_id)
                            ->select(DB::raw('sum(re_amount) as amount'))
                            ->first();
                        $passreg = DB::Table('registration')

                            ->where('reg', '=', $leave_allocation->emid)

                            ->first();

                        if (!empty($pass->amount)) {

                            $due = $pass->amount;
                        } else {
                            $due = '0';
                        }

                        $totam = $totam + $leave_allocation->amount;
                        $topayre = $topayre + $due;

                        $totdue = $totdue + $leave_allocation->due;

                        $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $leave_allocation->in_id . '</td>
														<td>' . $passreg->com_name . '</td>
												<td>' . $leave_allocation->amount . '</td>
                                                            <td>' . $due . '</td>
                                                             <td>' . $leave_allocation->due . '</td>
                                                             <td>' . strtoupper($leave_allocation->status) . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>


						</tr>';
                        $f++;}
                }

                $data['amount'] = $request->amount;
                $data['status'] = $request->status;
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;
                $data['bill_amout_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(amount)'))
                    ->get();
                $data['bill_sta_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(status)'))
                    ->get();
                $data['totam'] = $totam;
                $data['topayre'] = $topayre;
                $data['totdue'] = $totdue;

                return View('admin/billreport-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewlisthrlagtimegy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - Lag Time After Submission list view');

                return View('admin/home-lagtime', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlisthrreply($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - Reply list view');

                return View('admin/home-hrreply', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddroleass($com_id)
    {
        try {

            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['users'] = DB::table('users_admin_emp')
                    ->where('employee_id', '=', base64_decode($com_id))
                    ->first();
                $data['module'] = DB::Table('role_authorization_admin_organ')
                    ->join('registration', 'role_authorization_admin_organ.module_name', '=', 'registration.reg')
                    ->where('role_authorization_admin_organ.member_id', '=', base64_decode($com_id))

                    ->orderBy('registration.com_name', 'asc')
                    ->select('registration.*')->get();

                return view('admin/assignment-edit', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddroleass(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $datagg = array(

                    'member_id' => $request->employee_id,
                    'status' => $request->status,

                    'module_name' => $request->emid,

                );
                DB::table('role_authorization_admin_organ')->where('id', $request->newid)->update($datagg);
                Session::flash('message', 'Organisation Assignment Changed Successfully .');

                $this->addAdminLog(10, 'Organisation Assignment Changed.');

                return redirect('superadmin/view-organisation-assignment');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function deleteUserAccesscancelbill($role_authorization_id)
    {
        try {

            if (!empty(Session::get('empsu_email'))) {

                $billing = DB::table('billing')->where('in_id', base64_decode($role_authorization_id))->first();

                $recruitment_file_emp = DB::table('recruitment_file_emp')->where('bill_no', base64_decode($role_authorization_id))->first();

                if (!empty($recruitment_file_emp)) {

                    if ($billing->bill_for == 'first invoice recruitment service') {

                        $dataRec = array(
                            'billed_first_invoice' => 'No',
                            'bill_no' => null,
                        );
                        DB::table('recruitment_file_emp')->where('id', $recruitment_file_emp->id)->update($dataRec);
                    }

                }

                $cos_apply_emp = DB::table('cos_apply_emp')->where('bill_no', base64_decode($role_authorization_id))->first();

                if (!empty($cos_apply_emp)) {

                    if ($billing->bill_for == 'second invoice visa service') {

                        $dataCos = array(
                            'billed_second_invoice' => 'No',
                            'bill_no' => null,
                        );
                        DB::table('cos_apply_emp')->where('id', $cos_apply_emp->id)->update($dataCos);
                    }

                }

                $datagg = array(

                    'status' => 'cancel',

                );
                DB::table('billing')->where('in_id', base64_decode($role_authorization_id))->update($datagg);
                Session::flash('message', 'Invoice Canceled Successfully.');
                return redirect('superadmin/billing');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewsendcandidatedetailswork($comp_id)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['bill_rs'] = DB::table('billing')

                    ->where('emid', '=', base64_decode($comp_id))
                    ->get();
                return View('admin/bill-history', $data);

            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewlistfifdayssgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - Application - 15 Days+ list view');

                return View('admin/15days-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewlistinvoicesgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }
                $this->addAdminLog(1, 'Employee Tracker - Application - First Invoice list view');
                return View('admin/invoice-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewlistpartnergy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }
                $this->addAdminLog(1, 'Employee Tracker - Application - Partner Referral list view');
                return View('admin/partner-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewlistinvoicehldsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }
                $this->addAdminLog(1, 'Employee Tracker - Application - First Invoice (Hold) list view');
                return View('admin/invoice-holdlist', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewopen()
    {

        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('13', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['opencomplain'] = DB::table('complain')
                    ->where('status', '=', 'open')

                    ->get();

                $this->addAdminLog(13, 'Open complain - list viewed.');
                return View('admin/view-open', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function addcomplain()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('13', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $id = Input::get('id');
                $decrypted_id = base64_decode($id);
                $data['open'] = DB::table('complain')->where('id', '=', $decrypted_id)->first();

                $data['user'] = DB::Table('role_authorization_admin_organ')

                    ->where('member_id', '=', $data['open']->cr_by)
                    ->get();
                $data['module'] = DB::Table('module')

                    ->get();

                return View('admin/edit-open', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveopen(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (isset($request->newid) && $request->newid != '') {
                    $id = $request->newid;
                    if ($request->has('flie')) {

                        $file = $request->file('flie');
                        $extension = $request->flie->extension();
                        $path = $request->flie->store('employee_logo', 'public');
                        $dataggimg = array(
                            'flie' => $path,
                        );
                        DB::table('complain')->where('id', $id)->update($dataggimg);

                    }
                    $datagg = array(

                        'status' => $request->status,
                        'remarks' => $request->remarks,

                        'up_date' => date('Y-m-d'),

                    );
                    DB::table('complain')->where('id', $id)->update($datagg);

                    if ($request->status == 'solved') {
                        $check_complain = DB::table('complain')->where('id', $id)->first();
                        $check_user = DB::table('users_admin_emp')->where('employee_id', $check_complain->cr_by)->first();

                        $check_com = DB::table('registration')->where('reg', $check_complain->emid)->first();

                        $data = array('check_complain' => $check_complain, 'check_user' => $check_user, 'check_com' => $check_com);
                        // $toemail='dasankita406@gmail.com';
                        $toemail = $check_user->email;
                        Mail::send('mailsolvedcom', $data, function ($message) use ($toemail) {
                            $message->to($toemail, 'skilledworkerscloud')->subject
                                ('Complain   Update');
                            $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                        });
                    }

                    Session::flash('message', ' Complain Updated Successfully .');

                    $this->addAdminLog(13, 'No. ' . $id . ' updated with status: ' . $request->status);

                    return redirect('superadmin/view-complain');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewsolved()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('13', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['opencomplain'] = DB::table('complain')
                    ->where('status', '=', 'solved')

                    ->get();

                $this->addAdminLog(13, 'Solved list viewed.');
                return View('admin/view-solved', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewclosed()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('13', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['opencomplain'] = DB::table('complain')
                    ->where('status', '=', 'closed')

                    ->get();

                $this->addAdminLog(13, 'Closed list viewed.');
                return View('admin/view-closed', $data);
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewreportcomplain()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('13', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                return View('admin/search-list');
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveeportcomplain(Request $request)
    {try {
        if (!empty(Session::get('empsu_email'))) {

            $email = Session::get('empsu_email');

            $start_date = date('Y-m-d', strtotime($request->start_date));

            $end_date = date('Y-m-d', strtotime($request->end_date));
            $leave_allocation_rs = DB::table('complain')

                ->whereBetween('cr_date', [$request->start_date, $request->end_date])

                ->select('complain.*')
                ->get();

            $data['result'] = '';

            if ($leave_allocation_rs) {$f = 1;
                foreach ($leave_allocation_rs as $open) {

                    $employee_desigrs = DB::table('users_admin_emp')
                        ->where('employee_id', '=', $open->cr_by)

                        ->first();
                    $employee_or = DB::table('registration')
                        ->where('reg', '=', $open->emid)
                        ->where('reg', 'like', 'EM%')
                        ->first();
                    $com = '';
                    if (!empty($employee_or)) {$com = $employee_or->com_name;}
                    $or = '';
                    if ($open->cat_name == 'Others') {$or = '( ' . $open->others . ')';}
                    $link = '';
                    if ($open->flie != '') {$link = '<a href="' . env("BASE_URL") . 'public/' . $open->flie . '" download><i class="fas fa-download"></i></a>';}

                    $up_date = '';
                    if ($open->up_date != '') {
                        $up_date = date('d/m/Y', strtotime($open->up_date));
                    }
                    $close_date = '';
                    if ($open->close_date != '') {
                        $close_date = date('d/m/Y', strtotime($open->close_date));
                    }
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>

														<td>' . $open->p_name . '</td>
														<td>' . $open->cat_name . ' ' . $or . ' </td>
															<td>' . $com . '</td>
															<td>' . $employee_desigrs->name . '</td>
															<td>' . $link . '</td>
															<td>' . $open->descrption . '</td>
																<td>' . ucwords($open->status) . '</td>
												<td>' . date('d/m/Y', strtotime($open->cr_date)) . '</td>
													<td>' . $up_date . '</td>
													<td>' . $close_date . '</td>

													<td>' . $open->remarks . '</td>

						</tr>';
                    $f++;}
            }

            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));

            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));
            return view('admin/search-list', $data);
        } else {
            return redirect('superadmin');
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function savereportroDatacomplainemexcel(Request $request)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            $start_date = date('Y-m-d', strtotime($request->start_date));

            $end_date = date('Y-m-d', strtotime($request->end_date));
            $startn_date = date('d-m-Y', strtotime($request->start_date));

            $endn_date = date('d-m-Y', strtotime($request->end_date));

            return Excel::download(new ExcelFileExportComplain($start_date, $end_date), 'Complain ' . $startn_date . ' to ' . $endn_date . '.xlsx');

        } else {
            return redirect('superadmin');
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function savereportroDatahrawardemexcel(Request $request)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            if ($request->start_date != '') {
                $start_date = date('Y-m-d', strtotime($request->start_date));
            } else {
                $start_date = 'all';
            }
            if ($request->end_date != '') {
                $end_date = date('Y-m-d', strtotime($request->end_date));
            } else {
                $end_date = 'all';
            }
            if ($request->employee_id != '') {
                $employee_id = $request->employee_id;
            } else {
                $employee_id = 'all';
            }

            if ($request->start_date != '') {
                $startn_date = date('d-m-Y', strtotime($request->start_date));
            } else {
                $startn_date = '';
            }
            if ($request->end_date != '') {
                $endn_date = date('d-m-Y', strtotime($request->end_date));

            } else {
                $endn_date = '';
            }

            return Excel::download(new ExcelFileExportAwardgrant($start_date, $end_date, $employee_id), 'LicenceAwardDecision ' . $startn_date . ' to ' . $endn_date . '.xlsx');

        } else {
            return redirect('superadmin');
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function savereportroDatahrhomeemexcel(Request $request)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            if ($request->start_date != '') {
                $start_date = date('Y-m-d', strtotime($request->start_date));
            } else {
                $start_date = 'all';
            }
            if ($request->end_date != '') {
                $end_date = date('Y-m-d', strtotime($request->end_date));
            } else {
                $end_date = 'all';
            }
            if ($request->employee_id != '') {
                $employee_id = $request->employee_id;
            } else {
                $employee_id = 'all';
            }

            if ($request->start_date != '') {
                $startn_date = date('d-m-Y', strtotime($request->start_date));
            } else {
                $startn_date = '';
            }
            if ($request->end_date != '') {
                $endn_date = date('d-m-Y', strtotime($request->end_date));

            } else {
                $endn_date = '';
            }
            $this->addAdminLog(1, 'Employee Tracker - HR - Home Office Client Visit  list export');
            return Excel::download(new ExcelFileExportHomeOffice($start_date, $end_date, $employee_id), 'HomeOfficeClient ' . $startn_date . ' to ' . $endn_date . '.xlsx');

        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function savereportroDatahrlagtimeemexcel(Request $request)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            if ($request->start_date != '') {
                $start_date = date('Y-m-d', strtotime($request->start_date));
            } else {
                $start_date = 'all';
            }
            if ($request->end_date != '') {
                $end_date = date('Y-m-d', strtotime($request->end_date));
            } else {
                $end_date = 'all';
            }
            if ($request->employee_id != '') {
                $employee_id = $request->employee_id;
            } else {
                $employee_id = 'all';
            }

            if ($request->start_date != '') {
                $startn_date = date('d-m-Y', strtotime($request->start_date));
            } else {
                $startn_date = '';
            }
            if ($request->end_date != '') {
                $endn_date = date('d-m-Y', strtotime($request->end_date));

            } else {
                $endn_date = '';
            }

            $this->addAdminLog(1, 'Employee Tracker - HR - Lag Time After Submission list export');

            return Excel::download(new ExcelFileExportLagTime($start_date, $end_date, $employee_id), 'LagTimeAfterSubmission ' . $startn_date . ' to ' . $endn_date . '.xlsx');

        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function savereportroDatahrreplyexcel(Request $request)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            if ($request->start_date != '') {
                $start_date = date('Y-m-d', strtotime($request->start_date));
            } else {
                $start_date = 'all';
            }
            if ($request->end_date != '') {
                $end_date = date('Y-m-d', strtotime($request->end_date));
            } else {
                $end_date = 'all';
            }
            if ($request->employee_id != '') {
                $employee_id = $request->employee_id;
            } else {
                $employee_id = 'all';
            }

            if ($request->start_date != '') {
                $startn_date = date('d-m-Y', strtotime($request->start_date));
            } else {
                $startn_date = '';
            }
            if ($request->end_date != '') {
                $endn_date = date('d-m-Y', strtotime($request->end_date));

            } else {
                $endn_date = '';
            }

            $this->addAdminLog(1, 'Employee Tracker - HR - Reply list export');

            return Excel::download(new ExcelFileExportHrReply($start_date, $end_date, $employee_id), 'HrReply ' . $startn_date . ' to ' . $endn_date . '.xlsx');

        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function getorsearchganapplication()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('2', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_active'] = DB::Table('users_admin_emp')

                    ->get();

                $this->addAdminLog(2, 'Application status visited.');
                return View('admin/application-search', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function vieworsearchganapplication(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;

                $this->addAdminLog(2, 'Application status viewed.');

                return View('admin/application-dashboard', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function savereportroDataapplicationemexcel(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->start_date != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                } else {
                    $start_date = 'all';
                }
                if ($request->end_date != '') {
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                } else {
                    $end_date = 'all';
                }

                if ($request->start_date != '') {
                    $startn_date = date('d-m-Y', strtotime($request->start_date));
                } else {
                    $startn_date = '';
                }
                if ($request->end_date != '') {
                    $endn_date = date('d-m-Y', strtotime($request->end_date));

                } else {
                    $endn_date = '';
                }

                $this->addAdminLog(2, 'Application status list exported.');

                return Excel::download(new ExcelFileExportApplicationStatus($start_date, $end_date), 'ApplicationStatus ' . $startn_date . ' to ' . $endn_date . '.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getetareactivity()
    {

        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('8', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['visa_rs'] = DB::Table('visa_activity_config')

                    ->where('status', '=', 'Active')
                    ->orderBy('id', 'asc')
                    ->get();

                $this->addAdminLog(8, 'List viewed.');
                return View('admin/visa-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewactivitygy($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('8', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['tareq'] = DB::table('visa_activity_config')

                    ->where('id', '=', base64_decode($comp_id))
                    ->first();
                return View('admin/visa-edit-act', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddactivitygy(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $datagg = array(

                    'name' => $request->name,

                    'duration' => $request->duration,
                    'update_date' => date('Y-m-d'),

                );
                DB::table('visa_activity_config')->where('id', $request->id)->update($datagg);
                Session::flash('message', 'Visa Activity Configuration Changed Successfully.');

                $this->addAdminLog(8, 'Visa Activity Configuration Changed for name: ' . $request->name);

                return redirect('superadmin/visa-activity');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewvisa()
    {

        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['bill_rs'] = DB::Table('visa_apply')

                    ->groupBy('emid')
                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(10, 'Visa allocation list viewed.');

                return View('admin/visa-add-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddvisay()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
                    ->where('registration.status', '=', 'active')
                    ->groupBy('role_authorization_admin_organ.module_name')
                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();
                return View('admin/visa-add', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveAddvisay(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $ckeck_dept = DB::table('visa_apply')->where('emid', $request->emid)->first();
                if (!empty($ckeck_dept)) {
                    Session::flash('message', 'Visa Allocation Already Exists.');
                    return redirect('superadmin/view-add-visa');
                } else {

                    foreach ($request['ref_id'] as $valuemenm) {

                        $datahh = array(

                            'emid' => $request->emid,
                            'employee_id' => $valuemenm,

                            'date' => date('Y-m-d'),
                            'status' => 'Allocate',

                        );

                        DB::table('visa_apply')->insert($datahh);

                    }

                    Session::flash('message', ' Visa Allocation Added Successfully .');

                    $this->addAdminLog(10, 'Visa Allocation Added.');

                    return redirect('superadmin/view-add-visa');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddvisaew($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('10', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['user'] = DB::Table('users_admin_emp')
                    ->where('status', '=', 'active')

                    ->get();

                $data['ref'] = DB::Table('reffer_mas')
                    ->where('status', '=', 'active')

                    ->get();

                $data['hr'] = DB::table('visa_apply')

                    ->where('emid', '=', base64_decode($comp_id))
                    ->first();
                return View('admin/visa-edit', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveAddvisagynew(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $ckeck_dept = DB::table('visa_apply')->where('emid', $request->emid)->where('id', '!=', $request->id)->first();

                DB::table('visa_apply')->where('emid', '=', $request->emid)->delete();

                foreach ($request['ref_id'] as $valuemenm) {

                    $datahh = array(

                        'emid' => $request->emid,
                        'employee_id' => $valuemenm,

                        'date' => date('Y-m-d'),
                        'update_new_ct' => date('Y-m-d'),
                        'status' => 'Allocate',

                    );

                    DB::table('visa_apply')->insert($datahh);

                }
                Session::flash('message', ' Visa Allocation Changed Successfully .');

                $this->addAdminLog(10, 'Visa Allocation Changed.');

                return redirect('superadmin/view-add-visa');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewlistvisaexpsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Visa Expiry list view');

                return View('admin/visaexp-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function viewvisaexpdetailswork($comp_id)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            $data['visa_rs'] = DB::table('visa_or_emp_details_apply')

                ->where('emid', '=', base64_decode($comp_id))
                ->get();
            $data['Roledata'] = DB::Table('registration')

                ->where('reg', '=', base64_decode($comp_id))
                ->first();
            return View('admin/visa-details', $data);

        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function viewlistvisanotifiactionsgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Visa Notification list view');

                return View('admin/visanotification-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getpackageTypes()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('9', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = DB::Table('package')

                    ->get();

                $this->addAdminLog(9, 'list viewed.');
                return view('admin/package', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPlans()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = DB::Table('plans')->get();

                $this->addAdminLog(15, 'list viewed.');
                return view('admin/plans', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPositions()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = InterviewPostion::get();

                $this->addAdminLog(15, 'list viewed.');

                //dd($data);
                return view('admin/positions', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getInterviewQuestions()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = InterviewQuestion::get();

                $this->addAdminLog(15, 'list viewed.');

                //dd($data);
                return view('admin/interview-questions', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCandidates()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = InterviewCandidate::join('interview_postions', 'interview_candidates.position_id', '=', 'interview_postions.id')
                ->select('interview_candidates.*',  'interview_postions.postion_name')
                ->get();

                $this->addAdminLog(15, 'list viewed.');

                //dd($data);
                return view('admin/interview-candidates', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPreMockInterviews()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = PreMockInterview::join('interview_candidates', 'pre_mock_interviews.candidate_id', '=', 'interview_candidates.id')
                ->join('interview_postions', 'interview_candidates.position_id', '=', 'interview_postions.id')
                ->select('pre_mock_interviews.*','interview_candidates.candidate_name','interview_candidates.client_name',  'interview_postions.postion_name')
                ->get();

                $this->addAdminLog(15, 'list viewed.');

                //dd($data);
                return view('admin/pre-mock-interviews', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getSubscriptions()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('16', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = DB::Table('subscriptions')
                ->select('subscriptions.*','registration.com_name','plans.plan_name')
                ->join('registration', 'registration.reg', '=', 'subscriptions.emid', 'inner')
                ->join('plans', 'plans.id', '=', 'subscriptions.plan_id', 'inner')
                ->get();

                $this->addAdminLog(16, 'list viewed.');
                return view('admin/subscriptions', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddpackageType()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('9', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                return view('admin/add-new-package');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddPlan()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                return view('admin/add-new-plan');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddPosition()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                return view('admin/add-new-position');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddInterviewQuestion()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['types']=array(
                    '0'=>'PRE-MOCK',
                    '1'=>'1POST-MOCK',
                    '2'=>'2POST-MOCK'
                );
                return view('admin/add-new-interview-question',$data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddCandidate()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['positions']=InterviewPostion::get();
                return view('admin/add-new-interview-candidate',$data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddPreMockInterview()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['candidates']=InterviewCandidate::get();
                $data['sections']=DB::table('interview_question_sections')->where('type', '=', '0')->get();
                $section_ids='';
                foreach($data['sections'] as $section){
                    $section_ids=$section_ids.$section->id.',';
                }
                $data['section_ids']=substr($section_ids,0 ,strlen($section_ids) - 1);

                $data['questions']=InterviewQuestion::where('type', '=', '0')->get();

                //dd($data);

                return view('admin/add-new-premock-interview',$data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddSubscription()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('16', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $data['companies']=DB::table('registration')->where('status', '=', 'active')->get();
                $data['plans']=DB::table('plans')->where('status', '=', 'active')->get();

                //dd($data);

                return view('admin/add-new-subscription',$data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
           //throw ($e);
        }
    }

    public function savepackageType(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (empty($request->id)) {
                    if (isset($request->vat_apply) && $request->vat_apply != '') {

                        $vat_apply = $request->vat_apply;
                    } else {
                        $vat_apply = 'N/A';
                    }

                    if (isset($request->discount_apply) && $request->discount_apply != '') {

                        $discount_apply = $request->discount_apply;
                    } else {
                        $discount_apply = 'N/A';
                    }
                    DB::table('package')->insert(
                        ['name' => $request->name, 'price' => $request->price, 'description' => $request->description, 'status' => $request->status,
                            'cr_date' => date('Y-m-d'), 'time_pre' => $request->time_pre, 'vat_apply' => $vat_apply, 'discount_apply' => $discount_apply]
                    );

                    Session::flash('message', 'Package Information Successfully saved.');

                    $this->addAdminLog(9, 'New package saved with name: ' . $request->name);

                    return redirect('superadmin/package');

                } else {

                    if (isset($request->vat_apply) && $request->vat_apply != '') {

                        $vat_apply = $request->vat_apply;
                    } else {
                        $vat_apply = 'N/A';
                    }

                    if (isset($request->discount_apply) && $request->discount_apply != '') {

                        $discount_apply = $request->discount_apply;
                    } else {
                        $discount_apply = 'N/A';
                    }
                    DB::table('package')
                        ->where('id', $request->id)
                        ->update(['name' => $request->name, 'price' => $request->price, 'description' => $request->description, 'status' => $request->status, 'time_pre' => $request->time_pre, 'up_date' => date('Y-m-d'), 'vat_apply' => $vat_apply, 'discount_apply' => $discount_apply]);

                    Session::flash('message', 'Package Information Successfully Updated.');

                    $this->addAdminLog(9, 'Package modified with name: ' . $request->name);

                    return redirect('superadmin/package');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function savePlan(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (empty($request->id)) {
                    DB::table('plans')->insert(
                        ['plan_name' => $request->plan_name, 'price' => $request->price, 'validity' => $request->validity, 'status' => $request->status,
                            'created_at' => date('Y-m-d H:i:s')]
                    );

                    Session::flash('message', 'Plan Information Successfully saved.');

                    $this->addAdminLog(15, 'New plan saved with name: ' . $request->name);

                    return redirect('superadmin/plans');

                } else {

                    DB::table('plans')
                        ->where('id', $request->id)
                        ->update(['plan_name' => $request->plan_name, 'price' => $request->price, 'validity' => $request->validity, 'status' => $request->status, 'updated_at' => date('Y-m-d H:i:s')]);

                    Session::flash('message', 'Plan Information Successfully Updated.');

                    $this->addAdminLog(15, 'Plan modified with name: ' . $request->name);

                    return redirect('superadmin/plans');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function savePosition(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (empty($request->id)) {
                    // DB::table('plans')->insert(
                    //     ['plan_name' => $request->plan_name, 'price' => $request->price, 'validity' => $request->validity, 'status' => $request->status,
                    //         'created_at' => date('Y-m-d H:i:s')]
                    // );

                    $model  = new InterviewPostion;
                    $model->postion_name    = $request->postion_name;
                    $model->save();

                    Session::flash('message', 'Interview Position Information Successfully saved.');

                    $this->addAdminLog(15, 'New position saved with name: ' . $request->postion_name);

                    return redirect('superadmin/positions');

                } else {

                    // DB::table('plans')
                    //     ->where('id', $request->id)
                    //     ->update(['plan_name' => $request->plan_name, 'price' => $request->price, 'validity' => $request->validity, 'status' => $request->status, 'updated_at' => date('Y-m-d H:i:s')]);

                    $model = InterviewPostion::find($request->id);
                    if(!$model){
                        throw new Exception("No result was found for id: $request->id");
                    }

                    $model->postion_name    = $request->postion_name;
                    $model->save();

                    Session::flash('message', 'Interview Position Information Successfully Updated.');

                    $this->addAdminLog(15, 'Interview Position modified with name: ' . $request->postion_name);

                    return redirect('superadmin/positions');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveInterviewQuestion(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                //dd($request->all());
                if (empty($request->id)) {

                    $model  = new InterviewQuestion;
                    $model->question    = $request->question;
                    $model->section    = $request->section;
                    $model->type    = $request->interview_type;
                    $model->save();

                    Session::flash('message', 'Interview Question Information Successfully saved.');

                    $this->addAdminLog(15, 'New question saved with name: ' . $request->question);

                    return redirect('superadmin/interview-questions');

                } else {

                    $model = InterviewQuestion::find($request->id);
                    if(!$model){
                        throw new Exception("No result was found for id: $request->id");
                    }

                    $model->question    = $request->question;
                    $model->section    = $request->section;
                    $model->type    = $request->interview_type;
                    $model->save();

                    Session::flash('message', 'Interview Question Information Successfully Updated.');

                    $this->addAdminLog(15, 'Interview Question modified with name: ' . $request->question);

                    return redirect('superadmin/interview-questions');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveInterviewCandidate(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                //dd($request->all());
                if (empty($request->id)) {

                    $model  = new InterviewCandidate;
                    $model->candidate_name    = $request->candidate_name;
                    $model->position_id    = $request->position_id;
                    $model->client_name    = $request->client_name;
                    $model->save();

                    Session::flash('message', 'Interview Candidate Information Successfully saved.');

                    $this->addAdminLog(15, 'New Candidate saved with name: ' . $request->question);

                    return redirect('superadmin/interview-candidate');

                } else {

                    $model = InterviewCandidate::find($request->id);
                    if(!$model){
                        throw new Exception("No result was found for id: $request->id");
                    }

                    $model->candidate_name    = $request->candidate_name;
                    $model->position_id    = $request->position_id;
                    $model->client_name    = $request->client_name;
                    $model->save();

                    Session::flash('message', 'Interview Question Information Successfully Updated.');

                    $this->addAdminLog(15, 'Interview Candidate modified with name: ' . $request->question);

                    return redirect('superadmin/interview-candidate');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function savePreMockInterview(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

               dd($request->all());
                //dd($request['standard_'.'6']);
                //dd($request['cap_rscore']);

                if (empty($request->id)) {

                    $check_interview=PreMockInterview::where('candidate_id', '=', $request->candidate_id)->get();

                    if(!empty($check_interview)){
                        Session::flash('error', 'Pre-Mock Interview Already taken for the selected candidate.');

                        return redirect('superadmin/pre-mock-interviews');
                    }

                    $model  = new PreMockInterview;
                    $model->candidate_id    = $request->candidate_id;
                    $model->interviewer    = $request->interviewer;
                    $model->interview_date    = $request->interview_date;
                    $model->capstone_value    = $request->cap_value;
                    $model->capstone_rscore    = $request->cap_rscore;
                    $model->capstone_score    = $request->cap_score;
                    $model->comment    = $request->comment;
                    $model->save();

                    $interview_id=$model->id;

                    $questions=InterviewQuestion::where('type', '=', '0')->get();

                    foreach($questions as $question){
                        $model1  = new PreMockInterviewDetail;
                        $model1->interview_id    = $interview_id;
                        $model1->question_id    = $question->id;
                        $model1->rating    = (isset($request['rating_'.$question->id]))? $request['rating_'.$question->id]:0;
                        $model1->profile_factor    = (isset($request['factor_'.$question->id]))? $request['factor_'.$question->id]:'';
                        $model1->comment    = (isset($request['comment_'.$question->id]))? $request['comment_'.$question->id]:'';

                        $model1->save();

                    }

                    $sections=DB::table('interview_question_sections')->where('type', '=', '0')->get();

                    foreach($sections as $section){
                        $model2  = new PreMockCapstoneDetail;
                        $model2->interview_id    = $interview_id;
                        $model2->section_id    = $section->id;
                        $model2->capstone_value    = (isset($request['cap_value_'.$section->id]))? $request['cap_value_'.$section->id]:0;
                        $model2->capstone_rscore    = (isset($request['cap_rscore_'.$section->id]))? $request['cap_rscore_'.$section->id]:0;
                        $model2->capstone_load    = (isset($request['cap_load_'.$section->id]))? $request['cap_load_'.$section->id]:0;
                        $model2->capstone_score    = (isset($request['cap_score_'.$section->id]))? $request['cap_score_'.$section->id]:0;

                        $model2->save();

                    }



                    Session::flash('message', 'Pre-Mock Interview Information Successfully saved.');

                    $this->addAdminLog(15, 'New Pre-Mock Interview saved with id: ' . $interview_id);

                    return redirect('superadmin/pre-mock-interviews');

                } else {

                    $model = PreMockInterview::find($request->id);
                    if(!$model){
                        throw new Exception("No result was found for id: $request->id");
                    }

                    //$model  = new PreMockInterview;
                    $model->candidate_id    = $request->candidate_id;
                    $model->interviewer    = $request->interviewer;
                    $model->interview_date    = $request->interview_date;
                    $model->capstone_value    = $request->cap_value;
                    $model->capstone_rscore    = $request->cap_rscore;
                    $model->capstone_score    = $request->cap_score;
                    $model->comment    = $request->comment;
                    $model->save();

                    $interview_id=$request->id;

                    DB::table('pre_mock_interview_details')->where('interview_id', '=', $interview_id)->delete();
                    DB::table('pre_mock_capstone_details')->where('interview_id', '=', $interview_id)->delete();

                    $questions=InterviewQuestion::where('type', '=', '0')->get();

                    foreach($questions as $question){
                        $model1  = new PreMockInterviewDetail;
                        $model1->interview_id    = $interview_id;
                        $model1->question_id    = $question->id;
                        $model1->rating    = (isset($request['rating_'.$question->id]))? $request['rating_'.$question->id]:0;
                        $model1->profile_factor    = (isset($request['factor_'.$question->id]))? $request['factor_'.$question->id]:'';
                        $model1->comment    = (isset($request['comment_'.$question->id]))? $request['comment_'.$question->id]:'';

                        $model1->save();

                    }

                    $sections=DB::table('interview_question_sections')->where('type', '=', '0')->get();

                    foreach($sections as $section){
                        $model2  = new PreMockCapstoneDetail;
                        $model2->interview_id    = $interview_id;
                        $model2->section_id    = $section->id;
                        $model2->capstone_value    = (isset($request['cap_value_'.$section->id]))? $request['cap_value_'.$section->id]:0;
                        $model2->capstone_rscore    = (isset($request['cap_rscore_'.$section->id]))? $request['cap_rscore_'.$section->id]:0;
                        $model2->capstone_load    = (isset($request['cap_load_'.$section->id]))? $request['cap_load_'.$section->id]:0;
                        $model2->capstone_score    = (isset($request['cap_score_'.$section->id]))? $request['cap_score_'.$section->id]:0;

                        $model2->save();

                    }


                    Session::flash('message', 'Pre-Mock Interview Information Successfully Updated.');

                    $this->addAdminLog(15, 'Pre-Mock Interview modified with id: ' . $interview_id);

                    return redirect('superadmin/pre-mock-interviews');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function saveSubscription(Request $request)
    {
        try {
                //dd($request->all());
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (empty($request->id)) {
                    $org = DB::table('registration')
                        ->where('reg', '=', $request->emid)
                        ->where('status', '=', 'active')
                        ->first();
                    $plan = DB::table('plans')
                        ->where('id', '=', $request->plan_id)
                        ->where('status', '=', 'active')
                        ->first();

                    $expiry_date='';
                    if(!empty($plan)){
                        $expiry_date=date('Y-m-d', strtotime($request->start_date." +".$plan->validity." days"));
                    }
                    //echo $expiry_date;

                    DB::table('subscriptions')->insert(
                        ['emid' => $request->emid, 'plan_id' => $request->plan_id, 'start_date' => $request->start_date, 'expiry_date' => $expiry_date, 'status' => $request->status,
                            'created_at' => date('Y-m-d H:i:s')]
                    );

                    Session::flash('message', 'Subscription Information Successfully saved.');

                    $this->addAdminLog(16, 'New Subscription saved with plan name: ' . $plan->plan_name.' for organisation: '.$org->com_name);

                    return redirect('superadmin/subscriptions');

                } else {

                    $org = DB::table('registration')
                        ->where('reg', '=', $request->emid)
                        ->where('status', '=', 'active')
                        ->first();
                    $plan = DB::table('plans')
                        ->where('id', '=', $request->plan_id)
                        ->where('status', '=', 'active')
                        ->first();

                    $expiry_date='';
                    if(!empty($plan)){
                        $expiry_date=date('Y-m-d', strtotime($request->start_date." +".$plan->validity." days"));
                    }

                    DB::table('subscriptions')
                        ->where('id', $request->id)
                        ->update(['emid' => $request->emid, 'plan_id' => $request->plan_id, 'start_date' => $request->start_date, 'expiry_date' => $expiry_date,'status' => $request->status, 'updated_at' => date('Y-m-d H:i:s')]);

                    Session::flash('message', 'Subscription Information Successfully Updated.');

                    $this->addAdminLog(16, 'Subscription modified with plan name: ' . $plan->plan_name.' for organisation: '.$org->com_name);

                    return redirect('superadmin/subscriptions');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function exportSubscription(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            if (!empty($email)) {
                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('16', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $this->addAdminLog(16, 'Subscription list export');

                return Excel::download(new ExcelFileExportSubscription(), 'Subscription.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }


    public function getpackageId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('9', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type'] = DB::table('package')->where('id', base64_decode($id))->first();

                return view('admin/add-new-package', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPlanId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type'] = DB::table('plans')->where('id', base64_decode($id))->first();

                return view('admin/add-new-plan', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPositionId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type'] = InterviewPostion::where('id', base64_decode($id))->first();

                return view('admin/add-new-position', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getInterviewQuestionId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['types']=array(
                    '0'=>'PRE-MOCK',
                    '1'=>'1POST-MOCK',
                    '2'=>'2POST-MOCK'
                );

                $data['employee_type'] = InterviewQuestion::where('id', base64_decode($id))->first();

                return view('admin/add-new-interview-question', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getInterviewCandidateId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['positions']=InterviewPostion::get();

                $data['employee_type'] = InterviewCandidate::where('id', base64_decode($id))->first();

                return view('admin/add-new-interview-candidate', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPreMockInterviewId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('15', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['candidates']=InterviewCandidate::get();
                $data['sections']=DB::table('interview_question_sections')->where('type', '=', '0')->get();
                $section_ids='';
                foreach($data['sections'] as $section){
                    $section_ids=$section_ids.$section->id.',';
                }
                $data['section_ids']=substr($section_ids,0 ,strlen($section_ids) - 1);

                $data['questions']=InterviewQuestion::where('type', '=', '0')->get();

                $data['premock_interview'] = PreMockInterview::where('id', base64_decode($id))->first();
                if(!empty($data['premock_interview'])){

                    $data['premock_interview_detail'] = PreMockInterviewDetail::where('interview_id', $data['premock_interview']->id)->get();
                    $data['premock_capstone_detail'] = PreMockCapstoneDetail::where('interview_id', $data['premock_interview']->id)->get();
                }

                return view('admin/add-new-premock-interview', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function deletePosition($id)
    {
        try {
            $model = InterviewPostion::find($id);
            if(!$model){
                throw new Exception("No result was found for id: $id");
            }
            $model->delete();

            Session::flash('message', 'Record Deleted Successfully.');
            return redirect('superadmin/positions');
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getSubscriptionId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('16', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $data['companies']=DB::table('registration')->where('status', '=', 'active')->get();
                $data['plans']=DB::table('plans')->where('status', '=', 'active')->get();
                $data['employee_type'] = DB::table('subscriptions')->where('id', base64_decode($id))->first();

                //dd($data);

                return view('admin/add-new-subscription', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getblogTypes()
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['employee_type_rs'] = DB::Table('blog')
                    ->orderBy('id', 'desc')
                    ->get();

                return view('admin/blog', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddblogType()
    {try { $email = Session::get('empsu_email');
        if (!empty($email)) {

            $data['blog_cat_type_rs'] = DB::Table('blog_cat')
                ->where('status', '=', 'active')
                ->get();
            return view('admin/add-new-blog', $data);
        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function saveblogType(Request $request)
    {try {

        $email = Session::get('empsu_email');
        if (!empty($email)) {

            if ($request->has('image')) {

                $file = $request->file('image');
                $extension = $request->image->extension();
                $path = $request->image->store('blog', 'public');

            } else {

                $path = '';
            }

            if (empty($request->id)) {
                $slug = Str::slug($request->name, '-');
                $countslug = DB::Table('blog')
                    ->where('slug', 'like', $slug . '%')

                    ->get();
                if (count($countslug) != 0) {

                    $slug = $slug . '-' . count($countslug);
                } else {
                    $slug = $slug;
                }

                DB::table('blog')->insert(
                    ['name' => $request->name, 'content' => $request->content, 'cat' => $request->cat, 'status' => $request->status,
                        'cr_date' => date('Y-m-d H:i:s'), 'cr_by' => $request->cr_by, 'image' => $path, 'slug' => $slug]
                );

                Session::flash('message', 'Blog Information Successfully saved.');

                return redirect('superadmin/blog');

            } else {
                $slug = Str::slug($request->name, '-');
                $countslug = DB::Table('blog')
                    ->where('slug', 'like', $slug . '%')
                    ->where('id', '!=', $request->id)
                    ->get();
                if (count($countslug) != 0) {

                    $slug = $slug . '-' . count($countslug);
                } else {
                    $slug = $slug;
                }
                DB::table('blog')
                    ->where('id', $request->id)
                    ->update(['name' => $request->name, 'content' => $request->content, 'cat' => $request->cat, 'status' => $request->status, 'cr_by' => $request->cr_by, 'slug' => $slug]);

                if ($request->has('image')) {

                    $file_ps_add = $request->file('image');
                    $extension_ps_add = $request->image->extension();
                    $path_ps_ad = $request->image->store('blog', 'public');
                    $dataimgps = array(
                        'image' => $path_ps_ad,
                    );
                    DB::table('blog')
                        ->where('id', $request->id)
                        ->update($dataimgps);

                }

                Session::flash('message', 'Blog Information Successfully Updated.');

                return redirect('superadmin/blog');
            }

        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }

    }

    public function getblogId($id)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            $data['blog_cat_type_rs'] = DB::Table('blog_cat')
                ->where('status', '=', 'active')
                ->get();
            $data['employee_type'] = DB::table('blog')->where('id', base64_decode($id))->first();

            return view('admin/add-new-blog', $data);
        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }
    public function getblogcommentTypes()
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['employee_type_rs'] = DB::Table('blog_comment')
                    ->orderBy('id', 'desc')
                    ->get();

                return view('admin/blog-comment', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getblogcommentId($id)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            $data['employee_type'] = DB::table('blog_comment')->where('id', base64_decode($id))->first();
            $data['blog_cat_type_rs'] = DB::Table('blog')
                ->where('id', '=', $data['employee_type']->blog_id)
                ->first();
            return view('admin/add-new-blog-comment', $data);
        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function saveblogcommentType(Request $request)
    {try {

        $email = Session::get('empsu_email');
        if (!empty($email)) {

            DB::table('blog_comment')
                ->where('id', $request->id)
                ->update(['status' => $request->status]);

            Session::flash('message', 'Blog Comment Information Successfully Updated.');

            return redirect('superadmin/blog-comment');

        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }

    }

    public function getblogcatTypes()
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['employee_type_rs'] = DB::Table('blog_cat')
                    ->orderBy('id', 'desc')
                    ->get();

                return view('admin/blog-cat', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function viewAddblogcatType()
    {try { $email = Session::get('empsu_email');
        if (!empty($email)) {

            return view('admin/add-new-blog-cat');
        } else {
            return redirect('superadmin');
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function saveblogcatType(Request $request)
    {try {

        $email = Session::get('empsu_email');
        if (!empty($email)) {

            if (empty($request->id)) {

                DB::table('blog_cat')->insert(
                    ['name' => $request->name, 'status' => $request->status,
                    ]
                );

                Session::flash('message', 'Blog Category Information Successfully saved.');

                return redirect('superadmin/blog-cat');

            } else {
                DB::table('blog_cat')
                    ->where('id', $request->id)
                    ->update(['name' => $request->name, 'status' => $request->status]);

                Session::flash('message', 'Blog Category Information Successfully Updated.');

                return redirect('superadmin/blog-cat');
            }

        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }

    }

    public function getblogcatId($id)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            $data['employee_type'] = DB::table('blog_cat')->where('id', base64_decode($id))->first();

            return view('admin/add-new-blog-cat', $data);
        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }
    public function deleteBlog($role_authorization_id)
    {try { $email = Session::get('empsu_email');
        if (!empty($email)) {
            // echo $role_authorization_id; exit;
            $result = DB::table('blog')->where('id', '=', base64_decode($role_authorization_id))->delete();
            Session::flash('message', 'Blog deleted Successfully.');
            return redirect('superadmin/blog');
        } else {
            return redirect('superadmin');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function savereportroDatarequestemexcel(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->start_date != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                } else {
                    $start_date = 'all';
                }
                if ($request->end_date != '') {
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                } else {
                    $end_date = 'all';
                }
                if ($request->employee_id != '') {
                    $employee_id = $request->employee_id;
                } else {
                    $employee_id = 'all';
                }

                if ($request->start_date != '') {
                    $startn_date = date('d-m-Y', strtotime($request->start_date));
                } else {
                    $startn_date = '';
                }
                if ($request->end_date != '') {
                    $endn_date = date('d-m-Y', strtotime($request->end_date));

                } else {
                    $endn_date = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Request list export');

                return Excel::download(new ExcelFileExportCosRequest($start_date, $end_date, $employee_id), 'Request  ' . $startn_date . ' to ' . $endn_date . '.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savereportroDatagrantedemexcel(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->start_date != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                } else {
                    $start_date = 'all';
                }
                if ($request->end_date != '') {
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                } else {
                    $end_date = 'all';
                }
                if ($request->employee_id != '') {
                    $employee_id = $request->employee_id;
                } else {
                    $employee_id = 'all';
                }

                if ($request->start_date != '') {
                    $startn_date = date('d-m-Y', strtotime($request->start_date));
                } else {
                    $startn_date = '';
                }
                if ($request->end_date != '') {
                    $endn_date = date('d-m-Y', strtotime($request->end_date));

                } else {
                    $endn_date = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - COS - Granted list export');
//dd($employee_id);
                return Excel::download(new ExcelFileExportCosGrant($start_date, $end_date, $employee_id), 'Granted  ' . $startn_date . ' to ' . $endn_date . '.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getenquiryTypes()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('14', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = DB::Table('enquiry')
                    ->orderBy('id', 'desc')
                    ->get();

                $this->addAdminLog(14, 'list viewed.');
                return view('admin/enquiry', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savereportroDatalicenceemexcel(Request $request)
    {try {
        $email = Session::get('empsu_email');
        if (!empty($email)) {

            return Excel::download(new ExcelFileExportLicence($email), 'Lincence.xlsx');

        } else {
            return redirect('superadmin');
        }

    } catch (Exception $e) {
        throw new \App\Exceptions\AdminException($e->getMessage());
    }
    }

    public function viewlisthrefusededgy($start_date, $end_date, $employee_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('1', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')

                    ->get();

                $data['start_date'] = base64_decode($start_date);

                $data['end_date'] = base64_decode($end_date);
                $data['employee_id'] = base64_decode($employee_id);
                if ($data['start_date'] != 'all') {
                    $data['start_date'] = $data['start_date'];
                } else {
                    $data['start_date'] = '';
                }
                if ($data['end_date'] != 'all') {
                    $data['end_date'] = $data['end_date'];
                } else {
                    $data['end_date'] = '';
                }
                if ($data['employee_id'] != 'all') {
                    $data['employee_id'] = $data['employee_id'];
                } else {
                    $data['employee_id'] = '';
                }

                $this->addAdminLog(1, 'Employee Tracker - HR - Licence Refused list view');

                return View('admin/hrrefused-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function getInvoiceCandidates()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['candidates'] = DB::Table('invoice_candidates')->get();
                //dd($data);
                $this->addAdminLog(4, 'Billing - Candidate for Invoice list view.');
                return view('admin/invoicecandidate', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
     public function storeAddInvoiceCandidate(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $data['organisation'] = DB::Table('registration')
                    ->where('com_name', '=', $request->emidname)
                //    ->where('status', '=', 'active')
                // ->orWhere('verify', '=', 'approved')
                // ->orWhere('licence', '=', 'yes')
                    ->first();

                dd($request->emidname);

                $ins_data = array(
                    'candidate_name' => $request->candidate_name,
                    'address' => $request->address,
                    'employer_id' => $data['organisation']->id,
                    'emid' => $data['organisation']->reg,
                    'email' => $request->email,
                    'com_name' => $data['organisation']->com_name,
                    'status' => 'A',
                );

                // dd($ins_data);

                DB::table('invoice_candidates')->insert($ins_data);

                $this->addAdminLog(4, 'Billing - Added Candidate for Invoice named: ' . $request->candidate_name);

                Session::flash('message', 'Invoice Candidate Saved Successfully.');
                return redirect('superadmin/invoice-candidates');

            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddInvoiceCandidate()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                // $data['bill_rs'] = DB::Table('billing')
                //     ->where(function ($query) {
                //         $query->where('status', '=', 'not paid')
                //             ->orWhere('status', '=', 'partially paid');
                //     })
                //     ->orderBy('id', 'desc')
                //     ->get();

                $data['or_rs'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                // ->orWhere('verify', '=', 'approved')
                // ->orWhere('licence', '=', 'yes')
                    ->get();

                // $userlist = array();
                // foreach ($data['bill_rs'] as $user) {
                //     $userlist[] = $user->emid;
                // }

                $data['or_de'] = array();
                foreach ($data['or_rs'] as $key => $employee) {
                    //if (in_array($employee->reg, $userlist)) {
                    $data['or_de'][] = (object) array("reg" => $employee->reg, "com_name" => $employee->com_name);
                    //  } else {

                    // }

                }

                return view('admin/add-new-invoice-candidate', $data);
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function updateAddInvoiceCandidate($id, Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $candidateId = base64_decode($id);

                // echo $request->emidname;

                $data['organisation'] = DB::Table('registration')
                    ->where('com_name', '=', $request->emidname)
                //->where('status', '=', 'active')
                // ->orWhere('verify', '=', 'approved')
                // ->orWhere('licence', '=', 'yes')
                    ->first();
                //dd($data['organisation']);

                $ins_data = array(

                    'candidate_name' => $request->candidate_name,
                    'address' => $request->address,
                    'employer_id' => $data['organisation']->id,
                    'emid' => $data['organisation']->reg,
                    'email' => $request->email,
                    'com_name' => $data['organisation']->com_name,
                    'status' => $request->status,
                );
                DB::table('invoice_candidates')
                    ->where('id', $candidateId)
                    ->update($ins_data);

                //dd($ins_data);
                $this->addAdminLog(4, 'Billing - Modified Candidate for Invoice named: ' . $request->candidate_name);
                Session::flash('message', 'Invoice Candidate Updated Successfully.');
                return redirect('superadmin/invoice-candidates');

            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function editInvoiceCandidate($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $candidateId = base64_decode($id);

                $data['candidate'] = DB::Table('invoice_candidates')->where('id', '=', $candidateId)->first();

                //dd($data['candidate']->id);

                $data['organisation'] = DB::Table('registration')
                    ->where('id', '=', $data['candidate']->employer_id)
                //->where('status', '=', 'active')
                // ->where('verify', '=', 'approved')
                // ->where('licence', '=', 'yes')
                    ->first();

                $data['or_rs'] = DB::Table('registration')
                // ->where('status', '=', 'active')
                // ->where('verify', '=', 'approved')
                // ->where('licence', '=', 'yes')
                    ->get();

                $data['or_de'] = array();
                foreach ($data['or_rs'] as $key => $employee) {
                    $data['or_de'][] = (object) array("reg" => $employee->reg, "com_name" => $employee->com_name);

                }

                return view('admin/edit-invoice-candidate', $data);
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function gettaxforbillTypes()
    {
        try {

            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = DB::Table('tax_bill')

                    ->get();

                $this->addAdminLog(4, 'Billing - Tax Master view.');
                return view('admin/taxbill', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddtaxforbillType()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                return view('admin/add-new-taxbill');
            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function savetaxforbillType(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (empty($request->id)) {

                    DB::table('tax_bill')->insert(
                        ['name' => $request->name, 'percent' => $request->percent, 'status' => $request->status,
                            'cr_date' => date('Y-m-d')]
                    );

                    $this->addAdminLog(4, 'Billing- Added new tax named: ' . $request->name);

                    Session::flash('message', 'Information Successfully saved.');

                    return redirect('superadmin/taxforbill');

                } else {

                    DB::table('tax_bill')
                        ->where('id', $request->id)
                        ->update(['name' => $request->name, 'percent' => $request->percent, 'status' => $request->status, 'up_date' => date('Y-m-d')]);

                    $this->addAdminLog(4, 'Billing- Updated tax named: ' . $request->name . ' to percent ' . $request->percent);
                    Session::flash('message', ' Information Successfully Updated.');

                    return redirect('superadmin/taxforbill');
                }

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function gettaxforbillId($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type'] = DB::table('tax_bill')->where('id', base64_decode($id))->first();

                return view('admin/add-new-taxbill', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function oldpaymentrecipt()
    {
        try {

            $lsapayment = DB::table('payment')->where('pay_recipt', '>=', '2021/10/006')->orderBy('id', 'DESC')->get();
            foreach ($lsapayment as $value) {

                $pidhh = str_replace("/", "-", $value->pay_recipt);
                $filename = $pidhh . '.pdf';
                $lsatdeptnmdb = DB::table('billing')->where('in_id', '=', $value->in_id)->orderBy('id', 'DESC')->first();

                $Roledata = DB::table('registration')

                    ->where('reg', '=', $lsatdeptnmdb->emid)
                    ->first();

                $datap = array();
                $datap = ['Roledata' => $Roledata, 'pay_recipt' => $value->pay_recipt, 're_amount' => $value->re_amount, 'des' => $value->des, 'date' => date('d/m/Y', strtotime($value->payment_date)), 'billing' => $lsatdeptnmdb, 'method' => 'Ofline'];

                $pdf = PDF::loadView('myinvoicePDF', $datap);

                $pdf->save(public_path() . '/paypdf/' . $filename);

            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewallcompanybillingsearch()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();
                $data['bill_amout_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(amount)'))
                    ->get();
                $data['bill_sta_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(status)'))
                    ->get();
                $data['orname'] = DB::Table('registration')
                    ->orderBy('com_name', 'asc')
                    ->get();
                return View('admin/billsearch-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedebillingsearch(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')

                        ->whereBetween('date', [$start_date, $end_date])
                        ->select('billing.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])

                        ->where('amount', '=', $request->amount)
                        ->select('billing.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])

                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('billing')

                        ->where('amount', '=', $request->amount)
                        ->select('billing.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('billing')
                        ->select('billing.*')

                        ->orderBy('date', 'desc')
                        ->get();

                }if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('billing')
                        ->whereBetween('date', [$start_date, $end_date])
                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('billing.*')
                        ->orderBy('date', 'desc')
                        ->get();

                }
                $totam = 0;
                $topayre = 0;
                $totdue = 0;

                $data['result'] = '';

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('payment')

                            ->where('in_id', '=', $leave_allocation->in_id)
                            ->select(DB::raw('sum(re_amount) as amount'))
                            ->first();
                        $passreg = DB::Table('registration')

                            ->where('reg', '=', $leave_allocation->emid)

                            ->first();
                        if ($passreg->licence == 'yes') {
                            $ffl = 'Granted';
                        } else {
                            $ffl = 'NOT Granted';
                        }
                        if (!empty($pass->amount)) {

                            $due = $pass->amount;
                        } else {
                            $due = '0';
                        }

                        $totam = $totam + $leave_allocation->amount;
                        $topayre = $topayre + $due;

                        $totdue = $totdue + $leave_allocation->due;
                        $pabillsts = DB::Table('hr_apply')

                            ->where('licence', '=', 'Granted')
                            ->where('emid', '=', $leave_allocation->emid)
                            ->first();
                        if (!empty($pabillsts)) {
                            $ffd = 'Granted';
                        } else {
                            $ffd = 'Not Granted';
                        }
                        if ($request->or_name == '') {

                            $data['result'] .= '<tr>
				                                    <td>' . $f . '</td>
													<td>' . $leave_allocation->in_id . '</td>
														<td>' . $passreg->com_name . '</td>
												<td>' . $leave_allocation->amount . '</td>
                                                            <td>' . $due . '</td>
                                                             <td>' . $leave_allocation->due . '</td>
                                                             <td>' . strtoupper($leave_allocation->status) . '</td>
														<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
														<td>' . $ffd . '</td>
														<td class="drp">


                                                        <div class="dropdown">
                                                        <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal' . $leave_allocation->id . '"><i class="fas fa-eye"></i>&nbsp; View Invoice</a>
                                                        <a class="dropdown-item" href="' . env("BASE_URL") . 'public/billpdf/' . $leave_allocation->dom_pdf . '" target="_blank"><i class="fas fa-download"></i>&nbsp; Download Invoice</a>

                                                        </div>
                                                        </div>





                                                                        </td>



                                                                                </tr>';
                            $f++;
                        } else if ($request->or_name != '' && $request->or_name == $leave_allocation->emid) {
                            $data['result'] .= '<tr>
                                                                    <td>' . $f . '</td>
                                                                                                        <td>' . $leave_allocation->in_id . '</td>
                                                                                                            <td>' . $passreg->com_name . '</td>
                                                                                                    <td>' . $leave_allocation->amount . '</td>
                                                                                                                <td>' . $due . '</td>
                                                                                                                <td>' . $leave_allocation->due . '</td>
                                                                                                                <td>' . strtoupper($leave_allocation->status) . '</td>
                                                                                                            <td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
                                                                                                            <td>' . $ffd . '</td>

                                                                                                        <td class="drp">


                                                    <div class="dropdown">
                                                    <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal' . $leave_allocation->id . '"><i class="fas fa-eye"></i>&nbsp; View Invoice</a>
                                                    <a class="dropdown-item" href="' . env("BASE_URL") . 'public/billpdf/' . $leave_allocation->dom_pdf . '" target="_blank"><i class="fas fa-download"></i>&nbsp; Download Invoice</a>

                                                    </div>
                                                    </div>





                                                                    </td>



                                                                            </tr>';
                            $f++;
                        }
                    }
                }

                $data['amount'] = $request->amount;
                $data['status'] = $request->status;
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;
                $data['bill_amout_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(amount)'))
                    ->get();
                $data['bill_sta_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(status)'))
                    ->get();
                $data['totam'] = $totam;
                $data['topayre'] = $topayre;
                $data['totdue'] = $totdue;

                $data['or_name'] = $request->or_name;
                $data['orname'] = DB::Table('registration')
                    ->orderBy('com_name', 'asc')
                    ->get();
                if (count($leave_allocation_rs) != 0) {
                    $data['billing_search_result'] = $leave_allocation_rs;

                } else {
                    $data['billing_search_result'] = array();
                }
                $this->addAdminLog(4, 'Billing- Bill Search list view.');
                return View('admin/billsearch-list', $data);

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewallcompanypaymentsearch()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_rs'] = DB::Table('users_admin_emp')

                    ->get();
                $data['bill_amout_rs'] = DB::Table('payment')
                    ->select(DB::raw('DISTINCT(amount)'))
                    ->get();
                $data['bill_sta_rs'] = DB::Table('payment')
                    ->select(DB::raw('DISTINCT(status)'))
                    ->get();
                $data['orname'] = DB::Table('registration')
                    ->orderBy('com_name', 'asc')
                    ->get();
                return View('admin/paymentsearch-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveemployeedepaymentsearch(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('payment')

                        ->whereBetween('payment_date', [$start_date, $end_date])
                        ->select('payment.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status == '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('payment')
                        ->whereBetween('payment_date', [$start_date, $end_date])

                        ->where('amount', '=', $request->amount)
                        ->select('payment.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date != '' && $request->end_date != '' && $request->amount == '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('payment')
                        ->whereBetween('payment_date', [$start_date, $end_date])

                        ->where('status', '=', $request->status)
                        ->select('payment.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('payment')

                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('payment.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status != '') {

                    $leave_allocation_rs = DB::table('payment')

                        ->where('status', '=', $request->status)
                        ->select('payment.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount != '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('payment')

                        ->where('amount', '=', $request->amount)
                        ->select('payment.*')
                        ->orderBy('date', 'desc')
                        ->get();

                } else if ($request->start_date == '' && $request->end_date == '' && $request->amount == '' && $request->status == '') {

                    $leave_allocation_rs = DB::table('payment')
                        ->select('payment.*')

                        ->orderBy('date', 'desc')
                        ->get();

                }if ($request->start_date != '' && $request->end_date != '' && $request->amount != '' && $request->status != '') {
                    $start_date = date('Y-m-d', strtotime($request->start_date));
                    $end_date = date('Y-m-d', strtotime($request->end_date));
                    $leave_allocation_rs = DB::table('payment')
                        ->whereBetween('payment_date', [$start_date, $end_date])
                        ->where('amount', '=', $request->amount)
                        ->where('status', '=', $request->status)
                        ->select('payment.*')
                        ->orderBy('date', 'desc')
                        ->get();

                }
                $totam = 0;
                $topayre = 0;
                $totdue = 0;

                $data['result'] = '';

                if ($leave_allocation_rs) {$f = 1;
                    foreach ($leave_allocation_rs as $leave_allocation) {
                        $pass = DB::Table('registration')

                            ->where('reg', '=', $leave_allocation->emid)

                            ->first();
                        $totam = $totam + $leave_allocation->amount;
                        $topayre = $topayre + $leave_allocation->re_amount;

                        $imgpa = '';
                        if ($leave_allocation->pay_recipt_pdf != '') {

                            //$imgpa = '<a href="https://workpermitcloud.co.uk/hrms/public/paypdf/' . $leave_allocation->pay_recipt_pdf . '" data-toggle="tooltip" data-placement="bottom" title="Download" download>
                            $imgpa = '<a target="_blank" href="https://workpermitcloud.co.uk/hrms/download-invoice/' . base64_encode($leave_allocation->id) . '" data-toggle="tooltip" data-placement="bottom" title="Download" download>
<img style="width: 19px;" src="https://workpermitcloud.co.uk/hrms/public/assets/img/download.png"></a>';} else {

                            $imgpa = '';
                        }

                        $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $leave_allocation->in_id . '</td>

												<td>' . $pass->com_name . '</td>
                                                            <td>' . $leave_allocation->des . '</td>
                                                             <td>' . $leave_allocation->amount . '</td>
															 <td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
															 <td>' . $leave_allocation->re_amount . '</td>
															  <td>' . date('d/m/Y', strtotime($leave_allocation->payment_date)) . '</td>
                                                             <td>' . strtoupper($leave_allocation->status) . '</td>

															<td style="text-align: center;">' . $imgpa . '</td>






						</tr>';
                        $f++;

                    }
                }

                $data['amount'] = $request->amount;
                $data['status'] = $request->status;
                $data['start_date'] = $request->start_date;
                $data['end_date'] = $request->end_date;
                $data['bill_amout_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(amount)'))
                    ->get();
                $data['bill_sta_rs'] = DB::Table('billing')
                    ->select(DB::raw('DISTINCT(status)'))
                    ->get();
                $data['totam'] = $totam;
                $data['topayre'] = $topayre;

                $data['or_name'] = $request->or_name;
                $data['orname'] = DB::Table('registration')
                    ->orderBy('com_name', 'asc')
                    ->get();
                if (count($leave_allocation_rs) != 0) {
                    $data['billing_search_result'] = $leave_allocation_rs;

                } else {
                    $data['billing_search_result'] = array();
                }
                $this->addAdminLog(4, 'Billing - Payment Search list view.');
                return View('admin/paymentsearch-list', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function viewcahngepass()
    {
        if (!empty(Session::get('empsu_email'))) {

            $users = DB::table('users')->where('user_type', '=', 'admin')->first();

            return view('admin/change-password', compact('users'));
        } else {
            return redirect('superadmin');
        }
    }

    public function savecahngepass(Request $request)
    {
        if (!empty(Session::get('empsu_email'))) {

            $users = DB::table('users')->where('user_type', '=', 'admin')->first();

            if ($request->old != $users->password) {
                Session::flash('error', 'Old Password Is Incorrect.');
                return redirect('superadmin/change-password');
            } else {
                if ($request->new_p != $request->con) {

                    Session::flash('error', 'New Password and Cormfirm Password Are Not Same');
                    return redirect('superadmin/change-password');

                } else {
                    if ($request->old != $request->new_p) {
                        $dataimgperpa = array(
                            'password' => $request->new_p,
                        );
                        DB::table('users')
                            ->where('user_type', '=', 'admin')
                            ->update($dataimgperpa);

                        Session::forget('users_id');
                        Session::forget('usersu_type');
                        Session::forget('empsu_pass');
                        Session::forget('empsu_email');
                        Session::flash('message', ' Password Changed Successfully.');
                        return redirect('superadmin');
                    } else {
                        Session::flash('error', 'Old Password and New Password Must be  Different');
                        return redirect('superadmin/change-password');
                    }
                }

            }
        } else {
            return redirect('superadmin');
        }

    }

    public function getCompaniesRecruitementAssigned(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', 'recruitment_file_apply.employee_id as caseworker_id', 'recruitment_file_apply.date as assign_date', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_apply.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->whereBetween('recruitment_file_apply.date', [$start_date, $end_date])
                        ->orderBy('recruitment_file_apply.id', 'desc')
                        ->get();
                } else {
                    $data['companies_rs'] = DB::table('registration')
                        ->select('registration.*', 'recruitment_file_apply.employee_id as caseworker_id', 'recruitment_file_apply.date as assign_date', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_apply.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->where('registration.verify', '=', 'approved')
                        ->where('registration.licence', '=', 'yes')
                        ->where('registration.license_type', '=', 'Internal')
                        ->orderBy('recruitment_file_apply.id', 'desc')
                        ->get();
                }

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Recruitment Assigned list view.');

                return view('admin/recruitment_assigned', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCompaniesRecruitementAssignedExport(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                //dd($request->all());
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(3, 'Organisation Assigned For Recruitment  export');
                return Excel::download(new ExcelFileExportOrganisation('recruitment_assigned_org', $start_date, $end_date), 'Organisation Assigned For Recruitment.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementUnbilledList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitment1stbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'first invoice recruitment service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['recruitementfile_unbilled_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->where('recruitment_file_emp.status', '=', 'Hired')
                        ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->whereBetween('recruitment_file_emp.candidate_hired_date', [$start_date, $end_date])
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['recruitementfile_unbilled_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->where('recruitment_file_emp.status', '=', 'Hired')
                        ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['companies_rs'] = DB::table('registration')
                //     ->select('registration.*', 'recruitment_file_apply.employee_id as caseworker_id', 'recruitment_file_apply.date as assign_date', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_apply.employee_id) as caseworker'))
                //     ->join('recruitment_file_apply', 'recruitment_file_apply.emid', '=', 'registration.reg')
                //     ->where('registration.status', '=', 'active')
                //     ->where('registration.verify', '=', 'approved')
                //     ->where('registration.licence', '=', 'yes')
                //     ->where('registration.license_type', '=', 'Internal')
                //     ->orderBy('recruitment_file_apply.id', 'desc')
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Recruitment Unbilled list view.');

                return view('admin/recruitmentfile-unbilled-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementUnbilledListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Recruitment Unbilled list export');
                return Excel::download(new ExcelFileExportOrganisation('recruitment_unbilled', $start_date, $end_date), 'RecruitmentUnbilled.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementRequestedDashB(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitment1stbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'first invoice recruitment service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['recruitementfile_requested_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                    // ->where('recruitment_file_emp.status', '=', 'Hired')
                    // ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['recruitementfile_requested_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                    // ->where('recruitment_file_emp.status', '=', 'Hired')
                    // ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['companies_rs'] = DB::table('registration')
                //     ->select('registration.*', 'recruitment_file_apply.employee_id as caseworker_id', 'recruitment_file_apply.date as assign_date', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_apply.employee_id) as caseworker'))
                //     ->join('recruitment_file_apply', 'recruitment_file_apply.emid', '=', 'registration.reg')
                //     ->where('registration.status', '=', 'active')
                //     ->where('registration.verify', '=', 'approved')
                //     ->where('registration.licence', '=', 'yes')
                //     ->where('registration.license_type', '=', 'Internal')
                //     ->orderBy('recruitment_file_apply.id', 'desc')
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Recruitment Requested list view.');

                return view('admin/recruitmentfile-requested-dashblist', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementRequestedDashBListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Recruitment Requested list export');
                return Excel::download(new ExcelFileExportOrganisation('recruitment_request', $start_date, $end_date), 'RecruitmentRequested.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementHiredDashB(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitment1stbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'first invoice recruitment service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['recruitementfile_hired_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('recruitment_file_emp.status', '=', 'Hired')
                    // ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->whereBetween('recruitment_file_emp.candidate_hired_date', [$start_date, $end_date])
                        ->where('registration.status', '=', 'active')
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['recruitementfile_hired_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('recruitment_file_emp.status', '=', 'Hired')
                        ->where('registration.status', '=', 'active')
                    // ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['recruitementfile_hired_rs'] = DB::Table('recruitment_file_emp')
                // ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                // ->where('recruitment_file_emp.status', '=', 'Hired')
                // ->whereBetween('recruitment_file_emp.candidate_hired_date', [$start_date, $end_date])
                // ->orderBy('recruitment_file_emp.id', 'desc')
                // ->distinct()
                // ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Recruitment Hired list view.');

                return view('admin/recruitmentfile-hired-dashblist', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementHiredDashBListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Recruitment Hired list export');
                return Excel::download(new ExcelFileExportOrganisation('recruitment_hired', $start_date, $end_date), 'RecruitmentHired.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementOngoingDashB(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitment1stbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'first invoice recruitment service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['recruitementfile_requested_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
                    // ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['recruitementfile_requested_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
                    // ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    //->whereIn('recruitment_file_emp.emid', $licensedOrg)
                    //->whereNotIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['companies_rs'] = DB::table('registration')
                //     ->select('registration.*', 'recruitment_file_apply.employee_id as caseworker_id', 'recruitment_file_apply.date as assign_date', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_apply.employee_id) as caseworker'))
                //     ->join('recruitment_file_apply', 'recruitment_file_apply.emid', '=', 'registration.reg')
                //     ->where('registration.status', '=', 'active')
                //     ->where('registration.verify', '=', 'approved')
                //     ->where('registration.licence', '=', 'yes')
                //     ->where('registration.license_type', '=', 'Internal')
                //     ->orderBy('recruitment_file_apply.id', 'desc')
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Recruitment Ongoing list view.');

                return view('admin/recruitmentfile-ongoing-dashblist', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementOngoingDashBListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Recruitment Ongoing list export');
                return Excel::download(new ExcelFileExportOrganisation('recruitment_ongoing', $start_date, $end_date), 'RecruitmentOngoing.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRecruitementBilledList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitment1stbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'first invoice recruitment service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['recruitementfile_billed_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->whereIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->where('recruitment_file_emp.status', '=', 'Hired')
                        ->where('recruitment_file_emp.billed_first_invoice', '=', 'Yes')
                        ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='first invoice recruitment service' and `emid` LIKE  `registration`.`reg`)"), [$start_date, $end_date])
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['recruitementfile_billed_rs'] = DB::Table('recruitment_file_emp')
                        ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                        ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                        ->where('registration.status', '=', 'active')
                        ->whereIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                        ->where('recruitment_file_emp.status', '=', 'Hired')
                        ->where('recruitment_file_emp.billed_first_invoice', '=', 'Yes')
                        ->orderBy('recruitment_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Recruitment Billed list view.');

                return view('admin/recruitmentfile-billed-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getRecruitementBilledListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Recruitment Billed list export');
                return Excel::download(new ExcelFileExportOrganisation('recruitment_billed', $start_date, $end_date), 'RecruitmentBilled.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosUnassignedList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cos_unassigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->whereNull('cos_apply_emp.employee_id')
                        ->whereBetween(DB::raw("(DATE(cos_apply_emp.date))"), [$request->start_date, $request->end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cos_unassigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->whereNull('cos_apply_emp.employee_id')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Request For COS List view.');

                return view('admin/cos-unassigned-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCosUnassignedListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Request For COS List export');
                return Excel::download(new ExcelFileExportOrganisation('cos_unassigned', $start_date, $end_date), 'Request For COS List.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosAssignedList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {
                    $data['cos_assigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->whereNotNull('cos_apply_emp.employee_id')
                        //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cos_assigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->whereNotNull('cos_apply_emp.employee_id')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Assigned list view.');

                return view('admin/cosfile-assigned-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosAssignedListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Assigned list export');
                return Excel::download(new ExcelFileExportOrganisation('cos_assigned', $start_date, $end_date), 'COS Assigned list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosPendingList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cos_pending_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->whereNull('cos_apply_emp.status')
                        ->whereNotNull('cos_apply_emp.employee_id')
                        //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cos_pending_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->whereNull('cos_apply_emp.status')
                        ->whereNotNull('cos_apply_emp.employee_id')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['cos_pending_rs'] = DB::Table('cos_apply_emp')
                //     ->whereNull('cos_apply_emp.status')
                //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                //     ->whereNotNull('cos_apply_emp.employee_id')
                //     ->where('cos_apply_emp.addn_cos', '=', 'No')
                //     ->orderBy('cos_apply_emp.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Pending list view.');

                return view('admin/cosfile-pending-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCosPendingListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Pending list export');
                return Excel::download(new ExcelFileExportOrganisation('cos_pending', $start_date, $end_date), 'COS Pending list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosGrantedList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cos_granted_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where(function ($query) {

                            $query->whereNull('cos_apply_emp.cos_assigned')
                                ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                        })
                        ->whereNotNull('cos_apply_emp.employee_id')
                        //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cos_granted_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where(function ($query) {

                            $query->whereNull('cos_apply_emp.cos_assigned')
                                ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                        })
                        ->whereNotNull('cos_apply_emp.employee_id')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['cos_granted_rs'] = DB::Table('cos_apply_emp')
                //     ->where('cos_apply_emp.status', '=', 'Granted')
                //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                //     ->where('cos_apply_emp.addn_cos', '=', 'No')
                //     ->orderBy('cos_apply_emp.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Granted list view.');

                return view('admin/cosfile-granted-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosGrantedListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Granted list export');
                return Excel::download(new ExcelFileExportOrganisation('cos_granted', $start_date, $end_date), 'COS Granted list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosUnsignedList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cos_granted_unassigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where(function ($query) {

                            $query->whereNull('cos_apply_emp.cos_assigned')
                                ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                        })
                        //->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(DATE(cos_apply_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cos_granted_unassigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where(function ($query) {

                            $query->whereNull('cos_apply_emp.cos_assigned')
                                ->orWhere('cos_apply_emp.cos_assigned', '=', 'No');
                        })
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['cos_granted_rs'] = DB::Table('cos_apply_emp')
                //     ->where('cos_apply_emp.status', '=', 'Granted')
                //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                //     ->where('cos_apply_emp.addn_cos', '=', 'No')
                //     ->orderBy('cos_apply_emp.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Granted Unassigned list view.');

                return view('admin/cosfile-unassigedcos-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosUnsignedListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Not Assigned list export');
                return Excel::download(new ExcelFileExportOrganisation('cos_not_assigned', $start_date, $end_date), 'COS Unassigned list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosSignedList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cos_granted_assigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                        ->whereBetween('cos_apply_emp.cos_assigned_date', [$start_date, $end_date])
                    //->whereNotNull('cos_apply_emp.employee_id')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cos_granted_assigned_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.employee_id')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['cos_granted_rs'] = DB::Table('cos_apply_emp')
                //     ->where('cos_apply_emp.status', '=', 'Granted')
                //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                //     ->where('cos_apply_emp.addn_cos', '=', 'No')
                //     ->orderBy('cos_apply_emp.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Granted Assigned list view.');

                return view('admin/cosfile-assigedcos-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosSignedListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Assigned list export');
                return Excel::download(new ExcelFileExportOrganisation('cos_granted_assigned', $start_date, $end_date), 'COS Assigned list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosRejectedList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cos_rejected_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Rejected')
                        ->whereNotNull('cos_apply_emp.employee_id')
                        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cos_rejected_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.status', '=', 'Rejected')
                        ->whereNotNull('cos_apply_emp.employee_id')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['cos_rejected_rs'] = DB::Table('cos_apply_emp')
                //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                //     ->where('cos_apply_emp.status', '=', 'Rejected')
                //     ->where('cos_apply_emp.addn_cos', '=', 'No')
                //     ->orderBy('cos_apply_emp.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Rejected list view.');

                return view('admin/cosfile-rejected-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosRejectedListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Rejected list export');
                return Excel::download(new ExcelFileExportOrganisation('cos_rejected', $start_date, $end_date), 'COS Rejected list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosUnbilledList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $recruitment2ndbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'second invoice visa service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cosfile_unbilled_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    //->whereNotIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                        ->where('cos_apply_emp.billed_second_invoice', '=', 'No')
                        ->whereBetween('cos_apply_emp.cos_assigned_date', [$start_date, $end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cosfile_unbilled_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    //->whereNotIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                        ->where('cos_apply_emp.billed_second_invoice', '=', 'No')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['cosfile_unbilled_rs'] = DB::Table('cos_apply_emp')
                //     ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'))
                //     ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                //     ->where('cos_apply_emp.addn_cos', '=', 'No')
                //     ->where('cos_apply_emp.status', '=', 'Rejected')
                //     ->whereNotNull('cos_apply_emp.employee_id')
                //     ->orderBy('cos_apply_emp.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Unbilled list view.');

                return view('admin/cosfile-unbilled-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCosUnbilledListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Unbilled list export');
                return Excel::download(new ExcelFileExportOrganisation('cosfile_unbilled', $start_date, $end_date), 'COS Unbilled list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getCosBilledList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosInactiveId = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Inactive')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    //->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.id');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                //->whereNotNull('cos_apply_emp.cos_assigned_date')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $recruitment2ndbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'second invoice visa service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['cosfile_billed_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                        ->whereIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                        ->where('cos_apply_emp.billed_second_invoice', '=', 'Yes')
                        ->whereBetween('cos_apply_emp.cos_assigned_date', [$start_date, $end_date])
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['cosfile_billed_rs'] = DB::Table('cos_apply_emp')
                        ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                        ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                        ->whereIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                        ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                        ->where('cos_apply_emp.status', '=', 'Granted')
                        ->where('cos_apply_emp.addn_cos', '=', 'No')
                        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                        ->where('cos_apply_emp.billed_second_invoice', '=', 'Yes')
                        ->orderBy('cos_apply_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['cosfile_unbilled_rs'] = DB::Table('cos_apply_emp')
                //     ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'))
                //     ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                //     ->where('cos_apply_emp.addn_cos', '=', 'No')
                //     ->where('cos_apply_emp.status', '=', 'Rejected')
                //     ->whereNotNull('cos_apply_emp.employee_id')
                //     ->orderBy('cos_apply_emp.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - COS Billed list view.');

                return view('admin/cosfile-billed-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getCosBilledListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - COS Billed list export');
                return Excel::download(new ExcelFileExportOrganisation('cosfile_billed', $start_date, $end_date), 'COS Billed list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getUnassignedVisaList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['visafile_unassigned_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNull('visa_file_emp.employee_id')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->whereBetween('visa_file_emp.date', [$start_date, $end_date])
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['visafile_unassigned_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNull('visa_file_emp.employee_id')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa Unassigned list view.');

                return view('admin/unassigned-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getUnassignedVisaListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Visa Unassigned list export');
                return Excel::download(new ExcelFileExportOrganisation('visafile_request', $start_date, $end_date), 'Visa Unassigned list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getAssignedVisaList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['visafile_assigned_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNotNull('visa_file_emp.employee_id')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->whereNull('visa_file_emp.status')
                            ->where(function ($query) {

                                $query->whereNull('visa_file_emp.visa_application_submitted')
                                    ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                            })
                        //->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
                        ->whereBetween(DB::raw("(DATE(visa_file_emp.update_new_ct))"), [$request->start_date, $request->end_date])
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['visafile_assigned_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNotNull('visa_file_emp.employee_id')
                        ->whereNull('visa_file_emp.status')
                            ->where(function ($query) {

                                $query->whereNull('visa_file_emp.visa_application_submitted')
                                    ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                            })
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['visafile_assigned_rs'] = DB::Table('visa_file_emp')
                //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                //     ->whereNotNull('visa_file_emp.employee_id')
                //     ->where('visa_file_emp.addn_visa', '=', 'No')
                //     ->orderBy('visa_file_apply.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa WIP list view.');

                return view('admin/assigned-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getAssignedVisaListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Visa File WIP List export');
                return Excel::download(new ExcelFileExportOrganisation('visafile_requested', $start_date, $end_date), 'Visa File WIP List.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getGrantedVisaList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['visafile_granted_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->where('visa_file_emp.status', '=', 'Granted')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->whereBetween('visa_file_emp.visa_granted_date', [$start_date, $end_date])
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['visafile_granted_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->where('visa_file_emp.status', '=', 'Granted')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['visafile_granted_rs'] = DB::Table('visa_file_emp')
                //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                //     ->where('visa_file_emp.status', '=', 'Granted')
                //     ->where('visa_file_emp.addn_visa', '=', 'No')
                //     ->orderBy('visa_file_apply.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa Granted list view.');

                return view('admin/granted-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getGrantedVisaListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Visa Granted list export');
                return Excel::download(new ExcelFileExportOrganisation('visafile_granted', $start_date, $end_date), 'Visa Granted list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPendingVisaList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['visafile_pending_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNull('visa_file_emp.status')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->where(function ($query) {

                            $query->whereNull('visa_file_emp.visa_application_submitted')
                                ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                        })
                        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['visafile_pending_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNull('visa_file_emp.status')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->where(function ($query) {

                            $query->whereNull('visa_file_emp.visa_application_submitted')
                                ->orWhere('visa_file_emp.visa_application_submitted', '=', 'No');
                        })
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['visafile_granted_rs'] = DB::Table('visa_file_emp')
                //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                //     ->where('visa_file_emp.status', '=', 'Granted')
                //     ->where('visa_file_emp.addn_visa', '=', 'No')
                //     ->orderBy('visa_file_apply.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa Pending list view.');

                return view('admin/pending-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getSubmittedVisaList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['visafile_submitted_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNull('visa_file_emp.status')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->where('visa_file_emp.visa_application_submitted', '=', 'Yes')

                        ->whereBetween('visa_file_emp.visa_application_submit_date', [$start_date, $end_date])
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['visafile_submitted_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->whereNull('visa_file_emp.status')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->where('visa_file_emp.visa_application_submitted', '=', 'Yes')
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['visafile_granted_rs'] = DB::Table('visa_file_emp')
                //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                //     ->where('visa_file_emp.status', '=', 'Granted')
                //     ->where('visa_file_emp.addn_visa', '=', 'No')
                //     ->orderBy('visa_file_apply.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa Submitted list view.');

                return view('admin/submitted-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getPendingVisaListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Visa Pending list export');
                return Excel::download(new ExcelFileExportOrganisation('visafile_pending', $start_date, $end_date), 'Visa Pending list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getSubmittedVisaListExport(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date;
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date;
                }
                $this->addAdminLog(1, 'Dashboard - Visa Submitted list export');
                return Excel::download(new ExcelFileExportOrganisation('visafile_submitted', $start_date, $end_date), 'Visa Submitted list.xlsx');

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getRejectedVisaList(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;
                if ($start_date != '' && $end_date != '') {
                    $data['visafile_rejected_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->where('visa_file_emp.status', '=', 'Rejected')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                } else {
                    $data['visafile_rejected_rs'] = DB::Table('visa_file_emp')
                        ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                        ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                        ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                        ->where('visa_file_emp.status', '=', 'Rejected')
                        ->where('visa_file_emp.addn_visa', '=', 'No')
                        ->orderBy('visa_file_emp.id', 'desc')
                        ->distinct()
                        ->get();
                }

                // $data['visafile_rejected_rs'] = DB::Table('visa_file_emp')
                //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                //     ->where('visa_file_emp.status', '=', 'Rejected')
                //     ->where('visa_file_emp.addn_visa', '=', 'No')
                //     ->orderBy('visa_file_apply.id', 'desc')
                //     ->distinct()
                //     ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa Rejected list view.');

                return view('admin/rejected-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getUnbilledVisaList()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $recruitment2ndbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'second invoice visa service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                // $data['visafile_unbilled_rs'] = DB::Table('visa_file_emp')
                //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                //     ->whereNotIn('visa_file_emp.emid', $recruitment2ndbillOrg)
                //     ->where('visa_file_emp.status', '=', 'Granted')
                //     ->where('visa_file_emp.addn_visa', '=', 'No')
                //     ->orderBy('visa_file_apply.id', 'desc')
                //     ->distinct()
                //     ->get();

                $data['visafile_unbilled_rs'] = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereNotIn('visa_file_emp.emid', $recruitment2ndbillOrg)
                    ->where('visa_file_emp.status', '=', 'Granted')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa Unbilled list view.');

                return view('admin/unbilled-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getBilledVisaList()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

                $recruitment2ndbillOrg = DB::Table('billing')
                    ->where('bill_for', '=', 'second invoice visa service')
                    ->where('status', '<>', 'cancel')
                    ->pluck('billing.emid');

                // $data['visafile_unbilled_rs'] = DB::Table('visa_file_emp')
                //     ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                //     ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                //     ->whereNotIn('visa_file_emp.emid', $recruitment2ndbillOrg)
                //     ->where('visa_file_emp.status', '=', 'Granted')
                //     ->where('visa_file_emp.addn_visa', '=', 'No')
                //     ->orderBy('visa_file_apply.id', 'desc')
                //     ->distinct()
                //     ->get();

                $data['visafile_billed_rs'] = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereIn('visa_file_emp.emid', $recruitment2ndbillOrg)
                    ->where('visa_file_emp.status', '=', 'Granted')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

                //dd($data);

                $this->addAdminLog(1, 'Dashboard - Visa Billed list view.');

                return view('admin/billed-visafile-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }


    //Revised mock interview
    public function getQuestionCategories()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('17', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = QuestionCategory::get();

                $this->addAdminLog(17, 'list viewed.');

                //dd($data);
                return view('admin/question-category', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addQuestionCategory()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('17', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                return view('admin/add-new-question-category');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveQuestionCategory(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (empty($request->id)) {
                    $model  = new QuestionCategory;
                    $model->category_name    = $request->category_name;
                    $model->save();

                    Session::flash('message', 'Industry Information Successfully saved.');

                    $this->addAdminLog(17, 'New industry saved with name: ' . $request->category_name);

                    return redirect('superadmin/industries');

                } else {

                    $model = QuestionCategory::find($request->id);
                    if(!$model){
                        throw new Exception("No result was found for id: $request->id");
                    }

                    $model->category_name    = $request->category_name;
                    $model->save();

                    Session::flash('message', 'Industry Information Successfully Updated.');

                    $this->addAdminLog(17, 'Industry modified with name: ' . $request->category_name);

                    return redirect('superadmin/industries');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function getQuestionCategoryById($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('17', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type'] = QuestionCategory::where('id', base64_decode($id))->first();

                return view('admin/add-new-question-category', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function deleteQuestionCategory($id)
    {
        try {
            $model = QuestionCategory::find($id);
            if(!$model){
                throw new Exception("No result was found for id: $id");
            }
            $model->delete();

            Session::flash('message', 'Record Deleted Successfully.');
            return redirect('superadmin/industries');
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getQuestions()
    {
        try {

            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('17', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['employee_type_rs'] = Question::get();

                $this->addAdminLog(17, 'list viewed.');

                //dd($data);
                return view('admin/questions', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addQuestion()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('17', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['categories'] = QuestionCategory::orderBy('category_name', 'asc')->get();

                return view('admin/add-new-question',$data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function saveQuestion(Request $request)
    {
        try {

            $email = Session::get('empsu_email');
            if (!empty($email)) {

                if (empty($request->id)) {
                    $model  = new Question;
                    $model->category_id    = $request->category_id;
                    $model->question    = $request->question;
                    $model->save();

                    Session::flash('message', 'Question Information Successfully saved.');

                    $this->addAdminLog(17, 'New question saved with name: ' . $request->category_name);

                    return redirect('superadmin/questions');

                } else {

                    $model = Question::find($request->id);
                    if(!$model){
                        throw new Exception("No result was found for id: $request->id");
                    }

                    $model->category_id    = $request->category_id;
                    $model->question    = $request->question;
                    $model->save();

                    Session::flash('message', 'Question Information Successfully Updated.');

                    $this->addAdminLog(17, 'Question modified with name: ' . $request->category_name);

                    return redirect('superadmin/questions');
                }

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function getQuestionById($id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('17', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $data['categories'] = QuestionCategory::orderBy('category_name', 'asc')->get();
                $data['employee_type'] = Question::where('id', base64_decode($id))->first();

                return view('admin/add-new-question', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function deleteQuestion($id)
    {
        try {
            $model = Question::find($id);
            if(!$model){
                throw new Exception("No result was found for id: $id");
            }
            $model->delete();

            Session::flash('message', 'Record Deleted Successfully.');
            return redirect('superadmin/questions');
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function subadmin(){
        //dd('okk');

        return view('subadmin/subadmindashboard');
    }
        public function activeSubadmin(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

             //dd($userType);

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                if($userType=='sub-admin'){
                    //$email =  $data[0]->org_code;
                    $org_code = Session::get('org_code');
                    //dd($org_code);
                } else {
                    $org_code ='';
                }
                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                    // dd($start_date);
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {

                    $data['companies_rs'] = DB::table('sub_admin_registrations')
                        ->where('status', '=', 'active')
                    // ->where('verify', '=', 'not approved')
                    // ->where('licence', '=', 'no')
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->orWhereNull('org_code')
                        ->orderBy('id', 'desc')
                        ->get();
                    // dd($data['companies_rs']);
                } else {
                    $data['companies_rs'] = DB::table('sub_admin_registrations')
                        ->where('status', '=', 'active')
                    // ->where('verify', '=', 'not approved')
                        // ->where(function($query) use ($org_code) {
                        //     if ($org_code !== '') {
                        //         $query->where('org_code', $org_code);
                        //     } else {
                        //         $query->where('org_code', '')
                        //             ->orWhereNull('org_code');
                        //     }
                        // })
                        ->orWhereNull('org_code')
                        ->orderBy('id', 'desc')
                        ->get();
                        // dd($data['companies_rs']);
                }

                $this->addAdminLog(3, 'Organisation - Active Organisation list view.');

                return view('admin/activesubadmin', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewSubOrganization($comp_id){

        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            //$org_code = Session::get('org_code');
            //dd('non verefy');
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['companies_rs'] = DB::table('registration')
                                        ->Where('org_code',$comp_id)
                                        ->orderBy('id', 'desc')
                                        ->get();
                $data['sub_admin'] = DB::table('sub_admin_registrations')
                                        ->Where('org_code',$comp_id)
                                        ->first();



                return view('admin/subOrganization', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

     public function nonVerfySubadmin()
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            //$org_code = Session::get('org_code');
            //dd('non verefy');
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                // if($userType=='sub-admin'){
                //     $org_code = Session::get('org_code');
                // } else {
                //     $org_code ='';
                // }
                $data['companies_rs'] = DB::table('sub_admin_registrations')
                ->where('status', '=', 'active')
                ->where('verify', '=', 'not approved')
                ->where('licence', '=', 'no')
                ->orWhereNull('org_code')
                ->orderBy('id', 'desc')
                ->get();

                $this->addAdminLog(3, 'Organisation - Not Verified Organisation list view.');



                return view('admin/nonVerifySubadmin', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function VerfySubadmin()
    {
       try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            $org_code = Session::get('org_code');
        //dd('subadmin verify');
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $start_date = '';
                if (isset($request->start_date)) {
                    $start_date = $request->start_date . ' 00:00:00';
                }

                $end_date = '';
                if (isset($request->end_date)) {
                    $end_date = $request->end_date . ' 23:59:59';
                }

                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                if ($start_date != '' && $end_date != '') {

                    $data['companies_rs'] = DB::table('sub_admin_registrations')
                        ->select('sub_admin_registrations.*', DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `sub_admin_registrations`.`reg`) as caseworker"), DB::raw("(select remark_su from tareq_app where tareq_app.`emid` LIKE  `sub_admin_registrations`.`reg`) as assignment_remarks"), DB::raw("(select assign_date from tareq_app where tareq_app.`emid` LIKE  `sub_admin_registrations`.`reg`) as assignment_date"))
                        ->where('sub_admin_registrations.status', '=', 'active')
                        ->where('sub_admin_registrations.verify', '=', 'approved')
                        ->where('sub_admin_registrations.licence', '=', 'no')
                        ->whereBetween(DB::raw("(DATE(sub_admin_registrations.verified_on))"), [$request->start_date, $request->end_date])
                        ->orWhereNull('org_code')
                        ->orderBy('sub_admin_registrations.id', 'desc')
                        ->get();

                } else {
                    //dd('opp');
                    $data['companies_rs'] = DB::table('sub_admin_registrations')
                        ->select('sub_admin_registrations.*', DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `sub_admin_registrations`.`reg`) as caseworker"), DB::raw("(select remark_su from tareq_app where tareq_app.`emid` LIKE  `sub_admin_registrations`.`reg`) as assignment_remarks"), DB::raw("(select assign_date from tareq_app where tareq_app.`emid` LIKE  `sub_admin_registrations`.`reg`) as assignment_date"))
                        ->where('sub_admin_registrations.status', '=', 'active')
                        ->where('sub_admin_registrations.verify', '=', 'approved')
                        ->where('sub_admin_registrations.licence', '=', 'no')
                        ->orWhereNull('org_code')
                        ->orderBy('id', 'desc')
                        ->get();
                }

                $this->addAdminLog(3, 'Organisation - Verified Organisation list view.');
        //dd($data);
                return view('admin/verify-sub-admin', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    // public function link($id){
    //     $data = DB::table('sub_admin_registrations')->where('email','=',$id)->where('status','=','active')->get();
    //     $email =  $data[0]->org_code;
    //     Session::put('users_id', $email);
    //     return view('subadmin/link');
    // }
     public function viewSubAddCompany($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('3', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                $data['Roledata'] = DB::table('sub_admin_registrations')

                    ->where('id', '=', $comp_id)
                    ->first();
                $data['cuurenci_master'] = DB::table('currencies')->get();
                $data['nat_or_master'] = DB::table('nat_or')->get();
                $data['type_or_master'] = DB::table('type_or')->get();
                $data['employee_upload_rs'] = DB::table('company_upload')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                $data['employee_or_rs'] = DB::table('company_employee')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();

                $this->addAdminLog(3, 'Organisation - Edit form opened for company code: ' . $data['Roledata']->reg);
                return View('admin/edit-sub-company', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

     public function saveSubCompany(Request $request)
    {

        try {
            $email = Session::get('empsu_email');
            $randomOrgCode = $this->generateKey();
            if (!empty($email)) {

                $email = Session::get('empsu_email');

                if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'no') {

                    $data = array(
                        'status' => $request->status,
                        'verify' => $request->verify,
                        'org_code'=>$randomOrgCode,
                        'employee_link' => env("BASE_URL") . 'new-employee/' . base64_encode($request->reg),

                    );

                    DB::table('sub_admin_registrations')->where('reg', $request->reg)->update($data);
                }
                if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'yes') {
                    //dd($request->all());
                    $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email, 'pass' => $request->pass);
                    $toemail = $request->email;
                    Mail::send('mailorupli', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ('Make your HR file ready');
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });
                    $data = array(
                        'status' => $request->status,
                        'verify' => $request->verify,
                        'licence' => $request->licence,
                        'license_type' => $request->license_type,

                    );
                    DB::table('sub_admin_registrations')->where('reg', $request->reg)->update($data);
                } else {

                    $data = array(
                        'status' => $request->status,
                        'verify' => $request->verify,
                        'licence' => $request->licence,
                        'license_type' => $request->license_type,
                    );

                    DB::table('sub_admin_registrations')->where('reg', $request->reg)->update($data);
                }

                $datau = array(
                    'status' => $request->status,

                );

                DB::table('users')->where('employee_id', $request->reg)->update($datau);

                $exits = DB::table('users')->where('employee_id', $request->reg)->first();

                if ($request->status == 'inactive') {

                    $datau = array(
                        'email' => $exits->email . 'inactive',

                    );

                    DB::table('users')->where('employee_id', $request->reg)->update($datau);

                    $datau = array(
                        'email' => $exits->email . 'inactive',
                        'inactive_remarks' => $request->inactive_remarks,

                    );

                    DB::table('sub_admin_registrations')->where('reg', $request->reg)->update($datau);

                }

                $this->addAdminLog(3, 'Organisation - Updated data for company code: ' . $request->reg);
                // $exits2 = DB::table('sub_admin_registrations')->where('reg', $request->reg)->first();
                // $name = $exits2->f_name.' '.$exits2->l_name;
                //dd($name);
                $toemail=$request->email;
                // $toemail='boton.cob2@gmail.com';
                if ($toemail != '') {
                $data = ["name" =>$exits->name, "email" =>$exits->email, "password" =>$exits->password];
                //dd($data);
                // $data = ["name" => $name, "email" => $exits2->email,"password" =>$exits2->pass];
                    Mail::send('org-approved', $data, function ($message) use ($toemail) {
                        $message->to($toemail, 'skilledworkerscloud')->subject
                            ('Partner Organisation Approved');
                        $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
                    });
                }
                //dd('77');
                Session::flash('message', 'Partner Organisation Information Successfully Updated.');

                if ($request->status == 'active' && $request->verify == 'not approved' && $request->licence == 'no') {
                    return redirect('subadmin/active');
                } else if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'no') {
                    return redirect('subadmin/verify');
                } else if ($request->status == 'inactive' && $request->verify == 'not approved' && $request->licence == 'no') {
                    //return redirect('superadmin/inactive');
                    return redirect('superadmindasboard');
                } else if ($request->status == 'inactive' && $request->verify == 'approved' && $request->licence == 'no') {
                     //return redirect('superadmin/inactive');
                    return redirect('superadmindasboard');
                } else if ($request->status == 'inactive' && $request->verify == 'approved' && $request->licence == 'yes') {
                     //return redirect('superadmin/inactive');
                     return redirect('superadmindasboard');
                } else if ($request->status == 'inactive' && $request->verify == 'not approved' && $request->licence == 'yes') {
                     //return redirect('superadmin/inactive');
                     return redirect('superadmindasboard');
                } else if ($request->status == 'active' && $request->verify == 'approved' && $request->licence == 'yes') {
                    return redirect('superadmin/license-applied');
                }

            } else {
                return redirect('superadmin');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function generateKey() {
        $alphabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';
        // Generate two random alphabetic characters
        $prefix = 'P' . $alphabets[rand(0, strlen($alphabets) - 1)];
        // Generate three random digits
        $suffix = '';
        for ($i = 0; $i < 3; $i++) {
            $suffix .= $digits[rand(0, strlen($digits) - 1)];
        }

        return $prefix . $suffix;
    }

    public function viewSubBillng()
    {
       //dd('okkk');
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');
            $org_code = Session::get('org_code');
            // $userType = Session::get('user_type');
            //dd($userType);
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                // if($userType == 'sub-admin'){
                    $data['bill_rs'] = DB::table('billing')
                    ->join('sub_admin_registrations', 'billing.emid', '=', 'sub_admin_registrations.reg')
                    ->where('billing.status', '=', 'not paid')
                    ->where('sub_admin_registrations.org_code', '=', $org_code)
                    ->groupBy('billing.in_id')
                    ->orderBy('billing.in_id', 'desc')
                    ->select('billing.*', 'sub_admin_registrations.*') // Adjust the selected columns as needed
                    ->get();
                // } else {
                // $data['bill_rs'] = DB::Table('billing')
                //     ->where('status', '=', 'not paid')
                //     ->groupBy('in_id')
                //     ->orderBy('in_id', 'desc')
                //     ->get();
                // }
                //dd($data['bill_rs']);

                return View('admin/sub-billing-list', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addsubbillng()
    {
        //dd('77');
        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                //All Bills
                $data['bill_rs'] = DB::Table('billing')->get();

                //organisation details
                $data['or_de'] = DB::Table('sub_admin_registrations')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    //->where('licence', '=', 'yes')
                    ->get();

                // $data['candidate_rs'] = DB::Table('invoice_candidates')
                //     ->where('status', '=', 'A')
                //     ->get();

                //hired candidate list
                $data['candidate_rs'] = DB::Table('candidate')
                    ->where('status', '=', 'Hired')
                    ->get();

                //dd($data['or_de']);

                $userlist = array();
                foreach ($data['bill_rs'] as $user) {
                    $userlist[] = $user->emid;
                }

                $data['package_rs'] = DB::Table('package')
                    ->where('status', '=', 'active')
                    ->get();

                $data['tax_rs'] = DB::Table('tax_bill')
                    ->where('status', '=', 'active')
                    ->get();
                //dd($data);
                return View('admin/billing-add-sub-new', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function findOrg($empid){
         $Roledata = DB::table('sub_admin_registrations')
            ->where('com_name', '=', $empid)
            ->where('status', '=', 'active')
            ->first();
        echo json_encode(array($Roledata));
    }


    public function savesubbillng(Request $request)
    {
        try {
        //dd($request->all());
        //dd($request->emid);
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                 //dd($request->all());

                $recruitmentFirstBillValid = false;
                $recruitmentSecondBillValid = false;

                if ($request->bill_for == 'first invoice recruitment service') {
                    if ($request->billing_type == 'Organisation') {
                        if ($request->rec_candidate_name == '') {
                            Session::flash('error', 'Please select candidate for recruitment first invoice.');
                            return redirect('superadmin/add-billing');
                        } else {
                            $recruitmentFirstBillValid = true;
                        }

                    } else {
                        Session::flash('error', 'Bill Type should be Organisation for recruitment first invoice.');
                        return redirect('superadmin/add-billing');
                    }
                }

                if ($request->bill_for == 'second invoice visa service') {
                    if ($request->billing_type == 'Organisation') {
                        if ($request->rec_candidate_name == '') {
                            Session::flash('error', 'Please select candidate for recruitment second invoice.');
                            return redirect('superadmin/add-billing');
                        } else {
                            $recruitmentSecondBillValid = true;
                        }

                    } else {
                        Session::flash('error', 'Bill Type should be Organisation for recruitment second invoice.');
                        return redirect('superadmin/add-billing');
                    }
                }

                $allValidDiscountVals = true;
                //validate all discount value to be proper
                if ($request->package && count($request->package) != 0) {
                    for ($i = 0; $i < count($request->package); $i++) {

                        if ($request->discount_type[$i] == 'P') {

                            if (((float) $request->discount[$i]) > 100 || ((float) $request->discount[$i]) < 0) {
                                $allValidDiscountVals = false;
                            }
                        }
                        if ($request->discount_type[$i] == 'A') {

                            if (((float) $request->discount[$i]) > ((float) $request->anount_ex_vat[$i]) || ((float) $request->discount[$i]) < 0) {
                                $allValidDiscountVals = false;
                            }
                        }

                    }
                }
                if ($allValidDiscountVals == false) {
                    Session::flash('error', 'Discount is not in proper format.');
                    return redirect('billing/add-sub-billing');
                }

                $ckeck_email = DB::Table('registration')

                    ->where('reg', '=', $request->emid)
                    ->first();

                if (empty($ckeck_email)) {
                    Session::flash('error', 'Organisation name is not in proper format.');
                    return redirect('billing/add-sub-billing');
                } else {

                    $lsatdeptnmdb = DB::table('billing')->whereYear('date', '=', date('Y'))->whereMonth('date', '=', date('m'))
                        ->groupBy('in_id')->orderBy('in_id', 'DESC')->first();

                    if (empty($lsatdeptnmdb)) {
                        $pid = date('Y') . '/' . date('m') . '/001';
                    } else {
                        $str = str_replace(date('Y') . '/' . date('m') . '/', "", $lsatdeptnmdb->in_id);
                        if ($str <= 8) {
                            $pid = date('Y') . '/' . date('m') . '/00' . ($str + 1);
                        } else if ($str < 99) {
                            $pid = date('Y') . '/' . date('m') . '/0' . ($str + 1);
                        } else {
                            $pid = date('Y') . '/' . date('m') . '/' . ($str + 1);
                        }

                    }
                    $lsatdeptnmdbexit = DB::table('billing')->where('in_id', '=', $pid)->orderBy('in_id', 'DESC')->first();

                    if ($recruitmentFirstBillValid == false && $recruitmentSecondBillValid == false) {
                        $request->bill_to = $request->billing_type;
                    }

                    if (!empty($lsatdeptnmdbexit)) {
                        Session::flash('error', 'Invoice Number already Exits. ');
                        return redirect('superadmin/add-billing');
                    } else {
                        $rec_candidate_info = array();
                        if ($recruitmentFirstBillValid) {
                            // $dummyDes = $request->des;
                            // for ($j = 0; $j < count($request->des); $j++) {
                            //     $dummyDes[$j] = $request->des[$j] . ' (Candidate : ' . $request->rec_candidate_name . ')';
                            //     //$request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';

                            // }
                            // $request->des = $dummyDes;
                            $rec_candidate_info = DB::table('recruitment_file_emp')
                                ->where('emid', $request->emid)
                                ->where('employee_name', $request->rec_candidate_name)
                                ->first();

                            $request->canidate_name = $rec_candidate_info->employee_name;
                            $request->canidate_email = $rec_candidate_info->employee_email;
                            $request->candidate_id = '0';
                            $request->candidate_address = $rec_candidate_info->employee_address;
                            //$request->bill_to = $request->rec_can_billto;
                        }
                        if ($recruitmentSecondBillValid) {
                            // $dummyDes = $request->des;
                            // for ($j = 0; $j < count($request->des); $j++) {
                            //     $dummyDes[$j] = $request->des[$j] . ' (Candidate : ' . $request->rec_candidate_name . ')';
                            //     //$request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';

                            // }
                            // $request->des = $dummyDes;
                            $rec_candidate_info = DB::table('recruitment_file_emp')
                                ->where('emid', $request->emid)
                                ->where('employee_name', $request->rec_candidate_name)
                                ->first();
                            $request->canidate_name = $rec_candidate_info->employee_name;
                            $request->canidate_email = $rec_candidate_info->employee_email;
                            $request->candidate_id = '0';
                            $request->candidate_address = $rec_candidate_info->employee_address;
                            //$request->bill_to = $request->rec_can_billto;
                            //                            $request->des = $request->des . ' (Candidate : ' . $request->rec_candidate_name . ')';
                        }
                        // dd('road block');
                        $pidhh = str_replace("/", "-", $pid);
                        $filename = $pidhh . '.pdf';
                        $Roledata = DB::Table('registration')
                            ->where('reg', '=', $request->emid)
                            ->first();

                        $datap = [
                            'Roledata' => $Roledata,
                            'in_id' => $pid,
                            'des' => $request->des,
                            'date' => date('Y-m-d'),
                            'package' => $request->package,
                            'net_amount' => $request->net_amount,
                            'discount_type' => $request->discount_type,
                            'discount' => $request->discount,
                            'discount_amount' => $request->discount_amount,
                            'anount_ex_vat' => $request->anount_ex_vat,
                            'vat' => $request->vat,
                            'amount_after_vat' => $request->amount_after_vat,
                            'billing_type' => $request->billing_type,
                            'canidate_name' => $request->canidate_name,
                            'candidate_id' => $request->candidate_id,
                            'candidate_address' => $request->candidate_address,
                            'bill_for' => $request->bill_for,
                            'bill_to' => $request->bill_to,
                            'rec_candidate_info' => $rec_candidate_info,
                        ];

                        // dd($datap);

                        $pdf = PDF::loadView('mybillPDFNew', $datap);
                        // dd(public_path());
                        $pdf->save(public_path() . '/billpdf/' . $filename);
                        // dd("hello");
                        // echo $pid;
                        // dd($datap);
                        // dd($request->all());
                        $totamount = 0;
                        if ($request->package && count($request->package) != 0) {
                            for ($i = 0; $i < count($request->package); $i++) {

                                $totamount = $totamount + $request->net_amount[$i];

                            }
                        }

                        if ($request->package && count($request->package) != 0) {
                            for ($i = 0; $i < count($request->package); $i++) {

                                $discount = $request->discount[$i];
                                $discount_p = 0;
                                if ($request->discount_type[$i] == 'P') {

                                    $discount = 0;
                                    $discount_p = $request->discount[$i];

                                    $discount = round(((((float) $request->anount_ex_vat[$i]) * ((float) $discount_p)) / 100), 2);
                                }

                                $data = array(

                                    'in_id' => $pid,
                                    'emid' => $request->emid,
                                    'pay_mode' => $request->pay_mode,
                                    'status' => 'not paid',
                                    'amount' => $totamount,
                                    'due' => $totamount,
                                    'des' => htmlspecialchars($request->des[$i]),
                                    'date' => date('Y-m-d'),
                                    'dom_pdf' => $filename,
                                    'discount' => $discount,
                                    'discount_percent' => $discount_p,
                                    'discount_type' => $request->discount_type[$i],
                                    'discount_amount' => $request->discount_amount[$i],
                                    'anount_ex_vat' => $request->anount_ex_vat[$i],
                                    'vat' => $request->vat[$i],
                                    'amount_after_vat' => $request->amount_after_vat[$i],
                                    'net_amount' => $request->net_amount[$i],
                                    'package' => $request->package[$i],
                                    'hold_st' => '',
                                    'canidate_name' => $request->canidate_name,
                                    'canidate_email' => $request->canidate_email,
                                    'candidate_id' => $request->candidate_id,
                                    'candidate_address' => $request->candidate_address,
                                    'billing_type' => $request->billing_type,
                                    'bill_for' => $request->bill_for,
                                    'bill_to' => $request->bill_to,
                                );
                                //dd($data);
                                DB::table('billing')->insert($data);

                                if ($recruitmentFirstBillValid) {
                                    $recruitment_file_emp = DB::table('recruitment_file_emp')->where('emid', '=', $request->emid)->where('employee_name', '=', $request->rec_candidate_name)->first();

                                    //dd($recruitment_file_emp);
                                    $dataRecruitmentUpdate = array(
                                        'billed_first_invoice' => 'Yes',
                                        'bill_no' => $pid,
                                        'update_new_ct' => date('Y-m-d'),
                                    );

                                    DB::table('recruitment_file_emp')->where('id', $recruitment_file_emp->id)->update($dataRecruitmentUpdate);
                                }
                                if ($recruitmentSecondBillValid) {
                                    $cos_apply_emp = DB::table('cos_apply_emp')->where('emid', '=', $request->emid)->where('employee_name', '=', $request->rec_candidate_name)->first();

                                    //dd($cos_apply_emp);
                                    $dataCosUpdate = array(
                                        'billed_second_invoice' => 'Yes',
                                        'bill_no' => $pid,
                                        'update_new_ct' => date('Y-m-d'),
                                    );

                                    DB::table('cos_apply_emp')->where('id', $cos_apply_emp->id)->update($dataCosUpdate);
                                }

                            }
                        }

                        $this->addAdminLog(4, 'Billing - Created new invoice with invoice no.: ' . $pid);
                        Session::flash('message', 'Bill Added Successfully .');

                        return redirect('superadmin/billing');

                    }

                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function addsubChildbilling()
    {

        try {
            $email = Session::get('empsu_email');

            $userType = Session::get('usersu_type');
            $org_code = Session::get('org_code');
            //dd($org_code);
            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }

                //All Bills
                $data['bill_rs'] = DB::Table('billing')->get();

                //organisation details
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('org_code','=',$org_code)
                    //->where('licence', '=', 'yes')
                    ->get();

                // $data['candidate_rs'] = DB::Table('invoice_candidates')
                //     ->where('status', '=', 'A')
                //     ->get();

                //hired candidate list
                $data['candidate_rs'] = DB::Table('candidate')
                    ->where('status', '=', 'Hired')
                    ->get();

                //dd($data['or_de']);

                $userlist = array();
                foreach ($data['bill_rs'] as $user) {
                    $userlist[] = $user->emid;
                }

                $data['package_rs'] = DB::Table('package')
                    ->where('status', '=', 'active')
                    ->get();

                $data['tax_rs'] = DB::Table('tax_bill')
                    ->where('status', '=', 'active')
                    ->get();

                return View('admin/billing-add-new', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewAddsubbillingy($comp_id)
    {
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $data['recruitment_file_emp'] = DB::table('recruitment_file_emp')->where('bill_no', base64_decode($comp_id))->first();
                $data['cos_apply_emp'] = DB::table('cos_apply_emp')->where('bill_no', base64_decode($comp_id))->first();

                $data['bill'] = DB::table('billing')

                    ->where('in_id', '=', base64_decode($comp_id))
                    ->get();
                $data['package_rs'] = DB::Table('package')
                    ->where('status', '=', 'active')
                    ->get();
                //dd($data);
                return View('admin/bill-edit-new', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

} //end class
