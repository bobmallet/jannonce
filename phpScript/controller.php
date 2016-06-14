<?php

/*
  Fichier: controller.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Gere les input du site
  Copyright (TPI 2016 - Kevin Zaffino © 2016)
 */

/**
 * Recupere le mail et le mot de passe et effectue la verification
 * @param string $mail
 * @param string $pwd
 * @return string
 */
function checkLogin($mail, $pwd) {
    $msg = TRUE;
    if (login($mail, $pwd)) {
        $userinfo = getUserInfo(login($mail, $pwd));
        if ($userinfo['banned'] == '1') {
            return "error";
        }
        $adress = $userinfo['street'] . " " . $userinfo['city'] . ", " . $userinfo['country'];

        setPrivilege(intval($userinfo['privilege']));
        setImagePath($userinfo['path']);
        setUserID(intval($userinfo['id']));
        setUserName(formatUserName($userinfo['firstname'], $userinfo['lastname']));
        setUserMail($mail);
        setUserTel($userinfo['phone']);
        setUserAdress($adress);
        setLogged();

        header('Location: index.php');
    } else {
        $msg = "Identifiants incorrect";
    }
    return $msg;
}

/**
 * Recupere les infromations d'enregistrement et effectue le traitement
 * @param string $lastName
 * @param string $firstName
 * @param int $gender
 * @param string $mail
 * @param string $pwd
 * @param string $phone
 * @param string $country
 * @param string $city
 * @param string $street
 * @param int $id_image
 * @return boolean
 */
function checkRegister($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $id_image) {

    if (!insertUser($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $id_image)) {
        return FALSE;
    } else {
        header('Location: login.php');
    }
}

/**
 * Récupere les information de création d'annonce et effectue le traitement
 * @param string $name
 * @param string $description
 * @param string $price
 * @param string $date
 * @param bool $mvis
 * @param bool $pvis
 * @param bool $avis
 * @return bool
 */
function checkNewArticle($name, $description, $price, $date, $mvis, $pvis, $avis) {
    $uid = getUserID();
    return insertArticle($name, $description, $price, $date, $uid, $mvis, $pvis, $avis);
}

/**
 * Récupere les informations d'edition d'annonce et effectue le traitement
 * @param int $id
 * @param string $name
 * @param string $description
 * @param string $price
 * @param bool $mvis
 * @param bool $pvis
 * @param bool $avis
 */
function checkEditArticle($id, $name, $description, $price, $mvis, $pvis, $avis) {
    editArticleInfo($id, $name, $description, $price, $mvis, $pvis, $avis);
    header('Location: articles.php?idarticle=' . $id);
}

/**
 * Récupere les informations d'edition du compte et effectue le traitement
 * @param string $country
 * @param string $city
 * @param string $street
 * @param int $adressid
 * @param string $lastName
 * @param string $firstName
 * @param int $gender
 * @param string $mail
 * @param string $phone
 */
function checkAccountEdit($country, $city, $street, $adressid, $lastName, $firstName, $gender, $mail, $phone) {
    updateUserAdress($adressid, $country, $city, $street);
    updateUserInfo($lastName, $firstName, $gender, $mail, $phone, getUserID());
    header('Location: userPage.php');
}
