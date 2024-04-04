<!DOCTYPE html>
<html>
    <head>
        <title>EASYPORTAL ADMINISTRATION</title>
        <!-- Titre de la page -->
        <meta charset="utf-8">
        <!-- Définition de l'encodage de caractères -->
        <link rel="stylesheet" type="text/css" href="connexion.css">
        <!-- Lien vers la feuille de style connexion.css -->
    </head>

    <body>
        <div class="container">
            <!-- Début du conteneur principal -->
            <h2>CONNEXION EASYPORTAL ADMINISTRATEUR</h2>
            <!-- Titre du formulaire -->
            <form method="POST" action="" align ="center">
                <!-- Début du formulaire avec la méthode POST et l'action vide -->
                <input type="text" name="pseudo" placeholder="Pseudo" autocomplete="off">
                <!-- Champ de saisie pour le pseudo -->
                <br>
                <!-- Saut de ligne -->
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" autocomplete="off">
                <!-- Champ de saisie pour le mot de passe -->
                <br><br>
                <!-- Saut de ligne -->
                <input type="submit" name="valider" value="Valider">
                <!-- Bouton de soumission du formulaire -->
            </form>
            <?php
                session_start();
                $bdd= new PDO ("mysql:host=localhost;dbname=portail",'root',''); 
                // Connexion à la base de données MySQL
                
                if(isset($_POST['valider'])){
                    // Vérifie si le formulaire a été soumis
                    
                    if(!empty($_POST['pseudo']) AND !empty($_POST['mot_de_passe'])){
                        // Vérifie si les champs pseudo et mot de passe ne sont pas vides
                        $pseudo= htmlspecialchars($_POST['pseudo']);
                        // Récupère le pseudo en protégeant contre les attaques XSS
                        $mot_de_passe=htmlspecialchars($_POST['mot_de_passe']);
                        // Récupère le mot de passe en protégeant contre les attaques XSS

                        $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE pseudo = ? AND mot_de_passe = ?");
                        // Prépare la requête de sélection de l'utilisateur dans la base de données
                        $recupUser->execute(array($pseudo,$mot_de_passe));
                        // Exécute la requête en passant le pseudo et le mot de passe en paramètres

                        if($recupUser->rowCount() > 0){
                            // Vérifie s'il y a au moins une ligne retournée par la requête
                            $_SESSION['pseudo'] =$pseudo;
                            // Initialise la session avec le pseudo de l'utilisateur
                            $_SESSION['mot_de_passe'] =$mot_de_passe;
                            // Initialise la session avec le mot de passe de l'utilisateur
                            $_SESSION['id'] =$recupUser->fetch()['id'];
                            // Initialise la session avec l'identifiant de l'utilisateur retourné par la requête
                            header("Location: index.php");
                            // Redirige vers la page index.php
                            exit();
                            // Termine l'exécution du script
                        }else{
                            echo "<p class='error'>Votre mot de passe ou pseudo est incorrect...</p>";
                            // Affiche un message d'erreur si le pseudo ou le mot de passe est incorrect
                        }
                    } else {
                        echo "<p class='error'>Veuillez compléter tous les champs.</p>";
                        // Affiche un message d'erreur si tous les champs ne sont pas complétés
                    }
                }
            ?>
        </div>
        <!-- Fin du conteneur principal -->
    </body>
</html>

