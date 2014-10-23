<?php


/**
*Handles the communication with the web service. Checks if the domain at the
*given URL is available and that there exists a JSON there 
*/
class TimeComm{

	/**
	*Checks if the URL given is valid and that we don't recieve a 404
	*
	*@param string $domain The URL to where the domain is
	*@return bool
	*/
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

		//Check if domain responds
		if ($response){ 

			return true;
		}
		else{

			throw new Exception("Error: Domain of web service is not available, aborting");

			return false;
		}
	}

	/**
	*Tries to fetch the JSON. If it can't throws an exception
	*
	*@param string $url The URL to where the JSON (list of timezones) is supposed to be
	*@return bool
	*/
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