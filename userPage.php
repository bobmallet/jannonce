<?php
/*
  Fichier: userPage.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Page d'information personnel
  Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
 */
require_once './phpScript/inc.all.php';
if (!isLogged()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <title>User page</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';
        $userinfo = getUserInfo($_SESSION['uid']);
        //var_dump($userinfo);
        ?>

        <div class="panel-info" id='information'>
            <div class = "panel-heading">
                <h3 class = "panel-title">Information personnelle</h3>
            </div>
            <div class="panel-body">

                <div class="pull-left col-lg-2">
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="<?php echo $userinfo['path']; ?>" width="300px">
                    </a>


                </div>
                <div class="col-lg-4">

                    <div id='description'>
                        <?php
                        $gender = ($userinfo['gender'] == "0") ? "Femme" : "Homme";

                        echo 'Nom: ' . $userinfo['lastname'];
                        echo '<br/>';
                        echo 'Prenom: ' . $userinfo['firstname'];
                        echo '<br/>';
                        echo 'Genre : ' . $gender;
                        echo '<br/><br/><br/>';
                        ?>

                        <br/><br/><br/>
                        <a href="modification.php" class="btn btn-warning" role="button">Modifier les informations</a>
                    </div>
                </div>

                <div id="info" class="pull-right col-lg-4">
                    <div class="panel-default">
                        <div class = "panel-heading">
                            <h3 class = "panel-title">Contact</h3>
                        </div>
                        <div class="panel-body">

                            Tel. : <?php echo $userinfo['phone']; ?>
                            <br/>
                            E-mail : <?php echo $userinfo['mail']; ?>
                            <br/>
                            Adresse : <?php echo '<br/>' . $userinfo['street'] . " " . $userinfo['city'] . ", " . $userinfo['country']; ?>
                            <br/><br/><br/>
                        </div>
                    </div>
                </div>

            </div>


        </div>

        <div id="articles" class = "panel panel-primary">
            <div class = "panel-heading">
                <h3 class = "panel-title">Mes annonce(s)</h3>
            </div>
            <div class = "panel-body">
                <ul class="media-list forum">
                    <?php
                    foreach (getUserArticles(getUserID()) as $value) {
                        $path = articleImages(intval($value['id']))[0]['path'];
                        print articleFormat($value, $path);
                    }
                    ?>
                    <!-- Forum Post -->
                    <!--
                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>

                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>

                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>

                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>
                    -->

                </ul>
            </div>
        </div>

    </body>
</html>
