<?php session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>ZOO</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Connexion.css">
</head>
<body>
<form action="Connexion.php" method="post">
<nav>
	<h1>Connexion</h1>
	<br>
	<h2>Identifiant:</h2>
	<input type="text" name="login">
	<br>
	<h2>Mots de passe:</h2>
	<input type="password" name="pass">
	<br>
	<input type="submit" name="submit" value="Se Connecter">
</nav>
</form>
<?php
	if(isset($_POST['submit'])){
		$conn = new PDO('mysql:host=localhost;dbname=mission4;charset=utf8','root', '');
		
		if(!empty($_POST['login']) || !empty($_POST['pass'])){
			$log = $_POST['login'];
			$pass = $_POST['pass'];
			$query = 'SELECT id, login, fonction FROM Personnel WHERE login = \''.$log.'\' AND mdp = \''.$pass.'\';';
			$res = $conn->prepare($query);
			$res->execute();
			$temp = $res->fetch();
			if ($temp['id'] == 1){
				echo '<h3 class="error">Erreur! Identifiant ou mot de passe erroné!</h3>';
				echo "<img src='Therock.png'><br>";
				die();
			}
			if($res->rowCount() > 0){
				$_SESSION['login'] = $log;
				if($temp['fonction'] == 1)
					$_SESSION['isAdmin'] = 1;
				header("Location: index.php");
			} else {
				echo "<h3 class='error'>Erreur! Identifiant ou mot de passe erroné!</h3>";
				echo "<img src='Therock.png'><br>";
			}
		} else {
			echo "<h3 class='error'>Erreur! Vous devez remplir les champs d'identifiant et de mot de passe!</h3>";
			echo "<img src='Therock.png'><br>";
		}
	}
?>
</body>
</html>