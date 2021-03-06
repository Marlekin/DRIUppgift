﻿<?php

/**
*Handles logging of events in the application
*/
class Logger{

	/**
	*Logs an entry to a local file (txt)
	*
	*@param string $header | The header for the log entry
	*@param string $content | The body for the log entry
	*@param int $count | The count of the number of rows logged
	*@param string $datetime | The filename for the logfile
	*@return void
	*/
	public static function log($header, $content, $count, $datetime){

		$logFile = fopen($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/logs/" . $datetime . ".txt", "a");

		$logString = $header . "\r\n" . "Row count: " . $count . "\r\n" . 
					$content . "\r\n \r\n";

		if(!fwrite($logFile, $logString)){

			throw new Exception ("Error: Couldn't write to logfile");

		}
		fclose($logFile);
	}

}



?>