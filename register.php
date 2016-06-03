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
                    <div class="col-md-5 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class = "panel-heading">
                                <h3 class = "panel-title">Inscription</h3>
                            </div>
                            <div class="panel-body">
                                <form role="form" method="get" action="#">
                                    <label for="lastname">Nom :
                                        <input type="text" class="form-control" id='lastname'>
                                    </label>
                                    <label for="firstname">Prenom :
                                        <input type="text" class="form-control" id='firstname'>
                                    </label>

                                    <label for="mail">E-mail :
                                        <input type="mail" class="form-control" id='mail'>
                                    </label>
                                    <label for="pwd">mdp :
                                        <input type="text" class="form-control" id='pwd'>
                                    </label>
                                    <label for="phone">Tel. :
                                        <input type="text" class="form-control" id='phone'>
                                    </label>

                                    <label for="adress">Adresse :
                                        <div id='adress'>
                                            <label for="country">Pays :
                                                <input type="text" class="form-control" id='country'>
                                            </label>
                                            <label for="city">Ville :
                                                <input type="text" class="form-control" id='city'>
                                            </label>
                                            <label for="street">Rue :
                                                <input type="text" class="form-control" id='street'>
                                            </label>
                                        </div>
                                    </label>

                                    <label for="gender">Genre :
                                        <select name="gender" class="form-control" id="gender">
                                            <option value="Homme">Homme</option>
                                            <option value="Femme">Femme</option>
                                        </select>
                                    </label>
                                    <br/>


                                    <label for="image">Image de profil :
                                        <input type="file" class="form-control" id='image'>
                                    </label>
                                    <br/>
                                    <button type="submit" class="btn btn-success" name="submit">Valider</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </body>
</html>
