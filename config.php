<?php
// ConvoManage Global Configuration
if (!defined('CONVOMANAGE')) {
    define('CONVOMANAGE', true);
}

define('APP_NAME', 'ConvoManage');
define('APP_ENV', 'production');
define('APP_URL', 'http://localhost/convomanage');
define('APP_TIMEZONE', 'Asia/Kolkata');

date_default_timezone_set(APP_TIMEZONE);

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'convomanage');
define('DB_USER', 'root');
define('DB_PASS', '');

// Session Security
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
}

// CSRF Helpers
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
