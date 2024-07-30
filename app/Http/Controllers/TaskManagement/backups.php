<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TaskComments;

class TaskCommentsControllerb extends Controller
{
    public function index()
    {
        $taskComments = TaskComments::all();
        return view('TaskComments.index', compact('TaskComments'));
    }

    public function create()    
    {
        return view('TaskComments.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'required',
            'comment_details' => 'required',
            'task_desc' => 'required',
            'createdBy' => 'required',
        ]);
        $data = [
            'status' => 'active'
        ];
        $mergedArray = array_merge($validatedData, $data);
        $taskComment = TaskComments::create($mergedArray);
        return redirect()->route('TaskComments.index')
            ->with('success', 'Project created successfully.');
    }

    public function show($id)
    {
        $taskComment = TaskComments::find($id);
        return view('TaskComments.show', compact('TaskComments'));
    }

    public function edit($id)
    {
        $taskComment = TaskComments::find($id);
        return view('TaskComments.edit', compact('TaskComments'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $taskComment = TaskComments::find($id);
        $taskComment->update($validatedData);
        return redirect()->route('TaskComments.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $taskComment = TaskComments::find($id);
        $taskComment->delete();
        return redirect()->route('TaskComments.index')
            ->with('success', 'Project deleted successfully.');
    }
}
?>



<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TaskNew;

class TaskControllerNewb extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function create()
    {
        return view('taskNew.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required',
            'task_name' => 'required',
            'task_desc' => 'required',
            'tags' => 'required',
            'assignedTo' => 'required',
            'start_date' => 'required',  
            'expected_end_date' => 'required',
            'createdBy' => 'required',
            'priority' => 'required',
        ]);
        $data = [
            'status' => 'active'
        ];
        $mergedArray = array_merge($validatedData, $data);
        $project = TaskNew::create($mergedArray);
        return redirect()->route('taskNew.index')
            ->with('success', 'Project created successfully.');
    }

    public function show($id)
    {
        $project = TaskNew::find($id);
        return view('taskNew.show', compact('project'));
    }

    public function edit($id)
    {
        $project = TaskNew::find($id);
        return view('taskNew.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $project = TaskNew::find($id);
        $project->update($validatedData);

        return redirect()->route('taskNew.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = TaskNew::find($id);
        $project->delete();

        return redirect()->route('taskNew.index')
            ->with('success', 'Project deleted successfully.');
    }
}
?>

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectControllerb extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'createdBy' => 'required',
        ]);
        $data = [
            'status' => 'active'
        ];
        $mergedArray = array_merge($validatedData, $data);
        $project = Project::create($mergedArray);
        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show($id)
    {
        $project = Project::find($id);
        return view('projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $project = Project::find($id);
        $project->update($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
