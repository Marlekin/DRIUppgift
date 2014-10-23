<?php

/**
*Handles the session for the runtime of the script. Does this by dropping
*a file at a given location. If the file exists, the script is running.
*Removes file at the end of script runtime.
*/
class SessionManager{

	/**This variable holds a path to the session file*/
	private static $session;
	
	/**
	*If a file doesn't already exists, this operation drops a file at a given location
	*If the file exists, throws an exception
	*
	*@return bool
	*/
	public static function startSession(){

		if(!file_exists(self::$session = (basename($_SERVER['DOCUMENT_ROOT'] . 
			'/TimeZone3/index.php' , '.php') . '.run'))){
			touch(self::$session);
			return true;
		}
		else{
			throw new Exception("<p class='notice'>Already running</p>");
			return false;
		}
		
	}

	/**
	*Stops the session by removing the file
	*
	*@return void
	*/
	public static function stopSession(){

		unlink(self::$session);

	}
}

?>