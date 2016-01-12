<?php
    global $t;
    $t->setPlugin("memes");

    $aliases = array("meme" => "memes", "memes" => "memes", "m" => "memes");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $helps = $t->g("help");
    $pluginManager->addHelp("memes", $helps);
?>
