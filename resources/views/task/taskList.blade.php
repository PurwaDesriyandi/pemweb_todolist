@extends('layouts.app')

@push('styles')
@endpush

@section('content')

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Todays' Tasks
                </div>
            </div>
            <div class="card-body">
                <div class="filter-container">
                    <div class="filters">
                        <button class="filter-btn active" data-filter="all"> All </button>
                        {{-- <button class="filter-btn" data-filter="running"> Running </button> --}}
                        <button class="filter-btn" data-filter="completed" id="filter-completed"> Completed </button>
                    </div>
                    <button class="btn btn-primary" onclick="openAddModal()">Add Task</button>
                </div>
                <ul class="task-list" id="task-list">
                    @foreach ($tasks as $task)
                        <li class="task-item" data-status="{{ $task->status }}">
                            <input type="checkbox" class="task-checkbox" data-id="{{ $task->id }}" {{ $task->status === 'Selesai' ? 'checked' : '' }}>
                            <div class="task-content">
                                <div class="task-title">
                                    {{ $task->title }}
                                </div>
                                <div class="task-deadline">
                                    Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                                </div>
                                <div class="task-description">
                                    {{ $task->description }}
                                </div>
                            </div>
                            <div class="task-action">
                                <form action="{{ route('task.update', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-edit" onclick="openEditModal({{ $task }})">Edit</button>
                                </form>
                                <form action="{{ route('task.destroy', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="progress-section">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                        <span style="font-size: 0.85rem;">Daily Progress</span>
                        <span id="progress-text" style="font-size: 0.85rem;">0%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add -->
    <div id="addTaskModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">                  
                <h3 class="modal-title">Add Task</h3>
            </div>
            <form id="addTaskForm" action="{{ route('task.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-input"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" name="deadline" id="deadline" class="form-input" required>
                    </div>
                </div>
                <div class="modal-footer">   
                    <button type="submit" class="modal-btn btn-save">Save</button>
                    <button type="button" onclick="closeModal('addTaskModal')" class="modal-btn btn-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- edit -->
    <div id="editTaskModal" class="modal">
        <div class="modal-content">
            <form id="editTaskForm" method="POST" action="{{ route('task.update', ['id' => $task->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h3 class="modal-title">Edit Task</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" name="title" id="editTitle" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-input"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editDeadline" class="form-label">Deadline</label>
                         <input type="date" name="deadline" id="editDeadline" class="form-input" required>
                    </div>
                </div>
                <div class="modal-footer">   
                    <button type="submit" class="modal-btn btn-save" >Save</button>
                    <button type="button" class="modal-btn btn-cancel" onclick="closeModal('editTaskModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('addTaskModal').style.display = 'block';
        }
        function openEditModal(task) {
            const form = document.getElementById('editTaskForm');
            form.action = `/task-assignment/${task.id}`;
            document.getElementById('editTitle').value = task.title;
            document.getElementById('editDescription').value = task.description;
            document.getElementById('editDeadline').value = task.deadline;
            document.getElementById('editTaskModal').style.display = 'block';
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
    

        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.task-checkbox');
            const progressText = document.getElementById('progress-text');
            const progressFill = document.getElementById('progress-fill');
            const taskList = document.getElementById('task-list');
            const completedTasks = document.getElementById('completed-tasks');

            function updateProgress() {
                const totalTasks = checkboxes.length;
                const completedTasksCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
                const progress = totalTasks > 0 ? (completedTasksCount / totalTasks) * 100 : 0;

                progressText.textContent = `${Math.round(progress)}%`;
                progressFill.style.width = `${progress}%`;
            }

            function moveTask(checkbox) {
                const taskItem = checkbox.closest('.task-item');
                if (checkbox.checked) {
                    completedTasks.appendChild(taskItem);
                } else {
                    taskList.appendChild(taskItem);
                }
            }

            if (checkboxes.length > 0) {
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        const taskId = checkbox.getAttribute('data-id');
                        const status = checkbox.checked ? 'Selesai' : 'Belum Selesai';

                        if (taskId) {
                            fetch(`/task/update-status/${taskId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ status })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to update task status');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Task status updated:', data);
                                moveTask(checkbox);
                                updateProgress();
                            })
                            .catch(error => {
                                console.error('Error updating task status:', error);
                            });
                        }
                    });
                });
            }

            updateProgress();
        });
    </script>
@endsection