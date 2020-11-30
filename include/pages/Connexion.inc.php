
<?php
$valid = false;
  $pm = new PersonneManager($db);
  $listePers = $pm->getAllPersonns();
  include_once 'include/usefullFunctions.inc.php'; */
  if(isset($_POST['username'])) {
    $trouve = personneExiste($listePersonne, $personneAtester);
    if($trouve) {
      $nom = $_POST['username'];
    }
  } else {
    $valid = false;
  }

  if(isset($_POST['pwd'])) {
    if(encrypt($_POST['pwd']) === $pm->getPersonneFromLogin($nom)->getPwd()) { // if(verifyPassword($_POST['pwd'], SALT)) {
      $pwd = $_POST['pwd'];
    }
  } else {
    $valid = false;
  }

  if(isset($_POST['captcha']) && isset($_POST['result'])) {
    if($_POST['result'] === $_POST['captcha']) {
      $captcha = $_POST['captcha'];
    }
  } else {
    $valid = false;
  }


  if(isset($nom) && isset($pwd) && isset($captcha)) {
    $valid = true;
  }
?>
<h1>Pour vous connecter</h1>
<?php
if(! $valid) {
  $rand1 = rand(1,9);
  $rand2 = rand(1,9);
  $result = $rand1 + $rand2;
  ?>
  <form class="customForm" action="#" method="post">
    <label for="username">Nom d'utilisateur:</label> <br />
    <input type="text" name="username" id="username" placeholder="bob"> <br />
    <label for="pwd">Mot de passe:</label> <br />
    <input type="password" name="pwd" id="pwd"> <br />
    <input type="hidden" name="result" value="<?php echo $result ?>">
    <br />
    <div class="captcha">
      <img src="image/nb/<?php echo $rand1; ?>.jpg" alt="<?php echo $rand1; ?>"> + <img src="image/nb/<?php echo $rand2; ?>.jpg" alt="<?php echo $rand2; ?>"> = <br />
      <input type="text" name="captcha" placeholder="résultat de l'oppération">
    </div>
    <input type="submit" value="Valider">
  </form>
  <?php
} else {
  $_SESSION['connecte'] = "true";
  $_SESSION['username'] = $nom;
  header('Location: '.$accueil);
  exit;
}

?>
