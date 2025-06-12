@extends('layouts.app')

@section('title', "Today's Tasks")

@push('styles')
<style>
    .task-item.completed .task-text {
        text-decoration: line-through;
        color: #6c757d;
    }
    .task-item .task-actions {
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }
    .task-item:hover .task-actions {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Today's Tasks</div>
            <div class="card-stats" id="task-stats">3 tasks remaining</div>
        </div>
        <div class="card-body">
            <div class="filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="active">Active</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
            </div>

            <div class="task-input">
                <input type="text" id="add-task-input" placeholder="Add a new task...">
                <button id="add-task-btn">Add</button>
            </div>

            <ul class="task-list" id="task-list">
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
                    <div class="priority-indicator priority-medium"></div>
                    <input type="checkbox" class="task-checkbox">
                    <span class="task-text">Team meeting at 2 PM</span>
                    <div class="task-actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                </li>
                <li class="task-item completed">
                    <div class="priority-indicator priority-low"></div>
                    <input type="checkbox" class="task-checkbox" checked>
                    <span class="task-text">Send weekly report</span>
                    <div class="task-actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                </li>
            </ul>

            <div class="progress-section">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                    <span style="font-size: 0.85rem;">Daily Progress</span>
                    <span id="progress-text" style="font-size: 0.85rem;">33%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill" style="width: 33%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const taskList = document.getElementById('task-list');
    const addTaskInput = document.getElementById('add-task-input');
    const addTaskBtn = document.getElementById('add-task-btn');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const taskStats = document.getElementById('task-stats');
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');

    function updateUI() {
        const allTasks = document.querySelectorAll('.task-item');
        const completedTasks = document.querySelectorAll('.task-item.completed');
        const remainingTasks = allTasks.length - completedTasks.length;

        taskStats.textContent = `${remainingTasks} tasks remaining`;

        const progressPercent = allTasks.length > 0 ? (completedTasks.length / allTasks.length) * 100 : 0;
        progressFill.style.width = `${progressPercent}%`;
        progressText.textContent = `${Math.round(progressPercent)}%`;
    }

    taskList.addEventListener('click', function(e) {
        const target = e.target;

        if (target.classList.contains('task-checkbox')) {
            target.closest('.task-item').classList.toggle('completed', target.checked);
        }

        if (target.classList.contains('btn-delete')) {
            if (confirm('Are you sure you want to delete this task?')) {
                target.closest('.task-item').remove();
            }
        }

        if (target.classList.contains('btn-edit')) {
            const taskItem = target.closest('.task-item');
            const taskTextElement = taskItem.querySelector('.task-text');
            const currentText = taskTextElement.textContent;
            const newText = prompt('Edit your task:', currentText);

            if (newText !== null && newText.trim() !== '') {
                taskTextElement.textContent = newText.trim();
            }
        }

        updateUI();
    });

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            const tasks = document.querySelectorAll('.task-item');

            tasks.forEach(task => {
                let show = true;
                if (filter === 'active' && task.classList.contains('completed')) {
                    show = false;
                } else if (filter === 'completed' && !task.classList.contains('completed')) {
                    show = false;
                }
                task.style.display = show ? 'flex' : 'none';
            });
        });
    });

    function addNewTask() {
        const text = addTaskInput.value.trim();
        if (text === '') return;

        const newTaskHTML = `
            <div class="priority-indicator priority-medium"></div>
            <input type="checkbox" class="task-checkbox">
            <span class="task-text">${text}</span>
            <div class="task-actions">
                <button class="btn-edit">Edit</button>
                <button class="btn-delete">Delete</button>
            </div>
        `;
        const li = document.createElement('li');
        li.className = 'task-item';
        li.innerHTML = newTaskHTML;

        taskList.prepend(li);
        addTaskInput.value = '';
        updateUI();
    }

    addTaskBtn.addEventListener('click', addNewTask);
    addTaskInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            addNewTask();
        }
    });

    updateUI();
});
</script>
@endpush
