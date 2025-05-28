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
                <a class="nav-link" href="/calendar">
                    <i class="bi bi-calendar-check"> </i>
                    <span>Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/upcomingtask">
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
                    <div class="card-title">Upcoming Tasks</div>
                    <div class="card-stats">8 tasks</div>
                </div>

                <ul class="task-list">
                    <li class="task-item">
                        <div class="priority-indicator priority-high"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Quarterly review meeting</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 22</div>
                    </li>
                    <li class="task-item">
                        <div class="priority-indicator priority-medium"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Client presentation</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 23</div>
                    </li>
                    <li class="task-item">
                        <div class="priority-indicator priority-medium"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Update documentation</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 25</div>
                    </li>
                    <li class="task-item">
                        <div class="priority-indicator priority-low"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">Review budget</span>
                        <div style="margin-left: auto; font-size: 0.85rem; color: #6c757d;">May 27</div>
                    </li>
                </ul>
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
                });
            </script>
@endsection
