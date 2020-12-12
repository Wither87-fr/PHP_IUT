<?php
/**
* les trois vérifications suivantes permettent d'avoir des raccourci pour les variables envoyées par formulaire.
*/
  if(isset($_POST['km'])) {
    $km = $_POST['km'];
  }
  if(isset($_POST['ville1'])) {
    $ville1 = $_POST['ville1'];
  }

  if(isset($_POST['ville2'])) {
    $ville2 = $_POST['ville2'];
  }
?>

<h1>Ajouter un parcours</h1>
<?php
  if(!isset($km) || !isset($ville1) || !isset($ville2)) { //Premier appel
    $vm = new VilleManager($db);
    $parcours = $vm->listerVilles(); //Renvoie la totalité des villes de la base de donnée.
    ?>
      <form class="customForm" action="#" method="post">
        <label for="ville1">Ville 1 : </label>
        <select name="ville1" id="ville1">
            <?php
              foreach ($parcours as $value) {
                ?>
                  <option value="<?php echo $value->getNum(); ?>"><?php echo $value->getNom(); ?></option>
                <?php
              }
            ?>
        </select>
        <label for="ville2">Ville 2: </label>
        <select name="ville2" id="ville2">
            <?php
            $parcours = $vm->listerVilles();
              foreach ($parcours as $value) {
                ?>
                  <option value="<?php echo $value->getNum(); ?>"><?php echo $value->getNom(); ?></option>
                <?php
              }
            ?>
        </select>
        <label for="km">Nombre de kilomètre(s)</label> <input type="text" name="km" id="km" placeholder="256">
        <br />
        <input type="submit" value="Valider">
      </form>
    <?php
  } else { //Deuxième appel
    $pm = new ParcoursManager($db);
    $ok = $pm->addParcours($km, $ville1, $ville2); //Ajoute le parcours dans la BD
    if($ok) {
      ?>
        <img src="image/valid.png" alt="OK"> Le parcours a été ajoutée <br /><!--Tout s'est bien passé-->
      <?php
    } else {
      ?>
        <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout du parcours <br /> <!--Il y a eu une erreur -->
      <?php
    }
    }
  }
?>
