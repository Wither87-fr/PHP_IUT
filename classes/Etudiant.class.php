<?php
/**
* Classe représentant la table "Etiudiant" de la BD
*/
	class Etudiant
	{
		private $per_num;
		private $dep_num;
		private $div_num;

		public function __construct($valeur)
		{
			if(!empty($valeur)) {
				$this->affecte($valeur);
			}
		}
		public function affecte($donnee) {
			foreach ($donnee as $key => $value) {
				switch ($key) {
					case 'per_num':
						$this->setPerNum($value);
						break;
					case 'dep_num':
						$this->setDepNum($value);
						break;
					case 'div_num':
						$this->setDivNum($value);
						break;
					default:
						break;
				}
			}
		}
		public function getPerNum() {
			return $this->per_num;
		}
		public function getDepNum() {
			return $this->dep_num;
		}
		public function getDivNum() {
			return $this->div_num;
		}
		public function setPerNum($id) {
			$this->per_num = $id;
		}
		public function setDepNum($id) {
			$this->dep_num = $id;
		}
		public function setDivNum($id) {
			$this->div_num = $id;
		}
	}

?>
