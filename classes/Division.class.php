<?php
/**
* Classe représentant la table "Division" de la BD
*/
class Division{
	private $num;
  private $nom;
  public function __construct($valeur = array())
  {
    if (!empty($valeur)) {
      $this->affecte($valeur);
    }
  }
  public function affecte($donnes) {
    foreach ($donnes as $attribut => $val) {
      switch ($attribut) {
        case 'div_num':
          $this->setNum($val);
          break;
        case 'div_nom':
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
  public function getNum() {
    return $this->num;
  }
  public function getNom() {
    return $this->nom;
  }
}
?>
