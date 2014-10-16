<?php

class Logger{

private static $logFile;

public function __construct(){

}


public static function logSomething($string){

$logFile = fopen("../Logging/Logs/log.txt", "w") or die ("Can't open file");
fwrite($logFile, $string);
fclose($logFile);

}

}

?>