<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include('../includes/db_connect.php');
include('../includes/header.php');

// Fetch current user to check role
$userStmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$userStmt->execute([$_SESSION['user_id']]);
$currentUser = $userStmt->fetch();

$stmt = $pdo->query("SELECT * FROM conferences ORDER BY start_time ASC");
$conferences = $stmt->fetchAll();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<main class="conference-container animate">
    <h2><i class="fas fa-calendar-alt"></i> Upcoming Conferences</h2>

    <?php if ($conferences): ?>
        <div class="conference-grid">
            <?php foreach ($conferences as $conf): ?>
                <div class="conference-card">
                    <h3><i class="fas fa-microphone"></i> <?= htmlspecialchars($conf['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($conf['description'])) ?></p>
                    <p class="time">
                        <i class="far fa-clock"></i>
                        <?= date("F j, Y, g:i A", strtotime($conf['start_time'])) ?> <br>
                        <?= date("F j, Y, g:i A", strtotime($conf['end_time'])) ?>
                    </p>

                    <?php if ($currentUser && $currentUser['role'] === 'admin'): ?>
                        <div class="admin-tools">
                            <div><i class="fas fa-key"></i> <strong>Join Code:</strong> <?= htmlspecialchars($conf['join_code']) ?></div>
                            <a href="edit.php?id=<?= $conf['id'] ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
                            <!-- <a href="delete.php?id=<?= $conf['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this conference?')"> -->
                            <a href="delete.php?id=<?= $conf['id'] ?>" class="delete-btn">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </div>
                    <?php endif; ?>

                    <a href="../chat/join.php?id=<?= $conf['id'] ?>" class="join-btn"><i class="fas fa-sign-in-alt"></i> Join Now</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-conf"><i class="fas fa-info-circle"></i> No conferences available at the moment.</p>
    <?php endif; ?>
</main>

<!-- Custom Styles -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 0;
    }

    .conference-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    h2 {
        font-size: 2rem;
        color: #003366;
        margin-bottom: 30px;
        text-align: center;
    }

    .conference-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }

    .conference-card {
        background-color: #fff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .conference-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .conference-card h3 {
        margin: 0 0 10px;
        color: #003366;
    }

    .conference-card p {
        margin: 10px 0;
        color: #444;
        font-size: 0.95rem;
    }

    .time {
        font-size: 0.9rem;
        color: #555;
    }

    .admin-tools {
        margin-top: 10px;
        font-size: 0.9rem;
        background: #f0f4ff;
        padding: 10px;
        border-radius: 8px;
        color: #003366;
    }

    .admin-tools a {
        display: inline-block;
        margin-right: 10px;
        font-size: 0.9rem;
        margin-top: 6px;
    }

    .edit-btn {
        color: #0066cc;
    }

    .delete-btn {
        color: #cc0000;
    }

    .join-btn {
        margin-top: 16px;
        padding: 10px 16px;
        background-color: #003366;
        color: white;
        border: none;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        font-size: 0.95rem;
        transition: background-color 0.3s ease;
    }

    .join-btn:hover {
        background-color: #0055aa;
    }

    .no-conf {
        text-align: center;
        font-size: 1rem;
        color: #777;
        margin-top: 40px;
    }

    /* Scroll Animation */
    .animate {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s ease;
    }

    .animate.visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 600px) {
        .conference-card {
            padding: 18px;
        }
        .conference-card h3 {
            font-size: 1.2rem;
        }
    }

    .conference-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr); /* Default: Mobile */
        gap: 24px;
    }

    @media (min-width: 600px) {
        .conference-grid {
            grid-template-columns: repeat(2, 1fr); /* Small laptops / tablets */
        }
    }

    @media (min-width: 992px) {
        .conference-grid {
            grid-template-columns: repeat(4, 1fr); /* Large laptops and desktops */
        }
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
        }, { threshold: 0.1 });

        document.querySelectorAll(".animate").forEach(el => observer.observe(el));
    });
</script>

<?php include('../includes/footer.php'); ?>
