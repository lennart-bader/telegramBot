<?php
    // ERROR DISPLAYS
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    // AUTHENTICATION
    define("restricted_access", true);

    // TELEGRAM API    
    define("TELEGRAM_API_URL", "https://api.telegram.org/bot");
    define("TELEGRAM_API", TELEGRAM_API_URL . TELEGRAM_API_TOKEN . "/");

    // PERSONALITY
    define("BOT_NAME", "Bob");
    define("BOT_GENDER", "m");
    define("BOT_BIRTH", "04.09.2015");  // dd.mm.YYYY

    // LOCALIZATION
    define("TIMEZONE", "+1");
    define("LANGUAGE", "DE");
    define("DEFAULT_LANGUAGE", "EN");
?>
