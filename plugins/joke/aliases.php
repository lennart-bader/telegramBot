<?php
    global $t;
    $t->setPlugin("joke");

    $aliases = array("joke" => "joke", "witz" => "joke");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $helps = $t->g("help");
    $pluginManager->addHelp("joke", $helps);
?>
