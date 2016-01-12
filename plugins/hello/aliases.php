<?php
    global $t;
    $t->setPlugin("hello");

    $aliases = array("hello" => "hello");
    global $pluginManager;
    $helps = array(
        $t->g("help")
    );
    
    $pluginManager->addHelp("hello", $helps);
    $pluginManager->registerAlias("hello", "hello", "text");
    $pluginManager->registerReceiver("hello", "text");
?>
