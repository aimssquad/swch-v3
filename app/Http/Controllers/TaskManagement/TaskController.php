<?php

namespace App\Http\Controllers\TaskManagement;

use App\Http\Controllers\Controller;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectMembers;
use App\Models\TaskManagement\MasterLabels;
use Illuminate\Http\Request;
use App\Models\TaskManagement\Task;
use App\Models\User;
use DB;
use Session;


class TaskController extends Controller
{
    public function dashboard(Request $request)
    {
        $project_id = decrypt($request->id);

        // dd(Session::all());
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $currentUserType = Session::get('user_type');
            $project = Project::where('id', $project_id)->first();
            $data = [];
            $projectMembers = ProjectMembers::where('project_id', $project_id)
                ->leftJoin('employee', 'employee.id', '=', 'project_members.user_id')
                ->select('project_members.*', 'employee.emp_fname as fname', 'employee.emp_mname as mname', 'employee.emp_lname as lname')
                ->get();
            // print_r($projectMembers);
            // die;
            $data['members'] = $projectMembers;

            $labels = MasterLabels::where('project_id', $project_id)->get();
            $data['labels'] = $labels;
            if ($currentUser === $project->createdBy || $currentUserType === 'employer') {
                $tasks = Task::select('tasks.*', 'e.emp_fname as fname', 'e.emp_mname as mname', 'e.emp_lname as lname')
                    ->where('project_id', $project_id)
                    ->leftJoin('employee as e', 'e.id', '=', 'tasks.assignedTo')
                    ->get();
                $data['tasks'] = $tasks;
            } else {
                $currentUserEmpDetails = User::select('users.*', 'e.id as emp_id')
                    ->leftJoin('employee as e', 'e.emp_code', '=', 'users.employee_id')
                    ->where('users.id', $currentUser)
                    ->first();
                $projectMember = ProjectMembers::where(['project_id' => $project_id, 'user_id' => $currentUserEmpDetails->emp_id])->first();
                if ($projectMember->role === 'manager') {
                    $tasks = Task::select('tasks.*', 'e.emp_fname as fname', 'e.emp_mname as mname', 'e.emp_lname as lname')
                        ->where('project_id', $project_id)
                        ->leftJoin('employee as e', 'e.id', '=', 'tasks.assignedTo')

                        ->get();
                    $data['tasks'] = $tasks;
                } else {

                    $tasks = Task::select('tasks.*', 'e.emp_fname as fname', 'e.emp_mname as mname', 'e.emp_lname as lname')
                        ->where(['project_id' => $project_id, 'assignedTo' => $currentUserEmpDetails->emp_id])
                        ->leftJoin('employee as e', 'e.id', '=', 'tasks.assignedTo')
                        ->get();
                    $data['tasks'] = $tasks;
                }
            }
            return View('taskmanagement/tasks/tasks', $data);
        } else {
            return redirect("/");
        }
    }
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }
    public function test(Request $request)
    {

        $params = DB::table('projects')->toSql();
        print_r($request->all());
        echo 'ok';
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

        $task = Task::select('*')
            // ->where('assignedTo', $request->input('uid'))
            ->offset($skip)
            ->limit((int) $limit)
            ->get();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    public function create(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $validatedData = $request->validate([
                'project_id' => 'required',
                'task_name' => 'required',
                'task_desc' => 'required',
                // 'tags' => 'required',
                // 'assignedTo' => 'required',
                // 'start_date' => 'required',
                // 'expected_end_date' => 'required',
                // 'createdBy' => 'required',
                // 'priority' => 'required',
                // 'status' => 'required'
            ]);
            $data = $request->all();
            $data['createdBy'] = $currentUser;
            // print_r($data);
            // die;
            $task = Task::create($data);
            return response()->json($task, 201);
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized access']);
        }
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required',
            'task_name' => 'required',
            'task_desc' => 'required',
            // 'tags' => 'required',
            'assignedTo' => 'required',
            // 'start_date' => 'required',
            // 'expected_end_date' => 'required',
            // 'createdBy' => 'required',
            // 'priority' => 'required',
        ]);


        $task = Task::find($request->get('task_id'));
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->update($validatedData);
        return response()->json($task);
    }
    public function updateStatus(Request $request)
    {

        $validatedData = $request->validate([
            'task_id' => 'required',
            'status' => 'required'
        ]);

        $task = Task::find($validatedData['task_id']);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->update($validatedData);
        return response()->json($task);
    }
    public function getTaskById($id)
    {
        $task = Task::where('tasks.id', $id)
            ->leftJoin('employee as e', 'e.id', '=', 'tasks.assignedTo')
            ->leftJoin('users as u', 'u.employee_id', '=', 'e.emp_code')
            ->leftJoin('projects as p', 'p.id', '=', 'tasks.project_id')
            ->select('tasks.*', 'u.name as assignedUsername', 'p.title as project_name')
            ->first();
        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
