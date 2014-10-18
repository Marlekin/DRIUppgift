<!DOCTYPE html>

<head>
	<meta charset="utf-8" />
	<title> TimeZone </title>
	<link rel="stylesheet" type="text/css" href="css/timeStyle.css" />
	
</head>

<body>

	<section>
		
	<?php
		
		include("php/main.php");
		include("php/util/sessionManager.php");
		
		
		ignore_user_abort(true);
		set_time_limit(0);
	
		SessionManager::setSession(basename($_SERVER['PHP_SELF'], '.php') . '.run');
			
		if(!file_exists(SessionManager::getSession())){
		
		touch(SessionManager::getSession());
		$main = new Main();
		unlink(SessionManager::getSession());
		
		exit();
		}
		
		else{
		echo "<p class='error'>Error: Script is already running. Wait until database has been populated</p>";
		}
		
	?>


	</section>

</body>

</html>