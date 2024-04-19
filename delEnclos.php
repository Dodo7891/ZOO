<?php include 'connect.php';
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$q1 = "DELETE FROM loc_Animaux WHERE id_Enclos = $id";
		$r1 = $conn->prepare($q1);
		$r1->execute();
		$query = "DELETE FROM Enclos WHERE id = $id";
		$res = $conn->prepare($query);
		$res->execute();
		if($res)
			header('Location: searchEnclos.php?search=');
		else {
			echo "<h3 class='error'>Erreur! Une erreur inconnue est survenue. Redirection...</h3>";
			echo "<img src='Therock.png'><br>";
			header('refresh:5; url=searchEnclos.php?search=');
		}
	}
	header('Location: searchEnclos.php?search=');
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