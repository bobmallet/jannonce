<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//constantes pour les privilèges
define('PRIV_ADMIN', 2);
define('PRIV_USER', 1);
define('PRIV_UNKNOWN', 0);

//image par defaut de l'utilisateur
define('DEFAULT_IMAGE_ID', 5);

//Upload d'image
define('INPUT', 'imgupload');
define('TARGET', './img/');     // Repertoire cible
define('MAX_SIZE', 10000000);   // Taille max en octets du fichier
define('WIDTH_MAX', 5000);      // Largeur max de l'image en pixels
define('HEIGHT_MAX', 5000);     // Hauteur max de l'image en pixels
