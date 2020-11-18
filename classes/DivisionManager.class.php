<?php //A COMPLETER
class DivisionManager{
	private $db;
	public function __construct($db) {
		$this->db = $db;
	}

	public function listerDivisions() {
		$listeDiv = array();
		$sql = "SELECT div_num, div_nom FROM division";
		$req = $this->db->query($sql);
		while ($div = $req->fetch(PDO::FETCH_OBJ)) {
			$d = new Division($div);
			$listeDiv[] = $d;
		}
		$req->closeCursor();
		return $listeDiv;
	}
}
?>
