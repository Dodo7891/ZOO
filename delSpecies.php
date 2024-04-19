<?php include 'connect.php';
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$q1 = "DELETE FROM Animaux WHERE id_Especes = $id";
		$r1 = $conn->prepare($q1);
		$r1->execute();
		$query = "DELETE FROM Especes WHERE id = $id";
		$res = $conn->prepare($query);
		$res->execute();
		if($res)
			header('Location: searchSpecies.php?search=');
		else {
			echo "<h3 class='error'>Erreur! Une erreur inconnue est survenue. Redirection...</h3>";
			echo "<img src='Therock.png'><br>";
			header('refresh:5; url=searchSpecies.php?search=');
		}
	}
	header('Location: searchSpecies.php?search=');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Suppression</title>
</head>
<body>

</body>
</html>