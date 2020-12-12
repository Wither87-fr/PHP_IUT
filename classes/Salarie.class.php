<?php
/**
* Classe représentant la table "Salarie" de la BD
*/
	class Salarie
	{

		private $per_num;
		private $sal_telprof;
		private $fon_num;

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
					case 'sale_telprof':
						$this->setSalTelprof($value);
						break;
					case 'fon_num':
						$this->setDivNum($value);
						break;
					default:
						break;
				}
			}
		} //$this->db->lastInsertId();
		public function getPerNum() {
			return $this->per_num;
		}
		public function getSalTelprof() {
			return $this->sal_telprof;
		}
		public function getFonNum() {
			return $this->fon_num;
		}
		public function setPerNum($id) {
			$this->per_num = $id;
		}
		public function setSalTelprof($tel) {
			$this->sale_telprof = $tel;
		}
		public function setFonNum($id) {
			$this->fon_num = $id;
		}
	}

?>
