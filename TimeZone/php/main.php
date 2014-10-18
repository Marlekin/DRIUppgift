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
	
	private $started;
	private $transferDone;
										
	public function __construct(){
	
		$this->started = false;
		$this->transferDone = false;
		$this->errors = "";
				
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
			echo("<p class='ok'>Database connection opened</p>");
		}
		
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
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
					return true;
				}
			}	
		}
			
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
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
						
		for($i = 0; $i < 5; $i++){				
		
			try{
			$stampContent = $stampFetch -> fetchTimeStamp(self::J_TIMESTAMPS, "bej");
			
			if(array_key_exists("datetime", $stampContent)){
			
				if($stampFetch->isValidFormat($stampContent["datetime"])){
							
					$stamp = $stampFetch -> convertStamp($stampContent["datetime"]);
										
					$this->writeToDB($zoneList[$i], $stamp);
											
				}
				
				else{
			
					$this->errors .= "The datetime of " . $zoneList[$i] . " is of invalid format, skipped <br />";
		
				}
			
			}		
			
			else{
				$this->errors .= $zoneList[$i] . " does not have a timestamp, skipped <br />";
			}
			
			}
			
			catch(Exception $e){
			
				echo $e->getMessage();
			
			}

		}
	
		$this->query->report($this->datetime);
		$this->stampFetch->report($this->datetime);
		
		$this->transferDone = true;
		
	}
	
	//Kasta ett exception om inte går
	public function writeToDB($zone, $stamp){
			
			$this->query->insertTimezone($this->mysqli_connection, $zone, $stamp);

	}
	
	
	public function presentResults(){
	

	echo "
	<h2>Successful transfers:</h2>
	<article class='valid'>" . $this->query->listZones($this->mysqli_connection) . "</article>
	";
	
	echo "
	<h2>Failed transfers:</h2>
	<article class='invalid'>" . $this->errors . "</article>
	";
	
	}
	
		
	//close connection to database
	public function disconnectDB($connection){
		
	$dbConnector = new DBConnector();

		try{
			$dbConnector->close($connection);
			echo "<p class='ok'>Database connection closed</p>";
		}
		catch(Exception $e){
			echo "<p class='error'>" . $e->getMessage() . "</p>";
			unlink(SessionManager::getSession());
			exit();
		}
			
	}
		
}
				

?>