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
        include './phpScript/function.php';
        $data;
        $data['country'] = "country";
        $data['city'] = "city";
        $data['street'] = "street";
        $data['firstname'] = "firstname";
        $data['lastname'] = "lastname";
        $data['gender'] = 0;
        $data['mail'] = "mail";
        $data['phone'] = "phone";
        $data['password'] = "Super";

        //addUser($data);
        //var_dump (addAdress($data));
        
        if(isset($_REQUEST['submit'])){
            var_dump($_FILES);
        }
        
        
        ?>

        
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="file" name="file" multiple/>
            <input type="submit" name="submit"/>
        </form>
        
        

    </body>
</html>
