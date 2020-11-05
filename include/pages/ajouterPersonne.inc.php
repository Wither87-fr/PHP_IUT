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
?>

<h1>Ajouter une personne</h1>
<?php
	if (!isset($per_nom) || !isset($per_prenom) || !isset($per_tel) || !isset($per_mail) || !isset($per_login) || !isset($per_pwd)) {
		$pm = new PersonneManager($db);
		?>
		<form class="customForm" action="#" method="post">
			<label for="Nom">Nom : </label> <input type="text" name="nom" id="per_nom">
			<label for="Prenom">Prenom : </label> <input type="text" name="prenom" id="per_prenom">
			<br />
			<label for="Téléphone">Téléphone : </label> <input type="text" name="tel" id="pre_tel">
			<label for="Mail">Mail : </label> <input type="email" name="mail" id="pre_mail">
			<br />
			<label for="Login">Login : </label> <input type="text" name="login" id="pre_login">
			<label for="Mot de Passe">Mot de Passe : </label> <input type="text" name="pwd" id="pre_pwd">
			<br />
			<label for="Catégorie">Catégorie : </label>
			<input type="radio" id="etudiant" name="choix" value="etudiant" checked="checked"> <label for="etudiant">Etudiant</label>
			<input type="radio" id="personnel" name="choix" value="personnel"> <label for="personnel">Personnel</label>
			<br />
			<input type="submit" value="Valider">
		</form>
		<?php
	} else {
		
	}
?>
