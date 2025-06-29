@extends('layouts.app')

@section('title', 'Calendar')

@push('styles')
<style>
    .calendar-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #month-year {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
        text-align: center;
    }

    #calendar-nav button {
        background: #f0f0f0;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 0.25rem 0.75rem;
        cursor: pointer;
    }
    #calendar-nav button:hover {
        background: #e9ecef;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        margin-top: 1rem;
    }

    .calendar-header, .calendar-day {
        text-align: center;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }

    .calendar-header {
        font-weight: 600;
        color: #6c757d;
    }

    .calendar-day {
        background-color: #f8f9fa;
        border-radius: 5px;
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        border: 1px solid #e9ecef;
        position: relative;
        font-weight: 500;
        min-height: 80px;
        padding: 0.25rem;
    }

    .calendar-day.prev-month,
    .calendar-day.next-month {
        color: #adb5bd;
        background-color: #fff;
    }

    .calendar-day.today {
        background-color: #4361ee;
        color: white;
        font-weight: bold;
        border-color: #4361ee;
    }

    .calendar-day.has-tasks::after {
        content: '';
        position: absolute;
        bottom: 6px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #f72585;
    }

    .calendar-day.today.has-tasks::after {
        background-color: white;
    }

    .day-number {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .task-list {
        width: 100%;
        flex-grow: 1;
        overflow: hidden;
    }

    .task-item {
        font-size: 0.7rem;
        padding: 0.1rem 0.2rem;
        margin-bottom: 0.1rem;
        background-color: rgba(67, 97, 238, 0.8);
        color: white;
        border-radius: 2px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
    }

    .task-item.completed {
        background-color: #28a745 !important;
    }

    .calendar-day.today .task-item {
        background-color: rgba(255, 255, 255, 0.9);
        color: #4361ee;
    }

    .calendar-day.today .task-item.completed {
        background-color: rgba(40, 167, 69, 0.9) !important;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card calendar-card">
        <div class="card-header">
            <div class="card-title">Calendar</div>
            <div id="calendar-nav" class="d-flex align-items-center gap-2">
                <button id="prev-month" class="btn btn-sm btn-outline-secondary">&lt; Prev</button>
                <h3 id="month-year"></h3>
                <button id="next-month" class="btn btn-sm btn-outline-secondary">Next &gt;</button>
            </div>
        </div>
        <div class="card-body">
            <div class="calendar-grid" id="calendar-headers">
                <div class="calendar-header">Sun</div>
                <div class="calendar-header">Mon</div>
                <div class="calendar-header">Tue</div>
                <div class="calendar-header">Wed</div>
                <div class="calendar-header">Thu</div>
                <div class="calendar-header">Fri</div>
                <div class="calendar-header">Sat</div>
            </div>
            <div class="calendar-grid" id="calendar-body">
            </div>
        </div>
    </div>
</div>

<script>
   window.tasksData = @json($tasks ?? []);
</script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarBody = document.getElementById('calendar-body');
        const monthYearDisplay = document.getElementById('month-year');
        const prevButton = document.getElementById('prev-month');
        const nextButton = document.getElementById('next-month');

<<<<<<< HEAD
    let currentDate = new Date();

    let tasks = {};

    // Function to fetch active tasks from API and update tasks object
    function fetchActiveTasks() {
        fetch('/api/active-tasks')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    tasks = {};
                    // Build a map of date to array of task objects
                    data.tasks.forEach(task => {
                        if (!tasks[task.deadline]) {
                            tasks[task.deadline] = [];
                        }
                        tasks[task.deadline].push({
                            title: task.title,
                            description: task.description
                        });
                    });
                    renderCalendar(currentDate);
                }
            })
            .catch(error => {
                console.error('Error fetching active tasks:', error);
            });
    }

    function renderCalendar(date) {
        calendarBody.innerHTML = '';
        const year = date.getFullYear();
        const month = date.getMonth();

        monthYearDisplay.textContent = date.toLocaleDateString('en-US', {
            month: 'long',
            year: 'numeric'
        });

        const firstDayOfMonth = new Date(year, month, 1);
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const startingDay = firstDayOfMonth.getDay();

        for (let i = 0; i < startingDay; i++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day', 'prev-month');
            calendarBody.appendChild(dayElement);
=======
        const tasks = {};

        // Process tasks data
        if (window.tasksData && Array.isArray(window.tasksData)) {
            window.tasksData.forEach(task => {
                if (task && task.deadline) {
                    const deadline = task.deadline; 
                    if (!tasks[deadline]) {
                        tasks[deadline] = [];
                    }
                    tasks[deadline].push({
                        title: task.title || 'Untitled',
                        status: task.status || 'Belum Dikerjakan'
                    });
                }
            });
>>>>>>> 29c6d9275264bfafedb2897ee471d1c5308346f3
        }

        let currentDate = new Date();

        function renderCalendar(date) {
            if (!calendarBody) return;
            
            calendarBody.innerHTML = '';
            const year = date.getFullYear();
            const month = date.getMonth();

            if (monthYearDisplay) {
                monthYearDisplay.textContent = date.toLocaleDateString('en-US', {
                    month: 'long',
                    year: 'numeric',
                });
            }

<<<<<<< HEAD
            const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            if (tasks[dateString]) {
                dayElement.classList.add('has-tasks');
                // Clear existing text content and add day number
                dayElement.textContent = '';
                const dayNumber = document.createElement('div');
                dayNumber.textContent = i;
                dayNumber.style.fontWeight = 'bold';
                dayElement.appendChild(dayNumber);

                // Add task info elements
                tasks[dateString].forEach(task => {
                    const taskInfo = document.createElement('div');
                    taskInfo.style.fontSize = '0.7rem';
                    taskInfo.style.marginTop = '2px';
                    taskInfo.style.textAlign = 'left';
                    taskInfo.textContent = `${task.title}${task.description ? ': ' + task.description : ''}`;
                    dayElement.appendChild(taskInfo);
                });
=======
            const firstDayOfMonth = new Date(year, month, 1);
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const startingDay = firstDayOfMonth.getDay();

            // empty cells for previous month
            for (let i = 0; i < startingDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('calendar-day', 'prev-month');
                calendarBody.appendChild(emptyDay);
>>>>>>> 29c6d9275264bfafedb2897ee471d1c5308346f3
            }

            // days of current month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day');

                const dayNumber = document.createElement('div');
                dayNumber.classList.add('day-number');
                dayNumber.textContent = day;
                dayElement.appendChild(dayNumber);

                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                // tasks for this date
                if (tasks[dateString] && tasks[dateString].length > 0) {
                    dayElement.classList.add('has-tasks');
                    const taskList = document.createElement('div');
                    taskList.classList.add('task-list');
                    
                    tasks[dateString].forEach(task => {
                        const taskItem = document.createElement('div');
                        taskItem.classList.add('task-item');
                        if (task.status === 'Selesai') {
                            taskItem.classList.add('completed');
                        }
                        taskItem.textContent = task.title;
                        taskItem.title = task.title; // Full title on hover
                        taskList.appendChild(taskItem);
                    });
                    dayElement.appendChild(taskList);
                }

                // Highlight today
                const today = new Date();
                if (day === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                    dayElement.classList.add('today');
                }

                calendarBody.appendChild(dayElement);
            }

            // Fill remaining cells for next month
            const totalCells = calendarBody.children.length;
            const remainingCells = 42 - totalCells; 
            for (let i = 0; i < remainingCells; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.classList.add('calendar-day', 'next-month');
                calendarBody.appendChild(emptyDay);
            }
        }

        // Event listeners
        if (prevButton) {
            prevButton.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
            });
        }

        if (nextButton) {
            nextButton.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
            });
        }

        // Initial render
        renderCalendar(currentDate);
    });
<<<<<<< HEAD

    nextButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    fetchActiveTasks();
});
=======
>>>>>>> 29c6d9275264bfafedb2897ee471d1c5308346f3
</script>
@endpush
@endsection