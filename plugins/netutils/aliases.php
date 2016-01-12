<?php
    global $t;
    $t->setPlugin("netutils");
    
    $helps = $t->g("help");
    global $pluginManager;
    $pluginManager->registerAlias("netutils", "netutils", "text");
    $pluginManager->registerAlias("nslookup", "netutils", "text");
    $pluginManager->registerAlias("whois", "netutils", "text");
    $pluginManager->registerAlias("dig", "netutils", "text");
    $pluginManager->registerAlias("nmap", "netutils", "text");
    $pluginManager->addHelp("netutils", $helps);
?>
