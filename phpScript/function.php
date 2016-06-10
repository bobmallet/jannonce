<?php

/*
  Fichier: function.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Contient les différentes fonctions
  Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
 */

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
 * @param string $country
 * @param string $city
 * @param string $street
 * @return int  => le dernier id ajouté dans la base
 */
function addAddress($country, $city, $street) {

    //Prepared statements
    static $ps_adress = null;
    static $ps_id = null;

    //query
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
    } catch (PDOException $e) {
        $isok = null;
    }
    return $isok;
}

/**
 * Insére un nouvel utilisateur dans la base de données
 * @param string $lastName    Le nom de famille
 * @param string $firstName   Le prénom
 * @param string $gender      Le genre
 * @param string $mail        Le email
 * @param string $pwd         Le mot de passe pas encore crypté
 * @param string $phone       Le numero de telephone
 * @param string $country     Le code ISO du pays
 * @param string $city        Le nom de la ville
 * @param string $street      Le nom de la rue
 * @param int $image          L'id de l'image
 * @return boolean  True si correctement ajouté, autrement False.
 */
function insertUser($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $image = DEFAULT_IMAGE_ID) {

    //Prepared statements
    static $ps_user = null;

    //Query
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

        $isok = $ps_user->execute();
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Verification des identifiants de l'utilisateur
 * @staticvar type $ps
 * @param string $mail      L'adresse email
 * @param string $pwd       Le mot de passe pas encore crypté
 * @return boolean
 */
function login($mail, $pwd) {

    //Prepared statement
    static $ps = null;

    //Query
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
 * Deconnect l'utilisateur
 */
function logOut() {
    destroySession();
    header('Location: index.php');
}

/**
 * Retourne un tableau avec les infos de l'utilisateur
 * @staticvar type $ps
 * @param int $id   Id de l'utilisateur
 * @return Array    Tableau associatif contenant les données de l'utilisateur
 */
function getUserInfo($id) {
    //Prepared statement
    static $ps = null;

    //Query
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
 * Inverse l'etat de bannissement de l'utilisateur
 * @staticvar type $ps
 * @param int $uid      Identifiant de l'utilisateur
 * @return boolean
 */
function banUnbanUser($uid) {
    $banstate = getUserInfo($uid)['banned'];
    $finalestate = ($banstate == "0") ? 1 : 0;

    //Prepared statement
    static $ps = null;

    //Query
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
 * @param string $lastName      Nom de l'utilisateur
 * @param string $firstName     Prenom de l'utilisateur
 * @param Bool $gender          Genre de l'utilisateur (0 pour Femme et 1 pour Homme)
 * @param string $mail          Email de l'utilisateur
 * @param string $phone         Numero de telephone de l'utilisateur
 * @param int $id               Identifiant d el'utilisateur
 * @return boolean
 */
function updateUserInfo($lastName, $firstName, $gender, $mail, $phone, $id) {

    //Prepared statement
    static $ps = null;

    //Query
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
 * @param int $id
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
 * @param int $id                   Identifiant de l'utilisateur
 * @param string $countryiso        Code ISO du pays
 * @param string $city              Nom de la ville
 * @param string $street            Nom de la rue
 * @return boolean
 */
function updateUserAdress($id, $countryiso, $city, $street) {

    //Prepared stateent
    static $ps = null;

    //Query
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
 * Retourne un tableau avec tous les utilisateurs
 * @staticvar type $ps
 * @return array        Tableau associatif contenant tous les utilisateurs
 */
function getAllUser() {
    static $ps = null;

    $sql = "SELECT id, firstname as Prenom,lastname as Nom,mail, banned as Bannis FROM user_info WHERE privilege=1;";

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
 * Insert une nouvelle annonce dans la base de donnée
 * @staticvar type $ps
 * @param string $name          libelle de l'annonce  
 * @param string $description   Description de l'annonce
 * @param string $price         Prix de l'annonce   
 * @param string $date          Date de creation de l'annonce
 * @param string $uid           Identifiant du créateur de l'annonce
 * @param bool $mailvisible     Email visible ou non
 * @param bool $phonevisible    Numero de telephone visible ou non
 * @param bool $adressvisible   Adresse visible ou non
 * @return boolean
 */
function insertArticle($name, $description, $price, $date, $uid, $mailvisible, $phonevisible, $adressvisible) {

    //Prepared statements
    static $ps = null;
    static $ps_id = null;

    //Query
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
 * Edition des informations d'une annonce
 * @staticvar type $ps
 * @param int $idarticle            Identifiant de l'annonce a editer
 * @param string $name              Libelle del'annonce
 * @param string $description       Description del'annonce
 * @param string $price             Prix de l'annonce
 * @param bool $mailvisible         Email visible ou non
 * @param bool $phonevisible        Numero de telephone visible ou non
 * @param bool $adressvisible       Adresse visible ou non
 * @return boolean
 */
function editArticleInfo($idarticle, $name, $description, $price, $mailvisible, $phonevisible, $adressvisible) {

    //Prepared statement
    static $ps = null;

    //Query
    $sql = 'update articles set name=:name ,description=:description ,price=:price ,mailvisible=:mvis, phonevisible=:pvis ,adressvisible =:avis where id=:id';

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {

        $ps->bindParam(':name', $name, PDO::PARAM_STR);
        $ps->bindParam(':description', $description, PDO::PARAM_STR);
        $ps->bindParam(':price', $price, PDO::PARAM_STR);
        $ps->bindParam(':mvis', $mailvisible, PDO::PARAM_INT);
        $ps->bindParam(':pvis', $phonevisible, PDO::PARAM_INT);
        $ps->bindParam(':avis', $adressvisible, PDO::PARAM_INT);
        $ps->bindParam(':id', $idarticle, PDO::PARAM_INT);


        $isok = $ps->execute();

        return $isok;
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Insert une image de l'article dans la base de données
 * @staticvar type $ps
 * @param int $aid      Identifiant de l'article
 * @param int $iid      Identifiant de l'image
 * @return boolean
 */
function insertArticleImage($aid, $iid) {
    //Prepared statement
    static $ps = null;

    //Query
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
 * Retourne image des articles en fonction de l'id de l'article
 * @staticvar type $ps
 * @param int $idarticle    Identifiant d el'article
 * @return boolean
 */
function articleImages($idarticle) {
    //Prepared statement
    static $ps = null;

    //Query
    $sql = 'SELECT id, path FROM images where images.id_articles = :id';

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

/**
 * Ovre/Ferme un article
 * @staticvar type $ps
 * @param int $aid      Identifiant del'article
 * @return boolean
 */
function openCloseArticle($aid) {
    //Recuperation des infos de l'article
    $banstate = articleInfo($aid)['state'];
    $finalestate = ($banstate == "0") ? 1 : 0;

    //prepared statement
    static $ps = null;

    //Query
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

/**
 * Ban/Unban un article
 * @staticvar type $ps
 * @param int $aid          Identifiant de l'article
 * @return boolean
 */
function banunbanArticle($aid) {
    $banstate = articleInfo($aid)['banned'];

    $finalestate = ($banstate == "0") ? 1 : 0;

    //Prepared statement
    static $ps = null;

    //Query
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

    //Prepared statement
    static $ps = null;

    //Query
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

    //Prepared statement
    static $ps = null;

    //Query
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
 * Recupere toutes les annonces d'un utilisateur en particulier
 * @staticvar type $ps
 * @param int $uid         Identifiant dle'utilisateur
 * @return boolean
 */
function getUserArticles($uid) {

    //Prepared statement
    static $ps = null;

    //Query
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
 * @param int $id       $identifiant de l'article
 * @return boolean
 */
function articleInfo($id) {

    //Prepared statement
    static $ps = null;

    //Query
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

//gestion des commentaires

/**
 * Ajoute un commentaire dans la base
 * @staticvar type $ps
 * @param int $uid          Identifiant de l'utilisateur
 * @param int $aid          Identifiant de l'article
 * @param string $date      Date du commentaire
 * @param string $com       Texte du commentaire
 * @return boolean
 */
function addComment($uid, $aid, $date, $com) {

    //Prepared statement
    static $ps = null;

    //Query
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
 * @param int $aid          Identifiant de l'annonce
 * @return boolean
 */
function getArticleComments($aid) {

    //Prepared statement
    static $ps = null;

    //Query
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
 * Inverse l'etat du commentaire (en attente de moderation ou non)
 * @staticvar type $ps
 * @param int $idcomment        Identifiant du commentaire
 * @param bool $state           Valeur a assigner
 * @return boolean
 */
function changeComState($idcomment, $state) {

    //Prepared statement
    static $ps = null;

    //Query
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
 * @param int $idcomment        Identifiant du commentaire
 * @return boolean
 */
function banComment($idcomment) {

    //Prepared statement
    static $ps = null;

    //Query
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
 * @return int      Identifiant de l'image
 */
function insertImage($path, $idarticle = FALSE) {

    //Prepared statements
    static $ps_image = null;
    static $ps_id = null;


    //Query
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

    //Extensions autorisées
    $extArray = array('jpg', 'gif', 'png', 'jpeg');

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
 * Récupere tous les pays
 * @staticvar type $ps
 * @return boolean
 */
function getAllCountry() {

    //Prepared statement
    static $ps = null;

    //Query
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

//utilisaé pour les annonces

/**
 * Parcour le $_FILE pour envoyer toute les images dans un article
 * @param int $id_article       Identifiant de l'article
 * @return boolean
 */
function multiUpload($id_article) {

    //Nombre d'image 
    $nb = count($_FILES[INPUT]['name']);
    for ($i = 0; $i < $nb; $i++) {
        $name = uniqid();
        $extension_upload = strtolower(substr(strrchr($_FILES[INPUT]['name'][$i], '.'), 1));
        $destination = TARGET . $name . "." . $extension_upload;
        //deplacement des fichiers
        move_uploaded_file($_FILES[INPUT]['tmp_name'][$i], $destination);
        //insertion del'image dans la base
        insertImage($destination, $id_article);
    }
    return TRUE;
}

/**
 * Supprime toutes les images d'un article dans la base de donnée
 * @staticvar type $ps
 * @param int $id_article       Identifiant del'article
 */
function deleteArticleImages($id_article) {
    //Prepared statement
    static $ps = null;

    //Query
    $sql = "update images set id_articles=NULL where id=:id";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    $imgid = articleImages($id_article);

    foreach ($imgid as $value) {
        $id = intval($value['id']);

        $ps->bindParam(':id', $id, PDO::PARAM_INT);
        $ps->execute();
    }
}

function editImagePath($id_image, $newpath) {
    static $ps = null;

    $sql = "update images set images.path = :path where images.id = :id";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':path', $newpath, PDO::PARAM_STR);
        $ps->bindParam(':id', $id_image, PDO::PARAM_INT);

        $isok = $ps->execute();
    } catch (PDOException $ex) {
        $isok = false;
    }

    return $isok;
}

function changeUserImage($user_id, $image_id) {
    static $ps = null;

    $sql = "update users set users.id_Images = :iid where users.id = :uid";

    if ($ps == null) {
        $ps = myDatabase()->prepare($sql);
    }

    try {
        $ps->bindParam(':iid', $image_id, PDO::PARAM_INT);
        $ps->bindParam(':uid', $user_id, PDO::PARAM_INT);

        $isok = $ps->execute();
    } catch (PDOException $ex) {
        $isok = false;
    }

    return $isok;
}
