<?php
	
	$login = "root";
	$pass = "";
	$error1 = "Connexion impossible � la base de donn�es";

	try{
		$dbh = new PDO('mysql:host=localhost;dbname=mrbs', $login, $pass);
		$dbh->exec("set names utf8");
	}
	catch(PDOException $e){
		echo $error1;
	}
?>