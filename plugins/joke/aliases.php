<?php
    global $t;
    $t->setPlugin("joke");

    global $pluginManager;

    $pluginManager->registerAlias("joke", "joke", "text");
    $pluginManager->registerAlias("witz", "joke", "text");
    
    $helps = $t->g("help");
    $pluginManager->addHelp("joke", $helps);
?>
