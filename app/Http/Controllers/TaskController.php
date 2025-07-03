<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('task.taskList', compact('tasks'));
    }

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
            'status' => 'Belum Dikerjakan',
        ]);

        return redirect()->route('task.assignment')->with('success', 'Task created successfully.');
    }

        public function show($id)
{
    try {
        $task = Task::findOrFail($id);
        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'deadline' => $task->deadline,
            'status' => $task->status
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Task not found'], 404);
    }
}

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

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('task.assignment')->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, $id){
        $request->validate([
            'status' => 'required|in:Selesai,Belum Dikerjakan,Sedang Dikerjakan',
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
            'deadline' => $task->deadline,
            'status' => $task->status,
        ];
    });
    return response()->json([
        'success' => true,
        'tasks' => $tasks
    ]);
    }

}
