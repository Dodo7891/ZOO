<?php include 'connect.php';
	include 'menu.php';
	$query1 = "SELECT id, nom FROM Personnel";
	$res1 = $conn->prepare($query1);
	$res1->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ajouter un enclos</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="" method="post">
		<h2>Entrez les données de l'animal:</h2>
		<table cellspacing="0" cellpadding="2.5">
			<tr>
				<td>Nom</td>
				<td><input type="text" name="nom" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Capacité</td>
				<td><input type="text" name="capacite" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Taille (km)</td>
				<td><input type="text" name="taille" style="width: 200px;"></td>
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
				<td>Personnel en charge</td>
				<td>
					<select name="idp" style="width: 207.5px;">
						<option value="NULL">--Sélectionnez une option--</option>
						<?php
							while($i = $res1->fetch());
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
			$n = $_POST['nom'];
			$c = $_POST['capacite'];
			$t = $_POST['taille'];
			$e = $_POST['eau'];
			$i = $_POST['idp'];
			if($e == 'NULL') {
				echo "<h3 class='error'>Erreur! Veuillez renseigner le champ Aquatique!</h3>";
			} elseif($i == 'NULL') {
				echo "<h3 class='error'>Erreur! Veuillez renseigner le champ Personnel en charge!</h3>";
			} else {
				$query = "INSERT INTO Enclos (nom, capacite, taille, eau, id_Personnel)
					VALUES ('$n', $c, $t, $e, $i)";
				$res = $conn->prepare($query);
				$res->execute();
				if($res)
					header('Location: searchEnclos.php?search=');
				else
					echo "<h3 class'error'>Erreur! Une erreur inconnue est survenue, vérifiez vos saisies...</h3>";
			}
		}
	?>

</body>
</html>