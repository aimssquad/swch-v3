<?php

namespace App\Http\Controllers\TaskManagement;

use App\Http\Controllers\Controller;
use App\Models\Role\Employee;
use App\Models\TaskManagement\MasterRoles;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectMembers;
use Session;
use Illuminate\Http\Request;
use DB;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->ProjectMemberModel = new ProjectMembers();
    }
    public function index(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');

            $project_id = decrypt($request->id);

            $project  = Project::where('id', $project_id)->first();
            if (empty($project)) {
            } else {
                $projectMembers = ProjectMembers::where('project_id', $project_id)
                    ->join('employee', 'employee.id', '=', 'project_members.user_id')
                    ->select('project_members.*', 'employee.emp_fname as fname', 'employee.emp_mname as mname', 'employee.emp_lname as lname')
                    ->get();

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $departments = DB::table('department')->where('emid', '=', $Roledata->reg)->get();
                // print_r($Roledata);
                $data['departments'] = $departments;

                $employees = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })->get();
                $roles = MasterRoles::where('project_id', $project_id)->get();
                // $roles = ['manager' => 'Manager', 'developer' => 'Developer', 'viewer' => 'Viewer'];
                $data = ['members' => $projectMembers, 'emplyees' => $employees, 'roles' => $roles, "project" => $project, 'departments' => $departments];
                // echo "<pre>";
                // print_r($data['members']);
                // echo "</pre>";
                // die;
                return View('taskmanagement/members/project-members', $data);
            }
        } else {
            redirect("/");
        }
    }
    public function addMember()
    {
        return View('taskmanagement/members/project-member-add-form');
    }
    public function submitMember(Request $request)
    {
        $project_id = $request->id;
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $validatedData = $request->validate([
                'user_id' => 'required',
                'role' => 'required',

            ]);
            $isExit = ProjectMembers::where(['user_id' => $validatedData['user_id'], 'project_id' => decrypt($project_id)])->first();

            // die;
            if (empty($isExit)) {
                $validatedData['created_at'] = date('Y-m-d h:i:s');
                $validatedData['createdBy'] = $currentUser;
                $validatedData['project_id'] = decrypt($project_id);
                $project = ProjectMembers::create($validatedData);
                // return response()->json($project, 201);
                // print_r($project);
                // die;
                Session::flash('message', 'Project member has been added successfully');
            } else {
                $updatedData['createdBy'] = $currentUser;
                $updatedData['role'] = $validatedData['role'];
                $updatedData['created_at'] = date('Y-m-d h:i:s');
                ProjectMembers::where('id', $isExit->id)->update($updatedData);
                Session::flash('message', 'Project member has been updated successfully');
            }
            return redirect('/task-management/' . $project_id . '/project-members');
        } else {
            Session::flash('error', 'Unauthorized access');
            return redirect('/task-management/' . $project_id . '/project-members');
            // return response()->json(['message' => 'Unauthorized access'], 401);
        }
    }
    public function removeMember(Request $request)
    {
        $members_id = $request->member_id;
        $project_id = $request->id;

        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');

            $members = ProjectMembers::where('id', decrypt($members_id))->delete();
            Session::flash('message', 'Project member has been deleted successfully');
            return redirect('/task-management/' . $project_id . '/project-members');
            // return response()->json(['status' => true, 'message' => 'Members has been deleted successfully']);
        } else {
            Session::flash('error', 'Unauthorized access');
            return redirect('/task-management/' . $project_id . '/project-members');
            // return response()->json(['status' => false, 'message' => 'Unathorized access']);
        }
        // return View('taskmanagement/members');
    }
    public function getMemberById(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $members_id = $request->input->member_id;

            $member = ProjectMembers::where('id', $members_id)->first();
            return response()->json(['status' => true, 'message' => 'Members has been fetched successfully', 'data' => $member]);
        } else {
            return response()->json(['status' => false, 'message' => 'Unathorized access']);
        }
    }
    public function getEmplyee(Request $request)
    {
        // $q = $request->input->q;

        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();

        $emplyees = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

            $query->whereNull('employee.emp_status')
                ->orWhere('employee.emp_status', '!=', 'LEFT');
        })->get();
        // $employees = DB::table('employee')
        //     ->where('status', '=', 'active')

        //     ->get();
        return response()->json(['status' => true, 'data' => $emplyees]);
    }
}
