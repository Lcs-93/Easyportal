<?php
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=portail", 'root', '');

if (isset($_SESSION['pseudo'])) {
    $admin_username = $_SESSION['pseudo'];
} else {
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi de message</title>
    <link rel="stylesheet" href="portail.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Ouverture du portail</h1>
    <!-- Bouton pour envoyer un message -->
    <button id="sendMessageButton">Ouvrir Portail</button>

    <script src="script.js"></script>
</body>
</html>




