<?php
$host = "localhost";
$db = "convomanage";
$user = "root";
$pass = ""; // Change if you set a password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("DB Connection Failed: " . $e->getMessage());
}
?>

