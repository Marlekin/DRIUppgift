<?php
		
		
include ("../DBComm/dbConnector.php");
include ("../DBComm/dbQuery.php");
include ("../TimeIntegration/timeCommunication.php");
include ("../TimeIntegration/timeFetch.php");
include ("../Logging/logger.php");

				
class Main{
		
	const DB_HOST = "localhost";
	const DB_USERNAME = "admin";
	const DB_PASSWORD = "";
	const DB = "dridb";
	
	
	const J_DOMAIN ="http://json-time.appspot.com/";	
	const J_TIMEZONES ="http://json-time.appspot.com/timezones.json";
	const J_TIMESTAMPS ="http://json-time.appspot.com/time.json?tz=";
			
	private $dbConnector;
	private $mysqli_connection;
	private $json_array;
					
	public function __construct(){
		
		$this->connectDB();
			
		$this->communicateWS();
				
		$this->disconnectDB($this->mysqli_connection);
				
	}
						
	//Establish connection to database
	public function connectDB(){
	
		$this->dbConnector = new DBConnector();
				
		try{
			$this->mysqli_connection = $this->dbConnector->connect(self::DB_HOST, self::DB_USERNAME, self::DB_PASSWORD, self::DB);
			echo("<p>Database connection opened</p>");
		}
		
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
		}

	}
		
	//Check availability of domain and validity of file. Fetch if avaliable and valid.
	public function communicateWS(){
		
		$comm = new TimeCommunication();
	
		try{
			if($comm->isDomainAvailable(self::J_DOMAIN)){
					
				if ($comm->isValidJSON(self::J_TIMEZONES)){
				
							
					$this->processJSON();
				
				}
						
			}	
		}
			
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
		}
		
	}
		
	//Fetch timezones and timestamps
	public function processJSON(){
		
		$fetch = new TimeFetch();
					
		try{
						
		$this->json_array = $fetch->fetchJson(self::J_TIMEZONES, self::J_TIMESTAMPS);
		
		$elementCount = count($this->json_array);
		
		for($i = 0; $i < $elementCount ; $i++){
		
		try{
			$this->writeToDB($this->json_array[0]["name"], $this->json_array[0]["dt"]);
		}
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
		}
		
		}
						
				
		}
		
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
		}
	
	}
	
	
	public function writeToDB($zone, $stamp){
	
		$started = false;
		$query = new DBQuery($this->dbConnector);

		try{
		
			if(!$started){
		
				$query->flushDB($this->mysqli_connection);
				$started = true;
			}
	
			$query->insertTimezone($this->mysqli_connection, $zone, $stamp);
			
		}
		
		catch(Exception $e){
		
			throw new Exception("Error occurred when attempting to write to database");
		
		}
	
	
	}
	
		
	//close connection to database
	public function disconnectDB($connection){
		
	$dbConnector = new DBConnector();

		try{
			$dbConnector->close($connection);
			echo "<p>Database connection closed</p>";
		}
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
		}
			
	}
		
}
				

?>