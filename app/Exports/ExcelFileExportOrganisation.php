<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DateTime;

class ExcelFileExportOrganisation implements FromCollection, WithHeadings
{
    private $sd;
    private $ed;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($status, $start_date = '', $end_date = '')
    {
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {

        if ($this->status == 'active') {
            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->where('status', '=', 'active')
                // ->where('verify', '=', 'not approved')
                // ->where('licence', '=', 'no')
                    ->whereBetween('created_at', [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();

            } else {
                $companies_rs = DB::table('registration')
                    ->where('status', '=', 'active')
                // ->where('verify', '=', 'not approved')
                // ->where('licence', '=', 'no')
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }
        if ($this->status == 'unassigned') {

            $assignedOrgs = DB::Table('role_authorization_admin_organ')
                ->whereNotNull('role_authorization_admin_organ.module_name')
                ->pluck('role_authorization_admin_organ.module_name');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*')
                    ->whereNotIn('registration.reg', $assignedOrgs)
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'not approved')
                    ->where('registration.licence', '=', 'no')
                    ->whereBetween('registration.created_at', [$this->start_date, $this->end_date])
                    ->orderBy('registration.id', 'desc')
                    ->get();

            } else {

                $companies_rs = DB::table('registration')
                    ->select('registration.*')
                    ->whereNotIn('registration.reg', $assignedOrgs)
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'not approved')
                    ->where('registration.licence', '=', 'no')
                    ->orderBy('registration.id', 'desc')
                    ->get();
            }
        }
        if ($this->status == 'assigned') {

            $assignedOrgs = DB::Table('role_authorization_admin_organ')
                ->whereNotNull('role_authorization_admin_organ.module_name')
                ->pluck('role_authorization_admin_organ.module_name');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`created_at`) FROM `role_authorization_admin_organ` WHERE `module_name` LIKE  `registration`.`reg`) as assign_date"), DB::raw("(SELECT GROUP_CONCAT(users_admin_emp.name) FROM `role_authorization_admin_organ` INNER JOIN users_admin_emp ON users_admin_emp.employee_id=role_authorization_admin_organ.member_id WHERE `module_name` LIKE  `registration`.`reg`) as caseworker"))
                    ->whereIn('registration.reg', $assignedOrgs)
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'not approved')
                    ->where('registration.licence', '=', 'no')
                    ->whereBetween(DB::raw("(SELECT max(`created_at`) FROM `role_authorization_admin_organ` WHERE `module_name` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('registration.id', 'desc')
                    ->get();
            } else {

                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`created_at`) FROM `role_authorization_admin_organ` WHERE `module_name` LIKE  `registration`.`reg`) as assign_date"), DB::raw("(SELECT GROUP_CONCAT(users_admin_emp.name) FROM `role_authorization_admin_organ` INNER JOIN users_admin_emp ON users_admin_emp.employee_id=role_authorization_admin_organ.member_id WHERE `module_name` LIKE  `registration`.`reg`) as caseworker"))
                    ->whereIn('registration.reg', $assignedOrgs)
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'not approved')
                    ->where('registration.licence', '=', 'no')
                    ->orderBy('registration.id', 'desc')
                    ->get();
            }
        }
        if ($this->status == 'verified') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select remark_su from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_remarks"), DB::raw("(select assign_date from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_date"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'no')
                    ->whereBetween('verified_on', [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select remark_su from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_remarks"), DB::raw("(select assign_date from tareq_app where tareq_app.`emid` LIKE  `registration`.`reg`) as assignment_date"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'no')
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }
        if ($this->status == 'license_applied') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();

            } else {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }
        if ($this->status == 'license_internal') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('license_type', '=', 'Internal')
                    ->where('licence', '=', 'yes')
                    ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->where('license_type', '=', 'Internal')
                    ->orderBy('id', 'desc')
                    ->get();

            }
        }
        if ($this->status == 'license_external') {
            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('license_type', '=', 'External')
                    ->where('licence', '=', 'yes')
                    ->whereBetween(DB::raw("(SELECT DATE(last_date) FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`ref_id` where tareq_app.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->where('license_type', '=', 'External')
                    ->orderBy('id', 'desc')
                    ->get();

            }
        }
        if ($this->status == 'unbilled_first_inv_internal') {

            $billed1stOrgs = DB::Table('billing')
                ->where('bill_for', '=', 'invoice for license applied')
                ->where('status', '<>', 'cancel')
                ->pluck('billing.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                   // ->where('licence', '=', 'yes')
                    ->whereNotIn('reg', $billed1stOrgs)
                    ->where('license_type', '=', 'Internal')
                    ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    //->where('licence', '=', 'yes')
                    ->whereNotIn('reg', $billed1stOrgs)
                    ->where('license_type', '=', 'Internal')
                    ->orderBy('id', 'desc')
                    ->get();

            }

        }
        if ($this->status == 'billed_first_inv_internal') {

            $billed1stOrgs = DB::Table('billing')
                ->where('bill_for', '=', 'invoice for license applied')
                ->where('status', '<>', 'cancel')
                ->pluck('billing.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license applied' and `emid` LIKE  `registration`.`reg`) as billing_date"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                   // ->where('licence', '=', 'yes')
                    ->whereIn('reg', $billed1stOrgs)
                    ->where('license_type', '=', 'Internal')
                    ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license applied' `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();

            } else {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license applied' and `emid` LIKE  `registration`.`reg`) as billing_date"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license applied' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    //->where('licence', '=', 'yes')
                    ->whereIn('reg', $billed1stOrgs)
                    ->where('license_type', '=', 'Internal')
                    ->orderBy('id', 'desc')
                    ->get();
            }

        }
        if ($this->status == 'unassigned_hr_internal') {

            $hrFileOrgs = DB::Table('hr_apply')
                ->pluck('hr_apply.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->whereNotIn('reg', $hrFileOrgs)
                    ->where('license_type', '=', 'Internal')

                    ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            } else {

                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->whereNotIn('reg', $hrFileOrgs)
                    ->where('license_type', '=', 'Internal')
                    ->orderBy('id', 'desc')
                    ->get();
            }

        }
        if ($this->status == 'assigned_hr_internal') {

            $hrFileOrgs = DB::Table('hr_apply')
                ->pluck('hr_apply.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->whereIn('reg', $hrFileOrgs)
                    ->where('license_type', '=', 'Internal')

                    ->whereBetween(DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            } else {

                $companies_rs = DB::table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->whereIn('reg', $hrFileOrgs)
                    ->where('license_type', '=', 'Internal')
                    ->orderBy('id', 'desc')
                    ->get();
            }

        }
        if ($this->status == 'license_pending_internal') {

            $allLicHr = DB::Table('hr_apply')
                ->where(function ($query) {
                    $query->where('hr_apply.licence', '=', 'Refused')
                        ->orWhere('hr_apply.licence', '=', 'Granted')
                        ->orWhere('hr_apply.licence', '=', 'Rejected');

                })
                ->distinct()
                ->pluck('hr_apply.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->where('license_type', '=', 'Internal')
                    ->whereNotIn('registration.reg', $allLicHr)
                    ->whereBetween(DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();
            } else {

                $companies_rs = DB::Table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->where('licence', '=', 'yes')
                    ->where('license_type', '=', 'Internal')
                    ->whereNotIn('registration.reg', $allLicHr)
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();
            }

        }
        if ($this->status == 'license_unbill_second_inv_internal') {

            $billed2ndOrgs = DB::Table('billing')
                ->where('bill_for', '=', 'invoice for license granted')
                ->where('status', '<>', 'cancel')
                ->pluck('billing.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->where('hr_apply.licence', '=', 'Granted')
                    ->whereNotIn('registration.reg', $billed2ndOrgs)
                    ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                    ->distinct()
                    ->get();

            } else {
                $companies_rs = DB::Table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from tareq_app INNER JOIN users_admin_emp ON users_admin_emp.employee_id=tareq_app.`relation` where tareq_app.`emid` LIKE  `registration`.`reg`) as relationmgr"))
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->where('hr_apply.licence', '=', 'Granted')
                    ->whereNotIn('registration.reg', $billed2ndOrgs)
                    ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                    ->distinct()
                    ->get();

            }

        }
        if ($this->status == 'license_bill_second_inv_internal') {

            $billed2ndOrgs = DB::Table('billing')
                ->where('bill_for', '=', 'invoice for license granted')
                ->where('status', '<>', 'cancel')
                ->pluck('billing.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license granted' and `emid` LIKE  `registration`.`reg`  and billing.status <> 'cancel') as bill_date"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->where('hr_apply.licence', '=', 'Granted')
                    ->whereIn('registration.reg', $billed2ndOrgs)
                    ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license granted' and `emid` LIKE  `registration`.`reg`  and billing.status <> 'cancel')"), [$this->start_date, $this->end_date])
                    ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='invoice for license granted' and `emid` LIKE  `registration`.`reg`  and billing.status <> 'cancel') as bill_date"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"), DB::raw("(SELECT amount FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_amount"), DB::raw("(SELECT due FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_due"), DB::raw("(SELECT in_id FROM `billing` WHERE `emid` LIKE  `registration`.`reg` and billing.bill_for= 'invoice for license granted' and billing.status <> 'cancel' order by billing.id desc limit 1) as invoice_no"))
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->where('hr_apply.licence', '=', 'Granted')
                    ->whereIn('registration.reg', $billed2ndOrgs)
                    ->where(DB::raw("(DATE(registration.created_at))"), '<', '2022-08-01')
                    ->distinct()
                    ->get();
            }

        }
        if ($this->status == 'wip_hr_internal') {

            if ($this->start_date != '' && $this->end_date != '') {

                $companies_rs = DB::table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->where('hr_apply.status', '=', 'Incomplete')
                    ->whereBetween('registration.created_at', [$this->start_date, $this->end_date])
                //->where('hr_apply.licence', '=', 'Pending Decision')
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();
            } else {

                $companies_rs = DB::table('registration')
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

        }
        if ($this->status == 'complete_hr_internal') {

            $allLicHr = DB::Table('hr_apply')
                ->where(function ($query) {
                    $query->where('hr_apply.licence', '=', 'Refused')
                        ->orWhere('hr_apply.licence', '=', 'Granted')
                        ->orWhere('hr_apply.licence', '=', 'Rejected');

                })
                ->distinct()
                ->pluck('hr_apply.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid', 'inner')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->where('hr_apply.status', '=', 'Complete')
                    //->where('hr_apply.licence', '=', 'Pending Decision')
                    //->whereNotIn('registration.reg', $allLicHr)
                    ->whereBetween(DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();

            } else {

                $companies_rs = DB::table('registration')
                // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                    ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
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

            // dd($companies_rs);

        }
        if ($this->status == 'granted_hr_internal') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                // ->where('hr_apply.status', '=', 'Complete')
                    ->where('hr_apply.licence', '=', 'Granted')
                    ->whereBetween(DB::raw("(SELECT max(`grant_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    //->whereBetween('registration.created_at', [$this->start_date, $this->end_date])
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();

            } else {

                $companies_rs = DB::table('registration')
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

        }
        if ($this->status == 'rejected_hr_internal') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                // ->where('hr_apply.status', '=', 'Complete')
                    ->where('hr_apply.licence', '=', 'Rejected')
                    ->whereBetween(DB::raw("(SELECT max(`reject_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();

            } else {

                $companies_rs = DB::table('registration')
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

        }
        if ($this->status == 'refused_hr_internal') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                ->select('registration.*', DB::raw("(SELECT max(`update_new_ct`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_updated_at"), DB::raw("(SELECT max(`job_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_assigned_at"), DB::raw("(SELECT last_date FROM `tareq_app` WHERE `last_date` IS NOT NULL and `emid` LIKE  `registration`.`reg`) as application_submission_date"), DB::raw("(select GROUP_CONCAT(users_admin_emp.name) from hr_apply INNER JOIN users_admin_emp ON users_admin_emp.employee_id=hr_apply.`employee_id` where hr_apply.`emid` LIKE  `registration`.`reg`) as caseworker"), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->whereBetween(DB::raw("(SELECT max(`refused_date`) FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                // ->where('hr_apply.status', '=', 'Complete')
                    ->where('hr_apply.licence', '=', 'Refused')
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();

            } else {

                $companies_rs = DB::table('registration')
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

        }
        if ($this->status == 'pd_hr_internal') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*')
                // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->whereBetween('registration.created_at', [$this->start_date, $this->end_date])
                // ->where('hr_apply.status', '=', 'Complete')
                    ->where(function ($query) {

                        $query->whereNull('hr_apply.licence')
                            ->orWhere('hr_apply.licence', '=', 'Pending Decision');
                    })
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();

            } else {

                $companies_rs = DB::table('registration')
                    ->select('registration.*')
                // ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
                    ->join('hr_apply', 'registration.reg', '=', 'hr_apply.emid')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                // ->where('hr_apply.status', '=', 'Complete')
                    ->where(function ($query) {

                        $query->whereNull('hr_apply.licence')
                            ->orWhere('hr_apply.licence', '=', 'Pending Decision');
                    })
                    ->distinct()
                    ->orderBy('registration.id', 'desc')
                    ->get();
            }

        }

        if ($this->status == 'recruitment_assigned_org') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::table('registration')
                    ->select('registration.*', 'recruitment_file_apply.employee_id as caseworker_id', 'recruitment_file_apply.date as assign_date', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_apply.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->whereBetween('recruitment_file_apply.date', [$this->start_date, $this->end_date])
                    ->orderBy('recruitment_file_apply.id', 'desc')
                    ->get();

            } else {

                $companies_rs = DB::table('registration')
                    ->select('registration.*', 'recruitment_file_apply.employee_id as caseworker_id', 'recruitment_file_apply.date as assign_date', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_apply.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->where('registration.verify', '=', 'approved')
                    ->where('registration.licence', '=', 'yes')
                    ->where('registration.license_type', '=', 'Internal')
                    ->orderBy('recruitment_file_apply.id', 'desc')
                    ->get();
            }

        }
        if ($this->status == 'recruitment_request') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->whereBetween('recruitment_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('recruitment_file_apply.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

        }
        if ($this->status == 'recruitment_ongoing') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
                    ->whereBetween('recruitment_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('recruitment_file_apply.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

        }
        if ($this->status == 'recruitment_hired') {

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->where('registration.status', '=', 'active')
                    ->whereBetween('recruitment_file_emp.candidate_hired_date', [$this->start_date, $this->end_date])
                    ->orderBy('recruitment_file_apply.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->where('registration.status', '=', 'active')
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

        }
        if ($this->status == 'recruitment_unbilled') {

            $recruitment1stbillOrg = DB::Table('billing')
                ->where('bill_for', '=', 'first invoice recruitment service')
                ->where('status', '<>', 'cancel')
                ->pluck('billing.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    ->whereBetween('recruitment_file_emp.candidate_hired_date', [$this->start_date, $this->end_date])
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->where('recruitment_file_emp.billed_first_invoice', '=', 'No')
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

        }

        if ($this->status == 'recruitment_billed') {

            $recruitment1stbillOrg = DB::Table('billing')
                ->where('bill_for', '=', 'first invoice recruitment service')
                ->where('status', '<>', 'cancel')
                ->pluck('billing.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('recruitment_file_emp')
                    ->select('recruitment_file_emp.*', 'recruitment_file_emp.employee_id as caseworker_id', 'recruitment_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=recruitment_file_emp.employee_id) as caseworker'))
                    ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
                    ->join('registration', 'recruitment_file_emp.emid', '=', 'registration.reg')
                    ->where('registration.status', '=', 'active')
                    ->whereIn('recruitment_file_emp.emid', $recruitment1stbillOrg)
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->where('recruitment_file_emp.billed_first_invoice', '=', 'Yes')
                    ->whereBetween(DB::raw("(SELECT max(`date`) FROM `billing` WHERE `bill_for`='first invoice recruitment service' and `emid` LIKE  `registration`.`reg`)"), [$this->start_date, $this->end_date])
                    ->orderBy('recruitment_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('recruitment_file_emp')
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

        }

        if ($this->status == 'cos_unassigned') {

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

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereNull('cos_apply_emp.employee_id')
                    ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
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

            //dd($companies_rs);

        }
        if ($this->status == 'cos_assigned') {

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

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereNotNull('cos_apply_emp.employee_id')
                    ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
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

            //dd($companies_rs);

        }
        if ($this->status == 'cos_pending') {

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

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->whereNull('cos_apply_emp.status')
                    ->whereNotNull('cos_apply_emp.employee_id')
                    ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
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

            //dd($companies_rs);

        }
        if ($this->status == 'cos_granted') {

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


            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->whereNotNull('cos_apply_emp.employee_id')
                    ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->whereNotNull('cos_apply_emp.employee_id')
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }

        if ($this->status == 'cos_rejected') {

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


            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.status', '=', 'Rejected')
                    ->whereNotNull('cos_apply_emp.employee_id')
                    ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
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

            //dd($companies_rs);

        }

        if ($this->status == 'cos_not_assigned') {

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


            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
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
                    ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
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

            //dd($companies_rs);

        }

        if ($this->status == 'cos_granted_assigned') {

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


            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->whereBetween('cos_apply_emp.cos_assigned_date', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }

        if ($this->status == 'cosfile_unbilled') {

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

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                    ->whereNotIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->where('cos_apply_emp.billed_second_invoice', '=', 'No')
                    ->whereBetween('cos_apply_emp.cos_assigned_date', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                    ->whereNotIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->where('cos_apply_emp.billed_second_invoice', '=', 'No')
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }

        if ($this->status == 'cosfile_billed') {

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

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('cos_apply_emp')
                    ->select('cos_apply_emp.*', 'cos_apply_emp.employee_id as caseworker_id', 'cos_apply_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=cos_apply_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'cos_apply_emp.emid', '=', 'registration.reg')
                    ->whereIn('cos_apply_emp.emid', $cosGrantedOrg)
                    ->whereIn('cos_apply_emp.emid', $recruitment2ndbillOrg)
                    ->whereNotIn('cos_apply_emp.id', $cosInactiveId)
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->where('cos_apply_emp.billed_second_invoice', '=', 'Yes')
                    ->whereBetween('cos_apply_emp.cos_assigned_date', [$this->start_date, $this->end_date])
                    ->orderBy('cos_apply_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('cos_apply_emp')
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

            //dd($companies_rs);

        }
        if ($this->status == 'visafile_request') {

            $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                ->where('recruitment_file_emp.status', '=', 'Hired')
                ->pluck('recruitment_file_emp.emid');

            $cosGrantedOrg = DB::Table('cos_apply_emp')
                ->where('cos_apply_emp.status', '=', 'Granted')
                ->where('cos_apply_emp.addn_cos', '=', 'No')
                ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
            //->whereNotNull('cos_apply_emp.cos_assigned_date')
                ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                ->pluck('cos_apply_emp.emid');

            // $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
            //     ->where('cos_apply_emp.status', '=', 'Granted')
            //     ->where('cos_apply_emp.addn_cos', '=', 'No')
            //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
            //     ->pluck('cos_apply_emp.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereNull('visa_file_emp.employee_id')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->whereBetween('visa_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereNull('visa_file_emp.employee_id')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }

        if ($this->status == 'visafile_requested') {

            $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                ->where('recruitment_file_emp.status', '=', 'Hired')
                ->pluck('recruitment_file_emp.emid');

            $cosGrantedOrg = DB::Table('cos_apply_emp')
                ->where('cos_apply_emp.status', '=', 'Granted')
                ->where('cos_apply_emp.addn_cos', '=', 'No')
                ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
            //->whereNotNull('cos_apply_emp.cos_assigned_date')
                ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                ->pluck('cos_apply_emp.emid');

            // $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
            //     ->where('cos_apply_emp.status', '=', 'Granted')
            //     ->where('cos_apply_emp.addn_cos', '=', 'No')
            //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
            //     ->pluck('cos_apply_emp.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereNotNull('visa_file_emp.employee_id')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->whereBetween('visa_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereNotNull('visa_file_emp.employee_id')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }
        if ($this->status == 'visafile_pending') {

            $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                ->where('recruitment_file_emp.status', '=', 'Hired')
                ->pluck('recruitment_file_emp.emid');

            $cosGrantedOrg = DB::Table('cos_apply_emp')
                ->where('cos_apply_emp.status', '=', 'Granted')
                ->where('cos_apply_emp.addn_cos', '=', 'No')
                ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
            //->whereNotNull('cos_apply_emp.cos_assigned_date')
                ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                ->pluck('cos_apply_emp.emid');

            // $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
            //     ->where('cos_apply_emp.status', '=', 'Granted')
            //     ->where('cos_apply_emp.addn_cos', '=', 'No')
            //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
            //     ->pluck('cos_apply_emp.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereNull('visa_file_emp.status')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->whereBetween('visa_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->whereNull('visa_file_emp.status')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }

        if ($this->status == 'visafile_submitted') {

            $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                    ->where('recruitment_file_emp.status', '=', 'Hired')
                    ->pluck('recruitment_file_emp.emid');

                $cosGrantedOrg = DB::Table('cos_apply_emp')
                    ->where('cos_apply_emp.status', '=', 'Granted')
                    ->where('cos_apply_emp.addn_cos', '=', 'No')
                    ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
                    ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                    ->pluck('cos_apply_emp.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('visa_file_emp')
                ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                ->whereNull('visa_file_emp.status')
                ->where('visa_file_emp.addn_visa', '=', 'No')
                ->where('visa_file_emp.visa_application_submitted', '=', 'Yes')
                    ->whereBetween('visa_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('visa_file_emp')
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

            //dd($companies_rs);

        }

        if ($this->status == 'visafile_granted') {

            $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                ->where('recruitment_file_emp.status', '=', 'Hired')
                ->pluck('recruitment_file_emp.emid');

            $cosGrantedOrg = DB::Table('cos_apply_emp')
                ->where('cos_apply_emp.status', '=', 'Granted')
                ->where('cos_apply_emp.addn_cos', '=', 'No')
                ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
            //->whereNotNull('cos_apply_emp.cos_assigned_date')
                ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                ->pluck('cos_apply_emp.emid');

            // $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
            //     ->where('cos_apply_emp.status', '=', 'Granted')
            //     ->where('cos_apply_emp.addn_cos', '=', 'No')
            //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
            //     ->pluck('cos_apply_emp.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->where('visa_file_emp.status', '=', 'Granted')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->whereBetween('visa_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'), DB::raw("(SELECT remarks FROM `hr_apply` WHERE `emid` LIKE  `registration`.`reg`) as hr_remarks"))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->where('visa_file_emp.status', '=', 'Granted')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }
        if ($this->status == 'visafile_rejected') {

            $recruitmentHiredOrg = DB::Table('recruitment_file_emp')
                ->where('recruitment_file_emp.status', '=', 'Hired')
                ->pluck('recruitment_file_emp.emid');

            $cosGrantedOrg = DB::Table('cos_apply_emp')
                ->where('cos_apply_emp.status', '=', 'Granted')
                ->where('cos_apply_emp.addn_cos', '=', 'No')
                ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
            //->whereNotNull('cos_apply_emp.cos_assigned_date')
                ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
                ->pluck('cos_apply_emp.emid');

            // $cosGrantedAloneOrg = DB::Table('cos_apply_emp')
            //     ->where('cos_apply_emp.status', '=', 'Granted')
            //     ->where('cos_apply_emp.addn_cos', '=', 'No')
            //     ->whereIn('cos_apply_emp.emid', $recruitmentHiredOrg)
            //     ->pluck('cos_apply_emp.emid');

            if ($this->start_date != '' && $this->end_date != '') {
                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->where('visa_file_emp.status', '=', 'Rejected')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->whereBetween('visa_file_emp.update_new_ct', [$this->start_date, $this->end_date])
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();

            } else {

                $companies_rs = DB::Table('visa_file_emp')
                    ->select('visa_file_emp.*', 'visa_file_emp.employee_id as caseworker_id', 'visa_file_emp.date as assign_date', 'registration.com_name', DB::raw('(select name from users_admin_emp where employee_id=visa_file_emp.employee_id) as caseworker'))
                    ->join('registration', 'visa_file_emp.emid', '=', 'registration.reg')
                    ->whereIn('visa_file_emp.emid', $cosGrantedOrg)
                    ->where('visa_file_emp.status', '=', 'Rejected')
                    ->where('visa_file_emp.addn_visa', '=', 'No')
                    ->orderBy('visa_file_emp.id', 'desc')
                    ->distinct()
                    ->get();
            }

            //dd($companies_rs);

        }

        //dd($companies_rs);
        if ($this->status == 'recruitment_assigned_org') {
            $f = 1;
            foreach ($companies_rs as $company) {

                $customer_array[] = array(
                    'Sl No' => $f,
                    'Organisation Name' => $company->com_name,
                    'Phone No.' => $company->p_no,
                    'Org. Status' => strtoupper($company->status),
                    'Org. Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                    'Org. License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                    'Org. Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                    'Org. Registered On' => date('d-m-Y h:i a', strtotime($company->created_at)),
                    'WPC Employee' => $company->caseworker,
                    'Assigned On' => date('d-m-Y', strtotime($company->assign_date)),
                );

                $f++;
            }
        }elseif ($this->status == 'recruitment_request') {
            $f = 1;
            foreach ($companies_rs as $company) {

                $customer_array[] = array(
                    'Sl No' => $f,
                    'Organisation Name' => $company->com_name,
                    'Candidate Name' => $company->employee_name,
                    'WPC Employee' => $company->caseworker,
                    'Candidate identified?' => $company->candidate_identified,
                    'Advert posted?' => $company->advert_posted,
                    'Advert start date' => $company->advert_start_date,
                    'Advert end date' => $company->advert_end_date,
                    'Date of interview' => $company->date_of_interview,
                    'Recruitment Remarks' => $company->remarks,
                    'Last Update On' => date('d-m-Y', strtotime($company->update_new_ct)),
                );

                $f++;
            }

        }elseif ($this->status == 'recruitment_ongoing') {
            $f = 1;
            foreach ($companies_rs as $company) {

                $customer_array[] = array(
                    'Sl No' => $f,
                    'Organisation Name' => $company->com_name,
                    'Candidate Name' => $company->employee_name,
                    'WPC Employee' => $company->caseworker,
                    'Candidate identified?' => $company->candidate_identified,
                    'Advert posted?' => $company->advert_posted,
                    'Advert start date' => $company->advert_start_date,
                    'Advert end date' => $company->advert_end_date,
                    'Date of interview' => $company->date_of_interview,
                    'Recruitment Remarks' => $company->remarks,
                    'Last Update On' => date('d-m-Y', strtotime($company->update_new_ct)),
                );

                $f++;
            }
        }elseif ($this->status == 'recruitment_hired') {
            $f = 1;
            foreach ($companies_rs as $company) {

                $customer_array[] = array(
                    'Sl No' => $f,
                    'Organisation Name' => $company->com_name,
                    'Candidate Name' => $company->employee_name,
                    'WPC Employee' => $company->caseworker,
                    'Candidate identified?' => $company->candidate_identified,
                    'Advert posted?' => $company->advert_posted,
                    'Advert start date' => $company->advert_start_date,
                    'Advert end date' => $company->advert_end_date,
                    'Date of interview' => $company->date_of_interview,
                    'Recruitment Remarks' => $company->remarks,
                    'Last Update On' => date('d-m-Y', strtotime($company->update_new_ct)),
                );

                $f++;
            }

        } elseif ($this->status == 'recruitment_unbilled' || $this->status == 'recruitment_billed') {
            $f = 1;
            foreach ($companies_rs as $company) {

                $customer_array[] = array(
                    'Sl No' => $f,
                    'Organisation Name' => $company->com_name,
                    'Candidate Name' => $company->employee_name,
                    'WPC Employee' => $company->caseworker,
                    'Candidate identified?' => $company->candidate_identified,
                    'Advert posted?' => $company->advert_posted,
                    'Advert start date' => $company->advert_start_date,
                    'Advert end date' => $company->advert_end_date,
                    'Date of interview' => $company->date_of_interview,
                    'Recruitment Remarks' => $company->remarks,
                    'Last Update On' => date('d-m-Y', strtotime($company->update_new_ct)),
                );
                $f++;
            }
        } elseif ($this->status == 'cos_unassigned' || $this->status == 'cos_assigned' || $this->status == 'cos_pending' || $this->status == 'cos_granted' || $this->status == 'cos_rejected' || $this->status == 'cos_not_assigned' || $this->status == 'cos_granted_assigned' || $this->status == 'cosfile_unbilled' || $this->status == 'cosfile_billed') {
            $f = 1;
            //dd($this->status);
            foreach ($companies_rs as $company) {

                $customer_array[] = array(
                    'Sl No' => $f,
                    'Organisation Name' => $company->com_name,
                    'Organisation Employee Name' => $company->employee_name,
                    'WPC Employee' => $company->caseworker,
                    'Applied for Cos-Date' => ($company->applied_cos_date != null && $company->applied_cos_date != '0000-00-00') ? date('d/m/Y', strtotime($company->applied_cos_date)) : '',
                    'Reply from HO-date' => ($company->additional_info_request_date != null && $company->additional_info_request_date != '0000-00-00') ? $company->additional_info_request_date : '',
                    'Additional information sent - date' => ($company->additional_info_sent_date != null && $company->additional_info_sent_date != '0000-00-00') ? date('d/m/Y', strtotime($company->additional_info_sent_date)) : '',
                    'Status' => ($company->status == '') ? 'Pending' : $company->status,
                    'CoS assigned date' => ($company->cos_assigned_date != null && $company->cos_assigned_date != '0000-00-00') ?
                    date('d/m/Y', strtotime($company->cos_assigned_date)) : '',
                    'Remarks' => $company->remarks_cos,
                    'Last Update On' => date('d-m-Y', strtotime($company->update_new_ct)),
                    //'HR Remarks' => $company->hr_remarks,
                );
                $f++;
            }
        } elseif ($this->status == 'visafile_request' || $this->status == 'visafile_requested' || $this->status == 'visafile_pending' || $this->status == 'visafile_submitted' || $this->status == 'visafile_granted' || $this->status == 'visafile_rejected') {
            $f = 1;
            //dd($this->status);
            foreach ($companies_rs as $company) {

                $customer_array[] = array(
                    'Sl No' => $f,
                    'Organisation Name' => $company->com_name,
                    'Organisation Employee Name' => $company->employee_name,
                    'WPC Employee' => $company->caseworker,
                    'CoS assigned?' => $company->cos_assigned,
                    'Visa application submitted?' => $company->visa_application_submitted,
                    'Visa application submition Date' => ($company->visa_application_submit_date != null && $company->visa_application_submit_date != '0000-00-00') ? $company->visa_application_submit_date : '',
                    'Biometric appointment date' => ($company->biometric_appo_date != null && $company->biometric_appo_date != '0000-00-00') ? date('d/m/Y', strtotime($company->biometric_appo_date)) : '',
                    'Interview Date' => ($company->interview_date != null && $company->interview_date != '0000-00-00') ?
                    date('d/m/Y', strtotime($company->interview_date)) : '',
                    'Status' => ($company->status == '') ? 'Pending' : $company->status,
                    'Remarks' => $company->remarks,
                    'Last Update On' => date('d-m-Y', strtotime($company->update_new_ct)),
                    //'HR Remarks' => $company->hr_remarks,
                );
                $f++;
            }
        }
        else {

            $f = 1;
            foreach ($companies_rs as $company) {

                $pass = DB::Table('users')->where('employee_id', '=', $company->reg)->first();

                $caddress = '';
                if ($company->address != '') {
                    $caddress = $caddress . $company->address;
                }
                if ($company->address2 != '') {
                    $caddress = $caddress . ', ' . $company->address2;
                }
                if ($company->road != '') {
                    $caddress = $caddress . ', ' . $company->road;
                }
                if ($company->city != '') {
                    $caddress = $caddress . ', ' . $company->city;
                }
                if ($company->zip != '') {
                    $caddress = $caddress . ', ' . $company->zip;
                }
                if ($company->country != '') {
                    $caddress = $caddress . ', ' . $company->country;
                }
                if ($this->status == 'assigned') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        // 'Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'WPC Employee' => $company->caseworker,
                        'Assigned On' => date('d-m-Y', strtotime($company->assign_date)),
                        'Created On' => date('d-m-Y h:i a', strtotime($company->created_at)),
                    );

                }elseif ($this->status == 'verified') {
                    $fdate=date('Y-m-d');
                    $tdate=$company->assignment_date;
                    $datetime1 = new DateTime($fdate);
                    $datetime2 = new DateTime($tdate);
                    $interval = $datetime1->diff($datetime2);
                    $days = $interval->format('%a');

                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'WPC Employee' => $company->caseworker,
                        'Assignment Remarks' => $company->assignment_remarks,
                        'Assigned Date' => $company->assignment_date,
                        'Time Lapsed (Days)' => $days,
                        'Payment Status' => ($company->license_type == 'Internal') ? $this->getOrgWIPPaymentStatus($company->id) : '',
                        'Updated On' => date('d-m-Y h:i a', strtotime($company->updated_at)),
                    );

                }elseif ($this->status == 'license_applied'|| $this->status == 'license_internal') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'Assigned On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'WPC Employee' => $company->caseworker,
                        'HR Latest Update' => $this->getOrganisationHRStage($company->reg),
                       
                    );

                }elseif ($this->status == 'license_external') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        //'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'Assigned On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'WPC Employee' => $company->caseworker,
                        'Relationship Manager' => $company->relationmgr,
                        'HR Latest Update' => $this->getOrganisationHRStage($company->reg),
                       
                    );

                }elseif ($this->status == 'assigned_hr_internal') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'WPC Employee' => $company->caseworker,
                        'License Applied On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'HR Assigned On' => ($company->hr_updated_at!='')?date('d-m-Y', strtotime($company->hr_updated_at)):'',
                        
                        'HR Remarks' => $company->hr_remarks,
        
                    );

                }elseif ($this->status == 'license_pending_internal') {
                    $fdate=date('Y-m-d');
                    $tdate=$company->application_submission_date;
                    $datetime1 = new DateTime($fdate);
                    $datetime2 = new DateTime($tdate);
                    $interval = $datetime1->diff($datetime2);
                    $days = $interval->format('%a');

                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        
                        'License Applied On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'Time Lapsed (Days)' => $days,
                        'WPC Employee' => $company->caseworker,
                        
                        'HR Remarks' => $this->getOrganisationHRStage($company->reg),
        
                    );

               
                
                }elseif ($this->status == 'unbilled_first_inv_internal') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'Assigned On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'Relationship Manager' => $company->relationmgr,
                    );
                }elseif ($this->status == 'billed_first_inv_internal') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'License Applied On'=> ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'Last Billed On'=> ($company->billing_date!='')?date('d-m-Y', strtotime($company->billing_date)):'',
                        'Invoice Amount'=> $company->invoice_amount,
                        'Invoice No.'=> $company->invoice_no,
                        'Invoice Balance'=> $company->invoice_due,
                        'Last Accounts Remarks'=> $this->getLastBillRemarks($company->invoice_no),
                        
                    );

                }elseif ($this->status == 'unassigned_hr_internal') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'License Applied On'=> ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        
                        
                    );

                }elseif ($this->status == 'granted_hr_internal' || $this->status == 'wip_hr_internal' || $this->status =='complete_hr_internal' || $this->status == 'rejected_hr_internal'  || $this->status == 'refused_hr_internal' ) {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'WPC Employee' => $company->caseworker,
                        'License Applied On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'HR Assigned On' => ($company->hr_assigned_at!='')?date('d-m-Y', strtotime($company->hr_assigned_at)):'',
                        'Updated On' => date('d-m-Y h:i a', strtotime($company->hr_updated_at)),
                        'HR Remarks' => $company->hr_remarks,
        
                    );
                }elseif ($this->status == 'license_unbill_second_inv_internal') {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'License Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'WPC Employee' => $company->caseworker,
                        'Relationship Manager' => $company->relationmgr,
                        'License Applied On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'HR Assigned On' => ($company->hr_assigned_at!='')?date('d-m-Y', strtotime($company->hr_assigned_at)):'',
                        'Updated On' => date('d-m-Y h:i a', strtotime($company->hr_updated_at)),
                        'HR Remarks' => $company->hr_remarks,
        
                    );

                }elseif ($this->status == 'license_bill_second_inv_internal' ) {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        // 'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        'Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'WPC Employee' => $company->caseworker,
                        'License Applied On' => ($company->application_submission_date!='')?date('d-m-Y', strtotime($company->application_submission_date)):'',
                        'HR Assigned On' => ($company->hr_assigned_at!='')?date('d-m-Y', strtotime($company->hr_assigned_at)):'',
                        'Updated On' => date('d-m-Y h:i a', strtotime($company->hr_updated_at)),
                        'Last Billed On'=> ($company->bill_date!='')?date('d-m-Y', strtotime($company->bill_date)):'',
                        'Invoice Amount'=> $company->invoice_amount,
                        'Invoice No.'=> $company->invoice_no,
                        'Invoice Balance'=> $company->invoice_due,
                        'Last Accounts Remarks'=> $this->getLastBillRemarks($company->invoice_no),
        
                    );

                } elseif ($this->status == 'active'){
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        'Status' => strtoupper($company->status),
                        // 'Verification' => ($company->verify == 'approved') ? 'VERIFIED' : 'NOT VERIFIED',
                        // 'License Applied' => ($company->licence == 'yes') ? 'APPLIED' : 'NOT APPLIED',
                        // 'Type' => ($company->license_type != '') ? $company->license_type : 'NA',
                        'Created On' => date('d-m-Y h:i a', strtotime($company->created_at)),
                        'Current Stage' => $this->getOrganisationStage($company->id),
                    );

                }
                else {
                    $customer_array[] = array(
                        'Sl No' => $f,
                        'Organisation Name' => $company->com_name,
                        'Organisation Address' => $caddress,
                        'Website' => $company->website,
                        'Login User Id' => $company->email,
                        'Password' => $pass->password,
                        'Phone No.' => $company->p_no,
                        'Created On' => date('d-m-Y h:i a', strtotime($company->created_at)),
                        'Updated On' => date('d-m-Y h:i a', strtotime($company->updated_at)),
                    );

                }

                $f++;
            }
        }

        return collect($customer_array);
    }

    public function headings(): array
    {
        if ($this->status == 'assigned') {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                // 'Type',
                'WPC Employee',
                'Last Assigned On',
                'Created On',
            ];

        } elseif ($this->status == 'verified') {
            return[
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'License Type',
                'WPC Employee',
                'Assignment Remarks',
                'Assigned Date',
                'Time Lapsed (Days)',
                'Payment Status',
                'Updated On',
            ];

        } elseif ($this->status == 'license_applied' || $this->status == 'license_internal') {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'License Type',
                'Applied On',
                'WPC Employee',
                'HR Latest Update',
            ];
        } elseif ($this->status == 'license_external') {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                //'License Type',
                'Applied On',
                'WPC Employee',
                'Relationship Manager',
                'HR Latest Update',
            ];
        } elseif ($this->status == 'assigned_hr_internal' ) {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                //'License Applied',
                'License Type',
                'WPC Employee',
                'License Applied On',
                'HR Assigned On',
               
                'HR Remarks',
            ];
        } elseif ($this->status =='license_pending_internal' ) {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'Type',
                'License Applied On',
                'Time Lapsed (Days)',
                'WPC Employee',
                'HR Latest Update',
            ];
                       
        }elseif ($this->status == 'unbilled_first_inv_internal') {
            
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'License Type',
                'Assigned On',
                'Relationship Manager',
            ];
        }elseif ($this->status == 'billed_first_inv_internal') {
            
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'License Type',
                'License Applied On',
                'Last Billed On',
                'Invoice Amount',
                'Invoice No.',
                'Invoice Balance',
                'Last Accounts Remarks',
            ];
        }elseif ($this->status == 'unassigned_hr_internal') {
            
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'License Type',
                'License Applied On',
                
            ];
        } elseif ($this->status == 'granted_hr_internal' || $this->status == 'wip_hr_internal' || $this->status =='complete_hr_internal' || $this->status == 'rejected_hr_internal' || $this->status == 'refused_hr_internal') {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'License Type',
                'WPC Employee',
                'License Applied On',
                'HR Assigned On',
                'Updated On',
                'HR Remarks',
            ];
        } elseif ($this->status == 'license_unbill_second_inv_internal') {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'License Type',
                'WPC Employee',
                'Relationship Manager',
                'License Applied On',
                'HR Assigned On',
                'Updated On',
                'HR Remarks',
            ];
        } elseif ($this->status == 'license_bill_second_inv_internal') {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                'Type',
                'WPC Employee',
                'License Applied On',
                'HR Assigned On',
                'HR Updated On',
                'Last Billed On',
                'Invoice Amount',
                'Invoice No.',
                'Invoice Balance',
                'Last Accounts Remarks'
            ];
        } elseif ($this->status == 'recruitment_assigned_org') {
            return [
                'Sl No',
                'Organisation Name',
                'Phone No.',
                'Org. Status',
                'Org. Verification',
                'Org. License Applied',
                'Org. Type',
                'Org. Registered On',
                'WPC Employee',
                'Assigned On',
            ];
        } elseif ($this->status == 'recruitment_request') {
            return [
                'Sl No',
                'Organisation Name',
                'Candidate Name',
                'WPC Employee',
                'Candidate identified?',
                'Advert posted?',
                'Advert start date',
                'Advert end date',
                'Date of interview',
                'Recruitment Remarks',
                'Last Update On',
            ];
        } elseif ($this->status == 'recruitment_ongoing') {
            return [
                'Sl No',
                'Organisation Name',
                'Candidate Name',
                'WPC Employee',
                'Candidate identified?',
                'Advert posted?',
                'Advert start date',
                'Advert end date',
                'Date of interview',
                'Recruitment Remarks',
                'Last Update On',
            ];
        } elseif ($this->status == 'recruitment_hired') {
            return [
                'Sl No',
                'Organisation Name',
                'Candidate Name',
                'WPC Employee',
                'Candidate identified?',
                'Advert posted?',
                'Advert start date',
                'Advert end date',
                'Date of interview',
                'Recruitment Remarks',
                'Last Update On',
            ];

        } elseif ($this->status == 'recruitment_unbilled' || $this->status == 'recruitment_billed') {
            return [
                'Sl No',
                'Organisation Name',
                'Candidate Name',
                'WPC Employee',
                'Candidate identified?',
                'Advert posted?',
                'Advert start date',
                'Advert end date',
                'Date of interview',
                'Recruitment Remarks',
                'Last Update On',

            ];
        } elseif ($this->status == 'cos_unassigned' || $this->status == 'cos_assigned' || $this->status == 'cos_pending' || $this->status == 'cos_granted' || $this->status == 'cos_rejected' || $this->status == 'cos_not_assigned' || $this->status == 'cos_granted_assigned' || $this->status == 'cosfile_unbilled'|| $this->status == 'cosfile_billed') {
            return [
                'Sl No',
                'Organisation Name',
                'Candidate Name',
                'WPC Employee',
                'Applied for Cos-Date',
                'Reply from HO-date',
                'Additional information sent - date',
                'Status',
                'CoS assigned date',
                'Remarks',
                'Last Update On',
               // 'HR Remarks',

            ];
        } elseif ($this->status == 'visafile_request' || $this->status == 'visafile_requested' || $this->status == 'visafile_pending'  || $this->status == 'visafile_submitted' || $this->status == 'visafile_granted' || $this->status == 'visafile_rejected') {
            return [
                'Sl No',
                'Organisation Name',
                'Candidate Name',
                'WPC Employee',
                'CoS assigned?',
                'Visa application submitted?',
                'Visa application submition Date',
                'Biometric appointment date',
                'Interview Date',
                'Status',
                'Remarks',
                'Last Update On',
               // 'HR Remarks',

            ];

        } elseif ($this->status == 'active'){
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                'Status',
                // 'Verification',
                // 'License Applied',
                // 'Type',
                'Created On',
                'Current Stage',
            ];

        }
        else {
            return [
                'Sl No',
                'Organisation Name',
                'Organisation Address',
                'Website',
                'Login User Id',
                'Password',
                'Phone No.',
                // 'Status',
                // 'Verification',
                // 'License Applied',
                // 'Type',
                'Created On',
                'Updated On',
            ];

        }
    }

    public function getLastBillRemarks($in_id){
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

    public function getOrganisationHRStage($emid){
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


    public function getOrganisationStage($organisation_id){
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


}$f = 1;
