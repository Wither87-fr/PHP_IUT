<h1>Ajouter une ville</h1>

<?php
// include_once 'include/ejectNotConnected.inc.php
  if(isset($_POST['nomVille'])) { //On vérifie que le formulaire a été rempli.
    $nomVille = $_POST['nomVille']; //On crée un "raccourci" pour $_POST['nomVille']
  }

  if(!isset($nomVille)) { //Lorsque la variable nomVille n'est pas set, nous sommes sur d'être au premier appel de la page.
    ?>
      <form class="customForm" action="#" method="post">
        <label for="nomVille">Nom : </label> <input type="text" name="nomVille" placeholder="ex : Toulouse" id="nomVille"> <input type="submit" value="Valider">
      </form>
    <?php
  } else {
    $villeManager = new VilleManager($db);
    $ok = $villeManager->addVille($nomVille);
    if($ok) {
      ?>
        <img src="image/valid.png" alt="OK"> La ville a été ajoutée <!--Tout s'est bien passé-->
      <?php
    } else {
      ?>
        <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de la ville <br /> <!--Il y a eu une erreur -->
      <?php
    }
  }
?>
