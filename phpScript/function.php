<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once './phpScript/mysql.inc.php';

/**
 * Créé un pointeur sur la base
 * @staticvar type $dbc
 * @return \PDO
 */
function myDatabase() {
    static $dbc = null;

    if ($dbc == null) {
        try {
            $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br />';
            echo 'N : ' . $e->getCode();
            die('Could not connect to MySQL');
        }
    }
    return $dbc;
}

//Gestion Utilisateurs
//ajoute l'adresse et retourne son id
function addAdress($data) {
    static $ps_adress = null;
    static $ps_id = null;

    $sql_adress = 'insert into adress (adress.country,adress.city,adress.street) values (:country,:city,:street);';
    $sql_id = 'select id from adress where country = :country and city = :city and street = :street';

    if ($ps_adress == null) {
        $ps_adress = myDatabase()->prepare($sql_adress);
    }

    if ($ps_id == null) {
        $ps_id = myDatabase()->prepare($sql_id);
    }

    try {
        $ps_adress->bindParam(':country', $data['country'], PDO::PARAM_STR);
        $ps_adress->bindParam(':city', $data['city'], PDO::PARAM_STR);
        $ps_adress->bindParam(':street', $data['street'], PDO::PARAM_STR);
        $ps_adress->execute();

        $ps_id->bindParam(':country', $data['country'], PDO::PARAM_STR);
        $ps_id->bindParam(':city', $data['city'], PDO::PARAM_STR);
        $ps_id->bindParam(':street', $data['street'], PDO::PARAM_STR);
        $isok = $ps_id->execute();
        $isok = $ps_id->fetchAll(PDO::FETCH_NUM);
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok[0][0];
}

function addUser($data) {


    static $ps_user = null;


    $sql_user = 'insert into users (users.firstname,users.lastname,users.gender,users.mail,users.phone,users.banned,users.password,users.id_Images,users.id_Adress) values (:firstname,:lastname:,:gender,:mail,:phone,0,:password,:idimage,:idadress);';



    if ($ps_user == null) {
        $ps_user = myDatabase()->prepare($sql_user);
    }

    $id_adress = intval(addAdress($data));
    //$id_image = intval(imageUpload());
    $id_image = 4;

    try {

//ajoute adresse et image mais pas user
        $ps_user->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
        $ps_user->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
        $ps_user->bindParam(':gender', $data['gender'], PDO::PARAM_INT);
        $ps_user->bindParam(':mail', $data['mail'], PDO::PARAM_STR);
        $ps_user->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $ps_user->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $ps_user->bindParam(':idimage', $id_image, PDO::PARAM_INT);
        $ps_user->bindParam(':idadress', $id_adress, PDO::PARAM_INT);

        //$ps_user->bindParam(':country', $data['country'], PDO::PARAM_STR);
        //$ps_user->bindParam(':city', $data['city'], PDO::PARAM_STR);
        //$ps_user->bindParam(':street', $data['street'], PDO::PARAM_STR);
        

        $isok = $ps_user->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

function login($data) {
    static $ps = null;

    $sql = 'select users.password from users where users.mail = :mail';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':mail', $data['mail'], PDO::PARAM_STR);
        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
        if ($isok[0]['password'] == $data['password']) {
            return true;
        }
    } catch (PDOException $e) {
        $isok = false;
    }
    return false;
}

function getUserInfo($id) {
    static $ps = null;
    $sql = 'select * from users_view where users_view.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $id, PDO::PARAM_INT);

        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok[0];
}

function setUserName($firstname, $lastname) {
    return ucfirst($firstname) . " " . substr(ucfirst($lastname), 0, 1) . ".";
}

// Upload Constants
define('INPUT', 'imgupload');
define('TARGET', './img/');   // Repertoire cible
define('MAX_SIZE', 10000000);   // Taille max en octets du fichier
define('WIDTH_MAX', 5000);      // Largeur max de l'image en pixels
define('HEIGHT_MAX', 5000);     // Hauteur max de l'image en pixels
//insert une image dans la base et retounr son id

function insertImage($path, $idarticle = FALSE) {
    static $ps_image = null;
    static $ps_id = null;


    if ($idarticle) {
        $sql_image = 'insert into images (path,images.id_articles) values (:path,:id)';
    } else {
        $sql_image = 'insert into images (path) values (:path)';
    }

    $sql_id = 'select id from images where path = :path';

    if ($ps_image == NULL) {
        $ps_image = myDatabase()->prepare($sql_image);
    }

    if ($ps_id == NULL) {
        $ps_id = myDatabase()->prepare($sql_id);
    }

    try {
        $ps_image->bindParam(':path', $path, PDO::PARAM_STR);
        if ($idarticle) {
            $ps_image->bindParam(':id', $idarticle, PDO::PARAM_INT);
        }

        $ps_image->execute();

        $ps_id->bindParam(':path', $path, PDO::PARAM_STR);

        $isok = $ps_id->execute();
        $isok = $ps_id->fetchAll(PDO::FETCH_NUM);
    } catch (PDOException $ex) {
        $isok = false;
    }

    return $isok[0][0];
}

function imageUpload() {

    $extArray = array('jpg', 'gif', 'png', 'jpeg');    // Extensions autorisées

    $ext = '';
    $error = '';
    $imageName = '';

//Si le dossier cible n'existe pas, alors on essaye de le créer
    if (!is_dir(TARGET)) {
        if (!mkdir(TARGET, 0755)) {
            exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
        }
    }

//Verification si le champ n'est pas vide
    if (!empty($_FILES[INPUT]['name'])) {

//recupère l'extension du fichier
        $ext = pathinfo($_FILES[INPUT]['name'], PATHINFO_EXTENSION);

//verification de l'extension
        if (in_array(strtolower($ext), $extArray)) {
            $infosImg = getimagesize($_FILES[INPUT]['tmp_name']);


//Verification du type de l'image
            if ($infosImg[2] >= 1 && $infosImg[2] <= 14) {


//Verification des dimensions et de la taille
                if (($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES[INPUT]['tmp_name']) <= MAX_SIZE)) {

                    if (isset($_FILES[INPUT]['error']) && UPLOAD_ERR_OK === $_FILES[INPUT]['error']) {

                        $imageName = uniqid() . '.' . $ext;

                        $_SESSION['ImageUploadDb'] = $imageName;

                        if (move_uploaded_file($_FILES[INPUT]['tmp_name'], TARGET . $imageName)) {
                            $path = TARGET . $imageName;
                            return insertImage($path);
                            //$error = 'Upload réussi !';
//return TRUE;
                        } else {
                            $error = 'Problème lors de l\'upload !';
                        }
                    } else {
                        $error = 'Une erreur interne a empêché l\'upload de l\'image';
                    }
                } else {
                    $error = 'Erreur dans les dimensions de l\'image !';
                }
            } else {
                $error = 'Le fichier à uploader n\'est pas une image !';
            }
        } else {
            $error = 'L\'extension du fichier est incorrecte !';
        }
    } else {
        $error = 'Image non renseignée!';
    }
}
