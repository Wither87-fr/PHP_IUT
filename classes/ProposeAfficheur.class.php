<?php
  /**
   *
   */
  class ProposeAfficheur
  {
    private $villeDepart;
    private $villeArrivee;
    private $sens;
    private $date;
    private $heure;
    private $places;
    private $conducteur;

    public function __construct($valeurs)
    {
      if(!empty($valeurs)) {
        $this->affecte($valeurs);
        if($this->sens === 1) {
          $temp = $this->villeArrivee;
          $this->villeArrivee = $this->villeDepart;
          $this->villeDepart = $temp;
        }
      }
    }




    public function affecte($donees) {
      foreach ($donees as $key => $value) {
        switch ($key) {
          case 'ville1':
            $this->setVilleDepart($value);
            break;
          case 'ville2':
            $this->setVilleArrivee($value);
            break;
          case 'sens':
            $this->setSens($value);
            break;
          case 'date':
            $this->setDate($value);
            break;
          case 'heure':
            $this->setHeure($value);
            break;
          case 'places':
            $this->setPlaces($value);
            break;
          case 'conducteur':
            $this->setConducteur($value);
            break;
          default:
            break;
        }
      }
    }



  public function setVilleDepart($ville1) {
    $this->villeDepart = $ville1;
  }
  public function setVilleArrivee($ville2) {
    $this->villeArrivee = $ville2;
  }
  public function setSens($sens) {
    $this->sens = $sens;
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
  public function setConducteur($conducteur) {
    $this->conducteur = $conducteur;
  }



  public function getVilleDepart() {
    return $this->villeDepart;
  }
  public function getVilleArrivee() {
    return $this->villeArrivee;
  }
  public function getSens() {
    return $this->sens;
  }
  public function getDate() {
    return $this->parcoursDate;
  }
  public function getHeure() {
    return $this->heure;
  }
  public function getPlaces() {
    return $this->places;
  }
  public function getConducteur() {
    return $this->conducteur;
  }
}

?>
