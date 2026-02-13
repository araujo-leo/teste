<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de produtos e fornecedores</title>
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

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #e9ecef;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #0d6efd, #0a58ca);
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #0a58ca, #084298);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        .badge-admin {
            background-color: #ffc107;
            color: #000;
            font-size: 0.7rem;
            margin-left: 8px;
            padding: 3px 8px;
            border-radius: 12px;
        }

        .user-info {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,.75);
            padding: 0.5rem 1rem;
        }

        .user-info i {
            margin-right: 8px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">
            Gerenciamento
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/products">
                        <i class="bi bi-box"></i> Produtos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/suppliers">
                        <i class="bi bi-building"></i> Fornecedores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/links">
                        <i class="bi bi-link-45deg"></i> Vínculos
                    </a>
                </li>
                <li class="nav-item dropdown" id="userDropdown" style="display: none;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <span id="userName">Usuário</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" id="logoutBtn">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item" id="loginBtn">
                    <a class="nav-link" href="/login">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container main-content">
