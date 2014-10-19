<?php

class Logger{

	public function __construct(){

	}

	private static function log($string, $filename){

		$logFile = fopen("logs/" . $filename . ".txt", "a");

		if(!fwrite($logFile, $string)){

			throw new Exception ("Error: Couldn't write to logfile");

		}
		fclose($logFile);
	}

	public static function logSomething($header, $s, $datetime){

		$string = $header;

		$string .= "\r\n" . $s . "\r\n";
		
		self::log($string, $datetime);

	}
}

?>