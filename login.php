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
        <link rel="stylesheet" type="text/css" href="CSS/font-awesome/css/font-awesome.css">
        <title>login</title>
    </head>
    <body>
        <?php
        include './menu/defaultMenu.html';
        ?>
        <div class="container" style="margin-top:30px">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form role="form" method="get" action="#">
                            <div class="form-group">
                                <label for="mail" class="sr-only">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="email" class="form-control" id="mail"
                                           placeholder="Entrez votre adresse email" name="uid">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pwd" class="sr-only">Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" class="form-control" id="pwd"
                                           placeholder="Mot de passe" name="pwd">
                                </div>                              
                            </div>
                            <button type="submit" class="btn btn-success" name="submit">Connexion</button>
                            <a href="#" class="btn btn-primary" role="button">Pas encore inscrit ?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
