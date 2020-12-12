<?php
session_start(); // on démarre la session
session_destroy(); // on la détruit, supprimant toutes les variables (en particulier "connecté")
header('Location: index.php'); // on le ramène à l'accueil mais deconnecté
exit;
?>
