<?php
class Shell {
    private $input;
    private $cmd;
    private $output;
    private $filter;

    public function __construct() {
        
    }

    public function setCmd($cmd) {
        $this->cmd = $cmd;
    }

    private function validate() {
        // No additional cmd!
        if (strpos(";", $this->cmd) !== false or strpos("&", $this->cmd) !== false) {
            return false;
        }
        $cmd = $this->cmd;
        $mainarg = $this->filter["main"];
        $mainlen = strlen($mainarg) + 1;
        if (substr($cmd, 0, $mainlen) != $mainarg . " ") {
            return false;
        }
        $split = explode("|", $cmd);
        if (sizeof($split) == 1) {
            return true;
        } else {
            foreach ($split as $pipe) {
                $subcmd = trim($pipe);
                $subargs = $this->filter["subarg"];
                $verified = false;
                foreach ($subargs as $subarg) {
                    $sublen = strlen($subarg) + 1;
                    if (substr($subcmd, 0, $sublen) == $subarg . " ") {
                        $verified = true;
                        break;
                    }
                }
                if (!$verified) {
                    return false;
                }
            }
        }
        return true;        
    }

    public function setFilter($filter) {
        $this->filter = $filter;
    }

    public function execute() {
        if (!$this->validate()) {
            return false;
        } else {
            $this->output = array();
            exec(escapeshellcmd($this->cmd), $this->output, $retval);
            return true;
        }
    }

    public function getOutput() {
        return $this->output;
    }


}

?>
