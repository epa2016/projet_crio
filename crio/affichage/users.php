<?php 
	require 'inc/header.php';
	require 'inc/functions.php';
	require_once 'inc/db.php';
	logged_only();
?>

<h1>Affichage des 100 premiers utilisateurs</h1>

<?php

	$sql = 'SELECT user, password FROM crio_user LIMIT 100';
	$table_user = $dbh->query($sql);


	echo '<table class="table table-hover"><tr><th>Identifiant</th><th>Mot de passe</th></tr>';
	while($d = $table_user->fetch(PDO::FETCH_OBJ)){
			$username = $d->user;
			$password = $d->password;
					
			echo'<tr><td>';
			echo $username;
			echo '</td>';
			echo '<td>';
			echo $password;
			echo '</td>';
			echo '</tr>';
		}
	echo '</table>';
?>



<?php require'inc/footer.php'; ?>