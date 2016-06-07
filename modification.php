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
        require_once './phpScript/inc.all.php';
        include './menu/showmenu.php';

        // Si on a appuyé sur le bouton Valider
        if (isset($_REQUEST['register'])) {

            $lastName = filter_input(INPUT_POST, 'lastname');
            $firstName = filter_input(INPUT_POST, 'firstname');
            $mail = filter_input(INPUT_POST, 'mail');
            $pwd = filter_input(INPUT_POST, 'pwd');
            $phone = filter_input(INPUT_POST, 'phone');
            $country = filter_input(INPUT_POST, 'country');
            $city = filter_input(INPUT_POST, 'city');
            $street = filter_input(INPUT_POST, 'street');
            $gender = filter_input(INPUT_POST, 'gender');

            //$id_image = intval(imageUpload());
            $id_image = 5;


            $data['lastname'] = $lastName;
            $data['firstname'] = $firstName;
            $data['gender'] = intval($gender);
            $data['mail'] = $mail;
            $data['phone'] = $phone;
            $data['password'] = $pwd;
            $data['idimage'] = $id_image;
            //$data['idadress'] = $id_adress;

            //var_dump($data);
            //addAdress($data);
            
            //addUser($data);
            insertUser($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street);
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
                                <input type="file" name="image" class="form-control" name="image" id='image'/>
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
