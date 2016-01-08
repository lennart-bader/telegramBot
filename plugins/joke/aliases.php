<?php
    $aliases = array("joke" => "joke", "witz" => "joke");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $helps = array(
        "Use /joke or /witz",
        "/joke - Sends you a random joke found on the internet"
    );
    $pluginManager->addHelp("joke", $helps);
?>
