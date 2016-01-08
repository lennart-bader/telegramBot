<?php
    require_once("weatherparser.class.php");

    class Weather {
        public function __construct() {
        
        }
    
        public function execute($data, $message) {
            $cmd = strtolower($data[0]);
			
			if (sizeof($data) >= 2) {
                unset($data[0]);
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
            
            Api::reply($message, $wp->getWeather($forecast), true);
        }
    }
?>