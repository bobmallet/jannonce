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

if (isLogged()) {
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

        $mailverif = TRUE;
        $error = "";

        // Si on a appuyé sur le bouton Valider
        if (isset($_REQUEST['register'])) {

            $lastName = filter_var($_REQUEST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
            $firstName = filter_var($_REQUEST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
            $mail = filter_var($_REQUEST['mail'], FILTER_SANITIZE_EMAIL);
            $pwd = filter_var($_REQUEST['pwd'], FILTER_SANITIZE_SPECIAL_CHARS);
            $phone = filter_var($_REQUEST['phone'], FILTER_SANITIZE_SPECIAL_CHARS);
            $country = filter_var($_REQUEST['country'], FILTER_SANITIZE_SPECIAL_CHARS);
            $city = filter_var($_REQUEST['city'], FILTER_SANITIZE_SPECIAL_CHARS);
            $street = filter_var($_REQUEST['street'], FILTER_SANITIZE_SPECIAL_CHARS);
            $gender = filter_var($_REQUEST['gender'], FILTER_SANITIZE_SPECIAL_CHARS);

            //$id_image = "qq";
            if ($_FILES[INPUT]['name'] != '') {
                $id_image = intval(imageUpload());
            } else {
                $id_image = DEFAULT_IMAGE_ID;
            }

            $mailverif = checkRegister($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $id_image);
            //var_dump($mailverif);
        }
        ?>
        <div class="container" style="margin-top:30px">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-default">
                    <div class = "panel-heading">
                        <h3 class = "panel-title">Inscription</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="#" enctype="multipart/form-data">
                            <label for="lastname">Nom* :
                                <input type="text" class="form-control" name="lastname" id='lastname' required>
                            </label>
                            <label for="firstname">Prenom* :
                                <input type="text" class="form-control" name="firstname" id='firstname' required>
                            </label>

                            <label for="mail">E-mail* :
                                <input type="email" class="form-control" name="mail" id='mail' required>
                            </label>

                            <?php if (!$mailverif) { ?>

                                <div class="alert alert-warning">
                                    <strong>Attention!</strong> Adresse email déja utilisée.
                                </div>

                            <?php } ?>

                            <label for="pwd">mdp* :
                                <input type="password" class="form-control" name="pwd" id='pwd' pattern=".{3,}" required title="3 characters minimum">
                            </label>
                            <label for="phone">Tel. :
                                <input type="text" class="form-control" name="phone" id='phone'>
                            </label>

                            <label for="adress">Adresse :
                                <div id='adress'>
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
                                <select name="gender" class="form-control" id="gender">
                                    <option value="1">Homme</option>
                                    <option value="0">Femme</option>
                                </select>
                            </label>
                            <br/>


                            <label for="image">Image de profil :
                                <input type="file" class="form-control" name="<?php echo INPUT; ?>" id='image' accept="image/*"/>
                            </label>
                            <br/>
                            <button type="submit" class="btn btn-success" name="register">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>




    </body>
</html>
