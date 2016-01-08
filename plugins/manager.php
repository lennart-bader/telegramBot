<?php
    function __autoload($class) {
        $class = strtolower($class);
        require_once "plugins/" . $class . "/plugin.php";
        
        file_put_contents("log/manager.log", "autoloading ".$class .  " : " . file_get_contents("plugins/" . $class . "/plugin.php"));
    }
    
class PluginManager {
    private $pluginAliases = array();
    private $plugins = array();
    private $receiveAliases = array();
    private $helps = array();


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
        if (isset($this->pluginAliases[$cmd])) {
            return $this->pluginAliases[$cmd];
        } else {
            return false;
        }
    }

    public function getPluginList() {
        return $this->plugins;
    }

    public function sendReceived($data, $message) {
        foreach ($this->receiveAliases as $pluginName) {
            $plugin = new $pluginName;
            $plugin->receive($data, $message);
        }
    }

    public function registerAliases($aliases) {
        $this->pluginAliases = $this->pluginAliases + $aliases;
        foreach ($aliases as $alias => $plugin) {
            if (!in_array($plugin, $this->plugins)) {
                $this->plugins[] = $plugin;
            }
        }
    }

    public function registerReceiver($receiver) {
        $this->receiveAliases[] = $receiver;
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
