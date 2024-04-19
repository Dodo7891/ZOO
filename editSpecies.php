<?php include 'connect.php';

	$req = "SELECT id, nom, type, duree_vie, aquatique, regime
	FROM Especes WHERE id = ".$_GET['id'];
	$data = $conn->prepare($req);
	$data->execute();
	if(empty($data)) {
		echo '<h3 class="error">Erreur! Impossible de trouver l\'espèce!</h3>';
		echo "<img src='Therock.png'><br>"; ?>
		<button onclick="javascript: history.back()">Retour</button> <?php
		die();
	}
	$res = $data->fetch();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php
			if(!$data) {
				echo 'Erreur!';
				exit();
			}
			else
				echo 'Modification d\'espèce';
		?>
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include 'menu.php'; ?>
	<form method="post" action="">
		<table>
			<tr>
				<td>Nom</td>
				<td><input type="text" value="<?php echo $res['nom']; ?>" name="nom" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Type</td>
				<td><input type="text" value="<?php echo $res['type']; ?>" name="type" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Espérance de vie</td>
				<td><input type="text" value="<?php echo $res['duree_vie']; ?>" name="vie" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Aquatique</td>
				<td>
					<select name="eau" style="width: 207.5px;">
						<?php
							if($res['aquatique'] == '0'){ ?>
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
				<td>Régime alimentaire</td>
				<td>
					<select name="regime" style="width: 207.5px;">
						<?php
							switch($res['regime']){
								case(1):
									echo '<option value="1">Herbivore</option>
									<option value="2">Omnivore</option>
									<option value="3">Carnivore</option>';
									break;
								case(2):
									echo '<option value="2">Omnivore</option>
									<option value="1">Herbivore</option>
									<option value="3">Carnivore</option>';
									break;
								case(3):
									echo '<option value="3">Carnivore</option>
									<option value="1">Herbivore</option>
									<option value="2">Omnivore</option>';
									break;
							}
						?>
					</select>
				</td>
			</tr>
		</table>
		<input type="submit" name="submit">
		<button onclick="javascript: history.back()">Retour</button>
	</form>

	<?php
		if(isset($_POST['submit'])) {
			$n = $_POST['nom'];
			$c = $_POST['type'];
			$v = $_POST['vie'];
			$e = $_POST['eau'];
			$r = $_POST['regime'];
			$req3 = "UPDATE Especes
			SET nom = '$n',
			type = '$c',
			duree_vie = $v,
			aquatique = $e,
			regime = $r
			WHERE id = ".$_GET['id'];
			$res3 = $conn->prepare($req3);
			$res3->execute();
			if($res3)
				header('Location: searchSpecies.php?search=');
			else{
				echo '<h3 class="error">Erreur! Vérifiez vos saisies.</h3>';
				echo "<img src='Therock.png'><br>";
			}
		}
	?>
</body>
</html>