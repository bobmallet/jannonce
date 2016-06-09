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
 * Ajoute une adresse dans la base
 * @staticvar type $ps_adress
 * @staticvar type $ps_id
 * @param type $country
 * @param type $city
 * @param type $street
 * @return type
 */
function addAddress($country, $city, $street) {
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
function insertUser($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $image = DEFAULT_IMAGE_ID) {

    static $ps_user = null;


    $sql_user = 'insert into users (users.firstname,users.lastname,users.gender,users.mail,users.phone,users.banned,users.password,users.id_Images,users.id_Adress, users.privilege) values (:firstname,:lastname,:gender,:mail,:phone,0,:password,:idimage,:idadress, :privilege);';



    if ($ps_user == null) {
        $ps_user = myDatabase()->prepare($sql_user);
    }

    $id_adress = intval(addAddress($country, $city, $street));

    $pwd_sha1 = sha1($pwd);
    $priv = PRIV_USER;
    try {

        $ps_user->bindParam(':firstname', $firstName, PDO::PARAM_STR);
        $ps_user->bindParam(':lastname', $lastName, PDO::PARAM_STR);
        $ps_user->bindParam(':gender', $gender, PDO::PARAM_INT);
        $ps_user->bindParam(':mail', $mail, PDO::PARAM_STR);
        $ps_user->bindParam(':phone', $phone, PDO::PARAM_STR);
        $ps_user->bindParam(':password', $pwd_sha1, PDO::PARAM_STR);
        $ps_user->bindParam(':idimage', $image, PDO::PARAM_INT);
        $ps_user->bindParam(':idadress', $id_adress, PDO::PARAM_INT);
        $ps_user->bindParam(':privilege', $priv, PDO::PARAM_INT);

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
 * Verification des identifiants de l'utilisateur 
 * @staticvar type $ps
 * @param type $data
 * @return boolean  retourne l'id de l'utilisateur si il existe, sinon retourne FALSE
 */
function login($mail, $pwd) {
    static $ps = null;

    $sql = 'select users.id, users.password from users where users.mail = :mail';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    $pwd_sha1 = sha1($pwd);

    try {
        $ps->bindParam(':mail', $mail, PDO::PARAM_STR);
        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
        if (isset($isok[0])) {
            if ($isok[0]['password'] == $pwd_sha1) {
                $isok = intval($isok[0]['id']);
            }
        } else {
            $isok = FALSE;
        }
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Reoturne un tableau avec les infos de l'utilisateur
 * @staticvar type $ps
 * @param type $id
 * @return Array
 */
function getUserInfo($id) {
    static $ps = null;
    $sql = 'select * from user_info where user_info.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $id, PDO::PARAM_INT);

        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
        $isok = $isok[0];
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Retourne les nom et le prenom avec le format "Prenom N."
 * @param type $firstname
 * @param type $lastname
 * @return (string) format Prenom N.
 */
function formatUserName($firstname, $lastname) {
    return ucfirst($firstname) . " " . substr(ucfirst($lastname), 0, 1) . ".";
}

/**
 * Inverse l'etat de bannissement de l'utilisateur
 * @staticvar type $ps
 * @param type $uid
 * @return boolean
 */
function banUnbanUser($uid) {
    $banstate = getUserInfo($uid)['banned'];
    $finalestate = ($banstate == "0") ? 1 : 0;

    static $ps = null;

    $sql = 'UPDATE `users` SET `banned` = :ban WHERE `id` = :id';
    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }
    try {
        $ps->bindParam(':ban', $finalestate, PDO::PARAM_INT);
        $ps->bindParam(':id', $uid, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Modifie les informations de l'utilisateur
 * @staticvar type $ps
 * @param type $lastName
 * @param type $firstName
 * @param type $gender
 * @param type $mail
 * @param type $pwd
 * @param type $phone
 * @param type $id
 * @return boolean
 */
function updateUserInfo($lastName, $firstName, $gender, $mail, $pwd, $phone, $id) {
    static $ps = null;

    $sql = "update users set users.firstname = :firstname ,users.lastname = :lastname ,users.gender = :gender ,users.mail = :mail ,users.phone = :phone where users.id = :id";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':firstname', $firstName, PDO::PARAM_STR);
        $ps->bindParam(':lastname', $lastName, PDO::PARAM_STR);
        $ps->bindParam(':gender', $gender, PDO::PARAM_INT);
        $ps->bindParam(':mail', $mail, PDO::PARAM_STR);
        $ps->bindParam(':phone', $phone, PDO::PARAM_STR);

        $ps->bindParam(':id', $id, PDO::PARAM_INT);

        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Modifie le chemin de l'avatar de l'utilisateur
 * @staticvar type $ps
 * @param type $id
 * @param type $path
 * @return boolean
 */
function updateUserImage($id, $path) {
    static $ps = null;

    $sql = "update images set images.path = :path where images.id = :id";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps_user->bindParam(':path', $city, PDO::PARAM_STR);
        $ps_user->bindParam(':id', $id, PDO::PARAM_INT);

        $isok = $ps_user->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Modifie l'adresse d'un utilisateur
 * @staticvar type $ps
 * @param type $id
 * @param type $countryiso
 * @param type $city
 * @param type $street
 * @return boolean
 */
function updateUserAdress($id, $countryiso, $city, $street) {
    static $ps = null;

    $sql = "update adress set adress.city = :city ,adress.street = :street ,adress.country_iso = :iso where adress.id = :id";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {

        $ps->bindParam(':city', $city, PDO::PARAM_STR);
        $ps->bindParam(':street', $street, PDO::PARAM_STR);
        $ps->bindParam(':iso', $countryiso, PDO::PARAM_STR);
        $ps->bindParam(':id', $id, PDO::PARAM_INT);


        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Retourne un tableau avec tous les utilisateurss
 * @staticvar type $ps
 * @return array
 */
function getAllUser() {
    static $ps = null;

    $sql = "SELECT id, firstname as Prenom,lastname as Nom,mail, banned as Bannis FROM user_info;";

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

//gestion des annonces

/**
 * Insert un nouvel article dans la base de donnée
 * @staticvar type $ps
 * @param type $name
 * @param type $description
 * @param type $price
 * @param type $date
 * @param type $uid
 * @param type $mailvisible
 * @param type $phonevisible
 * @param type $adressvisible
 * @return boolean
 */
function insertArticle($name, $description, $price, $date, $uid, $mailvisible, $phonevisible, $adressvisible) {
    static $ps = null;
    static $ps_id = null;


    $sql = 'insert into articles (name,description,price,state,creationdate,banned,id_Users,mailvisible,phonevisible,adressvisible) values (:name,:description,:price,1,:date,0,:uid,:mvis,:pvis,:avis)';


    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    if ($ps_id == null) {
        $ps_id = myDatabase()->prepare('SELECT LAST_INSERT_ID()');
    }


    try {
        $ps->bindParam(':name', $name, PDO::PARAM_STR);
        $ps->bindParam(':description', $description, PDO::PARAM_STR);
        $ps->bindParam(':price', $price, PDO::PARAM_STR);
        $ps->bindParam(':date', $date, PDO::PARAM_STR);
        $ps->bindParam(':uid', $uid, PDO::PARAM_INT);
        $ps->bindParam(':mvis', $mailvisible, PDO::PARAM_INT);
        $ps->bindParam(':pvis', $phonevisible, PDO::PARAM_INT);
        $ps->bindParam(':avis', $adressvisible, PDO::PARAM_INT);


        $isok = $ps->execute();

        $ps_id->execute();
        $last_id = $ps_id->fetchAll(PDO::FETCH_NUM);

        return intval($last_id[0][0]);
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Insert une image de l'article dans la base de données
 * @staticvar type $ps
 * @param type $aid
 * @param type $iid
 * @return boolean
 */
function insertArticleImage($aid, $iid) {

    static $ps = null;

    $sql = "update images set images.id_articles = :articleid where images.id = :imageid";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':articleid', $aid, PDO::PARAM_INT);
        $ps->bindParam(':imageid', $iid, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

/**
 * Retourne du code html pour afficher un article
 * @param type $data
 * @param type $imgpath
 * @return string
 */
function articleFormat($data, $imgpath) {
    $output = "\n<li class=\"media well\">";
    $output .= "\n<div class=\"pull-left col-lg-2\">";
    $output .= "\n<a href=\"articles.php?idarticle=" . $data['id'] . "\" class=\"thumbnail\">";
    $output .= "<img alt=\"Image\" src=\"" . $imgpath . "\">";
    $output .= "\n</a>";
    $output .= "\n</div>";
    $output .= "<div class=\"col-lg-6\">";
    $output .= "\n<b>" . $data['name'] . "</b>";
    $output .= "<br/><br/>";
    $output .= "\n<p>" . descriptionSize($data['description']) . "</p>";
    $output .= "\n</div>";
    $output .= "\n<div class=\"col-lg-4\">";
    $output .= "\nCréateur de l'annonce : ";
    $output .= "\n<br/><br/>";
    $output .= "\nLe " . $data['creationdate'];
    $output .= "\n<br/><br/>";
    $output .= "\nPrix : " . $data['price'];
    $output .= "\n</div>";
    $output .= "\n</li>";
    $output .= "\n</li>";

    return $output;
}

/**
 * Retourne image des articles en fonction de l'id de l'article
 * @staticvar type $ps
 * @param type $idarticle
 * @return boolean
 */
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

function openCloseArticle($aid) {
    $banstate = articleInfo($aid)['state'];
    $finalestate = ($banstate == "0") ? 1 : 0;

    static $ps = null;

    $sql = 'UPDATE `articles` SET `state` = :state WHERE `id` = :id';
    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }
    try {
        $ps->bindParam(':state', $finalestate, PDO::PARAM_INT);
        $ps->bindParam(':id', $aid, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

function banunbanArticle($aid) {
    $banstate = articleInfo($aid)['banned'];

    $finalestate = ($banstate == "0") ? 1 : 0;

    static $ps = null;

    $sql = "UPDATE `articles` SET `banned` = :ban WHERE `id` = :id";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }
    try {
        $ps->bindParam(':ban', $finalestate, PDO::PARAM_INT);
        $ps->bindParam(':id', $aid, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Recupere tous les annonces de la base
 * @staticvar type $ps
 * @return boolean
 */
function getAllArticles() {
    static $ps = null;

    $sql = 'select id, name as Libelle,description,price as Prix,state as Etat,creationdate as "Date de creation",banned as Bannis from articles';

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

/**
 * Recupere tous les articles qui sont actif et non bannis
 * @staticvar type $ps
 * @return boolean
 */
function listArticles() {
    static $ps = null;

    $sql = 'SELECT * FROM articles where state = 1 and banned = 0 order by creationdate DESC';

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

/**
 * Recupere toute les annonces d'un utilisateru en particulier
 * @staticvar type $ps
 * @param type $uid
 * @return boolean
 */
function getUserArticles($uid) {
    static $ps = null;

    $sql = 'SELECT * FROM articles where banned = 0 and articles.id_Users = :id order by creationdate';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $uid, PDO::PARAM_INT);
        $isok = $ps->execute();
        $isok = $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

/**
 * Retourne les informations d'un article
 * @staticvar type $ps
 * @param type $id
 * @return boolean
 */
function articleInfo($id) {
    static $ps = null;
    $sql = 'select * from articles where id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $id, PDO::PARAM_INT);

        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
        $isok = $isok[0];
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

/**
 * Retourne un string d'un certain nombre de charactère
 * @param type $desc
 * @return type
 */
function descriptionSize($desc) {
    return substr($desc, 0, 50) . "...";
}

//gestion des commentaires

/**
 * Ajoute un commentaire dans la base
 * @staticvar type $ps
 * @param type $uid
 * @param type $aid
 * @param type $date
 * @param type $com
 * @return boolean
 */
function addComment($uid, $aid, $date, $com) {
    static $ps = null;
    $sql = "insert into comments (comments.id_Users,comments.id_articles,comments.date_com,comments.comm,comments.state,comments.banned) values (:uid,:aid,:date,:com,1,0)";
    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':uid', $uid, PDO::PARAM_STR);
        $ps->bindParam(':aid', $aid, PDO::PARAM_STR);
        $ps->bindParam(':date', $date, PDO::PARAM_STR);
        $ps->bindParam(':com', $com, PDO::PARAM_STR);

        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Recupere les commentaires d'une annonce
 * @staticvar type $ps
 * @param type $aid
 * @return boolean
 */
function getArticleComments($aid) {
    static $ps = null;
    $sql = "select * from comments where id_articles = :id and comments.banned = 0";
    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $aid, PDO::PARAM_INT);
        $isok = $ps->execute();
        $isok = $isok = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

/**
 * Retourne du code html pout afficher le ocmmentaire
 * @param type $data
 * @param type $creatorid
 * @return string
 */
function commentFormat($data, $creatorid) {
    $uid = intval($data['id_Users']);
    $userinfo = getUserInfo($uid);

    if ($userinfo['privilege'] == "2") {
        $priv = "Admin";
    } else {
        $priv = "Membre";
    }

    if ($data['state'] == "1") {
        $comment = $data['comm'];
    } else {
        $comment = "Commentaire en attente de modération";
    }


    $btn = "";

    if (getUserID() == $creatorid) {
        $btn .= "<input type=\"submit\" name=\"state\" class=\"btn btn-warning\" value=\"!\" />";
    }

    if (getPrivilege() == PRIV_ADMIN) {
        $btn .= "<input type=\"submit\" name=\"ban\" class=\"btn btn-danger\" value=\"X\"/>";
    }

    $output = "    \n<li class=\"media well\">
                            \n<div class=\"pull-left user-info col-lg-1\">
                               \n <img class=\"avatar img-circle img-thumbnail\" src=\"" . $userinfo['path'] . "\"
                                     \nwidth=\"64\" alt=\"Generic placeholder image\">
                                \n<br/>
                                \n<strong><a href=\"user.html\">" . formatUserName($userinfo['firstname'], $userinfo['lastname']) . "</a></strong>
                               \n <br/><small>" . $priv . "</small>
                               \n <br>

                            \n</div>
                           \n <div class=\"media-body\">" .
            $comment
            . "\n </div>
                            \n<div id='postOptions' class=\"media-right\">
                                " . $data['date_com'] . "
                                \n<br/>"
            .
            "\n<form action=\"#\" method=\"post\">
                                    <input type=\"hidden\" name=\"comstate\" value=\"" . $data['state'] . "\"/>
                                    <input type=\"hidden\" name=\"idcom\" value=\"" . $data['id'] . "\"/>"
            . $btn .
            "</form>"
            .
            //\n<a href=\"#\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i></span></a>
            //\n<br/>
            //\n<a href=\"#\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-remove-sign\"></i></span></a>



            "\n</div>
                        \n</li>";

    return $output;
}

/**
 * Inverse l'etat du commentaire (en attente de moderation ou non)
 * @staticvar type $ps
 * @param type $idcomment
 * @param type $state
 * @return boolean
 */
function changeComState($idcomment, $state) {
    static $ps = null;

    $sql = 'update comments set comments.state = :state where comments.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $idcomment, PDO::PARAM_INT);
        $ps->bindParam(':state', $state, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

/**
 * Bannis un commentaire
 * @staticvar type $ps
 * @param type $idcomment
 * @return boolean
 */
function banComment($idcomment) {
    static $ps = null;

    $sql = 'update comments set comments.banned = 1 where comments.id = :id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':id', $idcomment, PDO::PARAM_INT);
        $isok = $ps->execute();
    } catch (PDOException $e) {
        $isok = false;
    }

    return $isok;
}

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

/**
 * Récupere tous les pays
 * @staticvar type $ps
 * @return boolean
 */
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

/**
 * Retourne du code html pout faire un select avec tous les pays
 * @param type $selectedcountry
 * @return string
 */
function selectCountry($selectedcountry = null) {
    $output = "\n<select name=\"country\" class=\"form-control\" id=\"country\">";
    foreach (getAllCountry() as $value) {

        if ($selectedcountry == $value['name']) {
            $selected = "selected";
        } else {
            $selected = "";
        }



        $output .="\n<option value=\"" . $value['iso'] . "\"" . $selected . ">" . $value['name'] . "</option>";
    }

    $output .= "\n</select>";

    return $output;
}




//utilisaé pour les annonces
function multiUpload($id_article) {

    $nb = count($_FILES[INPUT]['name']);
    for ($i = 0; $i < $nb; $i++) {
        $name = uniqid();
        $extension_upload = strtolower(substr(strrchr($_FILES[INPUT]['name'][$i], '.'), 1));
        $destination = TARGET . $name . "." . $extension_upload;
        move_uploaded_file($_FILES[INPUT]['tmp_name'][$i], $destination);
        insertImage($destination, $id_article);
    }
    return TRUE;
}
