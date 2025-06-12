@extends('dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Today's Tasks</div>
            <div class="card-stats">3 tasks remaining</div>
        </div>

        <div class="filters">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Active</button>
            <button class="filter-btn">Completed</button>
        </div>

        <div class="task-input">
            <input type="text" placeholder="Add a new task...">
            <button>Add</button>
        </div>

        <ul class="task-list">
            <li class="task-item">
                <div class="priority-indicator priority-high"></div>
                <input type="checkbox" class="task-checkbox">
                <span class="task-text">Complete project proposal</span>
                <div class="task-actions">
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Delete</button>
                </div>
            </li>
            <li class="task-item">
