<?php include 'connect.php';
	if (isset($_GET['search'])){
		$q = strtolower(str_replace(' ', '', $_GET['search']));
		if(isset($_SESSION['isAdmin'])){
			$query = 
			"SELECT id, nom, prenom, naissance, sexe, login, mdp, fonction, salaire
				FROM Personnel
				WHERE ((nom LIKE '%$q%') OR (prenom LIKE '%$q%') OR (salaire LIKE '%$q%') OR (id LIKE '%$q%')) AND id != 1
				ORDER BY nom";
		} else {
			$query = 
			"SELECT nom, prenom, naissance, sexe, fonction
				FROM Personnel
				WHERE ((nom LIKE '%$q%') OR (prenom LIKE '%$q%')) AND id != 1
				ORDER BY nom";
		}
		$req = $conn->prepare($query);
		$req->execute();
	} else {
		$query = "SELECT id, pseudo, sexe, naissance, commentaire FROM Animaux;";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php
			if (isset($q) && ($q != '')) {
				echo "Recherche: $q";
			} else {
				echo "Recherche";
			}
		?>
	</title>
</head>
<body>
	<?php include 'menu.php'; ?>
	<form action="searchEmployee.php" method="get" class="searchbar">
		<input type="text" name="search">
		<input type="submit">
	</form>
	<?php if(isset($_SESSION['isAdmin']))
		echo '<h3>Vous ne trouvez pas les bons résultats? <a href="addEmployee.php">Ajouter un employé</a></h3>';
	?>
	<nav>
		<?php if (isset($_GET['search'])) {
			if(isset($_SESSION['isAdmin'])){
				if ($req) { ?>
					<table border="1" cellpadding="10" cellspacing="0">
						<tr class="entete">
							<td>Nom</td>
							<td>Prénom</td>
							<td>Date de naissance</td>
							<td>Sexe</td>
							<td>Login</td>
							<td>Mot de passe</td>
							<td>Fonction</td>
							<td>Salaire</td>
							<td colspan="2">Actions</td>
						</tr>
					<?php while($res = $req->fetch()){ ?>
						<tr>
							<td><?php echo $res['nom']; ?></td>
							<td><?php echo $res['prenom']; ?></td>
							<td><?php echo $res['naissance']; ?></td>
							<td><?php
								switch ($res['sexe']) {
									case 'M':
										echo 'Homme';
										break;
									case 'F':
										echo 'Femme';
										break;
									case 'O':
										echo 'Autre';
										break;
								}
							?></td>
							<td><?php echo $res['login']; ?></td>
							<td><?php for($i = 0; $i < strlen($res['mdp']); $i++)
									echo '*';
								?></td>
							<td><?php
								if($res['fonction'])
									echo "Directeur";
								else
									echo "Employé";
							?></td>
							<td><?php echo $res['salaire']; ?></td>
							<td><button onclick="linkEdit(<?php echo $res['id']; ?>)">Modifier</button></td>
							<td><button onclick="delConfirm(<?php echo $res['id']; ?>)">Supprimer</button></td>
						</tr>
					<?php } ?>
					</table>
				<?php } else { ?>
					<h2 class="noresults">Il semblerait qu'il n'y a aucun résultat...</h2>
				<?php } 	
			} else {
				if ($req) { ?>
					<table border="1" cellpadding="10" cellspacing="0">
						<tr class="entete">
							<td>Nom</td>
							<td>Prénom</td>
							<td>Date de naissance</td>
							<td>Sexe</td>
							<td>Fonction</td>
						</tr>
					<?php while($res = $req->fetch()){ ?>
						<tr>
							<td><?php echo $res['nom']; ?></td>
							<td><?php echo $res['prenom']; ?></td>
							<td><?php echo $res['naissance']; ?></td>
							<td><?php
								switch ($res['sexe']) {
									case 'H':
										echo 'Homme';
										break;
									case 'F':
										echo 'Femme';
										break;
									case 'O':
										echo 'Autre';
										break;
								}
							?></td>
							<td><?php
								if($res['fonction'])
									echo "Directeur";
								else
									echo "Employé";
							?></td>
						</tr>
					<?php } ?>
					</table>
				<?php } else { ?>
					<h2 class="noresults">Il semblerait qu'il n'y a aucun résultat...</h2>
				<?php } 	
			}
		} ?>
	</nav>
</body>
<script type="text/javascript">
	const delConfirm = (id) => {
		const response = confirm("Êtes vous sûr de vouloir continuer ?\nCette action supprimera cet employé.");
		if (response) {
			let link = "delEmployee.php?id=" + id;
			window.location.href = link;
		}
	}

	const linkEdit = (id) => {
		let link = "editEmployee.php?id=" + id;
		window.location.href = link;
	}
</script>
</html>