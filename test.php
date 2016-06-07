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
        
        if (isset($_REQUEST['submit'])) {
            $
        }

        
        
        insertArticle("qq", "ww", "ee", "datetime", 9, 1, 1, 1);
        
        //insertUser("mallet", "bob", 0, "bob.mallet@gmail.com", "Super", "phone number", "AF", "city 17", "street 17");
        //var_dump(login("bob.mallet@gmail.com", "Super"));
        //var_dump(getUserInfo(9));
        ?>

        <form action="#" method="post">
            <label for="title">Libelle :
                <input type="text" class="form-control"/>
            </label>
            <br/>
            <label for="description">Description :<br/>
                <textarea name='description' rows="10" cols="50" maxlength="500"></textarea>
            </label>
            <br/>
            <label for="price">Prix :
                <input type="text" name='price'/>
            </label>
            <br/>
            <label for="image">Image(s) :
                <input type="file" name='image'/>
            </label>
            <br/>

            <label for='mailVisible'>
                E-mail visible : <input type="checkbox" name='mailVisible'/>                        
            </label>

            <label for='phoneVisible'>
                Numero de Tel. visible : <input type="checkbox" name='phoneVisible'/>                        
            </label>

            <label for='adressVisible'>
                Adresse visible : <input type="checkbox" name='adressVisible'/>                        
            </label>
            <br/>
            <button type="submit" class="btn btn-success" name="submit">Envoyer</button>

        </form>

    </body>
</html>
