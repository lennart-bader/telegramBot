<?php
class Help {
    public function execute($data, $message) {
        global $pluginManager;

        $cmd = implode("_", $data);
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
            array_unshift($res, "*Available Plugins*");
        } else {
            $plugin = $pluginManager->getPlugin($help);
            $res = $pluginManager->getHelp($plugin);
            if (sizeof($res) == 0) {
                $res = array("*Plugin " . $help . " not found*");
            } else {
                $helps = array();
                foreach ($res as $text) {
                    $helps[] = str_replace("_", "\\_", $text);
                }
                array_unshift($helps, "*Help for ".$help." (Plugin: " . $plugin . ")*");
                $res = $helps;
            }
        }
        
        $reply = implode("\n", $res); 
        
        Api::reply($message, $reply, true);
    }
}
?>
