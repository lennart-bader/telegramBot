<?php
    $aliases = array("help" => "help");
    $helps = array("/help - Zeigt die Hilfe an", "/help `plugin` - Zeigt Hilfe eines bestimmten Plugins an");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("help", $helps);
?>
