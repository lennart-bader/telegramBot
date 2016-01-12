<?php
class Netutils {
    public function execute($data, $message) {
        global $pluginManager;
        global $t;
        $t->setPlugin("netutils");
        $reply = "";
        
        $shell = new Shell();
        $execute = true;

        $call = $data[0];
        array_shift($data);

        switch ($call) {
            case "nslookup":
                $shell->setFilter(array("main" => "nslookup", "subarg" => array()));
                $cmd = "nslookup " . implode(" ", $data);
                break;
            case "dig":
                $shell->setFilter(array("main" => "dig", "subarg" => array()));
                $cmd = "dig " . implode(" ", $data);
                break;
            case "nmap":
                $shell->setFilter(array("main" => "nmap", "subarg" => array()));
                $cmd = "nmap " . implode(" ", $data);
                break;
            case "whois":
                $shell->setFilter(array("main" => "whois", "subarg" => array()));
                $cmd = "whois " . implode(" ", $data);
                break;
            default:
                $reply = $t->g("default");
                $execute = false;
                break;
        }

        if ($execute) {
            $shell->setCmd($cmd);
            if ($shell->execute()) {
                $reply = "`$ ". api::encodePlain($cmd) . "\n" . api::encodePlain(implode("\n", $shell->getOutput())) . "`";
            } else {
                $reply = sprintf($t->g("command_error"), api::encodePlain($cmd));
            }
        }
        // Api::reply($message, $reply, true);
        global $api;
        global $chatid;
        $api->sendMessage($chatid, $reply, "Markdown", true);
    }
}
?>
