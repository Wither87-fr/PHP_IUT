<?php
class SalarieManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

	public function addSalarie($per_num, $sal_telprof, $fon_num) {
		$sql = "INSERT INTO salarie(per_num, sal_telprof, fon_num) VALUES (:per_num, :sal_telprof, :fon_num) "; //préparation de la requête
		$req = $this->db->prepare($sql);

		//Valorisation de la requête
		$req->bindValue(':per_num', $per_num);
		$req->bindValue(':sal_telprof', $sal_telprof);
		$req->bindValue(':fon_num', $fon_num);

		$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non

		return $effectue;
	$req->closeCursor();
	}

	public function getTelProfFromId($id) {
		$sql = "SELECT sal_telprof from salarie WHERE per_num = $id";
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$telProf = $result['sal_telprof'];
		$req->closeCursor();
		return $telProf;
	}

	public function getFonNumFromId($id) {
		$sql = "SELECT fon_num from salarie WHERE per_num = $id";
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$fonNum = $result['fon_num'];
		$req->closeCursor();
		return $fonNum;
	}

	public function delSal($id) {
		$sql = "DELETE FROM salarie WHERE per_num=$id";
		$req = $this->db->prepare($sql);
		$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
		return $effectue;
	}

	public function updateInfos($tel_prof, $fon_num, $id) {
		$sql = "UPDATE salarie SET sal_telprof = :tel_prof; fon_num = :fon_num WHERE per_num = :id";
		$req = $this->db->prepare($sql);
		$req->bindValue('tel_prof', $tel_prof);
		$req->bindValue('fon_num', $fon_num);
		$req->bindValue('id', $id);
		$effectue = $req->execute(); //execution de la requete et stockage du fait que la requete a été effectuée correctement ou non
		return $effectue;
	}
}
