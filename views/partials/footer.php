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
                    &copy; <?= date('Y'); ?> <strong>Management System</strong>
                </p>
                <small class="text-muted">
                    Product & Supplier Management | Commercial Team
                </small>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <div class="footer-links justify-content-center justify-content-md-end">
                    <a href="https://github.com/araujo-leo" target="_blank">
                        <i class="bi bi-github"></i> GitHub
                    </a>
                    <span class="text-muted">|</span>
                    <a href="/docs" class="text-muted">
                        <i class="bi bi-file-text"></i> Documentation
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const token = localStorage.getItem('auth_token');
    const userJson = localStorage.getItem('user');

    if (token && userJson) {
        const user = JSON.parse(userJson);
        $('#loginBtnNav').hide();
        $('#userDropdown').show();

        if (user.name) {
            let userDisplay = user.name;
            if (user.isAdmin == 1) {
                userDisplay += ' <span class="badge-admin">ADMIN</span>';
            }
            $('#userNameDisplay').html(userDisplay);
        }
    } else {
        $('#loginBtnNav').show();
        $('#userDropdown').hide();
    }

    $('#logoutBtn').on('click', function(e) {
        e.preventDefault();
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
        window.location.href = '/login';
    });

    window.apiRequest = function(url, options = {}) {
        const token = localStorage.getItem('auth_token');

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
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user');
                    window.location.href = '/login';
                }
            }
        });
    };

    window.showAlert = function(message, type = 'success') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-alert="alert"></button>
            </div>
        `;

        const alertContainer = $('#alertContainer');
        if (alertContainer.length) {
            alertContainer.html(alertHtml);
        } else {
            $('.main-content').prepend('<div id="alertContainer">' + alertHtml + '</div>');
        }

        setTimeout(() => {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    };
</script>

</body>
</html>