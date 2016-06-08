<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if (isset($_REQUEST['logout'])) {
    destroySession();
    header('Location: index.php');
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