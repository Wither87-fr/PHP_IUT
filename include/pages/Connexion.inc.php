
<?php
$valid = false; // Informations rentrées valide ou non.
  $pm = new PersonneManager($db);
  $listePers = $pm->getAllPersonns(); // Liste de toutes les personnes de la BD


  if(isset($_POST['username'])) {
    $trouve = personneExiste($listePers, $_POST['username']); // verifie que la personne existe bien
    if($trouve) { //la personne existe
      $nom = $_POST['username']; //raccourci pour le nom d'utilisateur
    }
  } else { // la personne n'existe pas
    $valid = false;
  }

  if(isset($_POST['pwd'])) {
    if(encrypt($_POST['pwd']) === $pm->getPersonneFromLogin($_POST['username'])->getPwd()) { // Le mot de passe entré et le mot de passe enregistré correspondent
      $pwd = $_POST['pwd'];
    } else { // Le mot de passe entré et le mot de passe enregistré ne correspondent pas
      $valid = false;
    }
  }

  if(isset($_POST['captcha']) && isset($_POST['result'])) {
    if($_POST['result'] === $_POST['captcha']) { // L'utilisateur a correctement résolu le Captcha
      $captcha = $_POST['captcha'];
    } else { // L'utilisateur n'a pas correctement résolu le Captcha
      $valid = false;
    }
  }

  if(isset($nom) && isset($pwd) && isset($captcha)) { // toutes les informations ont été vérifiées
    $valid = true;
  }
?>
<h1>Pour vous connecter</h1>
<?php
if(! $valid) { // On est au premier appel, ou les informations rentrées sont incorrectes.
  $rand1 = rand(1,9); $rand2 = rand(1,9); // génération de deux nombres aléatoires entre 1 et 9
  $result = $rand1 + $rand2; // calcul de leur somme
  ?>
  <form class="customForm" action="#" method="post">
    <label for="username">Nom d'utilisateur:</label> <br />
    <input type="text" name="username" id="username" placeholder="Bob" required> <br />
    <label for="pwd">Mot de passe:</label> <br />
    <input type="password" name="pwd" id="pwd" required> <br />
    <input type="hidden" name="result" value="<?php echo $result ?>">
    <br />
    <div class="captcha">
      <img src="image/nb/<?php echo $rand1; ?>.jpg" alt="<?php echo $rand1; ?>"> + <img src="image/nb/<?php echo $rand2; ?>.jpg" alt="<?php echo $rand2; ?>"> = <br />
      <input type="text" name="captcha" placeholder="résultat de l'oppération" required>
    </div>
    <input type="submit" value="Valider">
  </form>
  <?php
} else { // Les informations sont valides
  $_SESSION['connecte'] = "true"; // La personne est connectée
  $_SESSION['username'] = $nom; // son nom d'utilisateur est enregistré
  header('Location: '.$accueil); // il est renvoyé à l'accueil, mais connecté.
  exit;
}

?>
