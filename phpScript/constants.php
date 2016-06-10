<?php
/*
Fichier: constants.php
Auteur: Kevin Zaffino
Date: 15/06/2016
Version:1.10
Description: Contient les constantes du site
Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
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
