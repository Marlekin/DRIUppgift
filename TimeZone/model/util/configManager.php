<?php

class ConfigManager{

	private $config;

	public function __construct(){

	}

	public function readConfig($path, $filename){
		$this->config = (array)simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . $path . $filename);
	}

	public function getConfig($path, $filename){

		$this->readConfig($path, $filename);

		return $this->config;
	}

}

?>