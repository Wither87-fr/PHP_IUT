<?php
  if(isset($_POST['villeDep'])) {
    $villeDep = $_POST['villeDep'];
  }
  if(isset($_POST['villeArrivee'])) {
    $villeArrivee = $_POST['villeArrivee'];
  }
  if(isset($_POST['date'])) {
    $date = $_POST['date'];
  }
  if(isset($_POST['heure'])) {
    $heure = $_POST['heure'];
  }
  if(isset($_POST['places'])) {
    $places = $_POST['places'];
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
      <input type="hidden" name="villeDep" value="<?php echo $villeDep; ?>">
      </form>
    <?php
  } else {
    $pm = new ProposeManager($db);
    $perm = new PersonneManager($db);
    $parm = new ParcoursManager($db);
    $par_num = $parm->getParNumByVille1AndVille2($villeDep, $villeArrivee);
    $sens = $pm->getSens($par_num, $villeDep);
    $ok = $pm->propose($par_num, $perm->getPersonneFromLogin($_SESSION['username'])->getNum(), $date, $heure, $places, $sens);

    if($ok) {
      ?>
        <img src="image/valid.png" alt="OK"> Le trajet a été ajouté <!--Tout s'est bien passé-->
      <?php
    } else {
      ?>
        <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout du trajet <br /> <!--Il y a eu une erreur -->
      <?php
    }
  }
  }
?>
