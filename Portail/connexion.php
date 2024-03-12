
<!DOCTYPE html>
<html>
    <head>
        <title>EASYPORTAL ADMINISTRATION</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="connexion.css">
    </head>

    <body>
        <div class="container">
            <h2>CONNEXION EASYPORTAL ADMINISTRATEUR</h2>
            <form method="POST" action="" align ="center">
                <input type="text" name="pseudo" placeholder="Pseudo" autocomplete="off">
                <br>
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" autocomplete="off">
                <br><br>
                <input type="submit" name="valider" value="Valider">
            </form>
            <?php
session_start();
$bdd= new PDO ("mysql:host=localhost;dbname=portail",'root',''); 
if(isset($_POST['valider'])){
    if(!empty($_POST['pseudo']) AND !empty($_POST['mot_de_passe'])){
        $pseudo= htmlspecialchars($_POST['pseudo']);
        $mot_de_passe=htmlspecialchars($_POST['mot_de_passe']);

        //echo "Pseudo saisi : $pseudo<br>";
        //echo "Mot de passe saisi : $mot_de_passe<br>";

        $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE pseudo = ? AND mot_de_passe = ?");
        $recupUser->execute(array($pseudo,$mot_de_passe));

        if($recupUser->rowCount() > 0){
            $_SESSION['pseudo'] =$pseudo;
            $_SESSION['mot_de_passe'] =$mot_de_passe;
            $_SESSION['id'] =$recupUser->fetch()['id'];
           
            header("Location: index.php");
           exit();

        }else{
             echo "<p class='error'>Votre mot de passe ou pseudo est incorrect...</p>";
        }
    } else {
        echo "<p class='error'>Veuillez compléter tous les champs.</p>";
    }
}
?>
        </div>
    </body>
</html>
