<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "portail";

// Création de la connexion
$mysqlClient = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($mysqlClient->connect_error) {
    die("Connexion échouée : " . $mysqlClient->connect_error);
}
?>

