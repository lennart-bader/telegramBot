<?php
    global $t;
    $t->setPlugin("hangman");

    $aliases = array(
        "hangman" => "hangman", 
    );
    $helps = $t->g("help");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("hangman", $helps);
    $pluginManager->registerReceiver("hangman");
?>
