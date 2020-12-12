<?php
	class EtudiantManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}
		/**
		* Ajoute un étudiant à la BD
		* @param per_num : le numéro de la personne
		* @param dep_num : le numéro de son département
		* @param div_num : le numéro de sa division
		* @return effectue : Si oui ou non, l'ajout s'est bien passé.
		*/
		public function addEtudiant($per_num,$dep_num, $div_num) {
			$sql = "INSERT INTO etudiant(per_num, dep_num, div_num) VALUES (:per_num, :dep_num, :div_num) "; //préparation de la requête
			$req = $this->db->prepare($sql);

			//Valorisation de la requête
			$req->bindValue(':per_num', $per_num);
			$req->bindValue(':dep_num', $dep_num);
			$req->bindValue(':div_num', $div_num);

			$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non

			return $effectue;
		$req->closeCursor();
		}

		/**
		* Récupère le numéro du département de l'étudiant grâce à son identifiant
		* @param id : L'identifiant de l'étudiant
		* @return dep : Le numéro de la division de l'étudiant
		*/
		public function getDepNumFromId($id) {
				$sql = "SELECT dep_num from etudiant WHERE per_num = $id";
				$req = $this->db->query($sql);
				$result = $req->fetch(PDO::FETCH_ASSOC);
				$dep = $result['dep_num'];
				$req->closeCursor();
				return $dep;
			}

			/**
			* Récupère le numéro de la division de l'étudiant grâce à son identifiant
			* @param id : L'identifiant de l'étudiant
			* @return div : Le numéro de la division de l'étudiant
			*/
			public function getDivNumFromId($id) {
					$sql = "SELECT div_num from etudiant WHERE per_num = $id";
					$req = $this->db->query($sql);
					$result = $req->fetch(PDO::FETCH_ASSOC);
					$div = $result['dep_num'];
					$req->closeCursor();
					return $div;
				}

		/**
		* Supprime un étudiant de la BD
		* @param id : l'identifiant de l'étudiant à supprimer
		* @return effectue : Si oui ou non la délétion s'est bien passée
		*/
		public function delEtu($id) {
			$sql = "DELETE FROM etudiant WHERE per_num=$id";
			$req = $this->db->prepare($sql);
			$effectue = $req->execute();
			return $effectue;
		}

		/**
		* Met à jour les infos de l'étudiant
		* @param dep_num : le numéro de son département
		* @param div_num : le numéro de sa division
		* @param id : l'identifiant de l'étudiant
		* @return effectue : Si oui ou non, la mise à jour s'est bien passé.
		*/
	public function updateInfos($dep_num, $div_num, $id) {
		$sql = "UPDATE etudiant SET dep_num = :dep_num, div_num = :div_num WHERE per_num = :id";
		$req = $this->db->prepare($sql);
		$req->bindValue('dep_num', $dep_num);
		$req->bindValue('dep_num', $div_num);
		$req->bindValue('id', $id);
		$effectue = $req->execute();
		return $effectue;
	}
}
?>
