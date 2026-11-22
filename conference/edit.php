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
$stmt = $pdo->prepare("SELECT * FROM conferences WHERE id = ?");
$stmt->execute([$id]);
$conference = $stmt->fetch();

if (!$conference) {
    echo "Conference not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $updateStmt = $pdo->prepare("UPDATE conferences SET title = ?, description = ?, start_time = ?, end_time = ? WHERE id = ?");
    $updateStmt->execute([$title, $description, $start_time, $end_time, $id]);

    header("Location: view.php?updated=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Conference</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .edit-container {
            max-width: 1200px;
            width: 95%;
            margin: 20px auto;
            padding: 40px 60px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
            animation: fadeIn 0.5s ease-in-out;
        }

        .edit-container h2 {
            margin-bottom: 25px;
            color: #1a237e;
            font-size: 2rem;
            border-left: 5px solid #1a237e;
            padding-left: 15px;
        }

        .edit-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 40px;
        }

        .edit-form .form-group {
            display: flex;
            flex-direction: column;
        }

        .edit-form label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .edit-form input[type="text"],
        .edit-form input[type="datetime-local"],
        .edit-form textarea {
            padding: 12px 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border 0.3s ease;
        }

        .edit-form textarea {
            resize: vertical;
            min-height: 100px;
            max-height: 200px;
        }

        .edit-form input:focus,
        .edit-form textarea:focus {
            border-color: #1a237e;
            outline: none;
        }

        .edit-form .full-width {
            grid-column: span 2;
        }

        .update-btn {
            background: #1a237e;
            color: #fff;
            padding: 14px 26px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease, transform 0.2s ease;
            width: fit-content;
        }

        .update-btn:hover {
            background: #3949ab;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .edit-form {
                grid-template-columns: 1fr;
            }

            .edit-form .full-width {
                grid-column: span 1;
            }

            .edit-container {
                padding: 25px 20px;
            }

            .update-btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<?php include('../includes/header.php'); ?>

<div class="edit-container">
    <h2><i class="fas fa-pen-to-square"></i> Edit Conference</h2>

    <form method="POST" class="edit-form">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($conference['title']) ?>" required>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" name="start_time" value="<?= date('Y-m-d\TH:i', strtotime($conference['start_time'])) ?>" required>
        </div>

        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="datetime-local" name="end_time" value="<?= date('Y-m-d\TH:i', strtotime($conference['end_time'])) ?>" required>
        </div>

        <div class="form-group full-width">
            <label for="description">Description</label>
            <textarea name="description" required><?= htmlspecialchars($conference['description']) ?></textarea>
        </div>

        <div class="form-group full-width">
            <button type="submit" class="update-btn"><i class="fas fa-save"></i> Update Conference</button>
        </div>
    </form>
</div>

<?php include('../includes/footer.php'); ?>

</body>
</html>
