<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['admin'])) { header('Location: dashboard.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bot_token = trim($_POST['bot_token'] ?? '');
    $chat_id = trim($_POST['chat_id'] ?? '');
    // Save to .env-style file (not committed)
    $env = "TELEGRAM_BOT_TOKEN=$bot_token\nTELEGRAM_CHAT_ID=$chat_id\n";
    file_put_contents('.env', $env);
    // Optionally, update config.php if you want to store statically (not recommended for secrets)
    header('Location: dashboard.php');
    exit;
}
header('Location: dashboard.php');
