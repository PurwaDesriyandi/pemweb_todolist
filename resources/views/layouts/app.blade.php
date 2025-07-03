<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ToDoList App')</title>

    <!-- DaisyUI & Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Ikon Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-base-100 min-h-screen">
    <!-- Navbar -->
    <nav class="navbar fixed top-0 left-0 w-full z-50">
        <div class="navbar-left flex items-center h-full px-4">
            <a href="/" class="navbar-brand text-xl font-bold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                ToDoList
            </a>
            <div class="hamburger ml-4 lg:flex" id="toggleSidebar">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar fixed top-0 left-0 h-full pt-16 lg:pt-0 z-40" id="sidebar">
        <ul class="nav p-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center" href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door-fill mr-3 text-gray-500"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('task-list') ? 'active' : '' }} flex items-center" href="/task-list">
                    <i class="bi bi-list-task mr-3 text-gray-500"></i>
                    <span>Today's Tasks</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('calendar') ? 'active' : '' }} flex items-center" href="/calendar">
                    <i class="bi bi-calendar-check mr-3 text-gray-500"></i>
                    <span>Calendar</span>
                </a>
            </li>
            @role('admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('role') ? 'active' : '' }} flex items-center" href="/role">
                    <i class="bi bi-person mr-3 text-gray-500"></i>
                    <span>Role</span>
                </a>
            </li>
            @endrole
            <li class="nav-item mt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link text-red-500 hover:bg-red-50 flex items-center" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right mr-3"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="page-content pt-24 lg:pt-16 min-h-screen transition-all duration-300" id="content">
        <div class="max-w-5xl mx-auto px-4">
            @yield('content')
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        // Inisialisasi status sidebar berdasarkan ukuran layar
        function initSidebar() {
            const isDesktop = window.innerWidth >= 1024;
            const shouldOpen = localStorage.getItem('sidebarOpen') === 'true';

            // Di desktop: default tertutup kecuali diinginkan terbuka
            if (isDesktop) {
                const open = shouldOpen || false;
                toggleSidebar.classList.toggle('active', open);
                sidebar.classList.toggle('active', open);
                content.classList.toggle('sidebar-active', open);
            }
            // Di mobile: default tertutup
            else {
                toggleSidebar.classList.remove('active');
                sidebar.classList.remove('active');
                content.classList.remove('sidebar-active');
            }
        }

        // Handle toggle sidebar
        function handleSidebarToggle() {
            const isOpen = sidebar.classList.toggle('active');
            toggleSidebar.classList.toggle('active', isOpen);
            content.classList.toggle('sidebar-active', isOpen);

            // Simpan status di localStorage (hanya untuk desktop)
            if (window.innerWidth >= 1024) {
                localStorage.setItem('sidebarOpen', isOpen);
            }
        }

        // Inisialisasi pertama kali
        initSidebar();

        toggleSidebar.addEventListener('click', handleSidebarToggle);

        // Tutup sidebar saat klik di luar area sidebar (di mobile)
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 1024 && sidebar.classList.contains('active')) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = toggleSidebar.contains(event.target);

                if (!isClickInsideSidebar && !isClickOnToggle) {
                    handleSidebarToggle();
                }
            }
        });

        // Handle resize event
        window.addEventListener('resize', function() {
            initSidebar();
        });
    });
</script>

    @stack('scripts')
</body>

</html>
