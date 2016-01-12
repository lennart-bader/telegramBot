<?php
    global $t;
    $t->setPlugin("help");

    $aliases = array("help" => "help");
    $helps = array(
        $t->g("help0"),
        $t->g("help1")
    );
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("help", $helps);
?>
