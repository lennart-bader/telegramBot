<?php
    global $t;
    $t->setPlugin("weather");

    global $pluginManager;
    $pluginManager->registerAlias("wetter", "weather", "text");
    $pluginManager->registerAlias("wettera", "weather", "text");
    $pluginManager->registerAlias("weather", "weather", "text");
    $pluginManager->registerAlias("weatherf", "weather", "text");
    $helps = $t->g("help");
    $pluginManager->addHelp("weather", $helps);
?>
