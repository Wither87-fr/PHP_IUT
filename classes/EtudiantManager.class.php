<?php
	class EtudiantManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

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

		public function getDepNumFromId($id) {
				$sql = "SELECT dep_num from etudiant WHERE per_num = $id";
				$req = $this->db->query($sql);
				$result = $req->fetch(PDO::FETCH_ASSOC);
				$dep = $result['dep_num'];
				$req->closeCursor();
				return $dep;
			}

			public function getDivNumFromId($id) {
					$sql = "SELECT div_num from etudiant WHERE per_num = $id";
					$req = $this->db->query($sql);
					$result = $req->fetch(PDO::FETCH_ASSOC);
					$div = $result['dep_num'];
					$req->closeCursor();
					return $div;
				}

		public function delEtu($id) {
			$sql = "DELETE FROM etudiant WHERE per_num=$id";
			$req = $this->db->prepare($sql);
			$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
			return $effectue;
		}


	public function updateInfos($dep_num, $div_num, $id) {
		$sql = "UPDATE etudiant SET dep_num = :dep_num, div_num = :div_num WHERE per_num = :id";
		$req = $this->db->prepare($sql);
		$req->bindValue('dep_num', $dep_num);
		$req->bindValue('dep_num', $div_num);
		$req->bindValue('id', $id);
		$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
		return $effectue;
	}
}
?>
