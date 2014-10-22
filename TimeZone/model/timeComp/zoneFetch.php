<?php 

class ZoneFetch{
	
	public function __construct(){

	}

	public function fetchTimeZones($urlZones){

		$jZoneArray = json_decode(file_get_contents($urlZones), true);

		return $jZoneArray;

	}

}

?>