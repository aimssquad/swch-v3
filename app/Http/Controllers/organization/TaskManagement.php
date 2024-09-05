<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use App\Models\TaskManagement\MasterLabels;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\Task;
use App\Models\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TaskManagement\MasterRoles;
use Illuminate\Support\Facades\Auth;

class TaskManagement extends Controller
{
    
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.task-management';
        $this->projectModel = new Project;
        //$this->_model       = new CompanyJobs();
    }

    // return view($this->_routePrefix . '.contract-list',$data);
    public function projects()
    {
        if (!empty(Session::get('user_type'))) {
            $currentUserType = Session::get('user_type');
            $currentUser = Session::get('users_id');
            $data = [];
            // dd($currentUser);
            if ($currentUserType === 'employer') {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $projects = $this->projectModel

                    ->where('projects.emid', $Roledata->reg)
                    ->leftJoin('users as u', 'u.id', '=', 'projects.createdBy')
                    ->select('projects.*',  'u.name as owner')
                    ->get();
                foreach ($projects as $k => $p) {
                    $projects[$k]['members'] = DB::select(DB::raw('select * from project_members where project_id=' . $p->id));
                }
                $data['projects'] = $projects;
            } else {
                $empDetails = User::select("users.*", 'e.id as emp_id')
                    ->leftJoin('employee as e', 'e.emp_code', '=', 'users.employee_id')
                    ->where('users.id', $currentUser)
                    ->first();
                $projects = Project::select('projects.*',  'u.name as owner')
                    ->where('projects.createdBy', $currentUser)
                    ->orWhere('pm.user_id', $empDetails->emp_id)
                    ->leftJoin('project_members as pm', 'pm.project_id', '=', 'projects.id')
                    ->leftJoin('users as u', 'u.id', '=', 'projects.createdBy')
                    ->get();
                // $projects = $this->projectModel
                //     // ->leftJoin('project_members as pm', 'pm.project_id', '=', 'projects.id')
                //     // ->leftJoin('users as pmu', 'pm.user_id', '=', 'pmu.id')
                //     ->leftJoin('users as u', 'u.id', '=', 'projects.createdBy')
                //     ->select('projects.*',  'u.name as owner')
                //     ->get();
                foreach ($projects as $k => $p) {
                    $projects[$k]['members'] = DB::select(DB::raw('select * from project_members where project_id=' . $p->id));
                }
                $data['projects'] = $projects;
            }
            return view($this->_routePrefix . '.projects',$data);
        } else {
            return redirect('/');
        }
    }


    public function createProject()
    {
        return view($this->_routePrefix . '.project-create-form');
        //return View('taskmanagement/projects/project-create-form');
    }

    public function create(Request $request)
    {
        //dd($request->all());
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
                //  die;
                $validatedData['created_at'] = date('Y-m-d h:i:s');
                $validatedData['createdBy'] = $currentUser;
                $validatedData['status'] = 'open';
                $validatedData['emid'] = $Roledata->reg;
                //dd($validatedData);
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
                return redirect('org-task-management/projects');
            }
            // return response()->json($project, 201);
        } else {
            session()->flash('error', 'Permission denied');
            return redirect('org-task-management/projects');
            // return response()->json(['message' => 'Unauthorized access'], 401);
        }
    }

    public function updateProject(Request $request)
    {
        $statusOption = [
            'open' => 'Open',
            'hold' => 'Hold',
            'close' => 'Close'
        ];
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $project = Project::where('id', decrypt($request->id))->first();
            //dd($project);
            return view($this->_routePrefix . '.project-update-form',['project' => $project, 'statusOptions' => $statusOption]);
            //return View('taskmanagement/projects/project-update-form', ['project' => $project, 'statusOptions' => $statusOption]);
        } else {
            return redirect('/');
        }
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
        $project_id = decrypt($request->get('id'));
        $project = Project::find($project_id);
        if (!$project) {
            Session::flash('error', 'Project does not exist in the system');
            return redirect('org-task-management/projects');
            //return redirect('/task-management/update-project/' . $request->get('id'));
        }

        Project::where('id', $project_id)->update($validatedData);
        Session::flash('message', 'Project has been updated successfully');
        return redirect('org-task-management/projects');
        //return redirect('/task-management/update-project/' . $request->get('id'));
    }


    public function destroy($id)
    {
        $project = Project::find(decrypt($id));
        if (!$project) {
            Session::flash('error', 'Project  not found');
            return redirect('org-task-management/projects');
            //return redirect('/task-management/projects');
        }
        $project->delete();
        Session::flash('message', 'Project  has been deleted successfully');
        return redirect('org-task-management/projects');
        //return redirect('/task-management/projects');
    }









} //End Class
