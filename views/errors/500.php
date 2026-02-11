<?php include __DIR__ . '/../partials/header.php'; ?>

    <style>
        body {
            background-color: #0d0d0d;
            color: #fff;
        }

        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #721c24;
            text-shadow: 2px 2px #dc3545;
        }

        .btn-retry {
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-retry:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>

    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
        <h1 class="error-code">500</h1>
        <h2 class="text-danger mb-4">System Failure</h2>


        <p class="text-danger text-center" style="max-width: 500px;">
            I felt a great disturbance in the Force. Our servers are having trouble handling the request. The engineering droids have been notified.
        </p>

        <?php if (isset($error) && $_ENV['APP_DEBUG'] === 'true'): ?>
            <div class="alert alert-dark border-danger text-danger mt-3 w-75 overflow-auto">
                <strong>Debug Info:</strong><br>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <a href="/" class="btn btn-retry px-5 py-2 mt-3 fw-bold">Try Again</a>
    </div>

<?php include __DIR__ . '/../partials/footer.php'; ?>