<?php include('../includes/db_connect.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['full_name']);
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $pass])) {
        header("Location: login.php?success=1");
        exit();
    } else {
        $error = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ConvoManage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        input,
        button,
        select,
        textarea {
            font-family: 'Poppins', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .register-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 400px;
            animation: fadeIn 0.5s ease;
        }

        .register-container h2 {
            text-align: center;
            color: #4f46e5;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: #4f46e5;
            outline: none;
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

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .login-link a {
            color: #4f46e5;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
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
    </style>
</head>
<body>

<div class="register-container">
    <h2><i class="fas fa-user-plus"></i> Create Account</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="full_name"><i class="fas fa-user"></i> Full Name</label>
            <input type="text" name="full_name" id="full_name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" id="password" placeholder="Create a password" required>
        </div>

        <button type="submit"><i class="fas fa-user-check"></i> Register</button>
    </form>

    <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
