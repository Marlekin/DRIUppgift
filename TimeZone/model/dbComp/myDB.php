<?php

include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/dbComp/medoo/medoo.php");

class MyDB extends medoo{


	public function __construct($options){
		parent::__construct($options);
	}

}


?>