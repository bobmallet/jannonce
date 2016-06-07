<?php 
// Les constantes
require_once '../phpScript/constants.php';
// Les sessions
require_once '../phpScript/sessions.php';
// Les fonctions
require_once '../phpScript/function.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        
        <title></title>
    </head>
    <body>
        <?php
        //addAddress("AF", "city17", "street");
        insertUser("mallet", "bob", 0, "bob.mallet@gmail.com", "Super", "phone number", "AF", "city 17", "street 17");
        ?>
    </body>
</html>
