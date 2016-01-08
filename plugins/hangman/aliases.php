<?php
    $aliases = array(
        "hangman" => "hangman", 
    );
    $helps = array(
        "/hangman_start - Starts a new hangman game",
        "/hangman_pause - pauses the current game. Can be continued by /hangman_start",
        "/hangman_solve - shows the solution for the current game (and ends the game)",
        "/hangman_stop  - ends the current game",
        "While in game just type single letters to play"
    );
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("hangman", $helps);
    $pluginManager->registerReceiver("hangman");
?>
