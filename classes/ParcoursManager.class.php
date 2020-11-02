<?php
	/**
	 *
	 */
	class ParcoursManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}



		public function addParcours($km, $idV1, $idV2) {
			$sql = "INSERT INTO parcours(par_km, vil_num1, vil_num2) VALUES (:km, :num1, :num2)"; //préparation de la requête
			$req = $this->db->prepare($sql);

			//Valorisation de la requête (les 3 lignes en dessous)
			$req->bindValue(':km', $km);
			$req->bindValue(':num1', $idV1, PDO::PARAM_INT);
			$req->bindValue(':num2', $idV2, PDO::PARAM_INT);

			$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
			if($effectue) {
				?>
				 <img src="image/valid.png" alt="OK"> Le parcours a été ajoutée <!--Tout s'est bien passé-->
			 <?php
		 } else {
			 ?>
				 <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout du parcours. <br /> <!--Il y a eu une erreur -->
				 <?php

			}
		 $req->closeCursor();
		}

		public function countParcours() {
			$sql = "SELECT COUNT(DISTINCT par_num) AS nb_parcours FROM propose";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC); //On n'a pas d'objets correspondant, et n'ayant qu'une ligne pour une colonne, une assoc suffit.
			$nb = $res['nb_parcours'];
			$req->closeCursor();
			return $nb;
		}

		public function listerParcoursProposés() { //Liste les parcours présent dans la table propose
			$listeParcours = array();
			$sql = "SELECT DISTINCT pa.par_num, pa.par_km, pa.vil_num1, pa.vil_num2 FROM parcours pa, propose p WHERE p.par_num = pa.par_num";
			$req = $this->db->query($sql);
			while($parcours = $req->fetch(PDO::FETCH_OBJ)) {
				$p = new Parcours($parcours);
				$listeParcours[] = $p;
			}

			return $listeParcours;
		}


		public function listerParcours() { //liste la totalité des parcours
			$listeParcours = array();
			$sql = "SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours";
			$req = $this->db->query($sql);
			while($parcours=$req->fetch(PDO::FETCH_OBJ)) {
				$p = new Parcours($parcours);
				$listeParcours[]=$p;
			}
			return $listeParcours;
		}

	}

?>
