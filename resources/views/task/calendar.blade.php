@extends('dashboard')

@section('content')
<main class="page-content" id="content">
    <div class="container">
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
                    <div class="day-number">21</div>
                </div>
                <div class="calendar-day has-tasks">
                    <div class="day-number">22</div>
                </div>
                <div class="calendar-day has-tasks">
                    <div class="day-number">23</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">24</div>
                </div>

                <div class="calendar-day">
                    <div class="day-number">25</div>
                </div>
                <div class="calendar-day has-tasks">
                    <div class="day-number">26</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">27</div>
                </div>
                <div class="calendar-day has-tasks">
                    <div class="day-number">28</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">29</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">30</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">31</div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
