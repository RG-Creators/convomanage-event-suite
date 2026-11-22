<?php
session_start();
include('../includes/db_connect.php');

$conf_id = $_POST['conf_id'];
$user_id = $_SESSION['user_id'];
$message = trim($_POST['message']);

if ($message !== "") {
    // Check if user is authorized (joined the conference)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM conference_users WHERE conference_id = ? AND user_id = ?");
    $stmt->execute([$conf_id, $user_id]);

    if ($stmt->fetchColumn() > 0) {
        // Use session-based key
        $key = $_SESSION['conf_keys'][$conf_id] ?? null;

        if ($key) {
            // Encrypt using OpenSSL
            $cipher = "AES-128-CTR";
            $iv = random_bytes(openssl_cipher_iv_length($cipher));
            $encrypted = openssl_encrypt($message, $cipher, $key, 0, $iv);
            $iv_hex = bin2hex($iv);

            // Store encrypted message and IV
            $stmt = $pdo->prepare("INSERT INTO chat_messages (conference_id, user_id, message, iv) VALUES (?, ?, ?, ?)");
            $stmt->execute([$conf_id, $user_id, $encrypted, $iv_hex]);
        }
    }
}
