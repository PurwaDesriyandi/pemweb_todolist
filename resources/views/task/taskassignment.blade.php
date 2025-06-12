<<<<<<< HEAD
@extends('layouts.app')

@section('title', "Today's Tasks")

@push('styles')
{{-- CSS ini penting untuk mengubah tampilan task yang sudah selesai --}}
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
            {{-- ID ditambahkan agar mudah diupdate oleh JavaScript --}}
            <div class="card-stats" id="task-stats">3 tasks remaining</div>
        </div>
        <div class="card-body">
            <div class="filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="active">Active</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
=======
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS (untuk dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Dashboard</title>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #90e0ef;
            --light: #f8f9fa;
            --dark: #212529;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
        }

        /* Navbar */
        .navbar {
            background-color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            /* Tetap space-between */
            align-items: center;
        }


        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .navbar-links {
            display: flex;
            gap: 1.5rem;
        }

        .navbar-link {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
        }

        .navbar-link:hover {
            color: var(--primary);
        }

        /* Hamburger Menu */
        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 24px;
            height: 18px;
            cursor: pointer;
            z-index: 1100;
            align-items: left;
        }

        .hamburger span {
            display: block;
            height: 2px;
            width: 100%;
            background-color: var(--dark);
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 220px;
            background-color: white;
            border-right: 2px solid #0400ff;
            padding-top: 20px;
            height: 100vh;
            position: fixed;
            top: 60px;
            /* Make room for navbar */
            left: 0;
            z-index: 100;
            transition: transform 0.3s ease;
            transform: translateX(-100%);
            /* Sidebar hidden by default on all screen sizes */
        }

        .sidebar.active {
            transform: translateX(0);
            /* Show sidebar when active class is applied */
        }

        .sidebar h5 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .nav {
            list-style: none;
            padding: 0;
        }

        .sidebar .nav-item {
            margin: 5px 0;
        }

        .sidebar .nav-link {
            display: block;
            padding: 10px 15px;
            color: #000;
            text-decoration: none;
            font-weight: 500;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #0400ff;
            background-color: #f0f0f0;
        }

        /* Main Content */
        .page-content {
            margin-left: 0;
            /* No sidebar margin by default */
            width: 100%;
            margin-top: 60px;
            /* Make room for navbar */
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .page-content.sidebar-active {
            margin-left: 220px;
            /* Add margin when sidebar is active */
            width: calc(100% - 220px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        h1 {
            color: var(--primary);
            font-size: 1.8rem;
        }

        .date-display {
            font-size: 1rem;
            color: #6c757d;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            height: fit-content;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
        }

        .card-stats {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .task-input {
            display: flex;
            margin-bottom: 1rem;
        }

        .task-input input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 5px 0 0 5px;
            font-size: 0.9rem;
        }

        .task-input button {
            padding: 0.75rem 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .task-input button:hover {
            background-color: var(--secondary);
        }

        .task-list {
            list-style-type: none;
        }

        .task-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f2f2f2;
        }

        .task-item:last-child {
            border-bottom: none;
        }

        .task-checkbox {
            margin-right: 0.75rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .task-text {
            flex: 1;
            font-size: 0.95rem;
        }

        .completed .task-text {
            text-decoration: line-through;
            color: #6c757d;
        }

        .task-actions {
            display: flex;
            gap: 0.5rem;
        }

        .task-actions button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            transition: background-color 0.2s;
        }

        .btn-edit {
            color: var(--warning);
        }

        .btn-edit:hover {
            background-color: #fff3cd;
        }

        .btn-delete {
            color: var(--danger);
        }

        .btn-delete:hover {
            background-color: #f8d7da;
        }

        .priority-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 0.75rem;
        }

        .priority-high {
            background-color: var(--danger);
        }

        .priority-medium {
            background-color: var(--warning);
        }

        .priority-low {
            background-color: var(--success);
        }

        .filters {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .filter-btn {
            padding: 0.5rem 0.75rem;
            background-color: #e9ecef;
            border: none;
            border-radius: 20px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn.active {
            background-color: var(--primary);
            color: white;
        }

        .progress-section {
            margin-top: 1rem;
        }

        .progress-bar {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--primary);
            width: 65%;
        }

        /* Summary Card */
        .summary-card {
            margin-bottom: 1.5rem;
        }

        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-box {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Calendar View */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }

        .calendar-header {
            font-weight: 600;
            text-align: center;
            padding: 0.5rem;
            color: #6c757d;
        }

        .calendar-day {
            aspect-ratio: 1;
            padding: 0.25rem;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.85rem;
            background-color: white;
        }

        .day-number {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .has-tasks {
            background-color: #e6f0ff;
            position: relative;
        }

        .has-tasks::after {
            content: '';
            width: 6px;
            height: 6px;
            background-color: var(--primary);
            border-radius: 50%;
            position: absolute;
            bottom: 5px;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            /* Jarak antara hamburger dan judul */
        }

        .hamburger {
            margin: 0;
            /* Pastikan tidak ada margin yang tidak perlu */
        }

        .today {
            border: 2px solid var(--primary);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar-links {
                display: none;
            }

            .sidebar {
                transform: translateX(-100%);
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .page-content {
                margin-left: 0;
                width: 100%;
            }

            .page-content.sidebar-active {
                margin-left: 220px;
                width: calc(100% - 220px);
            }

            .container {
                padding: 1rem;
            }

            .dashboard {
                grid-template-columns: 1fr;
            }

            .summary-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 80px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .modal input,
        .modal textarea {
            width: 100%;
            margin: 8px 0;
            padding: 8px;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/" class="navbar-brand">ToDoList </a>
            <div class="hamburger" id="toggleSidebar">
                <span></span>
                <span></span>
                <span></span>
>>>>>>> b2f4a36a0f34b5cb517976c4aae52d49f3158df7
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
<<<<<<< HEAD
=======
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle navbar-link"
                    id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" width="32"
                        height="32" class="rounded-circle me-2">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                </ul>
            </div>
>>>>>>> b2f4a36a0f34b5cb517976c4aae52d49f3158df7
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Memilih semua elemen yang dibutuhkan
    const taskList = document.getElementById('task-list');
    const addTaskInput = document.getElementById('add-task-input');
    const addTaskBtn = document.getElementById('add-task-btn');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const taskStats = document.getElementById('task-stats');
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');

    // 2. Fungsi utama untuk memperbarui UI (progress bar dan sisa task)
    function updateUI() {
        const allTasks = document.querySelectorAll('.task-item');
        const completedTasks = document.querySelectorAll('.task-item.completed');
        const remainingTasks = allTasks.length - completedTasks.length;

<<<<<<< HEAD
        // Update teks sisa task
        taskStats.textContent = `${remainingTasks} tasks remaining`;

        // Update progress bar
        const progressPercent = allTasks.length > 0 ? (completedTasks.length / allTasks.length) * 100 : 0;
        progressFill.style.width = `${progressPercent}%`;
        progressText.textContent = `${Math.round(progressPercent)}%`;
    }
=======
                <div class="task-input">
                    <input type="text" placeholder="Add a new task...">
                    <button id="openAddModal">Add Task</button>
                </div>

                <!-- Add Task Modal -->
                <div id="addTaskModal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn" id="closeAddModal">&times;</span>
                        <h3>Add New Task</h3>
                        <input type="text" id="taskTitle" placeholder="Task title">
                        <input type="date" id="taskDate">
                        <textarea id="taskDescription" placeholder="Task description"></textarea>
                        <button id="submitAddTask">Add Task</button>
                    </div>
                </div>

                <!-- Modal Edit Tugas -->
                <div class="modal" id="editTaskModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Edit Task</h2>
                            <span class="close-btn" id="closeEditModal">&times;</span>
                        </div>

                        <label for="editTaskTitle">Judul Tugas *</label>
                        <input type="text" id="editTaskTitle" required>

                        <label for="editTaskDate">Tanggal</label>
                        <input type="date" id="editTaskDate">

                        <label for="editTaskDescription">Deskripsi</label>
                        <textarea id="editTaskDescription" placeholder="Masukkan deskripsi tugas (opsional)…"></textarea>

                        <div class="modal-footer">
                            <button class="btn-cancel" id="cancelEditModal">Batal</button>
                            <button class="btn-submit" id="saveEditTask">Simpan Perubahan</button>
                        </div>
                    </div>
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
>>>>>>> b2f4a36a0f34b5cb517976c4aae52d49f3158df7

    // 3. Fungsi untuk menangani semua aksi di dalam daftar task
    taskList.addEventListener('click', function(e) {
        const target = e.target;

        // Aksi untuk Checkbox
        if (target.classList.contains('task-checkbox')) {
            target.closest('.task-item').classList.toggle('completed', target.checked);
        }

        // Aksi untuk tombol Delete
        if (target.classList.contains('btn-delete')) {
            if (confirm('Are you sure you want to delete this task?')) {
                target.closest('.task-item').remove();
            }
        }

        // Aksi untuk tombol Edit
        if (target.classList.contains('btn-edit')) {
            const taskItem = target.closest('.task-item');
            const taskTextElement = taskItem.querySelector('.task-text');
            const currentText = taskTextElement.textContent;
            const newText = prompt('Edit your task:', currentText);

            if (newText !== null && newText.trim() !== '') {
                taskTextElement.textContent = newText.trim();
            }
        }

        // Panggil updateUI setelah ada aksi
        updateUI();
    });

    // 4. Fungsi untuk Filter
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Hapus kelas 'active' dari semua tombol
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Tambahkan kelas 'active' ke tombol yang diklik
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

    // 5. Fungsi untuk Menambah Task Baru
    function addNewTask() {
        const text = addTaskInput.value.trim();
        if (text === '') return; // Jangan tambah task kosong

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

<<<<<<< HEAD
        taskList.prepend(li); // Tambah task baru di paling atas
        addTaskInput.value = ''; // Kosongkan input
        updateUI();
    }
=======
            <script>
                // Edit Task Functionality
                let currentEditTask = null;

                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('btn-edit')) {
                        const taskItem = e.target.closest('.task-item');
                        currentEditTask = taskItem;

                        // Get data
                        const title = taskItem.querySelector('.task-text').textContent;
                        const description = taskItem.querySelector('textarea')?.textContent || taskItem.querySelector(
                            'div[style*="font-size: 0.9rem"]')?.textContent || '';
                        const date = taskItem.querySelector('div[style*="font-size: 0.8rem"]')?.textContent || '';

                        // Set to modal input
                        document.getElementById('editTaskTitle').value = title.trim();
                        document.getElementById('editTaskDate').value = date.trim();
                        document.getElementById('editTaskDescription').value = description.trim();

                        // Show modal
                        document.getElementById('editTaskModal').style.display = 'block';
                    }
                });

                // Close edit modal
                document.getElementById('closeEditModal').addEventListener('click', () => {
                    document.getElementById('editTaskModal').style.display = 'none';
                });
                document.getElementById('cancelEditModal').addEventListener('click', () => {
                    document.getElementById('editTaskModal').style.display = 'none';
                });

                // Save changes
                document.getElementById('saveEditTask').addEventListener('click', () => {
                    if (!currentEditTask) return;

                    const title = document.getElementById('editTaskTitle').value.trim();
                    const date = document.getElementById('editTaskDate').value;
                    const description = document.getElementById('editTaskDescription').value.trim();

                    if (title) {
                        currentEditTask.querySelector('.task-text').textContent = title;

                        // Update or create date element
                        let dateElement = currentEditTask.querySelector('div[style*="font-size: 0.8rem"]');
                        if (!dateElement) {
                            dateElement = document.createElement('div');
                            dateElement.style.fontSize = '0.8rem';
                            dateElement.style.color = 'gray';
                            currentEditTask.insertBefore(dateElement, currentEditTask.querySelector('.task-actions'));
                        }
                        dateElement.textContent = date;

                        // Update or create description element
                        let descElement = currentEditTask.querySelector('div[style*="font-size: 0.9rem"]');
                        if (!descElement) {
                            descElement = document.createElement('div');
                            descElement.style.fontSize = '0.9rem';
                            currentEditTask.insertBefore(descElement, currentEditTask.querySelector('.task-actions'));
                        }
                        descElement.textContent = description;
                    }

                    document.getElementById('editTaskModal').style.display = 'none';
                    updateTaskCounts();
                });


                // Modal Elements
                const openModalBtn = document.getElementById('openAddModal');
                const closeModalBtn = document.getElementById('closeAddModal');
                const modal = document.getElementById('addTaskModal');
                const submitAddTask = document.getElementById('submitAddTask');

                // Open Modal
                openModalBtn.addEventListener('click', () => {
                    modal.style.display = 'block';
                });

                // Close Modal
                closeModalBtn.addEventListener('click', () => {
                    modal.style.display = 'none';
                });

                // Click outside modal closes it
                window.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                    }
                });

                // Add task from modal
                submitAddTask.addEventListener('click', () => {
                    addNewTaskFromModal();
                    modal.style.display = 'none';
                });

                function addNewTaskFromModal() {
                    const title = document.getElementById('taskTitle').value.trim();
                    const date = document.getElementById('taskDate').value;
                    const description = document.getElementById('taskDescription').value.trim();

                    if (title) {
                        const taskList = document.querySelector('.task-list');
                        const newTask = document.createElement('li');
                        newTask.className = 'task-item';

                        newTask.innerHTML = `
            <div class="priority-indicator priority-medium"></div>
            <input type="checkbox" class="task-checkbox">
            <span class="task-text">${title}</span>
            <div style="font-size: 0.8rem; color: gray;">${date}</div>
            <div style="font-size: 0.9rem;">${description}</div>
            <div class="task-actions">
                <button class="btn-edit">Edit</button>
                <button class="btn-delete">Delete</button>
            </div>
        `;

                        taskList.prepend(newTask);
                        updateTaskCounts();

                        // Clear inputs
                        document.getElementById('taskTitle').value = '';
                        document.getElementById('taskDate').value = '';
                        document.getElementById('taskDescription').value = '';
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    // Activate sidebar by default when page loads
                    document.getElementById('sidebar').classList.add('active');
                    document.getElementById('content').classList.add('sidebar-active');
                    document.getElementById('toggleSidebar').classList.add('active');
>>>>>>> b2f4a36a0f34b5cb517976c4aae52d49f3158df7

    addTaskBtn.addEventListener('click', addNewTask);
    addTaskInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            addNewTask();
        }
    });

<<<<<<< HEAD
    updateUI();
});
</script>
@endpush
=======
                    toggleSidebar.addEventListener('click', function() {
                        toggleSidebar.classList.toggle('active');
                        sidebar.classList.toggle('active');
                        content.classList.toggle('sidebar-active');
                    });

                    // Close sidebar if clicking outside
                    document.addEventListener('click', function(e) {
                        // Only if sidebar is active and the click is not on or within the sidebar or hamburger
                        if (sidebar.classList.contains('active') &&
                            !sidebar.contains(e.target) &&
                            !toggleSidebar.contains(e.target)) {
                            toggleSidebar.classList.remove('active');
                            sidebar.classList.remove('active');
                            content.classList.remove('sidebar-active');
                        }
                    });

                    // Get all checkboxes
                    const checkboxes = document.querySelectorAll('.task-checkbox');

                    // Add event listener to each checkbox
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const taskItem = this.closest('.task-item');
                            if (this.checked) {
                                taskItem.classList.add('completed');
                            } else {
                                taskItem.classList.remove('completed');
                            }

                            // Update task counters
                            updateTaskCounts();
                        });
                    });

                    // Add task functionality
                    const addTaskInput = document.querySelector('.task-input input');
                    const addTaskButton = document.querySelector('.task-input button');

                    addTaskButton.addEventListener('click', function() {
                        addNewTask();
                    });

                    addTaskInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            addNewTask();
                        }
                    });

                    // Filter buttons
                    const filterButtons = document.querySelectorAll('.filter-btn');

                    filterButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // Remove active class from all buttons
                            filterButtons.forEach(btn => btn.classList.remove('active'));

                            // Add active class to clicked button
                            this.classList.add('active');

                            // Apply filter
                            const filter = this.textContent.toLowerCase();
                            const taskItems = document.querySelectorAll('.task-list .task-item');

                            taskItems.forEach(item => {
                                if (filter === 'all') {
                                    item.style.display = '';
                                } else if (filter === 'active') {
                                    item.style.display = item.classList.contains('completed') ?
                                        'none' : '';
                                } else if (filter === 'completed') {
                                    item.style.display = item.classList.contains('completed') ? '' :
                                        'none';
                                }
                            });
                        });
                    });

                    // Delete task buttons
                    document.addEventListener('click', function(e) {
                        if (e.target.classList.contains('btn-delete')) {
                            const taskItem = e.target.closest('.task-item');
                            taskItem.remove();
                            updateTaskCounts();
                        }
                    });

                    // Set current date
                    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                });

                function addNewTask() {
                    const input = document.querySelector('.task-input input');
                    const taskText = input.value.trim();

                    if (taskText) {
                        const taskList = document.querySelector('.task-list');

                        const newTask = document.createElement('li');
                        newTask.className = 'task-item';

                        newTask.innerHTML = `
                            <div class="priority-indicator priority-medium"></div>
                            <input type="checkbox" class="task-checkbox">
                            <span class="task-text">${taskText}</span>
                            <div class="task-actions">
                                <button class="btn-edit">Edit</button>
                                <button class="btn-delete">Delete</button>
                            </div>
                        `;

                        taskList.prepend(newTask);
                        input.value = '';
                        updateTaskCounts();
                    }
                }

                function updateTaskCounts() {
                    // This is a simplified version - in a real app you'd have more robust logic
                    const totalTasks = document.querySelectorAll('.task-item').length;
                    const completedTasks = document.querySelectorAll('.task-item.completed').length;
                    const remainingTasks = totalTasks - completedTasks;

                    const taskStats = document.querySelector('.card-stats');
                    if (taskStats) {
                        taskStats.textContent = `${remainingTasks} tasks remaining`;
                    }

                    // Update progress bar
                    const progressPercentage = totalTasks > 0 ? (completedTasks / totalTasks) * 100 : 0;
                    const progressFill = document.querySelector('.progress-fill');
                    if (progressFill) {
                        progressFill.style.width = `${progressPercentage}%`;
                    }

                    const progressText = document.querySelector('.progress-section span:last-child');
                    if (progressText) {
                        progressText.textContent = `${Math.round(progressPercentage)}%`;
                    }
                }



                // Handle window resize
                window.addEventListener('resize', function() {
                    // No special handling needed since sidebar works the same at all screen sizes
                });
            </script>
</body>

</html>
>>>>>>> b2f4a36a0f34b5cb517976c4aae52d49f3158df7
