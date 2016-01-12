<?php
    global $pluginManager;
    $pluginManager->registerAlias("news", "news", "text");
    $helps = array(
        "/news - Gives you the latest news from SPON",
        "/news `SEARCH` - Gives you the latest news with keywoard `SEARCH`"
    );
    $pluginManager->addHelp("news", $helps);
?>
