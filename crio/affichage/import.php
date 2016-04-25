<?php 
	require 'inc/header.php';
	require 'inc/functions.php';
	require_once 'inc/db.php';
	logged_only();

	if(isset($_POST['submit'])){
		$fname = $_FILES['sel-csv']['name'];
		echo 'Nom du fichier uploadé : '.$fname.' ';
		$chk_ext = explode(".",$fname);
		if(strtolower(end($chk_ext))=="csv"){
			$filename = $_FILES['sel-csv']['tmp_name'];
			$handle = fopen($filename, "r");
			$truncate = $dbh->prepare("truncate table crio_user")->execute();
			$flush = $dbh->prepare("flush table crio_user")->execute();

		while (($data = fgetcsv($handle, 1000,",")) !== FALSE) {
				$req = $dbh->prepare("INSERT INTO crio_user SET user =?, password=?");
				$req->execute([ $data[0], $data[1] ]);
			}
			fclose($handle);
			$_SESSION['flash']['success'] = "Importation terminée avec succès";
			header('Location:users.php');
			exit();
		}
		else{
			$_SESSION['flash']['danger'] = "Le format du fichier est incorrect";
			header('Location:import.php');
			exit();
		}
		
	}
?>

<h1>Mise à jour des utilisateurs</h1>
<div class="alert alert-danger"> 
Veuillez lire attentivement, les consignes suivantes :
<ul>
	<li>Le fichier .csv doit contenir uniquement les colonnes "user" et "password"</li>
	<li>Le séparateur doit être une virgule ","</li>
	<li>Faites attention à ce qu'il n'y ait pas d'espace dans le fichier</li>
</ul>

</div>


<form action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label for="">Selectionner le fichier CSV</label>
		<input type="file" name="sel-csv"/>
		<p class="help-block">Fichier .csv / Séparateur : virgule</p>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Importer</button>


<?php require'inc/footer.php'; ?>