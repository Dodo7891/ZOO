<?php include 'connect.php';

	$req = 'SELECT pseudo, sexe, naissance, commentaire, id_Especes
	FROM Animaux
	WHERE id='.$_GET['id'];
	$data = mysqli_query($conn, $req);
	$data = $conn->prepare($req);
	$data->execute();
	$res = $data->fetch();
	if(!$data) {
		echo '<h3 class="error">Erreur! Impossible de trouver l\'animal!</h3>';
		echo "<img src='Therock.png'><br>";?>
		<button onclick="javascript: history.back()">Retour</button> <?php
	} 
	$req1 = 'SELECT nom FROM Especes WHERE id = '.$res['id_Especes'];
	$data1 = $conn->prepare($req1);
	$data1->execute();
	$res1 = $data1->fetch();
	$req2 = 'SELECT nom, id FROM Especes WHERE id != '.$res['id_Especes'];
	$data2 = $conn->prepare($req2);
	$data2->execute();
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
				echo 'Modification d\'animal';
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
				<td><input type="text" value="<?php echo $res['pseudo']; ?>" name="pseudo"></td>
			</tr>
			<tr>
				<td>Sexe</td>
				<td>
					<select name="sexe">
						<?php
							if($res['sexe'] == 'M'){ ?>
								<option value="M">Mâle</option>
								<option value="F">Femelle</option>
								<option value="O">Indéterminé</option>
							<?php } elseif($res['sexe'] == 'F') { ?>
								<option value="F">Femelle</option>
								<option value="M">Mâle</option>
								<option value="O">Indéterminé</option>
							<?php } else { ?>
								<option value="O">Indéterminé</option>
								<option value="M">Mâle</option>
								<option value="F">Femelle</option>
							<?php }
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Espèce</td>
				<td>
					<select name="espece">
						<?php echo '<option value="'.$res['id_Especes'].'">'.$res1['nom'].'</option>';
						while($res2 = $data2->fetch())
							echo '<option value="'.$res2['id'].'">'.$res2['nom'].'</option>';
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Date de naissance</td>
				<td><input type="text" value="<?php echo $res['naissance']; ?>" name="naissance"></td>
			</tr>
			<tr>
				<td>Commentaires</td>
				<td><input type="text" value="<?php echo $res['commentaire']; ?>" name="comm"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Confirmer">
		<button onclick="javascript: history.back()">Retour</button>
	</form>

	<?php
		if(isset($_POST['submit'])) {
			$p = $_POST['pseudo'];
			$s = $_POST['sexe'];
			$e = $_POST['espece'];
			$n = $_POST['naissance'];
			$c = $_POST['comm'];
			$req3 = "UPDATE Animaux
			SET pseudo = '$p',
			sexe = '$s',
			id_Especes = '$e',
			naissance = '$n',
			commentaire = '$c'
			WHERE id = ".$_GET['id'];
			$res3 = $conn->prepare($req3);
			$res3->execute();
			if($res3)
				header('Location: searchAnimal.php?search=');
			else{
				echo '<h3 class="error">Erreur! Vérifiez vos saisies.</h3>';
				echo "<img src='Therock.png'><br>";
			}
		}
	?>
</body>
</html>