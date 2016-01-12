<?php

/**
 * PHP Class to get the current and future weather conditions
 */
class OpenWeather
{
	/**
	 * Class properties
	 */
	protected $location_ = false;
	protected $currentWeather = false;
	protected $futureWeather = false;
	protected $coords = false;
		
	/**
	 * Constructor for the GoogleWeather class
	 */	
	public function __construct($location){
			
		//Location must not be empty
		if (is_array($location)) {
			$this->coords = $location;
			$this->getWeather();	
		} elseif ($location != "") {
			$this->location_ = $location;
			$this->getWeather();	
		}		
	}
		
	/**
	 * Get the weather from the location in the form
	 */
	private function getWeather(){
		$appid = weather_appid;
		$lang = strtolower(LANGUAGE);
		//If location is set
		if($this->location_){
			$this->currentWeather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($this->location_) . "&lang=".$lang."&units=metric&APPID=" . $appid), true);
			
			$this->futureWeather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/forecast?q=" . urlencode($this->location_) . "&lang=".$lang."&units=metric&APPID=" . $appid), true);
		} elseif (is_array($this->coords)) {
			$lat = $this->coords["lat"];
			$lon = $this->coords["lon"];
			$this->currentWeather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=".$lat. "&lon=".$lon."&lang=".$lang."&units=metric&APPID=" . $appid), true);
			$this->futureWeather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/forecast?lat=".$lat. "&lon=".$lon."&lang=".$lang."&units=metric&APPID=" . $appid), true);
			$this->location_ = $this->currentWeather["name"];
		}
	}
		
	/**
	 * Gets the current location
	 */
	public function getLocation(){
		return ucwords($this->location_);
	}
}
?>
