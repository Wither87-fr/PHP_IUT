<?php

	class PersonneManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}
		/**
		* Ajoute une personne à la BD
		* @param per_nom : le nom de la personne
		* @param per_prenom : le prénom de la personne
		* @param per_tel : le numéro de téléphone de la Personne
		* @param per_mail : l'adresse mail de la Personne
		* @param per_login : l'identifiant de connexion de la Personne
		* @param per_pwd : Le mot de passe hashé de la Personne
		* @return effectue : Si oui ou non, l'ajout s'est bien passé.
		*/
		public function addPersonne($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $per_pwd) {
			$sql = "INSERT INTO personne(per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:per_nom, :per_prenom, :per_tel, :per_mail, :per_login, :per_pwd) "; //préparation de la requête
			$req = $this->db->prepare($sql);

			$req->bindValue(':per_nom', $per_nom);
			$req->bindValue(':per_prenom', $per_prenom);
			$req->bindValue(':per_tel', $per_tel);
			$req->bindValue(':per_mail', $per_mail);
			$req->bindValue(':per_login', $per_login);
			$req->bindValue(':per_pwd', $per_pwd);

			$effectue = $req->execute();

			if($effectue) {
				return $this->db->lastInsertId();
		 	} else {
			 	return -1; //-1 = valeur d'erreur
			}
		$req->closeCursor();
		}

		/**
		* Liste l'intégralité des personnes de la BD
		* @return listePers : la liste des personnes
		*/
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

		/**
		* Récupère un objet Personne grâce à l'identifiant de connexion de la BD
		* @param login : L'identifiant de connexion de la personne
		* @return pers : L'objet Personne correspondant
		*/
		public function getPersonneFromLogin($login) {
			$sql = "SELECT  per_num, per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd from personne WHERE per_login = '$login'";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_OBJ);
			$pers = new Personne($result);
			$req->closeCursor();
			return $pers;
		}
		/**
		* Compte le nombre de personnes présente sur la BD
		* @return nb : le nombre de personnes
		*/
		public function countPersonne() {
			$sql = "SELECT COUNT(per_num) AS nb_pers FROM personne";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$nb = $res['nb_pers'];
			$req->closeCursor();
			return $nb;
		}
		/**
		* vérifie si la personne est un étudiant grâce à son ID
		* @param id : L'identifiant de la personne
		* @return isEtudiant : booléen indiquant si oui ou non la personne est un(e) étudiant(e)
		*/
		public function isEtudiant($id) {
			$sql = "SELECT IF(COUNT(per_num) > 0, 'true', 'false') FROM etudiant WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch();
			$req->closeCursor();
			return $result[0];
		}

		/**
		* Récupère le prénom de la personne grâce à son identifiant
		* @param id : L'identifiant de la persone
		* @return pre : Le prénom de la personne
		*/
		public function getPrenomFromId($id) {
			$sql = "SELECT per_prenom from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$pre = $result['per_prenom'];
			$req->closeCursor();
			return $pre;
		}

		/**
		* Récupère le nom de la personne grâce à son identifiant
		* @param id : L'identifiant de la persone
		* @return nom : Le nom de la personne
		*/
		public function getNomFromId($id) {
			$sql = "SELECT per_nom from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$nom = $result['per_nom'];
			$req->closeCursor();
			return $nom;
		}
		/**
		* Récupère le mail de la personne grâce à son identifiant
		* @param id : L'identifiant de la persone
		* @return mail : Le mail de la personne
		*/
		public function getMailFromId($id) {
			$sql = "SELECT per_mail from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$mail = $result['per_mail'];
			$req->closeCursor();
			return $mail;
		}

		/**
		* Récupère le téléphone de la personne grâce à son identifiant
		* @param id : L'identifiant de la persone
		* @return tel : Le téléphone de la personne
		*/
		public function getTelFromId($id) {
			$sql = "SELECT per_tel from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$tel = $result['per_tel'];
			$req->closeCursor();
			return $tel;
		}

		/**
		* Récupère le'identifiant de connexion de la personne grâce à son identifiant
		* @param id : L'identifiant de la persone
		* @return log : L'identifiant de connexion de la personne
		*/
		public function getLoginFromId($id) {
			$sql = "SELECT per_login from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$log = $result['per_login'];
			$req->closeCursor();
			return $log;
		}

		/**
		* Récupère le mot de passe de la personne grâce à son identifiant
		* @param id : L'identifiant de la persone
		* @return pwd : Le mot de passe de la personne
		*/
		public function getPasswordFromId($id) {
			$sql = "SELECT per_pwd from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$pwd = $result['per_pwd'];
			$req->closeCursor();
			return $pwd;
		}
		/**
		* Supprime une personne de la BD
		* @param id : l'identifiant de la personne à supprimer
		* @return effectue : Si oui ou non la délétion s'est bien passée
		*/
		public function delPers($id_personne) {
			$isEtudiant = $this->isEtudiant($id_personne);
			if($isEtudiant === 'true') {
				$em = new EtudiantManager($this->db);
				$em->delEtu($id_personne);
			} else {
				$sm = new SalarieManager($this->db);
				$sm->delSal($id_personne);
			}
			$sql = "DELETE FROM personne WHERE per_num=$id_personne";
			$req = $this->db->prepare($sql);
		  $effectue = $req->execute();
			return $effectue;
		}


		/**
		* Met à jour les infos de la personne, sauf du mot de passe
		* @param per_nom : le nom de la personne
		* @param per_prenom : le prénom de la personne
		* @param per_tel : le numéro de téléphone de la Personne
		* @param per_mail : l'adresse mail de la Personne
		* @param per_login : l'identifiant de connexion de la Personne
		* @param id : L'identifiant de la Personne
		* @return effectue : Si oui ou non, la mise à jour s'est bien passé.
		*/
		public function updateAll($per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $id) {
			$sql = "UPDATE personne SET per_nom = :per_nom, per_prenom = :per_prenom, per_tel = :per_tel, per_mail = :per_mail, per_login = :per_login WHERE per_num = :id";
			$req = $this->db->prepare($sql);

			$req->bindValue(':id', $id);
			$req->bindValue(':per_nom', $per_nom);
			$req->bindValue(':per_prenom', $per_prenom);
			$req->bindValue(':per_tel', $per_tel);
			$req->bindValue(':per_mail', $per_mail);
			$req->bindValue(':per_login', $per_login);

			$effectue = $req->execute();
			return $effectue;
		}

		/**
		* Met à jour les infos de la personne, sauf du mot de passe
		* @param per_pwd : le mot de passe hashé de la personne
		* @param id : L'identifiant de la Personne
		* @return effectue : Si oui ou non, la mise à jour s'est bien passé.
		*/
		public function updatePwd($id, $per_pwd) {
			$sql = "UPDATE personne SET per_pwd = :per_pwd WHERE per_num = :id";
			$req = $this->db->prepare($sql);

			$req->bindValue(':id', $id);
			$req->bindValue(':per_pwd', $per_pwd);

			$effectue = $req->execute();
			return $effectue;
		}

		/**
		* Récupère le dernier commentaire associé à la personne
		* @param id : L'identifiant de la Personne
		* @return com : le dernier commentaire lié à cette personne
		*/
		public function getCommentaire($id) {
			$sql = "SELECT avi_comm FROM avis WHERE per_num = $id ORDER BY avi_date DESC";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$com = $res['avi_comm'];
			$req->closeCursor();
			return $com;
		}

		/**
		* Récupère la moyenne des nottes de la personne
		* @param id : L'identifiant de la Personne
		* @return note : La note moyenne de la personne
		*/
		public function getAvgNote($id) {
			$sql = "SELECT AVG(avi_note) AS 'note_moyenne' FROM avis WHERE per_num = 1 GROUP BY per_num";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$note = $res['note_moyenne'];
			$req->closeCursor();
			return $note;
		}

	}
