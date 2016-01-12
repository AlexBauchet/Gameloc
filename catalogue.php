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
	<link rel="stylesheet" href="public/css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<?php include(__DIR__.'/include/nav.php');?>
	
			


						<!-- Moteur de recherche de film en GET -->


	<div class="row" id="cssRow">
		<div class="col-md-3">				
			<div id="fondRecherche">
				<hr />
					<form id="search-form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="form-group">
							<label for="GameName">Rechercher un jeu</label>
							<input type="text" class="form-control" id="GameName" name="GameName" />
						</div>

						<div>
							<label>Plateforme</label>
							<select class="form-control">
							<option>Tous</option>
							<option>Xbox One</option>
							<option>PC</option>
							<option>PS4</option>
							</select>							
						</div>
						<br>

						<div >
							<label>Type de jeu</label>
							<select class="form-control">
							<option>Tous</option>
							<option>RPG</option>
							<option>FPS</option>
							<option>Stratégie</option>
							<option>Gestion</option>
							<option>Combat</option>
							<option>Action</option>
							<option>Aventure</option>
							<option>Sport</option>
							<option>Course</option>
							</select>							
						</div>
						<br>

						<div>
							<input type="checkbox"> Disponible immédiatement</button>
						</div>
						<br>

						<button type="submit" class="btn btn-primary" name="action" value="search">Rechercher</button>
					</form>
				<hr />
			</div>
		</div>
	</div>
			


									<!-- Formulaire d'ajout de film en POST -->
			<!-- <div class="">
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
		</div> -->







						<!-- Liste des jeux video du catalogue -->
	<div class="container">				
		<div class="row">
			<div class="col-md-1">
				<?php if(!empty($allGames)): ?>
					<?php foreach ($allGames as $keyGames => $games) : ?>
						<div>
							<table class="table">
							
								<tr><img id="image" src="<?php echo $games['image']; ?>" target="_blank"></img><tr>
							

							
								<td>Titre </td>
								<td><?php echo $games['name']; ?></td> 
								<td>Description :</td>
								<td><?php echo substr($games['description'], 0, 550); ?>...</td> 
								<td>Date de sortie : </td>
								<td><?php echo ($games['date_published']); ?></td>
								<td>Temps de jeu :</td>
								<td><?php echo ($games['game_time']); ?></td>
								<td>aze</td>
								<td>ddd</td>
								
							</table>	

						</div>
					<?php endforeach; ?>
				<?php else: ?>
				<h5>Désolé, aucun jeu ne correspond a votre recherche.</h5>
				<?php endif; ?>
			</div>
		</div>
	</div>		

<div>
	<nav>
	  <ul class="pagination">
	    <li>
	      <a href="#" aria-label="Previous">
	        <span aria-hidden="true">&laquo;</span>
	      </a>
	    </li>
	    <li><a href="#">1</a></li>
	    <li><a href="#">2</a></li>
	    <li><a href="#">3</a></li>
	    <li><a href="#">4</a></li>
	    <li><a href="#">5</a></li>
	    <li>
	      <a href="#" aria-label="Next">
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>
	  </ul>
	</nav>
</div>	



</body>
</html>