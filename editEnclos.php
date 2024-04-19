<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="utf-8">
<?php include 'connect.php';

	$req = "SELECT Enclos.id AS id, Enclos.nom AS nom, capacite, taille, eau, id_Personnel, Personnel.nom AS nomp
	FROM Enclos
	INNER JOIN Personnel ON Enclos.id_Personnel = Personnel.id
	WHERE Enclos.id = ".$_GET['id'];
	$data = $conn->prepare($req);
	$data->execute();
	$res = $data->fetch();
	if(!$res) {
		echo '<h3 class="error">Erreur! Impossible de trouver l\'enclos!</h3>'; ?>
		<img src="Therock.png"><br>
		<button onclick="javascript: history.back()">Retour</button> <?php
		die();
	} 
	$req1 = 'SELECT id, nom FROM Personnel WHERE id != '.$res['id_Personnel'].' AND id != 1 ORDER BY nom;';
	$data1 = mysqli_query($conn, $req1);
	$data1 = $conn->prepare($req1);
	$data1->execute();
	?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php
			if(!$data) {
				echo 'Erreur!';
				exit();
			}
			else
				echo 'Modification d\'enclos';
		?>
	</title>
</head>
<body>
	<?php include 'menu.php'; ?>
	<form method="post" action="">
		<table>
			<tr>
				<td>Nom</td>
				<td><input type="text" value="<?php echo $res['nom']; ?>" name="nom"></td>
			</tr>
			<tr>
				<td>Capacité</td>
				<td><input type="text" value="<?php echo $res['capacite']; ?>" name="capacite"></td>
			</tr>
			<tr>
				<td>Taille (km)</td>
				<td><input type="text" value="<?php echo $res['taille']; ?>" name="taille"></td>
			</tr>
			<tr>
				<td>Aquatique</td>
				<td>
					<select name="eau">
						<?php
							if($res['eau'] == '0'){ ?>
								<option value="0">Non</option>
								<option value="1">Oui</option>
							<?php } else { ?>
								<option value="1">Oui</option>
								<option value="0">Non</option>
							<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Personnel en charge</td>
				<td>
					<select name="id_perso">
						<?php echo '<option value="'.$res['id_Personnel'].'">'.$res['nomp'].'</option>';
						if($res['id_Personnel'] != 1)
							echo '<option value="1">Personne</option>';
						while($res1 = $data1->fetch())
							echo '<option value="'.$res1['id'].'">'.$res1['nom'].'</option>';
						?>
					</select>
				</td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Confirmer">
		<button onclick="javascript: history.back()">Retour</button>
	</form>

	<?php
		if(isset($_POST['submit'])) {
			$n = $_POST['nom'];
			$c = $_POST['capacite'];
			$t = $_POST['taille'];
			$e = $_POST['eau'];
			$i = $_POST['id_perso'];
			$req3 = "UPDATE Enclos
			SET nom = '$n',
			capacite = $c,
			taille = $t,
			eau = $e,
			id_Personnel = $i
			WHERE id = ".$_GET['id'];
			$res3 = $conn->prepare($req3);
			$res3->execute();
			if($res3)
				header('Location: searchEnclos.php?search=');
			else{
				echo '<h3 class="error">Erreur! Vérifiez vos saisies.</h3>';
				echo "<img src='Therock.png'><br>";
			}
		}
	?>
</body>
</html>