<?php
session_start();

// Process login if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['uname'] ?? '';
    $password = $_POST['pswd'] ?? '';
    
    // Validate credentials (admin/admin4321)
    if ($username === 'admin' && $password === 'admin4321') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        echo "<script>window.top.location.href = 'admin.php';</script>";
        exit;
    } else {
        echo "<script>document.getElementById('errorMessage').style.display = 'block';</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <style>
    .login-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box {
        background: white;
        padding: 30px;
        border-radius: 8px;
        width: 90%;
        max-width: 400px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #888;
    }

    .login-form input {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .login-form button {
        width: 100%;
        padding: 12px;
        background: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .error-message {
        color: red;
        display: none;
        margin-bottom: 15px;
    }
    </style>
</head>

<body>
    <div id="loginPopup" class="login-popup">
        <div class="login-box">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h3>Login Admin</h3>

            <div id="errorMessage" class="error-message">
                Username atau password salah!
            </div>

            <form method="post" class="login-form" onsubmit="return submitForm(this)">
                <input type="text" name="uname" placeholder="Username" required>
                <input type="password" name="pswd" placeholder="Password" required>
                <button type="submit">MASUK</button>
            </form>
        </div>
    </div>

    <script>
    function closePopup() {
        document.getElementById('loginPopup').style.display = 'none';
    }

    function submitForm(form) {
        fetch('login-popup.php', {
                method: 'POST',
                body: new FormData(form)
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('popupContainer').innerHTML = html;
            });
        return false;
    }

    // Close when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('loginPopup')) {
            closePopup();
        }
    });
    </script>
</body>

</html>