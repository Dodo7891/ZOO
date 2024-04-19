<?php include 'connect.php';
	include 'menu.php';
	$req1 = "SELECT id, pseudo FROM Animaux ORDER BY pseudo;";

	$res1 = $conn->prepare($req1);
	$res1->execute();
	$req2 = "SELECT id, nom FROM Enclos ORDER BY nom";
	$res2 = $conn->prepare($req2);
	$res2->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ajouter un emplacement</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="" method="post">
		<h2>Entrez les données de l'espèce:</h2>
		<table cellspacing="0" cellpadding="2.5">
			<tr>
				<td>Animal</td>
				<td>
					<select name="animal" style="width: 207.5px;">
						<option value="NULL">--Selectionnez un animal--</option>
						<?php
							while($i = $res1->fetch());
								echo "<option value='".$i['id']."'>".$i['pseudo']."</option>";
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Enclos</td>
				<td>
					<select name="enclos" style="width: 207.5px;">
						<option value="NULL">--Selectionnez un enclos--</option>
						<?php
							while($i = $res2->fetch());
								echo "<option value='".$i['id']."'>".$i['nom']."</option>";
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Date d'arrivée</td>
				<td><input type="date" name="arrivee" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Date de sortie</td>
				<td><input type="date" name="sortie" style="width: 200px;"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Confirmer" style="width: 207.5px;"></td>
			</tr>
		</table>
	</form>

	<?php
		if(isset($_POST['submit'])){
			$a = $_POST['animal'];
			$e = $_POST['enclos'];
			$ar = $_POST['arrivee'];
			$s = $_POST['sortie'];
			if(empty($s))
				$s = '';
			if(($e == 'NULL') || ($a == 'NULL')) {
				echo "<h3 class='error'>Erreur! Veuillez renseigner les champs Animal et Enclos</h3>";
			} else {
				// Verif place dans l'enclos
				$q = "SELECT COUNT(id_Animaux) AS nombre, Enclos.capacite AS capacite FROM Animaux
				INNER JOIN loc_Animaux ON Animaux.id = loc_Animaux.id_Animaux
				INNER JOIN Enclos ON Enclos.id = loc_Animaux.id_Enclos
				WHERE (Enclos.id = $e) AND ((loc_Animaux.sortie > '$ar') OR (loc_Animaux.sortie = '0000-00-00'))";
				$r = $conn->prepare($q);
				$r->execute();
				$rs = $r->fetch();
			
				if($rs['nombre'] < $rs['capacite']){
					// Ajout
					$query = "INSERT INTO loc_Animaux (id_Animaux, id_Enclos, arrivee, sortie)
						VALUES ($a, $e, '$ar', '$s')";
					$res = $conn->prepare($query);
					$res->execute();
					if($res)
						header('Location: searchLocation.php?search=');
					else
						echo "<h3 class'error'>Erreur! Une erreur inconnue est survenue, vérifiez vos saisies...</h3>";
				} else {
					echo "<h3 class='error'>Erreur! Cet enclos est plein...</h3>";
				}
			}
		}
	?>

</body>
</html>