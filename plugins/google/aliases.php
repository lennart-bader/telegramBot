<?php
    global $t;
    global $pluginManager;

    $t->setPlugin("google");
    $helps = $t->g("help");

    $pluginManager->addHelp("google", $helps);

    $pluginManager->registerAlias("g", "google", "text");
    $pluginManager->registerAlias("img", "google", "text");
    $pluginManager->registerAlias("google", "google", "text");
?>
