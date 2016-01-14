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
		 	
	 	}
	 	else {
	 		$query = $pdo->prepare('SELECT games.*, platforms.name as platform_name FROM games
	 		INNER JOIN platforms ON games.platform_id = platforms.id
	 		WHERE (games.name LIKE :search)');

		 	$query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
		 	
		 	$query->execute();
		 	$results = $query->fetchAll();
	 		
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



// PAGINATION
// 1. Grâce à une query et la fonction SQL COUNT, récuperer le nombre total de users dans ma bdd
$query = $pdo->query('SELECT COUNT(*) AS total FROM games');
$countGames = $query->fetch();
$totalGames = $countGames['total']; // Valeur: 1020

// 2. Trouver la fonction qui arrondi une décimal à son entier supérieur et utiliser la 
// fonction ceil
$limitGames = 4;
$pagesGames = ceil($totalGames / $limitGames); // Valeur: 11

// echo "<pre>";
// print_r($countGames);
// echo "</pre>";

// 6. Récupérer la variable page envoyée en GET et l'affecter à $pageActiveGame
if(isset($_GET['page'])) {
	$pageActiveGames = $_GET['page'];
}
else {
	$pageActiveGames = 1;
}

// 7. Créer la variable $offsetGames et la binder dans la requête SQL
$offsetGames = ($pageActiveGames - 1) * $limitGames;

// 4. Construire la requête sql pour récupérer les 100 premiers users 
// (tester avec phpMyAdmin)
// Requete SQL : SELECT * FROM users LIMIT 100 OFFSET 0;
$query = $pdo->prepare('SELECT * FROM games LIMIT :limit OFFSET :offset');
$query->bindValue(':limit', $limitGames, PDO::PARAM_INT);
$query->bindValue(':offset', $offsetGames, PDO::PARAM_INT);
$query->execute();

$games = $query->fetchAll();

// echo "<pre>";
// print_r($games);
// echo "</pre>";


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

<div class="container-fluid">
		<div class="row" >

			<div class="col-md-3">				
				<div id="fondRecherche">
					<hr />
					<form id="search-form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<div class="form-group">
							<label for="search">Rechercher un jeu</label>
							<input type="text" class="form-control" id="search" name="search" />
						</div>
						<div>
							<label for="platforms">Plateforme du jeu</label>
							<select class="form-control" id="platforms" name="platforms">
								<option value="0">Tous</option>
								<option value="1">PC</option>
								<option value="2">Xbox One</option>
								<option value="3">PS4</option>
							</select>							
						</div>
						<br>
						<div>
							<input  name="checkbox" type="checkbox"> Disponible immédiatement</button>
						</div>
						<br>
						<button type="submit" class="btn btn-primary" name="action" value="search">Rechercher</button>
					</form>
					<hr />
				</div>
					<hr />
					<div id="fondRecherche">
						<a href="ajoutjeu.php" class="btn btn-primary" role="button">Ajouter un jeu</a>
					</div>
					
				
										
					<hr />
			</div>
	
			<!-- <div class="col-md-2">
				<div class="row">	 -->		
		<!-- Liste des jeux video du catalogue -->
					
			
				<div class="col-md-9">
					<?php if(!empty($results)): ?>
						<?php foreach ($results as $keyGames => $games) : ?>							
								<label>
									<img id="image" src="<?php echo $games['url_img']; ?>" target="_blank"></img>														
									<p>Titre : <?php echo $games['name']; ?></p>
									<!-- <p>Description : <?php echo substr($games['description'], 0, 550); ?>...</p>								
									<p>Date de sortie : <?php echo ($games['published_at']); ?></p>
									<p>Temps de jeu : <?php echo ($games['game_time']); ?></p>								
									<p>Disponible : <?php echo ($games['is_available']); ?></p>
									<p>Article créé le <?php echo ($games['created_at']); ?></p>
									<p>Article mis a jour le <?php echo ($games['updated_at']); ?></p> -->
									<p>Plateforme : <?php echo $games['']; ?></p>

									<button type="submit" class="btn btn-primary" name="action" value="search">Louer</button>
								</label>
							
						<?php endforeach; ?>
					<?php else: ?>
						<h5>Désolé, aucun jeu ne correspond a votre recherche.</h5>
					<?php endif; ?>
				</div>
				
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-5">						
				<nav>
					<ul class="pagination">
  						<!-- 8. Mettre la pagination suivante > et précédente > -->
  						<?php if($pagesGames > 1): ?>
  							<li><a href="catalogue.php?page=<?php echo $pageActiveGames - 1; ?>">></a></li>
  						<?php endif; ?>

  						<!-- 3. Construire la pagination pour n nombre de page $pageUsers -->
  						<?php for($i=1; $i <= $pagesGames; $i++): ?> 
					    	<li class="<?php if($pageActiveGames == $i) echo 'active'; ?>"><a href="catalogue.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
  						<?php endfor; ?>

  						<?php if($pageActiveGames < $pagesGames): ?>
  							<li><a href="catalogue.php?page=<?php echo $pageActiveGames + 1; ?>">></a></li>
  						<?php endif; ?>
				  	</ul>
				</nav>
			</div>
		</div>

</div>

<!-- Script JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>

	</body>
	</html>