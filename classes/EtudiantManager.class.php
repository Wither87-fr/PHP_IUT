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

			if($effectue) {
				?>
				<img src="image/valid.png" alt="OK"> L'étudiant a été ajoutée <!--Tout s'est bien passé-->
			 	<?php
		 	} else {
			 	?>
				<img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de l'étudiant <br /> <!--Il y a eu une erreur -->
				<?php
		}
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
}
?>
