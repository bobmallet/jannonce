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

        <title>Administration</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';
        ?>






        <?php
        $users = getAllUser();

        $edit = '<a href="?user=true" class="btn btn-primary" role="button">Ban/Unban</a>';




        for ($i = 0; $i < count($users); $i++) {
            $edit = '<form action="#" method="post">
                                <input type="hidden" name="uid" value="' . $users[$i]['id'] . '"/>
                                <input type="submit" name="banuser" class="btn btn-primary" value="Ban/Unban"/>
                        </form>';

            $users[$i]['Edition'] = $edit;
        }

        print Array2Html($users, true);




        $articles = getAllArticles();



        for ($i = 0; $i < count($articles); $i++) {
            $edit = '<form action="#" method="post">
                                <input type="hidden" name="aid" value="' . $articles[$i]['id'] . '"/>
                                <input type="submit" name="banarticle" class="btn btn-primary" value="Ban/Unban"/>
                        </form>';
            $articles[$i]['Edition'] = $edit;
        }

        print Array2Html($articles, true);


        if (isset($_REQUEST['banuser'])) {
            $uid = intval($_REQUEST['uid']);
            banUnbanUser($uid);
            header('Location: administration.php');
        }


        ?>
    </body>
</html>
