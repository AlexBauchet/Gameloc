<?php

include(__DIR__.'/config/db.php');
// echo __DIR__;


	$query = $pdo->prepare('SELECT * FROM jeux_video');
	// $query-> bindValue(':gameName', '%'.$gameName.'%', PDO::PARAM_STR);
	$query->execute();

	$allGames = $query->fetchAll();

	print_r($allGames);

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
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php if(!empty($allGames)): ?>
							<?php foreach ($allGames as $keyGames => $games) : ?>
								<div>
									<h3><?php echo $games['name']; ?></h3> 
									<img id="image" src="<?php echo $games['image']; ?>" target="_blank"></img> <br><br>
									<p id="text1"><?php echo substr($games['description'], 0, 550); ?>...</p>
																		
								</div>
							<?php endforeach; ?>
						<?php else: ?>
						<h5>Désolé, aucun jeu ne correspond a votre recherche.</h5>
						<?php endif; ?>


							
			</div>
		</div>
	</div>


</body>
</html>