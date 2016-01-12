<?php
    global $t;
    $t->setPlugin("memes");

    global $pluginManager;
    $pluginManager->registerAlias("meme", "memes", "text");
    $pluginManager->registerAlias("memes", "memes", "text");
    $pluginManager->registerAlias("m", "memes", "text");
    $helps = $t->g("help");
    $pluginManager->addHelp("memes", $helps);
?>
