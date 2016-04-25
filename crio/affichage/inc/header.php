<?php

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="img/favicon.ico">
	<title>Crio Multimedia</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/sticky-footer-navbar.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            		<span class="sr-only">Toggle navigation</span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
            		<span class="icon-bar"></span>
          		</button>
				<a class="navbar-brand" href="index.php"><img style="logo" alt="Logo" src="img/logo.png" class="pull-left"></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
	          	<ul class="nav navbar-nav">
	            	<?php if(isset($_SESSION['auth'])): ?>
	              	<li><a href="index.php">Affichage</a></li>
	              	<li><a href="users.php">Utilisateurs</a></li>
	              	<li><a href="import.php">Mise à jour utilisateurs</a></li>
	              	<li><a href="logout.php">Se déconnecter</a></li>
	            	<?php else: ?>
	              	<!-- <li><a href="register.php">S'inscrire</a></li>
	              	<li><a href="login.php">Se connecter</a></li>
	              	<li><a href="account.php">Mon compte</a></li> -->
	            	<?php endif ?>
	          	</ul>
        	</div><!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">

	<?php if(isset($_SESSION['flash'])): ?>
    	<?php foreach ($_SESSION['flash'] as $type => $message): ?>
        	<div class="alert alert-<?= $type; ?>">
        		<?= $message; ?>
        	</div>
      	<?php endforeach ?>
      	<?php unset($_SESSION['flash']);?>
    <?php endif ?>