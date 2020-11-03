<?php
	class EtudiantManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		public function addEtudiant($dep_num, $div_num) {
			$sql = "INSERT INTO etudiant(dep_num, div_num) VALUES (:dep_num, :div_num) "; //préparation de la requête
			$req = $this->db->prepare($sql);

			//Valorisation de la requête
			$req->bindValue(':dep_num', $dep_num);
			$req->bindValue(':div_num', $div_num);

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

		public function detailEtudiant($id) {
			$sql = "SELECT vil_nom from ville where vil_num=$id";
			$req = $this->db->query($sql); // A FINIR
		}
	}
?>
