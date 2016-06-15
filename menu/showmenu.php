<?php

/*
  Fichier: showmenu.php
  Auteur: Kevin Zaffino
  Date: 15/06/2016
  Version:1.10
  Description: Gere l'affichage des menus
  Copyright (TPI 2016 - Kevin Zaffino © 2016)
 */

if (isset($_REQUEST['logout'])) {
    logOut();
}

switch (getPrivilege()) {
    case 0:
        include './menu/defaultMenu.html';
        break;
    case 1:
        include './menu/authMenu.html';
        break;
    case 2:
        include './menu/adminMenu.html';
        break;
}
