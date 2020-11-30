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

	public function getLibelleFromNum($fonNum) {
		$sql = "SELECT fon_libelle from fonction WHERE fon_num = $fonNum";
		$req = $this->db->query($sql);
		$result = $req->fetch(PDO::FETCH_ASSOC);
		$fonLibelle = $result['fon_libelle'];
		$req->closeCursor();
		return $fonLibelle;
	}

}
?>
