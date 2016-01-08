<?php
    $aliases = array("hello" => "hello");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->registerReceiver("hello");
    $helps = array(
        "Just a greeting Plugin - no commands necessary"
    );
    $pluginManager->addHelp("hello", $helps);
?>
