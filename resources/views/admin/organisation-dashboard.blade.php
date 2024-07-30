<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
	<style>
body {background: #f2f3f3;}
.main-panel .collapse {
    /*border-top: 1px solid #ececec;*/
}
.card h6{font-size: 16px;}
.arrow i{color: #fff;
    background: #136cdd;
    width: 30px;
    height: 30px;
    padding: 8px 7px;
    border-radius: 50%;
    font-size: 17px;}
.bg-primary-gradient {
    background: #1572e8!important;
    background: -webkit-linear-gradient(legacy-direction(-45deg),#06418e,#1572e8)!important;
    background: linear-gradient(
-45deg
 ,#06418e,#1572e8)!important;
}
.go{    background: #1572e8;
    width: 30px;
    border-radius: 50%;
    padding: 5px;
    margin-top: 15px; margin-bottom: 16px;}
.card{border-top: none;}
.alert [data-notify=title]{display:none !important;}
.alert [data-notify=message]{display:none !important}
.alert [data-notify=icon]{display:none !important}
.main-dash {margin: 30px;}.org-dasicon {background: #00efa2;color: #fff;width: 100%;height: 100%;padding: 32px 21px;}
.org-dasicon i{font-size: 25px;color:#fff;}
.pl0{padding-left: 0 !important} .pr0{padding-right:0 !important;}.mb0{margin-bottom: 0}.mt0{margin-top: 0;}
.org-dashcont {
    background: #fff;
    padding: 9px 20px 3px;
        min-height: 92px;
}
.main-dash h3 span{text-align: right;
    float: right;
    background: #08c286;
    color: #fff;
    padding: 2px 10px;
   }
ul{padding-left: 0;list-style: none;}.main-dash ul li{margin-bottom: 20px;}
.org-dasicon.orange{background: #f39c12;}.org-dasicon.red{background: #c00000;}
.org-dashcont p a {
    color: #343a40;
    text-decoration: none;
}
.card{margin-bottom: 5px;}
.card .card-header, .card-light .card-header {
    padding: 0.5rem 1.25rem;border-bottom: none !important;}
.footer{position:relative;}
.card h5 {
    padding: 0;
    font-size: 20px;text-align: left;color: #1572e8;;}
   button.btn.btn-link:hover {
    text-decoration: none !important;
}
/*.card-header{background: #e8e7e7;}*/
</style>

</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		  <div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div><?php if ($employee_id != '') {

    $lsatdeptorganlasr = DB::table('users_admin_emp')
        ->where('employee_id', '=', $employee_id)->orderBy('id', 'DESC')->first();
    $adname = 'For ' . $lsatdeptorganlasr->name;
} else {
    $adname = '';
}
?>
								<h2 class="text-white pb-2 fw-bold">Employee Tracker <?=$adname;?></h2>

							</div>
							<div class="ml-md-auto py-2 py-md-0">

							</div>
						</div>
					</div>
				</div>
				<?php
$cos_success_rs = 0;
$per_spi_appli = 0;
$per_spi_hr = 0;
if ($start_date == '' && $end_date == '' && $employee_id == '') {
    $or_appli = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')

        ->get();
    $or_lince = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')
        ->where('registration.licence', '=', 'yes')
        ->get();

    $data['or_verify'] = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')

        ->where('registration.licence', '=', 'no')
        ->get();
    $or_verify = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')

        ->where('registration.licence', '=', 'no')
        ->get();
    $or_noverify = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'not approved')
        ->where('registration.licence', '=', 'no')

        ->get();

    $or_partner_ref = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('tareq_app.assign', '=', 'Partner')
        ->where('tareq_app.reffered', '!=', '')

        ->get();

    $bill_rs = DB::Table('billing')

        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->orderBy('billing.id', 'desc')
        ->select('billing.*', 'tareq_app.ref_id')
        ->get();
    $first_invoice_rs = DB::Table('tareq_app')

        ->where('invoice', '=', 'Yes')
        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();
    $first_invoicehold_rs = DB::Table('tareq_app')

        ->where(function ($query) {
            $query->where('invoice', '=', 'No')
                ->orWhere('invoice', '=', ' ')
                ->orWhereNull('invoice');
        })
        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();
    $bill_paid_rs = DB::Table('payment')
        ->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
        ->where(function ($query) {
            $query->where('payment.status', '=', 'paid')
                ->orWhere('payment.status', '=', 'partially paid');
        })
        ->orderBy('payment.id', 'desc')
        ->get();
    $sum = 0;
    foreach ($bill_rs as $val) {
        $sum = $sum + $val->amount;
    }

    $hr_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_com_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.status', '=', 'Complete')
        ->get();
    $hr_home_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.home_off', '=', 'Yes')
        ->get();

    $hr_reject_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.licence', '=', 'Rejected')
        ->get();
    $hr_refused_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.licence', '=', 'Refused')
        ->get();
    $hr_granted_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.licence', '=', 'Granted')
        ->get();
    $hr_wip_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.status', '=', 'Incomplete')
        ->get();
    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')

        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();

    $visa_notification_rs = DB::Table('visa_or_emp_details_apply')

        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();
    $need_action_apply_rs = DB::Table('tareq_app')

        ->where('need_action', '=', 'Yes')
        ->orderBy('id', 'desc')
        ->get();
    $need_action_hr_rs = DB::Table('hr_apply')

        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.need_action', '=', 'Yes')
        ->get();

    $cos_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $cos_requesrt_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

    //->where('cos_apply_emp.status', '=', 'Request')
        ->orderBy('cos_apply_emp.id', 'desc')
        ->get();

    $cos_pending_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
        ->whereNull('cos_apply_emp.status')
    //->where('cos_apply_emp.status', '<>', 'Rejected')
        ->orderBy('cos_apply_emp.id', 'desc')
        ->get();
    //dd($cos_pending_rs);
    $cos_assigned_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $cos_granted_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->where('cos_apply_emp.status', '=', 'Granted')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_rejected_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->where('cos_apply_emp.status', '=', 'Rejected')
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $visafile_request_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $visafile_pending_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereNull('visa_file_emp.status')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $visafile_granted_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->where('visa_file_emp.status', '=', 'Granted')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();
    $visafile_rejected_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->where('visa_file_emp.status', '=', 'Rejected')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $recruitementfile_request_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_pending_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereNull('recruitment_file_emp.status')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_ongoing_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();
    $recruitementfile_hired_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->where('recruitment_file_emp.status', '=', 'Hired')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    if (count($cos_rs) != 0) {
        $cos_success_rs = number_format((count($cos_granted_rs) * 100) / count($cos_rs), 2);
    }

    $per_spi_appli = 0;
    $per_spi_hr = 0;

    $cos_further_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
        ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->where('cos_apply_emp.fur_query', '=', 'Yes')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $hr_lag_time_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->where('hr_apply.status', '=', 'Incomplete')
        ->get();

    $hr_reply_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->orderBy('hr_apply.id', 'desc')
        ->whereNotNull('hr_apply.hr_reply_date')
        ->get();
}

if ($start_date == '' && $end_date == '' && $employee_id != '') {
    $or_appli = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->get();
    $or_lince = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')
        ->where('registration.licence', '=', 'yes')

        ->get();

    $or_partner_ref = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('tareq_app.assign', '=', 'Partner')
        ->where('tareq_app.reffered', '!=', '')

        ->get();

    $data['or_verify'] = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')

        ->where('registration.licence', '=', 'no')
        ->get();
    $or_verify = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('registration.licence', '=', 'no')
        ->get();
    $or_noverify = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'not approved')
        ->where('registration.licence', '=', 'no')
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->get();
    $bill_rs = DB::Table('billing')
        ->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->orderBy('billing.id', 'desc')
        ->select('billing.*', 'tareq_app.ref_id')
        ->get();
    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')

        ->where('user_employee_id', '=', $employee_id)
        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();
    $visa_notification_rs = DB::Table('visa_or_emp_details_apply')

        ->where('user_employee_id', '=', $employee_id)
        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();
    $first_invoice_rs = DB::Table('tareq_app')

        ->where('invoice', '=', 'Yes')
        ->where('ref_id', '=', $employee_id)
        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();
    $first_invoicehold_rs = DB::Table('tareq_app')
        ->where('ref_id', '=', $employee_id)
        ->where(function ($query) {
            $query->where('invoice', '=', 'No')
                ->orWhere('invoice', '=', ' ')
                ->orWhereNull('invoice');
        })
        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();
    $bill_paid_rs = DB::Table('payment')
        ->join('role_authorization_admin_organ', 'payment.emid', '=', 'role_authorization_admin_organ.module_name')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
        ->where(function ($query) {
            $query->where('payment.status', '=', 'paid')
                ->orWhere('payment.status', '=', 'partially paid');
        })
        ->orderBy('payment.id', 'desc')
        ->get();
    $sum = 0;
    foreach ($bill_rs as $val) {
        $sum = $sum + $val->amount;
    }

    $hr_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)

        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_com_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.status', '=', 'Complete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_home_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.home_off', '=', 'Yes')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_reject_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.licence', '=', 'Rejected')
        ->orderBy('hr_apply.id', 'desc')
        ->get();

    $hr_refused_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.licence', '=', 'Refused')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_granted_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.licence', '=', 'Granted')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_wip_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.status', '=', 'Incomplete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $need_action_apply_rs = DB::Table('tareq_app')
        ->where('ref_id', '=', $employee_id)
        ->where('need_action', '=', 'Yes')
        ->orderBy('id', 'desc')
        ->get();
    $need_action_hr_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.need_action', '=', 'Yes')
        ->orderBy('hr_apply.id', 'desc')
        ->get();

    $cos_further_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
        ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply_emp.fur_query', '=', 'Yes')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $cos_requesrt_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
    //->where('cos_apply_emp.status', '=', 'Request')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_pending_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->whereNull('cos_apply_emp.status')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_assigned_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_granted_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->where('cos_apply.status', '=', 'Granted')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_rejected_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->where('cos_apply_emp.status', '=', 'Rejected')
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $visafile_request_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    // ->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->orderBy('visa_file_emp.id', 'desc')
        ->get();

    $visafile_pending_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->whereNull('visa_file_emp.status')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $visafile_granted_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->where('visa_file_emp.status', '=', 'Granted')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();
    $visafile_rejected_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    // ->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->where('visa_file_emp.status', '=', 'Rejected')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $recruitementfile_request_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    // ->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_pending_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->whereNull('recruitment_file_emp.status')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_ongoing_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();
    $recruitementfile_hired_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    // ->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->where('recruitment_file_emp.status', '=', 'Hired')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    if (count($cos_rs) != 0) {
        $cos_success_rs = number_format((count($cos_granted_rs) * 100) / count($cos_rs), 2);
    }
    $fof = 0;
    if (count($or_lince) != 0) {
        $tokgg = DB::table('role_authorization_admin_time')->where('type', '=', 'Application Time')->first();
        foreach ($or_lince as $lival) {
            $tok = DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours'))->where('employee_id', '=', $employee_id)->where('type', '=', 'Application Time')->where('emid', '=', $lival->reg)->first();

            if (!empty($tok->w_hours)) {
                if ($tokgg->time >= ($tok->w_hours)) {

                } else {
                    $fof++;
                }
            } else {
                $fof++;
            }
        }

    }

    $gof = 0;
    if (count($hr_com_rs) != 0) {
        $tokgg = DB::table('role_authorization_admin_time')->where('type', '=', 'HR Time')->first();
        foreach ($hr_com_rs as $lival) {
            $tok = DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours'))->where('employee_id', '=', $employee_id)->where('type', '=', 'HR Time')->where('emid', '=', $lival->emid)->first();

            if (!empty($tok->w_hours)) {
                if ($tokgg->time >= ($tok->w_hours)) {

                } else {
                    $gof++;
                }
            } else {
                $gof++;
            }
        }
    }
    if (count($or_lince) != 0) {

        if ($fof >= 1) {
            $per_spi_appli = 1;
        } else {
            $per_spi_appli = 0;
        }} else {
        $per_spi_appli = 1;
    }

    if (count($hr_com_rs) != 0) {
        if ($gof >= 1) {
            $per_spi_hr = 1;
        } else {
            $per_spi_hr = 0;
        }
    } else {
        $per_spi_hr = 1;
    }

    $hr_lag_time_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.status', '=', 'Incomplete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();

    $hr_reply_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->where('tareq_app.ref_id','=',$employee_id) 
        ->whereNotNull('hr_apply.hr_reply_date')
        ->orderBy('hr_apply.id', 'desc')
        ->get();


}

if ($start_date != '' && $end_date != '' && $employee_id == '') {
    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));
    $or_appli = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->get();
    $or_lince = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')
        ->where('registration.licence', '=', 'yes')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])

        ->get();

    $or_partner_ref = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('tareq_app.assign', '=', 'Partner')
        ->where('tareq_app.reffered', '!=', '')

        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])

        ->get();

    $data['or_verify'] = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->where('registration.licence', '=', 'no')
        ->get();
    $or_verify = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')

        ->where('registration.licence', '=', 'no')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->get();
    $or_noverify = DB::Table('registration')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'not approved')
        ->where('registration.licence', '=', 'no')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])

        ->get();
    $bill_rs = DB::Table('billing')
        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->whereBetween('billing.date', [$start_date, $end_date])
        ->orderBy('billing.id', 'desc')
        ->select('billing.*', 'tareq_app.ref_id')
        ->get();
    $first_invoice_rs = DB::Table('tareq_app')

        ->whereBetween('assign_date', [$start_date, $end_date])
        ->where('invoice', '=', 'Yes')

        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();
    $first_invoicehold_rs = DB::Table('tareq_app')
        ->whereBetween('assign_date', [$start_date, $end_date])
        ->where(function ($query) {
            $query->where('invoice', '=', 'No')
                ->orWhere('invoice', '=', ' ')
                ->orWhereNull('invoice');
        })
        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();

    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')

        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->whereBetween('start_date', [$start_date, $end_date])
        ->get();
    $visa_notification_rs = DB::Table('visa_or_emp_details_apply')

        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();

    $bill_paid_rs = DB::Table('payment')
        ->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
        ->where(function ($query) {
            $query->where('payment.status', '=', 'paid')
                ->orWhere('payment.status', '=', 'partially paid');
        })
        ->whereBetween('payment.date', [$start_date, $end_date])
        ->orderBy('payment.id', 'desc')
        ->get();
    $sum = 0;
    foreach ($bill_rs as $val) {
        $sum = $sum + $val->amount;
    }

    $hr_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])

        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_com_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.status', '=', 'Complete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_home_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.home_off', '=', 'Yes')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_reject_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.licence', '=', 'Rejected')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_refused_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.licence', '=', 'Refused')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_granted_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.licence', '=', 'Granted')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_wip_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.status', '=', 'Incomplete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $need_action_apply_rs = DB::Table('tareq_app')
        ->join('registration', 'tareq_app.emid', '=', 'registration.reg')
        ->where('registration.status', '=', 'active')

        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->where('tareq_app.need_action', '=', 'Yes')
        ->orderBy('tareq_app.id', 'desc')
        ->get();
    $need_action_hr_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.need_action', '=', 'Yes')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $cos_further_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
        ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.fur_query', '=', 'Yes')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $cos_requesrt_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
    //->where('cos_apply_emp.status', '=', 'Request')
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $cos_assigned_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $cos_pending_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->whereNull('cos_apply_emp.status')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_granted_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.status', '=', 'Granted')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_rejected_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.status', '=', 'Rejected')
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $visafile_request_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();
    $visafile_pending_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
        ->whereNull('visa_file_emp.status')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $visafile_granted_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    // ->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
        ->where('visa_file_emp.status', '=', 'Granted')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();
    $visafile_rejected_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
        ->where('visa_file_emp.status', '=', 'Rejected')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $recruitementfile_request_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_pending_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
        ->whereNull('recruitment_file_emp.status')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_ongoing_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    // ->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
        ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();
    $recruitementfile_hired_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
        ->where('recruitment_file_emp.status', '=', 'Hired')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    if (count($cos_rs) != 0) {
        $cos_success_rs = number_format((count($cos_granted_rs) * 100) / count($cos_rs), 2);
    }
    $per_spi_appli = 0;
    $per_spi_hr = 0;

    $hr_lag_time_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.sub_due_date', [$start_date, $end_date])
        ->where('hr_apply.status', '=', 'Incomplete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();

    $hr_reply_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.hr_reply_date', [$start_date, $end_date])
        ->orderBy('hr_apply.id', 'desc')
        ->get();


}

if ($start_date != '' && $end_date != '' && $employee_id != '') {

    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));

    $or_appli = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('registration.status', '=', 'active')

        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->get();
    $or_lince = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)

        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')
        ->where('registration.licence', '=', 'yes')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])

        ->where('tareq_app.ref_id', '=', $employee_id)
        ->get();
    $or_partner_ref = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('tareq_app.assign', '=', 'Partner')
        ->where('tareq_app.reffered', '!=', '')

        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])

        ->get();
    $data['or_verify'] = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')

        ->where('registration.licence', '=', 'no')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->get();

    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')
        ->where('user_employee_id', '=', $employee_id)
        ->orderBy('id', 'desc')
        ->whereBetween('start_date', [$start_date, $end_date])
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();
    $visa_notification_rs = DB::Table('visa_or_emp_details_apply')

        ->where('user_employee_id', '=', $employee_id)
        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();
    $or_verify = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'approved')
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('registration.licence', '=', 'no')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->get();
    $or_noverify = DB::Table('registration')
        ->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('registration.status', '=', 'active')
        ->where('registration.verify', '=', 'not approved')
        ->where('registration.licence', '=', 'no')
        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->get();
    $bill_rs = DB::Table('billing')
        ->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->whereBetween('billing.date', [$start_date, $end_date])
        ->orderBy('billing.id', 'desc')
        ->select('billing.*', 'tareq_app.ref_id')
        ->get();
    $first_invoice_rs = DB::Table('tareq_app')
        ->where('ref_id', '=', $employee_id)
        ->whereBetween('assign_date', [$start_date, $end_date])
        ->where('invoice', '=', 'Yes')

        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();
    $first_invoicehold_rs = DB::Table('tareq_app')
        ->whereBetween('assign_date', [$start_date, $end_date])
        ->where('ref_id', '=', $employee_id)
        ->where(function ($query) {
            $query->where('invoice', '=', 'No')
                ->orWhere('invoice', '=', ' ')
                ->orWhereNull('invoice');
        })
        ->orderBy('id', 'desc')
        ->select('tareq_app.*')
        ->get();

    $bill_paid_rs = DB::Table('payment')
        ->join('role_authorization_admin_organ', 'payment.emid', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where(function ($query) {
            $query->where('payment.status', '=', 'paid')
                ->orWhere('payment.status', '=', 'partially paid');
        })
        ->whereBetween('payment.date', [$start_date, $end_date])
        ->orderBy('payment.id', 'desc')
        ->get();
    $sum = 0;
    foreach ($bill_rs as $val) {
        $sum = $sum + $val->amount;
    }

    $hr_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_com_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.status', '=', 'Complete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_home_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.home_off', '=', 'Yes')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_reject_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.licence', '=', 'Rejected')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_refused_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.licence', '=', 'Refused')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_granted_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.licence', '=', 'Granted')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $hr_wip_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.status', '=', 'Incomplete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();
    $need_action_apply_rs = DB::Table('tareq_app')
        ->join('registration', 'tareq_app.emid', '=', 'registration.reg')
        ->where('registration.status', '=', 'active')

        ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
        ->where('tareq_app.need_action', '=', 'Yes')
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->orderBy('tareq_app.id', 'desc')
        ->get();
    $need_action_hr_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.need_action', '=', 'Yes')
        ->orderBy('hr_apply.id', 'desc')
        ->get();

    $cos_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_further_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
        ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.fur_query', '=', 'Yes')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_requesrt_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
    //->where('cos_apply_emp.status', '=', 'Request')
    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_assigned_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.cos_assigned', '=', 'Yes')
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_pending_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    //->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->whereNull('cos_apply_emp.status')
    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_granted_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.status', '=', 'Granted')
        ->orderBy('cos_apply.id', 'desc')
        ->get();
    $cos_rejected_rs = DB::Table('cos_apply_emp')
        ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
    // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

        ->whereBetween('cos_apply_emp.update_new_ct', [$start_date, $end_date])
        ->where('cos_apply_emp.status', '=', 'Rejected')
    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('cos_apply.employee_id', '=', $employee_id)
        ->orderBy('cos_apply.id', 'desc')
        ->get();

    $visafile_request_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    // ->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $visafile_pending_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    // ->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->whereNull('visa_file_emp.status')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $visafile_granted_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    //->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->where('visa_file_emp.status', '=', 'Granted')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();
    $visafile_rejected_rs = DB::Table('visa_file_emp')
        ->join('visa_file_apply', 'visa_file_apply.id', '=', 'visa_file_emp.com_visa_apply_id', 'inner')
    // ->join('tareq_app', 'visa_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('visa_file_emp.update_new_ct', [$start_date, $end_date])
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('visa_file_apply.employee_id', '=', $employee_id)
        ->where('visa_file_emp.status', '=', 'Rejected')
        ->orderBy('visa_file_apply.id', 'desc')
        ->get();

    $recruitementfile_request_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_pending_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
    //->where('tareq_app.ref_id', '=', $employee_id)
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->whereNull('recruitment_file_emp.status')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    $recruitementfile_ongoing_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->where('recruitment_file_emp.status', '=', 'Recruitment Ongoing')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();
    $recruitementfile_hired_rs = DB::Table('recruitment_file_emp')
        ->join('recruitment_file_apply', 'recruitment_file_apply.id', '=', 'recruitment_file_emp.com_recruitment_apply_id', 'inner')
    //->join('tareq_app', 'recruitment_file_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('recruitment_file_emp.update_new_ct', [$start_date, $end_date])
    // ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('recruitment_file_apply.employee_id', '=', $employee_id)
        ->where('recruitment_file_emp.status', '=', 'Hired')
        ->orderBy('recruitment_file_emp.id', 'desc')
        ->get();

    if (count($cos_rs) != 0) {
        $cos_success_rs = number_format((count($cos_granted_rs) * 100) / count($cos_rs), 2);
    }

    $fof = 0;
    if (count($or_lince) != 0) {
        $tokgg = DB::table('role_authorization_admin_time')->where('type', '=', 'Application Time')->first();
        foreach ($or_lince as $lival) {
            $tok = DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours'))->where('employee_id', '=', $employee_id)->where('type', '=', 'Application Time')->where('emid', '=', $lival->reg)->first();

            if (!empty($tok->w_hours)) {
                if ($tokgg->time >= ($tok->w_hours)) {

                } else {
                    $fof++;
                }
            } else {
                $fof++;
            }
        }

    }

    $gof = 0;
    if (count($hr_com_rs) != 0) {
        $tokgg = DB::table('role_authorization_admin_time')->where('type', '=', 'HR Time')->first();
        foreach ($hr_com_rs as $lival) {
            $tok = DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours'))->where('employee_id', '=', $employee_id)->where('type', '=', 'HR Time')->where('emid', '=', $lival->emid)->first();

            if (!empty($tok->w_hours)) {
                if ($tokgg->time >= ($tok->w_hours)) {

                } else {
                    $gof++;
                }
            } else {
                $gof++;
            }
        }
    }

    if (count($or_lince) != 0) {
        if ($fof >= 1) {
            $per_spi_appli = 1;
        } else {
            $per_spi_appli = 0;
        }} else {
        $per_spi_appli = 1;
    }

    if (count($hr_com_rs) != 0) {
        if ($gof >= 1) {
            $per_spi_hr = 1;
        } else {
            $per_spi_hr = 0;
        }
    } else {
        $per_spi_hr = 1;
    }
    $hr_lag_time_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.sub_due_date', [$start_date, $end_date])
        ->where('hr_apply.employee_id', '=', $employee_id)
        ->where('hr_apply.status', '=', 'Incomplete')
        ->orderBy('hr_apply.id', 'desc')
        ->get();

    $hr_reply_rs = DB::Table('hr_apply')
        ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
        ->whereBetween('hr_apply.hr_reply_date', [$start_date, $end_date])
        ->where('tareq_app.ref_id','=',$employee_id) 
        ->orderBy('hr_apply.id', 'desc')
        ->get();

}

$ongo = 0;
foreach ($bill_rs as $valoh) {
    if ($valoh->hold_st == 'Yes') {
        $ongo++;
    }

}
$aydngo = 0;

if ($start_date == '' && $end_date == '' && $employee_id == '') {
    $bill30da_rs = DB::Table('billing')

        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->where('billing.status', '=', 'not paid')
        ->orderBy('billing.id', 'desc')

        ->select('billing.*', 'tareq_app.ref_id')
        ->get();

}

if ($start_date == '' && $end_date == '' && $employee_id != '') {
    $bill30da_rs = DB::Table('billing')
        ->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('billing.status', '=', 'not paid')
        ->orderBy('billing.id', 'desc')
        ->select('billing.*', 'tareq_app.ref_id')
        ->get();

}

if ($start_date != '' && $end_date != '' && $employee_id == '') {
    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));
    $bill30da_rs = DB::Table('billing')
        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->whereBetween('billing.date', [$start_date, $end_date])
        ->where('billing.status', '=', 'not paid')
        ->orderBy('billing.id', 'desc')
        ->select('billing.*', 'tareq_app.ref_id')
        ->get();
}

if ($start_date != '' && $end_date != '' && $employee_id != '') {

    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));

    $bill30da_rs = DB::Table('billing')
        ->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
        ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
        ->where('role_authorization_admin_organ.member_id', '=', $employee_id)
        ->where('tareq_app.ref_id', '=', $employee_id)
        ->where('billing.status', '=', 'not paid')
        ->whereBetween('billing.date', [$start_date, $end_date])
        ->orderBy('billing.id', 'desc')
        ->select('billing.*', 'tareq_app.ref_id')
        ->get();

}
$aydngo15 = 0;

foreach ($bill30da_rs as $companyjhnvg) {

    if ($companyjhnvg->status == 'not paid' && $companyjhnvg->hold_st != 'Yes' || $companyjhnvg->hold_st != ' ' || is_null($companyjhnvg->hold_st)) {

        $daten = date('Y-m-d', strtotime($companyjhnvg->date . '  + 30 days'));
        $daten15 = date('Y-m-d', strtotime($companyjhnvg->date . '  + 15 days'));

        if ($daten < date('Y-m-d')) {
            $aydngo++;
        }
        if ($daten15 < date('Y-m-d')) {
            $aydngo15++;
        }

    }

}

if (count($visa_notification_rs) != 0) {
    $vis_count_not = 0;
    foreach ($visa_notification_rs as $visa_notification) {

        $today = date('Y-m-d');
        $next2day = date('Y-m-d', strtotime('+2 days'));

        $visa_expiry_notif = DB::Table('visa_or_emp_details_apply')
            ->where('emid', '=', $visa_notification->emid)
            ->where('employee_id', '=', $visa_notification->employee_id)

            ->whereBetween('end_date', [$today, $next2day])
            ->orderBy('id', 'desc')
            ->first();
        if (!empty($visa_expiry_notif)) {
            $vis_count_not = $vis_count_not + 1;
        }

    }

} else {
    $vis_count_not = 0;
}

?>
<?php
if ($start_date != '') {
    $start_date = $start_date;
} else {
    $start_date = 'all';
}
if ($end_date != '') {
    $end_date = $end_date;
} else {
    $end_date = 'all';
}
if ($employee_id != '') {
    $employee_id = $employee_id;
} else {
    $employee_id = 'all';
}

?>


<div class="main-dash">
	<div class="container">
		<div class="row">
		<div class="col-md-12">
			<div id="accordion" style="width: 100%;">
  <div class="card custom-card">
    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <div class="card-header" id="headingOne">
      <h5 class="mb-0">
          Application <span style="color: #2bb930; ">({{count($or_appli)}})</span>    <span class="arrow" style="float: right;"><i class="fas fa-chevron-down"></i></span>

      </h5>
    </div>
</button>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">



									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-1"></div>
											<h6 class="fw-bold mt-3 mb-0">Completed</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-complete/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}"  target="_blank" style="padding: 0 10px 17px;" data-original-title="View">


							<img class="go" src="../assets/img/login.png" style="background: rgb(255, 158, 39);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-2"></div>
											<h6 class="fw-bold mt-3 mb-0">WIP</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-wip/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}"   target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(43, 185, 48);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-3"></div>
											<h6 class="fw-bold mt-3 mb-0">Need Action</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-need/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(242, 89, 97);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-4"></div>
											<h6 class="fw-bold mt-3 mb-0">Performance SPI</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="#" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>
									</div>
									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-5"></div>
											<h6 class="fw-bold mt-3 mb-0">Partner Referral</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-partner/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>


										<div class="col-md-3 text-center">
											<div id="circles-6"></div>
											<h6 class="fw-bold mt-3 mb-0">First Invoice </h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-invoice/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-28"></div>
											<h6 class="fw-bold mt-3 mb-0">First Invoice (Hold)</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-invoicehld/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
									</div>
      </div>
    </div>
  </div>
  <div class="card">
     <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
     	<div class="card-header" id="headingTwo">
      <h5 class="mb-0">Revenue <span style="color: #2bb930; ">({{$sum}})</span>
          <span class="arrow" style="float: right;"><i class="fas fa-chevron-down"></i></span>
      </h5>
    </div>
    </button>

    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">


									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-7"></div>
											<h6 class="fw-bold mt-3 mb-0">Billed</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-billed/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-8"></div>
											<h6 class="fw-bold mt-3 mb-0">Recieved</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-recieved/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-9"></div>
											<h6 class="fw-bold mt-3 mb-0">30 Days+</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-days/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-10"></div>
											<h6 class="fw-bold mt-3 mb-0">15 Days+</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-fifdays/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(242, 89, 97);"></a>
										</div>
									</div>
									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-11"></div>
											<h6 class="fw-bold mt-3 mb-0">On Hold</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-onhold/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(255, 158, 39);"></a>
										</div>
									</div>

      </div>
    </div>

  <div class="card">
  	 <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">

          HR <span style="color: #2bb930; ">({{count($hr_rs)}})</span>   <span class="arrow" style="float: right;"><i class="fas fa-chevron-down"></i></span>

      </h5>
    </div>
    </button>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">

									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-12"></div>
											<h6 class="fw-bold mt-3 mb-0">Complete</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-hrcomplete/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(255, 158, 39);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-13"></div>
											<h6 class="fw-bold mt-3 mb-0">WIP</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-hrwip/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(43, 185, 48);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-14"></div>
											<h6 class="fw-bold mt-3 mb-0">Need Action</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hrneed/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(242, 89, 97);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-15"></div>
											<h6 class="fw-bold mt-3 mb-0">Performace-SPI</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="#" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>
									</div>
									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-16"></div>
											<h6 class="fw-bold mt-3 mb-0">Licence Award Decision (Granted)</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hraward/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							                <img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-17"></div>
											<h6 class="fw-bold mt-3 mb-0">Licence Rejected</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hrrejected/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							                <img class="go" src="../assets/img/login.png" style="background: rgb(253, 9, 88);"></a>
										</div>


										<div class="col-md-3 text-center">
											<div id="circles-18"></div>
											<h6 class="fw-bold mt-3 mb-0">Licence Refused</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hrrefused/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							                <img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-19"></div>
											<h6 class="fw-bold mt-3 mb-0">Home Office Client Visit</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hrhome/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							                <img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-20"></div>
											<h6 class="fw-bold mt-3 mb-0">Lag Time After Submission</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hrlagtime/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							                <img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-20-hrreply"></div>
											<h6 class="fw-bold mt-3 mb-0">HR Reply</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hrreply/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							                <img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>
									</div>
									</div>
      </div>
    </div>
  </div>

  <div class="card">
  	  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">

          COS <span style="color: #2bb930;">({{count($cos_rs)}})</span>   <span class="arrow" style="float: right;"><i class="fas fa-chevron-down"></i></span>

      </h5>
    </div> </button>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
      <div class="card-body">

									<div class="row pb-2 pt-4">
										<div class="col-md-2 text-center">
											<div id="circles-21"></div>
											<h6 class="fw-bold mt-3 mb-0">No. of CoS requested</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-request/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(242, 89, 97);"></a>
										</div>
                                        <div class="col-md-2 text-center">
											<div id="circles-24"></div>
											<h6 class="fw-bold mt-3 mb-0">Pending</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-pending/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-2 text-center">
											<div id="circles-22"></div>
											<h6 class="fw-bold mt-3 mb-0">Granted</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-granted/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(255, 158, 39);"></a>
										</div>
										<div class="col-md-2 text-center">
											<div id="circles-23"></div>
											<h6 class="fw-bold mt-3 mb-0">Rejected</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-rejected/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>
                                        <div class="col-md-2 text-center">
											<div id="circles-25"></div>
											<h6 class="fw-bold mt-3 mb-0">Assigned</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-assigned/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(253, 9, 88);"></a>
										</div>
										<!--<div class="col-md-2 text-center">
											<div id="circles-24"></div>
											<h6 class="fw-bold mt-3 mb-0">% Success</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="#" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										 <div class="col-md-2 text-center">
											<div id="circles-25"></div>
											<h6 class="fw-bold mt-3 mb-0">Further Query</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-further/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(253, 9, 88);"></a>
										</div>
										<div class="col-md-2 text-center">
											<div id="circles-26"></div>
											<h6 class="fw-bold mt-3 mb-0">Visa Expiry</h6>
											<a data-toggle="tooltip" data-placement="bottom" title=""  href="{{url('superadmin/list-visa-exp/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(33, 171, 255);"></a>
										</div>
									</div>
										<div class="row pt-4">
										<div class="col-md-2 text-center">
											<div id="circles-27"></div>
											<h6 class="fw-bold mt-3 mb-0">Visa Notification</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-visa-notifiaction/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(12, 179, 9);"></a>
										</div></div>-->

									</div>
      </div>
    </div>
  </div>

  <div class="card">
  	  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">

          VISA <span style="color: #2bb930;">({{count($visafile_request_rs)}})</span>   <span class="arrow" style="float: right;"><i class="fas fa-chevron-down"></i></span>

      </h5>
    </div> </button>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
      <div class="card-body">

									<div class="row pb-2 pt-4">

                                        <div class="col-md-2 text-center">
											<div id="circles-26"></div>
											<h6 class="fw-bold mt-3 mb-0">Pending</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-pending-visafile/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-2 text-center">
											<div id="circles-27"></div>
											<h6 class="fw-bold mt-3 mb-0">Granted</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-granted-visafile/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(255, 158, 39);"></a>
										</div>
										<div class="col-md-2 text-center">
											<div id="circles-29"></div>
											<h6 class="fw-bold mt-3 mb-0">Rejected</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-rejected-visafile/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>


									</div>
      </div>
    </div>
  </div>
  <div class="card">
  	  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
    <div class="card-header" id="headingSix">
      <h5 class="mb-0">

          RECRUITMENT <span style="color: #2bb930;">({{count($recruitementfile_request_rs)}})</span>   <span class="arrow" style="float: right;"><i class="fas fa-chevron-down"></i></span>

      </h5>
    </div> </button>
    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
      <div class="card-body">

									<div class="row pb-2 pt-4">

                                        <div class="col-md-2 text-center">
											<div id="circles-30"></div>
											<h6 class="fw-bold mt-3 mb-0">Requested</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-requested-recruitmentfile/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(200, 9, 234);"></a>
										</div>
										<div class="col-md-2 text-center">
											<div id="circles-31"></div>
											<h6 class="fw-bold mt-3 mb-0">Ongoing</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-ongoing-recruitmentfile/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(255, 158, 39);"></a>
										</div>
										<div class="col-md-2 text-center">
											<div id="circles-32"></div>
											<h6 class="fw-bold mt-3 mb-0">Hired</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="" href="{{url('superadmin/list-hired-recruitmentfile/'.base64_encode($start_date).'/'.base64_encode($end_date).'/'.base64_encode($employee_id))}}" target="_blank" style="padding: 0 10px 17px;" data-original-title="View">
							<img class="go" src="../assets/img/login.png" style="background: rgb(3, 122, 224);"></a>
										</div>


									</div>
      </div>
    </div>
  </div>
</div>





		</div>

<div class="row">

<div class="col-md-6">
	<div class="card">
		<div class="card-header" style="border-bottom: 1px solid #ccc !important;">
			<div class="card-title" style="color:#FF9E27;">Application<span style="text-align: right;
    float: right;
    background: #1572e8;
    color: #fff;
    padding: 2px 10px;">{{count($or_appli)}}</span></div>
		</div>
		<div class="card-body">
			<div class="chart-container">
				<canvas id="barChart"></canvas>
			</div>
		</div>
	</div>
</div>


<div class="col-md-6">
	<div class="card">
		<div class="card-header" style="border-bottom: 1px solid #ccc !important;">
			<div class="card-title" style="color:#2BB930;">Revenue<span style="text-align: right;
    float: right;
    background: #1572e8;
    color: #fff;
    padding: 2px 10px;">{{$sum}}</span></div>
		</div>
		<div class="card-body">
			<div class="chart-container">
				<canvas id="barChart1"></canvas>
			</div>
		</div>
	</div>
</div>
</div>



<div class="row">

<div class="col-md-6">
	<div class="card">
		<div class="card-header" style="border-bottom: 1px solid #ccc !important;">
			<div class="card-title" style="color:#F25961;">HR<span style="text-align: right;
    float: right;
    background: #1572e8;
    color: #fff;
    padding: 2px 10px;">{{count($hr_rs)}}</span></div>
		</div>
		<div class="card-body">
			<div class="chart-container">
				<canvas id="barChart3"></canvas>
			</div>
		</div>
	</div>
</div>


<div class="col-md-6">
	<div class="card">
		<div class="card-header" style="border-bottom: 1px solid #ccc !important;">
			<div class="card-title" style="color:#c809ea;">COS<span style="text-align: right;
    float: right;
    background: #1572e8;
    color: #fff;
    padding: 2px 10px;">{{count($cos_rs)}}</span></div>
		</div>
		<div class="card-body">
			<div class="chart-container">
				<canvas id="barChart4"></canvas>
			</div>
		</div>
	</div>
</div>
</div>

	</div>
</div>
		<!-- @include('admin.include.footer') -->
		</div>

		<!-- Custom template | don't include it in your project! -->

		<!-- End Custom template -->
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>


	<!-- Chart JS -->
	<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo.js')}}"></script>
	<script src="{{ asset('assets/js/demo.js')}}"></script>
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
	<script>
		Circles.create({
			id:'circles-1',
			radius:45,
			value:{{count($or_lince)}},
			maxValue:100,
			width:7,
			text: {{count($or_lince)}},
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value:<?php echo count($or_verify) + count($or_noverify); ?>,
			maxValue:100,
			width:7,
			text: <?php echo count($or_verify) + count($or_noverify); ?>,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:{{count($need_action_apply_rs)}},
			maxValue:100,
			width:7,
			text: {{count($need_action_apply_rs)}},
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-4',
			radius:45,
			value: <?php if ($per_spi_appli == 0) {echo '0';} else {echo '100';}?>,
			maxValue:100,
			width:7,
			text: <?php if ($per_spi_appli == 0) {echo '0';} else {echo '100';}?>,
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-5',
			radius:45,
			value:{{count(	$or_partner_ref)}},
			maxValue:100,
			width:7,
			text: {{count(	$or_partner_ref)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-6',
			radius:45,
			value:{{count($first_invoice_rs)}},
			maxValue:100,
			width:7,
			text: {{count($first_invoice_rs)}},
			colors:['#f1f1f1', '#c808eb'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-28',
			radius:45,
			value:{{count($first_invoicehold_rs)}},
			maxValue:100,
			width:7,
			text: {{count($first_invoicehold_rs)}},
			colors:['#f1f1f1', '#c808eb'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-7',
			radius:45,
			value:{{count($bill_rs)}},
			maxValue:100,
			width:7,
			text: {{count($bill_rs)}},
			colors:['#f1f1f1', '#c808eb'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-8',
			radius:45,
			value:{{count($bill_paid_rs)}},
			maxValue:100,
			width:7,
			text: {{count($bill_paid_rs)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-9',
			radius:45,
			value:{{$aydngo}},
			maxValue:100,
			width:7,
			text: {{$aydngo}},
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-10',
			radius:45,
			value:{{$aydngo15}},
			maxValue:100,
			width:7,
			text: {{$aydngo15}},
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
Circles.create({
			id:'circles-11',
			radius:45,
			value:{{$ongo}},
			maxValue:100,
			width:7,
			text: {{$ongo}},
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})


Circles.create({
			id:'circles-12',
			radius:45,
			value:{{count($hr_com_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_com_rs)}},
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-13',
			radius:45,
			value:{{count($hr_wip_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_wip_rs)}},
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-14',
			radius:45,
			value:{{count($need_action_hr_rs)}},
			maxValue:100,
			width:7,
			text: {{count($need_action_hr_rs)}},
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-15',
			radius:45,
			value:<?php if ($per_spi_hr == 0) {echo '0';} else {echo '100';}?>,
			maxValue:100,
			width:7,
			text: <?php if ($per_spi_hr == 0) {echo '0';} else {echo '100';}?>,
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-16',
			radius:45,
			value:{{count($hr_granted_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_granted_rs)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-17',
			radius:45,
			value:{{count($hr_reject_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_reject_rs)}},
			colors:['#f1f1f1', '#fd0958'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-18',
			radius:45,
			value:{{count($hr_refused_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_refused_rs)}},
			colors:['#f1f1f1', '#c808eb'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-19',
			radius:45,
			value:{{count($hr_home_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_home_rs)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-20',
			radius:45,
			value:{{count($hr_lag_time_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_lag_time_rs)}},
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-20-hrreply',
			radius:45,
			value:{{count($hr_reply_rs)}},
			maxValue:100,
			width:7,
			text: {{count($hr_reply_rs)}},
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-21',
			radius:45,
			value:{{count($cos_requesrt_rs)}},
			maxValue:100,
			width:7,
			text: {{count($cos_requesrt_rs)}},
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
        Circles.create({
			id:'circles-22',
			radius:45,
			value:{{count($cos_granted_rs)}},
			maxValue:100,
			width:7,
			text: {{count($cos_granted_rs)}},
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
        Circles.create({
			id:'circles-23',
			radius:45,
			value:{{count($cos_rejected_rs)}},
			maxValue:100,
			width:7,
			text: {{count($cos_rejected_rs)}},
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-24',
			radius:45,
			value:{{count($cos_pending_rs)}},
			maxValue:100,
			width:7,
			text: {{count($cos_pending_rs)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-25',
			radius:45,
			value:{{count($cos_assigned_rs)}},
			maxValue:100,
			width:7,
			text: {{count($cos_assigned_rs)}},
			colors:['#f1f1f1', '#fd0958'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-26',
			radius:45,
			value:{{count($visafile_pending_rs)}},
			maxValue:100,
			width:7,
			text: {{count($visafile_pending_rs)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-27',
			radius:45,
			value:{{count($visafile_granted_rs)}},
			maxValue:100,
			width:7,
			text: {{count($visafile_granted_rs)}},
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-29',
			radius:45,
			value:{{count($visafile_rejected_rs)}},
			maxValue:100,
			width:7,
			text: {{count($visafile_rejected_rs)}},
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-30',
			radius:45,
			value:{{count($recruitementfile_request_rs)}},
			maxValue:100,
			width:7,
			text: {{count($recruitementfile_request_rs)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-31',
			radius:45,
			value:{{count($recruitementfile_ongoing_rs)}},
			maxValue:100,
			width:7,
			text: {{count($recruitementfile_ongoing_rs)}},
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-32',
			radius:45,
			value:{{count($recruitementfile_hired_rs)}},
			maxValue:100,
			width:7,
			text: {{count($recruitementfile_hired_rs)}},
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})



var myBarChart = new Chart(barChart, {
			type: 'bar',
			data: {
				labels: ["Completed","WIP","Need Action","SPI","Partner Referral","First Invoice","First Invoice (Hold)"],
				datasets : [{
					label: "Application",
					backgroundColor: '#FF9E27',
					borderColor: '#FF9E27',
					data: [ {{count($or_lince)}}, <?=(count($or_verify) + count($or_noverify))?>, {{count($need_action_apply_rs)}}, <?php echo count($or_verify) + count($or_noverify); ?>, {{count(	$or_partner_ref)}}, {{count($first_invoice_rs)}}, {{count($first_invoicehold_rs)}}],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				},
			}
		});

var myBarChart1 = new Chart(barChart1, {
			type: 'bar',
			data: {
				labels: ["Billed","Recieved","30 Days+","15 Days+","On Hold"],
				datasets : [{
					label: "Revenue",
					backgroundColor: '#2BB930',
					borderColor: '#2BB930',
					data: [{{count($bill_rs)}}, {{count($bill_paid_rs)}}, {{$aydngo}}, {{$aydngo15}}, {{$ongo}}],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				},
			}
		});
var myBarChart3 = new Chart(barChart3, {
			type: 'bar',
			data: {
				labels: ["Complete","WIP","Need Action","SPI","Granted","Rejected","Refused","Home Office","Lag Time"],
				datasets : [{
					label: "HR",
					backgroundColor: '#F25961',
					borderColor: '#F25961',
					data: [ {{count($hr_com_rs)}}, {{count($hr_wip_rs)}}, {{count($need_action_hr_rs)}}, <?php if ($per_spi_appli == 0) {echo '0';} else {echo '100';}?>, {{count($hr_granted_rs)}}, {{count($hr_reject_rs)}}, {{count($hr_refused_rs)}}, {{count($hr_home_rs)}}, {{count($hr_lag_time_rs)}}],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				},
			}
		});
var myBarChart4 = new Chart(barChart4, {
			type: 'bar',
			data: {
				labels: ["No. of CoS requested","Pending","Granted","Rejected","Assigned"],
				datasets : [{
					label: "COS",
					backgroundColor: '#c809ea',
					borderColor: '#c809ea',
					data: [{{count($cos_requesrt_rs)}},{{count($cos_pending_rs)}}, {{count($cos_granted_rs)}}, {{count($cos_rejected_rs)}}, {{count($cos_assigned_rs)}}],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				},
			}
		});
		$('#lineChart').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>
</body>
</html>