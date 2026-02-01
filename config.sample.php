<?php
// Copy this file to config.php and edit the values below, or set as environment variables on Render

define('ADMIN_PASSWORD_HASH', '$2y$10$replace_with_bcrypt_hash'); // Use password_hash('yourpassword', PASSWORD_BCRYPT)
define('TELEGRAM_BOT_TOKEN', getenv('TELEGRAM_BOT_TOKEN') ?: '');
define('TELEGRAM_CHAT_ID', getenv('TELEGRAM_CHAT_ID') ?: '');
