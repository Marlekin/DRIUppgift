<?php
		
		
include ("dbComp/dbConnector.php");
include ("dbComp/dbQuery.php");
include ("timeComp/timeComm.php");
include ("timeComp/timeFetch.php");
include ("timeComp/stampFetch.php");
include ("util/logger.php");

				
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
	private $query;
	
	private $datetime;
	private $errors;
	private $errorCount;
	
	private $started;
	private $transferDone;
										
	public function __construct(){
	
		$this->started = false;
		$this->transferDone = false;
		$this->errors = "";
		$errorCount = 0;
				
		echo "<h1>Eventlog</h1>";
	
		$this->connectDB();
		
		$this->query = new DBQuery($this->dbConnector);
			
		if($this->communicateWS()){
		
			$this->datetime = date('dmy_H-i-s');
			
			$this->transfer();
			
			if($this->transferDone){

			$this->presentResults();
			
			}
		}
		
		$this->disconnectDB($this->mysqli_connection);
	}
		
	
						
	//Establish connection to database
	public function connectDB(){
		
		try{
			$this->dbConnector = new DBConnector();
		
			$this->mysqli_connection = $this->dbConnector->connect(self::DB_HOST, self::DB_USERNAME, self::DB_PASSWORD, self::DB);
			echo("<p class='ok'>Database connection opened...</p>");
		}
		
		catch(Exception $e){
			echo "<p class='notice'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}

	}
		
	//Check availability of domain and validity of file. Fetch if avaliable and valid.
	public function communicateWS(){
		
		$comm = new TimeComm();
	
		try{
			if($comm->isDomainAvailable(self::J_DOMAIN)){
					
				if ($comm->isValidJSON(self::J_TIMEZONES)){
					echo("<p class='notice'>Web service availability validated, transfer process started...</p> <br />");
					return true;
				}
			}	
		}
			
		catch(Exception $e){
			echo "<p class='notice'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}
		
		return false;
		
	}
		
	//transfer from WS to DB
	public function transfer(){
	
		$this->query->flushDB($this->mysqli_connection);
				
		$timeFetch = new TimeFetch();
		$stampFetch = new StampFetch();
		
		$stampContent = array();
		$validArray = array();
		$validIndex = 0;
		
		$succesString ="";
		
		$zoneList = $timeFetch -> fetchTimeZones(self::J_TIMEZONES);		
		$elementCount = count($zoneList);
						
		for($i = 0; $i < $elementCount; $i++){				
		
			try{
			
			$stampContent = $stampFetch -> fetchTimeStamp(self::J_TIMESTAMPS, $zoneList[$i]);
			
			if($stampFetch->hasDateTime($stampContent, $zoneList[$i])){
						
				if($stampFetch->isValidFormat($zoneList[$i])){
																	
					$this->writeToDB($zoneList[$i], $stampFetch->getTimeStamp());
																
				}
			
			}		
						
			}
			
			catch(Exception $e){
			$this->errors .= $e->getMessage() . "<br />";
			$this->errorCount++;
			}

		}
	
		$stampFetch->report($this->datetime);
		$this->query->report($this->datetime);
		
		echo "<p class='notice'>...Transfer process done, events logged</p>";	
		
		$this->transferDone = true;		
		
	}
	
	//Kasta ett exception om inte går
	public function writeToDB($zone, $stamp){
			
			try{
				$this->query->insertTimezone($this->mysqli_connection, $zone, $stamp);
			}
			catch(Exception $e){
				echo "<p class='notice'>" . $e->getMessage() . "</p>";
				unlink(SessionManager::getSession());
				exit();
			}

	}
	
	
	public function presentResults(){
	
		$resultString = $this->query->listZones($this->mysqli_connection);
		
		echo "
		<h2>Successful transfers:</h2>
		<article class='valid'>";
				
		if($resultString != ""){
			echo $this->query->getCount() . " rows has been succesfully transferred<br /><br />" . $resultString;
		}
		else{
			echo "No rows inserted in database";
		}
		
		echo "</article>";
		
		echo "<h2>Failed transfers:</h2>
		<article class='invalid'>";
	
		if($this->errors != ""){
			echo $this->errorCount . " errors occured <br /><br />" . $this->errors; 
		}
		
		else{
			echo "No failed transfers detected";
		}
		
		
		echo "</article>";
	
	}
	
		
	//close connection to database
	public function disconnectDB($connection){
		
	$dbConnector = new DBConnector();

		try{
			$dbConnector->close($connection);
			echo "<p class='ok'>...Database connection closed</p>";
		}
		catch(Exception $e){
			echo "<p class='notice'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}
			
	}
		
}
				

?>