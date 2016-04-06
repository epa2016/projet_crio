
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="img/favicon.ico">
	<title>Crio Multimedia</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/navbar-static-top.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#"><img style="logo" alt="Logo" src="img/logo.png" class="pull-left"></a>
			</div>
		</div>
	</nav>

	<div class="jumbotron">
		<div class="container">
			<h1>Affichage quotidien</h1>
			<p>Veuillez choisir 3 salles dans la liste ci-dessous</p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<?php
				echo '<h4>';
				setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
				echo strftime("%A %d %B %Y");
				echo '</h4>';
				?>
				<form action="multi_display.php" name="formulaire" method="get">
					<div class="form-group">
						<select class="form-control" name="salle[]" multiple >
							<?php
							require_once('connection.php');
							$a = "r.id";
							$b = "r.room_name";
							$c = "r.area_id";
							$d = "a.id";

							$sql = 'SELECT '.$a.' as identifiant, '.$b.' as nom FROM mrbs_room r, mrbs_area a WHERE '.$c.' = '.$d.'';
							$req = $dbh->query($sql);

							while($d = $req->fetch(PDO::FETCH_OBJ)){

								$valeur = $d->identifiant;
								$nom = $d->nom;
								echo '<option value="'. $valeur .'">'. $nom .'</option>';
							}
							?>
						</select>
						<h5>(CTRL + clic)</h5>
					</div>
					<button type="submit" class="btn btn-default">Afficher</button>
				</form>
			</div>
		</div>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>