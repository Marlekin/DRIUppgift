﻿<?php

class SessionManager{

	private $session;

	public function __construct(){

		$this->session = (basename($_SERVER['DOCUMENT_ROOT'] . 
			'/TimeZone3/index.php' , '.php') . '.run');
	
	}
	
	public function startSession(){

		if(!file_exists($this->session)){
			touch($this->session);
		}
		else{
			throw new Exception("Script is already running, please wait");
		}
	}


	public function stopSession(){

		unlink($this->session);

	}


}

?>