<?php
require './phpScript/inc.all.php';
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

        <title>Nouvelle annonce</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';

        if (isset($_REQUEST['submit'])) {
            $name = filter_input(INPUT_POST, 'name');
            $description = filter_input(INPUT_POST, 'description');
            $price = filter_input(INPUT_POST, 'price');
            $images="";
            $date = date('Y-m-d H:i:s');
            $uid = getUserID();
            
            $mvis = (isset($_POST["mailVisible"])) ? TRUE : FALSE;
            $pvis = (isset($_POST["phoneVisible"])) ? TRUE : FALSE;
            $avis = (isset($_POST["adressVisible"])) ? TRUE : FALSE;
            
            $article_id = insertArticle($name, $description, $price, $date, $uid, $mvis, $pvis, $avis);
                
            $id_image = intval(imageUpload());
            insertArticleImage($article_id, $id_image);
                   
            
        }
        ?>
        <div class="panel panel-default">
            <div class = "panel-heading">
                <h3 class = "panel-title">Nouvelle annonce</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="title">Libelle :
                        <input type="text" class="form-control" name='name'/>
                    </label>
                    <br/>
                    <label for="description">Description :<br/>
                        <textarea name='description' rows="10" cols="50" maxlength="500"></textarea>
                    </label>
                    <br/>
                    <label for="price">Prix :
                        <input type="text" name='price'/>
                    </label>
                    <br/>
                    <label for="image">Image(s) :
                        <input type="file" name="<?php echo INPUT; ?>"/>
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
    </body>
</html>
