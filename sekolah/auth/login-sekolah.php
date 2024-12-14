<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekolah Login</title>
    <link rel="shortcut icon" href="../../assets/images/logo-website.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/login-sekolah.css">
</head>

<body>
    <div class="login-container">
        <div class="website-title">
            <img class="logo-web" src="../../assets/images/logo-website.png" alt="logo-website">
            <h2 class="login-title">Login to Continue</h2>
        </div>
        <form method="POST">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-input" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" class="form-input" placeholder="Enter your password">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                        👁️
                    </button>
                </div>
            </div>
            <button type="submit" class="submit-btn">Sign In</button>
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordType = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = passwordType;
        }
    </script>
</body>

</html>