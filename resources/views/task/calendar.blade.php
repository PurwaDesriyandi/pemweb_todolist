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
        justify-content: center;
        align-items: center;
        border: 1px solid #e9ecef;
        position: relative;
        font-weight: 500;
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarBody = document.getElementById('calendar-body');
    const monthYearDisplay = document.getElementById('month-year');
    const prevButton = document.getElementById('prev-month');
    const nextButton = document.getElementById('next-month');

    const tasks = {
        '2025-06-18': 'Team Meeting',
        '2025-06-20': 'Project Alpha Deadline',
        '2025-07-04': 'Submit Report'
    };

    let currentDate = new Date();

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
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const dayElement = document.createElement('div');
            dayElement.classList.add('calendar-day');
            dayElement.textContent = i;

            const today = new Date();
            if (i === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                dayElement.classList.add('today');
            }

            const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            if (tasks[dateString]) {
                dayElement.classList.add('has-tasks');
                dayElement.setAttribute('title', tasks[dateString]);
            }

            calendarBody.appendChild(dayElement);
        }
    }

    prevButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
});
</script>
@endpush
