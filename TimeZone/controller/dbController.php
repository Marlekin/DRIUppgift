<?php



class DBController{

	private $myDB;
	private $results;

	public function __construct(){

	}

	public function setDatabase($options){

		switch ($options['database_type']) {
			case 'mysql':
			
				$this->myDB = new MySQLDB($options);
				break;
			
			default:

				throw new Exception("Could not connect to database");
				break;
		}

	}

	public function insertToTable($table, $val1, $val2, $zone, $stamp){

		$this->myDB->insertSQL($table, $val1, $val2, $zone, $stamp);

	}

	public function selectFromTable($table){

		$results = $this->myDB->selectSQL($table);

		return $results;

	}

	public function flushTable($table){

		$this->myDB->truncateSQL($table);

	}


	public function report(){
		
	}


}

?>