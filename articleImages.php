<?php
/*
  Fichier: articleImages.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Page d'affichage des images d'annonce
  Copyright (TPI 2016 - Kevin Zaffino © 2016)
 */
require_once './phpScript/inc.all.php';

//Uniquement si le parametre "id" existe
if (!isset($_REQUEST['id'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>articleImages</title>
        <base target="_parent" />
    </head>
    <body>
        <?php
        $id = intval($_REQUEST['id']);
        $img = articleImages($id);
        
        //Affichage des images
        foreach ($img as $value) {
            echo '<a href="' . $value['path'] . '"><img alt="Image" src="' . $value['path'] . '" width="100%"></a>';
        }
        ?>
    </body>
</html>
