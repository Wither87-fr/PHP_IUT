<?php
	class ParcoursManager
	{

		private $db;
		public function __construct($db) {
			$this->db = $db;
		}


		/**
		* Ajoute un parcours à la BD
		* @param km : le nombre de kilomètre composant le parcours
		* @param idV1 : le numéro de la première ville
		* @param idV2 : le numéro de la deuxième ville
		* @return effectue : Si oui ou non, l'ajout s'est bien passé.
		*/
		public function addParcours($km, $idV1, $idV2) {
			$sql = "INSERT INTO parcours(par_km, vil_num1, vil_num2) VALUES (:km, :num1, :num2)"; //préparation de la requête
			$req = $this->db->prepare($sql);

			//Valorisation de la requête (les 3 lignes en dessous)
			$req->bindValue(':km', $km);
			$req->bindValue(':num1', $idV1, PDO::PARAM_INT);
			$req->bindValue(':num2', $idV2, PDO::PARAM_INT);

			$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
			return $effectue;
		 $req->closeCursor();
		}

		/**
		* Compte le nombre de parcours présents dans la BD
		* @return nb : le nombre de parcours présents dans la BD
		*/
		public function countParcours() {
			$sql = "SELECT COUNT(DISTINCT par_num) AS nb_parcours FROM propose";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC); //On n'a pas d'objets correspondant, et n'ayant qu'une ligne pour une colonne, une assoc suffit.
			$nb = $res['nb_parcours'];
			$req->closeCursor();
			return $nb;
		}

		/**
		* Liste l'intégralité des parcours de la table propose
		* @return listeParcours : la liste des parcours présents dans la table propose
		*/
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

		/**
		* Liste l'intégralité des parcours de la BD
		* @return listeParcours : la liste des parcours présents dans la BD
		*/
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

		/**
		* Récupère le numéro du parcours grâce aux deux villes qui le compose
		* @param ville1 : La ville 1
		* @param ville2 : La ville 2
		* @return par_num : Le numéro du parcours
		*/
		public function getParNumByVille1AndVille2($ville1, $ville2) {
			$sql = "SELECT par_num FROM parcours WHERE (vil_num1 = $ville1 AND vil_num2 = $ville2) OR (vil_num1 = $ville2 AND vil_num2 = $ville1)";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC); //On n'a pas d'objets correspondant, et n'ayant qu'une ligne pour une colonne, une assoc suffit.
			$par_num = $res['par_num'];
			$req->closeCursor();
			return $par_num;

		}

		/**
		* Récupère les ville faisant partie d'un parcours
		* @return listeVilleDep : la liste des villes faisant parties d'un parcours
		*/
		public function getVillesProposees() {
			$listeVilleDep = array();

			$sql = "SELECT DISTINCT v.vil_num AS 'vil_num', vil_nom FROM ville v JOIN parcours p ON p.vil_num1 = v.vil_num OR p.vil_num2 = v.vil_num GROUP BY vil_nom, vil_num";
			$req = $this->db->query($sql);

			while($ville = $req->fetch(PDO::FETCH_OBJ)) {
				$v = new Ville($ville);
				$listeVilleDep[] = $v;
			}

			$req->closeCursor();
			return $listeVilleDep;
		}

		/**
		* Récupère les ville faisant partie d'un  parcours où la ville en paramètre est présente
		* @param villeDepart : Ville dont on veut chercher les villes reliées par un parcours
		* @return listeVilleDep : la liste des villes faisant parties d'un parcours où la ville en paramètre est présente
		*/
		public function getVillesArrivee($villeDepart) {

					$listeVilleArrivee = array();

					$sql = "SELECT DISTINCT v.vil_num AS 'vil_num', vil_nom FROM ville v, parcours p WHERE (p.vil_num1 = $villeDepart AND p.vil_num2 = v.vil_num) OR (p.vil_num2 = $villeDepart AND p.vil_num1 = v.vil_num) GROUP BY vil_nom, vil_num";
					$req = $this->db->query($sql);

					while($ville = $req->fetch(PDO::FETCH_OBJ)) {
						$v = new Ville($ville);
						$listeVilleDep[] = $v;
					}

					$req->closeCursor();
					return $listeVilleDep;
		}

	}

?>
