<?php
  //include_once 'include/ejectNotConnected.inc.php';
  if(isset($_POST['per_nom'])) {
    $per_nom = $_POST['per_nom'];
    $_SESSION['per_nom'] = $_POST['per_nom'];
  }
	if(isset($_POST['per_prenom'])) {
    $per_prenom = $_POST['per_prenom'];
    $_SESSION['per_prenom'] = $_POST['per_prenom'];
  }
	if(isset($_POST['per_tel'])) {
    $per_tel = $_POST['per_tel'];
    $_SESSION['per_tel'] = $_POST['per_tel'];
  }
	if(isset($_POST['per_mail'])) {
    $per_mail = $_POST['per_mail'];
    $_SESSION['per_mail'] = $_POST['per_mail'];
  }
	if(isset($_POST['per_login'])) {
    $per_login = $_POST['per_login'];
    $_SESSION['per_login'] = $_POST['per_login'];
  }
	if(isset($_POST['per_pwd'])) {
    $per_pwd = $_POST['per_pwd'];
    $_SESSION['per_pwd'] = $_POST['per_pwd'];
  }
  if(isset($_POST['choix'])) {
    $choix = $_POST['choix'];
    $_SESSION['choix'] = $_POST['choix'];
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

  if(isset($_SESSION['per_nom'])) {
    $per_nom = $_SESSION['per_nom'];
  }
  if(isset($_SESSION['per_prenom'])) {
    $per_prenom = $_SESSION['per_prenom'];
  }
  if(isset($_SESSION['per_tel'])) {
    $per_tel = $_SESSION['per_tel'];
  }
  if(isset($_SESSION['per_mail'])) {
    $per_mail = $_SESSION['per_mail'];
  }
  if(isset($_SESSION['per_login'])) {
    $per_login = $_SESSION['per_login'];
  }
  if(isset($_SESSION['per_pwd'])) {
    $per_pwd = $_SESSION['per_pwd'];
  }
  if(isset($_SESSION['choix'])) {
    $choix = $_SESSION['choix'];
  }
?>


<?php
	if (!isset($per_nom) || !isset($per_prenom) || !isset($per_tel) || !isset($per_mail) || !isset($per_login) || !isset($per_pwd) || !isset($choix)) {
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
	} else {
    $pm = new PersonneManager($db);

    if(!personneExiste($pm->getAllPersonns(), $per_login)) {
      $pwd = encrypt($per_pwd);
      $num_pers = $pm->addPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $pwd);
      switch ($choix) {
        case 'etudiant':

        if(!isset($dep) || !isset($annee) || !isset($num_pers)) {
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
            </form>
          <?php
        } else {
          $em = new EtudiantManager($db);
          /*$ok =*/$em->addEtudiant($num_pers, $dep, $annee);
          /*
          if($ok) {
          ?>
              <img src="image/valid.png" alt="OK"> L'étudiant a été ajoutée <!--Tout s'est bien passé-->
          <?php
          } else {
          ?>
            <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de l'étudiant <br /> <!--Il y a eu une erreur -->
          <?php
          }
          */
        }
          break;
        case 'personnel':

          if (!isset($fonction) || !isset($tel_prof) || !isset($num_pers)) {
            ?>
            <h1>Ajouter un salarié</h1>
            <?php
              $fonm = new FonctionManager($db);
              $listeFon = $fonm->listerFonctions();
              ?>
              <form class="customForm" action="#" method="post">
                <label for="tel_prof">Téléphone professionnel : </label>
                <input type="tel" name="tel_prof" placeholder="06 66 66 66 66">

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
              </form>
              <?php
          } else {
            $sm = new SalarieManager($db);
            /*$ok =*/$sm->addSalarie($num_pers, $tel_prof, $fonction);
            /*
            if($ok) {
            ?>
                <img src="image/valid.png" alt="OK"> Le salarié a été ajoutée <!--Tout s'est bien passé-->
            <?php
            } else {
            ?>
              <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout du salarié <br /> <!--Il y a eu une erreur -->
            <?php
            }
            */
          }
          break;
        default:
          break;
        }
    } else {
    ?>
      <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de la personne, login existant déjà <br /> <!--Il y a eu une erreur -->
    <?php
    }



      //A la fin, on enleve les variables de session innutiles :
      $nom = $_SESSION['username'];
      session_destroy();
      session_start();
      $_SESSION['connecte'] = "true";
      $_SESSION['username'] = $nom;
	}
?>
