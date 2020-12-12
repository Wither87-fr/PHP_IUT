<?php

/**
* les quatorze vérifications suivantes permettent d'avoir des raccourci pour les variables envoyées par formulaire.
*/
  if(isset($_POST['idPers'])) {
    $id = $_POST['idPers'];
  }
  if(isset($_POST['choix'])) {
    $choix = $_POST['choix'];
  }
  if(isset($_POST['nom'])) {
    $nom = $_POST['nom'];
  }
  if(isset($_POST['prenom'])) {
    $prenom = $_POST['prenom'];
  }
  if(isset($_POST['tel'])) {
    $tel = $_POST['tel'];
  }
  if(isset($_POST['mail'])) {
    $mail = $_POST['mail'];
  }
  if(isset($_POST['login'])) {
    $login = $_POST['login'];
  }
  if(isset($_POST['pwd'])) {
    $pwd = $_POST['pwd'];
  }
  if(isset($_POST['dep'])) {
    $dep = $_POST['dep'];
  }
  if(isset($_POST['annee'])) {
    $annee = $_POST['annee'];
  }
  if(isset($_POST['tel_prof'])) {
    $tel_prof = $_POST['tel_prof'];
  }
  if(isset($_POST['fonction'])) {
    $fonction = $_POST['fonction'];
  }
  if(isset($_POST['validated'])) {
    $validated = $_POST['validated'];
  }
  if(isset($_POST['changed'])) {
    $changed = $_POST['changed'];
  }
?>

<h1>Modifier une personne</h1>
<?php
 if(!isset($id)) { //Premier appel
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
      <input type="submit" value="Valider">
    </form>
   <?php
 } else { //Deuxième ou troisième appel
 if(!isset($choix)) { // Deuxième appel
 ?>

  <h1>Choisissez le rôle</h1>
  <form class="customForm" action="#" method="post">
    <input type="radio" id="etudiant" name="choix" value="etudiant" checked="checked"> <label for="etudiant">Etudiant</label>
		<input type="radio" id="personnel" name="choix" value="personnel"> <label for="personnel">Personnel</label>
		<br />
		<input type="submit" value="Valider">
    <input type="hidden" name="idPers" value="<?php echo $id; ?>">
  </form>
  <?php
  } else { // Troisième appel
    if(!isset($validated)) {
      $pm = new PersonneManager($db);
      $em = new EtudiantManager($db);
      $sm = new SalarieManager($db);
      $estEtu = $pm->isEtudiant($id);
      if(($estEtu === 'true' && $choix === 'personnel')|| ($estEtu === 'false' && $choix === 'etudiant')) { // Le rôle (salarié/étudiant) a changé

        if($estEtu === 'true') { // la personne était un étudiant
          $em->delEtu($id); // Enleve la personne de la table étudiant
        } else { // la personne était un salarié
          $sm->delSal($id); // Enleve la personne de la table salarié
        }
        ?>
          <form class="customForm" action="#" method="post">
            <label for="nom">Nom :</label> <input type="text" name="nom" value="<?php echo $pm->getNomFromId($id); ?>" required> <br />
            <label for="prenom">Prénom :</label> <input type="text" name="prenom" value="<?php echo $pm->getPrenomFromId($id); ?>" required> <br />
            <label for="tel">Téléphone :</label> <input type="text" name="tel" value="<?php echo $pm->getTelFromId($id); ?>" required> <br />
            <label for="mail">Mail :</label> <input type="email" name="mail" value="<?php echo $pm->getMailFromId($id); ?>" required> <br />
            <label for="login">Login :</label> <input type="text" name="login" value="<?php echo $pm->getLoginFromId($id); ?>" required> <br />
            <label for="pwd">Mot de Passe :</label> <input type="password" name="pwd"> <br/>
            <?php
              if($choix === 'etudiant') { // La personne devient un(e) étudiant(e)
                $divm = new DivisionManager($db);
                $listeDiv = $divm->listerDivisions();
                $depm = new DepartementManager($db);
                $listeDep = $depm->listerDepartements();
                ?>
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
                  <?php
              } else { // la personne devient un(e) salarié(e)
                $fonm = new FonctionManager($db);
                $listeFon = $fonm->listerFonctions();
                ?>
                  <label for="tel_prof">Téléphone professionnel : </label>
                  <input type="tel" name="tel_prof" value="<?php echo $sm->getTelProfFromId($id); ?>" id="tel_prof" required>

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
                <?php
              }
            ?>
            <input type="submit" value="Modifier">
            <input type="hidden" name="idPers" value="<?php echo $id; ?>">
            <input type="hidden" name="choix" value="<?php echo $choix; ?>">
            <input type="hidden" name="changed" value="true">
            <input type="hidden" name="validated" value="ok">
          </form>
        <?php
      } else { // Le rôle (salarié/étudiant) n'a pas changé
        ?>
        <form class="customForm" action="#" method="post">
          <label for="nom">Nom :</label> <input type="text" name="nom" value="<?php echo $pm->getNomFromId($id); ?>" required> <br />
          <label for="prenom">Prénom :</label> <input type="text" name="prenom" value="<?php echo $pm->getPrenomFromId($id); ?>" required> <br />
          <label for="tel">Téléphone :</label> <input type="text" name="tel" value="<?php echo $pm->getTelFromId($id); ?>" required> <br />
          <label for="mail">Mail :</label> <input type="email" name="mail" value="<?php echo $pm->getMailFromId($id); ?>" required> <br />
          <label for="login">Login :</label> <input type="text" name="login" value="<?php echo $pm->getLoginFromId($id); ?>" required> <br />
          <label for="pwd">Mot de Passe :</label> <input type="password" name="pwd"> <br/>
          <?php
            if($estEtu === 'true') { // la personne est un(e) étudiant(e)
              $divm = new DivisionManager($db);
              $listeDiv = $divm->listerDivisions();
              $depm = new DepartementManager($db);
              $listeDep = $depm->listerDepartements();
              ?>
                <label for="annee">Année : </label>
                <select name="annee" id="annee">
                    <?php
                      foreach ($listeDiv as $value) {
                        ?>
                          <option value="<?php echo $value->getNum(); ?>" <?php
                            if($em->getDivNumFromId($id) === $value->getNum()) {
                              echo 'selected'; // selectionne par défaut sa division précédente
                            }
                           ?>><?php echo $value->getNom(); ?></option>
                        <?php
                      }
                    ?>
                </select>
                <label for="dep">Département : </label>
                <select name="dep" id="dep">
                    <?php
                      foreach ($listeDep as $value) {
                        ?>
                          <option value="<?php echo $value->getNum(); ?>" <?php
                            if($em->getDepNumFromId($id) === $value->getNum()) {
                              echo 'selected'; // selectionne par défaut son département précédent
                            }
                           ?>><?php echo $value->getNom(); ?></option>
                        <?php
                      }
                    ?>
                </select>
                <?php
            } else { // la personne est un(e) salarié(e)
              $fonm = new FonctionManager($db);
              $listeFon = $fonm->listerFonctions();
              ?>
                <label for="tel_prof">Téléphone professionnel : </label>
                <input type="tel" name="tel_prof" value="<?php echo $sm->getTelProfFromId($id); ?>" id="tel_prof">

                <label for="fonction">Fonction : </label>
                <select name="fonction" id="fonction">
                    <?php
                      foreach ($listeFon as $value) {
                        ?>
                          <option value="<?php echo $value->getNum(); ?>"
                            <?php
                              if($sm->getFonNumFromId($id) === $value->getNum()) {
                                echo 'selected'; //selectionne par défaut sa fonction précédente
                              }
                            ?>
                            ><?php echo $value->getNom(); ?></option>
                        <?php
                      }
                    ?>
                </select>
              <?php
            }
          ?>
          <input type="submit" value="Modifier">
          <input type="hidden" name="idPers" value="<?php echo $id; ?>">
          <input type="hidden" name="choix" value="<?php echo $choix; ?>">
          <input type="hidden" name="changed" value="false">
          <input type="hidden" name="validated" value="ok">
        </form>
      <?php
      }
    } else { // Quatrième appel
      $pm = new PersonneManager($db);
      $ok = $pm->updateAll($nom, $prenom, $tel, $mail, $login, $id); // on met à jour les informations
      if(!verifyPassword($pwd, $pm->getPasswordFromId($id)) || str_replace(" ","",$pwd) !== "") { // On verifie que les mots de passe sont différents OU que le mot de passe entré n'est pas vide
        $pm->updatePwd($id, encrypt($pwd));
      }

      if($choix === 'etudiant') { // On a modifié un étudiant
        $em = new EtudiantManager($db);
        if($changed==='true') { // Son rôle a changé
          $ok = $em->addEtudiant($id, $dep, $annee); // Ajoute l'étudiant dans la BD
        } else { // Son rôle n'a pas changé
          $ok = $em->updateInfos($dep, $annee, $id); // Met les infos de l'étudiant à jour
        }
      } else { // On a modifié un salarié
        $sm = new SalarieManager($db);
        if($changed==='true') { // Son rôle a changé
          $ok = $sm->addSalarie($id, $tel_prof, $fonction); // Ajoute la salarié dans la BD
        } else { // Son rôle n'a pas changé
          $ok = $sm->updateInfos($tel_prof,$fonction, $id); // Met les infos du salarié à jour
        }
      }

      if($ok) {
          ?>
              <img src="image/valid.png" alt="OK"> La personne a été modifiée ! <br /> <!--Tout s'est bien passé-->
          <?php
        } else {
          ?>
            <img src="image/erreur.png" alt="NOP"> Erreur lors de la modification <br /> <!--Il y a eu une erreur -->
          <?php
        }
    }
  }
}
?>
