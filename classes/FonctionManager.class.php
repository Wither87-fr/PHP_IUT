<?php
class FonctionManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

	public function listerFonctions() {
		$listeFon = array();
		$sql = "SELECT fon_num, fon_libelle FROM fonction";
		$req = $this->db->query($sql);
		while ($fon = $req->fetch(PDO::FETCH_OBJ)) {
			$f = new Fonction($fon);
			$listeFon[] = $f;
		}
		$req->closeCursor();
		return $listeFon;
	}
}
?>
