<?php


/**
*Inherits from class MyDB. Stores variables and handle operations that are
*specific for the given MySQL database
*/
class MySQLDB extends MyDB{


	/**
	*@var string The name of the MySQL DB. Can't be empty or null
	*/
	private $dbName;

	/**
	*@var string The name of the MySQL DB table. Can't be empty or null
	*/
	private $tblName;

	/**
	*@var string The name of the timezone column in the MySQL DB. Can't be empty or null
	*/
	private $zoneCol;

	/**
	*@var string The name of the timestamp column in the MySQL DB. Can't be empty or null
	*/
	private $stampCol;

	/**
	*@var int The count of succesful DB insertions. Can't be empty or null
	*/
	private $dbCount;

	/**
	*Calls the parent constructor with the incoming DB settings for connecting to the database 
	*
	*@param string[] $options Array containing settings for the database. Can't be null or empty. 
	*/
	public function __construct($options){

		parent::__construct($options);

		$this->dbCount = 0;

		$this->dbName = $options['database_name'];
		$this->tblName = $options['table_name'];
		$this->zoneCol = $options['timezone_column'];
		$this->stampCol = $options['timestamp_column'];
		

	}

	/**
	*Routes a select-query to MyDB, giving the table name and column names
	*
	*@return string[] A two-dimensional array containing timezones and timestamps
	*/
	public function selectSQL(){

		$results = parent::selectSQL($this->tblName, $this->zoneCol, $this->stampCol);

		return $results;

	}

	/**
	*Routes an insert-query to MyDB, giving the table name, the column names and the items to be inserted
	*
	*@param string $zone The timezone name, can't be empty or null
	*@param string $stamp The timestamp, can't be empty or null
	*@return void
	*/
	public function insertSQL($zone, $stamp){

		parent::insertSQL($this->tblName, $this->zoneCol, $this->stampCol, $zone, $stamp);

		$this->dbCount ++;

	}

	/**
	*Makes a query to truncate the table in the MySQL database
	*
	*@return void
	*/
	public function truncateSQL(){

		$strSQL = "TRUNCATE " . $this->tblName;

		$this->query($strSQL);

	}

	/**
	*Gets the count of successful database insertions
	*
	*@return int Returns the amount of succesfull DB inserts. Can't be null
	*/
	public function getCount(){

		return $this->dbCount;

	}

	/**
	*Gets the name of the timezone column in the MySQL database
	*
	*@return string Returns the timezone column name
	*/
	public function getZoneColumn(){

		return $this->zoneCol;	

	}

	/**
	*Gets the name of the timestamp column in the MySQL database
	*
	*@return string Returns the timestamp column name
	*/
	public function getStampColumn(){

		return $this->stampCol;	
		
	}




}

?>