<?php
    $aliases = array("news" => "news");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $helps = array(
        "/news - Gives you the latest news from SPON",
        "/news `SEARCH` - Gives you the latest news with keywoard `SEARCH`"
    );
    $pluginManager->addHelp("news", $helps);
?>
