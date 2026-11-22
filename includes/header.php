<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConvoManage</title>
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, #f8fbff, #e6efff);
            color: #333;
            transition: all 0.3s ease-in-out;
            min-height: 100vh;
        }

        header {
            background: #ffffff;
            padding: 15px 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            animation: fadeInDown 0.8s ease;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #004080;
        }

        nav {
            display: flex;
            gap: 25px;
        }

        nav a {
            text-decoration: none;
            color: #004080;
            font-size: 1rem;
            font-weight: 500;
            background-color: #f0f8ff;
            padding: 8px 14px;
            border-radius: 8px;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        nav a:hover {
            background-color: #d0e7ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }

            nav {
                margin-top: 10px;
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 10px;
            }

            nav a {
                padding: 10px;
                width: auto;
            }

            header h1 {
                font-size: 1.5rem;
                margin-bottom: 5px;
            }
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<header>
    <h1>ConvoManage</h1>
    <nav>
        <a href="../dashboard/<?php echo $_SESSION['role'] == 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>">Home</a>
        <a href="../conference/view.php">Conferences</a>
        <a href="../chat/join.php">Join Now</a>
        <a href="../dashboard/profile.php">Profile</a>
        <a href="../auth/logout.php">Logout</a>
    </nav>
</header>
<!-- <hr> -->

<!-- Optional: JS Enhancements -->
<script>
    document.querySelectorAll("nav a").forEach(link => {
        link.addEventListener("mouseenter", () => {
            link.style.boxShadow = "0 4px 10px rgba(0,0,0,0.12)";
        });
        link.addEventListener("mouseleave", () => {
            link.style.boxShadow = "none";
        });
    });
</script>
</body>
</html>
