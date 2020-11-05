<?php
	class PersonneManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		public function addPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $per_pwd) {
			$sql = "INSERT INTO etudiant(per_nom, per_prenom, per_tel, pre_mail, per_login, per_pwd) VALUES (:per_nom, :per_prenom, :per_tel, :pre_mail, :per_login, :per_pwd) "; //préparation de la requête
			$req = $this->db->prepare($sql);

			//Valorisation de la requête
			$req->bindValue(':per_nom', $per_nom);
			$req->bindValue(':per_prenom', $per_prenom);
			$req->bindValue(':per_tel', $per_tel);
			$req->bindValue(':per_mail', $per_mail);
			$req->bindValue(':per_login', $per_login);
			$req->bindValue(':per_pwd', $per_pwd);

			$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non

			if($effectue) {
				?>
				<img src="image/valid.png" alt="OK"> L'étudiant a été ajoutée <!--Tout s'est bien passé-->
			 	<?php
		 	} else {
			 	?>
				<img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de l'étudiant. <br /> <!--Il y a eu une erreur -->
				<?php
		}
		$req->closeCursor();
		}



	}
