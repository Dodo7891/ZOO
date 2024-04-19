<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="utf-8">
<?php include 'connect.php';
	if(!isset($_SESSION['isAdmin'])){
		echo "<h3 class='error'>Erreur! Vous n'avez pas les permission pour effectuer cette action! Redirection...</h3>";
		echo "<img src='Therock.png'><br>";
		header('refresh:5; url=searchEmployee.php?search=');
		die();
	}
	$req = 'SELECT nom, prenom, naissance, sexe, login, mdp, salaire 
	FROM personnel
	WHERE id='.$_GET['id'];
	$data = $conn->prepare($req);
	$data->execute();
	$res = $data->fetch();
	if(!$res) {
		echo '<h3 class="error">Erreur! Impossible de trouver l\'employé!</h3>';
		echo "<img src='Therock.png'><br>"; ?>
		<button onclick="javascript: history.back()">Retour</button> <?php
		die();
	} 
	
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
				echo 'Modification d\'Employe';
		?>
	</title>
</head>
<body>
	<?php include 'menu.php'; ?>
	<form method="post" action="">
		<table>
			<tr>
				<td>Nom</td>
				<td><input type="text" value="<?php echo $res['nom']; ?>" name="Nom"></td>
			</tr>
			<tr>
				<td>Prenom</td>	
				<td><input type="text" value="<?php echo $res['prenom']; ?>" name="prenom"></td>
			</tr>
			<tr>
				<td>Date de naissance</td>
				<td><input type="text" value="<?php echo $res['naissance']; ?>" name="naissance"></td>
			</tr>
			<tr>
				<td>Sexe</td>
				<td>
					<select name="sexe">
						<?php
							switch($res['sexe']){
								case('M'):
									echo '<option value="M">Homme</option>
									<option value="F">Femme</option>
									<option value="O">Autre</option>';
									break;
								case('F'):
									echo '<option value="F">Femme</option>
									<option value="M">Homme</option>
									<option value="O">Autre</option>';
									break;
								case('O'):
									echo '<option value="O">Autre</option>
									<option value="M">Homme</option>
									<option value="F">Femme</option>';
									break;
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>login</td>
				<td><input type="text" value="<?php echo $res['login']; ?>" name="login"></td>
			</tr>
			<tr>
				<td>mdp</td>
				<td><input type="password" value="<?php echo $res['mdp']; ?>" name="mdp"></td>
			</tr>
			<tr>
				<td>salaire</td>
				<td><input type="text" value="<?php echo $res['salaire'] ?>" name="salaire"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Confirmer">
		<button onclick="javascript: history.back()">Retour</button>
	</form>

	<?php
		if(isset($_POST['submit'])) {
			$N = $_POST['Nom'];
			$p = $_POST['prenom'];
			$s = $_POST['sexe'];
			$n = $_POST['naissance'];
			$l = $_POST['login'];
			$mdp = $_POST['mdp'];
			$c = $_POST['salaire'];
			$req3 = "UPDATE personnel
			SET Nom = '$N',
			prenom = '$p',
			sexe = '$s',
			naissance = '$n',
			login = '$l',
			mdp = '$mdp',
			salaire = $c
		
			WHERE id = ".$_GET['id'];
			$res3 = $conn->prepare($req3);
			$res3->execute();
			if($res3)
				header('Location: searchEmployee.php?search=');
			else{
				echo '<h3 class="error">Erreur! Vérifiez vos saisies.</h3>';
				echo "<img src='Therock.png'><br>";
			}
		}
	?>
</body>
</html>