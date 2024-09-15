<?php


namespace App;

use App\Http\Controllers\organization\ExportController;
use App\Http\Controllers\organization\PDFController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Route;
use Session;
use App\InterviewCandidate;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\organization\OrganizationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('index');
// });

// new route



Route::get('forgot-password', 'App\Http\Controllers\organization\LandingController@indexfor');
Route::post('forgot-password', 'App\Http\Controllers\organization\LandingController@Doforgot');

//Export Excel Dynamically route
Route::post('/export-table-data', [ExportController::class, 'exportTableData'])->name('exportTableData');
Route::post('/export-pdf', [PDFController::class, 'exportPDF'])->name('exportPDF');

// organization Controller 
Route::get('organization/employerdashboard', 'App\Http\Controllers\organization\OrganizationController@Dashboard')->name('organization.home');
Route::get('/organization-statistics', [OrganizationController::class, 'statistics'])->name('organization.statistics');
Route::get('/organization/profile', [OrganizationController::class, 'profile'])->name('organization.profile');
Route::get('org-company-profile/edit-company', [OrganizationController::class, 'viewAddCompany']);
Route::post('org-company-profile/editcompany', [OrganizationController::class, 'saveCompany']);
Route::get('/employees-according-to-rti', [OrganizationController::class, 'employeesRTI'])->name('employees.rti');
Route::get('/authorizing-officer', [OrganizationController::class, 'authorizingOfficer'])->name('authorizing.officer');
Route::get('/key-contact', [OrganizationController::class, 'keyContact'])->name('key.contact');
Route::get('/level-1-user', [OrganizationController::class, 'level1User'])->name('level1.user');
Route::get('/level-2-user', [OrganizationController::class, 'level2User'])->name('level2.user');
Route::get('org-company-profile/pdf', [OrganizationController::class, 'pdf']);

// Employee  
Route::get('organization/employee/employerdashboard', 'App\Http\Controllers\organization\LandingController@employeeDashboard')->name('organization.employee.dashboard');
Route::get('organization/employeeee', 'App\Http\Controllers\organization\LandingController@allempcard')->name('organization/employee-card');
Route::get('organization/emplist', 'App\Http\Controllers\organization\LandingController@allEmpList')->name('organization/emp-list');
Route::get('organization/view-add-employee', 'App\Http\Controllers\organization\EmployeeController@viewAddEmployee')->name('organization/view-add-employee');
Route::post('organization/view-add-employee', 'App\Http\Controllers\organization\EmployeeController@saveEmployee');

Route::get('organization/add_employee', 'App\Http\Controllers\organization\LandingController@addEmployee')->name('new_employeee_new');
//Route::post('organization/save-employee', 'App\Http\Controllers\EmployeeController@saveEmployee');
Route::get('organization/example', 'App\Http\Controllers\organization\EmployeeController@example');




//----------------------------- Holiday List ------------------------------------
Route::get('orgaization/holiday-dashboard','App\Http\Controllers\organization\HolidayController@dashboard')->name('organization/holiday-dashboard');
Route::get('organization/holiday-list', 'App\Http\Controllers\organization\HolidayController@holidayList')->name('organization/holiday-list');
Route::get('organization/add-holiday-list', 'App\Http\Controllers\organization\HolidayController@addHolidayList')->name('organization/add-holiday-list');
Route::post('organization/save-holiday-list', 'App\Http\Controllers\organization\HolidayController@saveHolidayList')->name('organization/save-holiday-list');
Route::get('organization/add-holiday-list/{holiday_id}', 'App\Http\Controllers\organization\HolidayController@getHolidayDtl');
Route::get('organization/delete-holiday-list/{holiday_id}','App\Http\Controllers\organization\HolidayController@deleteHoliday');

Route::get('organization/holiday-type', 'App\Http\Controllers\organization\HolidayController@viewHolidayTypeDetails')->name('organization/holiday-type');
Route::get('organization/add-holiday-type', 'App\Http\Controllers\organization\HolidayController@viewAddHolidayType')->name('organization/add-holiday-type');
Route::post('organization/add-holiday-type', 'App\Http\Controllers\organization\HolidayController@saveHolidayTypeData');
Route::get('organization/add-holiday-type/{holiday_id}', 'App\Http\Controllers\organization\HolidayController@getHolidayTypeDtl');
Route::get('organization/delete-holiday-type/{holiday_id}', 'App\Http\Controllers\organization\HolidayController@deleteHolidayType');
//----------------------------- End Holiday List ---------------------------------



//------------------------------Leave Management --------------------------------------------
Route::get('leave/dashboard', 'App\Http\Controllers\organization\LeaveManagementController@viewdash');


Route::get('leave/leave-type-listing', 'App\Http\Controllers\organization\LeaveManagementController@getLeaveType')->name('leave/leave-type-listing');
Route::get('leave/leave-type-listing/{holiday_id}', 'App\Http\Controllers\organization\LeaveManagementController@getLeaveTypeDtl');
Route::get('leave/new-leave-type', 'App\Http\Controllers\organization\LeaveManagementController@viewAddLeaveType')->name('leave/new-leave-type');
Route::post('leave/new-leave-type', 'App\Http\Controllers\organization\LeaveManagementController@saveLeaveType');

Route::get('leave/leave-rule-listing', 'App\Http\Controllers\organization\LeaveManagementController@getLeaveRules');
Route::get('leave/save-leave-rule', 'App\Http\Controllers\organization\LeaveManagementController@leaveRules');
Route::post('leave/save-leave-rule', 'App\Http\Controllers\organization\LeaveManagementController@saveAddLeaveRule');
Route::get('leave/view-leave-rule/{leave_rule_id}', 'App\Http\Controllers\organization\LeaveManagementController@getLeaveRulesById');

Route::get('leave/leave-allocation-listing', 'App\Http\Controllers\organization\LeaveManagementController@getLeaveAllocation');
Route::get('leave/save-leave-allocation', 'App\Http\Controllers\organization\LeaveManagementController@viewAddLeaveAllocation');
Route::post('leave/save-leave-allocation', 'App\Http\Controllers\organization\LeaveManagementController@saveAddLeaveAllocation');
Route::post('leave/get-leave-allocation', 'App\Http\Controllers\organization\LeaveManagementController@getAddLeaveAllocation');

Route::get('leave/leave-balance', 'App\Http\Controllers\organization\LeaveManagementController@getLeaveBalance');
Route::post('leave/leave-balance', 'App\Http\Controllers\organization\LeaveManagementController@spoLeaveBalance');
Route::post('leave/leave-balance-excel', 'App\Http\Controllers\organization\LeaveManagementController@spoLeaveBalanceexcel');

Route::get('leave/leave-report', 'App\Http\Controllers\organization\LeaveManagementController@leaveBalanceView');
Route::post('leave/leave-report', 'App\Http\Controllers\organization\LeaveManagementController@leaveBalanceReport');

Route::get('leave/leave-report-employee', 'App\Http\Controllers\organization\LeaveManagementController@viewleaveemplyee');
Route::post('leave/leave-report-employee', 'App\Http\Controllers\organization\LeaveManagementController@getleaveemplyee');
Route::post('leave/leave-report-employee-wise', 'App\Http\Controllers\organization\LeaveManagementController@postleaveemplyee');
Route::post('leave/leave-report-employee-wise-excel', 'App\Http\Controllers\organization\LeaveManagementController@postleaveemplyeeexcel');

//------------------------------End Leave Management -----------------------------------------
//-------------------------------Change of Circumstances----------------------------------------
Route::get('organization/circumstances','App\Http\Controllers\organization\CircumstanceController@dashboard')->name('organization/circumstances');

//-------------------------------End Cirrcumstances -------------------------------------------------
//----------------------------------- Attendance Mangement ---------------------------------------------
Route::get('attendance-management/dashboard', 'App\Http\Controllers\organization\AttendanceController@dashboard');
Route::get('attendance-management/upload-data', 'App\Http\Controllers\organization\AttendanceController@viewUploadAttendence');
Route::post('attendance-management/upload-data', 'App\Http\Controllers\organization\AttendanceController@importExcel');

Route::get('attendance-management/generate-data', 'App\Http\Controllers\organization\AttendanceController@viewGenerateAttendence');
Route::post('attendance-management/generate-data', 'App\Http\Controllers\organization\AttendanceController@importGenerate');
Route::post('attendance-management/save-generate-attandance', 'App\Http\Controllers\organization\AttendanceController@saveGenerate');

Route::get('attendance-management/daily-attendance', 'App\Http\Controllers\organization\AttendanceController@viewattendancedaily');
Route::post('attendance-management/daily-attendance', 'App\Http\Controllers\organization\AttendanceController@getDailyAttandance');
Route::get('attendance-management/edit-daily/{daily_id}', 'App\Http\Controllers\organization\AttendanceController@getDailyAttandancedetails');
Route::post('attendance-management/edit-daily', 'App\Http\Controllers\organization\AttendanceController@saveDailyAttandancedetails');

Route::get('attendance-management/attendance-report', 'App\Http\Controllers\organization\AttendanceController@viewattendancereport');
Route::post('attendance-management/attendance-report', 'App\Http\Controllers\organization\AttendanceController@getReportAttandance');
Route::post('attendance-management/attendance-month-report', 'App\Http\Controllers\organization\AttendanceController@importdtaa');
// pdf pending

Route::get('attendance-management/process-attendance', 'App\Http\Controllers\organization\AttendanceController@viewattendanceprocess');
Route::post(' attendance-management/process-attendance', 'App\Http\Controllers\organization\AttendanceController@getprocessAttandance');
Route::post('attendance-management/save-Process-Attandance', 'App\Http\Controllers\organization\AttendanceController@saveProcessAttandance');

Route::get('attendance-management/absent-report', 'App\Http\Controllers\organization\AttendanceController@viewattendanabsent');
Route::post('attendance-management/absent-report', 'App\Http\Controllers\organization\AttendanceController@getattendanabsent');
//------------------------------------ End Attendance Management -------------------------------------

//------------------------------------- Rota ---------------------------------------------------
Route::get('rota-org/dashboard','App\Http\Controllers\organization\RotaController@dashboard')->name('rota-dashboard');
Route::get('rota-org/shift-management', 'App\Http\Controllers\organization\RotaController@viewshift');
Route::get('rota-org/add-shift-management', 'App\Http\Controllers\organization\RotaController@viewAddNewShift');
Route::post('rota-org/add-shift-management', 'App\Http\Controllers\organization\RotaController@saveShiftData');
Route::get('rota-org/delete-shift-management/{id}', 'App\Http\Controllers\organization\RotaController@shiftDeleted');

Route::get('rota-org/late-policy', 'App\Http\Controllers\organization\RotaController@viewlate');
Route::get('rota-org/add-late-policy', 'App\Http\Controllers\organization\RotaController@viewAddNewlate');
Route::post('rota-org/add-late-policy', 'App\Http\Controllers\organization\RotaController@savelateData');

Route::get('rota-org/offday', 'App\Http\Controllers\organization\RotaController@viewoffday');
Route::get('rota-org/add-offday', 'App\Http\Controllers\organization\RotaController@viewAddNewoffday');
Route::post('rota-org/add-offday', 'App\Http\Controllers\organization\RotaController@saveoffdayData');

Route::get('rota-org/grace-period', 'App\Http\Controllers\organization\RotaController@viewgrace');
Route::get('rota-org/add-grace-period', 'App\Http\Controllers\organization\RotaController@viewAddNewgrace');
Route::post('rota-org/add-grace-period', 'App\Http\Controllers\organization\RotaController@savegraceData');

Route::get('rota-org/duty-roster','App\Http\Controllers\organization\RotaController@viewroster');
Route::post('rota-org/add-duty-roster', 'App\Http\Controllers\organization\RotaController@saverosterData');
Route::get('rota-org/add-employee-duty', 'App\Http\Controllers\organization\RotaController@viewAddNewemployeeduty');
Route::post('rota-org/add-employee-duty', 'App\Http\Controllers\organization\RotaController@saveemployeedutyData');
Route::get('rota-org/add-department-duty', 'App\Http\Controllers\organization\RotaController@viewAddNewdepartmentduty');
Route::post('rota-org/add-department-duty', 'App\Http\Controllers\organization\RotaController@savedepartmentdutyData');

Route::get('rota-org/module-dashboard', 'App\Http\Controllers\organization\RotaController@linkDashboard');
Route::get('rota-org/visitor-link', 'App\Http\Controllers\organization\RotaController@viewvisitorlink');

Route::get('rota-org/visitor-regis', 'App\Http\Controllers\organization\RotaController@viewvisitorregis');
Route::get('rota-org/visitor-regis-edit/{id}', 'App\Http\Controllers\organization\RotaController@eitvisitorregisterlist');
Route::post('rota-org/visitor-edit', 'App\Http\Controllers\organization\RotaController@eitvisitorregistersave');
Route::get('rota-org/visitor-regis-deleted/{id}', 'App\Http\Controllers\organization\RotaController@visitorDeleted');



//-------------------------------------End Rota--------------------------------------------------

//-------------------------------------- File Manager -----------------------------------------------
Route::get('file-management/dashboard', 'App\Http\Controllers\organization\FilemanagmentControler@dashboard')->name('file-management/dashboard');
Route::get('file-management/file-devision-list', 'App\Http\Controllers\organization\FilemanagmentControler@filedivisionlist');
Route::get('file-management/fileManagment-division-add', 'App\Http\Controllers\organization\FilemanagmentControler@filedivisionView');
Route::post('file-management/fileManagment-division-adds', 'App\Http\Controllers\organization\FilemanagmentControler@filedivisionadd');
Route::get('file-management/edit-file-devision/{id}', 'App\Http\Controllers\organization\FilemanagmentControler@filedivisionViewedit');
Route::post('file-management/fileManagment-division-update', 'App\Http\Controllers\organization\FilemanagmentControler@filedivisionViewupdate');

Route::get('file-management/fileManagmentList', 'App\Http\Controllers\organization\FilemanagmentControler@fileManagmentList');
Route::get('file-management/folder-create/{id}', 'App\Http\Controllers\organization\FilemanagmentControler@folderCreate');
Route::get('file-management/fileManagment-add', 'App\Http\Controllers\organization\FilemanagmentControler@fileManagmentView');
Route::post('file-management/fileManagment-save', 'App\Http\Controllers\organization\FilemanagmentControler@savefilemanagment');
Route::get('file-management/report-excel', 'App\Http\Controllers\FilemanagmentControler@excelreport');

//-------------------------------------- End File Management --------------------------------------------

// -----------------------------------------Leave Approver --------------------------------------------------
Route::get('leaveapprover/leave-dashboard', 'App\Http\Controllers\organization\LeaveApproverController@dashboard')->name('leave-approver/dashboard');
Route::get('leaveapprover/leave-request', 'App\Http\Controllers\organization\LeaveApproverController@viewLeaveApproved');

//----------------------------------------- End Leave Approver -----------------------------------------------

// -----------------------------------------Employee Corner --------------------------------------------------
Route::get('org-user-check-employee', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@indexserorganisationemployee');
Route::post('org-user-check-employee', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@DoLoginorganisationemployee');
Route::get('org-employeecornerorganisationdashboard', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewdash');
Route::get('org-employee-corner-organisation/user-profile', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewdetadash');

Route::get('org-employee-corner/holiday', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewdetaholiday');

Route::get('org-employee-corner/work-update', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewworkupdate');
Route::get('org-employee-corner/add-work-update', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewaddworkupdate');
Route::get('pis/gettimemintuesnew/{in_time}/{out_time}','App\Http\Controllers\organization\EmployeeCornerOrganisationController@gettimemintuesnew');
Route::post('org-employee-corner/task-save', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewtasksave');
Route::get('org-employee-corner/work-edit/{id}', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewaddworkupdateget');
Route::post('org-employee-corner/task-update', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewtaskupdate');

Route::get('org-employee-corner/attendance-status', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@viewAttandancestatus');
Route::post('org-employee-corner/attendance-status', 'App\Http\Controllers\organization\EmployeeCornerOrganisationController@saveAttandancestatus');

// ----------------------------------------- End Employee Corner ---------------------------------------------

//-------------------------------------------- Hr Support ---------------------------------------------------
Route::get('hr-support/dashboard', 'App\Http\Controllers\organization\HrSupportController@viewdashboard')->name('hr-support.dashboard');
Route::get('hr-support/support-file/{id}', 'App\Http\Controllers\organization\HrSupportController@supportFile')->name('support-file.show');
Route::get('hr-support/support-file-details/{id}', 'App\Http\Controllers\organization\HrSupportController@supportFileDetails')->name('support-file.details');

//-------------------------------------------- End Hr Support -----------------------------------------------

//--------------------------------------------- User Access -----------------------------------------------
Route::get('user-access-role/dashboard', 'App\Http\Controllers\organization\UseraceesController@dashboard')->name('user-access/dashboard');
Route::get('user-access-role/vw-users', 'App\Http\Controllers\organization\UseraceesController@viewUserConfig');
Route::get('user-access-role/vw-user-config', 'App\Http\Controllers\organization\UseraceesController@viewUserConfigForm');
Route::get('user-access-role/vw-user-config/{user_id}', 'App\Http\Controllers\organization\UseraceesController@GetUserConfigForm');
Route::post('user-access-role/vw-user-config', 'App\Http\Controllers\organization\UseraceesController@SaveUserConfigForm');

Route::get('user-access-role/view-users-role', 'App\Http\Controllers\organization\UseraceesController@viewUserAccessRights');
Route::get('user-access-role/user-role', 'App\Http\Controllers\organization\UseraceesController@viewUserAccessRightsForm');
Route::post('user-access-role/user-role', 'App\Http\Controllers\organization\UseraceesController@UserAccessRightsFormAuth');
Route::get('user-accessrole/view-users-role/{role_authorization_id}', 'App\Http\Controllers\organization\UseraceesController@deleteUserAccess');
//---------------------------------------------- End User Access ---------------------------------------

//----------------------------------------------- Settings ---------------------------------------------
//Company Bank
Route::get('organization/settings-dashboard','App\Http\Controllers\organization\SettingController@dashboard')->name('settings-dashboard');
Route::get('org-settings/vw-cmp-bank', 'App\Http\Controllers\organization\SettingController@getCompanyBank');
Route::get('org-settings/add-company-bank', 'App\Http\Controllers\organization\SettingController@addComapnyBankAdd');
Route::post('org-settings/add-new-bank-details', 'App\Http\Controllers\organization\SettingController@addcmpbankDetails');
Route::get('org-settings/comapny-bank-edit/{id}', 'App\Http\Controllers\organization\SettingController@cmpbankedit');
Route::post('org-settings/update-cmp-bank-details', 'App\Http\Controllers\organization\SettingController@cmpBankDetailsupdate');
// Employee Bank 
Route::get('org-settings/vw-emp-bank', 'App\Http\Controllers\organization\SettingController@getempBank');
Route::get('org-settings/add-emp-bank', 'App\Http\Controllers\organization\SettingController@addempBankAdd');
Route::post('org-settings/add-new-emp-bank-details', 'App\Http\Controllers\organization\SettingController@addempbankDetails');
Route::get('org-settings/emp-bank-edit/{id}', 'App\Http\Controllers\organization\SettingController@empbankedit');
Route::post('org-settings/update-emp-bank-details', 'App\Http\Controllers\organization\SettingController@empBankDetailsupdate');
//-----------------------------------------------Ifsc Master-------------------------------------------------------
Route::get('org-settings/vw-ifsc', 'App\Http\Controllers\organization\SettingController@getIfsc');
Route::get('org-settings/add-new-ifsc', 'App\Http\Controllers\organization\SettingController@viewAddNewIfsc');
Route::post('org-settings/add-new-ifsc', 'App\Http\Controllers\organization\SettingController@saveIfscData');
Route::get('org-settings/edit-ifsc/{id}','App\Http\Controllers\organization\SettingController@editviewAddNewIfsc');
Route::post('org-settings/update-ifsc','App\Http\Controllers\organization\SettingController@updatesaveIfscData');

//----------------------------------------------- Caste Master---------------------------------------------------------
Route::get('org-settings/vw-caste', 'App\Http\Controllers\organization\SettingController@getCaste');
Route::get('org-settings/add-new-caste', 'App\Http\Controllers\organization\SettingController@viewAddNewCaste');
Route::post('org-settings/add-new-caste', 'App\Http\Controllers\organization\SettingController@saveCasteData');
Route::get('org-settings/edit-cast/{id}', 'App\Http\Controllers\organization\SettingController@castUpdate');
Route::post('org-settings/updateCast', 'App\Http\Controllers\organization\SettingController@updateCast');
//----------------------------------------------- Sub Caste ----------------------------------------------
Route::get('org-settings/vw-subcast', 'App\Http\Controllers\organization\SettingController@subcastGet');
Route::get('org-settings/add-sub-caste', 'App\Http\Controllers\organization\SettingController@addsubcast');
Route::post('org-settings/add-sub-caste', 'App\Http\Controllers\organization\SettingController@saveSubCasteData');
Route::get('org-settings/edit-sub-cast/{id}', 'App\Http\Controllers\organization\SettingController@editSubCast');
Route::post('org-settings/update-sub-cast', 'App\Http\Controllers\organization\SettingController@updateSubCast');
//--------------------------------------------------- Employee Class ----------------------------------------------
Route::get('org-settings/vw-class', 'App\Http\Controllers\organization\SettingController@getClasses');
Route::get('org-settings/edit-classes/{id}', 'App\Http\Controllers\organization\SettingController@getClassesById');
Route::post('org-settings/update-classes', 'App\Http\Controllers\organization\SettingController@updateClassById');
Route::get('org-settings/add-new-class', 'App\Http\Controllers\organization\SettingController@viewAddNewClass');
Route::post('org-settings/add-new-class', 'App\Http\Controllers\organization\SettingController@saveClassData');
//--------------------------------------------------- Pincode Master -------------------------------------------------
Route::get('org-settings/vw-pincode', 'App\Http\Controllers\organization\SettingController@getPincode');
Route::get('org-settings/add-new-pincode', 'App\Http\Controllers\organization\SettingController@viewAddNewPincode');
Route::post('org-settings/add-new-pincode', 'App\Http\Controllers\organization\SettingController@savePincodeData');
Route::get('org-settings/edit-pincode/{id}', 'App\Http\Controllers\organization\SettingController@pincodeGetbyId');
Route::post('org-settings/updatepincode', 'App\Http\Controllers\organization\SettingController@pincodeUpdate');
//-------------------------------------------------- Employee Type Master ----------------------------------------------
Route::get('org-settings/vw-type', 'App\Http\Controllers\organization\SettingController@getType');
Route::get('org-settings/add-new-type', 'App\Http\Controllers\organization\SettingController@viewAddNewType');
Route::post('org-settings/add-new-type', 'App\Http\Controllers\organization\SettingController@saveTypeData');
Route::get('org-settings/edit-type/{id}', 'App\Http\Controllers\organization\SettingController@typeofedit');
Route::post('org-settings/vw-emp-update', 'App\Http\Controllers\organization\SettingController@typeofupdate');
//-------------------------------------------------- Mode Of Employee ----------------------------------------------------
Route::get('org-settings/vw-mode-type', 'App\Http\Controllers\organization\SettingController@getmodeOfEmpType');
Route::get('org-settings/add-mode-emp', 'App\Http\Controllers\organization\SettingController@modeemployeeadd');
Route::post('org-settings/add-mode-emp-new', 'App\Http\Controllers\organization\SettingController@addmodeemployeesucc');
Route::get('org-settings/mode-of-emp-edit/{id}', 'App\Http\Controllers\organization\SettingController@editEmpMode');
Route::post('org-settings/mode-emp-new-update', 'App\Http\Controllers\organization\SettingController@modeEmpUpdate');
//--------------------------------------------- Religion Master -----------------------------------------------------
Route::get('org-settings/vw-religion', 'App\Http\Controllers\organization\SettingController@getReligion');
Route::get('org-settings/add-new-religion', 'App\Http\Controllers\organization\SettingController@viewAddNewReligion');
Route::post('org-settings/add-new-religion', 'App\Http\Controllers\organization\SettingController@saveReligionData');
Route::get('org-settings/edit-new-religion/{id}', 'App\Http\Controllers\organization\SettingController@editViewsaveReligionData');
Route::post('org-settings/update-new-religion', 'App\Http\Controllers\organization\SettingController@updateViewsaveReligionData');
//--------------------------------------------- Education Master ---------------------------------------------------------
Route::get('org-settings/vw-education', 'App\Http\Controllers\organization\SettingController@getEducation');
Route::get('org-settings/add-new-education', 'App\Http\Controllers\organization\SettingController@viewAddNewEducation');
Route::post('org-settings/add-new-education', 'App\Http\Controllers\organization\SettingController@saveEducationData');
Route::get('org-settings/edit-new-education/{id}','App\Http\Controllers\organization\SettingController@editViewEducationData');
Route::post('org-settings/update-new-education', 'App\Http\Controllers\organization\SettingController@editEducationData');
//---------------------------------------------- Department --------------------------------------------------------------
Route::get('org-settings/vw-department', 'App\Http\Controllers\organization\SettingController@getDepartment');
Route::get('org-settings/add-new-department', 'App\Http\Controllers\organization\SettingController@viewAddNewDepartment');
Route::post('org-settings/add-new-department', 'App\Http\Controllers\organization\SettingController@saveDepartmentData');
//---------------------------------------------- Designation -----------------------------------------------
Route::get('org-settings/vw-designation', 'App\Http\Controllers\organization\SettingController@getDesignations');
Route::post('org-settings/designation', 'App\Http\Controllers\organization\SettingController@saveDesignation');
Route::get('org-settings/designation', 'App\Http\Controllers\organization\SettingController@viewAddDesignation');
//---------------------------------------------- Employment Type ---------------------------------------------------
Route::get('org-settings/vw-employee-type', 'App\Http\Controllers\organization\SettingController@getEmployeeTypes');
Route::get('org-settings/employee-type', 'App\Http\Controllers\organization\SettingController@viewAddEmployeeType');
Route::post('org-settings/employee-type', 'App\Http\Controllers\organization\SettingController@saveEmployeeType');
Route::get('org-settings/employee-type/{id}', 'App\Http\Controllers\organization\SettingController@getTypeById');
//------------------------------------------- Pay Group ----------------------------------------------------------
Route::get('org-settings/vw-paygroup', 'App\Http\Controllers\organization\SettingController@getGrades');
Route::get('org-settings/paygroup', 'App\Http\Controllers\organization\SettingController@viewAddGrade');
Route::post('org-settings/paygroup', 'App\Http\Controllers\organization\SettingController@saveGrade');
//--------------------------------------------Annual Pay ------------------------------------------------------------
Route::get('org-settings/vw-annualpay', 'App\Http\Controllers\organization\SettingController@getPayscale');
Route::get('org-settings/annualpay', 'App\Http\Controllers\organization\SettingController@viewAddPayscale');
Route::post('org-settings/annualpay', 'App\Http\Controllers\organization\SettingController@savePayscale');
//-------------------------------------------- Bank Short Code ----------------------------------------------------
Route::get('org-settings/vw-bank-sortcode', 'App\Http\Controllers\organization\SettingController@getBanks');
Route::get('org-settings/bank-sortcode', 'App\Http\Controllers\organization\SettingController@viewAddBank');
Route::post('org-settings/bank-sortcode', 'App\Http\Controllers\organization\SettingController@saveBank');
//------------------------------------------ Payment Type --------------------------------------------
Route::get('org-settings/vw-pay-type', 'App\Http\Controllers\organization\SettingController@getPaytypemaster');
Route::get('org-settings/pay-type', 'App\Http\Controllers\organization\SettingController@viewAddPaytypemaster');
Route::post('org-settings/pay-type', 'App\Http\Controllers\organization\SettingController@savePaytypemaster');
//-------------------------------------------Pay Mode ------------------------------------------------------------
Route::get('org-settings/vw-wedgespay-type', 'App\Http\Controllers\organization\SettingController@getwedgesPaytypemaster');
Route::get('org-settings/wedgespay-type', 'App\Http\Controllers\organization\SettingController@viewAddwedgesPaytypemaster');
Route::post('org-settings/wedgespay-type', 'App\Http\Controllers\organization\SettingController@savewedgesPaytypemaster');
//------------------------------------------------------Tax Master --------------------------------------------------
Route::get('org-settings/vw-tax', 'App\Http\Controllers\organization\SettingController@getTaxmaster');
Route::get('org-settings/tax', 'App\Http\Controllers\organization\SettingController@viewAddTaxmaster');
Route::post('org-settings/tax', 'App\Http\Controllers\organization\SettingController@saveTaxmaster');
//------------------------------------------------End Settings -------------------------------------------
//-----------------------------------------------------Performance Management --------------------------------------------
Route::get('org-performances/dashboard', 'App\Http\Controllers\organization\PerformanceController@dashboard');
Route::get('org-performances', 'App\Http\Controllers\organization\PerformanceController@index');
Route::get('org-performances/request', 'App\Http\Controllers\organization\PerformanceController@performanceRequest');
Route::get('org-performances/request/{id}', 'App\Http\Controllers\organization\PerformanceController@requestEdit');
Route::post('org-performances/request', 'App\Http\Controllers\organization\PerformanceController@submitRequest');
Route::get("org-performances/del/{id}", 'App\Http\Controllers\organization\PerformanceController@destroy');

//----------------------------------------------- End Performance Managemant -----------------------------------------------
//############################################### Task Management #########################################################
Route::get('org-task-management/dashboard','App\Http\Controllers\organization\TaskManagement@index');
Route::get('org-task-management/projects', 'App\Http\Controllers\organization\TaskManagement@projects');
Route::get('org-task-management/create-project', 'App\Http\Controllers\organization\TaskManagement@createProject');
Route::post("org-projects/add", 'App\Http\Controllers\organization\TaskManagement@create');
Route::get('org-task-management/update-project/{id}', 'App\Http\Controllers\organization\TaskManagement@updateProject');
Route::post("org-projects/update", 'App\Http\Controllers\organization\TaskManagement@update');
Route::get("org-projects/del/{id}", 'App\Http\Controllers\organization\TaskManagement@destroy');




//############################################### End Task Managemant ####################################################

//---------------------------------------------Sponsor Compliance------------------------------------------------------------
Route::get('org-dashboarddetails', 'App\Http\Controllers\organization\DashboardController@getamployeedas');
Route::get('org-dashboard-employees', 'App\Http\Controllers\organization\DashboardController@getEmployees');
Route::get('org-dashboard-migrant-employees', 'App\Http\Controllers\organization\DashboardController@getEmployeesmigrant');
Route::get('org-dashboard-right-works', 'App\Http\Controllers\organization\DashboardController@getEmployeesright');
Route::get('org-add-right-works-by-datecheck', 'App\Http\Controllers\organization\DashboardController@addEmployeesrightByDate');
Route::get('org-dashboard/key-contact', 'App\Http\Controllers\organization\DashboardController@getCompaniesofficerkey');
Route::get('org-dashboard/sponsor-management-dossier', 'App\Http\Controllers\organization\DashboardController@getEmployeesdossier');
Route::get('org-dashboard/message-center', 'App\Http\Controllers\organization\DashboardController@viewmsgcen');
Route::post('org-document/staff-report-excel', 'App\Http\Controllers\organization\DashboardController@reportEmployeesexcelstaff');
Route::get('org-dashboard/absent-report', 'App\Http\Controllers\organization\DashboardController@viewattendanabsent');
Route::post('org-dashboard/absent-report', 'App\Http\Controllers\organization\DashboardController@getattendanabsent');
Route::get('org-dashboard/absent-record-card/{absent_id}/{year_value}', 'App\Http\Controllers\organization\DashboardController@viewattendanabsentreport');
Route::get('org-dashboard/absent-record-card-pdf/{absent_id}/{year_value}', 'App\Http\Controllers\organization\DashboardController@viewattendanabsentreportpdf');
Route::get('org-dashboard/change-of-circumstances', 'App\Http\Controllers\organization\DashboardController@viewchangecircumstancesedit')->name('org-dashboard/change-of-circumstances');
Route::post('org-dashboard/change-of-circumstances', 'App\Http\Controllers\organization\DashboardController@savechangecircumstancesedit');
Route::get('org-dashboard/contract-agreement', 'App\Http\Controllers\organization\DashboardController@viewemployeeagreement');
Route::post('org-dashboard/contract-agreement', 'App\Http\Controllers\organization\DashboardController@saveemployeeagreement');

//-----------------------------------------End Sponsor Compliance --------------------------------------------------------

// --------------------------------Start Recruitment Section ---------------------------------------------------------------
Route::get('sample', 'App\Http\Controllers\organization\RecruitmentController@sample')->name('sample');
Route::get('recruitment/job_list', 'App\Http\Controllers\organization\RecruitmentController@jobList')->name('recruitment.job-list');
Route::get('recruitment/dashboard', 'App\Http\Controllers\organization\RecruitmentController@dashboard')->name('recruitment.dashboard');
// Route::get('recruitment/job_applied', 'App\Http\Controllers\organization\RecruitmentController@appliedjob')->name('recruitment.job-applied');

//Route::get('recruitment/add-job-list', 'App\Http\Controllers\organization\RecruitmentController@addJobList')->name('recruitment.add-job-list');


Route::get('recruitment/job_posting', 'App\Http\Controllers\organization\RecruitmentController@jobPosting')->name('recruitment.job-posting');
Route::get('recruitment/job_published', 'App\Http\Controllers\organization\RecruitmentController@jobPublished')->name('recruitment.job-published');
// Route::get('recruitment/job_applied', 'App\Http\Controllers\organization\RecruitmentController@jobApplied')->name('recruitment.job-applied');
// Route::get('recruitment/short_listing', 'App\Http\Controllers\organization\RecruitmentController@shortListing')->name('recruitment.short-listing');
// Route::get('recruitment/interview_result', 'App\Http\Controllers\organization\RecruitmentController@interview')->name('recruitment.interview_result');
// Route::get('recruitment/hired_list', 'App\Http\Controllers\organization\RecruitmentController@hired')->name('recruitment.hired-list');
// Route::get('recruitment/offer_letter', 'App\Http\Controllers\organization\RecruitmentController@offerLetter')->name('recruitment.offer-letter');
// Route::get('recruitment/rejected', 'App\Http\Controllers\organization\RecruitmentController@rejected')->name('recruitment.rejected');

Route::get('recruitment/edit_candidate/{candidate_id}', 'App\Http\Controllers\organization\RecruitmentController@candidateDetailsView')->name('edit-candidates');
Route::post('recruitment/edit_candidate', 'App\Http\Controllers\RecruitmentController@savecandidatedetails');


Route::get('org-recruitment/job-list', 'App\Http\Controllers\organization\RecruitmentController@viewjoblist');
Route::get('org-recruitment/soccode/{id}', 'App\Http\Controllers\organization\RecruitmentController@soccodess');
Route::get('org-recruitment/add-job-list', 'App\Http\Controllers\organization\RecruitmentController@viewAddNewJobList');
Route::post('org-recruitment/add-job-list', 'App\Http\Controllers\organization\RecruitmentController@saveJobListData');

Route::get('org-recruitment/add-job-post', 'App\Http\Controllers\organization\RecruitmentController@viewAddNewJobPost');
Route::post('org-recruitment/add-job-post', 'App\Http\Controllers\organization\RecruitmentController@saveJobPostData');

Route::get('org-recruitment/add-job-published', 'App\Http\Controllers\organization\RecruitmentController@viewAddNewpublished');
Route::post('org-recruitment/add-job-published', 'App\Http\Controllers\organization\RecruitmentController@saveJobpublishedData');

Route::get('org-recruitment/candidate', 'App\Http\Controllers\organization\RecruitmentController@viewcandidate');
Route::get('org-recruitment/edit-candidate/{candidate_id}', 'App\Http\Controllers\organization\RecruitmentController@viewcandidatedetails');
Route::post('org-recruitment/edit-candidate', 'App\Http\Controllers\organization\RecruitmentController@savecandidatedetails');
Route::get('org-recruitment/send-letter-job-applied/{send_id}', 'App\Http\Controllers\organization\RecruitmentController@viewsendcandidatedetailsjobapplied');

Route::get('org-recruitment/short-listing', 'App\Http\Controllers\organization\RecruitmentController@viewshortcandidate');
Route::get('org-recruitment/edit-short-listing/{short_id}', 'App\Http\Controllers\organization\RecruitmentController@viewshortcandidatedetails');
Route::post('org-recruitment/edit-short-listing', 'App\Http\Controllers\organization\RecruitmentController@saveshortcandidatedetails');

Route::get('org-recruitment/interview', 'App\Http\Controllers\organization\RecruitmentController@viewinterviewcandidate');
Route::get('org-recruitment/edit-interview/{interview_id}', 'App\Http\Controllers\organization\RecruitmentController@viewinterviewcandidatedetails');
Route::post('org-recruitment/edit-interview', 'App\Http\Controllers\organization\RecruitmentController@saveinterviewcandidatedetails');

Route::get('org-recruitment/hired', 'App\Http\Controllers\organization\RecruitmentController@viewhiredcandidate');

Route::get('org-recruitment/offer-letter', 'App\Http\Controllers\organization\RecruitmentController@viewsoffercandidate');
Route::get('org-recruitment/generate-letter', 'App\Http\Controllers\organization\RecruitmentController@viewsofferlattercandidate');
Route::post('org-recruitment/edit-offer-letter', 'App\Http\Controllers\organization\RecruitmentController@saveofferlat');

Route::get('org-recruitment/search', 'App\Http\Controllers\organization\RecruitmentController@viewsearchcandidate');
Route::post('org-recruitment/search', 'App\Http\Controllers\organization\RecruitmentController@getsearchcandidate');

Route::get('org-recruitment/status-search', 'App\Http\Controllers\organization\RecruitmentController@viewsearchcandidatestatus');
Route::post('org-recruitment/status-search', 'App\Http\Controllers\organization\RecruitmentController@getsearchcandidatestatus');
Route::post('org-recruitment/status-search-result', 'App\Http\Controllers\organization\RecruitmentController@savesearchopstatus');
Route::post('org-recruitment/status-search-result-excel', 'App\Http\Controllers\organization\RecruitmentController@savesearchopexcelstatus');

Route::get('org-recruitment/reject', 'App\Http\Controllers\organization\RecruitmentController@viewrejectcandidate');
Route::get('org-recruitment/edit-reject/{reject_id}', 'App\Http\Controllers\organization\RecruitmentController@viewrejectcandidatedetails');
Route::post('org-recruitment/edit-reject', 'App\Http\Controllers\organization\RecruitmentController@saverejectcandidatedetails');

Route::get('org-recruitment/message-centre', 'App\Http\Controllers\organization\RecruitmentController@viewmsgcen');
Route::get('org-recruitment/add-message-centre', 'App\Http\Controllers\organization\RecruitmentController@addmscen');
Route::post('org-recruitment/add-message-centre', 'App\Http\Controllers\organization\RecruitmentController@savemscen');


//-----------------------------End Recruitment Section -------------------------------------------------------------


// old route
Route::get('/', 'App\Http\Controllers\LandingController@index');
Route::get('login-pay', 'App\Http\Controllers\LandingController@indexloginpay');
Route::post('login-pay', 'App\Http\Controllers\LandingController@DoLoginpay');
Route::get('login-pay-register', 'App\Http\Controllers\LandingController@payregister');
Route::get('old-payment-recipt', 'App\Http\Controllers\AdminController@oldpaymentrecipt');
Route::post('login-pay-register', 'App\Http\Controllers\LandingController@Dopayregister');

Route::get('login-pay-forgot-password', 'App\Http\Controllers\LandingController@indexpayfor');
Route::post('login-pay-forgot-password', 'App\Http\Controllers\LandingController@Dopayforgot');

Route::get('register/{org_code?}', 'App\Http\Controllers\LandingController@register');
Route::get('/get-country-code','App\Http\Controllers\LandingController@getCountryCode')->name('get-country-code');

//Route::get('employerdashboard','LandingController@employerdashboard');
Route::post('register', 'App\Http\Controllers\LandingController@Doregister');
// Route::get('forgot-password', 'App\Http\Controllers\LandingController@indexfor');
// Route::post('forgot-password', 'App\Http\Controllers\LandingController@Doforgot');
Route::post('/', 'App\Http\Controllers\LandingController@DoLogin');
Route::get('otpvalidate', 'App\Http\Controllers\LandingController@otp');
Route::post('otpvalidate', 'App\Http\Controllers\LandingController@otpvalidate');
Route::get('otpsend', 'App\Http\Controllers\LandingController@otpsend');
Route::get('employerdashboard', 'App\Http\Controllers\LandingController@Dashboard')->name('home');
//payroll dashboard
Route::get('payroll-home-dashboard', 'App\Http\Controllers\HomeController@Dashboard');





/** getEmplyees by dept  */
Route::post('getEmployeeByDept', 'App\Http\Controllers\PerformanceManagement\PerformanceController@getEmployeesByDept');
Route::post('getEmployeeDetails', 'App\Http\Controllers\PerformanceManagement\PerformanceController@getEmployeeDetails');

/** Perfomance Management Routes */
Route::get('performances', 'App\Http\Controllers\PerformanceManagement\PerformanceController@index');
Route::get('performances/request', 'App\Http\Controllers\PerformanceManagement\PerformanceController@request');
Route::get('performances/request/{id}', 'App\Http\Controllers\PerformanceManagement\PerformanceController@requestEdit');
Route::post('performances/request', 'App\Http\Controllers\PerformanceManagement\PerformanceController@submitRequest');
Route::get("performances/del/{id}", 'App\Http\Controllers\PerformanceManagement\PerformanceController@destroy');
/******** Task Management Routes */
Route::get('task-management/dashboard', 'App\Http\Controllers\TaskManagement\TaskManagement@index');
Route::get('task-management/projects', 'App\Http\Controllers\TaskManagement\TaskManagement@projects');
Route::get('task-management/create-project', 'App\Http\Controllers\TaskManagement\TaskManagement@createProject');
Route::get('task-management/update-project/{id}', 'App\Http\Controllers\TaskManagement\TaskManagement@updateProject');
Route::get('task-management/save-project', 'App\Http\Controllers\TaskManagement\TaskManagement@saveProject');
Route::get('task-management/{id}/project-members', 'App\Http\Controllers\TaskManagement\MembersController@index');
Route::post('task-management/{id}/project-members', 'App\Http\Controllers\TaskManagement\MembersController@submitMember');
Route::get('task-management/{id}/project-members/{member_id}', 'App\Http\Controllers\TaskManagement\MembersController@removeMember');
Route::get('task-management/{id}/project-members-add', 'App\Http\Controllers\TaskManagement\MembersController@addMember');
Route::get('task-management/{id}/tasks', 'App\Http\Controllers\TaskManagement\TaskController@dashboard');
Route::get('task-management/{id}/labels', 'App\Http\Controllers\TaskManagement\LabelController@index');
// Route::get('task-management/{id}/label-add', 'TaskManagement\LabelController@add');
Route::post('task-management/{id}/labels', 'App\Http\Controllers\TaskManagement\LabelController@submit');
Route::get('task-management/{id}/label-del/{label_id}', 'App\Http\Controllers\TaskManagement\LabelController@deleteLabel');
Route::get('task-management/{id}/roles', 'App\Http\Controllers\TaskManagement\RolesController@index');
Route::get('task-management/{id}/role-del/{role_id}', 'App\Http\Controllers\TaskManagement\RolesController@delete');
Route::post('task-management/{id}/roles', 'App\Http\Controllers\TaskManagement\RolesController@submit');
// Route::post('task-management/{id}/tasks', 'TaskManagement\TaskController@create');


Route::post("projects/add", 'App\Http\Controllers\TaskManagement\ProjectController@create');
Route::post("projects/update", 'App\Http\Controllers\TaskManagement\ProjectController@update');
Route::get("projects/get", 'App\Http\Controllers\TaskManagement\ProjectController@show');
Route::get("projects/del/{id}", 'App\Http\Controllers\TaskManagement\ProjectController@destroy');
Route::post("tasks/add", 'App\Http\Controllers\TaskManagement\TaskController@create');
Route::post("tasks/update", 'App\Http\Controllers\TaskManagement\TaskController@update');
Route::post("tasks/updateStatus", 'App\Http\Controllers\TaskManagement\TaskController@updateStatus');
Route::get("tasks/getDetails/{id}", 'App\Http\Controllers\TaskManagement\TaskController@getTaskById');
Route::get("tasks/del/{id}", 'App\Http\Controllers\TaskManagement\TaskController@destroy');
Route::post("comments/add", 'App\Http\Controllers\TaskManagement\TaskCommentsController@create');
Route::get("comments/get", 'App\Http\Controllers\TaskManagement\TaskCommentsController@show');
Route::get("comments/del/{id}", 'App\Http\Controllers\TaskManagement\TaskCommentsController@destroy');






Route::get('user-check-employee', 'App\Http\Controllers\EmployeeCornerOrganisationController@indexserorganisationemployee');
Route::post('user-check-employee', 'App\Http\Controllers\EmployeeCornerOrganisationController@DoLoginorganisationemployee');
Route::get('employeecornerorganisationdashboard', 'App\Http\Controllers\EmployeeCornerOrganisationController@viewdash');

Route::get('employee-corner-organisation/user-profile', 'App\Http\Controllers\EmployeeCornerOrganisationController@viewdetadash');
Route::get('employee-corner-organisation/holiday', 'App\Http\Controllers\EmployeeCornerOrganisationController@viewdetaholiday');

Route::get('employee-corner-organisation/attendance-status', 'App\Http\Controllers\EmployeeCornerOrganisationController@viewAttandancestatus');

Route::post('employee-corner-organisation/attendance-status', 'App\Http\Controllers\EmployeeCornerOrganisationController@saveAttandancestatus');

Route::get('employee-corner-organisation/change-of-circumstances', 'App\Http\Controllers\EmployeeCornerOrganisationController@viewchangecircumstances');

Route::get('employee-corner-organisation/contract-agreement', 'App\Http\Controllers\EmployeeCornerOrganisationController@viewemployeeagreement');

Route::get('superadmin', 'App\Http\Controllers\AdminController@index');
Route::post('superadmin', 'App\Http\Controllers\AdminController@DoLogin');
Route::get('adminotpvalidate', 'App\Http\Controllers\AdminController@otp');
Route::post('adminotpvalidate', 'App\Http\Controllers\AdminController@otpvalidate');
Route::get('adminotpsend', 'App\Http\Controllers\AdminController@otpsend');
Route::get('user-login', 'App\Http\Controllers\LandingController@indexser');
Route::get('user-check-organisation', 'App\Http\Controllers\LandingController@indexserorganisation');
Route::post('user-check-organisation', 'App\Http\Controllers\LandingController@DoLoginorganisation');
Route::post('user-login', 'App\Http\Controllers\LandingController@DoLoginuser');
Route::get('superadmindasboard', 'App\Http\Controllers\AdminController@Dashboard');
Route::get('superadminLogout', 'App\Http\Controllers\AdminController@Logout');
Route::get('superadmin/company', 'App\Http\Controllers\AdminController@getCompanies');
Route::get('superadmin/employer-list', 'App\Http\Controllers\AdminController@getemployerjob');
Route::get('superadmin/fresher', 'App\Http\Controllers\AdminController@getfresherjob');
Route::get('superadmin/experience', 'App\Http\Controllers\AdminController@getexperiencejob');
Route::get('superadmin/delete-blog/{blog}', 'App\Http\Controllers\AdminController@deleteBlog');

Route::get('superadmin/package', 'App\Http\Controllers\AdminController@getpackageTypes');
Route::get('superadmin/add-package', 'App\Http\Controllers\AdminController@viewAddpackageType');
Route::post('superadmin/add-package', 'App\Http\Controllers\AdminController@savepackageType');
Route::get('superadmin/add-package/{id}', 'App\Http\Controllers\AdminController@getpackageId');

//******* Hr File Supprot Start *********//

//Superadmin part
Route::get('superadmin/hr-support-file-type', 'App\Http\Controllers\HrSupport\HrSupportController@hrSupportFiletype');
Route::get('superadmin/add-hr-support-file-type', 'App\Http\Controllers\HrSupport\HrSupportController@addHrSupportFile');
Route::post('superadmin/add-hr-support-file-type', 'App\Http\Controllers\HrSupport\HrSupportController@storeOrUpdateHrSupportFileType');
Route::get('superadmin/edit-hr-support-file-type/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@editHrSupportFileType')->name('edit-hr-support-file-type');
Route::get('superadmin/delete-hr-support-file-type/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@deleteHrSupportFileType')->name('delete-hr-support-file-type');
Route::get('superadmin/get-hr-support-file-type/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@getHrSupportFileType');

Route::get('superadmin/hr-support-files', 'App\Http\Controllers\HrSupport\HrSupportController@hrSupportFile');
Route::get('superadmin/add-hr-support-file', 'App\Http\Controllers\HrSupport\HrSupportController@addHrSupport');
Route::post('superadmin/add-hr-support-file', 'App\Http\Controllers\HrSupport\HrSupportController@storeOrUpdateHrSupportFile');
Route::get('superadmin/edit-hr-support-file/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@editHrSupportFile')->name('edit-hr-support-file');
Route::get('superadmin/delete-hr-support-file/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@deleteHrSupportFile')->name('delete-hr-support-file');
Route::get('superadmin/get-hr-support-file/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@getHrSupportFile');


//Hr support for organization
Route::get('hrsupport/dashboard', 'App\Http\Controllers\HrSupport\HrSupportController@viewdashboard')->name('hrsupport.dashboard');
Route::get('hrsupport/support-file/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@supportFile')->name('supportfile.show');
Route::get('hrsupport/support-file-details/{id}', 'App\Http\Controllers\HrSupport\HrSupportController@supportFileDetails')->name('supportfile.details');


//******* Hr File Supprot End *********//


//******* Routes with  attendance start *********//
Route::get('attendance/dashboard', 'App\Http\Controllers\Attendance\UploadAttendenceController@viewdashboard');
Route::get('attendance/upload-data', 'App\Http\Controllers\Attendance\UploadAttendenceController@viewUploadAttendence');
Route::post('attendance/upload-data', 'App\Http\Controllers\Attendance\UploadAttendenceController@importExcel');
// Route::get('attendance/process-attendance', 'App\Http\Controllers\Attendance\ProcessAttendanceController@viewProcessAttendance');
// Route::post('attendance/process-attendance', 'App\Http\Controllers\Attendance\ProcessAttendanceController@getProcessAttandance');
Route::post('attendance/add-process-attendance', 'App\Http\Controllers\Attendance\ProcessAttendanceController@updateDailyProcessAttendance');
Route::post('attendance/save-Process-Attandance', 'App\Http\Controllers\Attendance\ProcessAttendanceController@saveProcessAttandance');


//******* Routes with attendance end *********//

//add process attendance
Route::get('attendance/add-montly-attendance-data-all', 'App\Http\Controllers\Attendance\ProcessAttendanceController@addMonthlyAttendancePAAllemployee');
Route::post('attendance/add-montly-attendance-data-all', 'App\Http\Controllers\Attendance\ProcessAttendanceController@listAttendanceAllemployee');
Route::post('attendance/save-montly-attendance-data-all', 'App\Http\Controllers\Attendance\ProcessAttendanceController@SaveAttendanceAllemployee');
Route::get('attendance/view-montly-attendance-data-all', 'App\Http\Controllers\Attendance\ProcessAttendanceController@viewMonthlyAttendanceAllemployee')->name('attendance.view-montly-attendance-data-all');
Route::post('attendance/view-montly-attendance-data-all', 'App\Http\Controllers\Attendance\ProcessAttendanceController@listMonthlyAttendanceAllemployee');
Route::post('attendance/update-montly-attendance-data-all', 'App\Http\Controllers\Attendance\ProcessAttendanceController@UpdateAttendanceAllemployee');

Route::get('attendance/vw-montly-attendance/export', 'App\Http\Controllers\Attendance\ProcessAttendanceController@getMonthlyAttendanceExport')->name('attendance.vw-montly-attendance.export');
Route::post('attendance/vw-montly-attendance/import', 'App\Http\Controllers\Attendance\ProcessAttendanceController@getMonthlyAttendanceImport')->name('attendance.vw-montly-attendance.import');

Route::get('attendance/report-monthly-attendance', 'App\Http\Controllers\Attendance\ProcessAttendanceController@reportMonthlyAttendanceAllemployee');
Route::post('attendance/report-monthly-attendance', 'App\Http\Controllers\Attendance\ProcessAttendanceController@getMonthlyAttendanceReport');
Route::post('attendance/xls-export-attendance-report', 'App\Http\Controllers\Attendance\ProcessAttendanceController@attandence_xlsexport');

//loan routes start
Route::get('loans/view-loans', 'App\Http\Controllers\Loan\LoanController@viewLoan');
Route::get('loans/add-loan', 'App\Http\Controllers\Loan\LoanController@addLoan');
Route::post('loans/save-loan', 'App\Http\Controllers\Loan\LoanController@saveLoan');
Route::get('loans/edit-loan/{id}', 'App\Http\Controllers\Loan\LoanController@editLoan');
Route::post('loans/update-loan', 'App\Http\Controllers\Loan\LoanController@updateLoan');
Route::post('loans/xls-export-loan-list', 'App\Http\Controllers\Loan\LoanController@loan_list_xlsexport');
Route::get('loans/adjust-loan/{id}', 'App\Http\Controllers\Loan\LoanController@adjustLoan');
Route::post('loans/update-loan-adjustment', 'App\Http\Controllers\Loan\LoanController@updateLoanAdjustment');
Route::get('loans/view-adjust-loan/{id}', 'App\Http\Controllers\Loan\LoanController@viewAdjustLoan');
Route::get('loans/adjustment-report', 'App\Http\Controllers\Loan\LoanController@loanAdjustmentReport');
Route::post('loans/xls-export-adjustment-report', 'App\Http\Controllers\Loan\LoanController@adjustment_report_xlsexport');


//loan routes end

//payroll start
Route::get('payroll/dashboard', 'App\Http\Controllers\Payroll\PayrollGenerationController@payrollDashboard');

    //coop
    Route::get('payroll/vw-montly-coop', 'App\Http\Controllers\Payroll\PayrollGenerationController@getMonthlyCoopDeduction');
    Route::post('payroll/vw-montly-coop', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewMonthlyCoopDeduction');
    Route::get('payroll/add-montly-coop-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@addMonthlyCoopDeductionAllemployee');
    Route::post('payroll/vw-add-coop-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@listCoopAllemployee');
    Route::post('payroll/save-coop-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@SaveCoopAll');
    Route::post('payroll/update-coop-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@UpdateCoopAll');
    Route::get('payroll/vw-montly-coop/export', 'App\Http\Controllers\Payroll\PayrollGenerationController@getMonthlyCoopDeductionExport')->name('payroll.vw-montly-coop.export');
    Route::post('payroll/vw-montly-coop/import', 'App\Http\Controllers\Payroll\PayrollGenerationController@getMonthlyCoopDeductionImport')->name('payroll.vw-montly-coop.import');

    //incometax
    Route::get('payroll/vw-montly-itax', 'App\Http\Controllers\Payroll\PayrollGenerationController@getMonthlyItaxDeduction');
    Route::post('payroll/vw-montly-itax', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewMonthlyItaxDeduction');
    Route::get('payroll/add-montly-itax-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@addMonthlyItaxDeductionAllemployee');
    Route::post('payroll/vw-add-itax-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@listItaxAllemployee');
    Route::post('payroll/save-itax-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@SaveItaxAll');
    Route::post('payroll/update-itax-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@UpdateItaxAll');

    //generate allowances
    Route::get('payroll/vw-montly-allowances', 'App\Http\Controllers\Payroll\PayrollGenerationController@getMonthlyEarningAllowances');
    Route::post('payroll/vw-montly-allowances', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewMonthlyEarningAllowances');
    Route::get('payroll/add-montly-allowances', 'App\Http\Controllers\Payroll\PayrollGenerationController@addMonthlyAllowancesAllemployee');
    Route::post('payroll/vw-add-allowances-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@listAllowancesAllemployee');
    Route::post('payroll/save-allowances-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@SaveAllowancesAll');
    Route::post('payroll/update-allowances-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@UpdateAllowancesAll');

    //generate overtime
    Route::get('payroll/vw-montly-overtime', 'App\Http\Controllers\Payroll\PayrollGenerationController@getMonthlyOvertimes');
    Route::post('payroll/vw-montly-overtimes', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewMonthlyOvertimes');
    Route::get('payroll/add-montly-overtimes', 'App\Http\Controllers\Payroll\PayrollGenerationController@addMonthlyOvertimesAllemployee');
    Route::post('payroll/vw-add-overtimes-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@listOvertimesAllemployee');
    Route::post('payroll/save-overtimes-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@SaveOvertimesAll');
    Route::post('payroll/update-overtimes-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@UpdateOvertimesAll');

    //Single Payroll Generation
    Route::get('payroll/dashboard', 'App\Http\Controllers\Payroll\PayrollGenerationController@payrollDashboard');
    Route::get('payroll/vw-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@getPayroll');
    Route::post('payroll/vw-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@showPayroll');
    // Route::post('payroll/xls-export-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@payroll_xlsexport');
    Route::get('payroll/add-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewPayroll');
    Route::post('payroll/add-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@savePayrollDetails');
    Route::get('payroll/getEmployeePayrollById/{empid}/{month}/{year}', 'App\Http\Controllers\Payroll\PayrollGenerationController@empPayrollAjax');
    //Bulk  Payroll Generation
    Route::get('payroll/vw-payroll-generation-all-employee', 'App\Http\Controllers\Payroll\PayrollGenerationController@getPayrollallemployee');
    Route::post('payroll/vw-payroll-generation-all-employee', 'App\Http\Controllers\Payroll\PayrollGenerationController@showPayrollallemployee');
    Route::get('payroll/add-generate-payroll-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@addPayrollallemployee');
    Route::post('payroll/vw-generate-payroll-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@listPayrollallemployee');
    Route::post('payroll/save-payroll-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@SavePayrollAll');

    Route::get('payroll/vw-process-payroll', 'App\Http\Controllers\Payroll\PayrollGenerationController@getProcessPayroll');
    Route::post('payroll/vw-process-payroll', 'App\Http\Controllers\Payroll\PayrollGenerationController@vwProcessPayroll');
    Route::post('payroll/edit-process-payroll', 'App\Http\Controllers\Payroll\PayrollGenerationController@updateProcessPayroll');
    Route::get('pis/payrolldelete/{payroll_id}', 'App\Http\Controllers\Payroll\PayrollGenerationController@deletePayroll');

    //pf opening
    Route::get('payroll/pf-opening-balance', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewPfOpeningBalance');
    Route::post('payroll/upload-pf-opening-balance', 'App\Http\Controllers\Payroll\PayrollGenerationController@importPfOpeningBalance');

    //salary adjustment
    Route::get('payroll/vw-adjustment-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@getAdjustPayroll');
    Route::get('payroll/adjustment-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewAdjustPayroll');
    Route::post('payroll/adjustment-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@saveAdjustmentPayrollDetails');

    //without payslip - voucher payroll entry
    Route::get('payroll/vw-voucher-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@getVoucherPayroll');
    Route::get('payroll/voucher-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewVoucherPayroll');
    Route::post('payroll/voucher-payroll-generation', 'App\Http\Controllers\Payroll\PayrollGenerationController@saveVoucherPayroll');

    //yearly bonus input
    Route::get('payroll/vw-yearly-bonus', 'App\Http\Controllers\Payroll\PayrollGenerationController@getYearlyBonus');
    Route::post('payroll/vw-yearly-bonus', 'App\Http\Controllers\Payroll\PayrollGenerationController@viewYearlyBonus');
    Route::get('payroll/add-yearly-bonus', 'App\Http\Controllers\Payroll\PayrollGenerationController@addYearlyBonus');
    Route::post('payroll/add-yearly-bonus', 'App\Http\Controllers\Payroll\PayrollGenerationController@listAddYearlyBonus');
    Route::post('payroll/save-bonus-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@SaveBonusAll');
    Route::post('payroll/update-bonus-all', 'App\Http\Controllers\Payroll\PayrollGenerationController@UpdateBonusAll');

//payroll end



//plans
Route::get('superadmin/plans', 'App\Http\Controllers\AdminController@getPlans');
Route::get('superadmin/add-plan', 'App\Http\Controllers\AdminController@viewAddPlan');
Route::post('superadmin/add-plan', 'App\Http\Controllers\AdminController@savePlan');
Route::get('superadmin/add-plan/{id}', 'App\Http\Controllers\AdminController@getPlanId');

//Subscriptions
Route::get('superadmin/subscriptions', 'App\Http\Controllers\AdminController@getSubscriptions');
Route::get('superadmin/add-subscription', 'App\Http\Controllers\AdminController@viewAddSubscription');
Route::get('pis/calulate-expiry-date/{plan_id}/{start_date}', function ($plan_id,$start_date) {

    $plan = DB::table('plans')
        ->where('id', '=', $plan_id)
        ->where('status', '=', 'active')
        ->first();

    $expiry_date='';
    if(!empty($plan)){
        $expiry_date=date('Y-m-d', strtotime($start_date." +".$plan->validity." days"));
       //dd($expiry_date);
    }
    echo $expiry_date;

});
Route::post('superadmin/add-subscription', 'App\Http\Controllers\AdminController@saveSubscription');
Route::get('superadmin/add-subscription/{id}', 'App\Http\Controllers\AdminController@getSubscriptionId');
Route::post('superadmin/subscription-export', 'App\Http\Controllers\AdminController@exportSubscription');

/*****Mock Interview start******* */

//fileManagment
Route::get('fileManagment/dashboard', 'App\Http\Controllers\FilemanagmentControler@dashboard');

Route::get('fileManagment/fileManagmentList', 'App\Http\Controllers\FilemanagmentControler@fileManagmentList');
Route::get('fileManagment/fileManagment-add', 'App\Http\Controllers\FilemanagmentControler@fileManagmentView');
Route::post('fileManagment/fileManagment-save', 'App\Http\Controllers\FilemanagmentControler@savefilemanagment');
Route::get('fileManagment/edit-fileManager/{id}', 'App\Http\Controllers\FilemanagmentControler@fileManagmentViewedit');
Route::post('fileManagment/fileManagment-update', 'App\Http\Controllers\FilemanagmentControler@savefilemanagmentupdate');
Route::get('fileManagment/get-id/{organizationId}', 'App\Http\Controllers\FilemanagmentControler@getalldatafilemanagment');
Route::get('fileManagment/report-excel', 'App\Http\Controllers\FilemanagmentControler@excelreport');

//endfileManagment
//file upload
Route::get('fileManagment/file-add/{id}', 'App\Http\Controllers\FilemanagmentControler@fileAdd')->name('file.add');
Route::post("fileManagment/saveUpload","App\Http\Controllers\FilemanagmentControler@saveFileUpload");
Route::get('fileManagment/folder-create/{id}', 'App\Http\Controllers\FilemanagmentControler@folderCreate')->name('folder.create');
Route::post("fileManagment/saveFolder","App\Http\Controllers\FilemanagmentControler@saveFolderUpload");
//end file upload
//file devision
Route::get('fileManagment/file-devision-list', 'App\Http\Controllers\FilemanagmentControler@filedivisionlist');
Route::get('fileManagment/fileManagment-division-add', 'App\Http\Controllers\FilemanagmentControler@filedivisionView');
Route::post('fileManagment/fileManagment-division-adds', 'App\Http\Controllers\FilemanagmentControler@filedivisionadd');
Route::get('fileManagment/edit-file-devision/{id}', 'App\Http\Controllers\FilemanagmentControler@filedivisionViewedit');
Route::post('fileManagment/fileManagment-division-update', 'App\Http\Controllers\FilemanagmentControler@filedivisionViewupdate');
Route::post('fileManagment/updateUpload', 'App\Http\Controllers\FilemanagmentControler@managerupdate');
Route::get('fileManagment/file-name-delete/{id}/{orgId}', 'App\Http\Controllers\FilemanagmentControler@filedeleted');


//end file devision

//30-05-2022
//Question Categories
Route::get('superadmin/industries', 'App\Http\Controllers\AdminController@getQuestionCategories');
Route::get('superadmin/add-industry', 'App\Http\Controllers\AdminController@addQuestionCategory');
Route::post('superadmin/add-industry', 'App\Http\Controllers\AdminController@saveQuestionCategory');
Route::get('superadmin/add-industry/{id}', 'App\Http\Controllers\AdminController@getQuestionCategoryById');
Route::post('superadmin/delete-question-category/{id}', 'App\Http\Controllers\AdminController@deleteQuestionCategory');

Route::get('superadmin/questions', 'App\Http\Controllers\AdminController@getQuestions');
Route::get('superadmin/add-question', 'App\Http\Controllers\AdminController@addQuestion');
Route::post('superadmin/add-question', 'App\Http\Controllers\AdminController@saveQuestion');
Route::get('superadmin/add-question/{id}', 'App\Http\Controllers\AdminController@getQuestionById');
Route::post('superadmin/delete-question/{id}', 'App\Http\Controllers\AdminController@deleteQuestion');
//----------------

//interview postions
Route::get('superadmin/positions', 'App\Http\Controllers\AdminController@getPositions');
Route::get('superadmin/add-position', 'App\Http\Controllers\AdminController@viewAddPosition');
Route::post('superadmin/add-position', 'App\Http\Controllers\AdminController@savePosition');
Route::get('superadmin/add-position/{id}', 'App\Http\Controllers\AdminController@getPositionId');
Route::post('superadmin/delete-position/{id}', 'App\Http\Controllers\AdminController@deletePosition');

Route::get('superadmin/list-country', 'App\Http\Controllers\AdminController@getlistofcountry');
Route::get('superadmin/country-wise-list/{id}', 'App\Http\Controllers\AdminController@countrywiselist');
Route::get('superadmin/org-details/{id}', 'App\Http\Controllers\AdminController@countrywiseorg');

//interview question sections
Route::get('pis/get-interview-question-sections/{type}', function ($type) {

    $records = DB::table('intervi
    ew_question_sections')

    ->where('type', '=', $type)
        ->get();

    echo json_encode($records);

});
//in






// terview questions
Route::get('superadmin/interview-questions', 'App\Http\Controllers\AdminController@getInterviewQuestions');
Route::get('superadmin/add-interview-question', 'App\Http\Controllers\AdminController@viewAddInterviewQuestion');
Route::post('superadmin/add-interview-question', 'App\Http\Controllers\AdminController@saveInterviewQuestion');
Route::get('superadmin/add-interview-question/{id}', 'App\Http\Controllers\AdminController@getInterviewQuestionId');
// Route::post('superadmin/delete-position/{id}', 'AdminController@deletePosition');

//interview candidates
Route::get('superadmin/interview-candidate', 'App\Http\Controllers\AdminController@getCandidates');
Route::get('superadmin/add-interview-candidate', 'App\Http\Controllers\AdminController@viewAddCandidate');
Route::post('superadmin/add-interview-candidate', 'App\Http\Controllers\AdminController@saveInterviewCandidate');
Route::get('superadmin/add-interview-candidate/{id}', 'App\Http\Controllers\AdminController@getInterviewCandidateId');
// Route::post('superadmin/delete-position/{id}', 'AdminController@deletePosition');

//pre-mock interviews
Route::get('superadmin/pre-mock-interviews', 'App\Http\Controllers\AdminController@getPreMockInterviews');
Route::get('superadmin/add-pre-mock-interview', 'App\Http\Controllers\AdminController@viewAddPreMockInterview');
Route::get('pis/get-candidate-position-client/{candidate_id}', function ($candidate_id) {

    $records = InterviewCandidate::where('id', '=', $candidate_id)->first();
    $response=[];
    if(!empty($records)){
        $response=['client_name'=>$records->client_name,'position_name'=>$records->position->postion_name];
    }
    echo json_encode($response);

});
Route::post('superadmin/add-premock-interview', 'App\Http\Controllers\AdminController@savePreMockInterview');
Route::get('superadmin/add-premock-interview/{id}', 'App\Http\Controllers\AdminController@getPreMockInterviewId');

/*****Mock Interview end******* */

Route::get('superadmin/taxforbill', 'App\Http\Controllers\AdminController@gettaxforbillTypes');
Route::get('superadmin/add-taxforbill', 'App\Http\Controllers\AdminController@viewAddtaxforbillType');
Route::post('superadmin/add-taxforbill', 'App\Http\Controllers\AdminController@savetaxforbillType');
Route::get('superadmin/add-taxforbill/{id}', 'App\Http\Controllers\AdminController@gettaxforbillId');

Route::get('superadmin/invoice-candidates', 'App\Http\Controllers\AdminController@getInvoiceCandidates');
Route::get('superadmin/add-invoice-candidate', 'App\Http\Controllers\AdminController@viewAddInvoiceCandidate');
Route::post('superadmin/add-invoice-candidate', 'App\Http\Controllers\AdminController@storeAddInvoiceCandidate');
Route::get('superadmin/edit-invoice-candidate/{id}', 'App\Http\Controllers\AdminController@editInvoiceCandidate');
Route::post('superadmin/edit-invoice-candidate/{id}', 'App\Http\Controllers\AdminController@updateAddInvoiceCandidate');

Route::get('superadmin/visaexp-details/{send_id}', 'App\Http\Controllers\AdminController@viewvisaexpdetailswork');
Route::get('superadmin/bill-history/{send_id}', 'App\Http\Controllers\AdminController@viewsendcandidatedetailswork');
Route::get('superadmin/view-tareq', 'App\Http\Controllers\AdminController@getetare');
Route::get('superadmin/add-tareq', 'App\Http\Controllers\AdminController@addtareq');
Route::post('superadmin/add-tareq', 'App\Http\Controllers\AdminController@savetareq');

Route::get('superadmin/edit-tareq/{comp_id}', 'App\Http\Controllers\AdminController@viewtareqgy');
Route::post('superadmin/edit-tareq', 'App\Http\Controllers\AdminController@saveAddtareqgy');

Route::get('superadmin/change-password', 'App\Http\Controllers\AdminController@viewcahngepass');

Route::post('superadmin/change-password', 'App\Http\Controllers\AdminController@savecahngepass');

Route::get('superadmin/edit-duty-roster/{comp_id}', 'App\Http\Controllers\AdminController@viewrostereditgy');
Route::post('superadmin/edit-duty-roster', 'App\Http\Controllers\AdminController@saveAddrosteredy');
Route::get('superadmin/view-search-dasboard', 'App\Http\Controllers\AdminController@getorsearchgandasboard');
Route::post('superadmin/view-search-dasboard', 'App\Http\Controllers\AdminController@vieworsearchgandasboard');
Route::get('superadmin/view-dasboard', 'App\Http\Controllers\AdminController@getorgandasboard');

//file manager
Route::get('superadmin/view-file-manager', 'App\Http\Controllers\AdminController@getfilemanager');
Route::get('superadmin/edit-file/{id}', 'App\Http\Controllers\AdminController@fileapproved');


//end file manager
Route::get('superadmin/view-search-application', 'App\Http\Controllers\AdminController@getorsearchganapplication');
Route::post('superadmin/view-search-application', 'App\Http\Controllers\AdminController@vieworsearchganapplication');
Route::get('superadmin/visa-activity', 'App\Http\Controllers\AdminController@getetareactivity');
Route::get('superadmin/edit-visa-activity/{comp_id}', 'App\Http\Controllers\AdminController@viewactivitygy');
Route::post('superadmin/edit-visa-activity', 'App\Http\Controllers\AdminController@saveAddactivitygy');
Route::get('superadmin/view-referred', 'App\Http\Controllers\AdminController@getetarereferred');
Route::get('superadmin/add-referred', 'App\Http\Controllers\AdminController@addreferred');
Route::post('superadmin/add-referred', 'App\Http\Controllers\AdminController@savereferred');

Route::get('superadmin/edit-referred/{comp_id}', 'App\Http\Controllers\AdminController@viewreferredgy');
Route::post('superadmin/edit-referred', 'App\Http\Controllers\AdminController@saveAddreferredgy');

Route::get('superadmin/list-complete/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistcompletegy');
Route::get('superadmin/list-wip/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistwipgy');
Route::get('superadmin/list-need/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistneedgy');

Route::get('superadmin/list-partner/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistpartnergy');
Route::get('superadmin/list-billed/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistbilledgy');
Route::get('superadmin/list-recieved/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistrecievedgy');
Route::get('superadmin/list-days/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistdaysgy');
Route::get('superadmin/list-fifdays/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistfifdayssgy');
Route::get('superadmin/list-invoice/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistinvoicesgy');
Route::get('superadmin/list-invoicehld/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistinvoicehldsgy');
Route::get('superadmin/list-onhold/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistonholdsgy');
Route::get('superadmin/list-further/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistfurthergy');
Route::get('superadmin/list-hrhome/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrhomegy');
Route::get('superadmin/list-hrlagtime/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrlagtimegy');
Route::get('superadmin/list-hrrejected/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrrejectedgy');
Route::get('superadmin/list-hrrefused/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrefusededgy');

Route::get('superadmin/list-hrreply/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrreply');

Route::get('superadmin/list-hraward/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrawardgy');

Route::get('superadmin/list-hrcomplete/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrcompletesgy');

Route::get('superadmin/list-hrwip/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrwipsgy');
Route::get('superadmin/list-hrneed/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthrneedsgy');

Route::get('superadmin/list-request/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistrequestsgy');
Route::get('superadmin/list-pending/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistpendingsgy');
Route::get('superadmin/list-assigned/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistassignedsgy');
Route::get('superadmin/list-granted/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistgrantedtsgy');
Route::get('superadmin/list-visa-exp/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistvisaexpsgy');
Route::get('superadmin/list-visa-notifiaction/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistvisanotifiactionsgy');
Route::get('superadmin/list-rejected/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistrejectedtsgy');
Route::get('superadmin/edit-company/{comp_id}', 'App\Http\Controllers\AdminController@viewAddCompany');
Route::get('superadmin/edit-role-ass/{comp_id}', 'App\Http\Controllers\AdminController@viewAddroleass');

//visa file
Route::get('superadmin/list-pending-visafile/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistpendingvisafile');
Route::get('superadmin/list-granted-visafile/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistgrantedvisafile');
Route::get('superadmin/list-rejected-visafile/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistrejectedvisafile');
//----

//recruitment file
Route::get('superadmin/list-requested-recruitmentfile/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistrequestedrecruitementfile');
Route::get('superadmin/list-ongoing-recruitmentfile/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlistongoingrecruitementfile');
Route::get('superadmin/list-hired-recruitmentfile/{start_date}/{end_date}/{employee_id}', 'App\Http\Controllers\AdminController@viewlisthiredrecruitementfile');
//---28-01-2022
Route::get('superadmin/list-assigned-recruitmentfile', 'App\Http\Controllers\AdminController@getCompaniesRecruitementAssigned');
Route::post('superadmin/list-assigned-recruitmentfile-export', 'App\Http\Controllers\AdminController@getCompaniesRecruitementAssignedExport');
Route::get('superadmin/list-unbilled-recruitmentfile', 'App\Http\Controllers\AdminController@getRecruitementUnbilledList');
Route::post('superadmin/list-unbilled-recruitmentfile-export', 'App\Http\Controllers\AdminController@getRecruitementUnbilledListExport');
Route::get('superadmin/list-billed-recruitmentfile', 'App\Http\Controllers\AdminController@getRecruitementBilledList');
Route::post('superadmin/list-billed-recruitmentfile-export', 'App\Http\Controllers\AdminController@getRecruitementBilledListExport');

//17-02-2022
Route::get('superadmin/list-request-recruitment-file', 'App\Http\Controllers\AdminController@getRecruitementRequestedDashB');
Route::post('superadmin/list-request-recruitment-file-export', 'App\Http\Controllers\AdminController@getRecruitementRequestedDashBListExport');
Route::get('superadmin/list-ongoing-recruitment-file', 'App\Http\Controllers\AdminController@getRecruitementOngoingDashB');
Route::post('superadmin/list-ongoing-recruitment-file-export', 'App\Http\Controllers\AdminController@getRecruitementOngoingDashBListExport');
Route::get('superadmin/list-hired-recruitment-file', 'App\Http\Controllers\AdminController@getRecruitementHiredDashB');
Route::post('superadmin/list-hired-recruitment-file-export', 'App\Http\Controllers\AdminController@getRecruitementHiredDashBListExport');

Route::get('superadmin/list-unassigned-cosfile', 'App\Http\Controllers\AdminController@getCosUnassignedList');
Route::post('superadmin/list-unassigned-cosfile-export', 'App\Http\Controllers\AdminController@getCosUnassignedListExport');
Route::get('superadmin/list-assigned-cosfile', 'App\Http\Controllers\AdminController@getCosAssignedList');
Route::post('superadmin/list-assigned-cosfile-export', 'App\Http\Controllers\AdminController@getCosAssignedListExport');
Route::get('superadmin/list-pending-cosfile', 'App\Http\Controllers\AdminController@getCosPendingList');
Route::post('superadmin/list-pending-cosfile-export', 'App\Http\Controllers\AdminController@getCosPendingListExport');
Route::get('superadmin/list-granted-cosfile', 'App\Http\Controllers\AdminController@getCosGrantedList');
Route::post('superadmin/list-granted-cosfile-export', 'App\Http\Controllers\AdminController@getCosGrantedListExport');
Route::get('superadmin/list-rejected-cosfile', 'App\Http\Controllers\AdminController@getCosRejectedList');
Route::post('superadmin/list-rejected-cosfile-export', 'App\Http\Controllers\AdminController@getCosRejectedListExport');
Route::get('superadmin/list-unbilled-cosfile', 'App\Http\Controllers\AdminController@getCosUnbilledList');
Route::post('superadmin/list-unbilled-cosfile-export', 'App\Http\Controllers\AdminController@getCosUnbilledListExport');
Route::get('superadmin/list-billed-cosfile', 'App\Http\Controllers\AdminController@getCosBilledList');
Route::post('superadmin/list-billed-cosfile-export', 'App\Http\Controllers\AdminController@getCosBilledListExport');
Route::get('superadmin/list-unsignedcos-cosfile', 'App\Http\Controllers\AdminController@getCosUnsignedList');
Route::post('superadmin/list-unsignedcos-cosfile-export', 'App\Http\Controllers\AdminController@getCosUnsignedListExport');
Route::get('superadmin/list-signedcos-cosfile', 'App\Http\Controllers\AdminController@getCosSignedList');
Route::post('superadmin/list-signedcos-cosfile-export', 'App\Http\Controllers\AdminController@getCosSignedListExport');

Route::get('superadmin/unassigned-visafile-list', 'App\Http\Controllers\AdminController@getUnassignedVisaList');
Route::post('superadmin/unassigned-visafile-list-export', 'App\Http\Controllers\AdminController@getUnassignedVisaListExport');
Route::get('superadmin/assigned-visafile-list', 'App\Http\Controllers\AdminController@getAssignedVisaList');
Route::post('superadmin/assigned-visafile-list-export', 'App\Http\Controllers\AdminController@getAssignedVisaListExport');
Route::get('superadmin/pending-visafile-list', 'App\Http\Controllers\AdminController@getPendingVisaList');
Route::post('superadmin/pending-visafile-list-export', 'App\Http\Controllers\AdminController@getPendingVisaListExport');

Route::get('superadmin/submitted-visafile-list', 'App\Http\Controllers\AdminController@getSubmittedVisaList');
Route::post('superadmin/submitted-visafile-list-export', 'App\Http\Controllers\AdminController@getSubmittedVisaListExport');

Route::get('superadmin/granted-visafile-list', 'App\Http\Controllers\AdminController@getGrantedVisaList');
Route::post('superadmin/granted-visafile-list-export', 'App\Http\Controllers\AdminController@getGrantedVisaListExport');
Route::get('superadmin/rejected-visafile-list', 'App\Http\Controllers\AdminController@getRejectedVisaList');
Route::post('superadmin/rejected-visafile-list-export', 'App\Http\Controllers\AdminController@getRejectedVisaListExport');

Route::get('superadmin/unbilled-visafile-list', 'App\Http\Controllers\AdminController@getUnbilledVisaList');
Route::get('superadmin/billed-visafile-list', 'App\Http\Controllers\AdminController@getBilledVisaList');
//----

Route::post('superadmin/edit-role-ass-gg', 'App\Http\Controllers\AdminController@saveAddroleass');
Route::get('superadmin/billing', 'App\Http\Controllers\AdminController@viewbillng');
Route::get('superadmin/add-billing', 'App\Http\Controllers\AdminController@addbillng');
Route::post('superadmin/add-billing', 'App\Http\Controllers\AdminController@savebillng');
Route::get('superadmin/edit-billing/{comp_id}', 'App\Http\Controllers\AdminController@viewAddbillingy');
Route::post('superadmin/edit-billing', 'App\Http\Controllers\AdminController@saveAddbillingy');

Route::get('superadmin/remarks-billing/{comp_id}', 'App\Http\Controllers\AdminController@viewBillingRemarks');
Route::post('superadmin/save-remarks-billing', 'App\Http\Controllers\AdminController@saveBillingRemarks');
Route::get('superadmin/delete-remarks-billing/{comp_id}', 'App\Http\Controllers\AdminController@deleteBillingRemarks');

Route::get('superadmin/payment-received', 'App\Http\Controllers\AdminController@viewpayre');
Route::get('superadmin/add-received-payment', 'App\Http\Controllers\AdminController@addpayre');
Route::post('superadmin/add-received-payment', 'App\Http\Controllers\AdminController@savepayre');

//Route::get('superadmin/pdf-received-payment/{receipt_id}', 'AdminController@vwreceiptpdf');
Route::get('download-invoice-old/{receipt_id}', 'App\Http\Controllers\AdminController@vwreceiptpdf');
Route::get('download-invoice/{receipt_id}', 'App\Http\Controllers\AdminController@vwreceiptpdfbc');

Route::get('superadmin/message-center', 'App\Http\Controllers\AdminController@viewmsgcen');
Route::get('superadmin/add-message-center', 'App\Http\Controllers\AdminController@addmscen');
Route::post('superadmin/add-message-center', 'App\Http\Controllers\AdminController@savemscen');
Route::get('address-postcode', 'App\Http\Controllers\AdminController@addadddress');

Route::get('superadmin/employee-config', 'App\Http\Controllers\AdminController@viewUserConfig');
Route::get('superadmin/vw-user-config', 'App\Http\Controllers\AdminController@viewUserConfigForm');
Route::post('superadmin/vw-user-config', 'App\Http\Controllers\AdminController@SaveUserConfigForm');
Route::get('superadmin/vw-user-config/{user_id}', 'App\Http\Controllers\AdminController@GetUserConfigForm');

Route::get('superadmin/user-role', 'App\Http\Controllers\AdminController@viewUserAccessRightsForm');
Route::get('superadmin/admin-role', 'App\Http\Controllers\AdminController@viewAdminAccessRightsForm');
Route::get('superadmin/view-sidebar-permission', 'App\Http\Controllers\AdminController@viewSidebarPermissionForm');

Route::post('superadmin/user-role', 'App\Http\Controllers\AdminController@UserAccessRightsFormAuth');
Route::post('superadmin/admin-role', 'App\Http\Controllers\AdminController@AdminAccessRightsFormAuth');
Route::post('superadmin/view-sidebar-permission', 'App\Http\Controllers\AdminController@UserAccessRightsSidebarFormAuth');

Route::get('superadmin/view-users-role', 'App\Http\Controllers\AdminController@viewUserAccessRights');
Route::get('superadmin/view-admin-role', 'App\Http\Controllers\AdminController@viewAdminAccessRights');
Route::get('superadmin/view-sidebar-role', 'App\Http\Controllers\AdminController@viewSidebarRole');

Route::get('superadmin/view-users-role/{role_authorization_id}', 'App\Http\Controllers\AdminController@deleteUserAccess');
Route::get('superadmin/view-admin-role/{role_authorization_id}', 'App\Http\Controllers\AdminController@deleteAdminUserAccess');
Route::get('superadmin/invoice-bill/{role_authorization_id}', 'App\Http\Controllers\AdminController@deleteUserAccesscancelbill');
Route::get('superadmin/view-time-schedule', 'App\Http\Controllers\AdminController@viewscheduleRights');

Route::get('organisation-status/change-password', 'App\Http\Controllers\OrganisationController@viewcahngepass');

Route::post('organisation-status/change-password', 'App\Http\Controllers\OrganisationController@savecahngepass');

Route::get('superadmin/add-time-schedule/{user_id}', 'App\Http\Controllers\AdminController@GetscheduleConfigForm');
Route::post('superadmin/add-time-schedule', 'App\Http\Controllers\AdminController@viewcheduleConfigForm');
Route::get('superadmin/view-time-delete/{user_id}', 'App\Http\Controllers\AdminController@deletetimerAccess');
Route::get('superadmin/view-duty-roster/{user_id}', 'App\Http\Controllers\AdminController@dutyrostimerAccess');
Route::get('superadmin/offday', 'App\Http\Controllers\AdminController@viewoffday');
Route::get('superadmin/add-offday', 'App\Http\Controllers\AdminController@viewAddNewoffday');
Route::post('superadmin/add-offday', 'App\Http\Controllers\AdminController@saveoffdayData');

Route::get('superadmin/duty-roster', 'App\Http\Controllers\AdminController@viewroster');
Route::post('superadmin/add-duty-roster', 'App\Http\Controllers\AdminController@saverosterData');
Route::get('superadmin/add-employee-duty', 'App\Http\Controllers\AdminController@viewAddNewemployeeduty');
Route::post('superadmin/add-employee-duty', 'App\Http\Controllers\AdminController@saveemployeedutyData');
Route::post('superadmin/add-employee-duty-save', 'App\Http\Controllers\AdminController@saveemployeedutyDatasave');

Route::get('superadmin/vw-time-schedule', 'App\Http\Controllers\AdminController@vwcheduleConfigForm');

Route::post('superadmin/vw-time-schedule', 'App\Http\Controllers\AdminController@savecheduleConfigForm');

Route::get('superadmin/enquiry', 'App\Http\Controllers\AdminController@getenquiryTypes');

Route::get('superadmin/blog-comment', 'App\Http\Controllers\AdminController@getblogcommentTypes');
Route::post('superadmin/add-blog-comment', 'App\Http\Controllers\AdminController@saveblogcommentType');
Route::get('superadmin/add-blog-comment/{id}', 'App\Http\Controllers\AdminController@getblogcommentId');
Route::get('superadmin/blog', 'App\Http\Controllers\AdminController@getblogTypes');
Route::get('superadmin/blog-cat', 'App\Http\Controllers\AdminController@getblogcatTypes');
Route::get('superadmin/add-blog-cat', 'App\Http\Controllers\AdminController@viewAddblogcatType');
Route::post('superadmin/add-blog-cat', 'App\Http\Controllers\AdminController@saveblogcatType');
Route::get('superadmin/add-blog-cat/{id}', 'App\Http\Controllers\AdminController@getblogcatId');
Route::get('superadmin/add-blog', 'App\Http\Controllers\AdminController@viewAddblogType');
Route::post('superadmin/add-blog', 'App\Http\Controllers\AdminController@saveblogType');
Route::get('superadmin/add-blog/{id}', 'App\Http\Controllers\AdminController@getblogId');

Route::get('superadmin/view-add-hr', 'App\Http\Controllers\AdminController@viewhr');

Route::get('superadmin/edit-hr/{comp_id}', 'App\Http\Controllers\AdminController@viewAddhrnew');
Route::post('superadmin/edit-hr', 'App\Http\Controllers\AdminController@saveAddhrgynew');

Route::get('superadmin/add-hr', 'App\Http\Controllers\AdminController@viewAddhry');
Route::post('superadmin/add-hr', 'App\Http\Controllers\AdminController@saveAddhry');

Route::get('superadmin/view-add-visa', 'App\Http\Controllers\AdminController@viewvisa');
Route::get('superadmin/add-visa', 'App\Http\Controllers\AdminController@viewAddvisay');
Route::post('superadmin/add-visa', 'App\Http\Controllers\AdminController@saveAddvisay');
Route::get('superadmin/edit-visa/{comp_id}', 'App\Http\Controllers\AdminController@viewAddvisaew');
Route::post('superadmin/edit-visa', 'App\Http\Controllers\AdminController@saveAddvisagynew');
Route::get('superadmin/view-add-cos', 'App\Http\Controllers\AdminController@viewcos');
Route::get('superadmin/add-cos', 'App\Http\Controllers\AdminController@viewAddcosy');

Route::post('superadmin/add-cos', 'App\Http\Controllers\AdminController@saveAddcosy');

Route::get('superadmin/add-cos-adn', 'App\Http\Controllers\AdminController@viewAddAdncosy');

Route::post('superadmin/add-cos-adn', 'App\Http\Controllers\AdminController@saveAddcosyn');

//visa file superadmin
Route::get('superadmin/view-visa-file', 'App\Http\Controllers\AdminController@viewvisafile');
Route::get('superadmin/add-visa-file', 'App\Http\Controllers\AdminController@viewAddVisaFile');
Route::post('superadmin/add-visa-file', 'App\Http\Controllers\AdminController@saveAddVisaFile');
Route::get('superadmin/edit-visa-file/{comp_id}', 'App\Http\Controllers\AdminController@viewEditVisaFile');
Route::post('superadmin/edit-visa-file', 'App\Http\Controllers\AdminController@saveEditVisaFile');

Route::get('superadmin/add-visa-file-adn', 'App\Http\Controllers\AdminController@viewAddVisaFileAdn');
Route::post('superadmin/add-visa-file-adn', 'App\Http\Controllers\AdminController@saveAddVisaFileAdn');

Route::get('superadmin/add-visa-file-dependent/{id}', 'App\Http\Controllers\AdminController@viewAddVisaFileDependent');
Route::post('superadmin/add-visa-file-dependent/{id}', 'App\Http\Controllers\AdminController@saveAddVisaFileDependent');
Route::get('settings/get-dep-row-mic/{id}', 'App\Http\Controllers\EmployeeController@departmentgetFun');
Route::get('employee/emp-bank-name/{id}', 'App\Http\Controllers\EmployeeController@employeebankajkxFun');
Route::get('employee/emp-branch-name/{id}', 'App\Http\Controllers\EmployeeController@employeebranchajkxFun');
Route::get('employee/excel-report', 'App\Http\Controllers\EmployeeController@empexcelreport');
Route::get('employee/all-employee-pdf-report', 'App\Http\Controllers\EmployeeController@emppdfreport');



//---------------------
//recruitmentisa file superadmin
Route::get('superadmin/view-recruitment-file', 'App\Http\Controllers\AdminController@viewrecruitmentfile');
Route::get('superadmin/add-recruitment-file', 'App\Http\Controllers\AdminController@viewAddRecruitmentFile');
Route::post('superadmin/add-recruitment-file', 'App\Http\Controllers\AdminController@saveAddRecruitmentFile');
Route::get('superadmin/edit-recruitment-file/{comp_id}', 'App\Http\Controllers\AdminController@viewEditRecruitmentFile');
Route::post('superadmin/edit-recruitment-file', 'App\Http\Controllers\AdminController@saveEditRecruitmentFile');
//-----

Route::get('superadmin/organisation-assignment', 'App\Http\Controllers\AdminController@viewUserassignmentRightsForm');
Route::get('superadmin/edit-cos/{comp_id}', 'App\Http\Controllers\AdminController@viewAddcosnew');
Route::post('superadmin/edit-cos', 'App\Http\Controllers\AdminController@saveAddcosgynew');

Route::post('superadmin/organisation-assignment', 'App\Http\Controllers\AdminController@UserassignmentRightsFormAuth');
Route::get('superadmin/view-organisation-assignment', 'App\Http\Controllers\AdminController@viewUserassignmentRights');

Route::get('superadmin/view-organisation-assignment/{role_authorization_id}', 'App\Http\Controllers\AdminController@deleteUserassignment');

Route::get('pis/getEmployeedesigappaddressByIdkk/{empid}', function ($empid) {

    $apiKey = 'AIzaSyB_C7WVOT_-K7bUIpDR5Tf__PrNVipOVUM';
    $a = '';
    $getadd = $empid;
    $rep = str_replace(",", " ", $getadd);
    $formattedAddrFrom = str_replace(' ', '+', $rep);
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false&key=' . $apiKey);
    $outputFrom = json_decode($geocodeFrom);
//
    //
    $result_status1 = '';

    if (count($outputFrom->results) > 0) {

        for ($add = 0; $add < count($outputFrom->results); $add++) {

            if (!empty($outputFrom->results[$add]->address_components)) {
                $getdetails = $outputFrom->results[$add]->address_components;
                $a = '';
                $loc = '';
                $lev1 = '';
                $lev2 = '';
                $post = '';
                $coun = '';
                $route = '';
                $post_town = '';
                $neighborhood = '';
                foreach ($getdetails as $value) {
                    if ($value->types[0] == 'neighborhood') {

                        $neighborhood = $value->long_name . ',';

                    }
                    if ($value->types[0] == 'route') {

                        $route = $value->long_name . ',';

                    }
                    if ($value->types[0] == 'postal_town') {

                        $post_town = $value->long_name . ',';

                    }
                    if ($value->types[0] == 'locality') {

                        $loc = $value->long_name . ',';

                    }
                    if ($value->types[0] == 'administrative_area_level_2') {

                        $lev1 = $value->long_name . ',';

                    }if ($value->types[0] == 'administrative_area_level_1') {

                        $lev2 = $value->long_name . ',';

                    }
                    if ($value->types[0] == 'postal_code') {

                        $post = $value->long_name . ',';

                    }if ($value->types[0] == 'country') {

                        $coun = $value->long_name;

                    }
                    $a = $loc . $neighborhood . $route . $post_town . $post . $lev1 . $lev2 . $coun;

                }
                $result_status1 .= '<option value="' . $a . '">' . $a . '</option>';
            }

        }
    }

    echo $result_status1;
});

Route::get('pis/getEmployeedesigappaddressById/{empid}', function ($empid) {

    $apiKey = 'AIzaSyB_C7WVOT_-K7bUIpDR5Tf__PrNVipOVUM';
    $a = '';
    $getadd = $empid;
    $rep = str_replace(",", " ", $getadd);
    $formattedAddrFrom = str_replace(' ', '+', $rep);
    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false&key=' . $apiKey);
    $outputFrom = json_decode($geocodeFrom);
//
    //
    $result_status1 = '';

    if (count($outputFrom->results) > 0) {

        for ($add = 0; $add < count($outputFrom->results); $add++) {

            if (!empty($outputFrom->results[$add]->address_components)) {
                $getdetails = $outputFrom->results[$add]->address_components;
                $a = '';
                $loc = '';
                $lev1 = '';
                $lev2 = '';
                $post = '';
                $coun = '';
                $route = '';
                $post_town = '';
                $neighborhood = '';
                foreach ($getdetails as $value) {

                    if ($value->types[0] == 'neighborhood') {

                        $neighborhood = $value->long_name;

                    }
                    if ($value->types[0] == 'route') {

                        $route = $value->long_name;

                    }
                    if ($value->types[0] == 'postal_town') {

                        $post_town = $value->long_name;

                    }
                    if ($value->types[0] == 'locality') {

                        $loc = $value->long_name;

                    }
                    if ($value->types[0] == 'administrative_area_level_2') {

                        $lev1 = $value->long_name;

                    }if ($value->types[0] == 'administrative_area_level_1') {

                        $lev2 = $value->long_name;

                    }
                    if ($value->types[0] == 'postal_code') {

                        $post = $value->long_name;

                    }if ($value->types[0] == 'country') {

                        $coun = $value->long_name;

                    }

                }
                $result_status1 .= $a;
            }

        }
    }

    echo json_encode(array('route' => $route, 'locality' => $loc, 'postal_town' => $post_town, 'administrative_area_level_1' => $lev1, 'administrative_area_level_2' => $lev2, 'country' => $coun, 'neighborhood' => $neighborhood));

});

Route::get('pis/getEmployeedesigappaddressByIhhd/{empid}', function ($empid) {

    $apiKey = 'ak_kue1uy5o5V41YRdC2Xd5yGbzLBzyJ';

    $a = '';
    $getadd = $empid;
    $rep = str_replace(",", " ", $getadd);
    $formattedAddrFrom = str_replace(' ', '+', $rep);
    $geocodeFrom = file_get_contents('https://api.ideal-postcodes.co.uk/v1/postcodes/' . $empid . '/?api_key=' . $apiKey);
    $outputFrom = json_decode($geocodeFrom);
//
    //

    $result_status1 = '';

    if (count($outputFrom->result) > 0) {
        $result_status1 = "  <option value=''>&nbsp;</option>
";
        foreach ($outputFrom->result as $bank) {
            $add = '';

            if ($bank->line_2 != '') {
                $add = $bank->line_2 . ',' . $bank->line_1;
            } else {
                $add = $bank->line_1;
            }
            if ($bank->line_3 != '') {
                $add .= ',' . $bank->line_3;
            }
            $add .= ',' . $bank->postal_county;
            $result_status1 .= '<option value="' . $add . '"'; $result_status1 .= '> ' . $add . '</option>';
        }

    }

    echo $result_status1;
});

Route::get('pis/getEmployeedesigappaddressByIhhdmnkkll/{empid}', function ($empid) {

    $apiKey = 'ak_kue1uy5o5V41YRdC2Xd5yGbzLBzyJ';

    $a = '';
    $getadd = $empid;
    $rep = str_replace(",", " ", $getadd);
    $formattedAddrFrom = str_replace(' ', '+', $rep);
    $geocodeFrom = file_get_contents('https://api.ideal-postcodes.co.uk/v1/postcodes/' . $empid . '/?api_key=' . $apiKey);
    $outputFrom = json_decode($geocodeFrom);
//
    //

    $result_status1 = '';

    if (count($outputFrom->result) > 0) {
        $result_status1 = "  <option value=''>select</option>
";
        foreach ($outputFrom->result as $bank) {
            $add = '';
            if ($bank->line_2 != '') {
                $add = $bank->line_2 . ',' . $bank->line_1;
            } else {
                $add = $bank->line_1;
            }
            if ($bank->line_3 != '') {
                $add .= ',' . $bank->line_3;
            }
            $add .= ',' . $bank->postal_county;
            $result_status1 .= '<option value="' . $add . '"'; $result_status1 .= '> ' . $add . '</option>';
        }

    }

    echo $result_status1;
});

Route::get('pis/getEmployeedesigappaddressByIhhdjfjjbfg/{empid}', function ($empid) {

    $ff = explode(',', $empid);
    $kk = count($ff);
    if ($kk == 4) {
        $o = 1;
        $address = '';
        $address2 = '';
        $road = '';
        $city = '';
        foreach ($ff as $bankhh) {
            if ($o == 1) {
                $address = $bankhh;
            }
            if ($o == 2) {
                $address2 = $bankhh;
            }
            if ($o == 3) {
                $road = $bankhh;
            }
            if ($o == 4) {
                $city = $bankhh;
            }
            $o++;
        }
        echo json_encode(array('address' => $address, 'address2' => $address2, 'road' => $road, 'city' => $city, 'country' => 'United Kingdom'));

    }
    if ($kk == 3) {
        $o = 1;
        $address = '';
        $address2 = '';
        $road = '';
        $city = '';
        foreach ($ff as $bankhh) {
            if ($o == 1) {
                $address = $bankhh;
            }
            if ($o == 2) {
                $address2 = $bankhh;
            }
            if ($o == 3) {
                $city = $bankhh;
            }

            $o++;
        }
        echo json_encode(array('address' => $address, 'address2' => $address2, 'road' => '', 'city' => $city, 'country' => 'United Kingdom'));

    }
    if ($kk == 2) {
        $o = 1;
        $address = '';
        $address2 = '';
        $road = '';
        $city = '';
        foreach ($ff as $bankhh) {
            if ($o == 1) {
                $address = $bankhh;
            }

            if ($o == 2) {
                $city = $bankhh;
            }

            $o++;
        }
        echo json_encode(array('address' => $address, 'address2' => '', 'road' => '', 'city' => $city, 'country' => 'United Kingdom'));

    }
    if ($kk == 5 || $kk == 6) {
        $o = 1;
        $address = '';
        $address2 = '';
        $address3 = '';
        $road = '';
        $city = '';
        foreach ($ff as $bankhh) {
            if ($o == 1) {
                $address = $bankhh;
            }
            if ($o == 2) {
                $address3 = ',' . $bankhh;
            }
            if ($o == 3) {
                $address2 = $bankhh;
            }
            if ($o == 4) {
                $road = $bankhh;
            }
            if ($o == 5 || $o == 6) {
                $city .= $bankhh;
            }

            $o++;
        }
        echo json_encode(array('address' => $address . $address3, 'address2' => $address2, 'road' => $road, 'city' => $city, 'country' => 'United Kingdom'));

    }
});

Route::get('billing/get-add-row-item/{row}', function ($row) {

    $row = $row;

    $result_status1 = '';
    $package_rs = DB::Table('package')
        ->where('status', '=', 'active')
        ->get();
    foreach ($package_rs as $package) {
        $result_status1 .= '<option value="' . $package->id . '">' . $package->name . '</option>';
    }
    $result = '

	<div class="row form-group itemslot" id="' . $row . '" >
	<div class="col-md-4">
					<div class="form-group">
						<label for="des" class="placeholder">Description</label>
						<select class="form-control input-border-bottom"   id="package' . $row . '" required=""  name="package[]" style="margin-top: 22px;" onchange="checkpackage(this.value,' . $row . ');">
													<option value="">&nbsp;</option>

												' . $result_status1 . '

												</select>

											 <input id="des' . $row . '"   name="des[]"   type="hidden" class="form-control"  required >


											</div>
											</div>



											<div class="col-md-4" style="display:none;" id="ex_vat_div' . $row . '">
												<div class=" form-group">
													<label for="anount_ex_vat" class="placeholder">Unit Price Excluding VAT</label>
													<input id="anount_ex_vat' . $row . '" type="number"  name="anount_ex_vat[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;"  >


												</div>
											</div>


											<div class="col-md-4" style="display:none;" id="discount_div' . $row . '">
												<div class=" form-group">
													<label for="discount" class="placeholder">Discount</label>
													<input id="discount' . $row . '" type="number"  name="discount[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;" onchange="checkpackagedis(this.value,' . $row . ');">


												</div>
											</div>

											<div class="col-md-2" style="display:none;" id="discount_amount_div' . $row . '">
												<div class=" form-group">
													<label for="discount_amount" class="placeholder">Discounted Amount</label>
													<input id="discount_amount' . $row . '" type="number"  name="discount_amount[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;"  >


												</div>
											</div>
											<div class="col-md-2"  style="display:none;" id="vat_div' . $row . '">
												<div class=" form-group">
													<label for="vat" class="placeholder">Vat in %</label>
													<input id="vat' . $row . '" type="number"  name="vat[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;" >


												</div>
											</div>

												<div class="col-md-2" style="display:none;" id="amount_after_vat_div' . $row . '">
												<div class=" form-group">
													<label for="amount_after_vat" class="placeholder">Amount After Vat</label>
													<input id="amount_after_vat' . $row . '" type="number"  name="amount_after_vat[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;"  onchange="checkcompany();">


												</div>
											</div>
											<div class="col-md-2" style="display:none;" id="net_amount_div' . $row . '">
												<div class=" form-group">
													<label for="net_amount" class="placeholder">Net Amount </label>
													<input id="net_amount' . $row . '" type="number"  name="net_amount[]"    class="form-control input-border-bottom" required="" style="margin-top: 22px;"  >


												</div>
											</div>
											<div class="col-md-2" style="margin-top:30px;"><div class=" form-group btn-pls">
											<button class="btn btn-success" type="button" id="add' . ($row + 1) . '" onClick="addnewrow(' . ($row + 1) . ')" data-id="' . ($row + 1) . '"> <i class="fas fa-plus"></i> </button>
											<button class="btn btn-danger deleteButton" type="button" id="delete' . $row . '" onClick="delRow(' . $row . ')" data-id="' . $row . '"> <i class="fas fa-minus"></i> </button>

											</div>
												</div>

	</div>
	';
    echo $result;
});

Route::get('pis/getbillpaykkById/{empid}', function ($empid) {

    $employee_rs = DB::table('billing')

        ->where('id', '=', $empid)

        ->first();

    $employee_rs_report = DB::table('registration')

        ->where('reg', '=', $employee_rs->emid)
        ->first();

    $des_rs = DB::table('billing')

        ->where('in_id', '=', $employee_rs->in_id)

        ->get();

    $nameb = array();
    if (count($des_rs) != 0) {
        foreach ($des_rs as $biname) {
            $nameb[] = $biname->des;

        }
    }
    $strbil = implode(',', $nameb);
    echo json_encode(array($employee_rs, $employee_rs_report, '3' => $strbil));

});
Route::get('pis/getbillorganmsgById/{empid}', function ($empid) {

    $employee_rs = DB::table('registration')

        ->where('reg', '=', $empid)
        ->first();

    echo json_encode(array($employee_rs));

});

Route::get('pis/getbillorganmsgniuById/{empid}', function ($empid) {

    $employee_rs = DB::table('candidate')

        ->where('id', '=', $empid)
        ->first();

    echo json_encode(array($employee_rs));

});
Route::get('pis/getremidnamepaykkByIdauthofnree/{empid}/{employee_id}', function ($empid, $employee_id) {

    $Roledata = DB::table('registration')

        ->where('com_name', '=', $empid)
        ->first();
    $yy = DB::table('role_authorization_admin_organ')

        ->where('module_name', '=', $Roledata->reg)
        ->where('member_id', '=', $employee_id)
        ->first();

    echo json_encode(array($yy));

});
Route::get('pis/getremidnamepaykkByIdauthofnreeregnew/{empid}/{employee_id}', function ($empid, $employee_id) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $empid)
        ->first();
    $yy = DB::table('role_authorization_admin_organ')

        ->where('module_name', '=', $Roledata->reg)
        ->where('member_id', '=', $employee_id)
        ->first();

    echo json_encode(array($yy));

});
Route::get('pis/getremidnamepaykkById/{empid}', function ($empid) {

    $Roledata = DB::table('registration')

        ->where('com_name', '=', $empid)
        ->where('status', '=', 'active')
        ->first();

    echo json_encode(array($Roledata));

});
Route::get('pis/getremidnamepaykkByIdnecandidatename/{empid}/{emplpyee}', function ($empid, $emplpyee) {

    $Roledata = DB::table('candidate')
        ->join('company_job', 'company_job.id', '=', 'candidate.job_id')
        ->where('candidate.name', '=', $empid)
        ->where('candidate.status', '=', 'Hired')
        ->where('company_job.emid', '=', $emplpyee)
        ->select('candidate.*')
        ->first();

    echo json_encode(array($Roledata));

});

Route::get('pis/getremidnamepaykkByIdnecandidatenameinvc/{empid}/{emplpyee}', function ($empid, $emplpyee) {

    $Roledata = DB::table('invoice_candidates')
        ->where('invoice_candidates.emid', '=', $emplpyee)
        ->where('invoice_candidates.candidate_name', '=', $empid)
        ->where('invoice_candidates.status', '=', 'A')
        ->select('*')
        ->first();

    echo json_encode(array($Roledata));

});

Route::get('leavecount/bydays/{from_date}/{to_date}/{leave_type}', function ($from_date, $to_date, $leave_type) {

    $user_id = Session::get('users_id');
    $users = DB::table('users')->where('id', '=', $user_id)->first();
    $satnew = 'Saturday';
    $sunnew = 'Sunday';
    $total_wk_days = 0;
    $date1_ts = strtotime($from_date);
    $date2_ts = strtotime($to_date);
    $diff = $date2_ts - $date1_ts;
    $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_type)->first();

    $Date1 = date('d-m-Y', strtotime($from_date));
    $Date2 = date('d-m-Y', strtotime($to_date));

// Declare an empty array
    $array = array();

// Use strtotime function
    $Variable1 = strtotime($Date1);
    $Variable2 = strtotime($Date2);

// Use for loop to store dates into array
    // 86400 sec = 24 hrs = 60*60*24 = 1 day
    for ($currentDate = $Variable1; $currentDate <= $Variable2;
        $currentDate += (86400)) {

        $Store = date('Y-m-d', $currentDate);

        $array[] = $Store;
    }
//   dd($leave_tyepenew);
    if (trim($leave_tyepenew->alies)) {
        $total_wk_days = (round($diff / 86400) + 1);

        $daysnew = 0;
        if (date('d', strtotime($from_date)) > $total_wk_days) {
            $total_wk_days = date('d', strtotime($from_date)) + ($total_wk_days - 1);

        } else if (date('d', strtotime($from_date)) != 1) {
            $total_wk_days = date('d', strtotime($from_date)) + ($total_wk_days - 1);
        } else {
            $total_wk_days = $total_wk_days;
        }
        if (date('d', strtotime($from_date)) == date('d', strtotime($to_date))) {
            $total_wk_days = date('d', strtotime($from_date));
        }

        foreach ($array as $valueogf) {
        //   dd("hello");
            $new_f = $valueogf;
            $duty_auth = DB::table('duty_roster')

                ->where('employee_id', '=', $users->employee_id)
                ->where('emid', '=', $users->emid)

                ->orderBy('id', 'DESC')
                ->first();
            //  dd($duty_auth);
            $holidays = DB::table('holiday')
                ->whereDate('from_date', '<=', $new_f)
                ->whereDate('to_date', '>=', $new_f)

                ->where('emid', '=', $users->emid)
                ->first();

            $offg = array();
            if (!empty($duty_auth)) {

                $shift_auth = DB::table('shift_management')

                    ->where('id', '=', $duty_auth->shift_code)

                    ->where('emid', '=', $users->emid)
                    ->orderBy('id', 'DESC')
                    ->first();
                $off_auth = DB::table('offday')

                    ->where('shift_code', '=', $duty_auth->shift_code)

                    ->where('emid', '=', $users->emid)
                    ->orderBy('id', 'DESC')
                    ->first();
                //  dd($off_auth);
                $off_day = 0;
                if (!empty($off_auth)) {
                    if ($off_auth->sun == '1') {

                        $off_day = $off_day + 1;
                        $offg[] = 'Sunday';
                    }
                    if ($off_auth->mon == '1') {
                        $off_day = $off_day + 1;
                        $offg[] = 'Monday';
                    }

                    if ($off_auth->tue == '1') {
                        $off_day = $off_day + 1;
                        $offg[] = 'Tuesday';
                    }

                    if ($off_auth->wed == '1') {
                        $off_day = $off_day + 1;
                        $offg[] = 'Wednesday';
                    }

                    if ($off_auth->thu == '1') {
                        $off_day = $off_day + 1;
                        $offg[] = 'Thursday';
                    }

                    if ($off_auth->fri == '1') {
                        $off_day = $off_day + 1;
                        $offg[] = 'Friday';
                    }
                    if ($off_auth->sat == '1') {
                        $off_day = $off_day + 1;
                        $offg[] = 'Saturday';
                    }

                }
            }
            if (in_array(date('l', strtotime($new_f)), $offg)) {

            } else {
                $daysnew++;
            }

        }

    } else {
        $diff = abs(strtotime($to_date) - strtotime($from_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = (floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24))) + 1;
        $daysnew = $days;
    }

    echo $daysnew;

});

//old candidate hired link to invoice
Route::get('pis/getremidnamepaykkByIdnewtime/{empid}', function ($empid) {
    $Roledatanewr = DB::table('registration')

        ->where('com_name', '=', $empid)
        ->where('status', '=', 'active')
        ->first();

    $Roledata = DB::table('candidate')
        ->join('company_job', 'company_job.id', '=', 'candidate.job_id')

        ->where('candidate.status', '=', 'Hired')
        ->where('company_job.emid', '=', $Roledatanewr->reg)
        ->get();
    $result_status1 = '';
    $result_status1 = "  <option value=''>&nbsp;</option>
";
    foreach ($Roledata as $bank) {
        $result_status1 .= '<option value="' . $bank->name . '"'; $result_status1 .= '> ' . $bank->name . '</option>';
    }

    echo $result_status1;

});

//new candidate invoice table link to invoice
Route::get('pis/getremidnamepaykkByIdnewtimeinvc/{empid}', function ($empid) {
    $Roledatanewr = DB::table('registration')

        ->where('com_name', '=', $empid)
        ->where('status', '=', 'active')
        ->first();

    $Roledata = DB::table('invoice_candidates')
        ->where('invoice_candidates.emid', '=', $Roledatanewr->reg)
        ->where('invoice_candidates.status', '=', 'A')
        ->get();
    $result_status1 = '';
    $result_status1 = "  <option value=''>&nbsp;</option>
";
    foreach ($Roledata as $bank) {
        $result_status1 .= '<option value="' . $bank->candidate_name . '"';
        $result_status1 .= '> ' . $bank->candidate_name . '</option>';
    }

    echo $result_status1;

});

Route::get('view-billing/{comp_id}', 'App\Http\Controllers\BillingController@viewNewbillingpage');

Route::get('pis/getremidnamepaykkByIdnecandidatenamenew/{empid}/{empidnew}', function ($empid, $empidnew) {

    $Roledata = DB::table('candidate')
        ->join('company_job', 'company_job.id', '=', 'candidate.job_id')
        ->where('candidate.name', '=', $empid)
        ->where('candidate.status', '=', 'Hired')
        ->where('company_job.emid', '=', $empidnew)
        ->first();

    $companyRoledata = DB::table('company_job')

        ->where('id', '=', $Roledata->job_id)

        ->first();

    echo json_encode(array($companyRoledata, $Roledata));

});

Route::get('pis/getremidnamepaykkByIdnewreg/{empid}', function ($empid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $empid)
        ->first();

    echo json_encode(array($Roledata));

});

Route::get('pis/getremidnamepaykkByIdauthoflust/{empid}', function ($empid) {

    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();
    $ff = DB::table('company_employee')
        ->where('emid', '=', $Roledata->reg)
        ->get();

    if (count($ff) != 0) {
        $type = $Roledata->updated_at;
        $d_type = date('Y-m-d', strtotime($Roledata->updated_at . '  + 3 Weeks'));
        $sub_date = date('Y-m-d', strtotime($Roledata->updated_at . '  + 4  Weeks'));
    } else if (count($ff) == 0) {
        $ffjj = DB::table('users')

            ->where('emid', '=', $Roledata->reg)
            ->first();
        if (!empty($ffjj)) {
            $type = date('Y-m-d', strtotime($Roledata->updated_at));
            $d_type = date('Y-m-d', strtotime($type . '  + 3 Weeks'));
            $sub_date = date('Y-m-d', strtotime($type . '  + 4  Weeks'));
        } else {
            $type = '';
            $d_type = '';
            $sub_date = '';
        }

    } else {
        $type = '';
        $d_type = '';
        $sub_date = '';
    }

    $ffjjtuu = DB::table('tareq_app')

        ->where('emid', '=', $Roledata->reg)
        ->first();

    if (!empty($ffjjtuu)) {
        if ($ffjjtuu->last_sub != '') {
            $sub_date = date('Y-m-d', strtotime($ffjjtuu->last_sub . '  + 5  Weeks'));
        } else {
            $sub_date = '';
        }
    } else {
        $sub_date = '';
    }

    $arr = array('type' => $type, 'd_type' => $d_type, 'sub_date' => $sub_date);
    echo json_encode($arr);

});

Route::get('pis/getremidnamepaykkByIdauthof/{empid}', function ($empid) {

    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();

    $Roledataroluu = DB::table('role_authorization_admin_organ')
        ->where('status', '=', 'active')
        ->where('module_name', '=', $Roledata->reg)
        ->get();

    // dd($Roledataroluu);

    $result_status1 = "  <option value=''>&nbsp;</option>";

    foreach ($Roledataroluu as $bank) {
        $Roledataroluuuser = DB::table('users_admin_emp')
            ->where('employee_id', '=', $bank->member_id)
            ->first();

        $result_status1 .= '<option value="' . $Roledataroluuuser->employee_id . '"';
        $result_status1 .= '> ' . $Roledataroluuuser->name . '</option>';
    }

    echo $result_status1;

});
//Get Candidate of Org from recruitement
Route::get('pis/getrecruitementcandidateforcos/{empid}', function ($empid) {
    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();

    $recruitment_file_apply = DB::table('recruitment_file_apply')
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $result_status1 = '';
    if (count($recruitment_file_apply) > 0) {
        $cos_apply_emp = DB::table('cos_apply_emp')
            ->where('emid', '=', $Roledata->reg)
            ->whereNull('employee_id')
            ->pluck('employee_name');

        // dd($cos_apply_emp);

        $recruitment_file_emp = DB::table('recruitment_file_emp')
            ->where('emid', '=', $Roledata->reg)
            ->whereIn('employee_name', $cos_apply_emp)
            ->orderBy('employee_name', 'asc')
            ->get();

       // dd($recruitment_file_emp);

        $result_status1 = "<option value=''>&nbsp;</option>";
        foreach ($recruitment_file_emp as $record) {
            $result_status1 .= '<option value="' . $record->employee_name . '"';
            $result_status1 .= '> ' . $record->employee_name . '</option>';
        }

    } else {
        $result_status1 = 'no_recruitement';
    }

    echo $result_status1;

});

//Get Candidate of Org from recruitement
Route::get('pis/getrecruitementfirstinvcandidate/{empid}', function ($empid) {
    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();

    $recruitment_file_apply = DB::table('recruitment_file_apply')
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $result_status1 = '';
    if (count($recruitment_file_apply) > 0) {

        $recruitment_file_emp = DB::table('recruitment_file_emp')
            ->where('emid', '=', $Roledata->reg)
            ->where('billed_first_invoice', '=', 'No')
        //->whereIn('employee_name', $cos_apply_emp)
            ->whereNotNull('employee_id')
            ->orderBy('employee_name', 'asc')
            ->get();

        //dd($recruitment_file_emp);

        $result_status1 = "<option value=''>&nbsp;</option>";
        foreach ($recruitment_file_emp as $record) {
            $result_status1 .= '<option value="' . $record->employee_name . '"';
            $result_status1 .= '> ' . $record->employee_name . '</option>';
        }

    } else {
        $result_status1 = 'no_recruitement';
    }

    echo $result_status1;

});

//Get Candidate for cos invoice
Route::get('pis/getrecruitementsecondinvcandidate/{empid}', function ($empid) {
    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();

    $cos_apply = DB::table('cos_apply')
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $result_status1 = '';

    if (count($cos_apply) > 0) {
        $recruitment_file_emp = DB::table('recruitment_file_emp')
            ->where('emid', '=', $Roledata->reg)
            ->whereNotNull('employee_id')
            ->pluck('employee_name');

        //dd($recruitment_file_emp);

        $cos_apply_emp = DB::table('cos_apply_emp')
            ->where('emid', '=', $Roledata->reg)
            ->whereIn('employee_name', $recruitment_file_emp)
            ->where('cos_assigned', '=', 'Yes')
            ->where('billed_second_invoice', '=', 'No')
            ->orderBy('employee_name', 'asc')
            ->get();

        //dd($cos_apply_emp);

        $result_status1 = "<option value=''>&nbsp;</option>";
        foreach ($cos_apply_emp as $record) {
            $result_status1 .= '<option value="' . $record->employee_name . '"';
            $result_status1 .= '> ' . $record->employee_name . '</option>';
        }

    } else {
        $result_status1 = 'no_cos';
    }

    echo $result_status1;

});

//Get All Candidate of Org from recruitement
Route::get('pis/getrecruitementfirstinvcandidate_edit/{empid}', function ($empid) {
    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();

    $recruitment_file_apply = DB::table('recruitment_file_apply')
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $result_status1 = '';
    if (count($recruitment_file_apply) > 0) {
        // $cos_apply_emp = DB::table('cos_apply_emp')
        //     ->where('emid', '=', $Roledata->reg)
        //     ->whereNotNull('employee_id')
        //     ->pluck('employee_name');

        // dd($cos_apply_emp);

        $recruitment_file_emp = DB::table('recruitment_file_emp')
            ->where('emid', '=', $Roledata->reg)
        // ->where('billed_first_invoice', '=', 'No')
        //->whereIn('employee_name', $cos_apply_emp)
            ->whereNotNull('employee_id')
            ->orderBy('employee_name', 'asc')
            ->get();

        //dd($recruitment_file_emp);

        $result_status1 = "<option value=''>&nbsp;</option>";
        foreach ($recruitment_file_emp as $record) {
            $result_status1 .= '<option value="' . $record->employee_name . '"';
            $result_status1 .= '> ' . $record->employee_name . '</option>';
        }

    } else {
        $result_status1 = 'no_recruitement';
    }

    echo $result_status1;

});

//Get Candidate of Org from cos
Route::get('pis/getrecruitementcandidateforvisa/{empid}', function ($empid) {

    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();

    $recruitment_file_apply = DB::table('recruitment_file_apply')
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $cos_apply = DB::table('cos_apply')
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $result_status1 = '';
    if (count($cos_apply) > 0) {
        $visa_apply_emp = DB::table('visa_file_emp')
            ->where('emid', '=', $Roledata->reg)
            ->whereNull('employee_id')
            ->pluck('employee_name');

        // dd($cos_apply_emp);

        $cos_apply_emp = DB::table('cos_apply_emp')
            ->where('emid', '=', $Roledata->reg)
            ->whereIn('employee_name', $visa_apply_emp)
            ->orderBy('employee_name', 'asc')
            ->get();

        //dd($cos_apply_emp);

        $result_status1 = "<option value=''>&nbsp;</option>";
        foreach ($cos_apply_emp as $record) {
            $result_status1 .= '<option value="' . $record->employee_name . '"';
            $result_status1 .= '> ' . $record->employee_name . '</option>';
        }

    } else {
        $result_status1 = 'no_cos';
    }

    echo $result_status1;

});
Route::get('pis/getpcakgedeatilsbyId/{empid}', function ($empid) {

    $package_rs = DB::table('package')

        ->where('id', '=', $empid)
        ->first();
    if ($package_rs->vat_apply == 'Yes') {
        $tax_rs = DB::table('tax_bill')
            ->where('id', '=', '1')
            ->where('status', '=', 'active')
            ->first();

    } else {
        $tax_rs = '';
    }
    echo json_encode(array($package_rs, $tax_rs));

});
Route::get('pis/getremidnamepaykkByIdnew/{empid}', function ($empid) {

    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $empid)
        ->first();

    $result = '';
    $bill_rs = DB::Table('billing')
        ->where('emid', '=', $Roledata->reg)
        ->where('status', '!=', 'paid')
        ->where('status', '!=', 'cancel')
        ->where('pay_mode', '=', 'Ofline')
        ->where(function ($query) {
            $query->where('hold_st', '=', 'No')
                ->orwhere('hold_st', '=', '')
                ->orWhereNull('hold_st');
        }
        )
        ->groupBy('in_id')
        ->get();

    $result_status1 = "  <option value=''>&nbsp;</option>
";
    foreach ($bill_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->id . '"'; $result_status1 .= '> ' . $bank->in_id . '</option>';
    }

    echo $result_status1;

});

Route::get('superadmin/send-bill/{send_id}', 'App\Http\Controllers\AdminController@viewsendbilldetails');
Route::post('superadmin/editcompany', 'App\Http\Controllers\AdminController@saveCompany');
Route::get('superadmin/organisation-employee', 'App\Http\Controllers\AdminController@viewallcompany');
Route::get('superadmin/employee-list', 'App\Http\Controllers\AdminController@viewallcompanyemployee');

Route::post('superadmin/organisation-employee', 'App\Http\Controllers\AdminController@saveemployeede');
Route::post('superadmin/employee-list', 'App\Http\Controllers\AdminController@saveallcompanyemployee');
Route::post('superadmin/employee-list-report', 'App\Http\Controllers\AdminController@savereportroDataem');
Route::post('superadmin/employee-list-report-excel', 'App\Http\Controllers\AdminController@savereportroDataemexcel');
Route::get('superadmin/company-report/{comp_id}', 'App\Http\Controllers\AdminController@viewAddCompanyreport');
Route::get('superadmin/employee-report/{comp_id}/{emp_id}', 'App\Http\Controllers\AdminController@viewAddEmployeereport');

Route::get('superadmin/view-reminder', 'App\Http\Controllers\AdminController@viewallcompanyreminder');
Route::post('superadmin/view-reminder', 'App\Http\Controllers\AdminController@saveemployeedereminder');

Route::get('superadmin/view-hr', 'App\Http\Controllers\AdminController@viewallcompanyhr');

Route::post('superadmin/view-hr', 'App\Http\Controllers\AdminController@saveemployeedehr');

Route::get('superadmin/billing-report', 'App\Http\Controllers\AdminController@viewallcompanybillingreport');
Route::post('superadmin/billing-report', 'App\Http\Controllers\AdminController@saveemployeedebillingreport');
Route::post('superadmin/billing-report-export', 'App\Http\Controllers\AdminController@saveemployeedebillingreport_export');

Route::post('superadmin/billing-report-pdf', 'App\Http\Controllers\AdminController@savesearchopdfp');

Route::get('superadmin/billing-search', 'App\Http\Controllers\AdminController@viewallcompanybillingsearch');
Route::post('superadmin/billing-search', 'App\Http\Controllers\AdminController@saveemployeedebillingsearch');
Route::post('superadmin/billing-search-export', 'App\Http\Controllers\AdminController@saveemployeedebillingsearch_export');
Route::get('superadmin/payment-search', 'App\Http\Controllers\AdminController@viewallcompanypaymentsearch');
Route::post('superadmin/payment-search', 'App\Http\Controllers\AdminController@saveemployeedepaymentsearch');

Route::get('superadmin/work-update', 'App\Http\Controllers\AdminController@viewallcompanywork');
Route::post('superadmin/work-update', 'App\Http\Controllers\AdminController@saveemployeedework');
Route::get('superadmin/view-cos', 'App\Http\Controllers\AdminController@viewallcompanycos');
Route::post('superadmin/view-cos', 'App\Http\Controllers\AdminController@saveemployeedecos');
Route::get('superadmin/active', 'App\Http\Controllers\AdminController@getCompaniesactive');
Route::post('superadmin/active-export', 'App\Http\Controllers\AdminController@getCompaniesactive_export');
//Route::post('superadmin/search-hrhome-excel', 'AdminController@savereportroDatahrhomeemexcel');

Route::get('superadmin/inactive', 'App\Http\Controllers\AdminController@getCompaniesinactive');

Route::get('superadmin/verify', 'App\Http\Controllers\AdminController@getCompaniesverify');
Route::post('superadmin/verify-export', 'App\Http\Controllers\AdminController@getCompaniesverify_export');

Route::get('superadmin/not-assigned', 'App\Http\Controllers\AdminController@getCompaniesNotAssigned');
Route::post('superadmin/not-assigned-export', 'App\Http\Controllers\AdminController@getCompaniesNotAssigned_export');

Route::get('superadmin/assigned', 'App\Http\Controllers\AdminController@getCompaniesAssigned');
Route::post('superadmin/assigned-export', 'App\Http\Controllers\AdminController@getCompaniesAssigned_export');

Route::get('superadmin/notverify', 'App\Http\Controllers\AdminController@getCompaniesnot');
Route::get('superadmin/license-applied', 'App\Http\Controllers\AdminController@getCompanieslice');
Route::post('superadmin/license-applied-export', 'App\Http\Controllers\AdminController@getCompanieslice_export');
Route::get('superadmin/license-applied-internal', 'App\Http\Controllers\AdminController@getCompaniesWithInternalLicense');
Route::post('superadmin/license-applied-internal-export', 'App\Http\Controllers\AdminController@getCompaniesWithInternalLicense_export');
Route::get('superadmin/license-applied-external', 'App\Http\Controllers\AdminController@getCompaniesWithExternalLicense');
Route::post('superadmin/license-applied-external-export', 'App\Http\Controllers\AdminController@getCompaniesWithExternalLicense_export');

//21-01-2022
Route::get('superadmin/unbilled-first-inv-internal', 'App\Http\Controllers\AdminController@getCompaniesUnbilledFirstInvInternal');
Route::post('superadmin/unbilled-first-inv-internal-export', 'App\Http\Controllers\AdminController@getCompaniesUnbilledFirstInvInternal_export');

Route::get('superadmin/billed-first-inv-internal', 'App\Http\Controllers\AdminController@getCompaniesBilledFirstInvInternal');
Route::post('superadmin/billed-first-inv-internal-export', 'App\Http\Controllers\AdminController@getCompaniesBilledFirstInvInternal_export');

Route::get('superadmin/unassigned-hr-internal', 'App\Http\Controllers\AdminController@getCompaniesUnassignedHrInternal');
Route::post('superadmin/unassigned-hr-internal-export', 'App\Http\Controllers\AdminController@getCompaniesUnassignedHrInternal_export');

Route::get('superadmin/assigned-hr-internal', 'App\Http\Controllers\AdminController@getCompaniesAssignedHrInternal');
Route::post('superadmin/assigned-hr-internal-export', 'App\Http\Controllers\AdminController@getCompaniesAssignedHrInternal_export');

Route::get('superadmin/wip-hr-internal', 'App\Http\Controllers\AdminController@getCompaniesWipHrInternal');
Route::post('superadmin/wip-hr-internal-export', 'App\Http\Controllers\AdminController@getCompaniesWipHrInternal_export');

Route::get('superadmin/complete-hr-internal', 'App\Http\Controllers\AdminController@getCompaniesCompleteHrInternal');
Route::post('superadmin/complete-hr-internal-export', 'App\Http\Controllers\AdminController@getCompaniesCompleteHrInternal_export');

Route::get('superadmin/granted-hr-internal', 'App\Http\Controllers\AdminController@getCompaniesGrantedHrInternal');
Route::post('superadmin/granted-hr-internal-export', 'App\Http\Controllers\AdminController@getCompaniesGrantedHrInternal_export');

Route::get('superadmin/rejected-hr-internal', 'App\Http\Controllers\AdminController@getCompaniesRejectedHrInternal');
Route::post('superadmin/rejected-hr-internal-export', 'App\Http\Controllers\AdminController@getCompaniesRejectedHrInternal_export');

Route::get('superadmin/refused-hr-internal', 'App\Http\Controllers\AdminController@getCompaniesRefusedHrInternal');
Route::post('superadmin/refused-hr-internal-export', 'App\Http\Controllers\AdminController@getCompaniesRefusedHrInternal_export');

Route::get('superadmin/license-pending-internal', 'App\Http\Controllers\AdminController@getCompaniesPdHrInternal');
Route::post('superadmin/license-pending-internal-export', 'App\Http\Controllers\AdminController@getCompaniesPdHrInternal_export');

Route::get('superadmin/unbilled-second-invoice-internal', 'App\Http\Controllers\AdminController@getCompaniesUnbilledSecondInvInternal');
Route::post('superadmin/unbilled-second-invoice-internal-export', 'App\Http\Controllers\AdminController@getCompaniesUnbilledSecondInvInternal_export');

Route::get('superadmin/billed-second-invoice-internal', 'App\Http\Controllers\AdminController@getCompaniesBilledSecondInvInternal');
Route::post('superadmin/billed-second-invoice-internal-export', 'App\Http\Controllers\AdminController@getCompaniesBilledSecondInvInternal_export');

//------

Route::get('superadmin/license-not-applied', 'App\Http\Controllers\AdminController@getCompaniesnotlicen');

Route::get('mailormsgcenemp', function () {

    $email = Session::get('emp_email');

    return View('mailormsgcenemp', $data);
});

Route::get('mailsolvedcom', function () {

    $email = Session::get('emp_email');

    return View('mailsolvedcom', $data);
});

Route::get('mailormsgcenrecru', function () {

    $email = Session::get('emp_email');

    return View('mailormsgcenrecru', $data);
});
Route::get('mailemployemigrsend', function () {

    $email = Session::get('emp_email');

    return View('mailemployemigrsend', $data);
});

Route::get('mailormsgcen', function () {

    $email = Session::get('emp_email');

    return View('mailormsgcen', $data);
});
Route::get('mailorpayre', function () {

    $email = Session::get('emp_email');

    return View('mailorpayre', $data);
});

Route::get('mailnewcom', function () {

    $email = Session::get('emp_email');

    return View('mailnewcom', $data);
});

Route::get('mailbillsend', function () {

    $email = Session::get('emp_email');

    return View('mailbillsend', $data);
});
Route::get('mailorupli', function () {

    $email = Session::get('emp_email');

    return View('mailorupli', $data);
});
Route::get('mail', function () {

    $email = Session::get('emp_email');

    return View('mail', $data);
});

Route::get('mailsend', function () {

    $email = Session::get('emp_email');

    return View('mailsend', $data);
});

Route::get('mailforgot', function () {

    $email = Session::get('emp_email');

    return View('mailforgot', $data);
});

Route::get('mailempnew', function () {

    $email = Session::get('emp_email');

    return View('mailempnew', $data);
});

Route::get('mailre', function () {

    return View('mailre', $data);
});

Route::get('mailor', function () {

    return View('mailor', $data);
});

Route::get('mailorup', function () {

    return View('mailorup', $data);
});

Route::get('mailorupnew', function () {

    return View('mailorupnew', $data);
});
Route::get('mailjob', function () {

    $email = Session::get('emp_email');

    return View('mailjob', $data);
});
Route::get('mailjobapply', function () {

    $email = Session::get('emp_email');

    return View('mailjobapply', $data);
});
Route::get('mailjobapplyinterview', function () {

    $email = Session::get('emp_email');

    return View('mailjobapplyinterview', $data);
});

Route::get('mailjobre', function () {

    $email = Session::get('emp_email');

    return View('mailjobre', $data);
});
Route::get('mailreth', function () {

    $email = Session::get('emp_email');

    return View('mailreth', $data);
});

Route::get('mainLogout', 'App\Http\Controllers\LandingController@Logout');
Route::get('mainuesrLogout', 'App\Http\Controllers\LandingController@Logoutusert');

Route::get('taskdashboard', 'App\Http\Controllers\TaskController@viewdash');
Route::get('task-list', 'App\Http\Controllers\TaskController@viewtasklist');
Route::get('task-list-employee', 'App\Http\Controllers\TaskController@viewtaskemployeelist');
Route::post('task-list-employee', 'App\Http\Controllers\TaskController@gettaskemployeelist');
Route::get('task-add', 'App\Http\Controllers\TaskController@viewadd');
Route::post('task-save', 'App\Http\Controllers\TaskController@viewsave');

Route::get('settingdashboard', 'App\Http\Controllers\SettingController@viewdash');

Route::get('settings/vw-grade', 'App\Http\Controllers\SettingController@getGrade');
Route::get('settings/edit-grades/{id}', 'App\Http\Controllers\SettingController@viewAddNewGrade');
Route::post('settings/add-new-grade', 'App\Http\Controllers\SettingController@saveGradeData');
Route::post('settings/updateGrd', 'App\Http\Controllers\SettingController@updateGrades');


Route::get('settings/vw-class', 'App\Http\Controllers\SettingController@getClasses');
Route::get('settings/edit-classes/{id}', 'App\Http\Controllers\SettingController@getClassesById');
Route::post('settings/update-classes', 'App\Http\Controllers\SettingController@updateClassById');
Route::get('settings/add-new-class', 'App\Http\Controllers\SettingController@viewAddNewClass');
Route::post('settings/add-new-class', 'App\Http\Controllers\SettingController@saveClassData');

Route::get('settings/vw-pincode', 'App\Http\Controllers\SettingController@getPincode');
Route::get('settings/edit-pincode/{id}', 'App\Http\Controllers\SettingController@pincodeGetbyId');
Route::get('settings/add-new-pincode', 'App\Http\Controllers\SettingController@viewAddNewPincode');
Route::post('settings/add-new-pincode', 'App\Http\Controllers\SettingController@savePincodeData');
Route::post('settings/updatepincode', 'App\Http\Controllers\SettingController@pincodeUpdate');

Route::get('settings/vw-type', 'App\Http\Controllers\SettingController@getType');
Route::get('settings/edit-type/{id}', 'App\Http\Controllers\SettingController@typeofedit');
Route::post('settings/vw-emp-update', 'App\Http\Controllers\SettingController@typeofupdate');
Route::get('settings/add-new-type', 'App\Http\Controllers\SettingController@viewAddNewType');
Route::post('settings/add-new-type', 'App\Http\Controllers\SettingController@saveTypeData');

Route::get('settings/vw-mode-type', 'App\Http\Controllers\SettingController@getmodeOfEmpType');
Route::get('settings/add-mode-emp', 'App\Http\Controllers\SettingController@modeemployeeadd');
Route::post('settings/add-mode-emp-new', 'App\Http\Controllers\SettingController@addmodeemployeesucc');
Route::get('settings/mode-of-emp-edit/{id}', 'App\Http\Controllers\SettingController@editEmpMode');
Route::post('settings/mode-emp-new-update', 'App\Http\Controllers\SettingController@modeEmpUpdate');

//bank model vw-cmp-bank
Route::get('settings/vw-cmp-bank', 'App\Http\Controllers\SettingController@getCompanyBank');
Route::get('settings/add-company-bank', 'App\Http\Controllers\SettingController@addComapnyBankAdd');
Route::post('settings/add-new-bank-details', 'App\Http\Controllers\SettingController@addcmpbankDetails');
Route::get('settings/comapny-bank-edit/{id}', 'App\Http\Controllers\SettingController@cmpbankedit');
Route::post('settings/update-cmp-bank-details', 'App\Http\Controllers\SettingController@cmpBankDetailsupdate');


//bank model vw-employee-bank
Route::get('settings/vw-emp-bank', 'App\Http\Controllers\SettingController@getempBank');
Route::get('settings/add-emp-bank', 'App\Http\Controllers\SettingController@addempBankAdd');
// Route::post('settings/add-new-bank-details', 'App\Http\Controllers\SettingController@addempbankDetails');
Route::get('settings/emp-bank-edit/{id}', 'App\Http\Controllers\SettingController@empbankedit');
Route::post('settings/update-emp-bank-details', 'App\Http\Controllers\SettingController@empBankDetailsupdate');

//payrol
Route::get('settings/pflist', 'App\Http\Controllers\SettingController@getpflistt');
Route::get('settings/pfAdd', 'App\Http\Controllers\SettingController@getpfdetails');
Route::post('settings/addpfloan', 'App\Http\Controllers\SettingController@getaddpfdetails');
Route::get('settings/pf-Loan-details/{id}', 'App\Http\Controllers\SettingController@getpfUpdetails');
Route::post('settings/addpfloanUpdate', 'App\Http\Controllers\SettingController@pfloanupdatedetails');
Route::get('settings/bonus-rate', 'App\Http\Controllers\SettingController@getbonaslistt');
Route::get('settings/bonus-add', 'App\Http\Controllers\SettingController@getbonasadd');
Route::post('settings/bonusrateadd', 'App\Http\Controllers\SettingController@bonusrateaddFun');
Route::get('settings/bonas-rate-get/{id}', 'App\Http\Controllers\SettingController@bonusrategetFun');
Route::post('settings/bonusrateupdate', 'App\Http\Controllers\SettingController@bonusrateupdatefunc');
Route::get('settings/itaxList', 'App\Http\Controllers\SettingController@getitaxListFunc');
Route::get('settings/itax-add', 'App\Http\Controllers\SettingController@itaxaddfunc');
Route::post('settings/itexaddfuncdetail', 'App\Http\Controllers\SettingController@itexaddfuncdetail');
Route::get('settings/itex-rate-get/{id}', 'App\Http\Controllers\SettingController@itexUpdatefuncdetail');
Route::post('settings/itexaddfuncdetailupdate', 'App\Http\Controllers\SettingController@updateitex');
Route::get('settings/rate-master-list', 'App\Http\Controllers\SettingController@ratemasterget');
Route::get('settings/rate-master-add', 'App\Http\Controllers\SettingController@ratemasteradd');
Route::post('settings/ratemastermainFunc', 'App\Http\Controllers\SettingController@addfunctionratemaster');
Route::get('settings/rate-master-update-get/{id}', 'App\Http\Controllers\SettingController@ratemastergetandupdate');
Route::post('settings/masterupdatemainfunction', 'App\Http\Controllers\SettingController@ratemastergetandupdatebllb');

//rate details
Route::get('settings/rate-master-details', 'App\Http\Controllers\SettingController@ratemasterdetailsfunc');
Route::get('settings/rate-master-details-add', 'App\Http\Controllers\SettingController@ratemasteradddetails');
Route::get('settings/headmaster/{id}', 'App\Http\Controllers\SettingController@testhhh');
Route::post('settings/rate-save', 'App\Http\Controllers\SettingController@SubmitRateDetailsForm');
Route::get('settings/getupdateratedetails/{id}','App\Http\Controllers\SettingController@detailsoftherate');
Route::post('settings/rate-update-save','App\Http\Controllers\SettingController@ratedetailsupdateform');

Route::get('settings/vw-ifsc', 'App\Http\Controllers\SettingController@getIfsc');
Route::get('settings/add-new-ifsc', 'App\Http\Controllers\SettingController@viewAddNewIfsc');
Route::post('settings/add-new-ifsc', 'App\Http\Controllers\SettingController@saveIfscData');
Route::get('settings/edit-ifsc/{id}','App\Http\Controllers\SettingController@editviewAddNewIfsc');
Route::post('settings/update-ifsc','App\Http\Controllers\SettingController@updatesaveIfscData');


Route::get('settings/vw-caste', 'App\Http\Controllers\SettingController@getCaste');
Route::get('settings/add-new-caste', 'App\Http\Controllers\SettingController@viewAddNewCaste');
Route::post('settings/add-new-caste', 'App\Http\Controllers\SettingController@saveCasteData');
Route::get('settings/edit-cast/{id}', 'App\Http\Controllers\SettingController@castUpdate');
Route::post('settings/updateCast', 'App\Http\Controllers\SettingController@updateCast');

Route::get('settings/vw-subcast', 'App\Http\Controllers\SettingController@subcastGet');
Route::get('settings/add-sub-caste', 'App\Http\Controllers\SettingController@addsubcast');
Route::post('settings/add-sub-caste', 'App\Http\Controllers\SettingController@saveSubCasteData');
Route::get('settings/edit-sub-cast/{id}', 'App\Http\Controllers\SettingController@editSubCast');
Route::post('settings/update-sub-cast', 'App\Http\Controllers\SettingController@updateSubCast');

Route::get('settings/vw-religion', 'App\Http\Controllers\SettingController@getReligion');
Route::get('settings/add-new-religion', 'App\Http\Controllers\SettingController@viewAddNewReligion');
Route::post('settings/add-new-religion', 'App\Http\Controllers\SettingController@saveReligionData');
Route::get('settings/edit-new-religion/{id}', 'App\Http\Controllers\SettingController@editViewsaveReligionData');
Route::post('settings/update-new-religion', 'App\Http\Controllers\SettingController@updateViewsaveReligionData');

Route::get('settings/vw-education', 'App\Http\Controllers\SettingController@getEducation');
Route::get('settings/add-new-education', 'App\Http\Controllers\SettingController@viewAddNewEducation');
Route::post('settings/add-new-education', 'App\Http\Controllers\SettingController@saveEducationData');
Route::get('settings/edit-new-education/{id}','App\Http\Controllers\SettingController@editViewEducationData');
Route::post('settings/update-new-education', 'App\Http\Controllers\SettingController@editEducationData');

Route::get('settings/vw-department', 'App\Http\Controllers\SettingController@getDepartment');
Route::get('settings/add-new-department', 'App\Http\Controllers\SettingController@viewAddNewDepartment');
Route::post('settings/add-new-department', 'App\Http\Controllers\SettingController@saveDepartmentData');


Route::get('settings/vw-designation', 'App\Http\Controllers\SettingController@getDesignations');
Route::post('settings/designation', 'App\Http\Controllers\SettingController@saveDesignation');
Route::get('settings/designation', 'App\Http\Controllers\SettingController@viewAddDesignation');

Route::get('settings/vw-employee-type', 'App\Http\Controllers\SettingController@getEmployeeTypes');
Route::get('settings/employee-type', 'App\Http\Controllers\SettingController@viewAddEmployeeType');
Route::post('settings/employee-type', 'App\Http\Controllers\SettingController@saveEmployeeType');
Route::get('settings/employee-type/{id}', 'App\Http\Controllers\SettingController@getTypeById');
Route::get('settings/vw-paygroup', 'App\Http\Controllers\SettingController@getGrades');
Route::get('settings/paygroup', 'App\Http\Controllers\SettingController@viewAddGrade');
Route::post('settings/paygroup', 'App\Http\Controllers\SettingController@saveGrade');

Route::get('settings/payitemlist', 'App\Http\Controllers\SettingController@getRateList');

Route::get('settings/pay-item-details/{rate_id}', 'App\Http\Controllers\SettingController@getRateChart');
Route::post('settings/pay-item-details', 'App\Http\Controllers\SettingController@saveRateChart');

Route::get('settings/bank-sortcode', 'App\Http\Controllers\SettingController@viewAddBank');
Route::post('settings/bank-sortcode', 'App\Http\Controllers\SettingController@saveBank');
Route::get('settings/vw-bank-sortcode', 'App\Http\Controllers\SettingController@getBanks');

Route::get('settings/bank', 'App\Http\Controllers\SettingController@viewAddBankmanin');
Route::post('settings/bank', 'App\Http\Controllers\SettingController@saveBankmain');
Route::get('settings/vw-bank', 'App\Http\Controllers\SettingController@getBanksmain');

Route::get('settings/vw-annualpay', 'App\Http\Controllers\SettingController@getPayscale');
Route::get('settings/annualpay', 'App\Http\Controllers\SettingController@viewAddPayscale');
Route::post('settings/annualpay', 'App\Http\Controllers\SettingController@savePayscale');

Route::get('documentsdashboard', 'App\Http\Controllers\DocumentsController@viewdash');
Route::get('document/staff-report', 'App\Http\Controllers\DocumentsController@getEmployeesstaff');

Route::get('document/organisation-report', 'App\Http\Controllers\DocumentsController@getorganisantionrepo');
Route::get('document/employee-report', 'App\Http\Controllers\DocumentsController@getemployeerepo');
Route::post('document/employee-report', 'App\Http\Controllers\DocumentsController@downorganisantionrepoemployee');

Route::get('document/employee-archive-report', 'App\Http\Controllers\DocumentsController@getemployeearchiverepo');
Route::post('document/employee-archive-report', 'App\Http\Controllers\DocumentsController@downorganisantionrepoemployee_archive');

Route::get('pis/getEmployeedreportfileById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('employee')

        ->where('emp_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    $employee_rs = DB::table('employee_qualification')

        ->where('emp_id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $employee_upload_rs = DB::table('employee_upload')

        ->where('emp_id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        if ($bank->doc != '') {
            $result_status1 .= '<option value="' . $bank->quli . ' Transcript Document">' . $bank->quli . ' Transcript Document</option>';

        }
        if ($bank->doc2 != '') {
            $result_status1 .= '<option value="' . $bank->quli . ' Certificate Document">' . $bank->quli . ' Certificate Document</option>';

        }
    }

    foreach ($employee_upload_rs as $bankjj) {
        if ($bankjj->type_doc != '') {
            $result_status1 .= '<option value="' . $bankjj->type_doc . '">' . $bankjj->type_doc . '</option>';

        }

    }
    if ($desig_rs->pr_add_proof != '') {
        $result_status1 .= '<option value="pr_add_proof">Proof Of Correspondence   Address </option>';

    }
    if ($desig_rs->pass_docu != '') {
        $result_status1 .= '<option value="pass_docu">Passport Document </option>';

    }
    if ($desig_rs->visa_upload_doc != '') {
        $result_status1 .= '<option value="visa_upload_doc">Visa Document </option>';

    }
    if ($desig_rs->dbs_upload_doc != '') {
        $result_status1 .= '<option value="dbs_upload_doc">DBS Document </option>';

    }

    $employee_otherd_doc_rs = DB::table('employee_other_doc')
        ->where('emid', '=', $Roledata->reg)
        ->where('emp_code', '=', $empid)
        ->get();
    foreach ($employee_otherd_doc_rs as $bankjjnew) {
        if ($bankjjnew->doc_upload_doc != '') {
            $result_status1 .= '<option value="' . $bankjjnew->doc_name . '">' . $bankjjnew->doc_name . '</option>';

        }

    }
    if ($desig_rs->euss_upload_doc != '') {
        $result_status1 .= '<option value="euss_upload_doc">EUSS    Document </option>';

    }
    if ($desig_rs->nat_upload_doc != '') {
        $result_status1 .= '<option value="nat_upload_doc">National Id    Document </option>';

    }
    echo $result_status1;

});

Route::get('settings/get-add-row-item-upload-other/{row}', function ($row) {

    $row = $row + 1;
    $country = '';
    $currency_user = DB::table('currencies')->orderBy('country', 'asc')->get();
    foreach ($currency_user as $currency_valu) {
        $country .= ' <option value="' . trim($currency_valu->country) . '" >' . trim($currency_valu->country) . '</option>';
    }
    $result = '

                   <div class="row itemslototherupload" id=" ' . $row . '">
				   <div class="col-md-3">

<div class="form-group ">
<label for="inputFloatingLabeldn' . $row . '" class="col-form-label">Document name.</label>
<input id="inputFloatingLabeldn' . $row . '" type="text" class="form-control"  name="doc_name[]">


</div>
</div>
				   		<div class="col-md-3">

<div class="form-group">
<label for="inputFloatingLabeldn' . $row . '" class="col-form-label">Document reference number.</label>
<input id="inputFloatingLabeldn' . $row . '" type="text" class="form-control"  name="doc_ref_no[]">


</div>
</div>


			            <div class="col-md-3">
				  <div class="form-group">
				  	<label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
												<select class="form-control" id="selectFloatingLabelntp"  name="doc_nation[]" >
												<option value="">&nbsp;</option>
												' . $country . '
			</select>

											</div>
						</div>

				   	<div class="col-md-3">

						<div class="form-group">
							<label for="inputFloatingLabelid' . $row . '" class="col-form-label">Issued Date</label>
						<input id="inputFloatingLabelid' . $row . '" type="date" class="form-control" name="doc_issue_date[]">
																													</div>
			</div>

				   <div class="col-md-3">
							<div class="form-group" >	<label for="doc_exp_date" class="col-form-label">Expiry Date</label>	<input id="doc_exp_date' . $row . '" type="date" class="form-control" name="doc_exp_date[]"
onchange="getreviewnatdateother(' . $row . ');">
																													</div>
			</div>
				   		<div class="col-md-3">

					<div class="form-group">
						<label for="doc_review_date" class="col-form-label"  style="margin-top:-12px;">Eligible Review Date</label>
					<input id="doc_review_date' . $row . '" type="date" readonly class="form-control" name="doc_review_date[]">
																														</div>
			</div>

							<div class="col-md-3">
							<label>Upload Document</label>
								<input type="file" class="form-control" name="doc_upload_doc' . $row . '[]" id="doc_upload_doc' . $row . '" onchange="Filevalidationdopassduploadnatother( ' . $row . ')">
								 <small> Please select  file which size up to 2mb</small>
						</div>



						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="doc_cur[]" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="doc_cur[]" value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">

								<div class="form-group">
									<label for="inputFloatingLabelrm' . $row . '" class="col-form-label">Remarks</label>
												<input id="inputFloatingLabelrm' . $row . '" type="text" class="form-control" name="doc_remarks[]" >

											</div>
						</div>


		 <div class="col-md-4" style="margin-top:27px;"><button class="btn-success" type="button"  id="adduploadother' . $row . '" onClick="addnewrowuploadother(' . $row . ')" data-id=" ' . $row . '"><i class="fas fa-plus"></i> </button>


		 <button class="btn-danger deleteButtonuploadother" type="button" id="deluploadother' . $row . '"  onClick="delRowuploadother(' . $row . ')"> <i class="fas fa-minus"></i> </button></div>
				</div>

						</div>



				    </br>	  ';
    echo $result;
});

Route::get('pis/getEmployeedreportfileByInewscand/{empid}/{val}', function ($empid, $val) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('employee')

        ->where('emp_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('employee_qualification')

        ->where('emp_id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = '';
    if ($val == 'pr_add_proof') {

        if ($desig_rs->pr_add_proof != '') {
            $result_status1 = $desig_rs->pr_add_proof;

        } else {
            $result_status1 = '';
        }
    }

    $employee_upload_rs = DB::table('employee_upload')

        ->where('emp_id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    foreach ($employee_upload_rs as $bankjj) {
        if ($bankjj->type_doc != '' && $bankjj->type_doc == $val) {
            $result_status1 = $bankjj->docu_nat;

        }
    }

    $employee_otherd_doc_rs = DB::table('employee_other_doc')
        ->where('emid', '=', $Roledata->reg)
        ->where('emp_code', '=', $empid)
        ->get();
    foreach ($employee_otherd_doc_rs as $bankjjnew) {
        if ($bankjjnew->doc_upload_doc != '' && $bankjjnew->doc_name == $val) {
            $result_status1 = $bankjjnew->doc_upload_doc;
        }

    }

    if ($val == 'pass_docu') {

        if ($desig_rs->pass_docu != '') {
            $result_status1 = $desig_rs->pass_docu;

        } else {
            $result_status1 = '';
        }
    }

    if ($val == 'visa_upload_doc') {

        if ($desig_rs->visa_upload_doc != '') {
            $result_status1 = $desig_rs->visa_upload_doc;

            if ($desig_rs->visaback_doc != '') {
                $result_status1 .= ',' . $desig_rs->visaback_doc;
            }

        } else {
            $result_status1 = '';
        }
    }
    if ($val == 'euss_upload_doc') {
        if ($desig_rs->euss_upload_doc != '') {
            $result_status1 = $desig_rs->euss_upload_doc;

        } else {
            $result_status1 = '';
        }

    }
    if ($val == 'nat_upload_doc') {
        if ($desig_rs->nat_upload_doc != '') {
            $result_status1 = $desig_rs->nat_upload_doc;

        } else {
            $result_status1 = '';
        }
    }

    $word = "Transcript Document";
    $word1 = "Certificate Document";

    if (strpos($val, $word) !== false) {

        $newstr = explode("Transcript Document", $val);
        $new_gan = trim($newstr[0]);
        $company_uprs = DB::table('employee_qualification')->where('emid', '=', $Roledata->reg)->where('emp_id', '=', $empid)
            ->where('quli', '=', $new_gan)->orderBy('id', 'DESC')
            ->first();
        if ($company_uprs->doc != '') {
            $result_status1 = $company_uprs->doc;
        } else {
            $result_status1 = '';
        }

    } else if (strpos($val, $word1) !== false) {
        $newstr = explode("Certificate Document", $val);
        $new_gan = trim($newstr[0]);

        $company_uprs = DB::table('employee_qualification')->where('emid', '=', $Roledata->reg)
            ->where('emp_id', '=', $empid)->where('quli', '=', $new_gan)->orderBy('id', 'DESC')
            ->first();
        if ($company_uprs->doc2 != '') {
            $result_status1 = $company_uprs->doc2;
        } else {
            $result_status1 = '';
        }

    }
    echo $result_status1;

});

Route::get('dashboarddetails', 'App\Http\Controllers\DashboardController@getamployeedas');
Route::get('dashboard-employees', 'App\Http\Controllers\DashboardController@getEmployees');
Route::get('dashboard-right-works', 'App\Http\Controllers\DashboardController@getEmployeesright');
Route::get('add-right-works', 'App\Http\Controllers\DashboardController@addEmployeesright');
Route::post('add-right-works', 'App\Http\Controllers\DashboardController@saveEmployeesright');
Route::get('dashboard-migrant-employees', 'App\Http\Controllers\DashboardController@getEmployeesmigrant');
Route::get('add-right-works-by-datecheck', 'App\Http\Controllers\DashboardController@addEmployeesrightByDate');
Route::post('add-right-works-by-date', 'App\Http\Controllers\DashboardController@saveEmployeesrightByDate');
Route::get('dashboard/work-view/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailswork');
Route::get('dashboard/work-view-auth/{send_id}/{eml}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailsworkauth');
Route::get('dashboard/work-view-download/{send_id}', 'App\Http\Controllers\DashboardController@downloadsendcandidatedetailswork');
Route::get('dashboard/edit-work-view/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailsworkedit');
Route::get('dashboard/absent-report', 'App\Http\Controllers\DashboardController@viewattendanabsent');
Route::post('edit-right-works', 'App\Http\Controllers\DashboardController@saveEmployeesrightedit');
Route::get('dashboard/migrant-firstletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetails');
Route::get('dashboard/migrant-firstletter-sendnew/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailssendnew');
Route::get('mailsendfirt', function () {

    $email = Session::get('emp_email');

    return View('mailsendfirt', $data);
});

Route::get('dashboard/migrant-secondletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailssecond');
Route::get('dashboard/migrant-secondletter-sendnew/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailssecondsendnew');
Route::get('mailsendsecond', function () {

    $email = Session::get('emp_email');

    return View('mailsendsecond', $data);
});

Route::get('dashboard/changesendlet/{send_id}/{date}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailsthirdsend_iddate');

Route::get('employee/changesendlet/{send_id}/{date}', 'App\Http\Controllers\EmployeeController@viewsendcandidatedetailsthirdsend_iddate');

Route::get('mailcircum', function () {

    $email = Session::get('emp_email');

    return View('mailcircum', $data);
});
Route::get('dashboard/migrant-thirdletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailsthird');
Route::get('dashboard/migrant-thirdletter-sendnew/{send_id}', 'App\Http\Controllers\DashboardController@viewsendcandidatedetailsthirdsendnew');
Route::get('mailsendthird', function () {

    $email = Session::get('emp_email');

    return View('mailsendthird', $data);
});
Route::get('dashboard/migrant-dash-firstletter/{send_id}', 'App\Http\Controllers\DashboardController@viewofferdownsendcandidatedetails');
Route::get('dashboard/migrant-dash-secondletter/{send_id}', 'App\Http\Controllers\DashboardController@viewofferdownsendcandidatedetailssecond');
Route::get('dashboard/migrant-dash-thiredletter/{send_id}', 'App\Http\Controllers\DashboardController@viewofferdownsendcandidatedetailsthired');
Route::get('dashboard/change/{send_id}/{date}', 'App\Http\Controllers\DashboardController@viewofferdownsendcandidatedetailssend_iddate');

//cron route start
Route::get('cron/migrant-dash-firstletter/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewofferdownsendcandidatedetails');
Route::get('cron/migrant-dash-secondletter/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewofferdownsendcandidatedetailssecond');
Route::get('cron/migrant-dash-thiredletter/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewofferdownsendcandidatedetailsthired');

Route::get('cron/migrant-firstletter-sendnew/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewsendcandidatedetailssendnew');
Route::get('cron/migrant-secondletter-sendnew/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewsendcandidatedetailssecondsendnew');
Route::get('cron/migrant-thirdletter-sendnew/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewsendcandidatedetailsthirdsendnew');

Route::get('cron/visa-reminder', 'App\Http\Controllers\MyCronController@visaReminderNotification');

Route::get('cron/migrant-euss-firstletter/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewofferdowneuss');
Route::get('cron/migrant-euss-secondletter/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewofferdownsendeusssecond');
Route::get('cron/migrant-euss-thiredletter/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewofferdownsendeussthired');

Route::get('cron/migrant-eussfirstletter-sendnew/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewsendeusssendnew');
Route::get('cron/migrant-eusssecondletter-sendnew/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewsendeusssecondsendnew');
Route::get('cron/migrant-eussthirdletter-sendnew/{send_id}/{emid}', 'App\Http\Controllers\MyCronController@viewsendeussthirdsendnew');

Route::get('cron/euss-reminder', 'App\Http\Controllers\MyCronController@eussReminderNotification');

Route::get('cron/subscription-reminder', 'App\Http\Controllers\MyCronController@subscription_reminder');

Route::get('cron/license-pending-reminder', 'App\Http\Controllers\MyCronController@spl_reminder');
// cron route end

Route::post('dashboard/absent-report', 'App\Http\Controllers\DashboardController@getattendanabsent');
Route::get('dashboard/absent-record-card/{absent_id}/{year_value}', 'App\Http\Controllers\DashboardController@viewattendanabsentreport');
Route::get('dashboard/absent-record-card-pdf/{absent_id}/{year_value}', 'App\Http\Controllers\DashboardController@viewattendanabsentreportpdf');
Route::get('dashboard/change-of-circumstances', 'App\Http\Controllers\DashboardController@viewchangecircumstancesedit');
Route::get('dashboard/edit-dashboard-company', 'App\Http\Controllers\DashboardController@viewAddCompany');
Route::post('dashboard/change-of-circumstances', 'App\Http\Controllers\DashboardController@savechangecircumstancesedit');

Route::get('dashboard/contract-agreement', 'App\Http\Controllers\DashboardController@viewemployeeagreement');
Route::get('dashboard/sponsor-management-dossier', 'App\Http\Controllers\DashboardController@getEmployeesdossier');

Route::post('dashboard/contract-agreement', 'App\Http\Controllers\DashboardController@saveemployeeagreement');
Route::get('dashboard/contract-agreement-edit/{agreement_id}', 'App\Http\Controllers\DashboardController@viewemployeeagreementdit');
Route::get('dashboard/contract-word/{agreement_id}', 'App\Http\Controllers\DashboardController@msword');
Route::get('dashboard/send-mail/{comp_id}/{emp_id}', 'App\Http\Controllers\DashboardController@viewAddEmployeereportnewsenmail');
Route::get('dashboard-details/send-mail/{comp_id}/{emp_id}', 'App\Http\Controllers\DashboardController@viewAddEmployeereportnewsenmailtext');

Route::get('dashboard/message-center', 'App\Http\Controllers\DashboardController@viewmsgcen');
Route::get('dashboard/add-message-center', 'App\Http\Controllers\DashboardController@addmscen');
Route::post('dashboard/add-message-center', 'App\Http\Controllers\DashboardController@savemscen');
Route::post('dashboard/send-mail-migrant', 'App\Http\Controllers\DashboardController@savemscenmigrant');

Route::get('superadmin/activity-log', 'App\Http\Controllers\AdminController@view_activity_log');
Route::post('superadmin/activity-log', 'App\Http\Controllers\AdminController@get_activity_log');

Route::get('pis/getbillorganmsgnewempmsgById/{empid}', function ($empid) {

    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();
    $data['Roledata'] = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::Table('employee')
        ->where('emid', '=', $Roledata->reg)
        ->where('emp_code', '=', $empid)
        ->first();

    echo json_encode(array($employee_rs));

});

Route::post('document/organisation-report', 'App\Http\Controllers\DocumentsController@downorganisantionrepo');

Route::get('dashboard/passportmigrant-dash-firstletter/{send_id}', 'App\Http\Controllers\DashboardController@viewpassportdownsendcandidatedetails');
Route::get('dashboard/passportmigrant-dash-secondletter/{send_id}', 'App\Http\Controllers\DashboardController@viewpassportdownsendcandidatedetailssecond');
Route::get('dashboard/passportmigrant-dash-thiredletter/{send_id}', 'App\Http\Controllers\DashboardController@viewpassportdownsendcandidatedetailsthired');

Route::get('dashboard/passportmigrant-firstletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewpassportsendcandidatedetails');
Route::get('passmailsendfirt', function () {

    $email = Session::get('emp_email');

    return View('passmailsendfirt', $data);
});

Route::get('dashboard/passportmigrant-secondletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewpassportsendcandidatedetailssecond');
Route::get('passmailsendsecond', function () {

    $email = Session::get('emp_email');

    return View('passmailsendsecond', $data);
});

Route::get('dashboard/passportmigrant-thirdletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewpassportsendcandidatedetailsthird');
Route::get('passmailsendthird', function () {

    $email = Session::get('emp_email');

    return View('passmailsendthird', $data);
});

Route::get('dashboard-details/passend-mail/{comp_id}/{emp_id}', 'App\Http\Controllers\DashboardController@viewAddpassportEmployeereportnewsenmailtext');


//dbs
Route::get('dashboard/dbsmigrant-dash-firstletter/{send_id}', 'App\Http\Controllers\DashboardController@viewdbsdownsendcandidatedetails');
Route::get('dashboard/dbsmigrant-dash-secondletter/{send_id}', 'App\Http\Controllers\DashboardController@viewdbsdownsendcandidatedetailssecond');
Route::get('dashboard/dbsmigrant-dash-thiredletter/{send_id}', 'App\Http\Controllers\DashboardController@viewdbsdownsendcandidatedetailsthired');

Route::get('dashboard/dbsmigrant-firstletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewdbssendcandidatedetails');
Route::get('dashboard/dbsmigrant-secondletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewdbssendcandidatedetailssecond');
Route::get('dashboard/dbsmigrant-thirdletter-send/{send_id}', 'App\Http\Controllers\DashboardController@viewdbssendcandidatedetailsthird');

//euss
Route::get('dashboard/eussmigrant-dash-firstletter/{send_id}', 'App\Http\Controllers\DashboardController@vieweussdownsendcandidatedetails');
Route::get('dashboard/eussmigrant-dash-secondletter/{send_id}', 'App\Http\Controllers\DashboardController@vieweussdownsendcandidatedetailssecond');
Route::get('dashboard/eussmigrant-dash-thiredletter/{send_id}', 'App\Http\Controllers\DashboardController@vieweussdownsendcandidatedetailsthired');

Route::get('dashboard/eussmigrant-firstletter-send/{send_id}', 'App\Http\Controllers\DashboardController@vieweusssendcandidatedetails');
Route::get('dashboard/eussmigrant-secondletter-send/{send_id}', 'App\Http\Controllers\DashboardController@vieweusssendcandidatedetailssecond');
Route::get('dashboard/eussmigrant-thirdletter-send/{send_id}', 'App\Http\Controllers\DashboardController@vieweusssendcandidatedetailsthird');
//------

Route::post('document/staff-report', 'App\Http\Controllers\DocumentsController@reportEmployeesstaff');
Route::post('document/staff-report-excel', 'App\Http\Controllers\DocumentsController@reportEmployeesexcelstaff');

Route::get('employee/dashboard', 'App\Http\Controllers\EmployeeController@getamployeedas');
Route::get('employees', 'App\Http\Controllers\EmployeeController@getEmployees');
Route::get('employeesadd', 'App\Http\Controllers\EmployeeController@getEmployeeAddFun');
Route::get('employees-left', 'App\Http\Controllers\DocumentsController@getEmployeesLeft');
Route::get('migrant-employees', 'App\Http\Controllers\EmployeeController@getEmployeesmigrant');
Route::get('addemployee', 'App\Http\Controllers\EmployeeController@viewAddEmployee');
Route::post('posts','App\Http\Controllers\EmployeeController@testqueexample');
Route::get('settings/get-add-row-earn/{row}', 'App\Http\Controllers\EmployeeController@ajaxAddRowearn');
Route::get('settings/get-add-row-deduct/{row}', 'App\Http\Controllers\EmployeeController@ajaxAddRowdeduct');
// Route::post('posts', [EmployeeController::class, 'testque'])->name('posts.store');
Route::post('employee/savemploy','App\Http\Controllers\EmployeeController@saveEmployeeaa');
Route::get('employee/get-earn/{headname}/{val}/{emp_basic_pay}','App\Http\Controllers\EmployeeController@ajaxAddvalue');

//swch new route
Route::get('employees', 'App\Http\Controllers\EmployeeController@getEmployees');
Route::post('addemployee', 'App\Http\Controllers\EmployeeController@saveEmployee');

//end swch new route

Route::get('migrant-addemployee', 'App\Http\Controllers\EmployeeController@viewAddEmployeemigrant');
// Route::post('addemployee', 'App\Http\Controllers\EmployeeController@saveEmployee');
Route::post('addemployee-bulk-upload', 'App\Http\Controllers\EmployeeController@uploadEmployee')->name('addemployee.bulk.upload');
Route::post('addemployee-by-form', 'App\Http\Controllers\EmployeeController@addEmployeeByForm')->name('addemployee.by.form');
Route::get('/download-employees-excel', 'App\Http\Controllers\EmployeeController@downloadExcel')->name('download.employees.excel');
Route::get('/download-sample-employee-excel', 'App\Http\Controllers\EmployeeController@downloadSampleExcel')->name('download.sample.employee.excel');
Route::get('/employees/{id}/edit', 'App\Http\Controllers\EmployeeController@edit')->name('employees.edit');
Route::put('/employees/{id}/update', 'App\Http\Controllers\EmployeeController@update')->name('employees.update');
Route::get('/employees/{id}', 'App\Http\Controllers\EmployeeController@destroy')->name('employees.destroy');
Route::get('employee/generate-report', 'App\Http\Controllers\EmployeeController@generateReport')->name('generate.report');
Route::get('employee/download-report', 'App\Http\Controllers\EmployeeController@downloadEmployeeReport')->name('download.report');
Route::post('migrant-addemployee', 'App\Http\Controllers\EmployeeController@saveEmployeemigrant');
Route::get('employee/contract-word/{agreement_id}', 'App\Http\Controllers\EmployeeController@msword');
//employee
Route::get('employeeslist', 'App\Http\Controllers\EmployeeController@employeeblade');
Route::get('employee-edit-view/{id}', 'App\Http\Controllers\EmployeeController@employeeeditview');
Route::get('settings/employee-update-get/{id}', 'App\Http\Controllers\EmployeeController@employeeupdatepage');
Route::post('employee/update-profile', 'App\Http\Controllers\EmployeeController@saveEmployeecoedit');

// employee ajax department phase
Route::get('employee/department-name/{emp_department}', 'App\Http\Controllers\EmployeeController@EmpDepartment');

Route::get('employee-add/employee-report/{comp_id}/{emp_id}', 'App\Http\Controllers\EmployeeController@viewAddEmployeereportnew');
Route::get('employee-add/employee-report-excel/{comp_id}/{emp_id}', 'App\Http\Controllers\EmployeeController@viewAddEmployeereportnewexcel');
Route::get('employee/send-mail/{comp_id}/{emp_id}', 'App\Http\Controllers\EmployeeController@viewAddEmployeereportnewsenmail');

Route::get('new-employee/{reg_id}/{emp_id}', 'App\Http\Controllers\EmployeeController@newaddEmployee');
Route::post('new-employe/save-new', 'App\Http\Controllers\EmployeeController@savenewEmployee');

Route::get('new-employe/thank-you', 'App\Http\Controllers\EmployeeController@thanknewEmployee');

Route::get('employee/change-of-circumstances', 'App\Http\Controllers\EmployeeController@viewchangecircumstancesedit');
Route::get('employee/change-of-circumstances-add', 'App\Http\Controllers\EmployeeController@viewchangecircumstanceseditadd');
Route::get('employee/change-of-circumstances-add-new', 'App\Http\Controllers\EmployeeController@viewchangecircumstanceseditnew');

Route::post('employee/change-of-circumstances-add-new', 'App\Http\Controllers\EmployeeController@savechangecircumstanceseditnewsave');
Route::post('employee/change-of-circumstances', 'App\Http\Controllers\EmployeeController@savechangecircumstancesedit');
Route::post('employee/employee-circumstances-report', 'App\Http\Controllers\EmployeeController@reportEmployeesstaff');
Route::post('employee/employee-circumstances-report-excel', 'App\Http\Controllers\EmployeeController@reportEmployeesexcelstaff');
Route::get('employee/edit-change-cir/{comp_id}', 'App\Http\Controllers\EmployeeController@viewAddchangeew');
Route::post('employee/edit-change-cir', 'App\Http\Controllers\EmployeeController@saveAddchangegynew');

Route::get('leaveapprovedashboard', 'App\Http\Controllers\LeaveApproverController@viewdash');

Route::get('leave-approver/leave-request', 'App\Http\Controllers\LeaveApproverController@viewLeaveApproved');

Route::get('leave-approver/leave-approved-right/{id}', 'App\Http\Controllers\LeaveApproverController@ViewLeavePermission');
Route::post('leave-approver/leave-approved-right', 'App\Http\Controllers\LeaveApproverController@SaveLeavePermission');

// Route::get('settings/get-add-row-item/{row}', function ($row) {
//     $row = $row + 1;

//     $result = ' <tr class="itemslot" id="' . $row . '" >
// 					    <td>' . $row . '</td>
// 						 <td>
//                          <select class="form-control" name="document_name[]">
//                          <option></option>
//                          <option value="aadhar card">Aadhar Card</option>
//                          <option value="voter">Voter Id</option>
//                          <option value="Pan">Pan Card</option>
//                          <option value="driving licence">Driving Licence</option>
//                          <option value="passport">Passport</option>
//                          </select>
//                          </td>
//                          <td><input type="file" class="form-control" name="document_upload[]"></td>
// 						 <td><button class="btn-success" type="button" id="add' . $row . '" onClick="addnewrow(' . $row . ')" data-id="' . $row . '"> <i class="fas fa-plus"></i> </button>
// 						 <button class="btn-danger deleteButton" type="button" id="del' . $row . '"  onClick="delRow(' . $row . ')"> <i class="fas fa-minus"></i> </button></td>
// 					  </tr>';
//     echo $result;
// });
Route::get('settings/get-add-row-item/{row}', function ($row) {

    $row = $row + 1;

    $result = ' <tr class="itemslot" id="' . $row . '" >
					    <td>' . $row . '</td>
						 <td><input type="text" class="form-control" name="quli[]"></td>
						 <td><input type="text" class="form-control" name="dis[]"></td>
						 <td><input type="text" class="form-control" name="ins_nmae[]"></td>
						 <td><input type="text" class="form-control" name="board[]"></td>
						 <td><input type="text" class="form-control" name="year_passing[]"></td>
						 <td><input type="text" class="form-control" name="perce[]"></td>
						 <td><input type="text" class="form-control" name="grade[]"></td>
						 <td><input type="file" id="doc' . $row . '" class="form-control" accept="capture=camera" name="doc[]" onchange="Filevalidationdocnew(' . $row . ')"> <small> Please select  file which size up to 2mb</small></td>
						  <td><input type="file" id="doc2' . $row . '" accept="capture=camera" class="form-control" name="doc2[]"  onchange="Filevalidationdocnewdoc(' . $row . ')"> <small> Please select  file which size up to 2mb</small></td>
						 <td><button class="btn-success" type="button" id="add' . $row . '" onClick="addnewrow(' . $row . ')" data-id="' . $row . '"> <i class="fas fa-plus"></i> </button>
						 <button class="btn-danger deleteButton" type="button" id="del' . $row . '"  onClick="delRow(' . $row . ')"> <i class="fas fa-minus"></i> </button></td>
					  </tr>';
    echo $result;
});

Route::get('settings/get-add-row-acc/{row}', function ($row) {
    $row = $row + 1;

    $result = ' <tr class="itemslot" id="' . $row . '" >
					    <td>' . $row . '</td>
						 <td>
                         <select class="form-control" name="emp_document_name[]">
                         <option></option>
                         <option value="10 th">10 th</option>
                                                               <option value="11 th">11 th</option>
                                                               <option value="12 th">12 th</option>
                                                               <option value="BA">BA</option>
                                                               <option value="ma">Ma</option>
                       </select>
                         </td>
                         <td>

                           <input type="text" name="boardss[]" class="form-control">
                         </td>
                         <td>

                            <input type="date" name="yearofpassing[]" class="form-control">
                        </td>
                                                              <td>

                                                                <input type="text" name="emp_grade[]" class="form-control">
                                                              </td>
                                                              <td>

                                                                <input type="file" name="emp_document_upload[]" class="form-control">
                                                              </td>
						 <td><button class="btn-success" type="button" id="add' . $row . '" onClick="accademinewrow(' . $row . ')" data-id="' . $row . '"> <i class="fas fa-plus"></i> </button>
						 <button class="btn-danger deleteButton" type="button" id="del' . $row . '"  onClick="delRow(' . $row . ')"> <i class="fas fa-minus"></i> </button></td>
					  </tr>';
    echo $result;
});

Route::get('settings/get-add-row-pro/{row}', function ($row) {
    $row = $row + 1;

    $result = ' <tr class="itemslot" id="' . $row . '" >
					    <td>' . $row . '</td>
						 <td>
                         <td>
                         <input type="text" name="Organization[]" class="form-control" placeholder="Organization">
                     </td>
                       <td>

                       <input type="text" name="Desigination[]" class="form-control" placeholder="Desigination">
                       </td>
                       <td>

                         <input type="date" name="formdate[]" class="form-control">
                       </td>
                       <td>

                         <input type="date" name="todate[]" class="form-control">
                       </td>
                       <td>

                         <input type="file" name="emp1_document_upload[]" class="form-control">
                       </td>
						 <td><button class="btn-success" type="button" id="add' . $row . '" onClick="proaddnewrow(' . $row . ')" data-id="' . $row . '"> <i class="fas fa-plus"></i> </button>
						 <button class="btn-danger deleteButton" type="button" id="del' . $row . '"  onClick="delRow(' . $row . ')"> <i class="fas fa-minus"></i> </button></td>
					  </tr>';
    echo $result;
});
Route::get('settings/get-add-row-mic/{row}', function ($row) {
    $row = $row + 1;

    $result = ' <tr class="itemslot" id="' . $row . '" >
					    <td>' . $row . '</td>

                         <td>
                         <select class="form-control" name="emp_traning">
                         <option>Select</option>
                         <option value="traning">Traning</option>
                         <option value="legal">Legal</option>
                         <option value="other">others</option>
                        </select>
                     </td>

                       <td>

                         <input type="file" name="traning1_document_upload[]" class="form-control">
                       </td>
						 <td><button class="btn-success" type="button" id="add' . $row . '" onClick="proaddnewrow(' . $row . ')" data-id="' . $row . '"> <i class="fas fa-plus"></i> </button>
						 <button class="btn-danger deleteButton" type="button" id="del' . $row . '"  onClick="delRow(' . $row . ')"> <i class="fas fa-minus"></i> </button></td>
					  </tr>';
    echo $result;
});

Route::get('settings/get-add-row-item-edu/{row}', function ($row) {

    $row = $row + 1;

    $result = '
				  <div class="itemslotedu" id="' . $row . '">
				  <div class="row " >
				  <div class="col-md-4">

		<div class="form-group">
	<label for="inputFloatingLabel-jobt" class="col-form-label">Job Title</label>
		<input id="inputFloatingLabel-jobt" type="text" class="form-control input-border-bottom"  name="job_name[]">

	</div>
	</div>
	<div class="col-md-4">

		<div class="form-group">
	    <label for="inputFloatingLabel-jobs" class="col-form-label">Start Date</label>
		<input id="inputFloatingLabel-jobs" type="date" class="form-control input-border-bottom" name="job_start_date[]">
	</div>
	</div>
	<div class="col-md-4">

		<div class="form-group">
		    <label for="inputFloatingLabel-jobe" class="col-form-label">End Date </label>
		<input id="inputFloatingLabel-jobe" type="date" class="form-control input-border-bottom" name="job_end_date[]">

	</div>
	</div>
		</div>

		          <div class="row">
				  <div class="col-md-4">
<div class="form-group">
   <label for="selectFloatingLabelexp" class="col-form-label">Year of Experience</label>
<select class="form-control input-border-bottom" id="selectFloatingLabelexp"  name="exp[]">
<option value="">&nbsp;</option>';
    for ($i = 0; $i <= 10; $i++) {
        $result .= '
<option value="' . $i . '">' . $i . '</option>';

    }

    $result .= '
</select>

</div>
</div><div class="col-md-6">

				  <div class="form-group">
<label for="inputFloatingLabel-jobs" class="col-form-label">Job Description</label>
	<textarea id="inputFloatingLabel-jobs"  rows="5" class="form-control"  style="height:135px !important;resize:none;"  name="des[]"> </textarea>

</div>
</div>




<div class="col-md-2" style="margin-top:27px;">
<button class="btn-success" type="button"  id="addedu' . $row . '" onClick="addnewrowedu(' . $row . ')" data-id="' . $row . '"><i class="fas fa-plus"></i> </button>
 <button class="btn-danger deleteButtonedu" type="button" id="deledu' . $row . '"  onClick="delRowedu(' . $row . ')"> <i class="fas fa-minus"></i> </button>
</div>
</div>
	</div></br>';
    echo $result;
});

Route::get('settings/get-add-row-item-train/{row}', function ($row) {

    $row = $row + 1;

    $result = '
				  <div class="itemslottrain" id="' . $row . '">

                  <div class="row">
				   <div class="col-md-4">
				     <div class="form-group">
				         	<label for="inputFloatingLabeltr1" class="col-form-label">Title</label>
						<input id="inputFloatingLabeltr1" type="text" class="form-control input-border-bottom"  name="tarin_name[]">

					</div>
				   </div>
				   <div class="col-md-4">
				     <div class="form-group">
				         <label for="inputFloatingLabeltr2" class="col-form-label">Start Date</label>
						<input id="inputFloatingLabeltr2" type="date" class="form-control input-border-bottom" name="tarin_start_date[]">

					</div>
				   </div>
				    <div class="col-md-4">
				    <div class="form-group">
				         <label for="inputFloatingLabeltr2" class="col-form-label">End Date</label>
						<input id="inputFloatingLabeltr2" type="date" class="form-control input-border-bottom"  name="tarin_end_date[]">

					</div>
				   </div>
				  </div>

				  <div class="row">
				  <div class="col-md-4">
				      <div class="form-group">
				         	<label for="inputFloatingLabeltr4" class="col-form-label">Description</label>
					<textarea id="inputFloatingLabeltr4"  rows="5" class="form-control"  style="height:135px !important;resize:none;"  name="train_des[]"> </textarea>


					</div>
					</div>
					<div class="col-md-4" style="margin-top:27px;"><button class="btn-success" type="button" id="addtarin' . $row . '" onClick="addnewrowtarin(' . $row . ')" data-id="' . $row . '"><i class="fas fa-plus"></i> </button>

					 <button class="btn-danger deleteButtontrain" type="button" id="deltarin' . $row . '"  onClick="delRowtrain(' . $row . ')"> <i class="fas fa-minus"></i> </button></div>
				  </div>
                 </div></br>	  ';
    echo $result;
});

Route::get('settings/get-add-row-item-upload/{row}', function ($row) {

    $row = $row + 1;

    $result = '
				  <div class="row itemslotupload" id="' . $row . '">
				  <div class="col-md-4">
				    <div class="form-group">
				    <label for="selectFloatingLabel" class="col-form-label">Type of Document</label>
					<input id="selectFloatingLabel" type="text" class="form-control" required="" name="type_doc[]">


											</div>
				  </div>

				  <div class="col-md-4">
				  <label>Uplaod Documents</label>
				    <input type="file" class="form-control-file" id="docu_nat' . $row . '" accept="capture=camera" onchange="Filevalidationdocother(' . $row . ')" name="docu_nat[]">
				    <small> Please select  file which size up to 2mb</small>
				  </div>
				  <div class="col-md-4" style="margin-top:27px;"><button class="btn-success" type="button"  id="addupload' . $row . '" onClick="addnewrowupload(' . $row . ')" data-id=' . $row . '"><i class="fas fa-plus"></i> </button>
				  <button class="btn-danger deleteButtonupload" type="button" id="delupload' . $row . '"  onClick="delRowupload(' . $row . ')"> <i class="fas fa-minus"></i> </button></div>
				</div>	  </br>	  ';
    echo $result;
});

Route::get('holidaydashboard', 'App\Http\Controllers\HolidayController@viewdash');
Route::get('holidays', 'App\Http\Controllers\HolidayController@viewHolidayDetails');

Route::get('holiday/add-holiday', 'App\Http\Controllers\HolidayController@viewAddHoliday');
Route::post('holiday/add-holiday', 'App\Http\Controllers\HolidayController@saveHolidayData');
Route::get('holiday/add-holiday/{holiday_id}', 'App\Http\Controllers\HolidayController@getHolidayDtl');
Route::get('holiday/holidaydelete/{holiday_id}', 'App\Http\Controllers\HolidayController@deleteHoliday');

Route::get('holiday-type', 'App\Http\Controllers\HolidayController@viewHolidayTypeDetails');

Route::get('holiday/add-holiday-type', 'App\Http\Controllers\HolidayController@viewAddHolidayType');
Route::post('holiday/add-holiday-type', 'App\Http\Controllers\HolidayController@saveHolidayTypeData');
Route::get('holiday/add-holiday-type/{holiday_id}', 'App\Http\Controllers\HolidayController@getHolidayTypeDtl');

Route::get('complaindashboard', 'App\Http\Controllers\ComplainController@viewdash');
Route::get('complain/add-complain', 'App\Http\Controllers\ComplainController@addcomplain');
Route::get('complain/view-complain', 'App\Http\Controllers\ComplainController@viewopen');
Route::post('complain/add-complain', 'App\Http\Controllers\ComplainController@saveopen');

Route::get('complain/view-solved-complain', 'App\Http\Controllers\ComplainController@viewsolved');
Route::get('complain/add-solved-complain', 'App\Http\Controllers\ComplainController@addcomplainsolved');
Route::post('complain/add-solved-complain', 'App\Http\Controllers\ComplainController@saveopensolved');

Route::get('complain/view-closed-complain', 'App\Http\Controllers\ComplainController@viewclosed');

Route::get('superadmin/view-complain', 'App\Http\Controllers\AdminController@viewopen');
Route::get('superadmin/add-complain', 'App\Http\Controllers\AdminController@addcomplain');
Route::post('superadmin/add-complain', 'App\Http\Controllers\AdminController@saveopen');

Route::get('superadmin/view-solved-complain', 'App\Http\Controllers\AdminController@viewsolved');
Route::get('superadmin/view-closed-complain', 'App\Http\Controllers\AdminController@viewclosed');
Route::get('superadmin/search-complain', 'App\Http\Controllers\AdminController@viewreportcomplain');

Route::post('superadmin/search-complain', 'App\Http\Controllers\AdminController@saveeportcomplain');

Route::post('superadmin/search-complain-excel', 'App\Http\Controllers\AdminController@savereportroDatacomplainemexcel');

Route::post('superadmin/search-hraward-excel', 'App\Http\Controllers\AdminController@savereportroDatahrawardemexcel');
Route::post('superadmin/search-request-excel', 'App\Http\Controllers\AdminController@savereportroDatarequestemexcel');
Route::post('superadmin/search-granted-excel', 'App\Http\Controllers\AdminController@savereportroDatagrantedemexcel');
Route::post('superadmin/search-licence-excel', 'App\Http\Controllers\AdminController@savereportroDatalicenceemexcel');
Route::post('superadmin/search-hrhome-excel', 'App\Http\Controllers\AdminController@savereportroDatahrhomeemexcel');
Route::post('superadmin/search-hrlagtime-excel', 'App\Http\Controllers\AdminController@savereportroDatahrlagtimeemexcel');
Route::post('superadmin/search-hrreply-excel', 'App\Http\Controllers\AdminController@savereportroDatahrreplyexcel');
Route::post('superadmin/search-application-excel', 'App\Http\Controllers\AdminController@savereportroDataapplicationemexcel');
Route::get('pis/getmodulebyprojectid/{empid}', function ($empid) {

    $employee_rs = DB::Table('module')

        ->get();
    $result_status1 = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    if ($empid == 'Work Permit Cloud') {

        foreach ($employee_rs as $bank) {
            $result_status1 .= '<option value="' . $bank->module_name . '">' . $bank->module_name . '</option>';
        }
    }
    if ($empid == 'Skilled Worker Route') {
        $result_status1 = "<option value='' selected disabled> &nbsp;</option>";

        $result_status1 .= '<option value="Employer Registration"   >Employer Registration</option>
<option value="Employer Verification"   >Employer Verification</option>
<option value="Employer Login"   >Employer Login</option>
<option value="Employer Forgot Password"   >Employer Forgot Password</option>
<option value="Employer Profile"   >Employer Profile</option>
<option value="Search"   >Search</option>
<option value="Job Posting"   >Job Posting</option>
<option value="Active Jobs"   >Active Jobs</option>
<option value="Closed Jobs"   >Closed Jobs</option>
<option value="Job Applied"   >Job Applied</option>
<option value="Short Listing"   >Short Listing</option>
<option value="Interview"   >Interview</option>
<option value="Hired"   >Hired</option>
<option value="Offer Letter"   >Offer Letter</option>
<option value="Messages"   >Messages</option>
<option value="Report"   >Report</option>
<option value="Candidate Registration"   >Candidate Registration</option>
<option value="Candidate Verification"   >Candidate Verification</option>
<option value="Candidate Login"   >Candidate Login</option>
<option value="Candidate Forgot Password"   >Candidate Forgot Password</option>
<option value="Candidate Profile"   >Candidate Profile</option>
<option value="Candidate CV"   >Candidate CV</option>
<option value="Recommended Job"   >Recommended Job</option>
<option value="My Application"   >My Application</option>
<option value="My Messages"   >My Messages</option>
<option value="Find A Job"   >Find A Job</option>
<option value="Find A Job (Name of Sector wise)"   >Find A Job (Name of Sector wise)</option>
<option value="Find A Job (Sponsorship wise)"   >Find A Job (Sponsorship wise)</option>
<option value="Job Details"   >Job Details</option>
<option value="Job Application"   >Job Application</option>';

    }
    $result_status1 .= '<option value="Others"   >Others</option>';
    echo $result_status1;

});

Route::get('dashboard/key-contact', 'App\Http\Controllers\DashboardController@getCompaniesofficerkey');
Route::get('leavedashboard', 'App\Http\Controllers\LeaveController@viewdash');

Route::get('companydashboard', 'App\Http\Controllers\CompanyController@viewdash');
Route::get('company-profile/company', 'App\Http\Controllers\CompanyController@getCompanies');

Route::get('company-profile/employee-link', 'App\Http\Controllers\CompanyController@getCompanieslink');
Route::get('company-profile/edit-company', 'App\Http\Controllers\CompanyController@viewAddCompany');
Route::post('company-profile/editcompany', 'App\Http\Controllers\CompanyController@saveCompany');

Route::get('company-profile-details/edit-company/{comapny_id}', 'App\Http\Controllers\AppcomanyController@viewAddCompany');
Route::post('company-profile-details/editcompany', 'App\Http\Controllers\AppcomanyController@saveCompany');
Route::get('company-profile-details/employee-link/{comapny_id}', 'App\Http\Controllers\AppcomanyController@getCompanieslink');

Route::get('company/company-report/{comp_id}', 'App\Http\Controllers\CompanyController@viewAddCompanyreport');

Route::get('company-profile-details/thank-you', 'App\Http\Controllers\AppcomanyController@viewthank');
Route::get('company-employee-rti', 'App\Http\Controllers\CompanyController@getCompaniesrti');
Route::get('company-authorizing-officer', 'App\Http\Controllers\CompanyController@getCompaniesofficer');
Route::get('company-key-contact', 'App\Http\Controllers\CompanyController@getCompaniesofficerkey');
Route::get('company-level-user', 'App\Http\Controllers\CompanyController@getCompaniesofficerlevel');
Route::get('appemployees/work-update/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewallcompanywork');
Route::post('appemployees/work-update', 'App\Http\Controllers\AppemployeeController@saveemployeedework');
Route::get('appemployees/attendance-monthwise/{emp_id}/{month_yr}', 'App\Http\Controllers\AppemployeeController@viewattendancemonthwise');
Route::get('appemployees/daily-attendance/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewdailyattendancemonthwise');
Route::get('appemployees/view-approved-leave/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewapprovedleave');

Route::get('appemployees/task-add/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewtaskadd');
Route::post('appemployees/task-save', 'App\Http\Controllers\AppemployeeController@viewtasksave');

Route::get('appemployees/duty-roster/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewdutyeroster');

Route::get('appemployees/{emp_id}', 'App\Http\Controllers\AppemployeeController@getEmployees');
Route::get('appmigrantemployees/{emp_id}', 'App\Http\Controllers\AppemployeeController@getmigrantEmployees');
Route::get('appdashemployees/{emp_id}/{appid}', 'App\Http\Controllers\AppemployeeController@getallEmployees');
Route::get('appaddallemployee/{emp_id}/{appid}', 'App\Http\Controllers\AppemployeeController@viewallAddEmployee');
Route::post('appaddallemployee', 'App\Http\Controllers\AppemployeeController@saveallEmployee');

Route::get('dashboard/migrant-dash-migrantfirstletter/{emp_id}/{send_id}', 'App\Http\Controllers\AppemployeeController@viewofferdownsendcandidatedetails');
Route::get('dashboard/migrant-dash-migrantsecondletter/{emp_id}/{send_id}', 'App\Http\Controllers\AppemployeeController@viewofferdownsendcandidatedetailssecond');
Route::get('dashboard/migrant-dash-migrantthiredletter/{emp_id}/{send_id}', 'App\Http\Controllers\AppemployeeController@viewofferdownsendcandidatedetailsthired');

Route::get('leaveapprovelist/{employee_id}', 'App\Http\Controllers\AppemployeeController@leaveapprivere');
Route::get('appleave-approver/leave-approved-right/{employee_id}/{id}', 'App\Http\Controllers\AppemployeeController@leaveapprivereedit');
Route::post('appleave-approver/leave-approved-right-save', 'App\Http\Controllers\AppemployeeController@SaveLeavePermission');

Route::get('apprightworks/{emp_id}', 'App\Http\Controllers\AppemployeeController@getrightworks');
Route::get('apprightworks/work-view/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewsendcandidatedetailswork');
Route::get('sponsor-management-dossier', 'App\Http\Controllers\AppemployeeController@getEmployeesdossier');
Route::get('key-contact/{emp_id}', 'App\Http\Controllers\AppemployeeController@getCompaniesofficerkey');

Route::get('approta/shift-management/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewshift');
Route::get('approta/add-shift-management/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddNewShift');
Route::post('approta/add-shift-management', 'App\Http\Controllers\AppemployeeController@saveShiftData');

Route::get('approta/late-policy/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewlate');
Route::get('approta/add-late-policy/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddNewlate');
Route::post('approta/add-late-policy', 'App\Http\Controllers\AppemployeeController@savelateData');

Route::get('approta/offday/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewoffday');
Route::get('approta/add-offday/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddNewoffday');
Route::post('approta/add-offday', 'App\Http\Controllers\AppemployeeController@saveoffdayData');

Route::get('approta/grace-period/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewgrace');
Route::get('approta/add-grace-period/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddNewgrace');
Route::post('approta/add-grace-period', 'App\Http\Controllers\AppemployeeController@savegraceData');

Route::get('approta/duty-roster/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewroster');

Route::post('approta/add-duty-roster', 'App\Http\Controllers\AppemployeeController@saverosterData');

Route::get('appuser/user-role/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewUserConfig');
Route::get('approta/add-department-duty/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddNewdepartmentduty');
Route::post('approta/add-department-duty', 'App\Http\Controllers\AppemployeeController@savedepartmentdutyData');

Route::get('approta/add-employee-duty/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddNewemployeeduty');
Route::post('approta/add-employee-duty', 'App\Http\Controllers\AppemployeeController@saveemployeedutyData');

Route::get('approta/get-employee-all-details-shift/{empid}/{em_id}', function ($empid, $em_id) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $em_id)
        ->first();

    $employee_rs = DB::table('shift_management')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    echo json_encode(array($employee_rs));

});

Route::get('approta/getEmployeedesigBylateId/{empid}/{em_id}', function ($empid, $em_id) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $em_id)
        ->first();

    $employee_rs = DB::table('shift_management')

        ->where('designation', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->id . '">' . $bank->shift_code . '  ( ' . $bank->shift_des . ' )</option>';
    }

    echo $result_status1;

});

Route::get('approta/getEmployeedesigBydutytshiftId/{empid}/{em_id}', function ($empid, $em_id) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $em_id)
        ->first();

    $employee_rs = DB::table('shift_management')

        ->where('designation', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "";
    $du = 1;
    foreach ($employee_rs as $bank) {
        if ($du == '1') {
            $chedu = 'checked';
        } else {
            $chedu = '';
        }
        $result_status1 .= '<div class="col-md-3">
											  <input id="shift_code' . $bank->id . '" type="radio" name="shift_code" value="' . $bank->id . '"  ' . $chedu . '>
											  <label for="shift_code' . $bank->id . '" class="day-check">' . $bank->shift_code . '  ( ' . $bank->shift_des . ' )</label>

										 </div>	';
        $du++;
    }

    echo $result_status1;

});

Route::get('appdocument/employee-report/{emp_id}', 'App\Http\Controllers\AppemployeeController@getemployeerepo');
Route::post('appdocument/employee-report', 'App\Http\Controllers\AppemployeeController@downorganisantionrepoemployee');

Route::get('appdocument/getEmployeedreportfileById/{empid}/{em_id}', function ($empid, $em_id) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $em_id)
        ->first();

    $desig_rs = DB::table('employee')

        ->where('emp_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    $employee_rs = DB::table('employee_qualification')

        ->where('emp_id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $employee_upload_rs = DB::table('employee_upload')

        ->where('emp_id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        if ($bank->doc != '') {
            $result_status1 .= '<option value="' . $bank->quli . ' Transcript Document">' . $bank->quli . ' Transcript Document</option>';

        }
        if ($bank->doc2 != '') {
            $result_status1 .= '<option value="' . $bank->quli . ' Certificate Document">' . $bank->quli . ' Certificate Document</option>';

        }
    }

    foreach ($employee_upload_rs as $bankjj) {
        if ($bankjj->type_doc != '') {
            $result_status1 .= '<option value="' . $bankjj->type_doc . '">' . $bankjj->type_doc . '</option>';

        }

    }
    if ($desig_rs->pr_add_proof != '') {
        $result_status1 .= '<option value="pr_add_proof">Proof Of Correspondence   Address </option>';

    }
    if ($desig_rs->pass_docu != '') {
        $result_status1 .= '<option value="pass_docu">Passport    Document </option>';

    }
    if ($desig_rs->visa_upload_doc != '') {
        $result_status1 .= '<option value="visa_upload_doc">Visa    Document </option>';

    }

    $employee_otherd_doc_rs = DB::table('employee_other_doc')
        ->where('emid', '=', $Roledata->reg)
        ->where('emp_code', '=', $empid)
        ->get();
    foreach ($employee_otherd_doc_rs as $bankjjnew) {
        if ($bankjjnew->doc_upload_doc != '') {
            $result_status1 .= '<option value="' . $bankjjnew->doc_name . '">' . $bankjjnew->doc_name . '</option>';

        }

    }
    if ($desig_rs->euss_upload_doc != '') {
        $result_status1 .= '<option value="euss_upload_doc">EUSS    Document </option>';

    }
    if ($desig_rs->nat_upload_doc != '') {
        $result_status1 .= '<option value="nat_upload_doc">National Id    Document </option>';

    }
    echo $result_status1;

});

Route::get('appattendance/attendance-report/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewattendancereport');
Route::post('appattendance/attendance-report', 'App\Http\Controllers\AppemployeeController@getReportAttandance');

Route::get('appattendance/getEmployeedailyattandeaneshightByIdnewr/{empid}/{em_id}', function ($empid, $em_id) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $em_id)
        ->first();

    $employee_desigrs = DB::table('designation')
        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_depers = DB::table('department')
        ->where('id', '=', $employee_desigrs->department_code)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('employee')

        ->where('emp_designation', '=', $employee_desigrs->designation_name)
        ->where('emp_department', '=', $employee_depers->department_name)
        ->where('emid', '=', $Roledata->reg)
        ->where(function ($query) {

            $query->whereNull('employee.emp_status')
                ->orWhere('employee.emp_status', '!=', 'LEFT');
        })
        ->get();
    $result = '';
    $result_status1 = "  <option value=''>Select</option>
	<option value=''>All</option>
";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('appattendance/getEmployeedesigByshiftId/absent/{empid}/{em_id}', function ($empid, $em_id) {
    $Roledata = DB::table('registration')

        ->where('reg', '=', $em_id)
        ->first();
    $desig_rs = DB::table('department')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    $employee_rs = DB::table('designation')

        ->where('department_code', '=', $desig_rs->id)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->id . '">' . $bank->designation_name . '</option>';
    }

    echo $result_status1;

});

Route::get('applaeve/leave-management/new-leave-type/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddLeaveType');
Route::post('applaeve/leave-management/new-leave-type', 'App\Http\Controllers\AppemployeeController@saveLeaveType');
Route::get('applaeve/leave-management/leave-type-listing/{emp_id}', 'App\Http\Controllers\AppemployeeController@getLeaveType');
Route::get('applaeve/leave-management/leave-type-listing/{emp_id}/{holiday_id}', 'App\Http\Controllers\AppemployeeController@getLeaveTypeDtl');

Route::get('applaeve/leave-management/save-leave-rule/{emp_id}', 'App\Http\Controllers\AppemployeeController@leaveRules');
Route::post('applaeve/leave-management/save-leave-rule', 'App\Http\Controllers\AppemployeeController@saveAddLeaveRule');
Route::get('applaeve/leave-management/leave-rule-listing/{emp_id}', 'App\Http\Controllers\AppemployeeController@getLeaveRules');
Route::get('applaeve/leave-management/view-leave-rule/{emp_id}/{leave_rule_id}', 'App\Http\Controllers\AppemployeeController@getLeaveRulesById');

Route::get('applaeve/leave-management/leave-allocation-listing/{emp_id}', 'App\Http\Controllers\AppemployeeController@getLeaveAllocation');
Route::get('applaeve/leave-management/save-leave-allocation/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddLeaveAllocation');
Route::post('applaeve/leave-management/save-leave-allocation', 'App\Http\Controllers\AppemployeeController@saveAddLeaveAllocation');
Route::post('applaeve/leave-management/get-leave-allocation', 'App\Http\Controllers\AppemployeeController@getAddLeaveAllocation');
Route::get('applaeve/leave-management/leave-allocation-dtl/{emp_id}/{leave_allocation_id}', 'App\Http\Controllers\AppemployeeController@getLeaveAllocationById');
Route::post('applaeve/attendance/save-edit-leave-allocation', 'App\Http\Controllers\AppemployeeController@editLeaveAllocation');

Route::get('applaeve/getEmployeedailyattandeaneByIdnewvchangenewdf/{empid}/{emid}', function ($empid, $emid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $employee_rs = DB::table('employee')

        ->where('emp_status', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "  <option value=''>Select</option>
	<option value=''>All</option>
   ";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('appchange/change-of-circumstances/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewchangecircumstanceseditnew');
Route::post('appchange/change-of-circumstances', 'App\Http\Controllers\AppemployeeController@savechangecircumstanceseditnew');
Route::get('appchange/change/{emid}/{send_id}/{date}', 'App\Http\Controllers\AppemployeeController@viewofferdownsendcandidatedetailssend_iddate');
Route::get('appchange/employee-circumstances-report/{em_id}/{emp_id}/{emp_type}', 'App\Http\Controllers\AppemployeeController@reportEmployeesstaff');
Route::get('appchange/employee-circumstances-report-excel/{em_id}/{emp_id}/{emp_type}', 'App\Http\Controllers\AppemployeeController@reportEmployeesexcelstaff');

Route::get('appcon/contract-agreement/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewemployeeagreementnew');
Route::post('appcon/contract-agreement', 'App\Http\Controllers\AppemployeeController@saveemployeeagreementnewne');
Route::get('appcon/contract-agreement-editnew/{emid}/{agreement_id}', 'App\Http\Controllers\AppemployeeController@viewemployeeagreementditshow');
Route::get('appcon/contract-word/{emid}/{agreement_id}', 'App\Http\Controllers\AppemployeeController@mswordnew');

Route::get('appleave/leave-status/{employee_id}/{emp_id}', 'App\Http\Controllers\AppemployeeController@allleavreqe');
Route::get('pis/getEmployeedailyattandeaneByIdnewvchangenewdf/{empid}/{emid}', function ($empid, $emid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $employee_rs = DB::table('employee')

        ->where('emp_status', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "  <option value=''>Select</option>
   ";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('appemployee-add/employee-report/{comp_id}/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddEmployeereportnew');
Route::get('appaddemployee/{emp_id}', 'App\Http\Controllers\AppemployeeController@viewAddEmployee');
Route::get('appaddemployee-new/{emp_id}/{emplo_id}', 'App\Http\Controllers\AppemployeeController@viewAddEmployeenew');

Route::get('appaddchange-of-circumstances/{emp_id}/{emplo_id}', 'App\Http\Controllers\AppemployeeController@viewchangecircumstances');
Route::get('appaddemployee-new/circumstances-edit/{emp_id}/{emp_code}', 'App\Http\Controllers\AppemployeeController@viewchangecircumstancesedit');
Route::get('appaddemployee-new/contract-agreement/{emp_id}/{emp_code}', 'App\Http\Controllers\AppemployeeController@viewemployeeagreement');

Route::get('appaddemployee/contract-agreement-edit/{emp_id}/{emp_code}', 'App\Http\Controllers\AppemployeeController@saveemployeeagreementnew');

Route::post('appaddemployee-new/circumstances-edit-new', 'App\Http\Controllers\AppemployeeController@savechangecircumstancesedit');

Route::post('appaddemployee-new/{emp_id}/{emplo_id}', 'App\Http\Controllers\AppemployeeController@saveEmployeenew');
Route::get('appsettings/vw-department/{emp_id}', 'App\Http\Controllers\AppSettingController@getDepartment');
Route::get('appsettings/add-new-department/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddNewDepartment');
Route::post('appsettings/add-new-department', 'App\Http\Controllers\AppSettingController@saveDepartmentData');

Route::get('appsettings/vw-designation/{emp_id}', 'App\Http\Controllers\AppSettingController@getDesignations');
Route::post('appsettings/designation', 'App\Http\Controllers\AppSettingController@saveDesignation');
Route::get('appsettings/designation/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddDesignation');

Route::get('appsettings/vw-employee-type/{emp_id}', 'App\Http\Controllers\AppSettingController@getEmployeeTypes');
Route::get('appsettings/employee-type/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddEmployeeType');
Route::post('appsettings/employee-type', 'App\Http\Controllers\AppSettingController@saveEmployeeType');

Route::get('appsettings/employee-type/{emp_id}/{id}', 'App\Http\Controllers\AppSettingController@getTypeById');

Route::get('appsettings/vw-paygroup/{emp_id}', 'App\Http\Controllers\AppSettingController@getGrades');
Route::get('appsettings/paygroup/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddGrade');
Route::post('appsettings/paygroup', 'App\Http\Controllers\AppSettingController@saveGrade');
Route::get('appsettings/vw-annualpay/{emp_id}', 'App\Http\Controllers\AppSettingController@getPayscale');
Route::get('appsettings/annualpay/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddPayscale');
Route::post('appsettings/annualpay', 'App\Http\Controllers\AppSettingController@savePayscale');

Route::get('appsettings/bank/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddBank');
Route::post('appsettings/bank', 'App\Http\Controllers\AppSettingController@saveBank');
Route::get('appsettings/vw-bank/{emp_id}', 'App\Http\Controllers\AppSettingController@getBanks');
Route::get('appsettings/vw-tax/{emp_id}', 'App\Http\Controllers\AppSettingController@getTaxmaster');
Route::get('appsettings/tax/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddTaxmaster');
Route::post('appsettings/tax', 'App\Http\Controllers\AppSettingController@saveTaxmaster');

Route::get('appsettings/vw-pay-type/{emp_id}', 'App\Http\Controllers\AppSettingController@getPaytypemaster');
Route::get('appsettings/pay-type/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddPaytypemaster');
Route::post('appsettings/pay-type', 'App\Http\Controllers\AppSettingController@savePaytypemaster');

Route::post('appaddemployee', 'App\Http\Controllers\AppemployeeController@saveEmployee');
Route::get('pis/getEmployeedesigappById/{empid}/{emid}', function ($empid, $emid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $desig_rs = DB::table('department')

        ->where('department_name', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('designation')

        ->where('department_code', '=', $desig_rs->id)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->designation_name . '">' . $bank->designation_name . '</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeeannulappById/{empid}/{emid}', function ($empid, $emid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $desig_rs = DB::table('pay_scale_master')

        ->where('payscale_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('pay_scale_basic_master')

        ->where('pay_scale_master_id', '=', $desig_rs->id)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->pay_scale_basic . '">' . $bank->pay_scale_basic . '</option>';
    }

    echo $result_status1;

});

// Route::get('pis/gettimemintuesnew/{in_time}/{out_time}', function ($in_time, $out_time) {
//     //dd('okk');
//     $in_time = base64_decode($in_time);
//     $out_time = base64_decode($out_time);
//     $st_time = date('Y-m-d') . ' ' . $in_time . ':10';

//     $end_time = date('Y-m-d') . ' ' . $out_time . ':10';
//     $t1 = Carbon::parse($st_time);
//     $t2 = Carbon::parse($end_time);
//     $diff = $t1->diff($t2);
//     // print_r($diff);
//     //print_r(str_pad($diff->i,2,"0",STR_PAD_LEFT));


//     $arr = array('hour' => $diff->h, 'min' => str_pad($diff->i,2,"0",STR_PAD_LEFT));
//     echo json_encode($arr);
// });

Route::get('pis/getEmployeererivewById/{emid}', function ($emid) {

    $desig_rs = date("Y-m-d", strtotime($emid . " -1 month"));
    return $desig_rs;

});
Route::get('pis/getEmployeererivewByIdhrfile/{emid}', function ($emid) {

    $desig_rs = date("Y-m-d", strtotime($emid . " + 3 Weeks"));
    return $desig_rs;

});

Route::get('pis/getEmployeererivewByIdsuhrfile/{emid}', function ($emid) {
    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('com_name', '=', $emid)
        ->first();

    $ffjjtuu = DB::table('tareq_app')

        ->where('emid', '=', $Roledata->reg)
        ->first();
    if (!empty($ffjjtuu)) {
        if ($ffjjtuu->last_sub != '') {
            $sub_date = date('Y-m-d', strtotime($ffjjtuu->last_sub . '  + 5  Weeks'));
        } else {
            $sub_date = '';
        }
    } else {
        $sub_date = '';
    }
    return $sub_date;

});
Route::get('pis/getEmployeererivewByIdnewdate/{emid}', function ($emid) {

    $desig_rs = date("Y-m-d", strtotime($emid . " +7 days"));
    return $desig_rs;

});
Route::get('pis/getEmployeererivewByIdnewdgooate/{emid}', function ($emid) {

    $desig_rs = date("Y-m-d", strtotime($emid . " +4 days"));
    return $desig_rs;

});

Route::get('pis/getEmployeeminworkappById/{empid}/{emid}', function ($empid, $emid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $desig_rs = DB::table('payment_type_master')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    return json_encode($desig_rs);

});

Route::get('pis/getEmployeetaxempappById/{empid}/{emid}', function ($empid, $emid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $desig_rs = DB::table('tax_master')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    return json_encode($desig_rs);

});

Route::get('attendance/get-app-employee-bank/{emp_branch_id}/{emid}', function ($emp_branch_id, $emid) {

    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $employee_ifsc_code = DB::table('bank')->where('bank_name', '=', $emp_branch_id)->where('emid', '=', $Roledata->reg)->first();
    echo json_encode($employee_ifsc_code);
});
Route::get('pis/getEmployeetaxempByIdnewemployee/{empid}', function ($empid) {

    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('employee')

        ->where('emp_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    $employee_otherd_doc_rs = DB::table('employee_other_doc')

        ->where('emp_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $currency_user = DB::table('currencies')->orderBy('country', 'asc')->get();

    $truotherdocpload_id = 0;

    $reslt = '';
    $countpayuppasother = count($employee_otherd_doc_rs); //dd($countpayuppasother);
    $reslt = '<div id="dynamic_row_upload_other">';
    $truotherdocpload_id++;
    if ($countpayuppasother != 0) {


        foreach ($employee_otherd_doc_rs as $empuprs) {
            if ($empuprs->doc_issue_date != '' && $empuprs->doc_issue_date != '1970-01-01') {$doc_date = $empuprs->doc_issue_date;} else {
                $doc_date = '';
            }
            if ($empuprs->doc_exp_date != '' && $empuprs->doc_exp_date != '1970-01-01') {$doc_exp_date = $empuprs->doc_exp_date;} else {
                $doc_exp_date = '';
            }
            if ($empuprs->doc_review_date != '' && $empuprs->doc_review_date != '1970-01-01') {$doc_review_date = $empuprs->doc_review_date;} else {
                $doc_review_date = '';
            }

            if ($empuprs->doc_cur == 'Yes') {$doc_cur = 'checked';} else if ($empuprs->doc_cur == 'No') {$doc_cur = 'checked';} else {
                $doc_cur = '';
            }
            $reslt .= '    <div class="row itemslototherupload" id="' . $truotherdocpload_id . '">
				   <div class="col-md-3">

<div class="form-group">
    <label for="inputFloatingLabeldn' . $truotherdocpload_id . '" class="col-form-label">Document name.</label>
    <input id="inputFloatingLabeldn' . $truotherdocpload_id . '" type="text" class="form-control input-border-bottom"  name="doc_name_' . $empuprs->id . '" value="' . $empuprs->doc_name . '">


</div>
</div>
				   		<div class="col-md-3">

<div class="form-group">
    <label for="inputFloatingLabeldn' . $truotherdocpload_id . '" class="col-form-label">Document reference number.</label>
    <input id="inputFloatingLabeldn' . $truotherdocpload_id . '" type="text" class="form-control input-border-bottom"   name="doc_ref_no_' . $empuprs->id . '" value="' . $empuprs->doc_ref_no . '">


</div>
</div>


			            <div class="col-md-3">
				  <div class="form-group">
				      <label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="doc_nation_' . $empuprs->id . '" >
												<option value="">&nbsp;</option>';

            foreach ($currency_user as $currency_valu) {
                if ($empuprs->doc_nation == trim($currency_valu->country)) {$slect = 'selected';} else {
                    $slect = '';
                }

                $reslt .= '<option value="' . trim($currency_valu->country) . '" ' . $slect . ' >' . $currency_valu->country . '</option>';
            }
            $reslt .= '</select>

											</div>
						</div>

				   	<div class="col-md-3">

						<div class="form-group">
						    <label for="inputFloatingLabelid' . $truotherdocpload_id . '" class="col-form-label">Issued Date</label>
						<input id="inputFloatingLabelid' . $truotherdocpload_id . '" type="date" class="form-control input-border-bottom"   name="doc_issue_date_' . $empuprs->id . '" value="' . $doc_date . '" >
																														</div>
			</div>
			<input type="hidden" class="form-control" name="emqliotherdoc[]" value="' . $empuprs->id . '"></td>

				   <div class="col-md-3">
							<div class="form-group" >
							    	<label for="doc_exp_date" class="col-form-label">Expiry Date</label>
							    <input id="doc_exp_date' . $truotherdocpload_id . '" type="date" class="form-control input-border-bottom"  name="doc_exp_date_' . $empuprs->id . '" value="' . $doc_exp_date . '"
onchange="getreviewnatdateother(' . $truotherdocpload_id . ');">
																														</div>
			</div>
				   		<div class="col-md-3">

					<div class="form-group">
					    <label for="doc_review_date" class="col-form-label"  style="margin-top:-12px;">Eligible Review Date</label>
					    <input id="doc_review_date' . $truotherdocpload_id . '" type="date" readonly class="form-control input-border-bottom"  name="doc_review_date_' . $empuprs->id . '" value="' . $doc_review_date . '">
																															</div>
			</div>

							<div class="col-md-3">
							<label>Upload Document</label> <span id="download_other_doc' . $truotherdocpload_id . '"><a style="color:blue;"  href="'.asset('public/') .'/'. $empuprs->doc_upload_doc .'" target="_blank">download</a></span>';

            $reslt .= '<input type="file" class="form-control" name="doc_upload_doc_' . $empuprs->id . '" id="doc_upload_doc' . $truotherdocpload_id . '" onchange="Filevalidationdopassduploadnatother(' . $truotherdocpload_id . ')">
								 <small> Please select  file which size up to 2mb</small>
						</div>



						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="doc_cur_' . $empuprs->id . '" value="Yes"   ' . $doc_cur . '>
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio"  value="No" name="doc_cur_' . $empuprs->id . '" ' . $doc_cur . '>
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">

								<div class="form-group">
								    	<label for="inputFloatingLabelrm1" class="placeholder">Remarks</label>
												<input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom"  name="doc_remarks_' . $empuprs->id . '" value="' . $empuprs->doc_remarks . '">

											</div>
						</div>';


            if ($truotherdocpload_id == ($countpayuppasother)) {
                $reslt .= '<div class="col-md-4" style="margin-top:27px;"><button class="btn-success" type="button"  id="adduploadother' . $truotherdocpload_id . '" onClick="addnewrowuploadother(' . $truotherdocpload_id . ')" data-id="' . $truotherdocpload_id . '"><i class="fas fa-plus"></i> </button></div>';

            }
            $reslt .= '</div>

				    </br>';
            $truotherdocpload_id++;

        }
    }
    if ($countpayuppasother == 0) {

        $reslt .= '<div class="row itemslototherupload" id="' . $truotherdocpload_id . '">
				   <div class="col-md-3">

<div class="form-group">
    <label for="inputFloatingLabeldn' . $truotherdocpload_id . '" class="placeholder">Document name.</label>
    <input id="inputFloatingLabeldn' . $truotherdocpload_id . '" type="text" class="form-control input-border-bottom"  name="doc_name[]">


</div>
</div>
				   		<div class="col-md-3">

<div class="form-group">
    <label for="inputFloatingLabeldn' . $truotherdocpload_id . '" class="placeholder">Document reference number.</label>
    <input id="inputFloatingLabeldn' . $truotherdocpload_id . '" type="text" class="form-control input-border-bottom"  name="doc_ref_no[]">


</div>
</div>


			            <div class="col-md-3">
				  <div class="form-group ">

				      	<label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
												<select class="form-control input-border-bottom" id="selectFloatingLabelntp"  name="doc_nation[]" >


		<option value="">&nbsp;</option>';

        foreach ($currency_user as $currency_valu) {

            $reslt .= '  <option value="' . trim($currency_valu->country) . '" >' . $currency_valu->country . '</option>';
        }$reslt .= '</select>


											</div>
						</div>

				   	<div class="col-md-3">

						<div class="form-group">
						    <label for="inputFloatingLabelid' . $truotherdocpload_id . '" class="placeholder">Issued Date</label>
						<input id="inputFloatingLabelid' . $truotherdocpload_id . '" type="date" class="form-control input-border-bottom" name="doc_issue_date[]">
																															</div>
			</div>

				   <div class="col-md-3">
							<div class="form-group" >
							    <label for="doc_exp_date' . $truotherdocpload_id . '" class="placeholder">Expiry Date</label>
							    <input id="doc_exp_date' . $truotherdocpload_id . '" type="date" class="form-control input-border-bottom" name="doc_exp_date[]"
onchange="getreviewnatdateother(' . $truotherdocpload_id . ');">
																														</div>
			</div>
				   		<div class="col-md-3">

					<div class="form-group">
					    	<label for="doc_review_date' . $truotherdocpload_id . '" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
					    <input id="doc_review_date' . $truotherdocpload_id . '" type="date" readonly class="form-control input-border-bottom" name="doc_review_date[]">
																														</div>
			</div>

							<div class="col-md-3">
							<label>Upload Document</label>
								<input type="file" class="form-control" name="doc_upload_doc[]" id="doc_upload_doc' . $truotherdocpload_id . '" onchange="Filevalidationdopassduploadnatother(' . $truotherdocpload_id . ')">
								 <small> Please select  file which size up to 2mb</small>
						</div>



						<div class="col-md-3">
						<div class="form-check">
												<label>Is this your current status?</label><br>
												<label class="form-radio-label">
													<input class="form-radio-input" type="radio" name="doc_cur[]" value="Yes" checked="">
													<span class="form-radio-sign">Yes</span>
												</label>
												<label class="form-radio-label ml-3">
													<input class="form-radio-input" type="radio" name="doc_cur[]" value="No">
													<span class="form-radio-sign">No</span>
												</label>
											</div>
									</div>
						<div class="col-md-3">

								<div class="form-group">
								    <label for="inputFloatingLabelrm' . $truotherdocpload_id . '" class="placeholder">Remarks</label>
												<input id="inputFloatingLabelrm' . $truotherdocpload_id . '" type="text" class="form-control input-border-bottom" name="doc_remarks[]" >

											</div>
						</div>


		 <div class="col-md-4" style="margin-top:27px;"><button class="btn-success" type="button"  id="adduploadother' . $truotherdocpload_id . '" onClick="addnewrowuploadother(' . $truotherdocpload_id . ')" data-id="' . $truotherdocpload_id . '"><i class="fas fa-plus"></i> </button></div>

						</div>

				    </br>';

    }

    $reslt .= ' </div>
				   </div>';

    $arr = array($desig_rs, $reslt);

    echo json_encode($arr);
});

Route::get('leave-management/new-leave-type', 'App\Http\Controllers\LeaveController@viewAddLeaveType');
Route::post('leave-management/new-leave-type', 'App\Http\Controllers\LeaveController@saveLeaveType');
Route::get('leave-management/leave-type-listing', 'App\Http\Controllers\LeaveController@getLeaveType');
Route::get('leave-management/leave-type-listing/{holiday_id}', 'App\Http\Controllers\LeaveController@getLeaveTypeDtl');

Route::get('leave-management/save-leave-rule', 'App\Http\Controllers\LeaveController@leaveRules');
Route::post('leave-management/save-leave-rule', 'App\Http\Controllers\LeaveController@saveAddLeaveRule');
Route::get('leave-management/leave-rule-listing', 'App\Http\Controllers\LeaveController@getLeaveRules');
Route::get('leave-management/view-leave-rule/{leave_rule_id}', 'App\Http\Controllers\LeaveController@getLeaveRulesById');
Route::get('leave-management/save-leave-allocation', 'App\Http\Controllers\LeaveController@viewAddLeaveAllocation');
Route::get('leave-management/leave-report-employee', 'App\Http\Controllers\LeaveController@viewleaveemplyee');

Route::post('leave-management/leave-report-employee', 'App\Http\Controllers\LeaveController@getleaveemplyee');

Route::post('leave-management/leave-report-employee-wise', 'App\Http\Controllers\LeaveController@postleaveemplyee');
Route::post('leave-management/leave-report-employee-wise-excel', 'App\Http\Controllers\LeaveController@postleaveemplyeeexcel');

Route::get('leave-management/leave-balance', 'App\Http\Controllers\LeaveController@getLeaveBalance');
Route::post('leave-management/leave-balance', 'App\Http\Controllers\LeaveController@spoLeaveBalance');
Route::get('leave-management/leave-report', 'App\Http\Controllers\LeaveController@leaveBalanceView');
Route::post('leave-management/leave-report', 'App\Http\Controllers\LeaveController@leaveBalanceReport');
Route::post('leave-management/leave-balance-excel', 'App\Http\Controllers\LeaveController@spoLeaveBalanceexcel');
Route::post('leave-management/get-leave-allocation', 'App\Http\Controllers\LeaveController@getAddLeaveAllocation');

Route::post('leave-management/save-leave-allocation', 'App\Http\Controllers\LeaveController@saveAddLeaveAllocation');

Route::get('leave-management/leave-allocation-listing', 'App\Http\Controllers\LeaveController@getLeaveAllocation');

Route::get('leave-management/leave-allocation-dtl/{leave_allocation_id}', 'App\Http\Controllers\LeaveController@getLeaveAllocationById');

Route::get('organisationdashboard', 'App\Http\Controllers\OrganisationController@viewdash');

Route::get('organisation-status/view-application', 'App\Http\Controllers\OrganisationController@viewbillng');
Route::get('organisation-status/edit-application/{comp_id}', 'App\Http\Controllers\OrganisationController@viewAddbillingy');
Route::post('organisation-status/edit-application', 'App\Http\Controllers\OrganisationController@saveAddbillingy');

Route::get('organisation-status/view-reminder', 'App\Http\Controllers\OrganisationController@viewreminder');
Route::get('organisation-status/add-reminder', 'App\Http\Controllers\OrganisationController@viewAddremindery');
Route::post('organisation-status/add-reminder', 'App\Http\Controllers\OrganisationController@saveAddremindery');

Route::get('organisation-status/view-hr', 'App\Http\Controllers\OrganisationController@viewhr');
Route::get('organisation-status/add-hr', 'App\Http\Controllers\OrganisationController@viewAddhry');
Route::post('organisation-status/add-hr', 'App\Http\Controllers\OrganisationController@saveAddhry');
Route::get('organisation-status/edit-hr/{comp_id}', 'App\Http\Controllers\OrganisationController@viewAddhrnew');
Route::post('organisation-status/edit-hr', 'App\Http\Controllers\OrganisationController@saveAddhrgynew');
Route::get('pis/getEmployeererivewdurationById/{emid}/{duration}', function ($emid, $duration) {

    $desig_rs = date("Y-m-d", strtotime($emid . "  " . $duration . " days"));
    return $desig_rs;

});

Route::get('organisation-status/view-visa', 'App\Http\Controllers\OrganisationController@viewvisa');
Route::get('organisation-status/add-visa', 'App\Http\Controllers\OrganisationController@viewAddvisay');
Route::post('organisation-status/add-visa', 'App\Http\Controllers\OrganisationController@saveAddvisay');
Route::get('organisation-status/edit-visa/{comp_id}', 'App\Http\Controllers\OrganisationController@viewAddvisanew');
Route::post('organisation-status/edit-visa', 'App\Http\Controllers\OrganisationController@saveAddvisagynew');
Route::get('organisation-status/view-cos', 'App\Http\Controllers\OrganisationController@viewcos');
Route::get('organisation-status/add-cos', 'App\Http\Controllers\OrganisationController@viewAddcosy');

Route::post('organisation-status/add-cos', 'App\Http\Controllers\OrganisationController@saveAddcosy');
Route::get('organisation-status/edit-cos/{comp_id}', 'App\Http\Controllers\OrganisationController@viewAddcosnew');
Route::post('organisation-status/edit-cos', 'App\Http\Controllers\OrganisationController@saveAddcosgynew');

//visa file
Route::get('organisation-status/view-visa-file', 'App\Http\Controllers\OrganisationController@viewVisaFile');
Route::get('organisation-status/add-visa-file', 'App\Http\Controllers\OrganisationController@viewAddVisaFile');
Route::post('organisation-status/add-visa-file', 'App\Http\Controllers\OrganisationController@saveAddVisaFile');
Route::get('organisation-status/edit-visa-file/{comp_id}', 'App\Http\Controllers\OrganisationController@editVisaFile');
Route::post('organisation-status/edit-visa-file', 'App\Http\Controllers\OrganisationController@updateVisaFile');

//-----

//recruitment file
Route::get('organisation-status/view-recruitment-file', 'App\Http\Controllers\OrganisationController@viewRecruitmentFile');
Route::get('organisation-status/add-recruitment-file', 'App\Http\Controllers\OrganisationController@viewAddRecruitmentFile');
Route::post('organisation-status/add-recruitment-file', 'App\Http\Controllers\OrganisationController@saveAddRecruitmentFile');
Route::get('organisation-status/edit-recruitment-file/{comp_id}', 'App\Http\Controllers\OrganisationController@editRecruitmentFile');
Route::post('organisation-status/edit-recruitment-file', 'App\Http\Controllers\OrganisationController@updateRecruitmentFile');

//-----

Route::get('billingorganizationdashboard', 'App\Http\Controllers\BillingOrganizationController@viewdash');
Route::get('billingorganization/billinglist', 'App\Http\Controllers\BillingOrganizationController@viewbillng');
Route::get('billingorganization/payment-received', 'App\Http\Controllers\BillingOrganizationController@viewpayre');
Route::get('billingdashboard', 'App\Http\Controllers\BillingController@viewdash');

//online payment disabled
// Route::get('billingorganization/pay-now/{com_id}/{in_id}', 'BillingOrganizationController@viewpaymentdeta');
// Route::post('billingorganization/pay-online', 'BillingOrganizationController@saveAddpayment');

Route::get('billingorganization/pay-now/{in_id}', 'App\Http\Controllers\BillingOrganizationController@tppaymentdeta');
Route::post('billingorganization/pay-now/{in_id}', 'App\Http\Controllers\BillingOrganizationController@tppaymentdeta');
Route::post('billingorganization/online-payment', 'App\Http\Controllers\BillingOrganizationController@saveAddpayTp');

Route::get('interroata/work-update', 'App\Http\Controllers\InterRotaController@viewwork');

Route::get('interroata/add-work-update', 'App\Http\Controllers\InterRotaController@viewAddworky');
Route::post('interroata/add-work-update', 'App\Http\Controllers\InterRotaController@saveAddworky');

Route::get('interroatadashboard', 'App\Http\Controllers\InterRotaController@viewdash');

Route::get('interroata/view-time-schedule', 'App\Http\Controllers\InterRotaController@viewscheduleRights');
Route::get('interroata/offday', 'App\Http\Controllers\InterRotaController@viewoffday');
Route::get('interroata/duty-roster', 'App\Http\Controllers\InterRotaController@viewroster');
Route::get('interroata/view-duty-roster/{comp_id}', 'App\Http\Controllers\InterRotaController@dutyrostimerAccess');

Route::get('billing/billinglist', 'App\Http\Controllers\BillingController@viewbillng');
Route::get('billing/payment-received', 'App\Http\Controllers\BillingController@viewpayre');
Route::get('billing/add-billing', 'App\Http\Controllers\BillingController@addbillng');
Route::post('billing/add-billing', 'App\Http\Controllers\BillingController@savebillng');
Route::get('billing/send-bill/{send_id}', 'App\Http\Controllers\BillingController@viewsendbilldetails');
Route::get('billing/edit-billing/{comp_id}', 'App\Http\Controllers\BillingController@viewAddbillingy');
Route::get('billing/payment-received', 'App\Http\Controllers\BillingController@viewpayre');
Route::get('billing/add-received-payment', 'App\Http\Controllers\BillingController@addpayre');
Route::post('billing/add-received-payment', 'App\Http\Controllers\BillingController@savepayre');
Route::post('billing/edit-billing', 'App\Http\Controllers\BillingController@saveAddbillingy');

Route::post('attendance/save-edit-leave-allocation', 'App\Http\Controllers\LeaveController@editLeaveAllocation');
Route::get('attendancedashboard', 'App\Http\Controllers\AttendanceController@viewdash');
Route::get('attendance/daily-attendance', 'App\Http\Controllers\AttendanceController@viewattendancedaily');
Route::post('attendance/daily-attendance', 'App\Http\Controllers\AttendanceController@getDailyAttandance');
Route::get('attendance/edit-daily/{daily_id}', 'App\Http\Controllers\AttendanceController@getDailyAttandancedetails');
Route::post('attendance/edit-daily', 'App\Http\Controllers\AttendanceController@saveDailyAttandancedetails');
Route::get(' attendance/process-attendance', 'App\Http\Controllers\AttendanceController@viewattendanceprocess');
Route::post(' attendance/process-attendance', 'App\Http\Controllers\AttendanceController@getprocessAttandance');
Route::post('attendance/save-Process-Attandance', 'App\Http\Controllers\AttendanceController@saveProcessAttandance');
Route::get('attendance/upload-data', 'App\Http\Controllers\AttendanceController@viewUploadAttendence');
Route::post('attendance/upload-data', 'App\Http\Controllers\AttendanceController@importExcel');
Route::post('attendance/attendance-month-report', 'App\Http\Controllers\AttendanceController@importdtaa');
Route::get('attendance/generate-data', 'App\Http\Controllers\AttendanceController@viewGenerateAttendence');
Route::post('attendance/generate-data', 'App\Http\Controllers\AttendanceController@importGenerate');
Route::post('attendance/save-generate-attandance', 'App\Http\Controllers\AttendanceController@saveGenerate');
Route::post('attendance/attendance-month-report-excel', 'App\Http\Controllers\AttendanceController@importdtaaexcel');
Route::get('attendance/attendance-report', 'App\Http\Controllers\AttendanceController@viewattendancereport');
Route::post('attendance/attendance-report', 'App\Http\Controllers\AttendanceController@getReportAttandance');
// Route::get(' attendance/process-attendance', 'AttendanceController@viewattendanceprocess');
// Route::post(' attendance/process-attendance', 'AttendanceController@getprocessAttandance');
//11-02-2022
Route::get('attendance/monthly-attendance-report', 'App\Http\Controllers\AttendanceController@viewMonthlyAttendanceReport');
Route::post('attendance/monthly-attendance-report', 'App\Http\Controllers\AttendanceController@getMonthlyReportAttandance');
Route::get('attendance/edit-report/{report_id}', 'App\Http\Controllers\AttendanceController@getReportAttandancedetails');
Route::post('attendance/edit-report', 'App\Http\Controllers\AttendanceController@saveReportAttandancedetails');
Route::get('attendance/absent-report', 'App\Http\Controllers\AttendanceController@viewattendanabsent');
Route::post('attendance/absent-report', 'App\Http\Controllers\AttendanceController@getattendanabsent');
Route::get('attendance/absent-record-card/{absent_id}/{year_value}', 'App\Http\Controllers\AttendanceController@viewattendanabsentreportN');
Route::get('attendance/absent-record-card-old/{absent_id}/{year_value}', 'App\Http\Controllers\AttendanceController@viewattendanabsentreport');
Route::get('attendance/absent-record-card-pdf/{absent_id}/{year_value}', 'App\Http\Controllers\AttendanceController@viewattendanabsentreportpdfN');

// Route::get('pis/getEmployeedailyattandeaneshightByIdnewr/{empid}', function ($empid) {
//     //dd($empid);
//     $email = Session::get('emp_email');
//     $Roledata = DB::table('registration')

//         ->where('email', '=', $email)
//         ->first();

//     $employee_desigrs = DB::table('designation')
//         ->where('id', '=', $empid)
//         ->where('emid', '=', $Roledata->reg)
//         ->first();
//     $employee_depers = DB::table('department')
//         ->where('id', '=', $employee_desigrs->department_code)
//         ->where('emid', '=', $Roledata->reg)
//         ->first();
//     $employee_rs = DB::table('employee')

//         ->where('emp_designation', '=', $employee_desigrs->designation_name)
//         ->where('emp_department', '=', $employee_depers->department_name)
//         ->where('emid', '=', $Roledata->reg)
//         ->get();
//     $result = '';
//     $result_status1 = "  <option value=''>Select</option>
// ";
//     foreach ($employee_rs as $bank) {
//         $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
//     }

//     echo $result_status1;

// });

Route::get('pis/getEmployeedailyattandeaneshightById/absent/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $employee_desigrs = DB::table('designation')
        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_depers = DB::table('department')
        ->where('id', '=', $employee_desigrs->department_code)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('employee')

        ->where('emp_designation', '=', $employee_desigrs->designation_name)
        ->where('emp_department', '=', $employee_depers->department_name)
        ->where('emid', '=', $Roledata->reg)
        ->where(function ($query) {

            $query->whereNull('employee.emp_status')
                ->orWhere('employee.emp_status', '!=', 'LEFT');
        })
        ->get();
    $result = '';
    $result_status1 = "  <option value=''>Select</option>
";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeedailyattandeaneshightById/{empid}', function ($empid) {

    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
        ->where('email', '=', $email)
        ->first();

        if (is_numeric($empid)) {
                $designi = DB::table('designation')
                ->where('id', '=',$empid)
                ->first();
                // dd($designi);

                 $employee_rs = DB::table('employee')

        ->where('emp_designation', '=',$designi->designation_name)

        ->where('emid', '=', $Roledata->reg)
        ->where(function ($query) {

            $query->whereNull('employee.emp_status')
                ->orWhere('employee.emp_status', '!=', 'LEFT');
        })
        ->get();

        // dd($employee_rs);

    $result = '';
    $result_status1 = "  <option value=''>Select</option>
	<option value=''>All</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;


        } elseif (is_string($empid)) {
           $employee_rs = DB::table('employee')

        ->where('emp_designation', '=',$empid)

        ->where('emid', '=', $Roledata->reg)
        ->where(function ($query) {

            $query->whereNull('employee.emp_status')
                ->orWhere('employee.emp_status', '!=', 'LEFT');
        })
        ->get();

        // dd($employee_rs);

    $result = '';
    $result_status1 = "  <option value=''>Select</option>
	<option value=''>All</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;
        } else {
            echo "Unknown type";
        }





});

Route::get('pis/getEmployeedailyattandeaneById/{empid}', function ($empid) {
//  dd($empid);
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

   $employee_rs = DB::table('employee')
    ->where('emp_status',$empid)
    ->get();

// dd($employee_rs);
    $result = '';
    $result_status1 = "  <option value=''>Select</option>
    <option value=''>All</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeedailyattandeaneByIdnewvchange/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::table('employee')

        ->where('emp_status', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "  <option value=''>Select</option>
   ";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('employeecornerdashboard', 'App\Http\Controllers\EmployeeCornerController@viewdash');
Route::get('employee-corner/user-profile', 'App\Http\Controllers\EmployeeCornerController@viewdetadash');

Route::get('employee-corner/update-profile', 'App\Http\Controllers\EmployeeCornerController@viewAddEmployeeco');
Route::post('employee-corner/update-profile', 'App\Http\Controllers\EmployeeCornerController@saveEmployeeco');

Route::get('employee-corner/holiday', 'App\Http\Controllers\EmployeeCornerController@viewdetaholiday');
Route::get('employee-corner/leave-apply', 'App\Http\Controllers\EmployeeCornerController@viewapplyleaveapplication');

Route::post('employee-corner/leave-apply', 'App\Http\Controllers\EmployeeCornerController@saveApplyLeaveData');

Route::get('employee-corner/change-password', 'App\Http\Controllers\EmployeeCornerController@viewcahngepass');

Route::post('employee-corner/change-password', 'App\Http\Controllers\EmployeeCornerController@savecahngepass');
Route::post('employee-corner/change-password', 'App\Http\Controllers\EmployeeCornerController@savecahngepass');

Route::post('employee-corner/user-image', 'App\Http\Controllers\EmployeeCornerController@savecahngeimage');

Route::post('leave/holiday-count', 'App\Http\Controllers\EmployeeCornerController@holidayLeaveApplyAjax');

Route::get('employee-corner/attendance-status', 'App\Http\Controllers\EmployeeCornerController@viewAttandancestatus');

Route::post('employee-corner/attendance-status', 'App\Http\Controllers\EmployeeCornerController@saveAttandancestatus');

Route::get('employee-corner/change-of-circumstances', 'App\Http\Controllers\EmployeeCornerController@viewchangecircumstances');

Route::get('employee-corner/circumstances-edit', 'App\Http\Controllers\EmployeeCornerController@viewchangecircumstancesedit');

Route::post('employee-corner/circumstances-edit', 'App\Http\Controllers\EmployeeCornerController@savechangecircumstancesedit');
Route::get('employee-corner/contract-agreement', 'App\Http\Controllers\EmployeeCornerController@viewemployeeagreement');

//sm-11-11-2021
Route::get('employee-corner/work-update', 'App\Http\Controllers\EmployeeCornerController@viewworkupdate');
Route::get('employee-corner/add-work-update', 'App\Http\Controllers\EmployeeCornerController@viewaddworkupdate');
Route::post('employee-corner/task-save', 'App\Http\Controllers\EmployeeCornerController@viewtasksave');
Route::get('employee-corner/work-edit/{id}', 'App\Http\Controllers\EmployeeCornerController@viewaddworkupdateget');
Route::post('employee-corner/task-update', 'App\Http\Controllers\EmployeeCornerController@viewtaskupdate');

//----

Route::get('employee-corner/contract-agreement-edit', 'App\Http\Controllers\EmployeeCornerController@viewemployeeagreementdit');

Route::get('employee/contract-agreement', 'App\Http\Controllers\EmployeeController@viewemployeeagreement');

Route::post('employee/contract-agreement', 'App\Http\Controllers\EmployeeController@saveemployeeagreement');
Route::get('employee/contract-agreement-edit/{agreement_id}', 'App\Http\Controllers\EmployeeController@viewemployeeagreementdit');

Route::get('leave/get-leave-in-hand/{id_leave_type}/{apply_date}', function ($id_leave_type, $apply_date) {
    $user_id = Session::get('users_id');

    $users = DB::table('users')->where('id', '=', $user_id)->first();

    // $leaveinhand = DB::table('leave_allocation')
    //     ->where('leave_type_id', '=', $id_leave_type)
    //     ->where('employee_code', '=', $users->employee_id)
    //     ->where('emid', '=', $users->emid)
    //     ->where('month_yr', 'like', '%' . date('Y', strtotime($apply_date)) . '%')
    //     ->orderBy('id', 'DESC')
    //     ->first();
    // dd($leaveinhand);

//   dd($users->emid);
    $leaveinhand=DB::table('leave_allocation')
     ->where('leave_type_id','=',$id_leave_type)
        ->where('employee_code','=',$users->employee_id)
        ->where('emid','=',$users->emid)
    //  ->where('month_yr','like','%2020%')
    ->orderBy('id','DESC')
     ->first();
    //  dd($leaveinhand);

    if (!empty($leaveinhand)) {
        if ($leaveinhand->leave_in_hand > 0) {

            echo $leaveinhand->leave_in_hand;

        } else {
            echo '0';
        }
    } else {
        echo '0';
    }

});

Route::get('leave/get-allocated-leave-in-hand/{id_leave_type}', function ($id_leave_type) {
    $user_id = Session::get('users_id');
    $users = DB::table('users')->where('id', '=', $user_id)->first();

    $leaveinhand = DB::table('leave_allocation')
        ->where('id', '=', $id_leave_type)
        ->where('employee_code', '=', $users->employee_id)
        ->where('emid', '=', $users->emid)
    //->where('month_yr', 'like', '%' . date('Y') . '%')
        ->orderBy('id', 'DESC')
        ->first();

    // $leaveinhand=DB::table('leave_allocation')
    //  ->where('leave_type_id','=',$id_leave_type)
    //    ->where('employee_code','=',$users->employee_id)
    //    ->where('emid','=',$users->emid)
    //  ->where('month_yr','like','%2020%')
    // ->orderBy('id','DESC')
    //  ->first();

    if (!empty($leaveinhand)) {
        if ($leaveinhand->leave_in_hand > 0) {

            echo $leaveinhand->leave_in_hand;

        } else {
            echo '0';
        }
    } else {
        echo '0';
    }

});

Route::get('organogramdashboard', 'App\Http\Controllers\OrganogramController@viewdash');
Route::get('organogram-chart', 'App\Http\Controllers\OrganogramController@showHierarchy')->name('organogram.chart');

Route::get('organogram-chart/vw-level', 'App\Http\Controllers\OrganogramController@viewlevel');
Route::get('organogram-chart/add-vw-level', 'App\Http\Controllers\OrganogramController@viewAddNewLevel');
Route::post('organogram-chart/add-vw-level', 'App\Http\Controllers\OrganogramController@saveLevelData');

Route::get('organogram-chart/vw-hierarchy', 'App\Http\Controllers\OrganogramController@viewhierarchy');
Route::get('organogram-chart/add-vw-hierarchy', 'App\Http\Controllers\OrganogramController@viewAddNewHierarchy');
Route::post('organogram-chart/add-vw-hierarchy', 'App\Http\Controllers\OrganogramController@saveHierarchyData');

// Route::get('organo/get-employee-all-organo-details/{empid}', function ($empid) {
//     $email = Session::get('emp_email');
//     $Roledata = DB::table('registration')
//         ->where('email', '=', $email)
//         ->first();
//     //dd($Roledata->reg);
//     $employee_rs = DB::table('employee')

//         ->where('emp_code', '=', $empid)
//         ->where('emid', '=', $Roledata->reg)
//         ->select('employee.*')->first();
//     $employee_rs_report = '';
//     if (!empty($employee_rs->emp_reporting_auth)) {
//         $employee_rs_report = DB::table('employee')

//             ->where('emp_code', '=', $employee_rs->emp_reporting_auth)
//             ->where('emid', '=', $Roledata->reg)
//             ->select('employee.*')->first();
//     } else {
//         $employee_rs_report = '';
//     }
//     echo json_encode(array($employee_rs, $employee_rs_report));

// });
Route::get('organo/get-employee-all-organo-details/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::table('employee')
        ->where('emp_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->select('employee.*')
        ->first();

    $employee_rs_report = null;
    if (!empty($employee_rs) && !empty($employee_rs->emp_reporting_auth)) {
        $employee_rs_report = DB::table('employee')
            ->where('emp_code', '=', $employee_rs->emp_reporting_auth)
            ->where('emid', '=', $Roledata->reg)
            ->select('employee.*')
            ->first();
    }

    $data = [
        'employee_rs' => $employee_rs,
        'employee_rs_report' => $employee_rs_report,
    ];

    return view('organogram-chart.dashboard', $data);
});

Route::get('rotadashboard', 'App\Http\Controllers\RotaController@viewdash');
Route::get('rota/shift-management', 'App\Http\Controllers\RotaController@viewshift')->name('shift-list');
Route::get('rota/add-shift-management', 'App\Http\Controllers\RotaController@viewAddNewShift');
Route::post('rota/add-shift-management', 'App\Http\Controllers\RotaController@saveShiftData');
Route::get('rota/add-shift-management-desi/{designition}', 'App\Http\Controllers\RotaController@empdesignition');
Route::get('rota/delete-shift-management/{id}', 'App\Http\Controllers\RotaController@shiftDeleted');

Route::get('rota/visitor-link', 'App\Http\Controllers\RotaController@viewvisitorlink');
Route::get('rota/visitor-regis', 'App\Http\Controllers\RotaController@viewvisitorregis');
Route::get('rota/visitor-regis-edit/{id}', 'App\Http\Controllers\RotaController@eitvisitorregisterlist');
Route::post('rota/visitor-edit', 'App\Http\Controllers\RotaController@eitvisitorregistersave');
Route::get('rota/visitor-regis-deleted/{id}', 'App\Http\Controllers\RotaController@visitorDeleted');

Route::get('rota/late-policy', 'App\Http\Controllers\RotaController@viewlate');
Route::get('rota/add-late-policy', 'App\Http\Controllers\RotaController@viewAddNewlate');
Route::post('rota/add-late-policy', 'App\Http\Controllers\RotaController@savelateData');

Route::get('visitor/{career_id}', 'App\Http\Controllers\RotaController@viewvis');

Route::post('visitor', 'App\Http\Controllers\RotaController@savevis');

Route::get('visitor-register/thank-you', 'App\Http\Controllers\RotaController@appthankyouvis');

Route::get('rota/offday', 'App\Http\Controllers\RotaController@viewoffday');
Route::get('rota/add-offday', 'App\Http\Controllers\RotaController@viewAddNewoffday');
Route::post('rota/add-offday', 'App\Http\Controllers\RotaController@saveoffdayData');
Route::post('rota/duty-roster-report', 'App\Http\Controllers\RotaController@savereportroData');
Route::post('rota/duty-roster-report-excel', 'App\Http\Controllers\RotaController@savereportroexcelData');

Route::get('rota/grace-period', 'App\Http\Controllers\RotaController@viewgrace');
Route::get('rota/add-grace-period', 'App\Http\Controllers\RotaController@viewAddNewgrace');
Route::post('rota/add-grace-period', 'App\Http\Controllers\RotaController@savegraceData');

Route::get('rota/duty-roster', 'App\Http\Controllers\RotaController@viewroster');

Route::post('rota/add-duty-roster', 'App\Http\Controllers\RotaController@saverosterData');

Route::get('rota/add-department-duty', 'App\Http\Controllers\RotaController@viewAddNewdepartmentduty');
Route::post('rota/add-department-duty', 'App\Http\Controllers\RotaController@savedepartmentdutyData');

Route::get('rota/add-employee-duty', 'App\Http\Controllers\RotaController@viewAddNewemployeeduty');
Route::post('rota/add-employee-duty', 'App\Http\Controllers\RotaController@saveemployeedutyData');

Route::get('pis/getEmployeedailyattandeaneshightdutyById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $employee_desigrs = DB::table('designation')
        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

        $designation_name=$employee_desigrs->designation_name;
    $employee_depers = DB::table('department')
        ->where('id', '=', $employee_desigrs->department_code)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    $employee_rs = DB::table('employee')

        ->where('emp_designation', '=',$designation_name)
        ->where('emp_department', '=', $employee_depers->department_name)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "  <option value=''>&nbsp;</option>
	";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '"';if (isset($employee_code) && $employee_code == $bank->emp_code) {$result_status1 .= 'selected';}$result_status1 .= '> ' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeedesigBydutytshiftId/{empid}', function ($empid) {

    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::table('shift_management')

        ->where('designation', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();

    $result = '';
    $result_status1 = "";
    $du = 1;
    foreach ($employee_rs as $bank) {

        if ($du == '1') {
            $chedu = 'checked';
        } else {
            $chedu = '';
        }
        $result_status1 .= '<div class="col-md-3">
											  <input id="shift_code' . $bank->id . '" type="checkbox" name="shift_code[]" value="' . $bank->id . '"  ' . $chedu . '>
											  <label for="shift_code' . $bank->id . '" class="day-check">' . $bank->shift_code . '  ( ' . $bank->shift_des . ' )</label>

										 </div>	';
        $du++;
    }
    echo $result_status1;
});
Route::get('role/get-employee-all-details-shift/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::table('shift_management')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    echo json_encode(array($employee_rs));

});

Route::get('pis/getEmployeedesigBylateId/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::table('shift_management')

        ->where('designation', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->id . '">' . $bank->shift_code . '  ( ' . $bank->shift_des . ' )</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeedesigByshiftIdcode/{department}/{designation}/{employee_code}/{start_date}/{end_date}/{emid}', function ($department, $designation, $employee_code, $start_date, $end_date, $emid) {
    //dd($emid);
    $Roledata = DB::table('registration')

        ->where('reg', '=', $emid)
        ->first();

    $desig_rs = DB::table('department')

        ->where('id', '=', $department)
        ->where('emid', '=', $emid)
        ->first();

    $employee_rs = DB::table('designation')

        ->where('id', '=', $designation)
        ->where('emid', '=', $emid)
        ->get();

    $duty_rs = DB::table('duty_roster')
        ->where('start_date', '<=', date('Y-m-d', strtotime($start_date)))
        ->where('end_date', '>=', date('Y-m-d', strtotime($end_date)))
        ->where('employee_id', '=', $employee_code)
        ->where('department', '=', $department)
        ->where('designation', '=', $designation)
        ->where('emid', '=', $emid)
        ->get();


    //dd($duty_rs);

    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($duty_rs as $bank) {
        //dd($bank->shift_code);
        $employee_shift = DB::table('shift_management')
            ->where('id', '=', $bank->shift_code)

            ->first();
        $result_status1 .= '<option value="' . $employee_shift->id . '">' . $employee_shift->shift_code . '  ( ' . $employee_shift->shift_des . ' )</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeedesigByshiftId/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('department')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();


    $employee_rs = DB::table('designation')

        ->where('department_code', '=', $desig_rs->id)
        ->get();
        // dd($employee_rs);
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->id . '">' . $bank->designation_name . '</option>';
    }

    echo $result_status1;

});

Route::get('settings/vw-tax', 'App\Http\Controllers\SettingController@getTaxmaster');
Route::get('settings/tax', 'App\Http\Controllers\SettingController@viewAddTaxmaster');
Route::post('settings/tax', 'App\Http\Controllers\SettingController@saveTaxmaster');

// Route::get('settings/vw-tax', 'App\Http\Controllers\SettingController@getTaxmaster');
// Route::get('settings/tax', 'App\Http\Controllers\SettingController@viewAddTaxmaster');
// Route::post('settings/tax', 'App\Http\Controllers\SettingController@saveTaxmaster');

Route::get('settings/vw-pay-type', 'App\Http\Controllers\SettingController@getPaytypemaster');
Route::get('settings/pay-type', 'App\Http\Controllers\SettingController@viewAddPaytypemaster');
Route::post('settings/pay-type', 'App\Http\Controllers\SettingController@savePaytypemaster');

Route::get('settings/vw-wedgespay-type', 'App\Http\Controllers\SettingController@getwedgesPaytypemaster');
Route::get('settings/wedgespay-type', 'App\Http\Controllers\SettingController@viewAddwedgesPaytypemaster');
Route::post('settings/wedgespay-type', 'App\Http\Controllers\SettingController@savewedgesPaytypemaster');

Route::get('appsettings/vw-wedgespay-type/{emp_id}', 'App\Http\Controllers\AppSettingController@getwedgesPaytypemaster');
Route::get('appsettings/add-new-wedgespay-type/{emp_id}', 'App\Http\Controllers\AppSettingController@viewAddwedgesPaytypemaster');
Route::post('appsettings/add-new-wedgespay-type', 'App\Http\Controllers\AppSettingController@savewedgesPaytypemaster');
Route::post('appsettings/add-new-wedgespay-type-new', 'App\Http\Controllers\AppSettingController@savewedgesPaytypemaster');

Route::get('settings/vw-currency', 'App\Http\Controllers\SettingController@getcurrenmaster');
Route::get('settings/currency', 'App\Http\Controllers\SettingController@viewAddcurrenmaster');
Route::post('settings/currency', 'App\Http\Controllers\SettingController@savecurrenmaster');

Route::get('settings/vw-nationality', 'App\Http\Controllers\SettingController@getNationmaster');
Route::get('settings/nationality', 'App\Http\Controllers\SettingController@viewAddNationmaster');
Route::post('settings/nationality', 'App\Http\Controllers\SettingController@saveNationmaster');

Route::get('useraccessdashboard', 'App\Http\Controllers\UseraceesController@viewdash');

Route::get('role/vw-users', 'App\Http\Controllers\UseraceesController@viewUserConfig');
Route::get('role/vw-user-config', 'App\Http\Controllers\UseraceesController@viewUserConfigForm');
Route::post('role/vw-user-config', 'App\Http\Controllers\UseraceesController@SaveUserConfigForm');
Route::get('role/vw-user-config/{user_id}', 'App\Http\Controllers\UseraceesController@GetUserConfigForm');

//Mock interview organisation 30-05-2022
Route::get('recruitment/interview-forms', 'App\Http\Controllers\RecruitmentController@viewInterviewForms');
Route::get('recruitment/add-interview-form', 'App\Http\Controllers\RecruitmentController@addInterviewForm');
Route::post('recruitment/add-interview-form', 'App\Http\Controllers\RecruitmentController@saveInterviewForm');

Route::get('recruitment/copy-interview-form/{form_id}', 'App\Http\Controllers\App\Http\Controllers\RecruitmentController@copyInterviewForm');

Route::get('recruitment/add-form-question/{form_id}', 'App\Http\Controllers\RecruitmentController@addFormQuestion');
Route::post('recruitment/add-form-question/{form_id}', 'App\Http\Controllers\RecruitmentController@saveFormQuestion');

Route::get('recruitment/take-interview/{form_id}', 'App\Http\Controllers\RecruitmentController@addInterview');
Route::post('recruitment/take-interview/{form_id}', 'App\Http\Controllers\RecruitmentController@saveInterview');

Route::get('pis/getInterviewCandidateInfo/{candidate_id}', function ($candidate_id) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')

        ->where('email', '=', $email)
        ->first();

    $candidates = DB::table('candidate')
        ->join('company_job','company_job.id','=','candidate.job_id')
        ->where('company_job.emid', $Roledata->reg)
        ->where('candidate.id','=',$candidate_id)

        ->first();

    //dd($candidates);

    echo json_encode($candidates);

});

Route::get('recruitment/interviews', 'App\Http\Controllers\RecruitmentController@viewInterviews');
Route::get('recruitment/interview/{id}', 'App\Http\Controllers\RecruitmentController@viewInterviewDetail');
Route::get('recruitment/interview/edit/{id}', 'App\Http\Controllers\RecruitmentController@editInterviewDetail');
Route::post('recruitment/interview/edit/{id}', 'App\Http\Controllers\RecruitmentController@updateInterviewDetail');

Route::get('recruitment/interview-feedback/{id}', 'App\Http\Controllers\RecruitmentController@viewInterviewFeedback');
Route::post('recruitment/interview-feedback/{id}', 'App\Http\Controllers\RecruitmentController@saveInterviewFeedback');

Route::get('recruitment/delete-interview/{id}', 'App\Http\Controllers\RecruitmentController@deleteInterview');

Route::get('recruitment/interview-feedback-report/{id}', 'App\Http\Controllers\RecruitmentController@getInterviewFeedbackReport');

Route::get('recruitment/capstone-assessment-report', 'App\Http\Controllers\RecruitmentController@viewCapstoneReport');
Route::post('recruitment/capstone-assessment-report', 'App\Http\Controllers\RecruitmentController@getCapstoneReport');
Route::post('recruitment/capstone-assessment-report-pdf', 'App\Http\Controllers\RecruitmentController@pdfCapstoneReport');

Route::get('recruitment/ca-assessment-report', 'App\Http\Controllers\RecruitmentController@viewCaReport');
Route::post('recruitment/ca-assessment-report', 'App\Http\Controllers\RecruitmentController@getCaReport');
Route::post('recruitment/ca-assessment-report-pdf', 'App\Http\Controllers\RecruitmentController@pdfCaReport');
//--------------------------

Route::get('recruitmentdashboard', 'App\Http\Controllers\RecruitmentController@viewdash');
Route::get('recruitment/job-list', 'App\Http\Controllers\RecruitmentController@viewjoblist');

Route::get('recruitment/add-job-list', 'App\Http\Controllers\RecruitmentController@viewAddNewJobList');
Route::post('recruitment/add-job-list', 'App\Http\Controllers\RecruitmentController@saveJobListData');
Route::get('recruitment/soccode/{id}', 'App\Http\Controllers\RecruitmentController@soccodess');


Route::get('recruitment/message-centre', 'App\Http\Controllers\RecruitmentController@viewmsgcen');
Route::get('recruitment/add-message-centre', 'App\Http\Controllers\RecruitmentController@addmscen');
Route::post('recruitment/add-message-centre', 'App\Http\Controllers\RecruitmentController@savemscen');

Route::get('recruitment/job-post', 'App\Http\Controllers\RecruitmentController@viewjobpost');

Route::get('recruitment/add-job-post', 'App\Http\Controllers\RecruitmentController@viewAddNewJobPost');
Route::post('recruitment/add-job-post', 'App\Http\Controllers\RecruitmentController@saveJobPostData');
Route::get('recruitment/resume-bulk', 'App\Http\Controllers\RecruitmentController@filterDaterange');

Route::get('recruitment/job-published', 'App\Http\Controllers\RecruitmentController@viewjobpublished');

Route::get('recruitment/add-job-published', 'App\Http\Controllers\RecruitmentController@viewAddNewpublished');
Route::post('recruitment/add-job-published', 'App\Http\Controllers\RecruitmentController@saveJobpublishedData');

Route::get('recruitment/candidate', 'App\Http\Controllers\RecruitmentController@viewcandidate');
Route::get('recruitment/edit-candidate/{candidate_id}', 'App\Http\Controllers\RecruitmentController@viewcandidatedetails');
Route::get('career/{career_id}', 'App\Http\Controllers\CareerController@viewdash');

Route::post('recruitment/edit-candidate', 'App\Http\Controllers\RecruitmentController@savecandidatedetails');
Route::get('recruitment/search', 'App\Http\Controllers\RecruitmentController@viewsearchcandidate');
Route::post('recruitment/search', 'App\Http\Controllers\RecruitmentController@getsearchcandidate');

Route::get('recruitment/status-search', 'App\Http\Controllers\RecruitmentController@viewsearchcandidatestatus');
Route::post('recruitment/status-search', 'App\Http\Controllers\RecruitmentController@getsearchcandidatestatus');
Route::post('recruitment/status-search-result', 'App\Http\Controllers\RecruitmentController@savesearchopstatus');
Route::post('recruitment/status-search-result-excel', 'App\Http\Controllers\RecruitmentController@savesearchopexcelstatus');
Route::get('recruitment/short-listing', 'App\Http\Controllers\RecruitmentController@viewshortcandidate');
Route::get('recruitment/edit-short-listing/{short_id}', 'App\Http\Controllers\RecruitmentController@viewshortcandidatedetails');

Route::post('recruitment/edit-short-listing', 'App\Http\Controllers\RecruitmentController@saveshortcandidatedetails');

Route::get('recruitment/reject', 'App\Http\Controllers\RecruitmentController@viewrejectcandidate');
Route::get('recruitment/edit-reject/{reject_id}', 'App\Http\Controllers\RecruitmentController@viewrejectcandidatedetails');

Route::post('recruitment/edit-reject', 'App\Http\Controllers\RecruitmentController@saverejectcandidatedetails');

Route::get('recruitment/interview', 'App\Http\Controllers\RecruitmentController@viewinterviewcandidate');
Route::get('recruitment/edit-interview/{interview_id}', 'App\Http\Controllers\RecruitmentController@viewinterviewcandidatedetails');

Route::post('recruitment/edit-interview', 'App\Http\Controllers\RecruitmentController@saveinterviewcandidatedetails');

Route::get('recruitment/hired', 'App\Http\Controllers\RecruitmentController@viewhiredcandidate');
Route::get('recruitment/edit-hired/{hired_id}', 'App\Http\Controllers\RecruitmentController@viewhiredcandidatedetails');
Route::post('recruitment/edit-hired', 'App\Http\Controllers\RecruitmentController@savehiredcandidatedetails');

Route::get('recruitment/apply-letter/{send_id}', 'App\Http\Controllers\RecruitmentController@viewapplysendcandidatedetails');
Route::get('recruitment/interview-letter/{send_id}', 'App\Http\Controllers\RecruitmentController@viewinterviewsendcandidatedetails');
Route::get('recruitment/offer-down-letter/{send_id}', 'App\Http\Controllers\RecruitmentController@viewofferdownsendcandidatedetails');
Route::get('recruitment/offer-letter', 'App\Http\Controllers\RecruitmentController@viewsoffercandidate');
Route::get(' recruitment/generate-letter', 'App\Http\Controllers\RecruitmentController@viewsofferlattercandidate');

Route::post('recruitment/edit-offer-letter', 'App\Http\Controllers\RecruitmentController@saveofferlat');
Route::get('recruitment/send-letter-job-applied/{send_id}', 'App\Http\Controllers\RecruitmentController@viewsendcandidatedetailsjobapplied');
Route::get('recruitment/send-letter-job-shorting/{send_id}', 'App\Http\Controllers\RecruitmentController@viewsendcandidatedetailsjobshorting');
Route::get('recruitment/send-letter/{send_id}', 'App\Http\Controllers\RecruitmentController@viewsendcandidatedetails');
Route::post('recruitment/search-result', 'App\Http\Controllers\RecruitmentController@savesearchop');
Route::post('recruitment/search-result-excel', 'App\Http\Controllers\RecruitmentController@savesearchopexcel');

Route::get('recruitment/get-employee/{val}', function ($val) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('candidate')

        ->where('id', '=', $val)

        ->first();
    return json_encode($desig_rs);

});

Route::get('career/application/{career_id}', 'App\Http\Controllers\CareerController@viewapp');

Route::post('career/application', 'App\Http\Controllers\CareerController@saveapp');

Route::get('thank-you', 'App\Http\Controllers\CareerController@appthankyou');

Route::get('role/get-employee-all-details/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::table('employee')

        ->where('emp_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->select('employee.*')->first();

    echo json_encode(array($employee_rs));

});

Route::get('pis/getEmployeedesigById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('department')

        ->where('department_name', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('designation')

        ->where('department_code', '=', $desig_rs->id)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->designation_name . '">' . $bank->designation_name . '</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeeannulById/{empid}', function ($empid) {
    // dd($Roledata->reg);
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();
    $desig_rs = DB::table('pay_scale_master')
        ->where('payscale_code', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    //   dd($desig_rs);
    $employee_rs = DB::table('pay_scale_basic_master')

        ->where('pay_scale_master_id', '=', $desig_rs->id)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->pay_scale_basic . '">' . $bank->pay_scale_basic . '</option>';
    }

    echo $result_status1;

});

Route::get('pis/getEmployeeminworkById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('payment_type_master')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    return json_encode($desig_rs);

});

Route::get('pis/getEmployeetaxempById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('tax_master')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    return json_encode($desig_rs);

});

Route::get('attendance/get-employee-bank/{emp_branch_id}', function ($emp_branch_id) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $employee_ifsc_code = DB::table('bank')->where('bank_name', '=', $emp_branch_id)->where('emid', '=', $Roledata->reg)->first();
    echo json_encode($employee_ifsc_code);
});

Route::get('role/user-role', 'App\Http\Controllers\UseraceesController@viewUserAccessRightsForm');

Route::post('role/user-role', 'App\Http\Controllers\UseraceesController@UserAccessRightsFormAuth');
Route::get('role/view-users-role', 'App\Http\Controllers\UseraceesController@viewUserAccessRights');

Route::get('role/view-users-role/{role_authorization_id}', 'App\Http\Controllers\UseraceesController@deleteUserAccess');
Route::get('role/get-sub-modules/{id_module}', 'App\Http\Controllers\UseraceesController@getsubmodule');

// Route::get('role/get-sub-modules/{id_module}', function ($id_module) {

//     $sub_module_rs = DB::table('module_config')->where('module_id', '=', $id_module)->get();
//     //dd($grade_rs);
//     $result = '';

//     foreach ($sub_module_rs as $sub_module) {
//         $result .= '<option value="' . $sub_module->id . '">' . $sub_module->menu_name . '</option>';
//     }
//     echo $result;
// });

Route::get('role/get-menu/{id_submenu}', function ($id_submenu) {

    $module_config_rs = DB::Table('module_config')->where('sub_module_id', '=', $id_submenu)->get();
    //dd($grade_rs);
    $result = '<option value="" selected disabled >Select</option>';

    foreach ($module_config_rs as $menu) {
        $result .= '<option value="' . $menu->id . '">' . $menu->menu_name . '</option>';
    }
    echo $result;
});

Route::get('role/get-role-menu/{id_sub_module}', function ($id_sub_module) {

    //$sub_module_rs=SubModule::where('module_id','=',$id_module)->get();
    $rolemenus = DB::table('module_config')->where('sub_module_id', '=', $id_sub_module)->get();
    //dd($grade_rs);
    $result = '';

    foreach ($rolemenus as $menu) {
        $result .= '<option value="' . $menu->id . '">' . $menu->menu_name . '</option>';
    }
    echo $result;

});

Route::get('pis/getEmployeenameById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('employee_type')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('employee')
        ->where('emid', '=', $Roledata->reg)
        ->where('emp_status', '=', $desig_rs->employee_type_name)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->emp_code . '">' . $bank->emp_fname . ' ' . $bank->emp_mname . ' ' . $bank->emp_lname . ' (' . $bank->emp_code . ')</option>';
    }

    echo $result_status1;

});

Route::get('pis/getcompanycountryById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $employee_rs = DB::table('currencies')

        ->where('country', '=', $empid)
        ->get();
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->code . '">' . $bank->code . '</option>';
    }

    echo $result_status1;

});

Route::get('pis/getjobpostByIdlkkk/{empid}', function ($empid) {

    $email = Session::get('emp_email');

    $Roledata = DB::table('registration')
        ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('company_job_list')

        ->where('soc', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    $employee_rs = DB::table('company_job_list')

        ->where('soc', '=', $desig_rs->soc)
        ->where('emid', '=', $Roledata->reg)
        ->get();
        // dd($employee_rs);
    $result = '';
    $result_status1 = "<option value='' selected disabled> &nbsp;</option>";
    foreach ($employee_rs as $bank) {
        $result_status1 .= '<option value="' . $bank->title . '">' . $bank->title . '</option>';
    }

    echo $result_status1;

});

Route::get('pis/getjobpostByIdlkkkll/{empid}/{soc}', function ($empid, $soc) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('company_job_list')

        ->where('soc', '=', $soc)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    $employee_rs = DB::table('company_job_list')

        ->where('soc', '=', $desig_rs->soc)
        ->where('title', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();

    return json_encode($employee_rs);

});

Route::get('pis/getjobpostById/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('company_job_list')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    return json_encode($desig_rs);

});
Route::get('pis/getjobpostBjjyId/{empid}', function ($empid) {
    $email = Session::get('emp_email');
    $Roledata = DB::table('registration')
    ->where('status', '=', 'active')
        ->where('email', '=', $email)
        ->first();

    $desig_rs = DB::table('company_job')

        ->where('id', '=', $empid)
        ->where('emid', '=', $Roledata->reg)
        ->first();
    return json_encode($desig_rs);

});


/***** Testing **** */
Route::get('sm-accept-payment', 'App\Http\Controllers\TestController@acceptPayment');
route::post('sm-get-payment', 'App\Http\Controllers\TestController@getPaymentInfo');

//*********************Sub Admin Route *************/
Route::get('subadmin/active', 'App\Http\Controllers\AdminController@activeSubadmin');
Route::get('subadmin/notverify', 'App\Http\Controllers\AdminController@nonVerfySubadmin');
Route::get('subadmin/verify', 'App\Http\Controllers\AdminController@VerfySubadmin');
Route::get('subadmin/edit-sub-company/{comp_id}', 'App\Http\Controllers\AdminController@viewSubAddCompany');
Route::post('subadmin/editsubcompany', 'App\Http\Controllers\AdminController@saveSubCompany');
Route::get('subadmin/view-sub-organization/{comp_id}', 'App\Http\Controllers\AdminController@viewSubOrganization');


// Ajax Route ------------------------------------------------------------
Route::get('pis/getEmployeedailyattandeaneshightByIdnewr/{empid}','App\Http\Controllers\AjaxController@getEmpCode');
