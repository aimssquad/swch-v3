<?php

namespace App\Http\Controllers\TaskManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TaskManagement\MasterLabels;
use Session;

class LabelController extends Controller
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
            $data['labels'] = MasterLabels::select("*")
                ->where('project_id', $project_id)
                ->get();
            return View('taskmanagement/labels/project-labels', $data);
        } else {
            return redirect("/");
        }
    }
    public function add(Request $request)
    {
        return View('taskmanagement/labels/project-labels-add-form');
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
            // print_r($validatedData);
            // die;
            $isExistChack = MasterLabels::where(['title' => $validatedData['title'], 'project_id' => $validatedData['project_id']])->first();
            if ($isExistChack) {
                session()->flash('error', 'This label is already exist in database');
            } else {
                $validatedData['created_at'] = date('Y-m-d h:i:s');
                $validatedData['createdBy'] = $currentUser;
                $label = MasterLabels::create($validatedData);
                session()->flash('message', 'Label has been created successfully');
                return redirect()->back();
            }
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
    public function deleteLabel(Request $request)
    {
        // echo "test" . $request->label_id;
        // die;
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            MasterLabels::where('id', decrypt($request->label_id))->delete();
            Session::flash("message", 'Label has been deleted successfully');
        } else {
            Session::flash('error', "Permission denied");
        }
        return redirect('/task-management/' . $request->id . '/labels');
    }
    public function list()
    {
    }
}
