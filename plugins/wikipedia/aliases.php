<?php
    global $t;
    $t->setPlugin("wikipedia");

    $aliases = array("wiki" => "wikipedia", "info" => "wikipedia", "wikip" => "wikipedia", "wikipedia" => "wikipedia");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);

    $helps = $t->g("help");
    $pluginManager->addHelp("wikipedia", $helps);
?>
