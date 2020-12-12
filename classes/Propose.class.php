<?php
/**
* Classe représentant la table "Propose" de la BD
*/
  class Propose
  {
    private $parcoursNum;
    private $personneNum;
    private $date;
    private $heure;
    private $places;
    private $sens;

    public function __construct($valeurs)
    {
      if(!empty($valeurs)) {
        $this->affecte($valeurs);
      }
    }




    public function affecte($donnees) {
      foreach ($donees as $key => $value) {
        switch ($key) {
          case 'par_num':
            $this->setParcoursNum($value);
            break;
          case 'per_num':
            $this->setPersonneNum($value);
            break;
          case 'pro_date':
            $this->setDate($value);
            break;
          case 'pro_time':
            $this->setHeure($value);
            break;
          case 'pro_place':
            $this->setPlaces($value);
            break;
          case 'pro_sens':
            $this->setSens($value);
            break;

          default:
            break;
        }
      }
    }
  }



  public function setParcoursNum($num) {
    $this->parcoursNum = $num;
  }
  public function setPersonneNum($num) {
    $this->personneNum = $num;
  }
  public function setDate($date) {
    $this->parcoursDate = $date;
  }
  public function setHeure($heure) {
    $this->heure = $heure;
  }
  public function setPlaces($nb) {
    $this->places = $nb;
  }
  public function setSens($sens) {
    $this->sens = $sens;
  }


  public function getParcoursNum() {
    return $this->parcoursNum;
  }
  public function getPersonneNum() {
    return $this->personneNum;
  }
  public function getDate() {
    return $this->parcoursDate;
  }
  public function getHeure() {
    return $this->heure;
  }
  public function getPlaces() {
    return $this->place;
  }
  public function getSens() {
    return $this->sens;
  }

?>
