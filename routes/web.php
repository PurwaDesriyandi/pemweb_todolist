<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/task-list', [TaskController::class, 'index'])->name('task.assignment');
    Route::post('/task-list', [TaskController::class, 'store'])->name('task.store');
    Route::put('/task-assignment/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task-list/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');
    Route::get('/calendar', [TaskController::class, 'showCalendar'])->name('task.calendar');
    Route::get('/api/active-tasks', [TaskController::class, 'activeTasks']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['role:admin,'])->group(function () {
    Route::get('/role', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });
});


