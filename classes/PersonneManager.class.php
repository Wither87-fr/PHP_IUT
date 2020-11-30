<?php
	class PersonneManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		public function addPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $per_pwd) {
			$sql = "INSERT INTO personne(per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:per_nom, :per_prenom, :per_tel, :per_mail, :per_login, :per_pwd) "; //préparation de la requête
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
				return $this->db->lastInsertId();
		 	} else {
			 	return -1; //-1 = valeur d'erreur
			}
		$req->closeCursor();
		}

		public function getAllPersonns() {
			$listePers = array();
			$sql = "SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_login FROM personne";
			$req = $this->db->query($sql);
			while($personne = $req->fetch(PDO::FETCH_OBJ)) {
				$p = new Personne($personne);
				$listePers[] = $p;
		}

		$req->closeCursor();
		return $listePers;
		}


		public function getPersonneFromLogin($login) {
			//A FAIRE
		}


	}
