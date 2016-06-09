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

        <title>about</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';
        ?>

        <div class="panel-info col-lg-3 pull-left">
            <div class = "panel-heading">
                <h3 class = "panel-title">A propos du site</h3>
            </div>
            <div class="panel-body">
                <p>Le site permettra aux utilisateurs de poster diverses annonces (ventes, services, …). Les utilisateurs pourront voir les annonces existantes et auront ainsi la possibilité de contacter la personne concernée.</p>
            </div>
        </div>

        <div class="panel-info col-lg-9 pull-right">
            <div class = "panel-heading">
                <h3 class = "panel-title">F.A.Q</h3>
            </div>
            <div class="panel-body">
                <h2>
                    Comment se connecter sur le site ?
                </h2>
                <p>
                    Il suffit de cliquer sur l’onglet « Connexion/Inscription » dans le menu du site.
                </p>
                <h2>
                </h2>
                <h2>
                    Comment ajouter une nouvelle annonce ?
                </h2>
                <p>
                    Une fois connecté sur le site, il suffit de cliquer sur « Nouvelle annonce » dans la page d’accueil.
                </p>
                <h2>
                    Je possède une annonce qui est terminée, comment le signaler ?
                </h2>
                <p>
                    Il suffit de cliquer sur « Ouvrir/Fermer » dans la page de votre annonce.
                </p>
            </div>
        </div>

        <div class="panel-info col-lg-3 pull-left">
            <div class = "panel-heading">
                <h3 class = "panel-title">Auteur</h3>
            </div>
            <div class="panel-body">
                Nom   : ZAFFINO Kevin
                <br/>
                email : kevin.zffn@eduge.ch
            </div>
        </div>
    </body>
</html>
