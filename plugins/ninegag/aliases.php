<?php
    global $t;
    global $pluginManager;

    $t->setPlugin("ninegag");
    $helps = $t->g("help");

    $pluginManager->addHelp("ninegag", $helps);

    $pluginManager->registerAlias("9gag", "ninegag", "text");
?>
