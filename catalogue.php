<?php
	session_start();
	
	require(__DIR__.'/functions.php');
	checkLoggedIn();

	$page ='Catalogue';


	include(__DIR__.'/config/db.php');


// echo __DIR__;


	$query = $pdo->prepare('SELECT * FROM games');
	// $query-> bindValue(':gameName', '%'.$gameName.'%', PDO::PARAM_STR);
	$query->execute();

	$allGames = $query->fetchAll();

	
// MOTEUR DE RECHERCHE

if(isset($_GET['GameName'])) {
	$GameName = $_GET['GameName'];

	$query = $pdo->prepare('SELECT * FROM games WHERE name LIKE ?');
	$query->bindValue(1, '%'.$GameName.'%', PDO::PARAM_STR);
	$query->execute();

	$allGames = $query->fetchAll();
} else {
	$query = $pdo->prepare('SELECT * FROM games'); // Prépare la requête
	$query->execute();
	$allMovies = $query->fetchAll();
}

$query = $pdo->prepare('SELECT id, name FROM games'); // Prépare la requête
$query->execute();
$allActors = $query->fetchAll();


	// RECHERCHE AVEC LA PLATEFORME ET LA DISPONIBILITE

	if(isset($_GET['action'])) {
	$gameName = htmlentities($_GET['search']); // Valeur de l'input text (string)
	$platforms = intval($_GET['platforms']); // Valeur de la selectbox (int)

	



	if($platforms > 0) { // Requete pour le PC, X1 ou PS4
		// 8. Refaire la même recherche SQL mais prendre en compte l'id de la catégorie


		$query = $pdo->prepare('SELECT games.*, platforms.name as platform_name FROM games
								INNER JOIN platforms ON games.platform_id = platforms.id
								WHERE (games.name LIKE :search)  AND (games.platforms_id = :platforms)');
		$query->bindValue(':search', '%'.$gameName.'%', PDO::PARAM_STR);
		$query->bindValue(':platforms', $platforms, PDO::PARAM_INT);
		$query->execute();
		$results = $query->fetchAll();

		print_r($results);



	}
	else { // Requete pour "Tous"

		// 6. Préparer et binder la value search pour faire la requête SQL adéquate sur le champs title
		// et description de la table videos (tester avec phpMyAdmin la requête)

		// 7. Modifier la requête pour faire la jointure avec la table categories (INNER JOIN)

		$query = $pdo->prepare('SELECT games.*, platforms.name as platform_name FROM games
								INNER JOIN platforms ON games.platform_id = platforms.id
								WHERE (games.name LIKE :search) AND (games.platform_id = :platforms)');
								
		$query->bindValue(':search', '%'.$gameName.'%', PDO::PARAM_STR);
		$query->bindValue(':platforms', $platforms, PDO::PARAM_INT);
		$query->execute();
		$results = $query->fetchAll();
	}



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
							<label for="search">Rechercher un jeu</label>
							<input type="text" class="form-control" id="search" name="search" />
						</div>

						<div>
							<label for="platforms">Plateforme</label>
							<select class="form-control" id="platforms" name="platforms">
							<option value="0">Tous</option>
							<option value="1">PC</option>
							<option value="2">Xbox One</option>
							<option value="3">PS4</option>
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
			

						<!-- Liste des jeux video du catalogue -->
	<div class="container">				
		<div class="row">
			<div class="col-md-1">
				<?php if(!empty($allGames)): ?>
					<?php foreach ($allGames as $keyGames => $games) : ?>
						<div>
						<label>

							<img id="image" src="<?php echo $games['url_img']; ?>" target="_blank"></img>														
							<p>Titre : <?php echo $games['name']; ?></p>
							<p>Description : <?php echo substr($games['description'], 0, 550); ?>...</p>								
							<p>Date de sortie : <?php echo ($games['published_at']); ?></p>
							<p>Temps de jeu : <?php echo ($games['game_time']); ?></p>								
							<p>Disponible : <?php echo ($games['is_available']); ?></p>
							<p>Article créé le <?php echo ($games['created_at']); ?></p>
							<p>Article mis a jour le <?php echo ($games['updated_at']); ?></p>

							<button type="submit" class="btn btn-primary" name="action" value="search">Louer</button>
						</label>
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