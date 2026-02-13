</div>

<style>
    footer {
        background-color: #f8f9fa;
        border-top: 2px solid #dee2e6;
        padding: 30px 0;
        width: 100%;
        margin-top: 50px;
    }

    footer a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s;
    }

    footer a:hover {
        color: #0d6efd;
    }

    footer .text-muted {
        color: #6c757d !important;
    }

    footer strong {
        color: #495057;
    }

    .footer-links {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .footer-links {
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }
    }
</style>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="text-muted mb-0">
                    &copy; <?= date('Y'); ?> <strong>Sistema de Gerenciamento</strong>
                </p>
                <small class="text-muted">
                    Gestão de Produtos e Fornecedores | Time Comercial
                </small>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <div class="footer-links justify-content-center justify-content-md-end">
                    <a href="https://github.com/araujo-leo" target="_blank">
                        <i class="bi bi-github"></i> GitHub
                    </a>
                    <span class="text-muted">|</span>
                    <a href="/docs" class="text-muted">
                        <i class="bi bi-file-text"></i> Documentação
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Verificar se há token JWT no localStorage
    const token = localStorage.getItem('jwt_token');
    const userName = localStorage.getItem('user_name');
    const isAdmin = localStorage.getItem('is_admin');

    if (token) {
        $('#loginBtn').hide();
        $('#userDropdown').show();

        if (userName) {
            let userDisplay = userName;
            if (isAdmin === '1') {
                userDisplay += ' <span class="badge-admin">ADMIN</span>';
            }
            $('#userName').html(userDisplay);
        }
    } else {
        $('#loginBtn').show();
        $('#userDropdown').hide();
    }

    // Logout
    $('#logoutBtn').on('click', function(e) {
        e.preventDefault();
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('user_name');
        localStorage.removeItem('is_admin');
        window.location.href = '/login';
    });

    // Função global para fazer requisições com JWT
    window.apiRequest = function(url, options = {}) {
        const token = localStorage.getItem('jwt_token');

        if (!options.headers) {
            options.headers = {};
        }

        if (token) {
            options.headers['Authorization'] = 'Bearer ' + token;
        }

        options.headers['Content-Type'] = 'application/json';

        return $.ajax({
            url: url,
            ...options,
            error: function(xhr) {
                if (xhr.status === 401) {
                    localStorage.removeItem('jwt_token');
                    localStorage.removeItem('user_name');
                    localStorage.removeItem('is_admin');
                    window.location.href = '/login';
                }
            }
        });
    };

    // Função global para exibir alertas
    window.showAlert = function(message, type = 'success') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        const alertContainer = $('#alertContainer');
        if (alertContainer.length) {
            alertContainer.html(alertHtml);
        } else {
            $('.main-content').prepend('<div id="alertContainer">' + alertHtml + '</div>');
        }

        // Auto dismiss após 5 segundos
        setTimeout(() => {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    };
</script>

</body>
</html>