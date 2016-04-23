<?php require 'inc/header.php';?>

	<div class="jumbotron">
		<div class="container">
			<h1>Affichage quotidien</h1>
			<p>Veuillez choisir une ou plusieurs salles dans la liste ci-dessous</p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<?php
				header('content-type: text/html; charset=utf-8');
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
	</div><!-- /.row -->

<?php require 'inc/footer.php';?>