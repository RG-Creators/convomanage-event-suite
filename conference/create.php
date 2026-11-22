<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db_connect.php');
include('../includes/header.php');

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $desc = htmlspecialchars($_POST['description']);
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $created_by = $_SESSION['user_id'];

    // Generate secure 16-byte (128-bit) AES key
    $raw_key = random_bytes(16); // 128-bit
    $encoded_key = base64_encode($raw_key); // Optional encoding for safe DB storage

    // Generate unique 6-character join code
    $join_code = strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6));

    $stmt = $pdo->prepare("INSERT INTO conferences (title, description, start_time, end_time, created_by, join_code, enc_key)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt->execute([$title, $desc, $start, $end, $created_by, $join_code, $encoded_key])) {
        $success = "Conference created successfully!";
    } else {
        $error = "Error creating conference. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Create Room</title>
</head>
<body>
    <main class="create-conference animate">
        <h2><i class="fas fa-plus-circle"></i> Create New Conference</h2>

        <?php if ($success): ?>
            <div class="success-msg"><i class="fas fa-check-circle"></i> <?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="error-msg"><i class="fas fa-exclamation-triangle"></i> <?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="conf-form">
            <label><i class="fas fa-heading"></i> Conference Title</label>
            <input type="text" name="title" placeholder="Enter title..." required>

            <label><i class="fas fa-align-left"></i> Description</label>
            <textarea name="description" rows="4" placeholder="Brief description..." required></textarea>

            <div class="datetime-group">
                <div>
                    <label><i class="fas fa-clock"></i> Start Time</label>
                    <input type="datetime-local" name="start_time" required>
                </div>
                <div>
                    <label><i class="fas fa-hourglass-end"></i> End Time</label>
                    <input type="datetime-local" name="end_time" required>
                </div>
            </div>

            <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Create Conference</button>
        </form>
    </main>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fbff;
            margin: 0;
            padding: 0;
        }

        .create-conference {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .create-conference h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        .success-msg, .error-msg {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .success-msg {
            background-color: #e6fff2;
            color: #007a3d;
            border: 1px solid #b4f3d1;
        }

        .error-msg {
            background-color: #ffe6e6;
            color: #cc0000;
            border: 1px solid #f5b5b5;
        }

        .conf-form label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #003366;
        }

        .conf-form input, .conf-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccd6e0;
            border-radius: 8px;
            transition: border-color 0.3s ease;
            font-size: 1rem;
        }

        .conf-form input:focus, .conf-form textarea:focus {
            border-color: #0077cc;
            outline: none;
        }

        .datetime-group {
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }

        .datetime-group div {
            flex: 1;
        }

        .submit-btn {
            background-color: #003366;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #0055aa;
        }

        /* Scroll animation */
        .animate {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.6s ease-in-out;
        }

        .animate.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 600px) {
            .datetime-group {
                flex-direction: column;
            }
        }
    </style>

    <!-- Scroll Reveal Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const section = document.querySelector('.animate');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                    }
                });
            }, { threshold: 0.1 });
            observer.observe(section);
        });
    </script>

    <?php include('../includes/footer.php'); ?>
    
</body>
</html>

