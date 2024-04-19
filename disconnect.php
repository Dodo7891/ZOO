<?php include 'connect.php';
	session_unset();
	session_destroy();
	echo "<img src='Therock.png'><br>";

	header("refresh:5; url=connexion.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Déconnexion...</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h2 class="success">Vous avez été déconnecté avec succès! Redirection...</h2>
	<h4>Si vous n'êtes pas redirigé automatiquement, cliquez <a href="connexion.php">ici</a>.</h4>
</body>
</html>