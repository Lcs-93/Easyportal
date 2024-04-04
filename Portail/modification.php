<?php
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=portail", 'root', '');
// Connexion à la base de données MySQL

// Vérifier si un formulaire de mise à jour a été soumis
if(isset($_POST['update'])){
    $id = $_POST['id']; // Récupère l'ID de l'utilisateur à mettre à jour depuis le formulaire
    $nom = $_POST['nom']; // Récupère le nouveau nom de l'utilisateur depuis le formulaire
    $prenom = $_POST['prenom']; // Récupère le nouveau prénom de l'utilisateur depuis le formulaire
    $plaque_immatriculation = $_POST['plaque_immatriculation']; // Récupère la nouvelle plaque d'immatriculation de l'utilisateur depuis le formulaire
    
    // Requête de mise à jour des informations dans la base de données
    $sql = "UPDATE informations_personnelles SET nom = :nom, prenom = :prenom, plaque_immatriculation = :plaque_immatriculation WHERE id = :id"; // Requête SQL pour mettre à jour les informations de l'utilisateur ayant l'ID spécifié
    $stmt = $bdd->prepare($sql); // Prépare la requête SQL
    $stmt->execute(array( // Exécute la requête en liant les valeurs des champs à mettre à jour
        ':nom' => $nom, // Lie la valeur du nouveau nom à la clé ":nom" dans la requête SQL
        ':prenom' => $prenom, // Lie la valeur du nouveau prénom à la clé ":prenom" dans la requête SQL
        ':plaque_immatriculation' => $plaque_immatriculation, // Lie la valeur de la nouvelle plaque d'immatriculation à la clé ":plaque_immatriculation" dans la requête SQL
        ':id' => $id // Lie la valeur de l'ID de l'utilisateur à mettre à jour à la clé ":id" dans la requête SQL
        
    ));
    
    // Redirection vers la même page après la mise à jour des informations
    header("Location: modification.php"); // Redirige l'utilisateur vers la page modification.php après la mise à jour
    exit(); // Termine l'exécution du script
}


// Vérifier si un formulaire de suppression a été soumis
if(isset($_POST['delete'])){
    $id = $_POST['id']; // Récupère l'ID de l'utilisateur à supprimer depuis le formulaire
    
    // Requête de suppression de l'utilisateur dans la base de données
    $sql = "DELETE FROM informations_personnelles WHERE id = :id"; // Requête SQL pour supprimer l'utilisateur ayant l'ID spécifié
    $stmt = $bdd->prepare($sql); // Prépare la requête SQL
    $stmt->execute(array(':id' => $id)); // Exécute la requête en liant la valeur de l'ID
    // Redirection vers la même page après la suppression de l'utilisateur
    header("Location: modification.php"); // Redirige l'utilisateur vers la page modification.php après la suppression
    exit(); // Termine l'exécution du script
}


// Récupérer les informations depuis la base de données
$sql = "SELECT * FROM informations_personnelles"; // Requête SQL pour sélectionner toutes les informations de la table informations_personnelles
$stmt = $bdd->query($sql); // Exécute la requête SQL
$users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère toutes les lignes de résultat sous forme d'un tableau associatif et les stocke dans la variable $users

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
            <td><?php echo $user['nom']; ?></td> <!-- Affiche le nom de l'utilisateur dans la cellule de la table -->
            <td><?php echo $user['prenom']; ?></td> <!-- Affiche le prénom de l'utilisateur dans la cellule de la table -->
            <td><?php echo $user['plaque_immatriculation']; ?></td> <!-- Affiche la plaque d'immatriculation de l'utilisateur dans la cellule de la table -->

            <td>
                <!-- Formulaire de mise à jour -->
                <form method="post">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>"> <!-- Champ caché contenant l'ID de l'utilisateur -->
                <input type="text" name="nom" value="<?php echo $user['nom']; ?>"> <!-- Champ texte affichant le nom de l'utilisateur -->
                <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>"> <!-- Champ texte affichant le prénom de l'utilisateur -->
                <input type="text" name="plaque_immatriculation" value="<?php echo $user['plaque_immatriculation']; ?>"> <!-- Champ texte affichant la plaque d'immatriculation de l'utilisateur -->
                <input type="submit" name="update" value="Modifier"> <!-- Bouton de soumission du formulaire de mise à jour -->

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
