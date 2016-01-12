<?php
    include("include.php");
    
    global $pluginManager;
    global $message;
    global $msg;
    global $api;
    global $chatid;
    global $sender;
    global $db;
    global $t;
    $t = new Translator();

    $db = new MySql();

    $api = new telegramBot(TELEGRAM_API_TOKEN);

    $pluginManager = new PluginManager();
    $pluginManager->collectAliases();
    
    if (defined("IS_CRONJOB")) {
        // Cronjob running
        // TODO
    } else {
        // Message received
        $message = Api::getUpdate();
        $chatid = Api::getChat($message);
        
        $sender = $message["message"]["from"];

        $text = $message["message"]["text"];    
    
        $isCmd = false;
        if (strpos($text, "/") == 0 && strpos($text, "/") !== false) {
            $text = substr($text, 1);
            $isCmd = true;
        }
    	$text = str_replace("@kryptur_bot", "", $text);
    
        $data = explode(" ", $text);
    
        $pluginManager->sendReceived($data, $message);

        $cmd = strtolower($data[0]);
        $cmd = $pluginManager->getPlugin($cmd);
        if (!$cmd) {
            exit;
        }

    
        if ($isCmd) {
            $class = new $cmd;
            $class->execute($data, $message);
        }
    }
    
?>
