<?php
    require_once("wikipedia.class.php");

    class Wikipedia {
        public function __construct() {
        
        }
    
        public function execute($message) {
			$markdown = true;
            global $t;
            $t->setPlugin("wikipedia");
			
            $cmd = strtolower($message->getCommand());
            $data = $message->getData();
			
			$cmd_params = explode("_", $cmd);
			if (sizeof($cmd_params) == 2) {
				$param = $cmd_params[1];
				$cmd = $cmd_params[0];
			}

			switch ($cmd) {
				case "wiki":
					if (sizeof($data) >= 1) {
						$title = implode(" ", $data);
					} else {
						$help = $t->g("default");
						$help = implode("\n", $help);
					
						Api::reply($message->chat, $help, true);
						return;
					}
            
					$wp = new WikipediaParser();
					$text = $wp->search($title, strtolower(LANGUAGE));
					$markdown = false;
					break;
					
				case "wikip":
					$wp = new WikipediaParser();
					$text = $wp->page($param, strtolower(LANGUAGE));
					break;
			}
			
            Api::reply($message->chat, $text, $markdown);
        }
    }
?>
