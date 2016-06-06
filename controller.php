<?php
require_once './phpScript/inc.all.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if (isset($_REQUEST['register'])) {
    checkRegister();
}

function checkLogin() {
    
}

function checkRegister() {
    $lastName = filter_input(INPUT_POST, 'lastname');
    $firstName = filter_input(INPUT_POST, 'firstname');
    $mail = filter_input(INPUT_POST, 'mail');
    $pwd = filter_input(INPUT_POST, 'pwd');
    $phone = filter_input(INPUT_POST, 'phone');
    $country = filter_input(INPUT_POST, 'country');
    $city = filter_input(INPUT_POST, 'city');
    $street = filter_input(INPUT_POST, 'street');
    $gender = filter_input(INPUT_POST, 'gender');

    
        $data['country'] = $country;
        $data['city'] = $city;
        $data['street'] = $street;
        $id_adress = intval(addAdress($data));
        
        $id_image = intval(imageUpload());
        
        
        $data['lastname'] = $lastName;
        $data['firstname'] = $firstName;
        $data['gender'] = intval($gender);
        $data['mail'] = $mail;
        $data['phone'] = $phone;
        $data['password'] = $pwd;
        $data['idimage'] = $id_image;
        $data['idadress'] = $id_adress;
        
        addUser($data);
        
        
        
    
    //$path = imageUpload();
}

function checkNewArticle() {
    
}
