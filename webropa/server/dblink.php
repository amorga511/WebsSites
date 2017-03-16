<?php 
/*
	$server = "mysql.hostinger.es";
	$user = "u301269794_uempr";
	$pwd = "morga2";
	$db = "u301269794_empr1";
	*/
	$server = "localhost";
	$user = "root";
	$pwd = "";
	$db = "llantas_db";

	$con = new mysqli($server, $user, $pwd, $db);
	if($con->connect_error)
	{
		echo $con->connect_error();
	}
?>