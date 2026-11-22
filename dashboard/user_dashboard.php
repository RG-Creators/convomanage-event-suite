<?php
require_once '../includes/db_connect.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: ../auth/login.php");
    exit();
}
include('../includes/header.php');

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$full_name = $user ? htmlspecialchars($user['full_name']) : 'User';
?>

<!-- Main Dashboard Content -->
<main class="user-dashboard">
    <section class="welcome-section animate">
        <h2><i class="fas fa-user-circle"></i> Welcome, <?= $full_name ?>!</h2>
        <p>We’re glad to have you on ConvoManage — your space to explore, register, and engage with the latest conferences tailored for you.</p>
        <p>From tech innovations to creative minds, discover events that inspire your growth and connect you with communities that matter.</p>
    </section>

    <section class="action-section animate">
        <a href="../conference/view.php" class="view-btn">
            <i class="fas fa-calendar-alt"></i> View Upcoming Conferences
        </a>
    </section>
</main>

<!-- Font Awesome CDN (ensure it's loaded once per page) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-vR1v7z+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Custom Styling -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f2f6fa;
        margin: 0;
        padding: 0;
    }

    main.user-dashboard {
        max-width: 960px;
        margin: 0 auto; /* This sets top & bottom margin to 0, left & right to auto */
        padding: 20px;
        animation: fadeIn 1s ease-in-out;
    }
    
    .welcome-section {
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        transition: all 0.6s ease;
    }

    .welcome-section h2 {
        font-size: 1.8rem;
        color: #004080;
        margin-bottom: 10px;
    }

    .welcome-section p {
        font-size: 1rem;
        color: #444;
        margin-top: 10px;
    }

    .action-section {
        text-align: center;
        transition: all 0.5s ease;
    }

    .view-btn {
        display: inline-block;
        background: #004080;
        color: #fff;
        padding: 14px 28px;
        border-radius: 8px;
        font-size: 1rem;
        text-decoration: none;
        transition: background 0.3s, transform 0.3s;
    }

    .view-btn i {
        margin-right: 10px;
    }

    .view-btn:hover {
        background: #0059b3;
        transform: translateY(-3px);
    }

    .animate {
        opacity: 0;
        transform: translateY(40px);
    }

    .animate.visible {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease;
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

    @media (max-width: 768px) {
        main.user-dashboard {
            padding: 15px;
        }

        .view-btn {
            width: 100%;
            font-size: 1rem;
        }
    }
</style>

<!-- Scroll Animation Script -->
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

        document.querySelectorAll(".animate").forEach(section => {
            observer.observe(section);
        });
    });
</script>

<?php include('../includes/footer.php'); ?>
