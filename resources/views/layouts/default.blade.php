<!doctype html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", "to do app")</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styleCalender.css') }}" rel="stylesheet">
    @yield("style")
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
  </body>
</html>