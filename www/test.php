<?php

	define('DBNAME', 'store');
	define('DBUSER', 'root');
	define('DBPASS', 'chygo');

	try{

	$conn = new PDO('mysql:host=localhost;dbname'.DBNAME, DBUSER, DBPASS);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

	} catch(PDOException $err) {
		echo $err->getMessage();
	}

	

?>