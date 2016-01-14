<?php
session_start();

require(__DIR__.'/functions.php');
checkLoggedIn();

$page ='Ajout de jeu';


include(__DIR__.'/config/db.php');

// AJOUT DE JEUX PAR LES UTILISATEURS
if (isset($_POST['action']) && ($_POST['action'] == 'create')) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	$url_img = $_POST['url_img'];
	$published_at = $_POST['published_at'];
	$game_time = $_POST['game_time'];
	$platforms = $_POST['platform_id'];


	$query = $pdo->prepare('INSERT INTO games(name, description, url_img, published_at, game_time, platform_id, owner_user_id) VALUES(?, ?, ?, ?, ?, ?, ?)');
	$query->bindValue(1, $name, PDO::PARAM_STR);
	$query->bindValue(2, $description, PDO::PARAM_STR);
	$query->bindValue(3, $url_img, PDO::PARAM_STR);
	$query->bindValue(4, $published_at, PDO::PARAM_STR);
	$query->bindValue(5, $game_time, PDO::PARAM_STR);
	$query->bindValue(6, $platforms, PDO::PARAM_INT);
	$query->bindValue(7, $_SESSION['user']['id'],PDO::PARAM_INT);
	$query->execute();




// if($query->rowCount() > 0) {
// 	$enregistrement('Vous avez enregistré votre jeu');
// } 
// else {
// 	$erreurEnregistrement("Une erreur est survenue à l'enregistrement");
// }

// // Retourne de la dernière ID insérée (integer)
// echo $pdo->lastInsertId();

// // Compte le nbr d'enregistrement affecté par la dernière requête
// echo $query->rowCount();

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Gameloc</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="public/css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
	<?php include(__DIR__.'/include/nav.php');?>

	<a href="catalogue.php" class="btn btn-success" role="button">Retour sur le catalogue</a>
	<hr>


	<!-- Formulaire d'ajout de film en POST -->
	<form id="add-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<fieldset>
			<legend>Ajouter un jeu</legend>
			<div class="form-group">
				<label for="name">Nom du jeu</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Titre du jeu" required/>
			</div>
			<div class="form-group">
				<label for="description">Description du jeu</label>
				<input type="text" class="form-control" id="description" name="description" placeholder="Descrire le jeu, son genre"/>
			</div>
			<div class="form-group">
				<label for="url_img">Lien Image</label>
				<input type="text" class="form-control" id="url_img" name="url_img" required/>
			</div>
			<div class="form-group">
				<label for="published_at">Date de sortie du jeu</label>
				<input type="text" class="form-control" id="published_at" name="published_at" placeholder="AAAA-MM-JJ"/>
			</div>
			<div class="form-group">
				<label for="game_time">Durée de temps du jeu</label>
				<input type="text" class="form-control" id="game_time" name="game_time" placeholder="10"/>
			</div>
			<div class="form-group">
				<label for="platform_id">Plateforme du jeu</label>
				<select class="form-control" id="platform_id" name="platform_id" required>
					<option value="" disabled selected>Selectionnez la plateforme</option>
					<option value="1">PC</option>
					<option value="2">Xbox One</option>
					<option value="3">PS4</option>
				</select>		
			</div>
			<button type="submit" class="btn btn-danger" name="action" value="create">Créer</button>

			<!-- <p><?php if($query->rowCount() > 0) { echo('Vous avez enregistré votre jeu');} 
				else { echo("Une erreur est survenue à l'enregistrement");} ?></p> -->

			</fieldset>
		</form>


	</body>
	</html>