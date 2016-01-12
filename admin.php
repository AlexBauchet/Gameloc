<?php
session_start();

require(__DIR__.'/config/db.php');
require(__DIR__.'/functions.php');
checkLoggedIn();

$page = 'Admin';

	// Cette fonction doit être mis de préférence dans le fichier functions.php
	// function checkLoggedIn() {
	// 	if(empty($_SESSION['user'])) {
	// 		header("Location: index.php");
	// 		die();
	// 	}
	// }

checkLoggedIn();

	// L'utilisateur est connecté

	// On va vérifié que ce user a le role admin
if($_SESSION['user']['role'] != 'admin') {
	header("HTTP/1.0 403 Forbidden");
	die();
}

	// Compter le nombre de users en bdd
$query = $pdo->query('SELECT count(id) as total FROM users');
$resultCount = $query->fetch();
	$totalUsers = $resultCount['total']; // Afficher cela dans la page admin


	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Gameloc</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="public/css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<style type="text/css">
			#map { 
				height: 92%; 
				width: 95%; 
				margin: 20px; 
				padding: 10%; 				
    			margin-left: auto;
    			margin-right: auto ;						 
			}


		</style>

	</head>


	<body>

		<?php include(__DIR__.'/include/nav.php');?>

		<div>
		<div>
			<h1>Statistique</h1>
			<p>Le site contient <?php echo $totalUsers; ?> utilisateur(s).</p>
		</div>
		


		<h1>Localisation des utilisateurs</h1>
		<div id="map"></div>
		
		<script type="text/javascript">

			var map;

			var myLatLng = {lat: 48.8909964, lng: 2.2345892};
			function initMap() {
				map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: 48.8534100, lng: 2.3488000},
					zoom: 12
				});

				var marker = new google.maps.Marker({
					position : myLatLng,  
					map: map,
					title: 'hello'
				})

			}
		</script>

		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApFHyhOE1lniNGNo0yrkthO-wEUp4OOzM&callback=initMap">
	</script>
	

<h1>Les derniers jeux ajoutés par les nouveaux inscrits</h1>


</div>

</body>
</html>


