<?php

class MySQLDB extends MyDB{

	private $dbCount;
	private $results;

	public function __construct($op){
		parent::__construct($op);

		$this->dbCount = 0;

	}

	public function selectSQL($table){

		$strSQL = "SELECT * from " . $table . "";

		$this->results = $this->query($strSQL)->fetchAll();

		return $this->results;

	}

	public function insertSQL($table, $val1, $val2, $zone, $stamp){

		$strSQL = "INSERT INTO " . $table . " (" . $val1 . ", " . $val2 . ") 
		VALUES ('" . $zone . "', '" . $stamp . "')";

		$this->query($strSQL);

	}


	public function truncateSQL($table){

		$strSQL = "TRUNCATE " . $table;

		$this->query($strSQL);

	}

	public function getCount(){

		foreach($results as $i){

			$this->dbCount++;

		}

		return $this->dbCount;
	}


}

?>