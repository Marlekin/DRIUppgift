<?php 

class TimeFetch{



public function __construct(){

}

//Thu, 16 Oct 2014 12:15:22 +0000
public function convertStamp($s){

	$stamp = substr($s,5,20);
	$date = date_create_from_format('d M Y H:i:s', $stamp);
	$date = $date->format('Y-m-d H:i:s');

	return $date;

}

public function fetchJson($urlZones, $urlStamps){
	
	$jZoneArray = json_decode(file_get_contents($urlZones), true);
	$jArrayValid = array();
	$validIndex = 0;
	
	for($i = 0; $i < count($jZoneArray); $i++){
	
		$jStampContent = file_get_contents($urlStamps . $jZoneArray[$i]);
		$tempStampArray = json_decode($jStampContent, true);
	
		if(array_key_exists("datetime", $tempStampArray)){
		
			$datetime = $this->convertStamp($tempStampArray["datetime"]);
	
			$jArrayValid[$validIndex]["name"] = $jZoneArray[$i];
			$jArrayValid[$validIndex]["dt"] = $datetime;
			
			echo $jArrayValid[$validIndex]["name"] . " " . $jArrayValid[$validIndex]["dt"] . "<br />";
	
			$validIndex++;

					
		}
		
		else{
		
		$errorString  += "Timezone " . $jZoneArray[$i] . " has no timestamp. Zone ignored \n";

		}
	
	}
	
	if($errorString != ""){
		Logger::logSomething($errorString);
	}
	
	
	return $jArrayValid;

}


}

?>