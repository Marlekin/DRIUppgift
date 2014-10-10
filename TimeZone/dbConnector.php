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
			throw new Exception(mysqli_connect_errno().": ".mysqli_connect_error());
		}
		
		return $this->connection;
	
	}
	
	//Make a query towards the database
	public function sqlQuery($connection, $strSQL)
	{	
		if(!$records = mysqli_query($connection, $strSQL, MYSQLI_USE_RESULT))
		{
			throw new Exception(mysqli_errno($connection).": ".mysqli_error($connection));
		}
		
		return $recordSet;
		
	}
	
	//List data currently in table
	public function listTableData($connection){
	
	$this->strSQL = "SELECT * FROM timestamps";
	$records = sqlQuery($connection, $this->strSQL);
	
	while($record = mysqli_fetch_assoc($records)){
	
	echo($record['timezone']);
	
	}
	
	freeResult($records);
	
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
			throw new Exception(mysqli_errno($connection).": ".mysqli_error($connection));
		}
	}
	
}
	
	

?>