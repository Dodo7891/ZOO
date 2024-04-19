<?php include 'connect.php';
	include 'menu.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ajouter une espèce</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="" method="post">
		<h2>Entrez les données de l'espèce:</h2>
		<table cellspacing="0" cellpadding="2.5">
			<tr>
				<td>Nom</td>
				<td><input type="text" name="nom" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Type</td>
				<td><input type="text" name="type" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Espérance de vie</td>
				<td><input type="text" name="vie" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Aquatique</td>
				<td>
					<select name="eau" style="width: 207.5px;">
						<option value="NULL">--Sélectionnez une option--</option>
						<option value="1">Oui</option>
						<option value="0">Non</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Régime alimentaire</td>
				<td>
					<select name="regime" style="width: 207.5px;">
						<option value="NULL">--Sélectionnez une option--</option>
						<option value="1">Herbivore</option>
						<option value="2">Omnivore</option>
						<option value="3">Carnivore</option>
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
			$n = $_POST['nom'];
			$c = $_POST['type'];
			$v = $_POST['vie'];
			$e = $_POST['eau'];
			$r = $_POST['regime'];
			if($e == 'NULL') {
				echo "<h3 class='error'>Erreur! Veuillez renseigner le champ Aquatique!</h3>";
			} else {
				$query = "INSERT INTO Especes (nom, type, duree_vie, aquatique, regime)
					VALUES ('$n', '$c', $v, $e, $r)";
				$res = $conn->prepare($query);
				$res->execute();
				if($res)
					header('Location: searchSpecies.php?search=');
				else
					echo "<h3 class'error'>Erreur! Une erreur inconnue est survenue, vérifiez vos saisies...</h3>";
			}
		}
	?>

</body>
</html>