<?php
/*
  Fichier: modification.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Page d'edition des informations utilisateur
  Copyright (TPI 2016 - Kevin Zaffino © 2016)
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
        <link rel="stylesheet" type="text/css" href="CSS/font-awesome/css/font-awesome.css">
        <title>Modification</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';

        $data = getUserInfo(getUserID());


        // Si on a appuyé sur le bouton Valider
        if (isset($_REQUEST['change'])) {

            $lastName = filter_var($_REQUEST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
            $firstName = filter_var($_REQUEST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
            $mail = filter_var($_REQUEST['mail'], FILTER_SANITIZE_SPECIAL_CHARS);
            //$pwd = filter_var($_REQUEST['pwd'],FILTER_SANITIZE_SPECIAL_CHARS);
            $phone = filter_var($_REQUEST['phone'], FILTER_SANITIZE_SPECIAL_CHARS);
            $country = filter_var($_REQUEST['country'], FILTER_SANITIZE_SPECIAL_CHARS);
            $city = filter_var($_REQUEST['city'], FILTER_SANITIZE_SPECIAL_CHARS);
            $street = filter_var($_REQUEST['street'], FILTER_SANITIZE_SPECIAL_CHARS);
            $gender = filter_var($_REQUEST['gender'], FILTER_SANITIZE_SPECIAL_CHARS);

            if ($_FILES[INPUT]['name'] != '') {
                deleteFile(getImagePath());
                $id_image = intval(imageUpload());
                changeUserImage(getUserID(), $id_image);
                $userinfo = getUserInfo(getUserID());
                setImagePath($userinfo['path']);
            }

            checkAccountEdit($country, $city, $street, $data['id_Adress'], $lastName, $firstName, $gender, $mail, $phone);
        }
        ?>
        <div class="container" style="margin-top:30px">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-default">
                    <div class = "panel-heading">
                        <h3 class = "panel-title">Modification</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="#" enctype="multipart/form-data">
                            <label for="lastname">Nom :
                                <input type="text" class="form-control" name="lastname" id='lastname' value="<?php echo $data['lastname']; ?>" required/>
                            </label>
                            <label for="firstname">Prenom :
                                <input type="text" class="form-control" name="firstname" id='firstname' value="<?php echo $data['firstname']; ?>" required/>
                            </label>

                            <label for="mail">E-mail :
                                <input type="mail" class="form-control" name="mail" id='mail' value="<?php echo $data['mail']; ?>" required />
                            </label>
                            
                            <label for="phone">Tel. :
                                <input type="text" class="form-control" name="phone" id='phone' value="<?php echo $data['phone']; ?>">
                            </label>

                            <label for="adress">Adresse :
                                <div id='adress'>
                                    <?php
                                    echo selectCountry($data['country']);
                                    ?>
                                    <label for="city">Ville :
                                        <input type="text" class="form-control" name="city" id='city' value="<?php echo $data['city']; ?>">
                                    </label>
                                    <label for="street">Rue :
                                        <input type="text" class="form-control" name="street" id='street' value="<?php echo $data['street']; ?>">
                                    </label>
                                </div>
                            </label>

                            <label for="gender">Genre :
                                <select name="gender" class="form-control" name="gender" id="gender">
                                    <option value="1" <?php
                                    if ($data['gender'] == "1") {
                                        echo 'selected';
                                    }
                                    ?>>Homme</option>
                                    <option value="0" <?php
                                    if ($data['gender'] == "0") {
                                        echo 'selected';
                                    }
                                    ?>>Femme</option>
                                </select>
                            </label>
                            <br/>


                            <label for="image">Image de profil :
                                <input type="file" class="form-control" name="<?php echo INPUT; ?>" id='image' accept="image/*"/>
                            </label>
                            <br/>
                            <button type="submit" class="btn btn-success" name="change">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
