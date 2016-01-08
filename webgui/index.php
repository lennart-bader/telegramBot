<?php
    session_start();

    include("../include.php");
    
    global $api;
    global $db;

    $db = new MySql();
    $api = new telegramBot(TELEGRAM_API_TOKEN);

    if ($module != "login" && (!isset($_SESSION["username"]) || $_SESSION["username"] != "root")) {
        header("location: login.x");
        exit;
    } 
    
    
?>
