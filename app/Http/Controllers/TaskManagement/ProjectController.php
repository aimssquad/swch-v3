<?php

namespace App\Http\Controllers\TaskManagement;

use App\Http\Controllers\Controller;
use App\Models\TaskManagement\MasterLabels;
use App\Models\TaskManagement\MasterRoles;
use Illuminate\Http\Request;
use App\Models\TaskManagement\Project;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function test(Request $request)
    {

        $params = DB::table('projects')->toSql();
        print_r($request->all());
        echo 'ok';
    }

    // public function create()
    // {
    //     return view('projects.create');
    // }

    public function create(Request $request)
    {

        // $duplicateName = Project::find('title', $request->input('title'));
        // if($duplicateName)
        // $user = Auth::user();
        // print_r(Session::all());
        // echo Session::get('users_id');
        // // print_r(Session::all());
        // die;
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $validatedData = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'identifier' => 'nullable',
                // 'createdBy' => 'required',
                // 'status' => 'required'
            ]);
            $isExist = Project::where(['title' => $validatedData['title'], 'emid' => $Roledata->reg])->first();
            if ($isExist) {
                session()->flash('error', 'Project already exist in the system');
                return redirect()->back();
            } else {

                // print_r($validatedData);
                // die;
                $validatedData['created_at'] = date('Y-m-d h:i:s');
                $validatedData['createdBy'] = $currentUser;
                $validatedData['status'] = 'open';
                $validatedData['emid'] = $Roledata->reg;
                $project = Project::create($validatedData);
                $labels = MasterLabels::create([
                    'title' => 'Todo',
                    'project_id' => $project->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'createdBy' => $currentUser
                ]);
                $labels1 = MasterLabels::create([
                    'title' => 'Resolved',
                    'project_id' => $project->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'createdBy' => $currentUser
                ]);
                $roles = MasterRoles::create([
                    'title' => 'Owner',
                    'project_id' => $project->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'createdBy' => $currentUser
                ]);
                $roles2 = MasterRoles::create([
                    'title' => 'Manager',
                    'project_id' => $project->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'createdBy' => $currentUser
                ]);
                session()->flash('message', 'Project has been created successfully');
                return redirect()->back();
            }
            // return response()->json($project, 201);
        } else {
            session()->flash('error', 'Permission denied');
            return redirect()->back();
            // return response()->json(['message' => 'Unauthorized access'], 401);
        }
    }

    public function show(Request $request)
    {
        $limit = $request->input('limit');
        if (!isset($limit))
            $limit = 10;
        $page = (int) $request->input('page');
        $skip = ($page - 1) * (int) $limit;
        if (!isset($page))
            $skip = 0;

        $project = Project::select('*')
            ->offset($skip)
            ->limit((int) $limit)
            ->get();
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return response()->json($project);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            // 'id' => 'required',
            // 'keywords' => 'required',
            'identifier' => 'nullable',
            'status' => 'required'
        ]);
        // $data = [
        //     'title' => $request->input('title'),
        //     'description' => $request->input('description'),
        //     'keywords' => $request->input('keywords'),
        //     'status' => $request->input('status'),
        // ];
        $project_id = decrypt($request->get('id'));
        // $updateData = [

        // ]
        $project = Project::find($project_id);
        if (!$project) {
            Session::flash('error', 'Project does not exist in the system');
            return redirect('/task-management/update-project/' . $request->get('id'));
        }

        Project::where('id', $project_id)->update($validatedData);
        Session::flash('message', 'Project has been updated successfully');
        return redirect('/task-management/update-project/' . $request->get('id'));
    }

    public function destroy($id)
    {
        $project = Project::find(decrypt($id));
        if (!$project) {
            Session::flash('error', 'Project  not found');
            return redirect('/task-management/projects');
        }
        $project->delete();
        Session::flash('message', 'Project  has been deleted successfully');
        return redirect('/task-management/projects');
    }
}
