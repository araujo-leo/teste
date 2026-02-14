<?php include __DIR__ . '/../partials/header.php'; ?>

    <style>
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #0d6efd;
            text-shadow: 2px 2px #dee2e6;
        }

        .btn-home {
            border: 2px solid #0d6efd;
            color: #0d6efd;
            transition: all 0.3s;
        }

        .btn-home:hover {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>

    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 70vh;">
        <h1 class="error-code">404</h1>
        <h2 class="text-dark mb-4 fw-bold">Page Not Found</h2>

        <p class="text-muted text-center" style="max-width: 500px;">
            The page you are looking for doesn't exist or has been moved.
            Please check the URL or return to the main dashboard.
        </p>

        <a href="/" class="btn btn-home px-5 py-2 mt-4 fw-bold">
            <i class="bi bi-house-door me-2"></i> Return to Base
        </a>
    </div>

<?php include __DIR__ . '/../partials/footer.php'; ?>