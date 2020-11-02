<?php

  /**
  * Renvoyer l'utilisateur non connecté sur la page d'accueil ($accueil = $_SERVER['PHP_SELF'] est mis dans le header)
  */
   if(!isset($_SESSION['connecte'])) {
     header('Location: '.$accueil);
     exit;
   }

?>
