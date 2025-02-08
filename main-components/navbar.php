<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-navbar: #2563eb;
            --text: #1f2937;
            --bg: #ffffff;
            --shadow: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background: var(--bg);
            box-shadow: 0 2px 8px var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand img {
            width: 3em;
        }

        .brand-name {
            font-weight: bold;
            color: var(--text);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-primary-navbar {
            background: var(--primary-navbar);
            color: white;
        }

        #menu-toggle {
            display: none;
        }

        .menu-btn {
            display: none;
        }

        @media (max-width: 768px) {
            .menu-btn {
                display: block;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .nav-links {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background: var(--bg);
                padding: 2rem;
                flex-direction: column;
                transform: translateX(-100%);
                transition: 0.3s;
            }

            #menu-toggle:checked ~ .nav-links {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="brand">
                <img src="assets/images/logo-website.png" alt="PPDB Logo">
                <span class="brand-name">PPDB JABAR 2024</span>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-btn">☰</label>
            <div class="nav-links">
                <a href="./admin/dashboard-admin/dashboard-admin.php">Admin PPDB</a>
                <a href="./sekolah/auth/login-sekolah.php">Sekolah</a>
                <a href="#contact">Contact</a>
                <a href="dashboard/dashboard.php">Dashboard</a>
                <a href="auth/login.php">Login</a>
                <a href="auth/register.php" class="btn btn-primary-navbar">Register</a>
            </div>
        </nav>
    </header>
</body>
</html>