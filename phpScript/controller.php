<?php
/*
Fichier: controller.php
Auteur: Kevin Zaffino
Date: 15/06/2016
Version:1.10
Description: Gere les input du site
Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
*/

//require_once './inc.all.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*
function checkLogin($mail, $pwd) {
    $error = TRUE;
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
        $error = "Identifiants incorrect";
    }
    return $error;
}
*/