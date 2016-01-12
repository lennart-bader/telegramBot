<?php
    global $pluginManager;
    $pluginManager->registerAlias("c", "wolfram", "text");
    $pluginManager->registerAlias("calc", "wolfram", "text");
    $pluginManager->registerAlias("wolfram", "wolfram", "text");

    $helps = array(
        "Use /c, /calc or /wolfram",
        "/c `ENGLISH-QUESTION` - Tries to answer your question",
        "   E.g.: `/c What date is it?`",
        "/c `Equation` - Calculates the solution for the equation.",
        "   E.g.: `/c 2x = 8`",
        "/c `QUERY` - Tries to evaluate your query",
        "   E.g.: `/c Android`"
    );


    $pluginManager->addHelp("wolfram", $helps);
?>
