<?php
	session_start();

	require(__DIR__.'/config/db.php');

	$page ='Inscription';

?>	

<!DOCTYPE html>
<html>
<head>
	<title>Formulaire d'inscription - Gameloc</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<?php include(__DIR__.'/include/nav.php');?>

<div class="container">
			<div class="row">

				<?php if(isset($_SESSION['message'])): ?>
					<div class="alert alert-info">
						<p><?php echo $_SESSION['message']; ?></p>
						<?php unset($_SESSION['message']); ?>
					</div>
				<?php endif; ?>

				<div class="col-md-6 col-md-offset-4">
					

					<!-- Affiche les erreurs stockés en session avec la clé registerErrors -->
					<?php if(isset($_SESSION['registerErrors'])): ?>
						<div class="alert alert-danger">
							<?php foreach($_SESSION['registerErrors'] as $keyError => $error): ?>
								<p><?php echo $error; ?></p>
							<?php endforeach; ?>
						</div>
						<!-- Supprime les erreurs après les avoir affiché 1 fois -->
						<?php unset($_SESSION['registerErrors']); ?>
					<?php endif; ?>

					<!-- Copié de bootstrap : http://getbootstrap.com/css/#forms -->
					<form method="POST" action="registerHandler.php">
						<div class="form-group">
			              <label for="email">Email</label>
			              <input type="text" class="form-control" id="email" name="email" placeholder="Email">
			            </div>

			            <div class="form-group">
			              <label for="password">Mot de passe</label>
			              <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
			            </div>

			            <div class="form-group">
			              <label for="passwordConfirm">Confirmez votre mot de passe</label>
			              <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmez votre mot de passe" required>
			            </div>

			            <div class="form-group">
			              <label for="lastname">Votre Prénom</label>
			              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Votre prenom" required>
			            </div>

			            <div class="form-group">
			              <label for="firstname">Votre Nom</label>
			              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Votre Nom" required>
			            </div>

			            <div class="form-group">
			              <label for="address">Votre Adresse</label>
			              <input type="text" class="form-control" id="address" name="address" placeholder="Votre Adresse" required>
			            </div>

			            <div class="form-group">
			              <label for="zip">Votre code postal</label>
			              <input type="text" class="form-control" id="zipcode" name="zipcode" pattern="[0-9]{5}" placeholder="Votre code postal" required>
			            </div>

			            <div class="form-group">
			              <label for="town">Votre Ville</label>
			              <input type="text" class="form-control" id="town" name="town" placeholder="Votre Ville" required>
			            </div>

			            <div class="form-group">
			              <label for="phone">Votre Téléphone</label>
			              <input type="tel" class="form-control" id="phone" name="phone" placeholder="Votre numéro de téléphone" required>
			            </div>

			            <button type="submit" name="action" class="btn btn-primary">Valider</button>
					</form>
				</div>
			</div>
		</div>		

</body>
</html>