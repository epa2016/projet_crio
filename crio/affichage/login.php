<?php
	require_once 'inc/db.php';
	require_once 'inc/functions.php';
	logged();
	if(!empty($_POST) && !empty($_POST['name']) && !empty($_POST['password_hash'])){
		

		$req = $dbh->prepare('SELECT * FROM mrbs_users WHERE name = :name');
		$req->execute(['name' => $_POST['name']]);
		$user = $req->fetch();

		
		if(password_verify($_POST['password_hash'], $user->password_hash)){
			$_SESSION['auth'] = $user;
			$_SESSION['flash']['success']='Vous êtes maintenant connecté';
			header('Location:index.php');
			exit();
		}
		else{
			$_SESSION['flash']['danger']='Identifiant ou mot de passe incorrecte';
			header('Location:login.php');
			exit();
		}
	}
?>

<?php require'inc/header.php'; ?>

<h1>Se connecter</h1>


<form action="" method="POST">
	<div class="form-group">
		<label for="">Identifiant</label>
		<input type="text" name="name" class="form-control" />
	</div>
	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="password_hash" class="form-control" />
	</div>
	<button type="submit" class="btn btn-primary">Se connecter</button>


<?php require'inc/footer.php'; ?>