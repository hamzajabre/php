<?php
if (isset($_POST['submit'])) {
  // Vérifier si des fichiers ont été téléchargés
  if (isset($_FILES['files'])) {
    $allowed_types = array('png', 'jpg');
    $max_size = 3 * 1024 * 1024; // 3 Mo en octets
    $errors = array();

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
      // Vérifier si le fichier est valide
      $file_name = $_FILES['files']['name'][$key];
      $file_size = $_FILES['files']['size'][$key];
      $file_type = $_FILES['files']['type'][$key];
      $file_error = $_FILES['files']['error'][$key];
      
      if ($file_error == UPLOAD_ERR_OK) {
        // Vérifier le type et la taille du fichier
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_types)) {
          $errors[] = "Le type de fichier '$file_name' n'est pas autorisé.";
        }
        if ($file_size > $max_size) {
          $errors[] = "Le fichier '$file_name' dépasse la taille maximale autorisée.";
        }

        // Gérer les accents dans le nom de fichier
        $file_name = strtr($file_name, "éèêëàâäôöûüîïç", "eeeeaaaoouuiic");

        // Télécharger le fichier
        $file_path = "uploads/" . $file_name;
        move_uploaded_file($tmp_name, $file_path);
      } else {
        $errors[] = "Erreur lors du téléchargement du fichier '$file_name'. Code d'erreur: $file_error";
      }
    }

    if (count($errors) == 0) {
      echo "Les fichiers ont été téléchargés avec succès.";
    } else {
      echo "Les erreurs suivantes se sont produites lors du téléchargement des fichiers:<br>";
      foreach ($errors as $error) {
        echo "- $error<br>";
      }
    }
  } else {
    echo "Aucun fichier n'a été téléchargé.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Téléchargement de fichiers</title>
</head>
<body>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="files[]" multiple>
    <br>
    <input type="submit" name="submit" value="Télécharger">
  </form>
</body>
</html>

