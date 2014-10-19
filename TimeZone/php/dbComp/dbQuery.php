<?php

class DBQuery{

	private $dbConnector;
	private $succesString;
	private $dbCount;

	public function __construct($connector){

		$this->dbConnector = $connector;
		$this->succesString = "";
		$this->dbCount = 0;

	}

	//List data currently in table
	public function listZones($connection){
	
		$strSQL = "SELECT * FROM timestamps";
		$results = "";
	
		try{
			$records = $this->dbConnector->sqlQuery($connection, $strSQL);
			
			while($record = mysqli_fetch_assoc($records)){
				$results .= $record['timezone'] . " " . $record['timestamp'] . "<br />";
				
				$this->dbCount++;
				
			}
			$this->dbConnector->freeResult($records);
		}
		catch(Exception $e){
			echo "<p class='notice'>" . $e->getMessage() . "</p>";
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
			echo "<p class='notice'>" . $e->getMessage() . "</p>";
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
			echo "<p class='notice'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}
	}
	
	public function getCount(){
		return $this->dbCount;
	}

	public function report($datetime){
		if($this->succesString != ""){
		Logger::logSomething("\r\nSuccesfully inserted into database:\r\n--------------------------------------------------------\r\n", $this->succesString, $datetime);
		}
	}
}

?>