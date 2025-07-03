@extends('layouts.app')

@section('title', "Today's Tasks")

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
<div class="container mx-auto p-4">
    @if(session('success'))
        <div class="alert alert-success mt-4 shadow-lg">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-error mt-4 shadow-lg">
            <ul class="list-disc ml-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card bg-base-100 shadow-xl mt-4">
        <div class="card-body">
            <h2 class="card-title">Today's Tasks</h2>
            <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                <div class="join">
                    <button class="btn join-item btn-active" data-filter="all">All</button>
                    <button class="btn join-item" id="completed-btn" data-filter="completed">Completed</button>
                </div>
                <button class="btn btn-primary" onclick="openAddModal()" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Task
                </button>
            </div>
            <ul class="space-y-4" id="task-list">
                @foreach($tasks as $task)
                <li class="task-item card card-compact bg-base-100 shadow {{ $task->status == 'Selesai' ? 'completed' : ($task->status == 'Sedang Dikerjakan' ? 'in-progress' : '') }}" data-status="{{ $task->status }}">
                    <div class="card-body">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <div class="relative">
                                <div class="dropdown">
                                    <label tabindex="0" class="btn btn-sm min-w-[160px] flex justify-between items-center status-btn">
                                        <span class="status-label">{{ $task->status }}</span>
                                        <i class="bi bi-chevron-down ml-2"></i>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content z-[10] menu p-2 shadow bg-base-100 rounded-box w-52 mt-1 flex flex-row gap-2">
                                        <li><a href="#" class="status-option flex items-center gap-1" data-id="{{ $task->id }}" data-status="Belum Dikerjakan"><span class="badge badge-neutral">Not Started</span></a></li>
                                        <li><a href="#" class="status-option flex items-center gap-1" data-id="{{ $task->id }}" data-status="Sedang Dikerjakan"><span class="badge badge-warning">In Progress</span></a></li>
                                        <li><a href="#" class="status-option flex items-center gap-1" data-id="{{ $task->id }}" data-status="Selesai"><span class="badge badge-success">Completed</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <span class="badge status-badge {{ $task->status == 'Selesai' ? 'badge-success' : ($task->status == 'Sedang Dikerjakan' ? 'badge-warning' : 'badge-neutral') }}">
                                {{ $task->status == 'Selesai' ? 'Completed' : ($task->status == 'Sedang Dikerjakan' ? 'In Progress' : 'Not Started') }}
                            </span>
                        </div>
                        <h3 class="card-title">{{ $task->title }}</h3>
                        <p class="text-gray-600">{{ $task->description }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <div class="text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Deadline: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : '-' }}
                            </div>
                            <div class="flex gap-2">
                                <button class="btn btn-sm btn-outline" onclick="openEditModal({{ $task->id }})">Edit</button>
                                <form action="{{ route('task.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="mt-8">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium">Daily Progress</span>
                    <span class="text-sm font-medium" id="progress-text">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-primary h-2.5 rounded-full" id="progress-fill" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div id="addTaskModal" class="modal">
    <div class="modal-box">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">Add Task</h3>
            <button class="btn btn-sm btn-circle btn-ghost" onclick="closeModal('addTaskModal')">✕</button>
        </div>

            <form class="space-y-4" method="POST" action="{{ route('task.store') }}">
                @csrf
                <div class="form-control">
                    <label class="label">

                        <span class="label-text">Title</span>
                    </label>
                    <input type="text" name="title" class="input input-bordered w-full" required value="{{ old('title') }}" placeholder="Task title">
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Description</span>
                    </label>
                    <textarea name="description" class="textarea textarea-bordered w-full h-32" placeholder="Task description">{{ old('description') }}</textarea>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Deadline</span>
                    </label>
                    <input type="date" name="deadline" class="input input-bordered w-full" required value="{{ old('deadline') }}">
                </div>
                <div class="modal-action flex justify-end gap-2 mt-6">
                    <button type="button" class="btn" onclick="closeModal('addTaskModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal - Diperbaiki -->
<div id="editTaskModal" class="modal">
    <div class="modal-box relative w-11/12 max-w-3xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg">Edit Task</h3>
            <button class="btn btn-sm btn-circle btn-ghost" onclick="closeModal('editTaskModal')">✕</button>
        </div>

            <form class="mt-4" id="editTaskForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Title</span>
                    </label>
                    <input type="text" name="title" id="edit-title" class="input input-bordered w-full" required>
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Description</span>
                    </label>
                    <textarea name="description" id="edit-description" class="textarea textarea-bordered w-full h-32"></textarea>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Deadline</span>
                    </label>
                    <input type="date" name="deadline" id="edit-deadline" class="input input-bordered w-full" required>
                </div>
                <div class="modal-action flex justify-end gap-2 mt-6">
                    <button type="button" class="btn" onclick="closeModal('editTaskModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Success message
    function showSuccess(message) {
        document.getElementById('success-text').textContent = message;
        document.getElementById('success-message').style.display = 'block';
        setTimeout(() => {
            document.getElementById('success-message').style.display = 'none';
        }, 3000);
    }
        // Function to disable body scroll
    function disableBodyScroll() {
        document.body.classList.add('modal-open');
    }

    // Function to enable body scroll
    function enableBodyScroll() {
        document.body.classList.remove('modal-open');
    }
    // Modal functions
    function openAddModal() {
        const modal = document.getElementById('addTaskModal');
        if (modal) {
            disableBodyScroll(); // Disable body scroll
            modal.classList.remove('hidden');
            modal.classList.add('modal-open');
        }
    }
    function openEditModal(id) {
        console.log('Opening edit modal with ID:', id);
        fetch(`/tasks/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Task data received:', data);

            // Populate form fields
            document.getElementById('edit-title').value = data.title || '';
            document.getElementById('edit-description').value = data.description || '';
            document.getElementById('edit-deadline').value = data.deadline || '';

            // Set form action
            document.getElementById('editTaskForm').action = `/tasks/${id}`;

            // Show modal
            const modal = document.getElementById('editTaskModal');
            if (modal) {
                disableBodyScroll(); // Disable body scroll
                modal.classList.remove('hidden');
                modal.classList.add('modal-open');
                console.log('Edit modal opened successfully');
            }
        })
        .catch(error => {
            console.error('Error fetching task data:', error);
            alert('Error loading task data. Please try again.');
        });
    }
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
        enableBodyScroll(); // Enable body scroll
        modal.classList.add('hidden');
        modal.classList.remove('modal-open');
    }
    document.addEventListener('DOMContentLoaded', function() {
        enableBodyScroll();
    });
    }
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
        const addModal = document.getElementById('addTaskModal');
        const editModal = document.getElementById('editTaskModal');

        if (addModal && addModal.classList.contains('modal-open')) {
            closeModal('addTaskModal');
        }
        if (editModal && editModal.classList.contains('modal-open')) {
            closeModal('editTaskModal');
        }
    }
    });
    // Filter functionality
    document.querySelectorAll('[data-filter]').forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            const tasks = document.querySelectorAll('.task-item');
            document.querySelectorAll('[data-filter]').forEach(btn => {
                btn.classList.remove('btn-active');
            });
            this.classList.add('btn-active');
            tasks.forEach(task => {
                if (filter === 'all') {
                    task.style.display = 'block';
                } else if (filter === 'completed') {
                    if (task.getAttribute('data-status') === 'Selesai') {
                        task.style.display = 'block';
                    } else {
                        task.style.display = 'none';
                    }
                }
            });
        });
    });
    // Status change for custom dropdown
    document.querySelectorAll('.task-item').forEach(function(taskItem) {
        const statusBtn = taskItem.querySelector('.status-btn');
        const statusLabel = taskItem.querySelector('.status-label');
        const statusBadge = taskItem.querySelector('.status-badge');
        const statusOptions = taskItem.querySelectorAll('.status-option');
        const dropdown = taskItem.querySelector('.dropdown');
        if (!statusBtn || !statusLabel || !statusBadge || !statusOptions) return;
        statusOptions.forEach(function(option) {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const newStatus = this.getAttribute('data-status');
                const taskId = this.getAttribute('data-id');
                statusLabel.textContent = newStatus;
                statusBadge.className = 'badge status-badge';
                if (newStatus === 'Selesai') {
                    statusBadge.textContent = 'Completed';
                    statusBadge.classList.add('badge-success');
                    taskItem.classList.add('completed');
                    taskItem.classList.remove('in-progress');
                    taskItem.setAttribute('data-status', 'Selesai');
                } else if (newStatus === 'Sedang Dikerjakan') {
                    statusBadge.textContent = 'In Progress';
                    statusBadge.classList.add('badge-warning');
                    taskItem.classList.add('in-progress');
                    taskItem.classList.remove('completed');
                    taskItem.setAttribute('data-status', 'Sedang Dikerjakan');
                } else {
                    statusBadge.textContent = 'Not Started';
                    statusBadge.classList.add('badge-neutral');
                    taskItem.classList.remove('completed', 'in-progress');
                    taskItem.setAttribute('data-status', 'Belum Dikerjakan');
                }
                updateProgress();
                fetch(`/tasks/${taskId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    showSuccess(data.message);
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                });
                if (dropdown) {
                    dropdown.classList.remove('dropdown-open');
                    statusBtn.blur();
                }
            });
        });
    });
    // Update progress bar
    function updateProgress() {
        const totalTasks = document.querySelectorAll('.task-item').length;
        const completedTasks = document.querySelectorAll('.task-item.completed').length;
        const progress = totalTasks === 0 ? 0 : Math.round((completedTasks / totalTasks) * 100);
        document.getElementById('progress-fill').style.width = `${progress}%`;
        document.getElementById('progress-text').textContent = `${progress}%`;
    }
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
    });
</script>
@endpush
