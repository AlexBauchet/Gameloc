<?php
	session_start();
	
	require(__DIR__.'/functions.php');
	// checkLoggedIn();

	$page ='Catalogue';


	include(__DIR__.'/config/db.php');


// echo __DIR__;


	$query = $pdo->prepare('SELECT * FROM jeux_video');
	// $query-> bindValue(':gameName', '%'.$gameName.'%', PDO::PARAM_STR);
	$query->execute();

	$allGames = $query->fetchAll();

	// print_r($allGames);

// else {

// 	$query = $pdo->prepare('SELECT * FROM jeux_video'); // Prepare la requete
// 	$query->execute();
// 	$allMovies = $query->fetchAll();

// $query = $pdo->prepare('SELECT id, name FROM jeux_video'); // Prepare la requete
// $query->execute();
// $allActors = $query->fetchAll();
// }

/*		AJOUT DE JEUX DANS LA BDD

if(isset($_POST['name'])) {
	$newMovieName = $_POST['name'];
	$newSynopsis = $_POST['description'];
	echo $newMovieName.'<br>';
	echo $newSynopsis;

	$query = $pdo->prepare('INSERT INTO movies(name, synopsis) VALUES(:name, :synopsis)');
	$query->bindValue(':name', $newMovieName, PDO::PARAM_STR);
	$query->bindValue(':synopsis', $newSynopsis, PDO::PARAM_STR);
	$query->execute();
}

*/

// echo '<pre>';
// print_r($gameName);
//  echo '</pre>';




// MOTEUR DE RECHERCHE

if(isset($_GET['GameName'])) {
	$GameName = $_GET['GameName'];

	$query = $pdo->prepare('SELECT * FROM jeux_video WHERE name LIKE ?');
	$query->bindValue(1, '%'.$GameName.'%', PDO::PARAM_STR);
	$query->execute();

	$allGames = $query->fetchAll();
} else {
	$query = $pdo->prepare('SELECT * FROM jeux_video'); // Prépare la requête
	$query->execute();
	$allMovies = $query->fetchAll();
}

$query = $pdo->prepare('SELECT id, name FROM jeux_video'); // Prépare la requête
$query->execute();
$allActors = $query->fetchAll();



// ENVOI FORMULAIRE DES JEUX DANS LA BDD -> check la value du btn submit
if (isset($_POST['action']) && ($_POST['action'] == 'create')) {
	$name = trim(htmlentities($_POST['name']));
	$description = trim(htmlentities($_POST['description']));
	$image = trim(htmlentities($_POST['image']));
	$date_published = trim(htmlentities($_POST['date_published']));
	$game_time = trim(htmlentities($_POST['game_time']));

	// Initialisation d'un tableau d'erreurs
		$errors = [];

	

	$query = $pdo->prepare('INSERT INTO jeux_video(name, description, image, date_published, game_time) VALUES(?, ?, ?, ?, ?)');
	$query->bindValue(1, $name, PDO::PARAM_STR);
	$query->bindValue(2, $description, PDO::PARAM_STR);
	$query->bindValue(3, $image, PDO::PARAM_STR);
	$query->bindValue(4, $date_published, PDO::PARAM_STR);
	$query->bindValue(5, $game_time, PDO::PARAM_STR);

	
	$result = $query->execute(array($name, $description, $image, $date_published, $game_time)); // Retourne true ou false
		if(!$result) {
		echo "Une erreur est survenue à l'enregistrement";
		}
	$results = $query->fetchAll();

	header('location: catalogue.php');
	die();
		

	// Retourne de la dernière ID insérée (integer)
	// echo $pdo->lastInsertId();

	// Compte le nbr d'enregistrement affecté par la dernière requête
	// echo $query->rowCount();

}


?>



<!DOCTYPE html>
<html>
<head>
	<title>Gameloc</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<?php include(__DIR__.'/include/nav.php');?>
	<div class="container">
		<div class="row">
			<div class="col-md-4">

						<!-- Moteur de recherche de film en GET -->
			
				<hr />
					<form id="search-form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="form-group">
							<label for="GameName">Rechercher un jeu</label>
							<input type="text" class="form-control" id="GameName" name="GameName" />
						</div>
						<button type="submit" class="btn btn-primary" name="action" value="search">OK</button>
					</form>
				<hr />
			


									<!-- Formulaire d'ajout de film en POST -->
			<form id="add-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<fieldset>
					<legend>Ajouter un jeu</legend>

			
		
					<div class="form-group">
						<label for="name">Nom du jeu</label>
						<input type="text" class="form-control" id="name" name="name" />
					</div>

					<div class="form-group">
						<label for="description">Description</label>
						<input type="text" class="form-control" id="description" name="description" />
					</div>

					<div class="form-group">
						<label for="image">Image</label>
						<input type="text" class="form-control" id="image" name="image" />
					</div>

					<div class="form-group">
						<label for="date_published">Date de sortie</label>
						<input type="text" class="form-control" id="date_published" name="date_published" />
					</div>

					<div class="form-group">
						<label for="game_time">Temps de jeu</label>
						<input type="text" class="form-control" id="game_time" name="game_time" />
					</div>

					
					<button type="submit" class="btn btn-danger" name="action" value="create" onclick="">Créer</button>
				</fieldset>
			</form>
		</div>







						<!-- Liste des jeux video du catalogue -->
			<div class="col-md-8">
				<?php if(!empty($allGames)): ?>
					<?php foreach ($allGames as $keyGames => $games) : ?>
						<div>
							<dl class="dl-horizontal">
							
								<dd><img id="image" src="<?php echo $games['image']; ?>" target="_blank"></img><dd>
							

							
								<dt>Titre </dt>
								<dd><?php echo $games['name']; ?></dd> 
								<dt>Description :</dt>
								<dd><?php echo substr($games['description'], 0, 550); ?>...</dd> 
								<dt>Date de sortie : </dt>
								<dd><?php echo ($games['date_published']); ?></dd>
								<dt>Temps de jeu :</dt>
								<dd><?php echo ($games['game_time']); ?></dd>
								<dt>aze</dt>
								<dd>ddd</dd>
								
							</dl>	

						</div>
					<?php endforeach; ?>
				<?php else: ?>
				<h5>Désolé, aucun jeu ne correspond a votre recherche.</h5>
				<?php endif; ?>

			</div>
			
							
			</div>
		</div>
	</div>


</body>
</html>