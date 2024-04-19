<?php include 'connect.php';
	include 'menu.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestion du Zoo</title>
</head>
<body>
	<?php
		echo 'Bienvenue, '.$_SESSION['login'].'.';
		if(isset($_SESSION['isAdmin']))
			echo "<br>Vous êtes connecté sur un compte administrateur.";
	?>
</body>
</html>