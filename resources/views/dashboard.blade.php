<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
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
        
        .today {
            border: 2px solid var(--primary);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .dashboard {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<x-header title="Selamat Datang" />
<body>
    <div class="container">
        <header>
            <h1>Task Dashboard</h1>
            <div class="date-display" id="currentDate">Wednesday, April 30, 2025</div>
        </header>
        
        <div class="summary-card card">
            <div class="card-header">
                <div class="card-title">Summary</div>
            </div>
            <div class="summary-stats">
                <div class="stat-box">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Due Today</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">4</div>
                    <div class="stat-label">Overdue</div>
                </div>
            </div>
        </div>
        
        <div class="dashboard">
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
            
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Upcoming Tasks</div>
                    <div class="card-stats">8 tasks</div>
                </div>
                
                <ul class="task-list">
                    <li class="task-item">
                        <div class="priority-indicator priority-high"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Quarterly review meeting</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 2</div>
                    </li>
                    <li class="task-item">
                        <div class="priority-indicator priority-medium"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Client presentation</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 3</div>
                    </li>
                    <li class="task-item">
                        <div class="priority-indicator priority-medium"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Update documentation</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 5</div>
                    </li>
                    <li class="task-item">
                        <div class="priority-indicator priority-low"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Review budget</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 7</div>
                    </li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Calendar View</div>
                    <div class="card-stats">May 2025</div>
                </div>
                
                <div class="calendar">
                    <div class="calendar-header">Sun</div>
                    <div class="calendar-header">Mon</div>
                    <div class="calendar-header">Tue</div>
                    <div class="calendar-header">Wed</div>
                    <div class="calendar-header">Thu</div>
                    <div class="calendar-header">Fri</div>
                    <div class="calendar-header">Sat</div>
                    
                    <div class="calendar-day"></div>
                    <div class="calendar-day"></div>
                    <div class="calendar-day"></div>
                    <div class="calendar-day today">
                        <div class="day-number">30</div>
                    </div>
                    <div class="calendar-day has-tasks">
                        <div class="day-number">1</div>
                    </div>
                    <div class="calendar-day has-tasks">
                        <div class="day-number">2</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">3</div>
                    </div>
                    
                    <div class="calendar-day">
                        <div class="day-number">4</div>
                    </div>
                    <div class="calendar-day has-tasks">
                        <div class="day-number">5</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">6</div>
                    </div>
                    <div class="calendar-day has-tasks">
                        <div class="day-number">7</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">8</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">9</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">10</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Basic task interaction functionality
        document.addEventListener('DOMContentLoaded', function() {
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
                    
                    // Update task counters (simplified)
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
    </script>
</body>
</html>