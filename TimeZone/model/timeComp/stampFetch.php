<?php

class StampFetch{

	private $timeStamp;
	
	public function __construct(){

		$this->errorString = "";
		$this->invalidString = "";

	}

	//Fetch list of timezones
	public function fetchTimeStamp($url, $zone){
	
		if($stamp = file_get_contents($url . $zone)){
			$stampArray = json_decode($stamp, true);
		}

		else{
			throw new Exception("Could not fetch timestamp of " . $zone . ", check URL");
		}

		return $stampArray;
	}
	
	public function hasDateTime($content, $zone){
	
	if(array_key_exists("datetime", $content)){
	@$this->timeStamp = $content["datetime"];	
	return true;
	}
	
	else{
	throw new Exception("Error: " . $zone . " does not have a timestamp, skipped");
	return false;
	}
	
	
	}

	//Check if format of incoming timestamp is valid
	public function isValidFormat($zone){

		$this->timeStamp = substr($this->timeStamp,5,20);

		if($this->timeStamp == date('d M Y H:i:s', strtotime($this->timeStamp))){
		
			$this->timeStamp = $this->convertStamp($this->timeStamp);
			
			return true;
		}		

		else{
			throw new Exception("Error: Timestamp of " . $zone . "is of invalid format");
			return false;

		}
	}
	
	//Convert timestamp to database format
	private function convertStamp($s){
		
		$stamp = $s;
		$date = date_create_from_format('d M Y H:i:s', $stamp);
		$date = $date->format('Y-m-d H:i:s');

		return $date;

	}
	
	public function getTimeStamp(){
	
	return $this->timeStamp;
	
	}

}


?>