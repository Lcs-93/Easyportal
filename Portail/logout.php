<?php
session_start();

// Détruit toutes les données de la session
session_destroy();

// Redirige vers la page de connexion ou une autre page de votre choix
header("Location: connexion.php");
exit();
?>
