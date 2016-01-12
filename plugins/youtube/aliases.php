<?php
    global $t;
    $t->setPlugin("youtube");

    global $pluginManager;
    $pluginManager->registerAlias("youtube", "youtube", "text");
    $pluginManager->registerAlias("yt", "youtube", "text");
    $pluginManager->registerAlias("dlv", "youtube", "text");
    $pluginManager->registerReceiver("youtube", "text");
    $helps = $t->g("help");
    $pluginManager->addHelp("youtube", $helps);
?>
