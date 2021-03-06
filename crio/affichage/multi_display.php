<?php

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    require 'inc/functions.php';
	logged_only();
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

	<?php
	ob_start();
	header('content-type: text/html; charset=utf-8');

	#Création d'une connection à la base de données
	require_once('inc/db.php');

		$sql_area = 'SELECT MIN(morningstarts) as minimum FROM mrbs_area';
		$req = $dbh->query($sql_area);
		$resultat = $req->fetch(PDO::FETCH_OBJ);
		$min_value = $resultat->minimum;

		//Variables temporelles
		$botd = mktime(0, 0, 0, date('m'), date('d'), date('Y')); #Timestamp du début du jour
		$eotd =  mktime(23, 59, 59, date('m'), date('d'), date('Y')); #Timestamp de la fin de journée
		$book_start = $botd + ($min_value*60*60); //La variable $book_start est initialisée à la date de début de réservation ici la date du début du jour + 10h
		$book_end = $eotd - (2*60*60) - 1; ////La variable $book_end est initialisée à la date de fin de réservation ici la date de fin du jour - 1h59min59s
		
		if (!empty($_GET['salle'])) {
			$rooms = $_GET['salle'];
			//REQUETES SQL

			//Préparation d'une requête pour chaque salle
			foreach ($rooms as $key => $value) {
				${"sql_room_".$key} = 'SELECT start_time, end_time, name, create_by FROM mrbs_entry WHERE start_time BETWEEN '.$botd.' AND '.$eotd.' AND room_id='.$value.' ORDER BY start_time';
				$sql_room[] = ${"sql_room_".$key};
			}
			unset($value);

			//Préparation d'une requête pour récupérer le nom de chaque salle
			foreach ($rooms as $key => $value) {
				${"sql_name_room_".$key} =  'SELECT room_name FROM mrbs_room WHERE id = '.$value.''; 
				$sql_name_room[] = ${"sql_name_room_".$key};
			}
			unset($value);
			
			//EXECUTION DES REQUETES

			foreach ($sql_room as $key => $value) {
				${"req_room_".$key} = $dbh->query($value);
				$req_room[] = ${"req_room_".$key};
			}
			unset($value);

			foreach ($sql_name_room as $key => $value) {
				${"req_name_room_".$key} = $dbh->query($value);
				$req_name_room[] = ${"req_name_room_".$key};
			}
			unset($value);

			//Récupération du nom des salles pour l'en tete du tableau
			foreach ($req_name_room as $key => $value) {
				${"s".$key} = $value->fetch(PDO::FETCH_OBJ);
				${"nom_salle_".$key} = ${"s".$key}->room_name;
			}
			unset($value);

			/*echo '<div class="jumbotron"><div class="container">';*/
			setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
			echo '<h3>'.strftime("%A %d %B %Y").'</h3>';
			/*echo '</div></div><div class="container">';*/
			echo '<div class="row"><div class="">';			
			echo '<table class="table table-hover"><tr class="active"><th>Horaires</th>';

			foreach ($req_name_room as $key => $value) {
				echo '<th>'.${"nom_salle_".$key}.'</th>';
			}

			echo '</th></tr><tr>';

			foreach ($req_room as $key => $value) {
				while ($d = $value->fetch(PDO::FETCH_OBJ)) {
					${"table_room_".$key}[] = $d;
				}
				unset($d);
			}
			
			$nb_row = count($req_room);

			while ($book_start<$book_end) {
				$heure_debut = date('H:i',$book_start);
				$heure_fin = date('H:i',$book_start+3600);
				echo '<tr><td class="active" width="1%">'.$heure_debut.'<br>'.$heure_fin.'</td>';
				
				foreach ($req_room as $key => $value) {
					${"ok_room_".$key} = false;
				}

				for ($i=0; $i <=$nb_row-1 ; $i++) { 
					if(!empty(${"table_room_".$i})){
						foreach (${"table_room_".$i} as $key=>$value) {
							if($value->start_time == $book_start AND $value->start_time != $value->end_time){
								${"ok_room_".$i} = true;
								$value->start_time = $value->start_time + 3600; ////////////////////////////////
								$indice = $key;
							}
						}
						unset($value);

						if(${"ok_room_".$i}==true){
							$reunion = ${"table_room_".$i}[$indice]->name;
							$utilisateur = ${"table_room_".$i}[$indice]->create_by;
							echo '<td class="danger">'.$reunion.'<br>'.$utilisateur.'</td>';
						}
						else{
							echo "<td class=\"success\">Disponible</td>";
						}
					}
					else{
						echo "<td class=\"success\">Disponible</td>";
					}
				}
				$book_start = $book_start + 3600;
			}
			$l1 = NULL;
			foreach ($rooms as $key => $value) {
				if($key<$nb_row-1)
					$l1 .= $value.'&salle%5B%5D=';
				else
					$l1 .= $value;
			}
			unset($value);
			$l2 = '?salle%5B%5D='.$l1;

			$page = $_SERVER['PHP_SELF'].$l2;
			//echo $page;
			$sec = "15";
			header("Refresh: $sec; url=$page");
			//exit;
			ob_end_flush();
		}
		?>
	</table>
	</div></div></div>

<?php require 'inc/footer.php';?>