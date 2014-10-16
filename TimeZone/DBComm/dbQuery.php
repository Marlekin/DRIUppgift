<?php

class DBQuery{

private $dbConnector;

public function __construct($connector){

	$this->dbConnector = $connector;

}

	//List data currently in table
public function listTimezones($connection){
	
	$this->strSQL = "SELECT * FROM timestamps";
	$records = sqlQuery($connection, $this->strSQL);
	
	while($record = mysqli_fetch_assoc($records)){
	
		echo($record['timezone']);
	
	}
	
	$this->dbConnector->freeResult($records);
	
}

public function insertTimezone($connection, $zone, $stamp){
	
	$strSQL = "INSERT INTO timestamps (timezone, timestamp) VALUES('".$zone."', '".$stamp."');";

	$records = $this->dbConnector->sqlQuery($connection, $strSQL);
	
	$this->dbConnector->freeResult($records);

	
}

public function flushDB($connection){

	$strSQL = "TRUNCATE timestamps;";
	
	$records = $this->dbConnector->sqlQuery($connection, $strSQL);
	
	$this->dbConnector->freeResult($records);

}

}

?>