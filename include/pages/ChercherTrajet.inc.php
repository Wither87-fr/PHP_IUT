<?php
if(isset($_POST['vil_dep'])) {
  $vil_dep = $_POST['vil_dep'];
}
if(isset($_POST['vil_ar'])) {
  $vil_ar = $_POST['vil_ar'];
}
if(isset($_POST['date_dep'])) {
  $date_dep = $_POST['date_dep'];
}
if(isset($_POST['precision'])) {
  $precision = $_POST['precision'];
}
if(isset($_POST['heure_min'])) {
  $heure_min = $_POST['heure_min'];
}

?>
  <h1>Rechercher un trajet</h1>
<?php
if(!isset($vil_dep)) {
  $propm = new ProposeManager($db);
  $listeVilleDep = $propm->getVillesDepartDejaProposees();
  ?>
    <form class="customForm" action="#" method="post">
      <label for="vil_dep"> Ville de départ : </label> <br />
      <select name="vil_dep" id="vil_dep">
        <?php
          foreach ($listeVilleDep as $ville) {
            ?>
              <option value="<?php echo $ville->getNum(); ?>"> <?php echo $ville->getNom(); ?></option>
            <?php
          }
        ?>
      </select> <br />
      <input type="submit" value="Valider">
    </form>
  <?php
} else {
  if(!isset($vil_ar) || !isset($date_dep) || !isset($precision) || !isset($heure_min)) {
    $vm = new VilleManager($db);
    $propm = new ProposeManager($db);
    $listeVilleArrivee = $propm->getVillesArriveeDejaProposees($vil_dep);
    ?>
      <form class="customForm" action="#" method="post">
        Ville de départ : <?php echo $vm->getVilleFromId($vil_dep); ?> <label for="vil_ar">Ville d'arrivée : </label>
          <select name="vil_ar" id="vil_ar">
            <?php
              foreach ($listeVilleArrivee as $ville) {
                ?>
                  <option value="<?php echo $ville->getNum(); ?>"><?php echo $ville->getNom(); ?></option>
                <?php
              }
            ?>
          </select> <br/>
          <label for="date_dep"> Date de départ : </label> <input type="date" name="date_dep" value="<?php echo date("Y-m-d") ?>" id="date_dep">
          <label for="precision"> Précision : </label>
          <select name="precision" id="precision">
            <option value="0">Ce jour</option>
            <option value="1">+/- 1 jour</option>
            <option value="2">+/- 2 jours</option>
            <option value="3">+/- 3 jours</option>
          </select>
          <br />
          <label for="heure_min">A partir de : </label> <?php createHourList(); ?>
          <br />
          <input type="submit" value="valider">
          <input type="hidden" name="vil_dep" value="<?php echo $vil_dep; ?>">
      </form>
    <?php
  } else {
    $propm = new ProposeManager($db);
    $pm = new ParcoursManager($db);
    $vm = new VilleManager($db);
    $perm = new PersonneManager($db);
    $par_num = $pm->getParNumByVille1AndVille2($vil_dep, $vil_ar);
    $date_max = addJours($date_dep, intval($precision));
    $tab = $propm->getPropositions($par_num, $date_dep, $heure_min, $date_max); // renvoie un tableau de "ProposeAfficheur"
    if (count($tab)===0) {
      ?>
      <img src="image/erreur.png" alt="NOP">Désolé, pas de trajet disponible ! <br />
      <?php
    } else {
      ?>
        <table>
          <thead>
            <tr>
              <th>Ville départ</th>
              <th>Ville arrivée</th>
              <th>Date départ</th>
              <th>Heure départ</th>
              <th>Nombre de place(s)</th>
              <th>Nom du covoitureur</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($tab as $parcours) {
                ?>
                  <tr>
                    <td><?php echo $vm->getVilleFromId($parcours->getVilleDepart()); ?></td>
                    <td><?php echo $vm->getVilleFromId($parcours->getVilleArrivee());?></td>
                    <td><?php echo $parcours->getDate();?></td>
                    <td><?php echo $parcours->getHeure(); ?></td>
                    <td><?php echo $parcours->getPlaces(); ?></td>
                    <td><acronym title="Moyenne des avis : <?php echo number_format($perm->getAvgNote($parcours->getConducteur()), 2); ?>, Dernier avis : <?php echo $perm->getCommentaire($parcours->getConducteur()); ?>"><?php echo $perm->getPrenomFromId($parcours->getConducteur())." ".$perm->getNomFromId($parcours->getConducteur()); ?></acronym></td>
                  </tr>
                <?php
              }
            ?>
          </tbody>
        </table>
      <?php
    }
  }
}
?>
