<?php

require_once("C:/xampp/htdocs/TimeZone3/model/timeComp/timeComm.php");

class TimeCommTest extends PHPUnit_Framework_TestCase{

	public $timeComm;
	public $domain;
	public $fakeDomain;
	public $notDomain;
	public $anotherDomain;
	public $jsonURL;

	public function setUp(){
		$this->timeComm = new TimeComm();
		$this->domain = "http://json-time.appspot.com/";
		$this->fakeDomain = "http://www.notreallyurl.com";
		$this->notDomain = "Här vare tomt på internet";
		$this->anotherDomain = "http://skartwork.se";
		$this->jsonURL = "http://json-time.appspot.com/timezones.json";
	}

	public function testDomainAvailable(){
		
		try{

			$available = $this->timeComm->isDomainAvailable($this->domain);
			$this->assertTrue($available);
	
		}

		catch(Exception $e){

			print($e->getMessage() . "\n\n");

		}
	}

	public function testDomainNotAvailable(){

		try{

		$notDomain = $this->timeComm->isDomainAvailable($this->fakeDomain);
		$this->assertFalse($notDomain);

		}
		catch(Exception $e){

			print($e->getMessage() . "\n\n");

		}

	}

	public function testURLValid(){

		try{

			$isValid = $this->timeComm->isDomainAvailable($this->anotherDomain);
			$this->assertTrue($isValid);
		
		}
		
		catch(Exception $e){

			print($e->getMessage() . "\n\n");

		}
	}

	public function testURLNotValid(){

		try{

			$notUrl = $this->timeComm->isDomainAvailable($this->notDomain);
			$this->assertFalse($notUrl);
		
		}
		
		catch(Exception $e){

			print($e->getMessage() . "\n\n");

		}
	}

	public function testIsValidJSON(){

		try{

			$isJson = $this->timeComm->isValidJSON($this->jsonURL);
			$this->assertTrue($isJson);
		
		}
		
		catch(Exception $e){

			print($e->getMessage() . "\n\n");

		}
	}
	

	public function testIsNotValidJSON(){

		try{

			$notJson = $this->timeComm->isValidJSON($this->anotherDomain);
			$this->assertFalse($notJson);
		
		}
		
		catch(Exception $e){

			print($e->getMessage() . "\n\n");

		}
	}	
}

?>