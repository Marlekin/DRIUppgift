<?php

class StampFetch{

	private $errorString;
	private $invalidString;

	public function __construct(){

		$this->errorString = "";
		$this->invalidString = "";

	}

	//Fetch list of timezones
	public function fetchTimeStamp($url, $zone){

		if(!$stamp = file_get_contents($url . $zone)){
			$stampArray = json_decode($stamp, true);
		}

		else{
			throw new Exception("Could not fetch timestamp");
			$this->errorstring .= "Error: Could not fetch timestamp for" . $zone . "\r\n";
		}

		return $stampArray;
	}

	//Convert timestamp to database format
	public function convertStamp($s){

		$stamp = substr($s,5,20);
		$date = date_create_from_format('d M Y H:i:s', $stamp);
		$date = $date->format('Y-m-d H:i:s');

		return $date;

	}

	//Check if format of incoming timestamp is valid
	public function isValidFormat($s, $zone){

		$stamp = substr($s,5,20);

		if($stamp == date('d M Y H:i:s', strtotime($stamp))){
	
			return true;

		}		

		else{

			$this->invalidString .= "Error: The datetime of " . $zone . " is of invalid format, timezone skipped \r\n";
			return false;

		}
	}

	public function report($datetime){
	
		if(!$errorString == ""){
			Logger::logSomething("\r\nFailures when fetching timestamps:\r\n--------------------------------------------------------\r\n", $this->errorString, $this->datetime);
		}		
		if(!$invalidString == ""){
			Logger::logSomething("\r\nInvalid datetime format of fetched timestamp:\r\n--------------------------------------------------------\r\n", $this->invalidString, $this->datetime);
		}
	}

}


?>