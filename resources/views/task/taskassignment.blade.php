@extends('layouts.app')

@section('title', "Today's Tasks")

@push('styles')
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Today's Tasks</div>
            <div class="card-stats" id="task-stats"> tasks remaining</div>
        </div>
        <div class="card-body">
            <!-- New container for filter and button -->
            <div class="filter-container">
                <div class="filters">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="active">Active</button>
                    <button class="filter-btn" data-filter="completed">Completed</button>
                </div>
                <button id="show-add-modal"> Add New Task</button>
            </div>

            <ul class="task-list" id="task-list">
                @forelse($tasks as $task)
                <li class="task-item @if($task->status === 'Selesai') completed @endif" data-id="{{ $task->id }}">
                    <input type="checkbox" class="task-checkbox" @if($task->status === 'Selesai') checked @endif>
                    <div class="task-content">
                        <div class="task-title">{{ $task->title }}</div>
                        <div class="task-deadline">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}</div>
                        <div class="task-description">{{ $task->description ?? 'No description' }}</div>
                    </div>
                    <div class="task-actions">
                        <button class="btn-edit" data-id="{{ $task->id }}">Edit</button>
                        <button class="btn-delete" data-id="{{ $task->id }}">Delete</button>
                    </div>
                </li>
                @empty
                <p>No tasks found for today.</p>
                @endforelse
            </ul>

            <div class="progress-section">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                    <span style="font-size: 0.85rem;">Daily Progress</span>
                    <span id="progress-text" style="font-size: 0.85rem;">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill" style="width: 33%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal-overlay" id="add-task-modal">
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        <div class="modal-header">
            <h3 class="modal-title">Add New Task</h3>
        </div>
        <div class="modal-body">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Judul Task</label>
                    <input type="text" class="form-input" name="title" id="task-title" placeholder="Masukkan judul task...">
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Deadline</label>
                    <input type="date" class="form-input" name="deadline" id="task-deadline">
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi Task</label>
                    <textarea class="form-input form-textarea" name="description" id="task-description" placeholder="Masukkan deskripsi task (opsional)..."></textarea>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn btn-cancel" data-dismiss="modal">Batal</button>
            <button type="submit" class="modal-btn btn-save" id="save-task">Simpan Task</button>
        </div>
        </form>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal-overlay" id="edit-task-modal">
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        <div class="modal-header">
            <h3 class="modal-title">Edit Task</h3>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Judul Task</label>
                <input type="text" class="form-input" id="edit-task-title">
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Deadline</label>
                <input type="date" class="form-input" id="edit-task-deadline">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Task</label>
                <textarea class="form-input form-textarea" id="edit-task-description"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-btn btn-cancel">Batal</button>
            <button class="modal-btn btn-save" id="update-task">Update Task</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay confirmation-modal" id="delete-confirm-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Hapus</h3>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus task ini?</p>
        </div>
        <div class="modal-footer">
            <button class="modal-btn btn-cancel" id="cancel-delete">Batal</button>
            <button class="modal-btn btn-danger" id="confirm-delete">Hapus</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskList = document.getElementById('task-list');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const taskStats = document.getElementById('task-stats');
        const progressFill = document.getElementById('progress-fill');
        const progressText = document.getElementById('progress-text');

        // Modal elements
        const addTaskModal = document.getElementById('add-task-modal');
        const editTaskModal = document.getElementById('edit-task-modal');
        const deleteConfirmModal = document.getElementById('delete-confirm-modal');
        const closeModalButtons = document.querySelectorAll('.close-modal, .btn-cancel');
        const saveTaskBtn = document.getElementById('save-task');
        const updateTaskBtn = document.getElementById('update-task');
        const showAddModalBtn = document.getElementById('show-add-modal');
        const confirmDeleteBtn = document.getElementById('confirm-delete');
        const cancelDeleteBtn = document.getElementById('cancel-delete');

        // Task form elements
        const taskTitle = document.getElementById('task-title');
        const taskDeadline = document.getElementById('task-deadline');
        const taskDescription = document.getElementById('task-description');

        // Edit form elements
        const editTaskTitle = document.getElementById('edit-task-title');
        const editTaskDeadline = document.getElementById('edit-task-deadline');
        const editTaskDescription = document.getElementById('edit-task-description');

        // Current task being edited/deleted
        let currentEditTask = null; // Ini akan menjadi elemen <li> task
        let taskToDelete = null; // Ini akan menjadi elemen <li> task

        // Set default date to today
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        taskDeadline.value = formattedDate;

        // Format date to DD/MM/YYYY
        function formatDate(dateString) {
            if (!dateString) return '';
            // Handle both YYYY-MM-DD (from input) and database date strings
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Modal functions
        function openModal(modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        function closeAllModals() {
            closeModal(addTaskModal);
            closeModal(editTaskModal);
            closeModal(deleteConfirmModal);
        }

        // Show add task modal
        showAddModalBtn.addEventListener('click', () => {
            // Reset form
            taskTitle.value = '';
            taskDeadline.value = formattedDate;
            taskDescription.value = '';
            openModal(addTaskModal);
        });

        // Show edit task modal and delete confirmation
        taskList.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-edit')) {
                const taskItem = e.target.closest('.task-item');
                currentEditTask = taskItem; // Simpan elemen <li> task

                // Get task data from DOM
                const taskTitleElement = taskItem.querySelector('.task-title');
                const taskDeadlineElement = taskItem.querySelector('.task-deadline');
                const taskDescriptionElement = taskItem.querySelector('.task-description');

                // Extract date from "Deadline: DD/MM/YYYY" text and convert to YYYY-MM-DD for input type="date"
                const deadlineText = taskDeadlineElement.textContent.replace('Deadline: ', '');
                const [day, month, year] = deadlineText.split('/');
                const formattedDeadlineForInput = `${year}-${month}-${day}`;

                // Populate form
                editTaskTitle.value = taskTitleElement.textContent;
                editTaskDeadline.value = formattedDeadlineForInput;
                editTaskDescription.value = taskDescriptionElement.textContent === 'No description' ? '' : taskDescriptionElement.textContent;

                openModal(editTaskModal);
            }

            if (e.target.classList.contains('btn-delete')) {
                taskToDelete = e.target.closest('.task-item'); // Simpan elemen <li> task
                openModal(deleteConfirmModal);
            }
        });

        // Close modals
        closeModalButtons.forEach(button => {
            button.addEventListener('click', closeAllModals);
        });

        cancelDeleteBtn.addEventListener('click', () => {
            closeModal(deleteConfirmModal);
        });

        // Add new task (dengan AJAX)
        saveTaskBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah submit form default

            const title = taskTitle.value.trim();
            const deadline = taskDeadline.value;
            const description = taskDescription.value.trim();

            if (!title) {
                alert('Judul task tidak boleh kosong');
                return;
            }

            fetch('{{ route('tasks.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        title,
                        deadline,
                        description
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const newTaskHTML = `
                            <li class="task-item" data-id="${data.task.id}">
                                <input type="checkbox" class="task-checkbox">
                                <div class="task-content">
                                    <div class="task-title">${data.task.title}</div>
                                    <div class="task-deadline">Deadline: ${formatDate(data.task.deadline)}</div>
                                    <div class="task-description">${data.task.description || 'No description'}</div>
                                </div>
                                <div class="task-actions">
                                    <button class="btn-edit" data-id="${data.task.id}">Edit</button>
                                    <button class="btn-delete" data-id="${data.task.id}">Delete</button>
                                </div>
                            </li>
                        `;
                        taskList.insertAdjacentHTML('afterbegin', newTaskHTML);
                        closeModal(addTaskModal);
                        updateUI();
                    } else {
                        alert('Gagal menyimpan task: ' + (data.message || 'Unknown error'));
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan task.');
                });
        });

        // Update task (dengan AJAX)
        updateTaskBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah submit form default

            if (!currentEditTask) return;

            const taskId = currentEditTask.dataset.id; // Ambil ID dari data-id pada elemen <li>
            const title = editTaskTitle.value.trim();
            const deadline = editTaskDeadline.value;
            const description = editTaskDescription.value.trim();

            if (!title) {
                alert('Judul task tidak boleh kosong');
                return;
            }

            fetch(`/tasks/${taskId}`, { // Menggunakan rute tasks.update
                    method: 'PUT', // Atau 'PATCH'
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        title,
                        deadline,
                        description
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update DOM dengan data yang diperbarui dari respons
                        currentEditTask.querySelector('.task-title').textContent = data.task.title;
                        currentEditTask.querySelector('.task-deadline').textContent = 'Deadline: ' + formatDate(data.task.deadline);
                        currentEditTask.querySelector('.task-description').textContent = data.task.description || 'No description';

                        closeModal(editTaskModal);
                        updateUI();
                    } else {
                        alert('Gagal memperbarui task: ' + (data.message || 'Unknown error'));
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui task.');
                });
        });

        // Confirm delete (dengan AJAX)
        confirmDeleteBtn.addEventListener('click', function() {
            if (!taskToDelete) return;

            const taskId = taskToDelete.dataset.id; // Ambil ID dari data-id pada elemen <li>

            fetch(`/tasks/${taskId}`, { // Menggunakan rute tasks.destroy
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        taskToDelete.remove(); // Hapus elemen dari DOM
                        updateUI();
                        closeModal(deleteConfirmModal);
                        taskToDelete = null;
                    } else {
                        alert('Gagal menghapus task: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus task.');
                });
        });


        // Existing functionality
        function updateUI() {
            const allTasks = document.querySelectorAll('.task-item');
            const completedTasks = document.querySelectorAll('.task-item.completed');
            const remainingTasks = allTasks.length - completedTasks.length;

            taskStats.textContent = `${remainingTasks} ${remainingTasks === 1 ? 'task' : 'tasks'} remaining`;

            const progressPercent = allTasks.length > 0 ? (completedTasks.length / allTasks.length) * 100 : 0;
            progressFill.style.width = `${progressPercent}%`;
            progressText.textContent = `${Math.round(progressPercent)}%`;
        }

        taskList.addEventListener('click', function(e) {
            const target = e.target;

            // Handle checkbox click
            if (target.classList.contains('task-checkbox')) {
                const taskItem = target.closest('.task-item');
                const taskId = taskItem.dataset.id; // Get task ID from the <li> element
                const isCompleted = target.checked;
                const newStatus = isCompleted ? 'Selesai' : 'Belum Dikerjakan'; // Sesuaikan dengan enum di DB

            fetch(`/tasks/${taskId}/toggle-status`, {
                        method: 'PUT', // Changed from PATCH to PUT to match route
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            taskItem.classList.toggle('completed', isCompleted);
                            updateUI();
                        } else {
                            alert('Gagal mengubah status task: ' + (data.message || 'Unknown error'));
                            // Revert checkbox state if update fails
                            target.checked = !isCompleted;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengubah status task.');
                        // Revert checkbox state on error
                        target.checked = !isCompleted;
                    });
            }
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

        updateUI();
    });
</script>
@endpush


