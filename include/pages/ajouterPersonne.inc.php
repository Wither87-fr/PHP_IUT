<?php
/**
* les douze vérifications suivantes permettent d'avoir des raccourci pour les variables envoyées par formulaire.
*/
  if(isset($_POST['per_nom'])) {
    $per_nom = $_POST['per_nom'];
  }
	if(isset($_POST['per_prenom'])) {
    $per_prenom = $_POST['per_prenom'];
  }
	if(isset($_POST['per_tel'])) {
    $per_tel = $_POST['per_tel'];
  }
	if(isset($_POST['per_mail'])) {
    $per_mail = $_POST['per_mail'];
  }
	if(isset($_POST['per_login'])) {
    $per_login = $_POST['per_login'];
  }
	if(isset($_POST['per_pwd'])) {
    $per_pwd = $_POST['per_pwd'];
  }
  if(isset($_POST['choix'])) {
    $choix = $_POST['choix'];
  }
  if(isset($_POST['annee'])) {
    $annee = $_POST['annee'];
  }

  if(isset($_POST['dep'])) {
    $dep = $_POST['dep'];
  }

  if(isset($_POST['num_pers'])) {
    $num_pers = $_POST['num_pers'];
  }

  if(isset($_POST['tel_prof'])) {
    $tel_prof = $_POST['tel_prof'];
  }

  if(isset($_POST['fonction'])) {
    $fonction = $_POST['fonction'];
  }
?>


<?php
	if (!isset($per_nom) || !isset($per_prenom) || !isset($per_tel) || !isset($per_mail) || !isset($per_login) || !isset($per_pwd) || !isset($choix)) { //Premier appel
		?>
    <h1>Ajouter une personne</h1>
		<form class="customForm" action="#" method="post">
			<label for="Nom">Nom : </label> <input type="text" name="per_nom" id="Nom">
			<label for="Prenom">Prenom : </label> <input type="text" name="per_prenom" id="Prenom">
			<br />
			<label for="Téléphone">Téléphone : </label> <input type="text" name="per_tel" id="Téléphone">
			<label for="Mail">Mail : </label> <input type="email" name="per_mail" id="Mail">
			<br />
			<label for="Login">Login : </label> <input type="text" name="per_login" id="Login">
			<label for="Mot de Passe">Mot de Passe : </label> <input type="password" name="per_pwd" id="Mot de Passe">
			<br />
			<label for="Catégorie">Catégorie : </label>
			<input type="radio" id="etudiant" name="choix" value="etudiant" checked="checked"> <label for="etudiant">Etudiant</label>
			<input type="radio" id="personnel" name="choix" value="personnel"> <label for="personnel">Personnel</label>
			<br />
			<input type="submit" value="Valider">
		</form>
		<?php
	} else { // Deuxième ou troisième appel
    $pm = new PersonneManager($db);


      switch ($choix) { //Comme il y a deux choix possible, on a deux formaulaires possibles, et ils sont donc traités ici.
        case 'etudiant':

        if(!isset($dep) || !isset($annee) || !isset($num_pers)) {  // Deuxième appel
          if(!personneExiste($pm->getAllPersonns(), $per_login)) { // Le login n'existe pas déjà
            $pwd = encrypt($per_pwd);
            $num_pers = $pm->addPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $pwd); // Ajoute la personne dans la BD et renvoie son numéro

          ?>
          <h1>Ajouter un étudiant</h1>
          <?php
            $divm = new DivisionManager($db);
            $listeDiv = $divm->listerDivisions();
            $depm = new DepartementManager($db);
            $listeDep = $depm->listerDepartements();
            ?>
            <form class="customForm" action="#" method="post">

              <label for="annee">Année : </label>
              <select name="annee" id="annee">
                  <?php
                    foreach ($listeDiv as $value) {
                      ?>
                        <option value="<?php echo $value->getNum(); ?>"><?php echo $value->getNom(); ?></option>
                      <?php
                    }
                  ?>
              </select>
              <label for="dep">Département : </label>
              <select name="dep" id="dep">
                  <?php
                    foreach ($listeDep as $value) {
                      ?>
                        <option value="<?php echo $value->getNum(); ?>"><?php echo $value->getNom(); ?></option>
                      <?php
                    }
                  ?>
              </select>
              <input type="hidden" name="num_pers" value="<?php echo $num_pers; ?>">
              <input type="submit" value="Valider">
              <input type="hidden" name="per_nom" value="<?php echo $per_nom; ?>">
              <input type="hidden" name="per_prenom" value="<?php echo $per_prenom; ?>">
              <input type="hidden" name="per_tel" value="<?php echo $per_tel; ?>">
              <input type="hidden" name="per_mail" value="<?php echo $per_mail; ?>">
              <input type="hidden" name="per_login" value="<?php echo $per_login; ?>">
              <input type="hidden" name="per_pwd" value="<?php echo $per_pwd; ?>">
              <input type="hidden" name="choix" value="<?php echo $choix; ?>">
            </form>
          <?php
        } else { //Le login existe déjà :
        ?>
          <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de la personne, login existant déjà <br /> <!--Il y a eu une erreur -->
        <?php
        }
      } else { // Troisième appel
          $em = new EtudiantManager($db);
          $ok = $em->addEtudiant($num_pers, $dep, $annee); //Ajoute l'étudiant dans la BD
          if($ok) {
          ?>
              <img src="image/valid.png" alt="OK"> L'étudiant a été ajoutée <br /> <!--Tout s'est bien passé-->
          <?php
          } else {
          ?>
            <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de l'étudiant <br /> <!--Il y a eu une erreur -->
          <?php
          }
        }
          break;
        case 'personnel':

          if (!isset($fonction) || !isset($tel_prof) || !isset($num_pers)) { // Deuxième appel
            if(!personneExiste($pm->getAllPersonns(), $per_login)) { // Le login n'existe pas déjà
              $pwd = encrypt($per_pwd);
              $num_pers = $pm->addPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $pwd); // Ajoute la personne dans la BD et renvoie son numéro
            ?>
            <h1>Ajouter un salarié</h1>
            <?php
              $fonm = new FonctionManager($db);
              $listeFon = $fonm->listerFonctions();
              ?>
              <form class="customForm" action="#" method="post">
                <label for="tel_prof">Téléphone professionnel : </label>
                <input type="tel" name="tel_prof" placeholder="06 66 66 66 66" id="tel_prof">

                <label for="fonction">Fonction : </label>
                <select name="fonction" id="fonction">
                    <?php
                      foreach ($listeFon as $value) {
                        ?>
                          <option value="<?php echo $value->getNum(); ?>"><?php echo $value->getNom(); ?></option>
                        <?php
                      }
                    ?>
                </select>
                <input type="hidden" name="num_pers" value="<?php echo $num_pers; ?>">
                <input type="submit" value="Valider">
                <input type="hidden" name="per_nom" value="<?php echo $per_nom; ?>">
                <input type="hidden" name="per_prenom" value="<?php echo $per_prenom; ?>">
                <input type="hidden" name="per_tel" value="<?php echo $per_tel; ?>">
                <input type="hidden" name="per_mail" value="<?php echo $per_mail; ?>">
                <input type="hidden" name="per_login" value="<?php echo $per_login; ?>">
                <input type="hidden" name="per_pwd" value="<?php echo $per_pwd; ?>">
                <input type="hidden" name="choix" value="<?php echo $choix; ?>">
              </form>
              <?php
            } else { // Le login existe déjà
            ?>
              <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de la personne, login existant déjà <br /> <!--Il y a eu une erreur -->
            <?php
            }
          } else { // Troisième Appel
            $sm = new SalarieManager($db);
            $ok = $sm->addSalarie($num_pers, $tel_prof, $fonction); //Ajoute le salarié dans la BD
            if($ok) {
            ?>
                <img src="image/valid.png" alt="OK"> Le salarié a été ajoutée <!--Tout s'est bien passé-->
            <?php
            } else {
            ?>
              <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout du salarié <br /> <!--Il y a eu une erreur -->
            <?php
            }
          }
          break;
        default:
          break;
        }
	}
?>
