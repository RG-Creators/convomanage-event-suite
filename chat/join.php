<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db_connect.php');

// Support direct link joining via ?id=... from conference list
if (isset($_GET['id'])) {
    $conf_id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT id, enc_key FROM conferences WHERE id = ?");
    $stmt->execute([$conf_id]);
    $conf = $stmt->fetch();

    if ($conf) {
        $user_id = $_SESSION['user_id'];
        $check = $pdo->prepare("SELECT COUNT(*) FROM conference_users WHERE conference_id = ? AND user_id = ?");
        $check->execute([$conf_id, $user_id]);

        if ($check->fetchColumn() == 0) {
            $insert = $pdo->prepare("INSERT INTO conference_users (conference_id, user_id) VALUES (?, ?)");
            $insert->execute([$conf_id, $user_id]);
        }

        $_SESSION['conf_keys'][$conf['id']] = $conf['enc_key'];
        header("Location: room.php?conf_id=" . $conf['id']);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = strtoupper(trim($_POST['join_code'] ?? ''));
    $stmt = $pdo->prepare("SELECT id, enc_key FROM conferences WHERE join_code = ?");
    $stmt->execute([$code]);
    $conf = $stmt->fetch();

    if ($conf) {
        $conf_id = $conf['id'];
        $user_id = $_SESSION['user_id'];

        // Check if user already joined
        $check = $pdo->prepare("SELECT COUNT(*) FROM conference_users WHERE conference_id = ? AND user_id = ?");
        $check->execute([$conf_id, $user_id]);

        if ($check->fetchColumn() == 0) {
            $insert = $pdo->prepare("INSERT INTO conference_users (conference_id, user_id) VALUES (?, ?)");
            $insert->execute([$conf_id, $user_id]);
        }

        $_SESSION['conf_keys'][$conf['id']] = $conf['enc_key'];
        header("Location: room.php?conf_id=" . $conf['id']);
        exit();
    } else {
        $error = "Invalid join code!";
    }
}

include('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Room - ConvoManage</title>
</head>
<body>

    <style>
    .join-container {
        max-width: 500px;
        margin: 60px auto;
        padding: 30px;
        background-color: #f9fafb;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        text-align: center;
        animation: fadeIn 0.5s ease-in-out;
    }

    .join-container h2 {
        margin-bottom: 20px;
        font-size: 1.8rem;
        color: #333;
    }

    .join-container form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .join-container input[type="text"] {
        padding: 14px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
        transition: border 0.3s;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
    }

    .join-container input[type="text"]:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
    }

    .join-container button {
        padding: 12px;
        font-size: 1rem;
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .join-container button:hover {
        background-color: #3730a3;
    }

    .error-message {
        color: #e11d48;
        margin-top: 10px;
        font-weight: 500;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 600px) {
        .join-container {
            margin: 20px;
            padding: 20px;
        }
    }
    </style>

    <div class="join-container">
        <h2>Join Conference Chat</h2>
        <form method="POST">
            <input type="text" name="join_code" maxlength="6" required placeholder="ENTER 6-DIGIT CODE">
            <button type="submit">Join Conference</button>
        </form>
        <?php if (!empty($error)) echo "<div class='error-message'>" . htmlspecialchars($error) . "</div>"; ?>
    </div>

    <script src="../assets/js/script.js"></script>
    <?php include('../includes/footer.php'); ?>

</body>
</html>
