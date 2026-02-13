<?php include __DIR__ . '/../partials/header.php'; ?>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
        <form>
            <h2 class="mb-4">Login</h2>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>



    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            $.ajax({
                url: '/api/login',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ email, password }),
                success: function(response) {
                    if (response.success) {
                        localStorage.setItem('auth_token', response.token);
                        localStorage.setItem('user', JSON.stringify(response.user));
                        window.location.href = '/';
                    } else {
                        showToast(response.message || response.error);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Erro de conexão com o servidor.';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || response.error || errorMessage;
                    } catch (e) {
                        console.error("Erro ao processar JSON:", e);
                    }
                    showToast(errorMessage);
                }
            });
        });

        function showToast(message) {
            const toastElement = document.getElementById('errorToast');
            const messageElement = document.getElementById('toastMessage');

            if (toastElement && messageElement) {
                messageElement.textContent = message;
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            } else {
                console.error("Elementos do Toast não encontrados!");
                alert(message);
            }
        }
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>