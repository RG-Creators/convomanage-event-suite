<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../includes/db_connect.php';

// Fetch user info
$stmt = $pdo->prepare("SELECT full_name, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$success = '';
$error = '';

// Handle password update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    // Fetch current hashed password
    $passStmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $passStmt->execute([$_SESSION['user_id']]);
    $row = $passStmt->fetch();

    if (!password_verify($current, $row['password'])) {
        $error = "Current password is incorrect.";
    } elseif ($new !== $confirm) {
        $error = "New passwords do not match.";
    } elseif (strlen($new) < 6) {
        $error = "New password must be at least 6 characters.";
    } else {
        // Hash and update new password
        $newHashed = password_hash($new, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->execute([$newHashed, $_SESSION['user_id']]);
        $success = "Password updated successfully!";
    }
}
?>

<?php include('../includes/header.php'); ?>

<main class="profile-container animate">
    <section class="profile-info">
        <h2><i class="fas fa-user-circle"></i> My Profile</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </section>

    <hr>

    <section class="password-change">
        <h3><i class="fas fa-lock"></i> Change Password</h3>

        <?php if ($success): ?>
            <p class="alert success"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="alert error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" class="password-form">
            <label>Current Password:</label>
            <input type="password" name="current_password" required>

            <label>New Password:</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password:</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Update Password</button>
        </form>
    </section>
</main>

<!-- Font Awesome (only if not already in header) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Styles -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    main.profile-container {
        width: 100%;
        max-width: 1200px;
        margin: 60px auto;
        background: #fff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
        transition: all 0.6s ease;
    }

    h2, h3 {
        color: #003366;
        margin-bottom: 20px;
    }

    p {
        font-size: 1rem;
        color: #444;
    }

    .password-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .password-form label {
        font-weight: 500;
        margin-bottom: 4px;
        color: #333;
    }

    .password-form input {
        padding: 10px 14px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: border-color 0.3s ease;
    }

    .password-form input:focus {
        border-color: #0055aa;
        outline: none;
    }

    .password-form button {
        background-color: #003366;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .password-form button:hover {
        background-color: #0055aa;
        transform: translateY(-2px);
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .alert.success {
        background-color: #e6f9ec;
        color: #2d7a46;
    }

    .alert.error {
        background-color: #ffecec;
        color: #c0392b;
    }

    hr {
        margin: 40px 0;
        border: 0;
        border-top: 1px solid #ddd;
    }

    @media (max-width: 768px) {
        main.profile-container {
            margin: 5px;
            padding: 20px;
        }
    }

    /* Scroll Animation */
    .animate {
        opacity: 0;
        transform: translateY(40px);
    }

    .animate.visible {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease;
    }
</style>

<!-- Scroll Reveal Script -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        document.querySelectorAll(".animate").forEach(el => observer.observe(el));
    });
</script>

<?php include('../includes/footer.php'); ?>
