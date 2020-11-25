<?php
  if(isset($_POST['villeDep'])) {
    $villeDep = $_POST['villeDep'];
    $_SESSION["villeDepart"] = $villeDep;
  }
  if(isset($_POST['villeArrivee'])) {
    $villeArrivee = $_POST['villeArrivee'];
  }


  if(isset($_SESSION["villeDepart"])) {
    $villeDep = $_SESSION["villeDepart"];
  }
?>


<h1>Proposer un trajet</h1>

<?php
  if(!isset($villeDep)) {
    $pam = new ParcoursManager($db);
    $villes = $pam->getVillesProposees();
    ?>
      <form class="customForm" id="numVille" action="#" method="post">
        <label for="villeDep">Ville de départ :</label> <br />
        <select id="villeDep" name="villeDep" onChange="javascript:document.getElementById('numVille').submit()">
          <option value="-1">Choisissez</option>
          <?php
            foreach ($villes as $ville) {
              ?>
                <option value="<?php echo $ville->getNum(); ?>"><?php echo $ville->getNom(); ?></option>
              <?php
            }
          ?>
        </select>
      </form>
    <?php
  } else {
    if(!isset($villeArrivee)) {
    $vm = new VilleManager($db);
    $pam = new ParcoursManager($db);
    ?>
      <form class="customForm" action="#" method="post">
      <label>  Ville de départ : <?php echo $vm->getVilleFromId($villeDep); ?> </label>
      <label for="arrivee">Ville d'arrivée:</label>
      <select id="arrivée" name="villeArrivee">
        <?php
          $villes = $pam->getVillesArrivee($villeDep);
          foreach ($villes as $ville) {
            ?>
              <option value="<?php echo $ville->getNum(); ?>"><?php echo $ville->getNom(); ?></option>
            <?php
          }
        ?>
      </select> <br />
      <label for="date">Date de départ:</label> <input type="date" name="date" id=date value="<?php echo date("Y-m-d"); ?>">
      <label for="heure">Heure de départ : </label> <input type="text" name="heure" id=heure value="<?php echo date("H:i:s") ?>"> <br />
      <label for="places">Nombre de places :</label> <input type="number" name="places" id="places" placeholder="3"> <br />
      <input type="submit" value="Valider">
      </form>
    <?php
  } else {
    ?>
    c'est OK! je peut pas aller plus loin sans le reste
    <?php
    $nom = $_SESSION['username'];
    session_destroy();
    session_start();
    $_SESSION['connecte'] = "true";
    $_SESSION['username'] = $nom;
  }
}
?>
