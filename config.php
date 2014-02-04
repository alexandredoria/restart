<?php
	$host = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_name = "restart";
	$db_connection = mysql_connect($host, $db_user, $db_password) or die("Error: ".mysql_Error());
	mysql_select_db($db_name, $db_connection) or die("Error: ".mysql_Error());
?>