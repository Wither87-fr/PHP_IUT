<?php
class ProposeManager
{
	private $db;
	public function __construct($db)
	{
		$this->db = $db;
	}

	public function propose($par_num, $per_num, $date, $heure, $places, $sens) {
		$sql = "INSERT INTO propose(par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES (:par_num, :per_num, :dateProp, :heure, :places, :sens)";
		$req = $this->db->prepare($sql);
		$req->bindValue(':par_num', $par_num);
		$req->bindValue(':per_num', $per_num);
		$req->bindValue(':dateProp', $date, PDO::PARAM_STR);
		$req->bindValue(':heure', $heure, PDO::PARAM_STR);
		$req->bindValue(':places', $places);
		$req->bindValue(':sens', $sens);

		$effectue = $req->execute();
		$req->closeCursor();
		return $effectue;
	}

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



	public function getSens($par_num, $vil_dep) {
		$sql = "SELECT IF($vil_dep = p.vil_num1, '0', '1') FROM parcours p WHERE par_num = $par_num";
		$req = $this->db->query($sql);
		$sens = $req->fetch();
		$req->closeCursor();
		return $sens[0];
	}

}
