<?php
		
	include ("dbConnector.php");
	include ("timeCommunication.php");
	include ("timeFetch.php");
				
		class Main{
		
			const DB_HOST = "localhost";
			const DB_USERNAME = "admin";
			const DB_PASSWORD = "";
			const DB = "dridb";
		
			const J_TIMEZONES ="http://json-time.appspot.com/timezones.json";
			const J_TIMESTAMPS ="http://json-time.appspot.com/time.json?tz=";
			
			private $dbConnector;
			private $mysqli_connection;
					
			public function __construct(){
		
				$this->dbConnector = new DBConnector();
				
				$this->connectDB();
				
				$this->communicateWS();
				
				$this->disconnectDB($this->mysqli_connection);
				
		}
						
		//Establish connection to database
		public function connectDB(){
		
			try{
				$this->mysqli_connection = $this->dbConnector->connect(self::DB_HOST, self::DB_USERNAME, self::DB_PASSWORD, self::DB);
				echo("<p>Database connection opened</p>");
			}
		
			catch(Exception $e){
				echo "<p class='error'>" . $e->getMessage() . "</p>";
			}
		
		
		}
		
		//Check availability domain and file
		public function communicateWS(){
		
			$comm = new TimeCommunication(self::J_TIMEZONES);
		
			try{
				if($comm->isDomainAvailable(self::J_TIMEZONES)){
	
					$this->fetch();
		
				}	
			}
			
			catch(Exception $e){
				echo "<p class='error'>" . $e->getMessage() . "</p>";
			}
		
		}
		
		//Fetch timezones and timestamps
		public function fetch(){
		
			$fetch = new TimeFetch();
		
			try{
				$fetch->fetchTimeZones(self::J_TIMEZONES);
				$fetch->fetchTimeStamps(self::J_TIMESTAMPS);
			}
			catch(Exception $e){
				echo "<p class='error'>" . $e->getMessage() . "</p>";
			}
		}
		
		//close connection to database
		public function disconnectDB($connection){

			try{
				$this->dbConnector->close($connection);
				echo "<p>Database connection closed</p>";
			}
			catch(Exception $e){
				echo "<p class='error'>" . $e->getMessage() . "</p>";
			}
		
		}
		
		}
				

?>