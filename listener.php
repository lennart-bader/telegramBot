<?php
    include("include.php");
    
    global $pluginManager;
    global $message;
    global $msg;
    global $api;
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
        $update = new Update($api->getWebhookUpdates());
        if ($update->type == "inlineQuery") {

        } else {
            $message = $update->message;
        
            $pluginManager->sendReceived($message);

        
            if ($message->is_command) {
                $cmd = $message->getCommand();
                if (!$cmd) {
                    exit;
                }
                $cmd = $pluginManager->resolveAlias($cmd);
                $class = new $cmd;
                $class->execute($message);
            }
        }
    }
    
?>
