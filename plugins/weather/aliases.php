<?php
    global $t;
    $t->setPlugin("weather");

    $aliases = array("wetter" => "weather", "weather" => "weather", "weatherf" => "weather", "wettera" => "weather");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $helps = $t->g("help");
    $pluginManager->addHelp("weather", $helps);
?>
