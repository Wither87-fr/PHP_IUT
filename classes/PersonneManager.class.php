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
			$sql = "SELECT  per_num, per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd from personne WHERE per_login = '$login'";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_OBJ);
			$pers = new Personne($result);
			$req->closeCursor();
			return $pers;
		}

		public function countPersonne() {
			$sql = "SELECT COUNT(per_num) AS nb_pers FROM personne";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$nb = $res['nb_pers'];
			$req->closeCursor();
			return $nb;
		}

		public function isEtudiant($id) {
			$sql = "SELECT IF(COUNT(per_num) > 0, 'true', 'false') FROM etudiant WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch();
			$req->closeCursor();
			return $result[0];
		}

		public function getPrenomFromId($id) {
			$sql = "SELECT per_prenom from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$pre = $result['per_prenom'];
			$req->closeCursor();
			return $pre;
		}

		public function getNomFromId($id) {
			$sql = "SELECT per_nom from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$nom = $result['per_nom'];
			$req->closeCursor();
			return $nom;
		}

		public function getMailFromId($id) {
			$sql = "SELECT per_mail from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$mail = $result['per_mail'];
			$req->closeCursor();
			return $mail;
		}

		public function getTelFromId($id) {
			$sql = "SELECT per_tel from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$tel = $result['per_tel'];
			$req->closeCursor();
			return $tel;
		}

		public function getLoginFromId($id) {
			$sql = "SELECT per_login from personne WHERE per_num = $id";
			$req = $this->db->query($sql);
			$result = $req->fetch(PDO::FETCH_ASSOC);
			$log = $result['per_login'];
			$req->closeCursor();
			return $log;
		}

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
		  $effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
			return $effectue;
		}


	}
