<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>inscription.PHP</h1>
    
    <form method="post" name="form_inscription"enctype="multipart/form-data">
        <input type="hidden" name="form_inscription" value="1">
        <label for="name_user">Nom :</label><br>
        <input type="text" name="name_user" >
        <br><br>
        <label for="first_name_user">Prénom :</label><br>
        <input type="text" name="first_name_user" >
        <br><br>
        <label for="login_user">Login :</label><br>
        <input type="text" name="login_user" >
        <br><br>
        <label for="pass_user">Mot de passe :</label><br>
        <input type="text" name="pass_user" >
        <br><br>
        <input type="submit" value="s'inscrire">
    </form>  

    <?php
    // On inclut notre connecteur à la base de données
    include('./connect.php');

    if (isset($_POST['name_user']) && isset($_POST['first_name_user'])
    && isset($_POST['login_user']) && isset($_POST['pass_user'])){
    
    $name_user = $_POST['name_user']; echo "nom : $name_user <br>";
    $first_name_user = $_POST['first_name_user'];echo "prenom : $first_name_user <br>";
    $login_user = $_POST['login_user'];echo "login : $login_user <b";
    $pass_user = $_POST['pass_user'];echo "mot de passe:  $pass_user";

    } 
    
    // On entre dans la boucle seulement lors de l’envoi du formulaire
    if(!empty($_POST["form_inscription"])) {
        // On recherche si l'adresse email existe déjà en BDD
        $select = $db->prepare("SELECT * FROM users WHERE name_user=:name_user;");
        $select->bindParam(":name_user", $_POST["name_user"]);
        $select->execute();
        if(empty($select->fetch(PDO::FETCH_COLUMN))) {
            // Si ce n'est pas le cas, on vient l'insérer
            $insert = $db->prepare("INSERT INTO users(name_user, first_name_user, login_user,  pass_user)
                                    VALUES(:name_user, :first_name_user, :login_user, :pass_user);");
            $insert->bindParam(":name_user", $_POST['name_user']);
            $insert->bindParam(":first_name_user", $_POST['first_name_user']);
            $insert->bindParam(":login_user", $_POST['login_user']);
            $pass_user = password_hash($_POST['pass_user'], PASSWORD_BCRYPT, array("cost" => '12'));
            $insert->bindParam(":pass_user", $pass_user);
            if($insert->execute()) {
                // Si aucune erreur ne se produit, on propose de se connecter
                die('<p style=”color: green;”>Inscription réussie.</p><a href="connexion.php">Se connecter.</a>');
            }
            die('<p style=”color: red;”>Inscription échouée.</p><a href="inscription.php">Réessayer.</a>');
        }
    }
    ?>

</body>
</html>