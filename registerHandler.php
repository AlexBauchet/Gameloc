<?php
	session_start();

	require(__DIR__.'/config/db.php');


	// Vérifie que le button submit a été cliqué
	if(isset($_POST['action'])) {
		// Affecte une variable à chaque valeur clé de $_POST
		$email = trim(htmlentities($_POST['email']));
		$password = trim(htmlentities($_POST['password']));
		$passwordConfirm = trim(htmlentities($_POST['passwordConfirm']));
		$lastname = trim(htmlentities($_POST['lastname']));
		$firstname = trim(htmlentities($_POST['firstname']));
		$address = trim(htmlentities($_POST['address']));
		$zipcode = trim(htmlentities($_POST['zipcode']));
		$town = trim(htmlentities($_POST['town']));
		$phone = trim(htmlentities($_POST['phone']));


		// Initialisation d'un tableau d'erreurs
		$errors = [];

		// Check du champs email
		if(empty($email) || (filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
			$errors['email'] = "Votre adresse mail est incorrecte.";
		}
		elseif(strlen($email) > 60) {
			$errors['email'] = "Votre mail est trop long.";
		}
		else {
			// Je vérifie que l'email existe pas déjà dans ma bdd
			$query = $pdo->prepare('SELECT email FROM users WHERE email = :email');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->execute();
			// Je récupère le résultat sql
			$resultEmail = $query->fetch();

			if($resultEmail['email']) {
				$errors['email'] = "Votre adresse mail existe déjà.";
			}
		}

		// Check du champs password
		// 1. Vérifier que les 2 passwords sont identiques
		// 2. Vérifier que le passwords ne fasse moins de 6 caractères
		// 3. Conditions de caractères dans le password

		if($password != $passwordConfirm) {
			$errors['password'] = "Mots de passe différents.";
		}
		elseif(strlen($password) <= 6) {
			$errors['password'] = "Mot de passe trop court.";
		}
		else {
			// Le password contient au moins une lettre ?
			$containsLetter = preg_match('/[a-zA-Z]/', $password);
			// Le password contient au moins un chiffre ?
			$containsDigit  = preg_match('/\d/', $password);
			// Le password contient au moins un autre caractère ?
			$containsSpecial= preg_match('/[^a-zA-Z\d]/', $password);

			// Si une des conditions n'est pas remplie ... erreur
			if(!$containsLetter || !$containsDigit || !$containsSpecial) {
				$errors['password'] = "Choisissez un meilleur mot de passe, avec au moins une lettre, un chiffre et un caractère spécial.";
			}
		}







		// S'il a pas d'erreurs, j'enregistre l'utilisateur en bdd
		if(empty($errors)) {
			$query = $pdo->prepare('INSERT INTO users (email, password, lastname, firstname, address, zipcode, town, phone)
									VALUES (:email, :password, :lastname, :firstname, :address, :zipcode, :town, :phone)');
			$query->bindValue(':email', $email, PDO::PARAM_STR);
			$query->bindValue(':lastname', $lastname, PDO::PARAM_STR);
			$query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
			$query->bindValue(':address', $address, PDO::PARAM_STR);
			$query->bindValue(':zipcode', $zipcode, PDO::PARAM_STR);
			$query->bindValue(':town', $town, PDO::PARAM_STR);
			$query->bindValue(':phone', $phone, PDO::PARAM_STR);

			// Hash du password pour la sécurité
			// Attention, PHP 5.5 ou plus !!! - Sinon, depuis 5.3.7 : https://github.com/ircmaxell/password_compat
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
			$query->execute();

			// L'utilisateur a t-il été bien inséré en bdd ?
			if($query->rowCount() > 0) {
				// Récupération de l'utilisateur depuis la bdd 
				// pour l'affecter à une variable de session
				$query = $pdo->prepare('SELECT * FROM users WHERE id = :id');
				$query->bindValue(':id', $pdo->lastInsertId(), PDO::PARAM_INT);
				$query->execute();
				$resultUser = $query->fetch();

				// On stocke le user en session et on retire le password avant (pas très grave)
				unset($resultUser['password']);
				$_SESSION['user'] = $resultUser;

				// On redirige l'utilisateur vers la page protégé profile.php
				header("Location: login.php");
				die();
			}
		}
		else {
			// On stocke toutes les erreurs en session
			$_SESSION['registerErrors'] = $errors;

			// On redirige dans l'index
			header("Location: register.php");
			die();
		}


	}
?>