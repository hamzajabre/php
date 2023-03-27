<!DOCTYPE html>
<html>
<head>
	<title>Création de comptes utilisateurs</title>
</head>
<body>
	<h1>Création de comptes utilisateurs</h1>
	<form method="post" >
		<label for="name_user">Nom :</label>
		<input type="text" name="name_user" ><br><br>
		
		<label for="first_name_user">Prénom :</label>
		<input type="text" name="first_name_user" ><br><br>
		
		<label for="login_user">Nom d'utilisateur :</label>
		<input type="text" name="login_user" ><br><br>
		
		<label for="pass_user">Mot de passe :</label>
		<input type="password" name="pass_user" ><br><br>
		
		<input type="submit" name="submit" value="Ajouter">
	</form><br><br>

	<?php

    // Vérification de la soumission du formulaire
	if (isset($_POST['name_user']) && isset($_POST['first_name_user']) && isset($_POST['login_user']) && isset($_POST['pass_user'])) {
		$name_user = $_POST['name_user'];  echo " nom  : $name_user  <br>";
		$first_name_user = $_POST['first_name_user'];  echo "prenom : $first_name_user  <br>";
		$login_user = $_POST['login_user'];  echo "login : $login_user  <br>";
		$pass_user = $_POST['pass_user'];  echo "pass : $pass_user  <br>";
	}
	// Connexion à la base de données
    $db_name = "task";
	$db_user = "hamza1986";
	$db_pass = "hamza1986";
	
	
		
        $bdd = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_user, $db_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        // Requête SQL pour insérer un nouvel enregistrement
		$sql = "INSERT INTO 'users' (name_user, first_name_user, login_user, pass_user) VALUES ('[name_user]', '[first_name_user]', '[login_user]', '[pass_user]')";
        // Préparation de la requête SQL nous stockons dans une variable $req la requête à exécuter
        $req = $bdd->prepare('SELECT * FROM users where name_user=:name_user');
        // La fonction bindParam permet de "filtrer" notre requête de manière sécurisée, la valeur ne peut pas lui être donnée directement
        $nom_attribut = "nom 1";
        $req->bindParam(":name_user", $name_user);
        // Exécution de la requête SQL
        $req->execute();
        echo "<h2>Liste des utilisateurs :</h2>";
        // Boucle pour parcourir et afficher le contenu de chaque ligne de la table
        foreach($req->fetchAll() as $donnee) {
            
            // Affichage des données du résultat de la requête par leurs noms d’attributs
            echo '<p>' . $donnee['name_user'] .":". "<br> " . $donnee['first_name_user'] . "<br> " . $donnee['login_user'] . "<br> " . $donnee['pass_user'] . '</p>';
        }
       
        
        // Fermeture de la connexion à la bdd (économise des ressources)
        $req->closeCursor();
    

	?>
</body>
</html>
