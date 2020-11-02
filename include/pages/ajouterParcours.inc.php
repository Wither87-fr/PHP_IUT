<?php
  //include_once 'include/ejectNotConnected.inc.php';
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
  if(!isset($km) || !isset($ville1) || !isset($ville2)) {
    $vm = new VilleManager($db);
    $parcours = $vm->listerVilles();
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
  } else {
    $pm = new ParcoursManager($db);
    $pm->addParcours($km, $ville1, $ville2);
  }
?>
