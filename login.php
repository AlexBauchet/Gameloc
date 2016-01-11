<?php
	session_start();

	require(__DIR__.'/config/db.php');
?>	

<!DOCTYPE html>
<html>
<head>
	<title>Formulaire d'inscription - Gameloc</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>

<div class="container">
			<div class="row">

				<?php if(isset($_SESSION['message'])): ?>
					<div class="alert alert-info">
						<p><?php echo $_SESSION['message']; ?></p>
						<?php unset($_SESSION['message']); ?>
					</div>
				<?php endif; ?>

				<div class="col-md-6">
					<h1>Connexion</h1>

					<!-- Affiche les erreurs stockés en session avec la clé loginErrors -->
					<?php if(isset($_SESSION['loginErrors'])): ?>
						<div class="alert alert-danger">
							<?php foreach($_SESSION['loginErrors'] as $keyError => $errors): ?>
								<p><?php echo $errors; ?></p>
							<?php endforeach; ?>
						</div>
						<!-- Supprime les erreurs après les avoir affiché 1 fois -->
						<?php unset($_SESSION['loginErrors']); ?>
					<?php endif; ?>
					

					<!-- Copié de bootstrap : http://getbootstrap.com/css/#forms -->
					<form method="POST" action="loginHandler.php">
						<div class="form-group">
			              <label for="email">Email</label>
			              <input type="text" class="form-control" id="email" name="email" placeholder="Email">
			            </div>

			            <div class="form-group">
			              <label for="password">Mot de passe</label>
			              <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
			            </div>


			            <button type="submit" name="action" class="btn btn-primary">Valider</button>
					</form>
				</div>

</body>
</html>