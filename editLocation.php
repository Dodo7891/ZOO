<?php include 'connect.php';

	$req = "SELECT arrivee, sortie, id_Animaux, id_Enclos, Animaux.pseudo AS pseudo, Enclos.nom AS nom
	FROM loc_Animaux
	INNER JOIN Animaux ON Animaux.id = id_Animaux
	INNER JOIN Enclos ON Enclos.id = id_Enclos
	WHERE loc_Animaux.id = ".$_GET['id'];
	$data = $conn->prepare($req);
	$data->execute();
	if(empty($data)) {
		echo '<h3 class="error">Erreur! Impossible de trouver l\'emplacement!</h3>'; 
		echo "<img src='Therock.png'><br>";?>
		<title>Erreur!</title>
		<button onclick="javascript: history.back()">Retour</button> <?php
		die();
	}
	$res = $data->fetch();

	$rq1 = 'SELECT id, pseudo FROM Animaux WHERE id != '.$res['id_Animaux'].' ORDER BY pseudo';
	$rs1 = $conn->prepare($rq1);
	$rs1->execute();
	$rq2 = 'SELECT id, nom FROM Enclos WHERE id != '.$res['id_Enclos'].' ORDER BY nom';
	$rs2 = $conn->prepare($rq2);
	$rs2->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Modification d'emplacement</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include 'menu.php'; ?>
	<form method="post" action="">
		<table>
			<tr>
				<td>Animal</td>
				<td>
					<select name="animal" style="width: 207.5px;">
						<option value="<?php echo $res['id_Animaux']; ?>"><?php echo $res['pseudo']; ?></option>
						<?php
							while($i = $rs1->fetch())
								echo '<option value="'.$i['id'].'">'.$i['pseudo'].'</option>';
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Enclos</td>
				<td>
					<select name="enclos" style="width: 207.5px;">
						<option value="<?php echo $res['id_Enclos'];?>"><?php echo $res['nom']; ?></option>
						<?php
							while($i = $rs2->fetch())
								echo '<option value="'.$i['id'].'">'.$i['nom'].'</option>';
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Date d'arrivée</td>
				<td><input type="date" value="<?php echo $res['arrivee']; ?>" name="arrivee" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Date de sortie</td>
				<td><input type="date" value="<?php echo $res['sortie']; ?>" name="sortie" style="width: 200px;"></td>
			</tr>
		</table>
		<input type="submit" name="submit">
		<button onclick="javascript: history.back()">Retour</button>
	</form>

	<?php
		if(isset($_POST['submit'])) {
			$a = $_POST['animal'];
			$e = $_POST['enclos'];
			$ar = $_POST['arrivee'];
			$s = $_POST['sortie'];
			// Verif place dans l'enclos
			$q = "SELECT COUNT(id_Animaux) AS nombre, Enclos.capacite AS capacite FROM Animaux
			INNER JOIN loc_Animaux ON Animaux.id = loc_Animaux.id_Animaux
			INNER JOIN Enclos ON Enclos.id = loc_Animaux.id_Enclos
			WHERE (Enclos.id = $e) AND (loc_Animaux.sortie > '$ar')";
			$r = $conn->prepare($q);
			$r->execute();
			$rs = $r->fetch();
			if($rs['nombre'] < $rs['capacite']){
				// Modification
				$req3 = "UPDATE loc_Animaux
				SET id_Animaux = $a,
				id_Enclos = $e,
				arrivee = '$ar',
				sortie = '$s'
				WHERE id = ".$_GET['id'];
				$res3 = $conn->prepare($req3);
				$res3->execute();
				if($res3)
					header('Location: searchLocation.php?search=');
				else{
					echo '<h3 class="error">Erreur! Vérifiez vos saisies.</h3>';
					echo "<img src='Therock.png'><br>";
				}
			} else{
				echo '<h3 class="error">Erreur! Cet enclos est plein!</h3>';
			}
		}
	?>
</body>
</html>