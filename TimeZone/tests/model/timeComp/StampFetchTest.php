<?php

require_once("C:/xampp/htdocs/TimeZone3/model/timeComp/stampFetch.php");
require_once("C:/xampp/htdocs/TimeZone3/model/timeComp/zoneFetch.php");

class StampFetchTest extends PHPUnit_Framework_TestCase{

	public $stampTest;
	public $zoneTest;

	public function setUp(){
		$this->stampTest = new StampFetch();
		$this->zoneTest = new ZoneFetch();
	}

	public function testFetch(){
		$zoneArray = $this->zoneTest->fetchTimeZones("http://json-time.appspot.com/timezones.json");
		$stampArray = $this->stampTest->fetchTimeStamp("http://json-time.appspot.com/time.json?tz=" . $zoneArray[0]);
		$this->assertTrue(is_array($stampArray));
		$this->assertTrue(!empty($stampArray));
	}
	
}

?>