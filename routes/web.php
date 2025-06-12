<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth/register');
});

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/task-assignment', function (){
    return view('task/taskassignment');
})->middleware('auth');

Route::get('/calendar', function (){
    return view('task/calendar');
})->middleware('auth');

Route::get('/upcoming-task', function (){
    return view('task/upcomingtask');
})->middleware('auth');
