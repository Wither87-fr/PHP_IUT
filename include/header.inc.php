<?php session_start(); ?>
<?php
  $accueil = $_SERVER["PHP_SELF"]; // c'est l'adresse de l'accueil
  require_once 'autoload.inc.php';
  require_once 'db.inc.php';
  require_once 'functions.inc.php';
?>
<!doctype html>
<html lang="fr">

<head>

  <meta charset="utf-8">

<?php
		$title = "Bienvenue sur le site de covoiturage de l'IUT.";?>
		<title>
		<?php echo $title ?>
		</title>

<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>
	<body>
	<div id="header">
		<div id="entete">
			<div class="colonne">
				<a href="index.php?page=0">
					<img src="image/logo.png" alt="Logo covoiturage IUT" title="Logo covoiturage IUT Limousin" />
				</a>
			</div>
			<div class="colonne">
				Covoiturage de l'IUT,<br />Partagez plus que votre véhicule !!!
			</div>
			</div>
			<div id="connect">

        <?php if(isset($_SESSION['connecte'])) { // L'utilisateur est connecté
          ?>
          Utilisateur: <b><?php echo $_SESSION['username']; ?></b>
          <a href="index.php?page=12">Deconnexion</a>
          <?php
        } else { // L'utilisateur n'est pas connecté
          ?>
          <a href="index.php?page=11">Connexion</a>
          <?php
        } ?>
			</div>
	</div>
