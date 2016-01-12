<?php
class Help {
    public function execute($message) {
        global $pluginManager;
        global $t;
        $t->setPlugin("help");

        $cmd = $message->getCommand();
        $data = explode("_", $cmd);

        array_shift($data);
        $help = trim(implode(" ", $data));

	    $reply = "";

        if (empty($help)) {
            $res = $pluginManager->getPluginList();
            $helps = array();
            foreach ($res as $text) {
                $helps[] = $text . " - /help\\_".$text;
            }
            $res = $helps;
            array_unshift($res, "*" . $t->g("available") . "*");
        } else {
            $plugin = $pluginManager->getPlugin($help);
            $res = $pluginManager->getHelp($plugin);
            if (sizeof($res) == 0) {
                $res = array("*" . sprintf($t->g("notfound"), $help) . "*");
            } else {
                $helps = array();
                foreach ($res as $text) {
                    $helps[] = str_replace("_", "\\_", $text);
                }
                array_unshift($helps, "*" . sprintf($t->g("helpheader"), $help, $plugin) . "*");
                $res = $helps;
            }
        }
        
        $reply = implode("\n", $res); 
        
        Api::reply($message->chat, $reply, true);
    }
}
?>
