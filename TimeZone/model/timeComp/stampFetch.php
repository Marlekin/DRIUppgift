<?php


/**
*Handles the fetching, checking, converting and returning 
*of all the individual timestamps
*/
class StampFetch{

	/**
	*@var string Holds a timestamp
	*/
	private $timeStamp;
	
	/**
	*Fetches a timestamp based on an incoming url and sends back
	*a timestamp as an array
	*
	*@param string $url First part of the url of a timestamp
	*@param string $zone Second part of the url of a timestamp (zone name)
	*@return string[] Array of the fetched timestamp
	*/
	public function fetchTimeStamp($url, $zone){
	
		if($stamp = file_get_contents($url . $zone)){
			$stampArray = json_decode($stamp, true);
		}

		else{
			throw new Exception("Could not fetch timestamp of " . $zone . ", check URL");
		}

		return $stampArray;
	}
	
	/**
	*Checks if the incoming timestamp has a datetime index. If it has, assign timestamp. If not, throw exception
	*
	*@param string[] $content Array of a timestamp
	*@param string $zone Name of timezone
	*@return bool
	*/
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

	/**
	*Checks if the timestamp has a valid format. If it does operation convertStamp() is 
	*called to convert the stamp. Throws an exception if not.
	*
	*@param string $zone Timezone name
	*@return bool
	*/
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
	
	/**
	*@param string $s Datetime of timestamp
	*@return string Datetime converted to database format
	*/
	private function convertStamp($s){
		
		$stamp = $s;
		$date = date_create_from_format('d M Y H:i:s', $stamp);
		$date = $date->format('Y-m-d H:i:s');

		return $date;

	}
	
	/**
	*Returns the timestamp (datetime)
	*
	*@return string 
	*/
	public function getTimeStamp(){
	
	return $this->timeStamp;
	
	}

}


?>