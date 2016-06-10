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
        
        //updateUserAdress(50, "MQ", "city", "street");
        //updateUserInfo("lastName", "firstName", 0, "asdfghjkl@gmail.com", "123456", 18);
        var_dump(articleImages(11));
        ?>

        <form method="post" action="#" enctype="multipart/form-data">
            <input type="file" name="imgupload[]" multiple/>
            <input type="submit" name="submit" value="Envoyer" />
        </form>


    </body>
</html>
