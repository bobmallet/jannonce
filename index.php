<?php
/*
Fichier: index.php
Auteur: Kevin Zaffino
Date: 15/06/2016
Version:1.10
Description: Page d'accueil du site
Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
*/
require_once './phpScript/inc.all.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <title>Accueil</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';
        ?>
        <div class="container">
            <div>
                <a href="newArticle.php" class="btn btn-info" role="button">Nouvelle annonce</a>
                <br/><br/>
            </div>
            <div id="articles">
                <ul class="media-list forum">
                    <?php
                    foreach (listArticles() as $value) {
                        $path = articleImages(intval($value['id']))[0]['path'];
                        print articleFormat($value, $path);
                    }
                    ?>  
                </ul>
            </div>
        </div>
    </body>
</html>
