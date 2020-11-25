<?php
  //include_once 'include/ejectNotConnected.inc.php';
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
?>


<?php
$pm = new PersonneManager($db);
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
			<label for="Mot de Passe">Mot de Passe : </label> <input type="text" name="per_pwd" id="Mot de Passe">
			<br />
			<label for="Catégorie">Catégorie : </label>
			<input type="radio" id="etudiant" name="choix" value="etudiant" checked="checked"> <label for="etudiant">Etudiant</label>
			<input type="radio" id="personnel" name="choix" value="personnel"> <label for="personnel">Personnel</label>
			<br />
			<input type="submit" value="Valider">
		</form>
		<?php
	} else {
    $num_pers = $pm->addPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $per_pwd);
    switch ($choix) {
      case 'etudiant':
      ?>
      <h1>Ajouter un étudiant</h1>
      <?php
        $em = new EtudiantManager($db);
        $divm = new DivisionManager($db);
        $listeDiv = $divm->listerDivisions();
        $depm = new DepartementManager($db);
        $listeDep = $depm->listerDepartements();
        ?>
        <form class="customForm" action="#" method="post">
          <label for="annee">Année : </label>
          <select name="div" id="div">
              <?php
                foreach ($listeDiv as $value) {
                  ?>
                    <option value="<?php echo $value->getNum(); ?>"><?php echo $value->getNom(); ?></option>
                  <?php
                }
              ?>
          </select>
          <label for="departement">Département : </label>
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
        //A FINIR AJOUT + FAIRE LES VERIFS D'APPELS
        <?php
        break;
      case 'personnel':
        // code...
        break;
      default:
        // code...
        break;
    }
	}
?>
