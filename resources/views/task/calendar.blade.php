@extends('layouts.app')

@section('title', 'Calendar')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<style>
    .calendar-grid {
        min-height: 320px;
    }
    .calendar-day {
        @apply bg-white rounded-lg border border-gray-200 min-h-[70px] flex flex-col p-2 transition hover:bg-violet-50;
        box-sizing: border-box;
    }
    .calendar-header {
        @apply text-center font-semibold py-2;
    }
    .calendar-day .day-number {
        @apply font-bold mb-1;
    }
    .calendar-day.has-tasks {
        @apply bg-green-50 border-green-200;
    }
    .calendar-day.today {
        @apply border-2 border-primary;
    }
    .calendar-day .task-list {
        @apply mt-1 space-y-1;
    }
    .calendar-day .task-item {
        @apply text-xs px-2 py-1 rounded bg-primary/10 text-primary truncate;
    }
    .calendar-day .task-item.completed {
        @apply bg-green-200 text-green-900;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto max-w-4xl py-8">
    <div class="card calendar-card bg-white shadow-lg rounded-lg">
        <div class="card-header flex justify-between items-center px-6 py-4 border-b">
            <div class="card-title text-xl font-semibold">Calendar</div>
            <div id="calendar-nav" class="flex items-center gap-2">
                <button id="prev-month" class="btn btn-sm btn-outline-secondary">&lt; Prev</button>
                <h3 id="month-year" class="mx-2 font-bold"></h3>
                <button id="next-month" class="btn btn-sm btn-outline-secondary">Next &gt;</button>
            </div>
        </div>
        <div class="card-body p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-center" id="calendar-table">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Sun</th>
                            <th class="border p-2">Mon</th>
                            <th class="border p-2">Tue</th>
                            <th class="border p-2">Wed</th>
                            <th class="border p-2">Thu</th>
                            <th class="border p-2">Fri</th>
                            <th class="border p-2">Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body-table">
                        <!-- Calendar rows will be rendered here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
   window.tasksData = @json($tasks ?? []);
</script>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarBody = document.getElementById('calendar-body-table');
        const monthYearDisplay = document.getElementById('month-year');
        const prevButton = document.getElementById('prev-month');
        const nextButton = document.getElementById('next-month');

        let currentDate = new Date();
        let tasks = {};

        function fetchActiveTasks() {
            fetch('/api/active-tasks')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        tasks = {};
                        data.tasks.forEach(task => {
                            if (!tasks[task.deadline]) {
                                tasks[task.deadline] = [];
                            }
                            tasks[task.deadline].push({
                                title: task.title,
                                description: task.description,
                                status: task.status
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

            const firstDayOfMonth = new Date(year, month, 1);
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const startingDay = firstDayOfMonth.getDay();

            let day = 1;
            for (let row = 0; row < 6; row++) {
                const tr = document.createElement('tr');
                for (let col = 0; col < 7; col++) {
                    const td = document.createElement('td');
                    td.className = 'border p-2 align-top min-h-[70px]';
                    if (row === 0 && col < startingDay) {
                        td.innerHTML = '';
                    } else if (day > daysInMonth) {
                        td.innerHTML = '';
                    } else {
                        const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                        let content = `<div class="font-bold mb-1">${day}</div>`;
                        if (tasks[dateString] && tasks[dateString].length > 0) {
                            content += '<div class="space-y-1 mt-1">';
                            tasks[dateString].forEach(task => {
                                content += `<div class="rounded px-2 py-1 text-xs truncate ${task.status === 'Selesai' ? 'bg-green-200 text-green-900' : 'bg-primary/10 text-primary'}" title="${task.title}${task.description ? ': ' + task.description : ''}">${task.title}</div>`;
                            });
                            content += '</div>';
                            td.classList.add('bg-green-50', 'border-green-200');
                        }
                        const today = new Date();
                        if (day === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                            td.classList.add('border-2', 'border-primary');
                        }
                        td.innerHTML = content;
                        day++;
                    }
                    tr.appendChild(td);
                }
                calendarBody.appendChild(tr);
            }
        }

        prevButton?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });
        nextButton?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });

        renderCalendar(currentDate);
        fetchActiveTasks();
    });
</script>
@endpush
