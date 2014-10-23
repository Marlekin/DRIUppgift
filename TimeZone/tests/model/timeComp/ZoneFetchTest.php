<?php

require_once("C:/xampp/htdocs/TimeZone3/model/timeComp/zoneFetch.php");

class ZoneFetchTest extends PHPUnit_Framework_TestCase{

	public $zoneTest;

	public function setUp(){
		$this->zoneTest = new ZoneFetch();
	}

	public function testFetchURL(){
		$array = $this->zoneTest->fetchTimeZones("http://json-time.appspot.com/timezones.json");
		$this->assertTrue(is_array($array));
	}
	
}

?>