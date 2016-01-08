<?php
    $aliases = array(
        "netutils" => "netutils", 
        "nslookup" => "netutils",
        "whois" => "netutils", 
        "dig" => "netutils",
        "nmap" => "netutils"
    );
    $helps = array(
        "/nslookup `DOMAIN` - looks up the IP for the given domain",
        "/nslookup `IP` - looks up reverse DNS for given IP",
        "/dig `PARAMS` - uses the dig command from unix",
        "/nmap `PARAMS` - use the nmap command from unix",
        "/whois `PARAMS` - use the whois command from unix"
    );
    global $pluginManager;
    $pluginManager->registerAliases($aliases);
    $pluginManager->addHelp("netutils", $helps);
?>
