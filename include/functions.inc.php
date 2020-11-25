<?php
	function getEnglishDate($date){
		$membres = explode('/', $date);
		$date = $membres[2].'-'.$membres[1].'-'.$membres[0];
		return $date;
	}

	function addJours($date, $nbJours){
		$membres = explode('/', $date);
		$date = $membres[2].'-'.$membres[1].'-'.(intval($membres[0])+$nbJours);
		return $date;
	}

	function verifyPassword($password, $hashed) {
    if(!empty($password)) {
      return encrypt($password) === $hashed;
    } else {
      return false;
    }

  }

  function personneExiste($listePersonne, $personneAtester) {
    $trouve = false;
    foreach ($listePersonne as $unepers) {
      if($unepers->getLogin() === $personneAtester) {
      $trouve = true;
    }
    }

    return $trouve;
  }

  function convertToUTF8($string) {
    return mb_convert_encoding($string, "UTF-8");
  }

  function encrypt($password) {
    return sha1(sha1(convertToUTF8($password)).convertToUTF8(SALT));
  }

  function createHourList() {
    ?>
      <select name="heureMin">
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
