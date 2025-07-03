<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // show all assignment
    public function index()
    {
        $tasks = Task::all();
        return view('task.taskList', compact('tasks'));
    }

    // add new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => 'Belum Dikerjakan', //default
        ]);

        return redirect()->route('task.assignment')->with('success', 'Task created successfully.');
    }

    // update task
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('task.assignment')->with('success', 'Task updated successfully.');
    }

    // delete task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('task.assignment')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, $id){
        $request->validate([
            'status' => 'required|in:Selesai,Belum Dikerjakan',
        ]);

        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->save();

        return response()->json(['message' => 'Task status updated successfully']);
    }

    public function showCalendar(){
        $tasks = Task::all();
        return view('task.calendar', compact('tasks'));
    }

    public function activeTasks()
    {
    $tasks = Task::all()->map(function($task) {
        return [
            'title' => $task->title,
            'description' => $task->description,
            'deadline' => $task->deadline, // pastikan format YYYY-MM-DD
            'status' => $task->status,
        ];
    });
    return response()->json([
        'success' => true,
        'tasks' => $tasks
    ]);
    }

}
