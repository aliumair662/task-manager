<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;


class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $projectId = $request->get('project_id', $projects->first()?->id);
        $tasks = Task::where('project_id', $projectId)->orderBy('priority')->get();

        return view('tasks', compact('projects', 'projectId', 'tasks'));
    }

     public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $data['priority'] = Task::where('project_id', $data['project_id'])->max('priority') + 1;
        Task::create($data);

       return redirect('/')->with('success', 'Task added successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task->update($data);
        return redirect('/')->with('success', 'Task updated successfully.');;
    }

    public function destroy(Task $task)
    {
        $task->delete();
       return redirect('/')->with('success', 'Task deleted successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }

        return response()->json(['status' => 'success']);
    }
}
