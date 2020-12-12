<?php
/**
* Classe représentant la table "Personne" de la BD
*/
	class Personne
	{
		private $per_num;
		private $per_nom;
		private $per_prenom;
		private $per_tel;
		private $per_mail;
		private $per_login;
		private $per_pwd;

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
						$this->setNum($value);
						break;
					case 'per_nom':
						$this->setNom($value);
						break;
					case 'per_prenom':
						$this->setPrenom($value);
						break;
					case 'per_tel':
						$this->setTel($value);
						break;
					case 'per_mail':
						$this->setMail($value);
						break;
					case 'per_login':
						$this->setLogin($value);
						break;
					case 'per_pwd':
						$this->setPwd($value);
						break;
					default:
						break;
				}
			}
		}
		public function getNum() {
			return $this->per_num;
		}
		public function getNom() {
			return $this->per_nom;
		}
		public function getPrenom() {
			return $this->per_prenom;
		}
		public function getTel() {
			return $this->per_tel;
		}
		public function getMail() {
			return $this->per_mail;
		}
		public function getLogin() {
			return $this->per_login;
		}
		public function getPwd() {
			return $this->per_pwd;
		}
		public function setNum($id) {
			$this->per_num = $id;
		}
		public function setNom($id) {
			$this->per_nom = $id;
		}
		public function setPrenom($id) {
			$this->per_prenom = $id;
		}
		public function setTel($id) {
			$this->per_tel = $id;
		}
		public function setMail($id) {
			$this->per_mail = $id;
		}
		public function setLogin($id) {
			$this->per_login = $id;
		}
		public function setPwd($id) {
			$this->per_pwd = $id;
		}
	}
?>
