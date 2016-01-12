<?php
    require_once("weatherparser.class.php");

    class Weather {
        public function __construct() {
        
        }
    
        public function execute($message) {
            $cmd = strtolower($message->getCommand());
	        $data = $message->getData();   

			if (sizeof($data) >= 1) {
                $location = implode(" ", $data);
            } else {
                $location = "Duisburg";
            }
            
			if (in_array($cmd, array("weatherf", "wettera"))) {
				$forecast = true;
			} else {
				$forecast = false;
			}
			
            $wp = new WeatherParser($location);
            
            Api::reply($message->chat, $wp->getWeather($forecast), true);
        }
    }
?>