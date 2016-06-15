<?php
/*
  Fichier: newArticle.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Page de creation d'annonce
  Copyright (TPI 2016 - Kevin Zaffino © 2016)
 */
require './phpScript/inc.all.php';

//Acces unique aux utilisateurs authentifiés
if (!isLogged()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <title>Nouvelle annonce</title>
    </head>
    <style>
        .panel{
            width: 75%;

        }
    </style>
    <body>
        <?php
        include './menu/showmenu.php';

        if (isset($_REQUEST['submit'])) {

            $name = filter_var($_REQUEST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($_REQUEST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_var($_REQUEST['price'], FILTER_SANITIZE_SPECIAL_CHARS);

            $date = date('Y-m-d H:i:s');

            $mvis = (isset($_POST["mailVisible"])) ? TRUE : FALSE;
            $pvis = (isset($_POST["phoneVisible"])) ? TRUE : FALSE;
            $avis = (isset($_POST["adressVisible"])) ? TRUE : FALSE;

            $article_id = checkNewArticle($name, $description, $price, $date, $mvis, $pvis, $avis);

            multiUpload($article_id);

            header('Location: articles.php?idarticle=' . $article_id);
        }
        ?>
        <div class="col-md-5 col-md-offset-4">
            <div class="panel panel-default">
                <div class = "panel-heading">
                    <h3 class = "panel-title">Nouvelle annonce</h3>
                </div>
                <div class="panel-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="title">Libelle :
                            <input type="text" class="form-control" name='name' required/>
                        </label>
                        <br/>
                        <label for="description">Description :<br/>
                            <textarea name='description' rows="10" cols="50" maxlength="500" required></textarea>
                        </label>
                        <br/>
                        <label for="price">Prix :
                            <input type="text" name='price' required/>
                        </label>
                        <br/>
                        <label for="image">Image(s) :
                            <input type="file" name="<?php echo INPUT; ?>[]" multiple accept="image/*" required/>
                        </label>
                        <br/>

                        <label for='mailVisible'>
                            E-mail visible : <input type="checkbox" name='mailVisible'/>                        
                        </label>

                        <label for='phoneVisible'>
                            Numero de Tel. visible : <input type="checkbox" name='phoneVisible'/>                        
                        </label>

                        <label for='adressVisible'>
                            Adresse visible : <input type="checkbox" name='adressVisible'/>                        
                        </label>
                        <br/>
                        <button type="submit" class="btn btn-success" name="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
