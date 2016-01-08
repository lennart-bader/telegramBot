<?php
    require_once("wikipedia.class.php");

    class Wikipedia {
        public function __construct() {
        
        }
    
        public function execute($data, $message) {
			$markdown = true;
			
            $cmd = strtolower($data[0]);
			
			$cmd_params = explode("_", $cmd);
			if (sizeof($cmd_params) == 2) {
				$param = $cmd_params[1];
				$cmd = $cmd_params[0];
			}

			switch ($cmd) {
				case "wiki":
					if (sizeof($data) >= 2) {
						unset($data[0]);
						$title = implode(" ", $data);
					} else {
						$help = array();
                        $help[] = "*Wikipedia Plugin*";
                        $help[] = "Try /help\\_wikipedia for help";
						$help = implode("\n", $help);
					
						Api::reply($message, $help, true);
						return;
					}
            
					$wp = new WikipediaParser();
					$text = $wp->search($title);
					$markdown = false;
					break;
					
				case "wikip":
					$wp = new WikipediaParser();
					$text = $wp->page($param);
					break;
			}
			
            Api::reply($message, $text, $markdown);
        }
    }
?>
