<?php
    $aliases = array("wetter" => "weather", "weather" => "weather", "weatherf" => "weather", "wettera" => "weather");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $helps = array(
        "Use /weather, /wetter and /weatherf, /wettera",
        "/weather `LOCATION` - Gives you the current weather for the specified location",
        "/weatherf `LOCATION` - Gives you the weather forecast for the specified location"
    );
    $pluginManager->addHelp("weather", $helps);
?>
