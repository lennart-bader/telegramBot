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
		
	/**
	 * Constructor for the GoogleWeather class
	 */	
	public function __construct($location){
			
		//Location must not be empty	
		if($location != ""){
			$this->location_ = $location;
			$this->getWeather();	
		}		
	}
		
	/**
	 * Get the weather from the location in the form
	 */
	private function getWeather(){
		$appid = weather_appid;
		
		//If location is set
		if($this->location_){
			$this->currentWeather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($this->location_) . "&lang=de&units=metric&APPID=" . $appid), true);
			
			$this->futureWeather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/forecast?q=" . urlencode($this->location_) . "&lang=de&units=metric&APPID=" . $appid), true);
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
