<?php
class ProposeManager
{
	private $db;
	public function __construct($db)
	{
		$this->db = $db;
	}

	/**
	* Propose un nouveau co-voiturage
	* @param par_num : le numéro du parcours effectué
	* @param per_num : le numéro du conducteur
	* @param date : la date à laquelle le co-voiturage aura lieu
	* @param heure : l'heure à laquelle le co-voiturage aura lieu
	* @param places : le nombre de place disponible pour ce co-voiturage
	* @param sens : direction du trajet (0 / 1)
	* @return effectue : Si oui ou non, l'ajout s'est bien passé.
	*/
	public function propose($par_num, $per_num, $date, $heure, $places, $sens) {
		$sql = "INSERT INTO propose(par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:par_num, :per_num, :dateProp, :heure, :places, :sens)";
		$req = $this->db->prepare($sql);
		$req->bindValue(':par_num', $par_num);
		$req->bindValue(':per_num', $per_num);
		$req->bindValue(':dateProp', $date, PDO::PARAM_STR);
		$req->bindValue(':heure', $heure, PDO::PARAM_STR);
		$req->bindValue(':places', $places);
		$req->bindValue(':sens', $sens); // 0 = ville1 -> ville2 , 1 = ville2 -> ville1

		$effectue = $req->execute();
		$req->closeCursor();
		return $effectue;
	}

	/**
	* Liste les propositions d'un certain parcours entre deux dates et à partir d'une certaine heure
	* @param par_num : le numéro du parcours effecté
	* @param date_min : la date minimun à laquelle le trajet doit avoir lieu
	* @param heure_min : l'heure minimum à laquelle le trajet doit avoir lieu
	* @param date_max : la date maximum à laquelle le trajet doit avoir lieu
	* @return listePropositions : la liste des propositions
	*/
	public function getPropositions($par_num, $date_min, $heure_min, $date_max) {
		$listeProposition = array();
		$sql = "SELECT p.vil_num1 AS 'ville1', p.vil_num2 AS 'ville2', pr.pro_date AS 'date', pr.pro_time AS 'heure', pr.pro_place AS 'places', pe.per_num AS 'conducteur', pr.pro_sens AS 'sens' FROM parcours p, propose pr, personne pe WHERE p.par_num = pr.par_num AND pr.per_num = pe.per_num AND pr.par_num = :par_num AND (pr.pro_date BETWEEN :date_min AND :date_max) AND pr.pro_time >= :pro_time ORDER BY pr.pro_date, pr.pro_time";
		$req = $this->db->prepare($sql);
		$req->bindValue(':par_num', $par_num);
		$req->bindValue(':date_min', $date_min, PDO::PARAM_STR);
		$req->bindValue(':date_max', $date_max, PDO::PARAM_STR);
		$req->bindValue(':pro_time', $heure_min, PDO::PARAM_STR);
		$req->execute();
		while($proposeAfficheur = $req->fetch(PDO::FETCH_OBJ)) {
			$pa = new ProposeAfficheur($proposeAfficheur);
			$listeProposition[] = $pa;
	}
		$req->closeCursor();
		return $listeProposition;
	}

	/**
	* Liste les villes desquelles part un trajet proposé
	* @return listeVilleDep : La liste des cilles d'où partent un trajet proposé
	*/
	public function getVillesDepartDejaProposees() {

		$listeVilleDep = array();

		$sql = "SELECT DISTINCT v.vil_num AS 'vil_num', vil_nom FROM ville v JOIN parcours p ON p.vil_num1 = v.vil_num OR p.vil_num2 = v.vil_num JOIN propose pr ON pr.par_num = p.par_num GROUP BY vil_nom, vil_num";
		$req = $this->db->query($sql);
		while($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$v = new Ville($ville);
			$listeVilleDep[] = $v;
		}

		$req->closeCursor();
		return $listeVilleDep;
	}


	/**
	* Liste les villes dans lesquelles un trajet proposé arrive, en partant d'une certaine ville de départ
	* @param villeDepart : la ville de laquelle doit partir le trajet
	* @return listeVilleDep : La liste des cilles d'où partent un trajet proposé
	*/
	public function getVillesArriveeDejaProposees($villeDepart) {

		$listeVilleArrivee = array();

		$sql = "SELECT DISTINCT v.vil_num AS 'vil_num', vil_nom FROM ville v, parcours p, propose pr WHERE ((p.vil_num1 = $villeDepart AND pr.pro_sens = 0 AND p.vil_num2 = v.vil_num) OR (p.vil_num2 = $villeDepart AND pr.pro_sens = 1 AND p.vil_num1 = v.vil_num)) AND pr.par_num = p.par_num GROUP BY vil_nom, vil_num";
		$req = $this->db->query($sql);


		while($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$v = new Ville($ville);
			$listeVilleArrivee[] = $v;
		}

		$req->closeCursor();
		return $listeVilleArrivee;
	}


	/**
	* Récupère le sens du trajet à partir du parcours concerné et de la ville de départ
	* @param par_num : numéro du parcours concerné
	* @param vil_dep : ville de départ du trajet
	* @return sens : le sens du trajet, 0 ou 1
	*/
	public function getSens($par_num, $vil_dep) {
		$sql = "SELECT IF($vil_dep = p.vil_num1, '0', '1') FROM parcours p WHERE par_num = $par_num"; // 0 = ville1 -> ville2 , 1 = ville2 -> ville1
		$req = $this->db->query($sql);
		$sens = $req->fetch();
		$req->closeCursor();
		return $sens[0];
	}

}
