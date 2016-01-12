<?php
	session_start();

	require(__DIR__.'/config/db.php');
	require(__DIR__.'/functions.php');

	// Cette fonction doit être mis de préférence dans le fichier functions.php
	function checkLoggedIn() {
		if(empty($_SESSION['user'])) {
			header("Location: index.php");
			die();
		}
	}

	checkLoggedIn();

	// L'utilisateur est connecté

	// On va vérifié que ce user a le role admin
	if($_SESSION['user']['role'] != 'admin') {
		header("HTTP/1.0 403 Forbidden");
		die();
	}

?>

Cette page est visible que pour les administrateurs


