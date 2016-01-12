<?php
    global $t;
    $t->setPlugin("dict");

    $helps = array(
        $t->g(0)
    );

    global $pluginManager;
    $pluginManager->registerAlias("dict", "dict", "text");
    $pluginManager->addHelp("dict", $helps);
?>
