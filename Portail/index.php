<?php
session_start(); // Démarre la session

$bdd= new PDO ("mysql:host=localhost;dbname=portail",'root',''); 
// Connexion à la base de données MySQL

// Vérifie si l'administrateur est connecté
if(isset($_SESSION['pseudo'])) {
    // Récupère le nom de l'administrateur depuis la session
    $admin_username = $_SESSION['pseudo'];
} else {
    // Si l'administrateur n'est pas connecté, redirige vers la page de connexion
    header("Location: connexion.php");
    exit(); // Arrête l'exécution du script après la redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>EASYPORTAL</title>
    <link rel="stylesheet" href="index.css"> <!-- Lien vers votre fichier CSS -->

    
</head>
<body>

<?php include 'header.php'; ?>
<!-- Inclure le header.php -->

<!-- Le message de bienvenue sera affiché au centre de la page -->
<div class="welcome-message">Bienvenue, <?php echo $admin_username; ?></div>

</body>
</html>
