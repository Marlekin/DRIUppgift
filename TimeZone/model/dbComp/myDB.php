<?php

include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/dbComp/medoo/medoo.php");

/**	
*Inherits the Medoo framework. Acts as an abstracted mediating layer in the application.  
*/
class MyDB extends medoo{


	/**
	*Calls the parent constructor with the incoming DB settings for connecting to the database 
	*
	*@param string[] $options Array containing settings for the database. Can't be null or empty. 
	*/
	public function __construct($options){

		parent::__construct($options);
		
	}

	/**
	*Makes a select-query towards the database 
	*
	*@param string $tableName The name of the table in the DB. Can't be empty or null
	*@param string $zoneColumn The name of the timezone column in the DB. Can't be empty or null
	*@param string $stampColumn The name of the timestamp column in the DB. Can't be empty or null
	*
	*@return string[] A two-dimensional array containing timezones and timestamps
	*/
	public function selectSQL($tableName, $zoneColumn, $stampColumn){

		$columns = array($zoneColumn => $zoneColumn, $stampColumn => $stampColumn);

		$results = $this->select($tableName, $columns);

		return $results;

	}

	/**
	*Makes an insert-query towards the database 
	*
	*@param string $tableName The name of the table in the DB. Can't be empty or null
	*@param string $zoneColumn The name of the timezone column in the DB. Can't be empty or null
	*@param string $stampColumn The name of the timestamp column in the DB. Can't be empty or null
	*@param string $zone The name of the timezone. Can't be empty or null
	*@param string $stamp The timestamp. Canät be empty or null
	*@return void
	*/
	public function insertSQL($tableName, $zoneColumn, $stampColumn, $zone, $stamp){

		$data = array($zoneColumn => $zone, $stampColumn => $stamp);

		$this->insert($tableName, $data);

	}

	

}


?>