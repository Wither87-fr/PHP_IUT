<?php
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
<!-- 1 : Choisir une personne -->
<?php
 if(!isset($id)) {
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
 } else {
   ?>
<!-- 2 : Changer ou non le role (salarié/etudiant) -->
<?php
 if(!isset($choix)) {
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
} else {
?>
<!-- 3 : Modifier la personne -->
<?php
  if(!isset($validated)) {
    $pm = new PersonneManager($db);
    $em = new EtudiantManager($db);
    $sm = new SalarieManager($db);
    $estEtu = $pm->isEtudiant($id);
    if(($estEtu === 'true' && $choix === 'personnel')|| ($estEtu === 'false' && $choix === 'etudiant')) {
      //Changement
      //1. Suppr Etudiant ou salarie
      if($estEtu === 'true') {
        $em->delEtu($id);
      } else {
        $sm->delSal($id);
      }
      //2. rentrer infos
      ?>
        <form class="customForm" action="#" method="post">
          <label for="nom">Nom :</label> <input type="text" name="nom" value="<?php echo $pm->getNomFromId($id); ?>" required> <br />
          <label for="prenom">Prénom :</label> <input type="text" name="prenom" value="<?php echo $pm->getPrenomFromId($id); ?>" required> <br />
          <label for="tel">Téléphone :</label> <input type="text" name="tel" value="<?php echo $pm->getTelFromId($id); ?>" required> <br />
          <label for="mail">Mail :</label> <input type="email" name="mail" value="<?php echo $pm->getMailFromId($id); ?>" required> <br />
          <label for="login">Login :</label> <input type="text" name="login" value="<?php echo $pm->getLoginFromId($id); ?>" required> <br />
          <label for="pwd">Mot de Passe :</label> <input type="password" name="pwd"> <br/>
          <?php
            if($choix === 'etudiant') {
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
            } else {
              if($choix==="personnel") {
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
            }
          ?>
          <input type="submit" value="Modifier">
          <input type="hidden" name="idPers" value="<?php echo $id; ?>">
          <input type="hidden" name="choix" value="<?php echo $choix; ?>">
          <input type="hidden" name="changed" value="true">
          <input type="hidden" name="validated" value="ok">
        </form>
      <?php
    } else {
      ?>
      <form class="customForm" action="#" method="post">
        <label for="nom">Nom :</label> <input type="text" name="nom" value="<?php echo $pm->getNomFromId($id); ?>" required> <br />
        <label for="prenom">Prénom :</label> <input type="text" name="prenom" value="<?php echo $pm->getPrenomFromId($id); ?>" required> <br />
        <label for="tel">Téléphone :</label> <input type="text" name="tel" value="<?php echo $pm->getTelFromId($id); ?>" required> <br />
        <label for="mail">Mail :</label> <input type="email" name="mail" value="<?php echo $pm->getMailFromId($id); ?>" required> <br />
        <label for="login">Login :</label> <input type="text" name="login" value="<?php echo $pm->getLoginFromId($id); ?>" required> <br />
        <label for="pwd">Mot de Passe :</label> <input type="password" name="pwd"> <br/>
        <?php
          if($estEtu === 'true') {
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
                            echo 'selected';
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
                            echo 'selected';
                          }
                         ?>><?php echo $value->getNom(); ?></option>
                      <?php
                    }
                  ?>
              </select>
              <?php
          } else {
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
                              echo 'selected';
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
  } else {
    $pm = new PersonneManager($db);
    $fait = $pm->updateAll($nom, $prenom, $tel, $mail, $login, $id);
    if(!verifyPassword($pwd, $pm->getPasswordFromId($id)) || str_replace(" ","",$pwd) !== "") {
      $pm->updatePwd($id, encrypt($pwd));
    }
    if($choix === 'etudiant') {
      $em = new EtudiantManager($db);
      if($changed==='true') {
        $fait = $em->addEtudiant($id, $dep, $annee);
      } else {
        $fait = $em->updateInfos($dep, $annee, $id);
      }

    } else {
      $sm = new SalarieManager($db);
      if($changed==='true') {
        $fait = $sm->addSalarie($id, $tel_prof, $fonction);
      } else {
        $fait = $sm->updateInfos($tel_prof,$fonction, $id);
      }
    }

    if($fait) {
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
