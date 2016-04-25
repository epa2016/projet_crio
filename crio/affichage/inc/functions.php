<?php

function debug($variable){
	echo '<pre>'. print_r($variable,true) . '</pre>';
}

function str_random ($length){
	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

}

function logged_only (){
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
  	}
  	if(!isset($_SESSION['auth'])){
  		$_SESSION['flash']['danger'] = "Vous devez vous identifier pour accéder à cette page";
  		header('Location:login.php');
  		exit();
  	}
}

function logged (){
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
  	}

  	if(isset($_SESSION['auth'])){
  		header('Location:index.php');
  		exit();
  	}

}