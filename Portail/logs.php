<?php
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=portail", 'root', '');

if (isset($_SESSION['pseudo'])) {
    $admin_username = $_SESSION['pseudo'];
} else {
    header("Location: connexion.php");
    exit();
}

// Récupérer les données de la base de données
$query = "SELECT *, DATE_FORMAT(heure_passage, '%H:%i:%s') AS heure_passage_format FROM logs";
$logs = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="logs.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <?php include 'header.php'; ?>

    <h1>Logs</h1>

    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Plaque d'immatriculation</th>
            <th>Accepter</th>
            <th>Refuser</th>
            <th>Heure de passage</th>
        </tr>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo $log['nom']; ?></td>
                <td><?php echo $log['prenom']; ?></td>
                <td><?php echo $log['plaque_immatriculation']; ?></td>
                <td><?php echo $log['accepter']; ?></td>
                <td><?php echo $log['refuse']; ?></td>
                <td><?php echo $log['heure_passage_format']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


