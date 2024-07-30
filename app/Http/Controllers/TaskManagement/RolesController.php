<?php

namespace App\Http\Controllers\TaskManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\TaskManagement\MasterRoles;

class RolesController extends Controller
{
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $data = [];
            $project_id = decrypt($request->id);
            $data['labels'] = MasterRoles::select("*")
                ->where('project_id', $project_id)
                ->get();
            return View('taskmanagement/roles/project-roles', $data);
        } else {
            return redirect("/");
        }
    }
    public function add(Request $request)
    {
        $data = [];
        $data['labels'] = [];
        return View('taskmanagement/roles/project-role-add-form', $data);
    }
    public function submit(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $validatedData = $request->validate([
                'title' => 'required',

                // 'createdBy' => 'required',
                // 'status' => 'required'
            ]);
            $validatedData['project_id'] = decrypt($request->id);
            $isExistChack = MasterRoles::where(['title' => $validatedData['title'], 'project_id' => $validatedData['project_id']])->first();
            if ($isExistChack) {
                session()->flash('error', 'This role is already exist in database');
            } else {
                // print_r($validatedData);
                // die;
                $validatedData['created_at'] = date('Y-m-d h:i:s');
                $validatedData['createdBy'] = $currentUser;
                $role = MasterRoles::create($validatedData);
                session()->flash('message', 'Role has been created successfully');
            }
            return redirect()->back();
            // return response()->json($project, 201);
        } else {
            session()->flash('error', 'Permission denied');
            return redirect()->back();
            // return response()->json(['message' => 'Unauthorized access'], 401);
        }
    }
    public function update()
    {
    }
    public function delete(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            MasterRoles::where('id', decrypt($request->role_id))->delete();
            Session::flash("message", 'Role has been deleted successfully');
        } else {
            Session::flash('error', "Permission denied");
        }
        return redirect('/task-management/' . $request->id . '/roles');
    }
    public function list()
    {
    }
}
