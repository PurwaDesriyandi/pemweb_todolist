<<<<<<< HEAD
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
=======
@extends('layouts.default')
@section('content')
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/taskassignment">
                    <i class="bi bi-list-task"></i>
                    <span>Tasks Assignment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/calendar">
                    <i class="bi bi-calendar-check"> </i>
                    <span>Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/upcomingtask">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Upcoming Tasks</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/login">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
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
        });
    </script>
>>>>>>> 078d4f7c9281337e6e2375765db3f4e3176e9c16
@endsection
