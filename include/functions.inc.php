<?php
	/**
	* ajoute nbJours à date
	* @param date : la date à laquelle ajouter des jours
	* @param nbJours : Le nombre de jours à ajouter
	* @return date : la date avec nbJours supplémentaires
	*/
	function addJours($date, $nbJours){
		$membres = explode('-', $date);
		$day = $membres[2];
		$month = $membres[1];
		$year = $membres[0];
		// Si oui ou non le mois a 31 jours
		$month31days = ((intval($month) == 1) || (intval($month) == 3) ||(intval($month) == 5) ||(intval($month) == 7) || (intval($month) == 8) ||(intval($month) == 10) || (intval($month) == 12));
		// Si oui ou non il s'agit du mois de février
		$february = intval($month) == 2;
		//Si l'anée est bissextile ou non
		$anneBis = ((intval($year) % 4) == 0) || (((intval($year) % 100) == 0) && (intval($year) % 400) == 0);
		if (intval($day) == 31 && $month31days && $nbJours > 0) {
			$day = 0;
			$month += 1;
			if(intval($membres[1]) == 12) {
				$year +=1;
			}
		}

		if (intval($day) == 30 && !$month31days && $nbJours > 0) {
			$day = 0;
			$month += 1;
		}

		if (intval($day) == 29 && $february && $nbJours > 0 && $anneBis) {
			$day = 0;
			$month += 1;
		}

		if (intval($day) == 28 && $february && $nbJours > 0 && !$anneBis) {
			$day = 0;
			$month += 1;
		}


		$date = $year.'-'.$month.'-'.($day+$nbJours);
		return $date;
	}

	/**
	* Vérifie que le mot de passe fourni et son hash correspondent
	* @param password : le mot de passe a comparer
	* @param hashed : Le mot de passe hashé
	* @return verified : Si oui ou non les deux correspondent
	*/
	function verifyPassword($password, $hashed) {
    if(!empty($password)) {
      return encrypt($password) === $hashed;
    } else {
      return false;
    }

  }

	/**
	* Vérifie qu'une personne se trouve dans la liste
	* @param listePersonne : La liste contenant toutes les personnes
	* @param personneAtester : La personne que l'on recherche dans la liste
	* @return trouve : Si oui ou non la personne est présente dans la liste
	*/
  function personneExiste($listePersonne, $personneAtester) {
    $trouve = false;
    foreach ($listePersonne as $unepers) {
      if($unepers->getLogin() === $personneAtester) {
      $trouve = true;
    	}
    }
    return $trouve;
  }

	/**
	* ajoute nbJours à date
	* @param toConvert : la chaîne à convertir
	* @return converted : la chaîne convertie en UTF-8
	*/
  function convertToUTF8($toConvert) {
    return mb_convert_encoding($toConvert, "UTF-8");
  }

	/**
	* Hash un mot de passe
	* @param password : le mot de passe que l'on veut hasher
	* @return hashedPassword : Le mot de passe hashé
	*/
  function encrypt($password) {
    return sha1(sha1(convertToUTF8($password)).convertToUTF8(SALT));
  }

	/**
	* Crée un un onglet "select" d'un formulaire contenant des heures (de 0 à 23)
	* @return selectBox : l'onglet "select"
	*/
  function createHourList() {
    ?>
      <select name="heure_min" id="heure_min">
        <option value="0">0h</option>
        <option value="1">1h</option>
        <option value="2">2h</option>
        <option value="3">3h</option>
        <option value="4">4h</option>
        <option value="5">5h</option>
        <option value="6">6h</option>
        <option value="7">7h</option>
        <option value="8">8h</option>
        <option value="9">9h</option>
        <option value="10">10h</option>
        <option value="11">11h</option>
        <option value="12">12h</option>
        <option value="13">13h</option>
        <option value="14">14h</option>
        <option value="15">15h</option>
        <option value="16">16h</option>
        <option value="17">17h</option>
        <option value="18">18h</option>
        <option value="19">19h</option>
        <option value="20">20h</option>
        <option value="21">21h</option>
        <option value="22">22h</option>
        <option value="23">23h</option>
      </select>
    <?php
  }

?>
