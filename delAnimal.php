<?php include 'connect.php';
	if(isset($_GET['id'])){
		$query0 = 'DELETE FROM loc_Animaux WHERE id_Animaux = '.$_GET['id'];
		$res0 = $conn->prepare($query0);
		$res0->execute();
		$query = 'DELETE FROM Animaux WHERE id = '.$_GET['id'];
		$res = $conn->prepare($query);
		$res->execute();
		if($res)
			header('Location: searchAnimal.php?search=');
		else {
			echo "<h3 class='error'>Erreur! Une erreur inconnue est survenue. Redirection...</h3>";
			echo "<img src='Therock.png'><br>";
			header('refresh:5; url=searchAnimal.php?search=');
		}
	}
	header('Location: searchAnimal.php?search=');
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