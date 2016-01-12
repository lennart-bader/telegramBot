<?php    
class PluginManager {
    private $pluginAliases = array();
    private $plugins = array();
    private $receiveAliases = array();
    private $helps = array();

    private $aliases = array();
    private $receivers = array();

    public function collectAliases() {
        foreach (new DirectoryIterator('plugins') as $fileInfo) {
            if($fileInfo->isDot()) continue;
            
            if ($fileInfo->isDir()) {
                if (file_exists($fileInfo->getPathname() . "/aliases.php")) {
                    require_once $fileInfo->getPathname() . "/aliases.php";
                }
                if (file_exists($fileInfo->getPathname() . "/config.php")) {
                    require_once $fileInfo->getPathname() . "/config.php";
                }

            }
        }
    }

    public function getAliases() {
        return $this->pluginAliases;
    }

    public function addHelp($plugin, $helps) {
        $this->helps[$plugin] = $helps;
    }

    public function getPlugin($cmd) {
        $cmd = explode("_", $cmd);
        $cmd = $cmd[0];
        if (isset($this->aliases[$cmd])) {
            $candidate = $this->aliases[$cmd];
            global $message;
            $type = $message->type;
            $types = $candidate["types"];
            if ($types === true || in_array($type, $types)) {
                return $candidate["to"];
            }
        }
        return false;
    }

    public function getPluginList() {
        return $this->plugins;
    }

    public function sendReceived($message) {
        foreach ($this->receivers as $receiver) {
            $pluginName = $receiver["plugin"];
            $types = $receiver["types"];
            if ($types === true || in_array($message->type, $types)) {
                $plugin = new $pluginName;
                $plugin->receive($message);
            }
        }
    }

    // @DEPRECATED
    public function registerAliases($aliases) {
        foreach ($aliases as $from => $to) {
            $this->registerAlias($from, $to);
        }
    }

    public function registerAlias($from, $to, $types = true) {
        if ($types !== true && !is_array($types)) {
            $types = array($types);
        }
        $this->aliases[$from] = array("to" => $to, "types" => $types);

        if (!in_array($to, $this->plugins)) {
            $this->plugins[] = $to;
        }
    }

    public function registerReceiver($receiver, $types = true) {
        if ($types !== true && !is_array($types)) {
            $types = array($types);
        }
        $this->receivers[] = array("plugin" => $receiver, "types" => $types);
    }

    public function getHelp($plugin) {
        if ($plugin == false)
            return $this->helps;
            
        if (isset($this->helps[$plugin]) && is_array($this->helps[$plugin])) {
            return $this->helps[$plugin];
        } else {
            return array();
        }
    }
}

?>
