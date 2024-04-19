<?php include 'connect.php';
	include 'menu.php';
	if(!isset($_SESSION['isAdmin']))
		header('Location: index.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ajouter un employé</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="" method="post">
		<h2>Entrez les données de l'employé:</h2>
		<table cellspacing="0" cellpadding="2.5">
			<tr>
				<td>Nom</td>
				<td><input type="text" name="nom" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Prénom</td>
				<td><input type="text" name="prenom" style="width: 200px;"></td>
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
						<option value="M">Homme</option>
						<option value="F">Femme</option>
						<option value="O">Autre</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Identifiant</td>
				<td><input type="text" name="loginA" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Mot de passe</td>
				<td><input type="password" name="passA" style="width: 200px;"></td>
			</tr>
			<tr>
				<td>Fonction</td>
				<td>
					<select name="function" style="width: 207.5px;">
						<option value="NULL">--Sélectionnez une option--</option>
						<option value="0">Employé</option>
						<option value="1">Directeur</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Salaire</td>
				<td><input type="text" name="salary" style="width: 200px;"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Confirmer" style="width: 207.5px;"></td>
			</tr>
		</table>
	</form>

	<?php
		if(isset($_POST['submit'])){
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$birth = $_POST['birthday'];
			$sexe = $_POST['sexe'];
			$loginA = $_POST['loginA'];
			$passA = $_POST['passA'];
			$function = $_POST['function'];
			$salary = $_POST['salary'];
			if($sexe == 'NULL') {
				echo "<h3 class='error'>Erreur! Veuillez renseigner le champ Sexe!</h3>";
			} elseif($function == 'NULL') {
				echo "<h3 class='error'>Erreur! Veuillez renseigner le champ Fonction!</h3>";
			} else {
				$query = "INSERT INTO Personnel (nom, prenom, naissance, sexe, login, mdp, fonction, salaire)
					VALUES ('$nom', '$prenom', '$birth', '$sexe', '$loginA', '$passA', '$function', $salary)";
				$res = $conn->prepare($query);
				$res->execute();
				header('Location: searchEmployee.php?search=');
			}
		}
	?>

</body>
</html>