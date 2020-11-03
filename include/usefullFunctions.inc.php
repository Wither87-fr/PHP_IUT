<?php
  function verifyPassword($password, $salt) {
    if(!empty($password)) {
      return password_verify($password, $salt);
    } else {
      return false;
    }

  }

  function personneExiste($listePersonne, $personneAtester) {
    $trouve = false;
    foreach ($listepers as $unepers) {
      if($unepers->getNom() === $_POST['username']) {
      $trouve = true;
    }
    }

    return $trouve;
  }
?>
