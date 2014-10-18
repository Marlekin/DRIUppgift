<?php 

class DBConnector{

private $connection;

public function __construct(){
  
}
	//Connect to MySQL database
	public function connect($host, $userName, $password, $db){
		
		$this->connection = mysqli_connect($host, $userName, $password, $db);
		
		if (!$this->connection) 
		{
			throw new Exception("Error: Can't connect to the database, aborting script");
		}
		
		return $this->connection;
	
	}
	
	//Make a query towards the database
	public function sqlQuery($connection, $strSQL)
	{	
		if(!$records = mysqli_query($connection, $strSQL, MYSQLI_USE_RESULT))
		{
			throw new Exception("Error: Can't query database, aborting script");
		}
		
		return $records;
		
	}
	
	//Clear set of records from query
	public function freeResult($records)
	{
		mysqli_free_result($records);
	}
	
	//Close connection to MySQL database
	public function close($connection)
	{
		if(!mysqli_close($connection))
		{
			throw new Exception("Error: Can't disconnect from the database");
		}
	}
	
}
	
	

?>