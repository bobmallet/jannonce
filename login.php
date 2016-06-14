<?php
/*
  Fichier: login.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Page de login du site
  Copyright (TPI 2016 - Kevin Zaffino © 2016)
 */
require_once './phpScript/inc.all.php';
if (isLogged()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <title>login</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';

        $error = "";

        if (isset($_REQUEST['login'])) {

            $mail = filter_var($_REQUEST['mail'], FILTER_SANITIZE_EMAIL);
            $pwd = filter_var($_REQUEST['pwd'], FILTER_SANITIZE_SPECIAL_CHARS);

            $error = checkLogin($mail, $pwd);
        }
        ?>
        <div class="container" style="margin-top:30px">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="#">
                            <div class="form-group">
                                <label for="mail" class="sr-only">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="email" class="form-control" id="mail"
                                           placeholder="Entrez votre adresse email" name="mail" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pwd" class="sr-only">Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" class="form-control" id="pwd"
                                           placeholder="Mot de passe" name="pwd" required>
                                </div>                              
                            </div>
                            <button type="submit" class="btn btn-success" name="login">Connexion</button>
                            <a href="register.php" class="btn btn-primary" role="button">Pas encore inscrit ?</a>
                        </form>
                    </div>
                </div>
                <?php if($error){ ?>
                <div class="alert alert-warning">
                    <strong>Attention!</strong> Identifiants incorrects.
                </div>
                
                <?php } ?>
            </div>
        </div>
    </body>
</html>
