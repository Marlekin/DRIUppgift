<?php

class TimeController{

	private $zoneFetch;
	private $stampFetch;
	private $errors;

	public function __construct(){

	$this->zoneFetch = new ZoneFetch();
	$this->stampFetch = new StampFetch();

	$errors = "";

	}


	public function communicateWS($urls){

		$comm = new TimeComm();
	
		try{
			if($comm->isDomainAvailable($urls['domain_url'])){
					
				if ($comm->isValidJSON($urls['timezones_url'])){
					echo("<p class='notice'>Web service availability validated, transfer process started...</p> <br />");
					return true;
				}
			}	
		}
			
		catch(Exception $e){
			throw $e;
		}
		
		return false;
		
	}


	public function fetch($urls){

		$timeArray = array();
	
		$zones = $this->zoneFetch->fetchTimeZones($urls['timezones_url']);
		$zoneCount = count($zones);
		$count = 0;

		for($i = 0; $i < $zoneCount; $i++){

			try{

				$stamp = $this->stampFetch->fetchTimeStamp($urls['timestamps_url'], $zones[$i]);

				if($this->stampFetch->hasDatetime($stamp, $zones[$i])){

					if($this->stampFetch->isValidFormat($zones[$i])){

						$timeArray['zone'][$count] = $zones[$i];
						$timeArray['stamp'][$count] = $this->stampFetch->getTimeStamp();

						$count++;
					}

				}
			}
			catch(Exception $e){
				$this->errors .= $e->getMessage() ."<br />";
			}

		}

		return $timeArray;
	}

	public function reportErrors(){
		if($this->errors != ""){
			return $this->errors;
		}
		else{
			return "No errors detected";
		}
	}

}


?>