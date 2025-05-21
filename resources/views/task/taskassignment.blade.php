@extends('dashboard')
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


</style>
<main class="page-content" id="content">
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
                <span style="font-size: 0.85rem;">65%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activate sidebar by default when page loads
        document.getElementById('sidebar').classList.add('active');
        document.getElementById('content').classList.add('sidebar-active');
        document.getElementById('toggleSidebar').classList.add('active');

        // Hamburger menu toggle
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

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
                        item.style.display = item.classList.contains('completed') ? 'none' : '';
                    } else if (filter === 'completed') {
                        item.style.display = item.classList.contains('completed') ? '' : 'none';
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
