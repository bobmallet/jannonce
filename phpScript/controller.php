<?php

/*
  Fichier: controller.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Gere les input du site
  Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
 */

function checkLogin($mail, $pwd) {
    $msg = TRUE;
    if (login($mail, $pwd)) {
        $userinfo = getUserInfo(login($mail, $pwd));
        $adress = $userinfo['street'] . " " . $userinfo['city'] . ", " . $userinfo['country'];
        //var_dump($userinfo);
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

function checkRegister($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $id_image) {

    insertUser($lastName, $firstName, $gender, $mail, $pwd, $phone, $country, $city, $street, $id_image);
    header('Location: login.php');
}

function checkNewArticle($name, $description, $price, $date, $mvis, $pvis, $avis) {
    $uid = getUserID();
    return insertArticle($name, $description, $price, $date, $uid, $mvis, $pvis, $avis);
}

function checkEditArticle($id, $name, $description, $price, $mvis, $pvis, $avis) {
    editArticleInfo($id, $name, $description, $price, $mvis, $pvis, $avis);
    header('Location: articles.php?idarticle=' . $id);
}

function checkAccountEdit(){
    
}