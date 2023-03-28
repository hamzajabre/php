<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <h1>index.PHP</h1>
    <p><a href="deconnexion.php">Se déconnecter</a></p>
    
    <?php
    include('./connect.php');

    if(empty($_SESSION["user"])) {        
  // Permet de détruire la session PHP courante ainsi que toutes les données rattachées
        session_destroy();
        header("Location: connexion.php");
    }
    ?>


</body>
</html>