<?php include('../includes/db_connect.php'); session_start(); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if (isset($_POST['remember'])) {
            setcookie("email", $email, time() + (86400 * 30), "/");
        }

        header("Location: ../dashboard/" . ($user['role'] === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php'));
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ConvoManage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        input,
        button,
        select,
        textarea {
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 95%;
            max-width: 400px;
            animation: fadeIn 0.5s ease;
        }

        .login-form h2 {
            text-align: center;
            color: #4f46e5;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"]  {
            width: 95%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border 0.3s ease;
            font-size: 15px;
            height: 25px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"] :focus {
            border-color: #4f46e5;
            outline: none;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            color: #777;
            cursor: pointer;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4f46e5;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4338ca;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #4f46e5;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .form-remember {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
            text-align: center;
            font-weight: 500;
        }

        @keyframes fadeIn {
            from {
                transform: translateY(10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
            }
        
            button {
                padding: 10px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form method="post" class="login-form">
            <h2><i class="fas fa-comments"></i> ConvoManage Login</h2>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" id="email" value="<?= $_COOKIE['email'] ?? '' ?>" placeholder="Enter your email" required>
            </div>

            <div class="form-group password-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
            </div>

            <div class="form-remember">
                <label><input type="checkbox" name="remember" <?= isset($_COOKIE['email']) ? 'checked' : '' ?>> Remember Me</label>
            </div>

            <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>

            <p class="register-link">Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.querySelector(".toggle-password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
