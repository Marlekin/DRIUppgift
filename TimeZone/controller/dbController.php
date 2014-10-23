<?php

include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/dbComp/myDB.php");
include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/dbComp/mySQLDB.php");

/**
*Controls the setting up of the database, calls operations from the 
*classes in the DB component and provides the ulility controller with data
*/
class DBController{

	/**
	*@var mixed This variable holds any kind of database
	*/
	private $myDB;

	/**
	*@var string Holds a string of successful DB inserts for the log
	*/
	private $resultString;

	/**
	*@var int Holds the count of succesful DB inserts for the log
	*/
	private $count;


	public function __construct(){

		$this->resultString = "";
		$count = 0;

	}

	/**
	*Sets the database based on the incoming 
	*database type stored in the parameter array
	*
	*@param string[] $options Settings for the DB connection
	*@return void
	*/
	public function setDatabase($options){

		switch ($options['database_type']) {

			case 'mysql':
			
				$this->myDB = new MySQLDB($options);

				break;

			case 'someOtherDB':

				//$this->myDB = new SomeOtherDB($options);
				break;
			
			default:

				throw new Exception("Could not connect to database");
				break;
		}
	}

	/**
	*Routes an insert-query to the currently connected DB
	*
	*
	*@param string $zone Incoming timezone for insertion into DB. Can't be empty or null
	*@param string $stamp Incoming timezone for insertion into DB. Can't be empty or null
	*@return void;
	*/
	public function insertToTable($zone, $stamp){

		$this->myDB->insertSQL($zone, $stamp);

		$this->count++;

	}

	/**
	*Routes a select-query based on the currently connected DB
	*
	*@return string[] A two-dimensional array containing timezones and timestamps
	*/
	public function selectFromTable(){

		$results = $this->myDB->selectSQL();

		return $results;

	}

	/**
	*Routes a truncate-query based on the currently connected DB
	*
	*@return void
	*/
	public function flushTable($table){

		$this->myDB->truncateSQL($table);

	}

	/**
	*Returns the count of the successful inserts into the database
	*
	*@return int The count of successful inserts
	*/
	public function getSuccessCount(){

		return $this->count;

	}

	/**
	*Returns a list of the successful inserts into the database
	*
	*@return string The list of successful inserts
	*/
	public function getSuccesString(){

		return $this->resultString;

	}

	/**
	*Reports the database insertion results to the utility controller
	*
	*@return mixed The count of successful insertions and a list of inserted posts
	*/
	public function reportSuccesses(){

		$result = $this->selectFromTable();

		$results = "";

		foreach($result as $data){

			$results .= $data[$this->myDB->getZoneColumn()] . "	|	" 
					. $data[$this->myDB->getStampColumn()] . "<br />";

			$this->resultString .= $data[$this->myDB->getZoneColumn()] . "	|	" 
					. $data[$this->myDB->getStampColumn()] . "\r\n";
					
		}

		return $this->myDB->getCount() . " successful database insertions:<br /><br />" . $results;

	}
}

?>