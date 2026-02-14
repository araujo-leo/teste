<?php include __DIR__ . '/../partials/header.php'; ?>
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
                        showToast('false', 'response');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Erro de conexão com o servidor.';
                    try {
                        errorMessage = JSON.stringify(xhr.responseJSON.error).replace(/"/g, "");
                    } catch (e) {
                        console.error("Erro ao processar JSON:", e);
                    }
                    showToast(false, errorMessage);
                }
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>