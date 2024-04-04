<?php
session_start(); // Démarre la session

$bdd = new PDO("mysql:host=localhost;dbname=portail", 'root', ''); // Connexion à la base de données MySQL

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

<?php

$bdd = new PDO("mysql:host=localhost;dbname=portail", 'root', ''); // Connexion à la base de données MySQL

if(isset($_POST['import'])){
    if($_FILES['file']['name']){ // Vérifie si un fichier a été sélectionné
        $filename = $_FILES['file']['tmp_name']; // Chemin temporaire du fichier uploadé
        
        $file = fopen($filename, "r"); // Ouvre le fichier en lecture
        
        // Parcourt le fichier ligne par ligne
        while(($data = fgetcsv($file, 1000, ",")) !== FALSE){
            // Récupère les données du fichier CSV
            $nom = $data[0];
            // Récupère le nom à partir de la première colonne des données du fichier CSV
            
            $prenom = $data[1];
            // Récupère le prénom à partir de la deuxième colonne des données du fichier CSV
            
            $plaque_immatriculation = $data[2];
            // Récupère la plaque d'immatriculation à partir de la troisième colonne des données du fichier CSV
            
            
            // Requête d'insertion dans la table informations_personnelles
            $sql = "INSERT INTO informations_personnelles (nom, prenom, plaque_immatriculation) VALUES ('$nom', '$prenom', '$plaque_immatriculation')";
            
            // Exécute la requête
            $bdd->exec($sql);
        }
        
        fclose($file); // Ferme le fichier
        header("Location: ajouter.php");
        exit();
    }
}

if(isset($_POST['export'])){
    // Vérifie si le formulaire d'exportation a été soumis

    // Requête de sélection des données de la table informations_personnelles
    $sql = "SELECT nom, prenom, plaque_immatriculation FROM informations_personnelles";
    
    // Prépare et exécute la requête SQL
    $stmt = $bdd->query($sql);
    
    // Entête CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=export.csv');
    
    // Crée un fichier CSV et écrit les données
    $output = fopen('php://output', 'w');
    
    // Ajoute l'en-tête des colonnes dans le fichier CSV
    fputcsv($output, array('Nom', 'Prénom', 'Plaque immatriculation'));
    
    // Parcourt les résultats de la requête et écrit chaque ligne dans le fichier CSV
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // Parcourt les résultats de la requête et récupère chaque ligne sous forme de tableau associatif
    
        fputcsv($output, $row);
        // Écrit la ligne actuelle dans le fichier CSV en utilisant la fonction fputcsv()
    }
    
    
    fclose($output); // Ferme le fichier CSV
    exit(); // Termine le script
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link rel="stylesheet" href="ajouter.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
<?php include 'header.php'; ?> <!-- Inclure le header.php -->

<div class="add-form">
    <h2>Ajouter un utilisateur</h2>
    <form method="post" action="ajouter.php">
    <!-- Début du formulaire avec la méthode POST et l'action "ajouter.php" -->
    <label for="nom">Nom:</label><br>
    <!-- Champ de saisie pour le nom -->
    <input type="text" id="nom" name="nom"><br>
    <!-- Balise de saisie de type texte avec l'identifiant "nom" et le nom "nom" -->
    <label for="prenom">Prénom:</label><br>
    <!-- Champ de saisie pour le prénom -->
    <input type="text" id="prenom" name="prenom"><br>
    <!-- Balise de saisie de type texte avec l'identifiant "prenom" et le nom "prenom" -->
    <label for="plaque_immatriculation">Plaque d'immatriculation:</label><br>
    <!-- Champ de saisie pour la plaque d'immatriculation -->
    <input type="text" id="plaque_immatriculation" name="plaque_immatriculation"><br><br>
    <!-- Balise de saisie de type texte avec l'identifiant "plaque_immatriculation" et le nom "plaque_immatriculation" -->
    <input type="submit" value="Ajouter">
    <!-- Bouton de soumission du formulaire -->
</form>
<!-- Fin du formulaire -->

</div>

<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom']; // Récupère la valeur du champ 'nom' du formulaire
    $prenom = $_POST['prenom']; // Récupère la valeur du champ 'prenom' du formulaire
    $plaque_immatriculation = $_POST['plaque_immatriculation']; // Récupère la valeur du champ 'plaque_immatriculation' du formulaire

    // Requête d'insertion
    $sql = "INSERT INTO informations_personnelles (nom, prenom, plaque_immatriculation) VALUES (:nom, :prenom, :plaque_immatriculation)";
    // Prépare la requête d'insertion avec des paramètres nommés
    $stmt = $bdd->prepare($sql);
    // Exécute la requête avec les valeurs récupérées du formulaire
    $stmt->execute(array(':nom' => $nom, ':prenom' => $prenom, ':plaque_immatriculation' => $plaque_immatriculation));

    // Afficher un message de succès
    echo "Utilisateur ajouté avec succès.";
}

?>

<div class="container import-container">
    <h2 class="import-title">Ajouter utilisateur via fichier csv</h2>
    <form method="post" enctype="multipart/form-data" class="import-form">
        <input type="file" name="file" accept=".csv" class="file-input">
        <input type="submit" name="import" value="Importer" class="import-button">
    </form>
</div>

<!-- Formulaire d'exportation vers un fichier CSV -->
<div class="container export-container">
    <h2 class="export-title">Exportation utilisateur via fichier csv</h2>
    <form method="post" class="export-form">
        <input type="submit" name="export" value="Exporter" class="export-button">
    </form>
</div>
</body>
</html>


