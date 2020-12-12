<?php
/**
*	Classe représentant la table "Departement"
*/
class Departement{
	private $num;
  private $nom;
  private $vil_num;
  public function __construct($valeur = array())
  {
    if (!empty($valeur)) {
      $this->affecte($valeur);
    }
  }
  public function affecte($donnes) {
    foreach ($donnes as $attribut => $val) {
      switch ($attribut) {
        case 'dep_num':
          $this->setNum($val);
          break;
        case 'dep_nom':
          $this->setNom($val);
          break;
        case 'vil_num':
          $this->setNom($val);
          break;
        default:
          break;
      }
    }
  }
  public function setNom($nom) {
    $this->nom = $nom;
  }
  public function setNum($num) {
    $this->num = $num;
  }
  public function setVilNum($vil_num) {
    $this->vil_num = $vil_num;
  }
  public function getNum() {
    return $this->num;
  }
  public function getNom() {
    return $this->nom;
  }
  public function getVilNum() {
    return $this->vil_num;
  }
}
?>
