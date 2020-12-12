<h1>Ajouter une ville</h1>

<?php
/**
* La vérification suivante permet d'avoir un raccourci pour les variables entrées par formulaire
*/
  if(isset($_POST['nomVille'])) {
    $nomVille = $_POST['nomVille'];
  }

  if(!isset($nomVille)) { // Premier Appel
    ?>
      <form class="customForm" action="#" method="post">
        <label for="nomVille">Nom : </label> <input type="text" name="nomVille" placeholder="ex : Toulouse" id="nomVille"> <input type="submit" value="Valider">
      </form>
    <?php
  } else { // Deuxième appel
    $villeManager = new VilleManager($db);
    $ok = $villeManager->addVille($nomVille);
    if($ok) {
      ?>
        <img src="image/valid.png" alt="OK"> La ville a été ajoutée <br /> <!--Tout s'est bien passé-->
      <?php
    } else {
      ?>
        <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de la ville <br /> <!--Il y a eu une erreur -->
      <?php
    }
  }
?>
