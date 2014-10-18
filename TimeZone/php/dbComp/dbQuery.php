<?php

class DBQuery{

	private $dbConnector;
	private $succesString;

	public function __construct($connector){

		$this->dbConnector = $connector;
		$this->succesString = "";

	}

	//List data currently in table
	public function listZones($connection){
	
		$strSQL = "SELECT * FROM timestamps";
		$results = "";
	
		try{
			$records = $this->dbConnector->sqlQuery($connection, $strSQL);
			
			while($record = mysqli_fetch_assoc($records)){
				$results .= $record['timezone'] . " " . $record['timestamp'] . "<br />";	
			}
			$this->dbConnector->freeResult($records);
		}
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}
		
		
	
		return $results;	
	}

	public function insertTimezone($connection, $zone, $stamp){
	
		$strSQL = "INSERT INTO timestamps (timezone, timestamp) VALUES('".$zone."', '".$stamp."');";

		try{
			$records = $this->dbConnector->sqlQuery($connection, $strSQL);
			$this->succesString .= "Timezone: " . $zone . ", Successfully transferred to database \r\n"; 
		}
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}
	}

	public function flushDB($connection){

		$strSQL = "TRUNCATE timestamps;";
	
		try{
			$records = $this->dbConnector->sqlQuery($connection, $strSQL);
		}
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}
	}

	public function report($datetime){
		if(succesString != ""){
		Logger::logSuccess("\r\nSuccesfully inserted into database:\r\n--------------------------------------------------------\r\n", $this->succesString, $datetime);
		}
	}
}

?>