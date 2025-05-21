<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipafestival 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            background-color: white;
            border-right: 2px solid #0400ff;
            padding-top: 70px;
            z-index: 100;
        }

        .sidebar .nav-link {
            color: #000;
            font-weight: 500;
            margin: 0.5rem 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #0400ff;
            background-color: #f0f0f0;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        .navbar-custom {
            background: white;
            border-bottom: 3px solid #0400ff;
            position: fixed;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand img {
            max-height: 50px;
        }

        .input-group .form-control:focus {
            box-shadow: none;
            border-color: #0400ff;
        }

        .btn-outline-secondary:hover {
            background-color: #f0f0f0;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-custom shadow-sm sticky-top px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center w-100">
            <div class="flex-grow-1 me-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search...">
                </div>
            </div>
            <div class="d-flex align-items-center me-3">
                <button class="btn btn-outline-secondary me-2">
                    <i class="bi bi-star"></i> Star
                </button>
                <span class="fw-bold">1,105</span>
            </div>
            <div>
                <span class="fw-bold text-success">Avatar</span>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <!-- <div class="sidebar p-3 ">
        <h5 class="text-center">Menu</h5>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-list-task me-2"></i> Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-calendar-check me-2"></i> Calendar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-bar-chart-line me-2"></i> Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
            </li>
        </ul>
    </div> -->

    <!-- Main Content -->


</body>

</html>
