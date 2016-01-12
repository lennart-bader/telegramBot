<?php
    global $t;
    $t->setPlugin("dict");

    $aliases = array(
        "dict" => "dict", 
    );
    $helps = array(
        $t->g(0)
    );
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("dict", $helps);
?>
