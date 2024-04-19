<?php include 'connect.php';
	$date = date('Y-m-d');
	$q = strtolower(str_replace(' ', '', $_GET['search']));
	$query = 
	"SELECT Enclos.id AS id, Enclos.nom AS nom, capacite, taille, eau, Personnel.nom AS nomp, COUNT(loc_Animaux.id_Animaux) AS nb
	FROM Enclos
	INNER JOIN Personnel ON Enclos.id_Personnel = Personnel.id
	INNER JOIN loc_Animaux ON Enclos.id = loc_Animaux.id_Enclos
	WHERE ((Enclos.nom LIKE '%$q%') OR (taille LIKE '%$q%') OR (capacite LIKE '%$q%') OR (Personnel.nom LIKE '%$q%')) AND loc_Animaux.sortie >= '$date'
	GROUP BY Enclos.id
	ORDER BY Enclos.nom;";
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
	<form action="searchEnclos.php" method="get" class="searchbar">
		<input type="text" name="search">
		<input type="submit">
	</form>
	<h3>Vous ne trouvez pas les bons résultats? <a href="addEnclos.php">Ajouter un enclos</a></h3>
	<nav>
		<?php if (isset($_GET['search'])) {
			if ($req) { ?>
				<table border="1" cellpadding="10" cellspacing="0">
					<tr class="entete">
						<td>Nom</td>
						<td>Animaux</td>
						<td>Capacité</td>
						<td>Taille (km)</td>
						<td>Aquatique</td>
						<td>Personnel en charge</td>
						<td colspan="2">Actions</td>
					</tr>
				<?php while($res = $req->fetch()){ ?>
					<tr>
						<td><?php echo $res['nom']; ?></td>
						<td><?php echo $res['nb']; ?></td>
						<td><?php echo $res['capacite']; ?></td>
						<td><?php echo $res['taille']; ?></td>
						<td><?php
							if($res['eau'] == '1')
								echo 'Oui';
							else
								echo 'Non';
						?></td>
						<td><?php echo $res['nomp']; ?></td>
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
		const response = confirm("Êtes vous sûr de vouloir continuer ?\nCette action supprimera toutes les localisations liées à cet enclos.");
		if (response) {
			let link = "delEnclos.php?id=" + id;
			window.location.href = link;
		}
	}

	const linkEdit = (id) => {
		let link = "editEnclos.php?id=" + id;
		window.location.href = link;
	}
</script>
</html>