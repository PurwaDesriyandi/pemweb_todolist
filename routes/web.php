<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('auth/login');
});
Route::get('/register', function () {
    return view('auth/register');
});
Route::get('/logout', function () {
    return view('auth/logout');
});
Route::get('/taskassignment', function (){
    return view('task/taskassignment');
});
Route::get('/calendar', function (){
    return view('task/calendar');
});
Route::get('/upcomingtask', function (){
    return view('task/upcomingtask');
});
