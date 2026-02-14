<?php include __DIR__ . '/../partials/header.php'; ?>

    <style>
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #6c757d;
            text-shadow: 2px 2px #dee2e6;
        }

        .btn-retry {
            border: 2px solid #6c757d;
            color: #6c757d;
        }

        .btn-retry:hover {
            background-color: #6c757d;
            color: #fff;
        }
    </style>

    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 70vh;">
        <h1 class="error-code">500</h1>
        <h2 class="text-secondary mb-4 fw-bold">System Failure</h2>

        <p class="text-muted text-center" style="max-width: 500px;">
            Our servers are having trouble handling the request.
            Our engineering team has been notified of the disturbance.
        </p>

        <?php if (isset($error) && isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === 'true'): ?>
            <div class="alert alert-light border text-danger mt-3 w-75 overflow-auto shadow-sm">
                <strong><i class="bi bi-bug"></i> Debug Info:</strong><br>
                <small><?= htmlspecialchars($error) ?></small>
            </div>
        <?php endif; ?>

        <a href="/" class="btn btn-retry px-5 py-2 mt-4 fw-bold">
            <i class="bi bi-arrow-clockwise me-2"></i> Try Again
        </a>
    </div>

<?php include __DIR__ . '/../partials/footer.php'; ?>