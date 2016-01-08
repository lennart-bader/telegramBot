<?php
    $aliases = array("wiki" => "wikipedia", "info" => "wikipedia", "wikip" => "wikipedia", "wikipedia" => "wikipedia");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);

    $helps = array(
        "/wiki `SEARCH` - Searchs for articles related to `SEARCH` in wikipedia with clickable detail commands",
        "/wikip_ID - Gives you an extract from the article with ID `ID`"
    );
    $pluginManager->addHelp("wikipedia", $helps);
?>
