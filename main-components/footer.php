<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* footer styling */
        footer {
            margin-top: 2em;
            background-color: #f4f4f4;
            padding: 2rem 1rem;
            text-align: center;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
        }

        .footer-section h3 {
            color: #333;
            margin-bottom: 1rem;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-links a {
            color: #666;
            font-size: 1.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: #000;
        }

        .footer-bottom {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 0.9rem;
        }

        @media (max-width: 600px) {
            .footer-content {
                flex-direction: column;
                align-items: center;
            }

            .footer-section {
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Email: carlosimbolon23@gmail.com</p>
                <p>Phone: +62 0859-4796-1197</p>
            </div>
            <div class="footer-section">
                <h3>Follow me</h3>
                <div class="social-links">
                    <a href="https://github.com/gitHUBmichael20" aria-label="github"><i
                            class="fa-brands fa-github"></i></a>
                    <a href="https://www.instagram.com/michaell_carlo/" aria-label="instagram"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/in/carlo-simbolon-301704267/" aria-label="LinkedIn"><i
                            class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 November. Tugas Database Basis Data.</p>
        </div>
    </footer>
</body>

</html>