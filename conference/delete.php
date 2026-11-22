<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../includes/db_connect.php';

if (!isset($_GET['id'])) {
    echo "Conference ID not provided.";
    exit();
}

$id = $_GET['id'];

// Check if conference exists
$stmt = $pdo->prepare("SELECT * FROM conferences WHERE id = ?");
$stmt->execute([$id]);
$conference = $stmt->fetch();

if (!$conference) {
    echo "Conference not found.";
    exit();
}

// Handle confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete related chat messages (if any)
    $pdo->prepare("DELETE FROM chat_messages WHERE conference_id = ?")->execute([$id]);

    // Delete conference
    $pdo->prepare("DELETE FROM conferences WHERE id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM conference_users WHERE conference_id = ?")->execute([$id]);

    header("Location: view.php?deleted=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="delete-container animate">
        <h2><i class="fas fa-trash-alt"></i> Delete Conference</h2>
        <p>Are you sure you want to permanently delete the conference titled:</p>
        <h3>"<?= htmlspecialchars($conference['title']) ?>"</h3>

        <form method="POST" class="confirm-form">
            <button type="submit" class="btn-delete">Yes, Delete</button>
            <a href="view.php" class="btn-cancel">Cancel</a>
        </form>
    </div>

    <!-- Font Awesome (if not already included) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .delete-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.5s ease-in-out;
        }

        .delete-container h2 {
            color: #d93025;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .delete-container h3 {
            color: #111;
            font-size: 1.4rem;
            margin: 20px 0;
        }

        .delete-container p {
            color: #333;
            font-size: 1rem;
        }

        .confirm-form {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-delete {
            background-color: #d93025;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #b71c1c;
        }

        .btn-cancel {
            background-color: #f0f0f0;
            color: #333;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
        }

        /* Animation */
        .animate {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            .delete-container {
                margin: 30px 16px;
                padding: 24px;
            }

            .btn-delete,
            .btn-cancel {
                width: 100%;
                padding: 14px;
            }

            .confirm-form {
                flex-direction: column;
                gap: 14px;
            }
        }
    </style>

    <?php include('../includes/footer.php'); ?>

</body>
</html>