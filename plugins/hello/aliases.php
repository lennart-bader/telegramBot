<?php
    global $t;
    $t->setPlugin("hello");

    $aliases = array("hello" => "hello");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->registerReceiver("hello");
    $helps = array(
        $t->g("help")
    );
    $pluginManager->addHelp("hello", $helps);
?>
