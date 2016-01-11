<?php
	session_start();

	require(__DIR__.'/config/db.php');

	// Vérifie que le button submit a été cliqué
	if(isset($_POST['action'])) {
		$email = trim(htmlentities($_POST['emailId']));
		$password = trim(htmlentities($_POST['passwordId']));
		$passwordConfirm = trim(htmlentities($_POST['passwordConfirmId']));
		$lastName = trim(htmlentities($_POST['lastNameId']));
		$firstName = trim(htmlentities($_POST['firstNameId']));
		$address = trim(htmlentities($_POST['addressId']));
		$zipcode = trim(htmlentities($_POST['zipcodeId']));
		$town = trim(htmlentities($_POST['townId']));
		$phone = trim(htmlentities($_POST['phoneId']));

		// Initialisation d'un tableau d'erreurs
		$errors = [];

		// 1. Récupération de l'utilisateur dans la bdd grâce à son email
		$query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$resultUser = $query->fetch();

		// Si l'utilisateur a été trouvé
		if($resultUser) {
			// Compare un password en clair avec un password haché
			// Attention, PHP 5.5 ou plus !!! - Sinon, depuis 5.3.7 : https://github.com/ircmaxell/password_compat
			$isValidPassword = password_verify($password, $resultUser['password']);

			if($isValidPassword) {
				// On stocke le user en session et on retire le password avant (pas très grave)
				unset($resultUser['password']);
				$_SESSION['user'] = $resultUser;

				// On redirige l'utilisateur vers la page protégé profile.php
				header("Location: profile.php");
				die();
			}
			else {
				$errors['password'] = "Wrong password.";
			}
		}
		else {
			$errors['user'] = "User with email not found.";
		}

		$_SESSION['loginErrors'] = $errors;
		
		header("Location: index.php");
		die();
	}
?>