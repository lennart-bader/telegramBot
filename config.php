<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    // TELEGRAM API    
    define("TELEGRAM_API_URL", "https://api.telegram.org/bot");
    define("TELEGRAM_API", TELEGRAM_API_URL . TELEGRAM_API_TOKEN . "/");
    define("TELEGRAM_LISTENER_URL", "https://telegram.lbader.de/listener.php");
?>
