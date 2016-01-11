<?php

	// Affiche un print_r avec un fond noir
	function pr($varArray) {
		echo "<pre style='background: #000; color: #FFF;'>";
		print_r($varArray);
		echo "</pre>";
	}

	// Vérification de la session users
	function checkLoggedIn() {
		// Si on a oublié d'appeler session_start()
		if(!isset($_SESSION)) {
			session_start();
		}

		if(empty($_SESSION['user'])) {
			$_SESSION['message'] = "Vous devez vous connecter.";
			
			header("Location: index.php");
			die();
		}
	}

?>