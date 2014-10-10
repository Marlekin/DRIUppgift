<?php 

class TimeFetch{


private $jArrayZones;
private $jArrayStamps;

public function __construct(){

}

public function fetchTimeZones($urlZone){

	$jZoneContent = file_get_contents($urlZone);
	$this->jArrayZones = json_decode($jZoneContent, true);	
	   
}

public function fetchTimeStamps($urlStamps){
	
	echo "<article class='dataposts'>";
	
	for($i = 0; $i < count($this->jArrayZones); $i++){
	
	$jStampContent = file_get_contents($urlStamps . $this->jArrayZones[$i]);
	$tempStampArray = json_decode($jStampContent, true);
	
	$this->jArrayStamps[$i] = $tempStampArray["datetime"];
	
	echo $this->jArrayZones[$i] . " " . $this->jArrayStamps[$i] . "<br />";
	
	}
	
	echo "</article>";
	
	
}



}

?>