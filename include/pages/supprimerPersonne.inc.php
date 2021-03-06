<?php
/**
* la vérification suivante permettent d'avoir des raccourci pour les variables envoyées par formulaire.
*/
  if(isset($_POST['idPers'])) {
    $id = $_POST['idPers'];
  }
?>

<h1>Supprimer une personne</h1>
<?php
 if(!isset($id)) { // Premier appel
   $pm = new PersonneManager($db);
   ?>
    <form class="customForm" action="#" method="post">
      <label for="idPers">Veuillez chosiir une personne : </label>
      <select name="idPers" id="idPers">
        <?php
          $personnes = $pm->getAllPersonns();
          foreach ($personnes as $personne) {
            ?>
              <option value="<?php echo $personne->getNum(); ?>"><?php echo $personne->getPrenom().' '.$personne->getNom(); ?></option>
            <?php
          }
        ?>
      </select>
      <input type="submit" value="Supprimer">
    </form>
   <?php
  } else { // Deuxième appel
   $pm = new PersonneManager($db);
   $effectue = $pm->delPers($id); // Supression de la personne
   if($effectue) {
    ?>
      <img src="image/valid.png" alt="OK"> La personne a été supprimé. <br /> <!--Tout s'est bien passé-->
    <?php
    } else {
    ?>
      <img src="image/erreur.png" alt="NOP"> Erreur lors de la suppression de la personne. <br /> <!--Il y a eu une erreur -->
      <?php
   }
 }
?>
