<?php
/**
 *
 */
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

	public function getPropositions($par_num, $pro_date, $pro_time) {
		$listeProposition = array();
		$sql = "SELECT p.vil_num1 AS 'ville1', p.vil_num2 AS 'ville2', pr.pro_date AS 'date', pr.pro_time AS 'heure', pr.pro_place AS 'places', pe.per_nom AS 'conducteur', pr.pro_sens AS 'sens' FROM parcours p, propose pr, personne pe WHERE p.par_num = pr.par_num AND pr.per_num = pe.per_num AND pr.par_num = :par_num AND pr.pro_date = :pro_date AND pr.pro_time = :pro_time"
		$req = $this->db->prepare($sql);
		$req->bindValue('par_num', $par_num);
		$req->bindValue('pro_date', $pro_date, PDO::PARAM_STR);
		$req->bindValue(':pro_time', $pro_time, PDO::PARAM_STR);
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
		$req = $this->db->prepare($sql);



		while($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$v = new Ville($ville);
			$listeVilleDep[] = $v;
		}

		$req->closeCursor();
		return $listeVilleDep;
	}



	public function getVillesArriveeDejaProposees($villeDepart) {

		$listeVilleArrivee = array();

		$sql = "SELECT DISTINCT v.vil_num AS 'vil_num', vil_nom FROM ville v, parcours p, propose pr WHERE ((p.vil_num1 = :villeDep AND pr.pro_sens = 0 AND p.vil_num2 = v.vil_num) OR (p.vil_num2 = :villeDep AND pr.pro_sens = 1 AND p.vil_num1 = v.vil_num)) AND pr.par_num = p.par_num GROUP BY vil_nom, vil_num";
		$req = $this->db->prepare($sql);
		$req->bindValue(':villeDep', $villeDepart);



		while($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$v = new Ville($ville);
			$listeVilleDep[] = $v;
		}

		$req->closeCursor();
		return $listeVilleDep;
	}



}
