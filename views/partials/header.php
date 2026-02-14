<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product & Supplier Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #e9ecef;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #0d6efd, #0a58ca);
            border-radius: 10px;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .badge-admin {
            background-color: #ffc107;
            color: #000;
            font-size: 0.65rem;
            font-weight: bold;
            margin-left: 5px;
            padding: 2px 6px;
            border-radius: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="toast-container position-fixed top-0 end-0 p-3 mt-5" style="z-index: 1060;">
    <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-shield-check"></i> Management
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/products"><i class="bi bi-box"></i> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/suppliers"><i class="bi bi-building"></i> Suppliers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/links"><i class="bi bi-link-45deg"></i> Links</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown" id="userDropdown" style="display: none;">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5 me-2"></i>
                        <span id="userNameDisplay">User</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text text-muted small" id="userEmailDisplay"></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" id="logoutBtn">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item" id="loginBtnNav">
                    <a class="nav-link" href="/login">
                        <i class="bi bi-box-arrow-in-right"></i> Sign In
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container main-content">

    <script>
        function showToast(status, message) {
            const toastElement = document.getElementById('errorToast');
            document.getElementById('toastMessage').textContent = message;
            if(status === true) {
                toastElement.classList.remove('bg-danger');
                toastElement.classList.add('bg-success');
            } else {
                toastElement.classList.remove('bg-success');
                toastElement.classList.add('bg-danger');
            }
            if (typeof bootstrap !== 'undefined') {
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            } else {
                alert(message);
            }
        }

        $(document).ready(function() {
            const token = localStorage.getItem('auth_token');
            const userJson = localStorage.getItem('user');

            if (token && userJson) {
                try {
                    const user = JSON.parse(userJson);

                    $('#userNameDisplay').text(user.name);
                    $('#userEmailDisplay').text(user.email);

                    if (user.isAdmin) {
                        $('#userNameDisplay').append('<span class="badge-admin">ADMIN</span>');
                    }

                    $('#userDropdown').show();
                    $('#loginBtnNav').hide();
                } catch (e) {
                    console.error("Error reading user data:", e);
                    localStorage.clear();
                }
            } else {
                $('#userDropdown').hide();
                $('#loginBtnNav').show();
            }

            $('#logoutBtn').on('click', function(e) {
                e.preventDefault();
                localStorage.removeItem('auth_token');
                localStorage.removeItem('user');
                document.cookie = 'auth_token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
                window.location.href = '/login';
            });
        });
    </script>