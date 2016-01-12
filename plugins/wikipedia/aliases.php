<?php
    global $t;
    $t->setPlugin("wikipedia");

    global $pluginManager;
    $pluginManager->registerAlias("wiki", "wikipedia", "text");
    $pluginManager->registerAlias("info", "wikipedia", "text");
    $pluginManager->registerAlias("wikip", "wikipedia", "text");
    $pluginManager->registerAlias("wikipedia", "wikipedia", "text");

    $helps = $t->g("help");
    $pluginManager->addHelp("wikipedia", $helps);
?>
