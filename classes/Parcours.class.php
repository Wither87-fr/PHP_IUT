<?php
	class Parcours
	{
		private $id;
		private $distance;
		private $villeID1;
		private $villeID2;
		public function __construct($valeurs)
		{
			if(!empty($valeurs)) {
				$this->affecte($valeurs);
			}
		}

		public function affecte($donees) {
			foreach ($donees as $key => $value) {
				switch ($key) {
					case 'par_num':
						$this->setId($value);
						break;
					case 'par_km':
						$this->setDistance($value);
						break;
					case 'vil_num1' :
						$this->setVilleID1($value);
						break;
					case 'vil_num2':
						$this->setVilleID2($value);
						break;
					default:
						break;
				}
			}
		}

		public function getId() {
			return $this->id;
		}

		public function getDistance() {
			return $this->distance;
		}

		public function getVilleID1() {
			return $this->villeID1;
		}

		public function getVilleID2() {
			return $this->villeID2;
		}

		public function setId($id) {
			$this->id = $id;
		}

		public function setDistance($distance) {
			$this->distance = $distance;
		}

		public function setVilleID1($id) {
			$this->villeID1 = $id;
		}

		public function setVilleID2($id) {
			$this->villeID2 = $id;
		}

	}

?>
