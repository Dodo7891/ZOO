<?php include 'connect.php';
	if(isset($_SESSION['isAdmin'])){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$q0 = "UPDATE Enclos SET id_Personnel = 1 WHERE id_Personnel = $id";
			$r1 = $conn->prepare($q0);
			$r1->execute();
			$query = "DELETE FROM Personnel WHERE id = $id";
			$res = $conn->prepare($query);
			$res->execute();
			if($res)
				header('Location: searchEmployee.php?search=');
			else {
				echo "<h3 class='error'>Erreur! Une erreur inconnue est survenue. Redirection...</h3>";
				echo "<img src='Therock.png'><br>";
				header('refresh:5; url=searchEmployee.php?search=');
			}
		}
	} else {
		echo "<h3 class='error'>Erreur! Il semblerait que vous n'ayez pas les droits pour effectuer cette action! Redirection...</h3>";
		echo "<img src='Therock.png'><br>";
		header('refresh:5; url=searchEmployee.php?search=');
	}
	header('Location: searchEmployee.php?search=');
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