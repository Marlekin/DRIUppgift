<?php

include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/controller/utilController.php");

/**
*Handles the updating of the view with the dynamic content
*/
class TimeView{

	/**
	*@var UtilController Holds an instance of the util controller
	*/
	private $utilController;
	
	public function __construct(){

		echo "<h1> Eventlog </h1>";

		$this->utilController = new utilController($this);
	}


	/**
	*Updates the view with results from database insertion.
	*
	*@param string $successes List of successful DB inserts as string. Can't be empty.
	*@return void
	*/
	public function showSuccesses($successes){

		echo $successes;

	}

	/**
	*Updates the view with results from database insertion.
	*
	*@param string $errors List of errors encountered when fetching from WS. Can't be empty.
	*@return void
	*/
	public function showErrors($errors){

		echo $errors;
		
	}


	/**
	*Updates the view with a notice of an event
	*
	*@param string $message A message that displays information about something which occurred during the process. Can't be empty.
	*
	*@return void
	*/
	public function showNotice($message){
		
		echo $message;

	}
}


?>