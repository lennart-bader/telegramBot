<?php
    global $t;
    $t->setPlugin("help");

    $helps = array(
        $t->g("help0"),
        $t->g("help1")
    );
    global $pluginManager;
    $pluginManager->registerAlias("help", "help", "text");
    $pluginManager->addHelp("help", $helps);
?>
