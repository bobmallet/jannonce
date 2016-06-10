<?php
/*
Fichier: register.php
Auteur: Kevin Zaffino
Date: 15/06/2016
Version:1.10
Description: Page d'enregistrement
Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
*/
require_once './phpScript/inc.all.php';

if(isLogged()){
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="CSS/font-awesome/css/font-awesome.css">
        <title>register</title>
    </head>
    <body>
        <?php
        
        include './menu/showmenu.php';

        // Si on a appuyé sur le bouton Valider
        if (isset($_REQUEST['register'])) {
            //var_dump($_FILES);
            
              $lastName = filter_input(INPUT_POST, 'lastname');
              $firstName = filter_input(INPUT_POST, 'firstname');
              $mail = filter_input(INPUT_POST, 'mail');
              $pwd = filter_input(INPUT_POST, 'pwd');
              $phone = filter_input(INPUT_POST, 'phone');
              $country = filter_input(INPUT_POST, 'country');
              $city = filter_input(INPUT_POST, 'city');
              $street = filter_input(INPUT_POST, 'street');
              $gender = filter_input(INPUT_POST, 'gender');
              $id_image = intval(imageUpload());
              
              insertUser($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street,$id_image);

             header('Location: login.php');
        }
        ?>
        <div class="container" style="margin-top:30px">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-default">
                    <div class = "panel-heading">
                        <h3 class = "panel-title">Inscription</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="#" enctype="multipart/form-data">
                            <label for="lastname">Nom :
                                <input type="text" class="form-control" name="lastname" id='lastname'>
                            </label>
                            <label for="firstname">Prenom :
                                <input type="text" class="form-control" name="firstname" id='firstname'>
                            </label>

                            <label for="mail">E-mail :
                                <input type="mail" class="form-control" name="mail" id='mail'>
                            </label>
                            <label for="pwd">mdp :
                                <input type="text" class="form-control" name="pwd" id='pwd'>
                            </label>
                            <label for="phone">Tel. :
                                <input type="text" class="form-control" name="phone" id='phone'>
                            </label>

                            <label for="adress">Adresse :
                                <div id='adress'>
                                    <!--<label for="country">Pays :
                                        <input type="text" class="form-control" id='country'>
                                    </label>-->
                                    <?php
                                    echo selectCountry();
                                    ?>
                                    <label for="city">Ville :
                                        <input type="text" class="form-control" name="city" id='city'>
                                    </label>
                                    <label for="street">Rue :
                                        <input type="text" class="form-control" name="street" id='street'>
                                    </label>
                                </div>
                            </label>

                            <label for="gender">Genre :
                                <select name="gender" class="form-control" name="gender" id="gender">
                                    <option value="1">Homme</option>
                                    <option value="0">Femme</option>
                                </select>
                            </label>
                            <br/>


                            <label for="image">Image de profil :
                                <input type="file" class="form-control" name="<?php echo INPUT; ?>" id='image'/>
                            </label>
                            <br/>
                            <button type="submit" class="btn btn-success" name="register">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



</body>
</html>
