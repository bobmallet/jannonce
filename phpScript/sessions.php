<?php
session_start();
?>

<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './phpScript/constants.php';

 
 /**
  * Est-ce que l'utilisateur est loggé
  * @return {boolean}   True is loggé, autrement false
  */
 function isLogged(){
     return (isset($_SESSION["logged"])) ? $_SESSION["logged"] : false;
 }
 
 function setLogged(){
     $_SESSION['logged'] = true;
 }
 
 
 function getPrivilege(){
     return (isset($_SESSION["privilege"])) ? $_SESSION["privilege"] : PRIV_UNKNOWN;
 }
 
 function setPrivilege($value){
     $_SESSION["privilege"] = $value;
 }
 
 
 function setImagePath($path){
     $_SESSION['image'] = $path;
 }
 
 function getImagePath(){
     return (isset($_SESSION["image"])) ? $_SESSION["image"] : NULL;
 }
 
 
 
 function isAdmin(){
     return getPrivilege() == PRIV_ADMIN;
 }
 
 
  function isUser(){
     return getPrivilege() == PRIV_USER;
 }

 
 function getUserID(){
     return (isset($_SESSION["uid"])) ? $_SESSION["uid"] : -1;
 }
 
 function setUserID($uid){
     $_SESSION["uid"] = $uid;
 }

 
 function getUserName(){
     return (isset($_SESSION["uname"])) ? $_SESSION["uname"] : "";
 }
 
 function setUserName($name){
     $_SESSION["uname"] = $name;
 }
 
 
