<?php
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=portail", 'root', '');

// Vérifier si un formulaire de mise à jour a été soumis
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $plaque_immatriculation = $_POST['plaque_immatriculation'];
    
    // Requête de mise à jour des informations dans la base de données
    $sql = "UPDATE informations_personnelles SET nom = :nom, prenom = :prenom, plaque_immatriculation = :plaque_immatriculation WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array(
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':plaque_immatriculation' => $plaque_immatriculation,
        ':id' => $id
    ));
    
    // Redirection vers la même page après la mise à jour des informations
    header("Location: modification.php");
    exit();
}

// Vérifier si un formulaire de suppression a été soumis
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    
    // Requête de suppression de l'utilisateur dans la base de données
    $sql = "DELETE FROM informations_personnelles WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array(':id' => $id));
    
    // Redirection vers la même page après la suppression de l'utilisateur
    header("Location: modification.php");
    exit();
}

// Récupérer les informations depuis la base de données
$sql = "SELECT * FROM informations_personnelles";
$stmt = $bdd->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification des informations personnelles</title>
    <link rel="stylesheet" href="modification.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>

<?php include 'header.php'; ?> <!-- Inclure le header.php -->

<div class="container">
    <h2>Modification des informations personnelles</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Plaque d'immatriculation</th>
            <th>Action</th>
        </tr>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?php echo $user['nom']; ?></td>
            <td><?php echo $user['prenom']; ?></td>
            <td><?php echo $user['plaque_immatriculation']; ?></td>
            <td>
                <!-- Formulaire de mise à jour -->
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <input type="text" name="nom" value="<?php echo $user['nom']; ?>">
                    <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>">
                    <input type="text" name="plaque_immatriculation" value="<?php echo $user['plaque_immatriculation']; ?>">
                    <input type="submit" name="update" value="Modifier">
                </form>
                <!-- Formulaire de suppression -->
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <input type="submit" name="delete" value="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
