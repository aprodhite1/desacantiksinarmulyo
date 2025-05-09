<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Desa Cantik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        color: #333;
        background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)),
            url('images/background.jpg');
        background-size: cover;
        background-position: center;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .login-container {
        max-width: 500px;
        margin: auto;
        padding: 2rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-top: 3rem;
        margin-bottom: 3rem;
        position: relative;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header img {
        height: 80px;
        margin-bottom: 1rem;
    }

    .login-header h2 {
        color: var(--secondary-color);
        font-weight: 600;
    }

    .form-control {
        padding: 12px 15px;
        border-radius: 5px;
        margin-bottom: 1.5rem;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .btn-login {
        background-color: var(--primary-color);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-weight: 500;
        width: 100%;
        transition: all 0.3s;
    }

    .btn-login:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    .btn-home {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--secondary-color);
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 15px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-home:hover {
        background-color: #1a252f;
        transform: translateY(-2px);
    }

    .forgot-password {
        text-align: center;
        margin-top: 1rem;
    }

    .forgot-password a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .alert {
        border-radius: 5px;
        margin-bottom: 1.5rem;
    }

    .footer {
        text-align: center;
        padding: 1rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .login-container {
            margin: 1.5rem;
            padding: 1.5rem;
        }

        .btn-home {
            position: static;
            margin-bottom: 1rem;
            width: 100%;
        }
    }
    </style>
</head>
<!-- Tombol Kembali ke Halaman Utama -->
<a href="index.html" class="btn btn-home">
    <i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama
</a>

<body>
    <div class="container">
        <div class="login-container">


            <div class="login-header">
                <img src="images/logo-descan.png" alt="Desa Cantik Logo">
                <h2>LOGIN SISTEM</h2>
                <p class="text-muted">Masukkan username dan password Anda</p>
            </div>

            <?php 
            if(isset($_GET['pesan'])) {
                echo '<div class="alert alert-' . 
                    ($_GET['pesan'] == 'gagal' ? 'danger' : 
                     ($_GET['pesan'] == 'logout' ? 'success' : 'warning')) . 
                    ' alert-dismissible fade show">';
                
                if($_GET['pesan'] == "gagal") {
                    echo '<i class="bi bi-exclamation-triangle-fill"></i> Login gagal! Username atau password salah!';
                } else if($_GET['pesan'] == "logout") {
                    echo '<i class="bi bi-check-circle-fill"></i> Anda telah berhasil logout';
                } else if($_GET['pesan'] == "belum_login") {
                    echo '<i class="bi bi-exclamation-circle-fill"></i> Anda harus login untuk mengakses halaman admin';
                }
                
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';
            }
            ?>

            <form action="log.php" method="post">
                <div class="mb-3">
                    <label for="uname" class="form-label">Username</label>
                    <input type="text" class="form-control" name="uname" id="uname" placeholder="Masukkan username"
                        required>
                </div>
                <div class="mb-4">
                    <label for="pswd" class="form-label">Password</label>
                    <input type="password" class="form-control" name="pswd" id="pswd" placeholder="Masukkan password"
                        required>
                </div>
                <button type="submit" class="btn btn-login">Login</button>

                <div class="forgot-password mt-3">
                    <a href="lupa-password.php">Lupa password?</a>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>© <?php echo date('Y'); ?> Sistem Desa Cantik - Kabupaten Ogan Komering Ulu Selatan</p>
        <p>Badan Pusat Statistik Kabupaten OKU Selatan</p>
    </footer>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Auto focus on username field when page loads
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('uname').focus();
    });
    </script>
</body>

</html>