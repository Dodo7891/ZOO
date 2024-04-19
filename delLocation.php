<?php include 'connect.php';
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$query = "DELETE FROM loc_Animaux WHERE id = $id";
		$res = $conn->prepare($query);
		$res->execute();
		if($res)
			header('Location: searchLocation.php?search=');
		else {
			echo "<h3 class='error'>Erreur! Une erreur inconnue est survenue. Redirection...</h3>";
			echo "<img src='Therock.png'><br>";
			header('refresh:3; url=searchLocation.php?search=');
		}
	}
	header('Location: searchLocation.php?search=');
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