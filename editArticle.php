<?php
/*
  Fichier: editArticle.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Page d'edition d'annonce
  Copyright (TPI 2016 - Kevin Zaffino © 2016)
 */
require './phpScript/inc.all.php';

$aid = intval($_REQUEST['aid']);
$uidarticle = intval(articleInfo($aid)['id_Users']);

//Acces unique au createur de l'annonce et à l'admin
if (getUserID() != $uidarticle && getPrivilege() != PRIV_ADMIN) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <title>Edition de l'annonce</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';


        $article = articleInfo($aid);

        if (isset($_REQUEST['submit'])) {
            $name = filter_var($_REQUEST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($_REQUEST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_var($_REQUEST['price'], FILTER_SANITIZE_SPECIAL_CHARS);

            $date = date('Y-m-d H:i:s');
            //$uid = getUserID();

            $mvis = (isset($_POST["mailVisible"])) ? TRUE : FALSE;
            $pvis = (isset($_POST["phoneVisible"])) ? TRUE : FALSE;
            $avis = (isset($_POST["adressVisible"])) ? TRUE : FALSE;


            if ($_FILES[INPUT]['name'][0] != '') {
                deleteArticleImages($aid);
                multiUpload($aid);
            }

            checkEditArticle($aid, $name, $description, $price, $mvis, $pvis, $avis);
        }
        ?>
        <div class="col-md-5 col-md-offset-4">
            <div class="panel panel-default">
                <div class = "panel-heading">
                    <h3 class = "panel-title">Edite l'annonce</h3>
                </div>
                <div class="panel-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="title">Libelle :
                            <input type="text" class="form-control" name='name' value="<?php echo $article['name']; ?>" required/>
                        </label>
                        <br/>
                        <label for="description">Description :<br/>
                            <textarea name='description' rows="10" cols="50" maxlength="500" required><?php echo $article['description']; ?></textarea>
                        </label>
                        <br/>
                        <label for="price">Prix :
                            <input type="text" name='price' value="<?php echo $article['price']; ?>" required/>
                        </label>
                        <br/>
                        <label for="image">Image(s) (Les anciennes images seront supprimées) :
                            <input type="file" name="<?php echo INPUT; ?>[]" multiple accept="image/*"/>
                        </label>
                        <br/>

                        <label for='mailVisible'>
                            E-mail visible : <input type="checkbox" name='mailVisible' <?php
                            if ($article['mailvisible'] == 1) {
                                echo 'checked';
                            }
                            ?>/>                        
                        </label>

                        <label for='phoneVisible'>
                            Numero de Tel. visible : <input type="checkbox" name='phoneVisible' <?php
                            if ($article['phonevisible'] == 1) {
                                echo 'checked';
                            }
                            ?>/>                        
                        </label>

                        <label for='adressVisible'>
                            Adresse visible : <input type="checkbox" name='adressVisible' <?php
                            if ($article['adressvisible'] == 1) {
                                echo 'checked';
                            }
                            ?>/>                        
                        </label>
                        <br/>
                        <button type="submit" class="btn btn-success" name="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
