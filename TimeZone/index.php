﻿<!DOCTYPE html>

	<head> 
		<meta charset="utf-8" />
		<title> TimeZone </title>
		<link rel="stylesheet" type="text/css" href="css/timeStyle.css" />
	</head>

	<body>

		<section>

			<?php

			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/controller/utilController.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/controller/timeController.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/controller/dbController.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/timeComp/timeComm.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/timeComp/zoneFetch.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/timeComp/stampFetch.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/dbComp/myDB.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/dbComp/mySQLDB.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/util/sessionManager.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/util/logger.php");
			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/model/util/configManager.php");

			ignore_user_abort(true);
			set_time_limit(0);

			include($_SERVER['DOCUMENT_ROOT'] . "/TimeZone3/view/timeView.php");

			
			new TimeView();

			?>

		</section>

	</body>

</html>