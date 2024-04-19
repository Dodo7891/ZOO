<?php include 'connect.php';
	include 'menu.php';
	$query1 = "SELECT id, nom FROM Especes";
	$res1 = $conn->prepare($query1);
	$res1->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ajouter un animal</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="" method="post">
		<h2>Entrez les données de l'animal:</h2>
		<table cellspacing="0" cellpadding="2.5">
			<tr>
				<td>Nom</td>
				<td><input type="text" name="pseudo" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Date de naissance</td>
				<td><input type="date" name="birthday" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Sexe</td>
				<td>
					<select name="sexe" style="width: 207.5px;">
						<option value="NULL">--Sélectionnez une option--</option>
						<option value="M">Mâle</option>
						<option value="F">Femelle</option>
						<option value="O">Indéterminé</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Commentaire</td>
				<td><input type="text" name="comm" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Espèce</td>
				<td>
					<select name="species" style="width: 207.5px;">
						<option value="NULL">--Sélectionnez une option--</option>
						<?php
							while($i = $res1->fetch())
								echo '<option value=\''.$i['id'].'\'>'.$i['nom'].'</option>';
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Confirmer" style="width: 207.5px;"></td>
			</tr>
		</table>
	</form>

	<?php
		if(isset($_POST['submit'])){
			$pseudo = $_POST['pseudo'];
			$birth = $_POST['birthday'];
			$sexe = $_POST['sexe'];
			$comm = $_POST['comm'];
			$species = $_POST['species'];
			if($sexe == 'NULL') {
				echo "<h3 class='error'>Erreur! Veuillez renseigner le champ Sexe!</h3>";
			} elseif($species == 'NULL') {
				echo "<h3 class='error'>Erreur! Veuillez renseigner le champ Espèce!</h3>";
			} else {
				$query = "INSERT INTO Animaux (pseudo, naissance, sexe, commentaire, id_Especes)
					VALUES ('$pseudo', '$birth', '$sexe', '$comm', '$species')";
				$res = $conn->prepare($query);
				$res->execute();
				if($res)
					header('Location: searchAnimal.php?search=');
				else
					echo "<h3 class'error'>Erreur! Une erreur inconnue est survenue, vérifiez vos saisies...</h3>";
			}
		}
	?>

</body>
</html>