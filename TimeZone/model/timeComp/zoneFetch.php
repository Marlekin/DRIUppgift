<?php 

/**
*Fetches the timezones from the web service
*/
class ZoneFetch{
	
	/**
	*Fetches all the timezone names from the web service as an array
	*
	*@param string $urlZones The url for the location of the timezone names 
	*@return string[] An array containing all the timezone names
	*/
	public function fetchTimeZones($urlZones){

		$jZoneArray = json_decode(file_get_contents($urlZones), true);

		return $jZoneArray;

	}

}

?>