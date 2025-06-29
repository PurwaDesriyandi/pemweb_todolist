<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class TaskController extends Controller
{
   public function index()
    {
        $tasks = task::all(); // Mengambil semua tugas dari database
        return view('task.taskassignment', compact('tasks')); // Mengirim data ke view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'deadline' => 'required|date',
            'description' => 'nullable',
        ]);

        $task = task::create($validatedData); // Membuat task baru

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully!',
            'task' => $task // Kirim kembali objek task yang baru dibuat
        ], 201); // 201 Created
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422); // Unprocessable Entity
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ], 500); // Internal Server Error
    }
}
public function update(Request $request, task $task) // Menggunakan Route Model Binding
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|max:255',
                'deadline' => 'required|date',
                'description' => 'nullable',
                'status' => 'in:Belum Dikerjakan,Sedang Dikerjakan,Selesai' // Tambahkan validasi untuk status
            ]);

            $task->update($validatedData); // Update task di database

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!',
                'task' => $task // Kirim kembali objek task yang diperbarui
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(task $task) // Menggunakan Route Model Binding
    {
        try {
            $task->delete(); // Hapus task dari database

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    // Anda juga bisa menambahkan metode untuk mengubah status task secara langsung
    public function toggleStatus(Request $request, task $task)
    {
        try {
            $task->status = $request->input('status'); // Ambil status dari request
            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Task status updated!',
                'task' => $task
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function calendar()
    {
        $tasks = task::all();
        return view('task.calendar', compact('tasks'));
    }

    // New method to get active tasks with deadlines as JSON
    public function activeTasks()
    {
        $tasks = task::where('status', '!=', 'Selesai')
            ->whereNotNull('deadline')
            ->get(['id', 'title', 'deadline', 'description']);

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }
}
