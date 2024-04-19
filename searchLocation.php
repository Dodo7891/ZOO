<?php include 'connect.php';
	$q = strtolower(str_replace(' ', '', $_GET['search']));
	$query = 
	"SELECT arrivee, sortie, Animaux.pseudo AS pseudo, Enclos.nom AS nom, loc_Animaux.id AS id
	FROM loc_Animaux
	INNER JOIN Animaux ON Animaux.id = loc_Animaux.id_Animaux
	INNER JOIN Enclos ON Enclos.id = loc_Animaux.id_Enclos
	WHERE (Animaux.pseudo LIKE '%$q%') OR (Enclos.nom LIKE '%$q%') OR (arrivee LIKE '%$q%') OR (sortie LIKE '%$q%')
	ORDER BY arrivee;";
	$req = $conn->prepare($query);
	$req->execute();
	if(!$req){
			echo "<h3 class='error'>Erreur inconnue...</h3>";
			die();
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
	<form action="searchLocation.php" method="get" class="searchbar">
		<input type="text" name="search">
		<input type="submit">
	</form>
	<h3>Vous ne trouvez pas les bons résultats? <a href="addLocation.php">Ajouter une localisation</a></h3>
	<nav>
		<?php if (isset($_GET['search'])) {
			if ($req) { ?>
				<table border="1" cellpadding="10" cellspacing="0">
					<tr class="entete">
						<td>Nom animal</td>
						<td>Nom enclos</td>
						<td>Date d'arrivée</td>
						<td>Date de sortie</td>
						<td colspan="2">Actions</td>
					</tr>
				<?php while($res = $req->fetch()){ ?>
					<tr>
						<td><?php echo $res['pseudo']; ?></td>
						<td><?php echo $res['nom']; ?></td>
						<td><?php echo $res['arrivee']; ?></td>
						<td><?php echo $res['sortie']; ?></td>
						<td><button onclick="linkEdit(<?php echo $res['id']; ?>)">Modifier</a></td>
						<td><button onclick="confirmAction(<?php echo $res['id']; ?>)">Supprimer</button></td>
					</tr>
				<?php } ?>
				</table>
			<?php } else {
				echo '<h2 class="noresults">Il semblerait qu\'il n\'y a aucun résultat...</h2>';
			} 
		} ?>
	</nav>
</body>
<script>
	const confirmAction = (id) => {
		const response = confirm("Êtes vous sûr de vouloir continuer ?");
		if (response) {
			let link = "delLocation.php?id=" + id;
			window.location.href = link;
		}
	}

	const linkEdit = (id) => {
		let link = "editLocation.php?id=" + id;
		window.location.href = link;
	}
</script>
</html>