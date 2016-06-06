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
function &myDatabase() {
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

/**
 * Ajoute l'adresse dans la base
 * @staticvar type $ps_adress
 * @staticvar type $ps_id
 * @param type $data  => data['country']; data['city']; data['street']
 * @return int
 */
function addAdress($data) {
    static $ps_adress = null;
    static $ps_id = null;

    $sql_adress = 'insert into adress (adress.city,adress.street,adress.country_iso) values (:city,:street,:iso);';
    $sql_id = 'SELECT LAST_INSERT_ID()';

    if ($ps_adress == null) {
        $ps_adress = myDatabase()->prepare($sql_adress);
    }
    if ($ps_id == null) {
        $ps_id = myDatabase()->prepare($sql_id);
    }

    try {  
        $ps_adress->bindParam(':city', $data['city'], PDO::PARAM_STR);
        $ps_adress->bindParam(':street', $data['street'], PDO::PARAM_STR);
        $ps_adress->bindParam(':iso', $data['iso'], PDO::PARAM_STR);
        $ps_adress->execute();

        $ps_id->execute();
        $last_id = $ps_id->fetchAll(PDO::FETCH_NUM);
        
        return $last_id[0][0];

        /*
          $ps_id->bindParam(':country', $data['country'], PDO::PARAM_STR);
          $ps_id->bindParam(':city', $data['city'], PDO::PARAM_STR);
          $ps_id->bindParam(':street', $data['street'], PDO::PARAM_STR);
          $isok = $ps_id->execute();
          $isok = $ps_id->fetchAll(PDO::FETCH_NUM);
          $isok = $isok[0][0];
         * */
    } catch (PDOException $e) {
        $isok = null;
    }
    return $isok;
}

function addAddress($country,$city,$street) {
    static $ps_adress = null;
    static $ps_id = null;

    $sql_adress = 'insert into adress (adress.city,adress.street,adress.country_iso) values (:city,:street,:iso);';

    if ($ps_adress == null) {
        $ps_adress = myDatabase()->prepare($sql_adress);
    }
    if ($ps_id == null) {
        $ps_id = myDatabase()->prepare('SELECT LAST_INSERT_ID()');
    }

    try {  
        $ps_adress->bindParam(':city', $city, PDO::PARAM_STR);
        $ps_adress->bindParam(':street', $street, PDO::PARAM_STR);
        $ps_adress->bindParam(':iso', $country, PDO::PARAM_STR);
        $ps_adress->execute();

        $ps_id->execute();
        $last_id = $ps_id->fetchAll(PDO::FETCH_NUM);
        
        return $last_id[0][0];

        /*
          $ps_id->bindParam(':country', $data['country'], PDO::PARAM_STR);
          $ps_id->bindParam(':city', $data['city'], PDO::PARAM_STR);
          $ps_id->bindParam(':street', $data['street'], PDO::PARAM_STR);
          $isok = $ps_id->execute();
          $isok = $ps_id->fetchAll(PDO::FETCH_NUM);
          $isok = $isok[0][0];
         * */
    } catch (PDOException $e) {
        $isok = null;
    }
    return $isok;
}


function addUser($data) {
    
    static $ps_user = null;


    $sql_user = 'insert into users (users.firstname,users.lastname,users.gender,users.mail,users.phone,users.banned,users.password,users.id_Images,users.id_Adress) values (:firstname,:lastname,:gender,:mail,:phone,0,:password,:idimage,:idadress);';



    if ($ps_user == null) {
        $ps_user = myDatabase()->prepare($sql_user);
    }

    $id_adress = intval(addAdress($data));
    //$id_image = intval(imageUpload());

    try {

        $ps_user->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
        $ps_user->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
        $ps_user->bindParam(':gender', $data['gender'], PDO::PARAM_INT);
        $ps_user->bindParam(':mail', $data['mail'], PDO::PARAM_STR);
        $ps_user->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $ps_user->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $ps_user->bindParam(':idimage', $data['idimage'], PDO::PARAM_INT);
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

/**
 * Insére un nouvel utilisateur dans la base de données
 * @param type $lastName    Le nom de famille
 * @param type $firstName   Le prénom
 * @param type $gender      Le genre
 * @param type $mail        Le email
 * @param type $pwd         Le mot de passe pas encore crypté
 * @param type $phone       
 * @param type $country
 * @param type $city
 * @param type $street
 * @param type $image
 * @return boolean  True si correctement ajouté, autrement False.
 */
function insertUser($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $image=DEFAULT_IMAGE_ID) {
    
    static $ps_user = null;


    $sql_user = 'insert into users (users.firstname,users.lastname,users.gender,users.mail,users.phone,users.banned,users.password,users.id_Images,users.id_Adress) values (:firstname,:lastname,:gender,:mail,:phone,0,:password,:idimage,:idadress);';



    if ($ps_user == null) {
        $ps_user = myDatabase()->prepare($sql_user);
    }

    $id_adress = intval(addAddress($country,$city,$street));
    //$id_image = intval(imageUpload());

    try {

        $ps_user->bindParam(':firstname', $firstName, PDO::PARAM_STR);
        $ps_user->bindParam(':lastname', $lastName, PDO::PARAM_STR);
        $ps_user->bindParam(':gender', $gender, PDO::PARAM_INT);
        $ps_user->bindParam(':mail', $mail, PDO::PARAM_STR);
        $ps_user->bindParam(':phone', $phone, PDO::PARAM_STR);
        $ps_user->bindParam(':password', $pwd, PDO::PARAM_STR);
        $ps_user->bindParam(':idimage', $image, PDO::PARAM_INT);
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

/**
 * Reoturne un tableau avec les infos de l'utilisateur
 * @staticvar type $ps
 * @param type $id
 * @return Array
 */
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

function formatUserName($firstname, $lastname) {
    return ucfirst($firstname) . " " . substr(ucfirst($lastname), 0, 1) . ".";
}

function banUser($id) {
    static $ps = null;
    $sql = 'UPDATE `users` SET `banned` = 1 WHERE `id` = :id';
    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }
    try {
        $ps->bindParam(':id', $id, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

function unbanUser($id) {
    static $ps = null;
    $sql = 'UPDATE `users` SET `banned` = 0 WHERE `id` = :id';
    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }
    try {
        $ps->bindParam(':id', $id, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

function logOut() {
    session_destroy();
    header("Location: index.php");
}

//gestion des annonces
//image des articles en fonction de l'id de l'article
function articleImages($idarticle) {
    static $ps = null;
    $sql = 'SELECT path FROM images where images.id_articles = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $idarticle, PDO::PARAM_INT);
        $isok = $ps->execute();
        $isok = $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

function closeArticle($idarticle) {
    static $ps = null;

    $sql = 'update articles set articles.state = 0 where articles.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $idarticle, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

function openArticle($idarticle) {
    static $ps = null;

    $sql = 'update articles set articles.state = 1 where articles.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $idarticle, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

function banArticle($idarticle) {
    static $ps = null;

    $sql = 'update articles set articles.banned = 1 where articles.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $idarticle, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

function unbanArticle($idarticle) {
    static $ps = null;

    $sql = 'update articles set articles.banned = 0 where articles.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $idarticle, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

function getAllArticles() {
    static $ps = null;

    $sql = 'select * from articles';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $isok = $ps->execute();
        $isok = $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

//article actif et non bannis
function listArticles() {
    static $ps = null;

    $sql = 'SELECT * FROM articles where state = 1 and banned = 0 order by creationdate';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $isok = $ps->execute();
        $isok = $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

//gestion des commentaires
// Upload Constants
define('INPUT', 'imgupload');
define('TARGET', './img/');     // Repertoire cible
define('MAX_SIZE', 10000000);   // Taille max en octets du fichier
define('WIDTH_MAX', 5000);      // Largeur max de l'image en pixels
define('HEIGHT_MAX', 5000);     // Hauteur max de l'image en pixels

/**
 * Insert une image dans la base de donnée et retourne son id
 * @staticvar type $ps_image
 * @staticvar type $ps_id
 * @param string $path
 * @param int $idarticle (a specifier si on souhaite assigner l'image a un article)
 * @return string
 */
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

/**
 * Upload une image
 * @return type
 */
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


                        if (move_uploaded_file($_FILES[INPUT]['tmp_name'], TARGET . $imageName)) {
                            $path = TARGET . $imageName;
                            return insertImage($path);
                            //$error = 'Upload réussi !';
//return TRUE;
                        } else {
                            return $error = 'Problème lors de l\'upload !';
                        }
                    } else {
                        return $error = 'Une erreur interne a empêché l\'upload de l\'image';
                    }
                } else {
                    return $error = 'Erreur dans les dimensions de l\'image !';
                }
            } else {
                return $error = 'Le fichier à uploader n\'est pas une image !';
            }
        } else {
            return $error = 'L\'extension du fichier est incorrecte !';
        }
    } else {
        return $error = 'Image non renseignée!';
    }
}

/**
 * Converti un tableau php en table html.
 * Le paramètre facultatif $assoc permet d'afficher une ligne d'entete si le tableau est associatif.
 * @param array $anArray Un tableau php (indexé ou associatif)
 * @param boolean $assoc (true si le tableau est associatif)
 * @return string Une chaîne qui contient un tableau html indenté.
 */
function Array2Html($anArray, $assoc = false) {
    $output = "\n<table class=\"table table-bordered\">";
    $lig = 0;

    // Si le tableau est associatif, la première ligne contient le nom des colonnes
    if ($assoc) {
        $firstLine = true;
        foreach ($anArray as $line) {
            if ($firstLine) {
                $output .= "\n <tr>";
                // affiche les entetes en th
                foreach ($line as $key => $value) {
                    $output .= "\n <th>" . $key . "</th>";
                }
                $output .= "\n </tr>";
                $output .= "\n <tr>";
                // affiche les entetes en th
                foreach ($line as $key => $value) {
                    $output .= "\n <td>" . $value . "</td>";
                }
                $output .= "\n </tr>";
                $firstLine = false;
            } else {
                if (($lig++ % 2) == 1)
                    $output .= "\n <tr>";
                else
                    $output .= "\n <tr class = \"odd\">";
// affiche les entetes en td
                foreach ($line as $key => $value) {
                    $output .= "\n    <td>" . $value . "</td>";
                }
                $output .= "\n  </tr>";
            }
        }
    } else {
// Tableau indexé
        for ($lig = 0; $lig < count($anArray); $lig++) {
            if (($lig % 2) == 0)
                $output .= "\n  <tr>";
            else
                $output .= "\n  <tr class=\"odd\">";
// Compte le nombre de colonnes
            for ($col = 0; $col < count($anArray[$lig]); $col++) {
                $output .= "\n    <td>" . $anArray[$lig][$col] . "</td>";
            }
            $output .= "\n  </tr>";
        }
    }

// Compte le nombre de lignes
    $output .= "\n</table>";
    return $output;
}

function getAllCountry() {
    static $ps = null;

    $sql = 'select * from country order by name';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $isok = $ps->execute();
        $isok = $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

function selectCountry() {
    $output = "\n<select name=\"country\" class=\"form-control\" id=\"country\">";
    foreach (getAllCountry() as $value) {
        $output .="\n<option value=\"" . $value['iso'] . "\">" . $value['name'] . "</option>";
    }

    $output .= "\n</select>";

    return $output;
}
