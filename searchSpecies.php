<?php include 'connect.php';
	$q = strtolower(str_replace(' ', '', $_GET['search']));
	$query = 
	"SELECT id, nom, type, duree_vie, aquatique, regime
	FROM Especes
	WHERE (nom LIKE '%$q%') OR (type LIKE '%$q%') OR (duree_vie LIKE '%$q%');";
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
	<form action="searchSpecies.php" method="get" class="searchbar">
		<input type="text" name="search">
		<input type="submit">
	</form>
	<h3>Vous ne trouvez pas les bons résultats? <a href="addSpecies.php">Ajouter une espèce</a></h3>
	<nav>
		<?php if (isset($_GET['search'])) {
			if ($req) { ?>
				<table border="1" cellpadding="10" cellspacing="0">
					<tr class="entete">
						<td>Nom</td>
						<td>Type</td>
						<td>Esperance de vie</td>
						<td>Aquatique</td>
						<td>Régime alimentaire</td>
						<td colspan="2">Actions</td>
					</tr>
				<?php while($res = $req->fetch()){ ?>
					<tr>
						<td><?php echo $res['nom']; ?></td>
						<td><?php echo $res['type']; ?></td>
						<td><?php echo $res['duree_vie']; ?></td>
						<td><?php
							if($res['aquatique'] == '1')
								echo 'Oui';
							else
								echo 'Non';
						?></td>
						<td><?php
							switch($res['regime']){
								case(1):
									echo 'Herbivore';
									break;
								case(2):
									echo 'Omnivore';
									break;
								case(3):
									echo 'Carnivore';
									break;
							}
						?></td>
						<td><button onclick="linkEdit(<?php echo $res['id']; ?>)">Modifier</button></td>
						<td><button onclick="confirmAction(<?php echo $res['id']; ?>)">Supprimer</button></td>
					</tr>
				<?php } ?>
				</table>
			<?php } else {
				echo '<h2 class="noresults">Il semblerait qu\'aucun résultat de correspond à votre recherche...</h2>';
			} 
		} ?>
	</nav>
</body>
<script>
	const confirmAction = (id) => {
		const response = confirm("Êtes vous sûr de vouloir continuer ?\nCette action supprimera tous les animaux de cette espèce.");
		if (response) {
			let link = "delSpecies.php?id=" + id;
			window.location.href = link;
		}
	}

	const linkEdit = (id) => {
		let link = "editSpecies.php?id=" + id;
		window.location.href = link;
	}
</script>
</html>