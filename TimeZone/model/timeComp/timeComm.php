<?php

class TimeComm{

	public function __construct(){
 
 
	}	

	public function isDomainAvailable($domain){

		//check, if a valid url is provided
		if(!filter_var($domain, FILTER_VALIDATE_URL))
		{
			throw new Exception("Error: Specified URL for web service is not valid, aborting");
			
			return false;
		}
 
		//initialize curl
		$curlIn = curl_init($domain);
		curl_setopt($curlIn,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlIn,CURLOPT_HEADER,true);
		curl_setopt($curlIn,CURLOPT_NOBODY,true);
		curl_setopt($curlIn,CURLOPT_RETURNTRANSFER,true);

		//get answer
		$response = curl_exec($curlIn);

		curl_close($curlIn);

		if ($response){ 

			return true;
		}
		else{

			throw new Exception("Error: Domain of web service is not available, aborting");

			return false;
		}
	}

	public function isValidJSON($url){

		if(@json_decode(file_get_contents($url))){
	
			return true;
		
		}
	
		else{
		
			throw new Exception("Error: URL does not contain a valid JSON, aborting");
	
			return false;
	
		}
	}
}



		



?>