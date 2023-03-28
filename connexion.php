<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="view
    port" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>CONNEXION.PHP</h1>
    <form method="POST" name="form_connexion">
        <input type="hidden" name="form_connexion" value="1">
        <label for="name_user">name:</label>
        <input type="text" name="name_user" id="name_user" >
        <label for="pass_user">Mot de passe:</label>
        <input type="password" name="form_password" id="pass_user" placeholder="1234">
        <input type="submit" name="connexion" value="Se connecter">
    </form>

    <?php

    include('./connect.php');

    if(!empty($_POST["form_connexion"])) {
      
       
        $select = $db->prepare("SELECT * FROM users WHERE name_user=:name_user;");
        $select->bindParam(":name_user", $_POST["name_user"]);
      
        $select->execute();
     
        // La fonction rowCount() permet de donner le nombre de lignes pour une requête
       
        if($select->rowCount() === 1) {
            $user = $select->fetch(PDO::FETCH_ASSOC);
            // Permet de vérifier le hash par rapport au mot de passe saisi
            if(password_verify($_POST["form_password"], $user['pass_user'])) {
            // On affecte les données de notre utilisateur dans notre super globale $_SESSION
            $_SESSION['user'] = $user;
            // Le header permet d'effectuer une requête HTTP, la valeur Location permet la redirection vers un autre fichier
            header("Location: index.php");
		}
        } else {
            unset($_SESSION['user']);
        }
    }
   
    ?>




</body>
</html>