<?php
    global $t;
    $t->setPlugin("netutils");
    $aliases = array(
        "netutils" => "netutils", 
        "nslookup" => "netutils",
        "whois" => "netutils", 
        "dig" => "netutils",
        "nmap" => "netutils"
    );
    $helps = $t->g("help");
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("netutils", $helps);
?>
