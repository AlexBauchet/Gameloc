<?php
session_start();

require(__DIR__.'/functions.php');
checkLoggedIn();

$page ='Catalogue';


include(__DIR__.'/config/db.php');


//	RECHERCHE AVEC LA PLATEFORME ET LA DISPONIBILITE

if(isset($_GET['action'])) {
	$search = htmlentities($_GET['search']); // Valeur de la recherche
	$platforms = intval($_GET['platforms']); // Valeur de la selectbox (Tous, PC, X1, PS4)
	$location = isset($_GET['checkbox']); // Valeur si la checkbox est coché
	
	if($platforms > 0) { // Requete pour une plateforme (PC, X1 ou PS4)

		if($location) {
			$query = $pdo->prepare('SELECT games.*, platforms.name as platform_name FROM games
				INNER JOIN platforms ON games.platform_id = platforms.id
				WHERE (games.name LIKE :search  AND games.platform_id = :platforms)
				AND (games.is_available = 0)');
			$query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
			$query->bindValue(':platforms', $platforms, PDO::PARAM_INT);
			$query->execute();
			$results = $query->fetchAll();
		}
		else {
			$query = $pdo->prepare('SELECT games.*, platforms.name as platform_name FROM games
				INNER JOIN platforms ON games.platform_id = platforms.id
				WHERE (games.name LIKE :search  AND games.platform_id = :platforms)
				AND (games.is_available = 1)');
			$query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
			$query->bindValue(':platforms', $platforms, PDO::PARAM_INT);
			$query->execute();
			$results = $query->fetchAll();

		}

	}

	 	else { // Requete pour "Tous"

		// 6. Préparer et binder la value search pour faire la requête SQL adéquate sur le champs title
		// et description de la table videos (tester avec phpMyAdmin la requête)

		// 7. Modifier la requête pour faire la jointure avec la table categories (INNER JOIN)
	 	if($location) {
	 	$query = $pdo->prepare('SELECT games.*, platforms.name as platform_name FROM games
	 		INNER JOIN platforms ON games.platform_id = platforms.id
	 		WHERE (games.name LIKE :search)
	 		AND (games.is_available = 1)');

	 	$query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
	 	$query->execute();
	 	$results = $query->fetchAll();

	 	echo 'location a 1';
	 	}
	 	else {
	 		$query = $pdo->prepare('SELECT games.*, platforms.name as platform_name FROM games
	 		INNER JOIN platforms ON games.platform_id = platforms.id
	 		WHERE (games.name LIKE :search)
	 		AND (games.is_available = 0)');

	 	$query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
	 	$query->execute();
	 	$results = $query->fetchAll();

	 		echo 'location a 0';
	 	}


	 	}

	} 

	else {
 	// Affichage des jeux dans la page
		$query = $pdo->prepare('SELECT * FROM games');
		$query->execute();
		$results = $query->fetchAll();	
	}

// AJOUT DE JEUX PAR LES UTILISATEURS
// if (isset($_POST['action']) && ($_POST['action'] == 'create')) {
// 	$movieName = $_POST['name'];
// 	$movieSynopsis = $_POST['synopsis'];

// 	$query = $pdo->prepare('INSERT INTO movies(name, synopsis) VALUES(?, ?)');
// 	// $query->bindValue(1, $movieName, PDO::PARAM_STR);
// 	// $query->bindValue(2, $movieSynopsis, PDO::PARAM_STR);
// 	// $query->execute();
// 	$result = $query->execute(array($movieName, $movieSynopsis)); // Retourne true ou false
// 	if(!$result) {
// 		echo "Une erreur est survenue à l'enregistrement";
// 	}

// 	// Retourne de la dernière ID insérée (integer)
// 	echo $pdo->lastInsertId();

// 	// Compte le nbr d'enregistrement affecté par la dernière requête
// 	echo $query->rowCount();

// }







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

						<div class="checkbox">
							<input name="checkbox" type="checkbox" > Disponible immédiatement</button>
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
					<?php if(!empty($results)): ?>
						<?php foreach ($results as $keyGames => $games) : ?>
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