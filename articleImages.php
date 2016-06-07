<?php
require_once './phpScript/inc.all.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <base target="_parent" />
        <?php
        $id = intval($_REQUEST['id']);
        $img = articleImages($id);

        foreach ($img as $value) {
            echo '<a href="'.$value['path'].'"><img alt="Image" src="' . $value['path'] . '" width="100%"></a>';
        }
        ?>

        
    </body>
</html>
