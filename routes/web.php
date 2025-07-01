<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
});
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/task-list', [TaskController::class, 'index'])->name('task.assignment');
    Route::post('/task-list', [TaskController::class, 'store'])->name('task.store');
    Route::put('/task-assignment/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task-list/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');
    Route::get('/calendar', [TaskController::class, 'showCalendar'])->name('task.calendar');
    // Route::get('/upcoming-task', [TaskController::class, 'upcomingTasks'])->name('upcoming.tasks');

    // Route::get('/task-assignment', [TaskController::class, 'index'])->name('task.assignment');

    // Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    // Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    // Route::match(['put', 'patch'], '/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    // Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Route::put('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');

    // Route::get('/calendar', [TaskController::class, 'calendar'])->name('task.calendar');
    // Route::get('/api/active-tasks', [TaskController::class, 'activeTasks']);

    Route::get('/role', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Route::get('/task-assignment', function (){
    //     return view('task.taskassignment');
    // });
    // Route::get('/upcoming-task', function (){
    //     return view('task.upcomingtask');
    // });
    // Route::get('/calendar', function (){
    //     return view('task.calendar');
    // });



    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
