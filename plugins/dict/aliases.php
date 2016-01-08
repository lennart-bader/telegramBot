<?php
    $aliases = array(
        "dict" => "dict", 
    );
    $helps = array(
        "/dict_FROM_TO `WORD` - Translate WORD between two languages"
    );
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("dict", $helps);
?>
