<?php
/*
Fichier: administation.php
Auteur: Kevin Zaffino
Date: 15/06/2016
Version:1.10
Description: Page d'administration du site
Copyright (TPI 2016 - Kevin Zaffino © 2016)
*/
require_once './phpScript/inc.all.php';
if(getPrivilege() != PRIV_ADMIN){
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <title>Administration</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';
        ?>






        <?php
        if (isset($_REQUEST['banuser'])) {
            $uid = intval($_REQUEST['uid']);
            banUnbanUser($uid);
            header('Location: administration.php');
        }

        if (isset($_REQUEST['banarticle'])) {
            $aid = intval($_REQUEST['aid']);
            banunbanArticle($aid);
            header('Location: administration.php');
        }
        ?>

        <div id="articles" class = "panel panel-primary">
            <div class = "panel-heading">
                <h3 class = "panel-title">Utilisateurs</h3>
            </div>
            <div class = "panel-body">
                <ul class="media-list forum">
                    <?php
                    $users = getAllUser();

                    for ($i = 0; $i < count($users); $i++) {
                        $edit = '<form action="#" method="post">
                                <input type="hidden" name="uid" value="' . $users[$i]['id'] . '"/>
                                <input type="submit" name="banuser" class="btn btn-primary" value="Ban/Unban"/>
                        </form>';

                        $users[$i]['Edition'] = $edit;
                    }

                    print Array2Html($users, true);
                    ?>

                </ul>
            </div>
        </div>

        <div id="articles" class = "panel panel-primary">
            <div class = "panel-heading">
                <h3 class = "panel-title">Annonces</h3>
            </div>
            <div class = "panel-body">
                <ul class="media-list forum">
                    <?php
                    $articles = getAllArticles();
                    for ($i = 0; $i < count($articles); $i++) {
                        $edit = '<form action="#" method="post">
                                <input type="hidden" name="aid" value="' . $articles[$i]['id'] . '"/>
                                <input type="submit" name="banarticle" class="btn btn-primary" value="Ban/Unban"/>
                        </form>';
                        $articles[$i]['Edition'] = $edit;
                    }

                    print Array2Html($articles, true);
                    ?>

                </ul>
            </div>
        </div>
    </body>
</html>
