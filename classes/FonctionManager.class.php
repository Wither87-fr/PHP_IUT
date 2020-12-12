<?php
class FonctionManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

	/**
	* Liste l'intégralité des fonctions de la BD
	* @return listeFon : la liste des fonctions présentes dans la BD
	*/
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

	/**
	* Récupère le libellé de la fonction à partir du numéro
	* @param fonNum : Le numéro de la fonction
	* @return listeDep : Le libellé de la fonction
	*/
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
