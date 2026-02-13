<?php include __DIR__ . '/../partials/header.php'; ?>

    <style>
        body {
            background-color: white;
            color: #fff;
        }

        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: #333;
            text-shadow: 2px 2px #FFE81F;
        }

        .btn-home {
            border: 2px solid #FFE81F;
            color: #FFE81F;
        }

        .btn-home:hover {
            background-color: #FFE81F;
            color: #000;
        }
    </style>

    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
        <h1 class="error-code">404</h1>
        <h2 class="text-warning mb-4">Page Not Found</h2>


        <p class="text-white text-center" style="max-width: 500px;">
            These are not the droids you are looking for. The coordinates you entered seem to be incorrect or the system has been purged by the Empire.
        </p>

        <a href="/" class="btn btn-home px-5 py-2 mt-3 fw-bold">Return to Base</a>
    </div>

<?php include __DIR__ . '/../partials/footer.php'; ?>