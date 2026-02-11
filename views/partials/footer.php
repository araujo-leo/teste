</div>
<div class="mb-5"></div>
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    footer {
        background-color: #1e1e1e;
        border-top: 1px solid #333;
        padding: 20px 0;
        width: 100%;
        margin-top: auto;
    }

    footer a {
        color: #888;
        text-decoration: none;
        margin-left: 20px;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    footer a:hover {
        color: #FFE81F;
    }
</style>

<footer>
    <div class="container d-flex flex-wrap justify-content-between align-items-center">

        <div class="small">
            &copy; <?= date('Y'); ?> <strong>Star Wars Wiki</strong>.
        </div>

        <div>
            <a href="https://github.com/araujo-leo" target="_blank">GitHub</a>
        </div>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>