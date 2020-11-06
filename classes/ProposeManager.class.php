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

	public function getPropositions($propose) {
		$sql = "SELECT p.vil_num1, p.vil_num2, pr.pro_date, pr.pro_time, pr.pro_place, pe.per_nom FROM parcours p, propose pr, personne pe WHERE p.par_num = pr.par_num AND pr.per_num = pe.per_num AND pr.par_num = :par_num AND pr.pro_date = :pro_date AND pr.pro_time = :pro_time"
		//propose a revoir pour tout stocker
	}
}
