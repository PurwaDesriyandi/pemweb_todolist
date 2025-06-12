<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ToDoList App')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/" class="navbar-brand">ToDoList</a>
            <div class="hamburger" id="toggleSidebar">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="navbar-links">
            <div class="flex-grow-1 me-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search...">
                </div>
            </div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle navbar-link" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" width="32" height="32" class="rounded-circle me-2">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('task-assignment') ? 'active' : '' }}" href="/task-assignment">
                    <i class="bi bi-list-task"></i>
                    <span>Today's Tasks</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('calendar') ? 'active' : '' }}" href="/calendar">
                    <i class="bi bi-calendar-check"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('upcoming-task') ? 'active' : '' }}" href="/upcoming-task">
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

    <main class="page-content" id="content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            if (toggleSidebar && sidebar && content) {

                function handleSidebarToggle() {
                    toggleSidebar.classList.toggle('active');
                    sidebar.classList.toggle('active');
                    content.classList.toggle('sidebar-active');
                }

                handleSidebarToggle();

                toggleSidebar.addEventListener('click', handleSidebarToggle);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
