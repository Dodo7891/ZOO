<?php
	session_start();

	$conn = new PDO('mysql:host=localhost;dbname=mission4;charset=utf8','root', '');
	if(!isset($_SESSION['login'])){
		session_unset();
		session_destroy();
		header('Location: Connexion.php');
	}
?>