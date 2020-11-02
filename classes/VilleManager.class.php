<?php
	class VilleManager
	{
		private $db;
		public function __construct($db) {
			$this->db = $db;
		}

		public function addVille($nomVille) {
			//En attente de debug
	    $sql = "INSERT INTO ville(vil_nom) VALUES (:nomVille)"; //la requête SQL
	    $bool = (ENV=='dev'); //Verification de l'environnement
	   // try {
	      $req = $this->db->prepare($sql); //préparation
	      $req->bindValue(':nomVille', $nomVille, PDO::PARAM_STR); //valorisation de la requête
	     // $req->execute(); //execution
			 $effectue = $req->execute();
			 if($effectue) {
				 ?>
 	        <img src="image/valid.png" alt="OK"> La ville "<b><?php echo $nomVille; ?></b>" a été ajoutée <!--Tout s'est bien passé-->
 	      <?php
			} else {
 	   // } catch(PDOException $e) {
 	      ?>
 	        <img src="image/erreur.png" alt="NOP"> Erreur lors de l'ajout de la ville. <br /> <!--Il y a eu une erreur -->
					<?php

			 }
	       // if($bool) {
	          //echo $e->getMessage(); //affichage seulement en environnement DEV.
	        //}
	   // }

	    $req->closeCursor();
		}

		public function compterVille() {
			$sql = "SELECT COUNT(vil_num) AS nb_ville FROM ville";
			$req = $this->db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC); //On n'a pas d'objets correspondant, et n'ayant qu'une ligne pour une colonne, une assoc suffit.
			$nb = $res['nb_ville'];
			$req->closeCursor();
			return $nb;
		}

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
