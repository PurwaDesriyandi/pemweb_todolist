<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class DashboardController extends Controller
{
    /**
     * 
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $today = Carbon::today();

        $tasks = \App\Models\task::all();

        $totalTasks = $tasks->count();

        $completedCount = $tasks->where('status', 'Selesai')->count();

        $dueTodayCount = $tasks->filter(function ($task) use ($today) {
            return $task->deadline && $task->status !== 'Selesai' && \Carbon\Carbon::parse($task->deadline)->isSameDay($today);
        })->count();

        $overdueCount = $tasks->filter(function ($task) use ($today) {
            return $task->deadline && $task->status !== 'Selesai' && \Carbon\Carbon::parse($task->deadline)->isPast() && !$today->isSameDay($task->deadline);
        })->count();

        return view('dashboard', compact(
            'totalTasks',
            'completedCount',
            'dueTodayCount',
            'overdueCount'
        ));
    }
}
