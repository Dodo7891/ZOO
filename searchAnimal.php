<?php include 'connect.php';
	$q = strtolower(str_replace(' ', '', $_GET['search']));
	$query = 
	"SELECT Animaux.id, Animaux.pseudo, Animaux.sexe, Animaux.naissance, Animaux.commentaire, Especes.nom
	FROM Animaux
	INNER JOIN Especes ON Animaux.id_Especes = Especes.id
	WHERE (Animaux.pseudo LIKE '%$q%') OR (Animaux.id LIKE '%$q%') OR (Animaux.commentaire LIKE '%$q%')
	ORDER BY pseudo;";
	$req = $conn->prepare($query);
	$req->execute();
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
	<form action="searchAnimal.php" method="get" class="searchbar">
		<input type="text" name="search">
		<input type="submit">
	</form>
	<h3>Vous ne trouvez pas les bons résultats? <a href="addAnimal.php">Ajouter un animal</a></h3>
	<nav>
		<?php if (isset($_GET['search'])) {
			if ($req) { ?>
				<table border="1" cellpadding="10" cellspacing="0">
					<tr class="entete">
						<td>Nom</td>
						<td>Sexe</td>
						<td>Espèce</td>
						<td>Date de naissance</td>
						<td>Commentaires</td>
						<td colspan="2">Actions</td>
					</tr>
				<?php while($res = $req->fetch()){ ?>
					<tr>
						<td><?php echo $res['pseudo']; ?></td>
						<td><?php
						if($res['sexe'] == 'M')
							echo 'Mâle';
						elseif($res['sexe'] == 'F')
							echo 'Femelle';
						else
							echo 'Indéterminé';
						?></td>
						<td><?php echo $res['nom']; ?></td>
						<td><?php echo $res['naissance']; ?></td>
						<td><?php echo $res['commentaire']; ?></td>
						<td><button onclick="editLink(<?php echo $res['id']; ?>)">Modifier</button></td>
						<td><button onclick="delConfirm(<?php echo $res['id']; ?>)">Supprimer</button></td>
					</tr>
				<?php } ?>
				</table>
			<?php } else {
				echo '<h2 class="noresults">Il semblerait qu\'il n\'y a aucun résultat...</h2>';
			} 
		} ?>
	</nav>
</body>
<script type="text/javascript">
	const delConfirm = (id) => {
		const response = confirm("Êtes vous sûr de vouloir continuer ?\nCette action supprimera cet animal.");
		if (response) {
			let link = "delAnimal.php?id=" + id;
			window.location.href = link;
		}
	}

	const editLink = (id) => {
		let link = "editAnimal.php?id=" + id;
		window.location.href = link;
	}
</script>
</html>