<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
include('../includes/header.php');
?>

<main class="admin-dashboard">
    <section class="admin-welcome animate">
        <h2><i class="fas fa-user-shield"></i> Welcome, Admin!</h2>
        <p>Take full control over the conferences. You can create, manage, and monitor events seamlessly from here.</p>
        <p>Use the tools below to streamline your event management tasks with ease and efficiency.</p>
    </section>

    <section class="admin-actions animate">
        <a href="../conference/create.php" class="admin-btn">
            <i class="fas fa-plus-circle"></i> Create New Conference
        </a>
        <a href="../conference/view.php" class="admin-btn">
            <i class="fas fa-calendar-alt"></i> View All Conferences
        </a>
    </section>
</main>

<!-- Font Awesome (if not already included in header.php) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-vR1v7z+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Styling -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f3f6fc;
        margin: 0;
        padding: 0;
    }

    main.admin-dashboard {
        max-width: 960px;
        margin: 60px auto;
        padding: 20px;
    }

    .admin-welcome {
        background: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
        transition: all 0.6s ease;
    }

    .admin-welcome h2 {
        font-size: 1.8rem;
        color: #003366;
        margin-bottom: 10px;
    }

    .admin-welcome p {
        font-size: 1rem;
        color: #555;
        margin-top: 10px;
    }

    .admin-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .admin-btn {
        background: #003366;
        color: white;
        padding: 14px 28px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1rem;
        transition: background 0.3s ease, transform 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-btn:hover {
        background: #0055aa;
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

    @media (max-width: 768px) {
        .admin-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-btn {
            justify-content: center;
            font-size: 1rem;
        }
    }
</style>

<!-- Scroll Effect Script -->
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
