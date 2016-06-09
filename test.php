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
        //session_destroy();
        //var_dump(getArticleComments(2));
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
        //insertArticleImage(9, 17);
        //banUnbanUser(15);
        //var_dump(articleInfo(11));
        //banunbanArticle(11);
        //var_dump(articleInfo(15));

        

        function multiUpload($id_article) {
            
            $nb = count($_FILES[INPUT]['name']);
            for ($i = 0; $i < $nb; $i++) {
                $name = uniqid();
                $extension_upload = strtolower(substr(strrchr($_FILES[INPUT]['name'][$i], '.'), 1));
                $destination = TARGET . $name . "." . $extension_upload;
                move_uploaded_file($_FILES[INPUT]['tmp_name'][$i], $destination);
                insertImage($destination, $id_article);
            }
            return TRUE;
        }

        if (isset($_REQUEST['submit'])) {
            multiUpload();
        }
        ?>

        <form method="post" action="#" enctype="multipart/form-data">
            <input type="file" name="imgupload[]" multiple/>
            <input type="submit" name="submit" value="Envoyer" />
        </form>


    </body>
</html>
