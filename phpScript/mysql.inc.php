<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//constante
define('DB_HOST', 'localhost');
define('DB_NAME', 'jannonce_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

//gestion des session
session_start();

if (!isset($_SESSION["logged"])) {
    $_SESSION["logged"] = FALSE;
}

if (!isset($_SESSION["privilege"])) {
    $_SESSION["privilege"] = NULL;
}

if (!isset($_SESSION["uid"])) {
    $_SESSION["logged"] = NULL;
}

if (!isset($_SESSION["uname"])) {
    $_SESSION["logged"] = FALSE;
}

if (!isset($_SESSION["img"])) {
    $_SESSION["img"] = NULL;
}