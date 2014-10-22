<?php

class UtilController{

	private $timeView;
	private $timeController;
	private $dbController;
	private $sessionManager;
	private $configManager;

	public function __construct($view){
		$this->timeView = $view;

		$this->sessionManager = new SessionManager();
		$this->configManager = new ConfigManager();
		$this->timeController = new TimeController();
		$this->dbController = new DBController();

	}

	//Methods for SessionManager
	public function start(){
		try{

			$this->sessionManager->startSession();

			$this->dbController->setDatabase(
				$dbConfig = $this->loadConfig(
								"/TimeZone3/model/dbComp/config/","mySQLConfig.xml"));

			$this->setViewNotice("<p class ='ok'>Database connection established</p>");

			$this->dbController->flushTable($dbConfig['table_name']);

		

			if($this->timeController->communicateWS($wsConfig = $this->loadConfig(
									"/TimeZone3/model/timeComp/config/", "timeConfig.xml"))){

				$timeZones = $this->timeController->fetch($wsConfig);
				$elements = count($timeZones['zone']);

				for($i = 0; $i < $elements; $i++){

					$this->writeToDB($dbConfig['table_name'], $dbConfig['timezone_column'],
							$dbConfig['timestamp_column'], $timeZones['zone'][$i], $timeZones['stamp'][$i]);


				}
				$this->setViewErrors();
			}

		}

		catch(Exception $e){
			$this->setViewNotice("<p class='notice'>" . $e->getMessage()) . "</p>";
		}

		
		
		$this->stop();
	}

	public function stop(){
			
		$this->sessionManager->stopSession();	

	}

	//Methods for logger
	public function logSomething($headerString, $contentString){
		Logger::log($headerString, $contentString);
	}

	//Methods for ConfigManager
	public function loadConfig($path, $filename){
		$config = $this->configManager->getConfig($path, $filename);
		return $config;
	} 

	public function writeToDB($table, $val1, $val2, $zone, $stamp){
			
			$this->dbController->insertToTable($table, $val1, $val2, $zone, $stamp);
		
	}

	public function setViewNotice($message){
		$this->timeView->showNotice($message);
	}

	public function setViewSuccesses(){

	}

	public function setViewErrors(){

		$errors = "<h2>Failed transfers:</h2>
		<article class='invalid'>" 
		. $this->timeController->reportErrors() . 
		"</article>";

		$this->timeView->showErrors($errors);

	}

}


?>