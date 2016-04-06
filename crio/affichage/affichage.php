
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/favicon.ico">
	<title>Crio Multimedia</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/navbar-static-top.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<!--
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#"><img style="logo" alt="Logo" src="img/logo.png" class="pull-left"></a>
			</div>
		</div>
	</nav>
	-->

	<?php
	#Création d'une connection à la base de données
	require_once('connection.php');


	$today = mktime(0, 0, 0, date('m'), date('d'), date('Y')); #Timestamp du début du jour
	$tomorrow =  mktime(23, 59, 59, date('m'), date('d'), date('Y')); #Timestamp de la fin de journée
	if (!empty($_GET['salle'])) {
		$salle = $_GET['salle'];
		$sql = 'SELECT start_time, end_time, name, create_by FROM mrbs_entry WHERE start_time BETWEEN '.$today.' AND '.$tomorrow.' AND room_id='.$salle.' ORDER BY start_time';
		$sql_room =  'SELECT room_name FROM mrbs_room WHERE id = '.$salle.''; //requete sql pour récupérer le nom de la salle
		$req = $dbh->query($sql);

		$req_room = $dbh->query($sql_room);
		$s = $req_room->fetch(PDO::FETCH_OBJ);
		$nom_salle = $s->room_name;

		echo '<div class="jumbotron"><div class="container"><h3>';echo $nom_salle;echo '</h3>';
		echo '<p>';
		setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
		echo strftime("%A %d %B %Y");
		echo '</p></div></div><div class="container"><div class="row"><div class="">';			
		echo '<table class="table table-hover"><tr><th>Horaires</th><th>Nom de la réunion</th><th>Utilisateur</th></tr><tr>';

		while($d = $req->fetch(PDO::FETCH_OBJ)){
			$heure_debut = date('H:i',$d->start_time);
			$heure_fin = date('H:i',$d->end_time);
			$reunion = $d->name;
			$utilisateur = $d->create_by;
					
			echo '<td>';
			echo $heure_debut;
			echo '<br>';
			echo $heure_fin;
			echo '</td>';
			echo'<td>';
			echo $reunion;
			echo '</td>';
			echo '<td>';
			echo $utilisateur;
			echo '</td>';
			echo '</tr>';
		}
	$page = $_SERVER['PHP_SELF']."?salle=".$_GET['salle'];
	$sec = "10";
	header("Refresh: $sec; url=$page");
	exit;
	}

	$page = $_SERVER['PHP_SELF'];
	$sec = "10";
	header("Refresh: $sec; url=$page");
	?>
	</table>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
	<script src="js/bootstrap.min.js"></script>
	</body>
	</html>