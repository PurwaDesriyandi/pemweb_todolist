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
                <li class="task-item">
                    <input type="checkbox" class="task-checkbox">
                    <div class="task-content">
                        <div class="task-title">Complete project proposal</div>
                        <div class="task-deadline">Deadline: 13/06/2025</div>
                        <div class="task-description">Prepare and finalize the project proposal document for client review</div>
                    </div>
                    <div class="task-actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                </li>
                <li class="task-item">
                    <input type="checkbox" class="task-checkbox">
                    <div class="task-content">
                        <div class="task-title">Team meeting at 2 PM</div>
                        <div class="task-deadline">Deadline: 13/06/2025</div>
                        <div class="task-description">Weekly team meeting to discuss project progress and next steps</div>
                    </div>
                    <div class="task-actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                </li>
                <li class="task-item completed">
                    <input type="checkbox" class="task-checkbox" checked>
                    <div class="task-content">
                        <div class="task-title">Send weekly report</div>
                        <div class="task-deadline">Deadline: 12/06/2025</div>
                        <div class="task-description">Compile and send weekly progress report to management</div>
                    </div>
                    <div class="task-actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                </li>
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
            <div class="form-group">
                <label class="form-label">Judul Task</label>
                <input type="text" class="form-input" id="task-title" placeholder="Masukkan judul task...">
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Deadline</label>
                <input type="date" class="form-input" id="task-deadline">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi Task</label>
                <textarea class="form-input form-textarea" id="task-description" placeholder="Masukkan deskripsi task (opsional)..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-btn btn-cancel">Batal</button>
            <button class="modal-btn btn-save" id="save-task">Simpan Task</button>
        </div>
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
    let currentEditTask = null;
    let taskToDelete = null;

    // Set default date to today
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    taskDeadline.value = formattedDate;

    // Format date to DD/MM/YYYY
    function formatDate(dateString) {
        const [year, month, day] = dateString.split('-');
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

    // Show edit task modal
    taskList.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-edit')) {
            const taskItem = e.target.closest('.task-item');
            currentEditTask = taskItem;

            // Get task data
            const taskTitleElement = taskItem.querySelector('.task-title');
            const taskDeadlineElement = taskItem.querySelector('.task-deadline');
            const taskDescriptionElement = taskItem.querySelector('.task-description');

            // Extract date from "Deadline: DD/MM/YYYY" text
            const deadlineText = taskDeadlineElement.textContent.replace('Deadline: ', '');
            const [day, month, year] = deadlineText.split('/');
            const formattedDeadline = `${year}-${month}-${day}`;

            // Populate form
            editTaskTitle.value = taskTitleElement.textContent;
            editTaskDeadline.value = formattedDeadline;
            editTaskDescription.value = taskDescriptionElement.textContent;

            openModal(editTaskModal);
        }

        if (e.target.classList.contains('btn-delete')) {
            taskToDelete = e.target.closest('.task-item');
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

    // Confirm delete
    confirmDeleteBtn.addEventListener('click', function() {
        if (taskToDelete) {
            taskToDelete.remove();
            updateUI();
            closeModal(deleteConfirmModal);
            taskToDelete = null;
        }
    });

    // Add new task
    saveTaskBtn.addEventListener('click', function() {
        const title = taskTitle.value.trim();
        if (!title) {
            alert('Judul task tidak boleh kosong');
            return;
        }

        const deadline = taskDeadline.value;
        const description = taskDescription.value.trim();

        const newTaskHTML = `
            <li class="task-item">
                <input type="checkbox" class="task-checkbox">
                <div class="task-content">
                    <div class="task-title">${title}</div>
                    <div class="task-deadline">Deadline: ${formatDate(deadline)}</div>
                    <div class="task-description">${description || 'No description'}</div>
                </div>
                <div class="task-actions">
                    <button class="btn-edit">Edit</button>
                    <button class="btn-delete">Delete</button>
                </div>
            </li>
        `;

        taskList.insertAdjacentHTML('afterbegin', newTaskHTML);
        closeModal(addTaskModal);
        updateUI();
    });

    // Update task
    updateTaskBtn.addEventListener('click', function() {
        if (!currentEditTask) return;

        const title = editTaskTitle.value.trim();
        if (!title) {
            alert('Judul task tidak boleh kosong');
            return;
        }

        const deadline = editTaskDeadline.value;
        const description = editTaskDescription.value.trim();

        // Update task
        currentEditTask.querySelector('.task-title').textContent = title;
        currentEditTask.querySelector('.task-deadline').textContent = 'Deadline: ' + formatDate(deadline);
        currentEditTask.querySelector('.task-description').textContent = description || 'No description';

        closeModal(editTaskModal);
        updateUI();
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

        if (target.classList.contains('task-checkbox')) {
            const taskItem = target.closest('.task-item');
            taskItem.classList.toggle('completed', target.checked);
            updateUI();
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
