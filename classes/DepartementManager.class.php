<?php
class DepartementManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

	/**
	* Liste l'intégralité des départements de la BD
	* @return listeDep : la liste des départements présents dans la BD
	*/
	public function listerDepartements() {
		$listeDep = array();
		$sql = "SELECT dep_num, dep_nom FROM departement";
		$req = $this->db->query($sql);
		while ($dep = $req->fetch(PDO::FETCH_OBJ)) {
			$d = new Departement($dep);
			$listeDep[] = $d;
		}
		$req->closeCursor();
		return $listeDep;
	}

	/**
	* Récupère le nom à partir du numéro
	* @param depNum : Le numéro du département
	* @return depNum : Le nom du département
	*/
	public function getNomFromNum($depNum) {
		$sql = "SELECT dep_nom from departement WHERE dep_num = $depNum";
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$depNom = $result['dep_nom'];
		$req->closeCursor();
		return $depNom;
	}

	/**
	* Récupère le numéro de la ville où se trouve le département grâce à son identifiant
	* @param depNum : L'identifiant du département
	* @return vilNum : Le uméro de la ville où se trouve le département
	*/
	public function getVilleNumFromId($depNum) {
		$sql = "SELECT vil_num from departement WHERE dep_num = $depNum";
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$vilNum = $result['vil_num'];
		$req->closeCursor();
		return $vilNum;
	}
}
?>
