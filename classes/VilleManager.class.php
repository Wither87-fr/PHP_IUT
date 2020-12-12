<?php
	class VilleManager
	{
		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		/**
		* Ajoute une ville à la BD
		* @param nomVille : le nom de la ville que l'on veut ajouter
		* @return effectue : Si oui ou non, l'ajout s'est bien passé.
		*/
		public function addVille($nomVille) {
	    $sql = "INSERT INTO ville(vil_nom) VALUES (:nomVille)"; //la requête SQL
	    $bool = (ENV=='dev'); //Verification de l'environnement
	    $req = $this->db->prepare($sql); //préparation
	    $req->bindValue(':nomVille', $nomVille, PDO::PARAM_STR); //valorisation de la requête
			$effectue = $req->execute();
			return $effectue;
	    $req->closeCursor();
		}

		/**
		* Compte le nombre de villes présentes dans la BD
		* @return nb : le nombre de villes présentes dans la BD
		*/
		public function compterVille() {
			$sql = "SELECT COUNT(vil_num) AS nb_ville FROM ville";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC); //On n'a pas d'objets correspondant, et n'ayant qu'une ligne pour une colonne, une assoc suffit.
			$nb = $res['nb_ville'];
			$req->closeCursor();
			return $nb;
		}

		/**
		* Liste l'intégralité des villes présentes dans la BD
		* @return listeVilles : la liste des villes présentes dans la BD
		*/
		public function listerVilles() {
			$listeVille = array();
			$sql = "SELECT vil_num, vil_nom FROM ville ORDER BY vil_nom ASC";
			$req = $this->db->query($sql);
			while($ville = $req->fetch(PDO::FETCH_OBJ)) {
				$v = new Ville($ville);
				$listeVille[] = $v;
		}

		$req->closeCursor();
		return $listeVille;
	}

	/**
	* Récupère le nom de la ville grâce à son identifiant
	* @param id : L'identifiant de la ville
	* @return nm : Le nom de la ville
	*/
	public function getVilleFromId($id) {
		$sql = "SELECT vil_nom from ville where vil_num=$id";
		$req = $this->db->query($sql);
		$res = $req->fetch(PDO::FETCH_ASSOC); //On n'a pas d'objets correspondant, et n'ayant qu'une ligne pour une colonne, une assoc suffit.
		$nom = $res['vil_nom'];
		$req->closeCursor();
		return $nom;
	}
}
?>
