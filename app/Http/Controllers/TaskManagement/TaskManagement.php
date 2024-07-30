<?php

namespace App\Http\Controllers\TaskManagement;

use App\Http\Controllers\Controller;
use App\Models\TaskManagement\MasterLabels;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\Task;
use App\Models\User;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskManagement extends Controller
{
    protected $projectModel;
    public function __construct()
    {
        $this->projectModel = new Project;
    }
    public function index()
    {
        if (!empty(Session::get('user_type'))) {
            $currentUserType = Session::get('user_type');

            $currentUser = Session::get('users_id');


            $data = [];
             //dd($currentUserType);
            if ($currentUserType === 'employer') {
                $projects = Project::select('projects.*',  'u.name as owner')
                    ->leftJoin('users as u', 'u.id', '=', 'projects.createdBy')
                    ->where('u.id','=',$currentUser)
                    ->get();
                    //dd($projects);
                foreach ($projects as $k => $p) {
                    // echo $p->id;

                    $labels = MasterLabels::where('project_id', $p->id)->get();
                    if (count($labels) > 0) {
                        $tempLeb = [];
                        foreach ($labels as $kk => $l) {
                            $openCount = Task::where(['project_id' => $p->id, 'status' => $l->title])->count();
                            // $tempProjects[$k]['labels'][$kk] = [
                            //     'title' => $l->title,
                            //     'count' => $openCount
                            // ];

                            // print_r($openCount);
                            array_push($tempLeb, [
                                'title' => $l->title,
                                'count' => $openCount
                            ]);
                        }
                        // $tempPro = array_merge((array)$p, ['labels' => $tempLeb]);
                        // array_push($tempProjects, $tempPro);
                        $p->setAttribute('labels', (object)$tempLeb);
                    } else {
                        // $temp = [];
                        // $tempProjects[$k]['labels'] = [];
                        $p->setAttribute('labels', (object)[]);
                    }
                }
                $data['projects'] =  $projects;
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
                $tempProjects = (array)$projects;
                foreach ($projects as $k => $p) {
                    // echo $p->id;

                    $labels = MasterLabels::where('project_id', $p->id)->get();
                    if (count($labels) > 0) {
                        $tempLeb = [];
                        foreach ($labels as $kk => $l) {
                            $openCount = Task::where(['project_id' => $p->id, 'status' => $l->title])->count();
                            // $tempProjects[$k]['labels'][$kk] = [
                            //     'title' => $l->title,
                            //     'count' => $openCount
                            // ];

                            // print_r($openCount);
                            array_push($tempLeb, [
                                'title' => $l->title,
                                'count' => $openCount
                            ]);
                        }
                        // $tempPro = array_merge((array)$p, ['labels' => $tempLeb]);
                        // array_push($tempProjects, $tempPro);
                        $p->setAttribute('labels', (object)$tempLeb);
                    } else {
                        // $temp = [];
                        // $tempProjects[$k]['labels'] = [];
                        $p->setAttribute('labels', (object)[]);
                    }
                }
                $data['projects'] =  $projects;
            }
            // print_r($data);
            // die;
            return View('taskmanagement/dashboard', $data);
        } else {
            return redirect('/');
        }
    }
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
            return View('taskmanagement/projects/projects', $data);
        } else {
            return redirect('/');
        }
    }
    public function createProject()
    {
        return View('taskmanagement/projects/project-create-form');
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
            return View('taskmanagement/projects/project-update-form', ['project' => $project, 'statusOptions' => $statusOption]);
        } else {
            return redirect('/');
        }
    }
    public function createTask()
    {
        return View('taskmanagement/task-create-form');
    }
    public function tasks()
    {
        return View('taskmanagement/tasks');
    }
    //


}
