<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-vR1v7z+G9N+ezuv4zCEoKsR+6MgxM2Yv+XzFvblAr9zU0W4UZbTz8CecLz9AHJ0gRcoD8M4DjDyp9YtLQ4bMhw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body>
    <!-- Font Awesome for Social Icons -->
        <!-- This made and designed by RG  -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-left">
            <h2>ConvoManage</h2>
            <p class="tagline">Empowering Conferences, Simplifying Management.</p>
            </div>
        
            <div class="footer-center">
            <p>&copy; 2025 ConvoManage. All rights reserved.</p>
            </div>
        
            <div class="footer-right">
            <a href="#" class="social" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="social" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f2f6fa;
        }

        .footer {
            background: #1c1f26;
            color: #bbb;
            padding: 30px 20px;
            margin-top: auto;
            animation: fadeInUp 0.8s ease;
            transition: all 0.4s ease-in-out;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-left h2 {
            font-size: 1.6rem;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .footer-left .tagline {
            font-size: 0.95rem;
            color: #aaa;
        }

        .footer-center p {
            font-size: 0.9rem;
            color: #999;
        }

        .footer-right {
            display: flex;
            gap: 15px;
        }

        .social {
            font-size: 1rem;
            color: #fff;
            background: #2a2f3a;
            padding: 10px;
            border-radius: 50%;
            transition: background 0.3s ease, transform 0.3s ease;
            text-align: center;
        }

        .social:hover {
            background: #3c4455;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .footer-left, .footer-center, .footer-right {
                width: 100%;
            }

            .footer-left h2 {
                font-size: 1.4rem;
            }

            .social {
                padding: 8px;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</body>
</html>