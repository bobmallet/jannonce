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

        //var_dump(getArticleComments(2));

        foreach (getArticleComments(2) as $value){
            print commentFormat($value);
        }
        //        
        //insertUser("mallet", "bob", 0, "bob.mallet@gmail.com", "Super", "phone number", "AF", "city 17", "street 17");
        //var_dump(login("bob.mallet@gmail.com", "Super"));
        //var_dump(getUserInfo(9));
        //var_dump(articleImages(2));
        // var_dump(getAllArticles());

        //var_dump(articleInfo(2));
        /*
        foreach (listArticles() as $value) {
            $path = articleImages(intval($value['id']))[0]['path'];
            print articleFormat($value, $path);
        }
*/
        //articleFormat($data, $imgpath)
        
        
        
        
        ?>




    </body>
</html>
