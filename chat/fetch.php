<?php
session_start();
include('../includes/db_connect.php');

$conf_id = $_POST['conf_id'];
$last_id = isset($_POST['last_id']) ? intval($_POST['last_id']) : 0;
$user_id = $_SESSION['user_id'];

// Check access
$check = $pdo->prepare("SELECT COUNT(*) FROM conference_users WHERE conference_id = ? AND user_id = ?");
$check->execute([$conf_id, $user_id]);

if ($check->fetchColumn() == 0) {
    echo json_encode(['error' => 'Access Denied']);
    exit;
}

// Get encryption key from session
$key = $_SESSION['conf_keys'][$conf_id] ?? null;
if (!$key) {
    echo json_encode(['error' => 'Missing key']);
    exit;
}

$stmt = $pdo->prepare("SELECT chat_messages.*, users.full_name 
    FROM chat_messages 
    JOIN users ON chat_messages.user_id = users.id 
    WHERE conference_id = ? AND chat_messages.id > ?
    ORDER BY timestamp ASC");
$stmt->execute([$conf_id, $last_id]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [];

foreach ($chats as $chat) {
    $cipher = "AES-128-CTR";
    $iv = hex2bin($chat['iv']);
    $decrypted_message = openssl_decrypt($chat['message'], $cipher, $key, 0, $iv);

    $response[] = [
        'id' => $chat['id'],
        'user_id' => $chat['user_id'],
        'full_name' => htmlspecialchars($chat['full_name']),
        'message' => htmlspecialchars($decrypted_message),
        'time' => date("H:i", strtotime($chat['timestamp']))
    ];
}

echo json_encode($response);
