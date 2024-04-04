<?php
session_start(); // Démarre la session
$bdd= new PDO ("mysql:host=localhost;dbname=portail",'root',''); 
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include 'header.php'; ?>
</body>
</html>

