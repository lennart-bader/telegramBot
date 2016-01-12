<?php
    global $t;
    $t->setPlugin("youtube");

    $aliases = array("youtube" => "youtube", "yt" => "youtube", "dlv" => "youtube");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->registerReceiver("youtube");
    $helps = $t->g("help");
    $pluginManager->addHelp("youtube", $helps);
?>
