<?php
require_once './phpScript/inc.all.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <title>Accueil</title>
    </head>
    <body>
        <?php
//include './menu/adminMenu.html';
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
