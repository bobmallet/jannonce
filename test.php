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
        <title></title>
    </head>
    <body>
        <?php
        include './menu/defaultMenu.html';        
        echo 'default';
        include './menu/authMenu.html';
        echo 'auth';
        include './menu/adminMenu.html';
        echo 'admin';
        ?>
        
    </body>
</html>
