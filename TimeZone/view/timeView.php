
<?php

/**
*Something about this class just gives me the creeps
*/
class TimeView{

	private $utilController;
	
	public function __construct(){

		echo "<h1> Eventlog </h1>";

		$this->utilController = new utilController($this);

		$this->start();
		
	}

	
	/**
	*Invokes the start method in utilController
	*@return void
	*/
	public function start(){
		$this->utilController->start();
	}



	/**
	*Updates the view with results from web service fetching and database insertion.
	*
	*@param string $successes | List of successful DB inserts as string. Can't be empty.
	*@param string $errors | List of errors in fetching or converting as string. Can't be empty
	*@return void
	*/
	public function showSuccesses($successes){
	}

	public function showErrors($errors){

		echo $errors;
		
	}


	public function showNotice($message){
		echo $message;
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
}


?>