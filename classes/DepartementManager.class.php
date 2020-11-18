<?php //A COMPLETER
class DepartementManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

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
}
?>
