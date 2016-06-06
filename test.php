<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <title>test</title>
    </head>
    <body>
        <?php
        require_once './phpScript/inc.all.php';
        $data;
        $data['country'] = "country";
        $data['city'] = "city";
        $data['street'] = "street";
        $data['iso'] = "AD";
        $data['firstname'] = "firstname";
        $data['lastname'] = "lastname";
        $data['gender'] = 0;
        $data['mail'] = "mail";
        $data['phone'] = "phone";
        $data['password'] = "Super";

        //addUser($data);
        //var_dump (addAdress($data));
        //var_dump(addAddress($data['iso'],$data['city'],$data['street']));
        //print selectCountry();
        
        addUser($data);
        
        
        ?>


        

    </body>
</html>
