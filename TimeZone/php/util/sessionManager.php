<?php

class SessionManager{

	private static $session;

	public static function setSession($run){

		self::$session = $run;

	}

	public static function getSession(){

		return self::$session;

	}
}

?>