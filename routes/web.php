<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

// nambah route dewe mergo gaiso login

Route::get('/task-list', [TaskController::class, 'index'])->name('task.assignment');
Route::post('/task-list', [TaskController::class, 'store'])->name('task.store');
Route::put('/task-assignment/{id}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/task-list/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');
Route::get('/calendar', [TaskController::class, 'showCalendar'])->name('task.calendar');
Route::get('/upcoming-task', [TaskController::class, 'upcomingTasks'])->name('upcoming.tasks');

// batas route ku


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
});
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    // Route::get('/task-assignment', function (){
    //     return view('task.taskassignment');
    // });

    // Route::get('/calendar', function (){
    //     return view('task.calendar');
    // });

    // Route::get('/upcoming-task', function (){
    //     return view('task.upcomingtask');
    // });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
