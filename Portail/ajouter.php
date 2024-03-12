<?php
session_start(); // Inclure le fichier de configuration de la base de données
$bdd= new PDO ("mysql:host=localhost;dbname=portail",'root',''); 
if(isset($_POST['import'])){
    if($_FILES['file']['name']){ // Vérifie si un fichier a été sélectionné
        $filename = $_FILES['file']['tmp_name']; // Chemin temporaire du fichier uploadé
        
        $file = fopen($filename, "r"); // Ouvre le fichier en lecture
        
        // Parcourt le fichier ligne par ligne
        while(($data = fgetcsv($file, 1000, ",")) !== FALSE){
            // Récupère les données du fichier CSV
            $nom = $data[0];
            $prenom = $data[1];
            $plaque_immatriculation = $data[2];
            
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
    // Requête de sélection des données de la table informations_personnelles
    $sql = "SELECT nom, prenom, plaque_immatriculation FROM informations_personnelles";
    $stmt = $bdd->query($sql);
    
    // Entête CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=export.csv');
    
    // Crée un fichier CSV et écrit les données
    $output = fopen('php://output', 'w');
    fputcsv($output, array('Nom', 'Prénom', 'Plaque immatriculation'));
    
    // Parcourt les résultats de la requête et écrit chaque ligne dans le fichier CSV
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        fputcsv($output, $row);
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
    <link rel="stylesheet" href="ajouter.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="add-form">
    <h2>Ajouter un utilisateur</h2>
        <form method="post" action="ajouter.php">
            <label for="nom">Nom:</label><br>
            <input type="text" id="nom" name="nom"><br>
            <label for="prenom">Prénom:</label><br>
            <input type="text" id="prenom" name="prenom"><br>
            <label for="plaque_immatriculation">Plaque d'immatriculation:</label><br>
            <input type="text" id="plaque_immatriculation" name="plaque_immatriculation"><br><br>
            <input type="submit" value="Ajouter">
        </form>
</div>
<?php
// Connexion à la base de données
$bdd = new PDO("mysql:host=localhost;dbname=portail", 'root', '');

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $plaque_immatriculation = $_POST['plaque_immatriculation'];

    // Requête d'insertion
    $sql = "INSERT INTO informations_personnelles (nom, prenom, plaque_immatriculation) VALUES (:nom, :prenom, :plaque_immatriculation)";
    $stmt = $bdd->prepare($sql);
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
