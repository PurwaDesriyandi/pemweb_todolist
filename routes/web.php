<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

Route::get('/task-list', function(){
    return view('task.taskList');
});

Route::get('/calendar', function () {
    return view('task.calendar');
});

Route::get('/upcoming-task', function () {
    return view('task.upcomingtask');
});

Route::get('/task-list', [TaskController::class, 'index'])->name('task.assignment');
Route::post('/task-list', [TaskController::class, 'store'])->name('task.store');
Route::put('/task-list/{id}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/task-list/{id}', [TaskController::class, 'destroy'])->name('task.destroy');


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
