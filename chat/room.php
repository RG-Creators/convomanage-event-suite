<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../auth/login.php");

include('../includes/db_connect.php');
include('../includes/header.php');

$conf_id = $_GET['conf_id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM conferences WHERE id = ?");
$stmt->execute([$conf_id]);
$conf = $stmt->fetch();

if (!$conf) {
    echo "<p>Conference not found.</p>";
    exit();
}
?>

<style>

.chat-message {
    background-color: #f4f6f8;
    padding: 14px 18px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.3s ease, background-color 0.3s ease;
    max-width: 75%;
    margin-bottom: 10px;
}

.chat-message.self {
    align-self: flex-end;
    background-color: #4f46e5;
    color: white;
}

.chat-message.other {
    align-self: flex-start;
}

.chat-message:hover {
    transform: translateY(-2px);
    background-color: #e8edf1;
}

.chat-left {
    font-weight: 500;
}

.chat-text {
    margin-left: 6px;
}

.chat-time {
    font-size: 0.85rem;
    margin-left: 12px;
    white-space: nowrap;
}

#chat-box {
    display: flex;
    flex-direction: column;
}

    .chat-container {
    width: 95%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
}

.chat-title {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.chat-box {
    height: 400px; /* Increased from 500px */
    overflow-y: auto;
    border: 1px solid #ccc;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 8px;
    margin-bottom: 20px;
    scrollbar-width: none; /* Firefox */
}

/* Optional: Hide scrollbar for WebKit browsers */
.chat-box::-webkit-scrollbar {
    display: none;
}

.chat-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.chat-input {
    flex: 1;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
    min-width: 0;
    margin-bottom: 20px;
}

.chat-send-btn {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #4f46e5;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 20px;
}

</style>
<!-- <h2>Chat Room: <?= htmlspecialchars($conf['title']) ?> (<?= $conf['join_code'] ?>)</h2> -->
<div class="chat-container">
    <h2 class="chat-title">
        Chat Room: <?= htmlspecialchars($conf['title']) ?>
    </h2>

    <div id="chat-box" class="chat-box"></div>

    <form id="chat-form" class="chat-form">
        <input type="hidden" name="conf_id" value="<?= $conf['id'] ?>">

        <input type="text" name="message" id="msg" class="chat-input" placeholder="Type your message..." required>

        <button type="submit" class="chat-send-btn">Send</button>
    </form>
</div>

<script src="../assets/js/jquery.min.js"></script>

<script src="../assets/js/jquery.min.js"></script>
<script>
let lastMessageId = 0;

function isAtBottom(el) {
    return el.scrollHeight - el.scrollTop <= el.clientHeight + 50;
}

function appendMessage(msg) {
    const alignment = msg.user_id == <?= $_SESSION['user_id'] ?> ? 'self' : 'other';

    const div = document.createElement('div');
    div.className = `chat-message ${alignment}`;
    div.innerHTML = `
        <div>
            <span class="chat-left">${msg.full_name}:</span>
            <span class="chat-text">${msg.message}</span>
        </div>
        <span class="chat-time">${msg.time}</span>
    `;

    return div;
}

function fetchMessages() {
    $.post('fetch.php', {
        conf_id: <?= $conf['id'] ?>,
        last_id: lastMessageId
    }, function(data) {
        const messages = JSON.parse(data);
        const chatBox = document.getElementById('chat-box');
        const stayAtBottom = isAtBottom(chatBox);

        messages.forEach(msg => {
            const msgDiv = appendMessage(msg);
            chatBox.appendChild(msgDiv);
            lastMessageId = msg.id;
        });

        if (stayAtBottom && messages.length > 0) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
}

$('#chat-form').on('submit', function(e){
    e.preventDefault();
    $.post('send.php', $(this).serialize(), function(){
        $('#msg').val('');
        fetchMessages();  // Append new message immediately
    });
});

setInterval(fetchMessages, 2000);
fetchMessages();
</script>


<?php include('../includes/footer.php'); ?>
