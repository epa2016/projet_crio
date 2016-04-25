<?php
	
	$login = "mrbscrio";
	$pass = "mrbscrio2016";
	$error1 = "Connexion impossible à la base de données";

	try{
		$dbh = new PDO('mysql:host=localhost;dbname=mrbs', $login, $pass);
		$dbh->exec("set names utf8");
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}
	catch(PDOException $e){
		echo $error1;
	}
?>