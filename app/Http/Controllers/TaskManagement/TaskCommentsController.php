<?php

// namespace App\Http\Controllers\API;

namespace App\Http\Controllers\TaskManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\Task;
use App\Models\TaskManagement\TaskComment;
use Session;

class TaskCommentsController extends Controller
{
    public function index()
    {
        $taskComments = TaskComment::all();
        return response()->json($taskComments);
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

        $taskComment = TaskComment::select('tasks_comments.*', 'u.name as username')
            ->where('tasks_comments.task_id', $request->input('tid'))
            // ->leftJoin('employee as e', 'e.id', '=', 'tasks_comments.createdBy')
            ->leftJoin('users as u', 'u.id', '=', 'tasks_comments.createdBy')
            ->offset($skip)
            ->limit((int) $limit)
            ->orderBy('tasks_comments.created_at', 'desc')
            ->get();

        if (!$taskComment) {
            return response()->json(['message' => 'Task comment not found'], 404);
        }

        return response()->json($taskComment);
    }

    public function create(Request $request)
    {
        // $project_id = $request->id;
        // $task_id = $request->task_id;

        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $validatedData = $request->validate([
                'comment_details' => 'required',
                'task_id' => 'required',

            ]);

            $data = [
                'status' => 'active',
                // 'task_id' => $task_id,
                'createdBy' => $currentUser,
                'createdAt' => date('Y-m-d h:i:s')
            ];

            $mergedArray = array_merge($validatedData, $data);
            $taskComment = TaskComment::create($mergedArray);
            return response()->json($taskComment, 201);
        } else {
            return response()->json("Permission denied", 403);
            // Session::flash('error', 'Unauthorized access');
            // return redirect('/task-management/' . $project_id . '/project-members');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'task_id' => 'required',
            'comment' => 'required',
        ]);
        $taskComment = TaskComment::find($id);
        if (!$taskComment) {
            return response()->json(['message' => 'Task comment not found'], 404);
        }
        $taskComment->update($validatedData);
        return response()->json($taskComment);
    }

    public function destroy($id)
    {
        $taskComment = TaskComment::find($id);
        if (!$taskComment) {
            return response()->json(['message' => 'Task comment not found'], 404);
        }
        $taskComment->delete();
        return response()->json(['message' => 'Task comment deleted successfully']);
    }
}
