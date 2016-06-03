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

        <title>Nouvelle annonce</title>
    </head>
    <body>
        <?php
        include './menu/adminMenu.html';
        ?>
        <div class="panel panel-default">
            <div class = "panel-heading">
                <h3 class = "panel-title">Nouvelle annonce</h3>
            </div>
            <div class="panel-body">
                <form action="#">
                    <label for="title">Libelle :
                        <input type="text" class="form-control"/>
                    </label>
                    <br/>
                    <label for="description">Description :<br/>
                        <textarea id='description' rows="10" cols="50" maxlength="500"></textarea>
                    </label>
                    <br/>
                    <label for="price">Prix :
                        <input type="text" id='price'/>
                    </label>
                    <br/>
                    <label for="image">Image(s) :
                        <input type="file" id='image'/>
                    </label>
                    <br/>

                    <label for='mailVisible'>
                        E-mail visible : <input type="checkbox" id='mailVisible'/>                        
                    </label>

                    <label for='phoneVisible'>
                        Numero de Tel. visible : <input type="checkbox" id='phoneVisible'/>                        
                    </label>

                    <label for='adressVisible'>
                        Adresse visible : <input type="checkbox" id='adressVisible'/>                        
                    </label>
                    <br/>
                    <button type="submit" class="btn btn-success" name="submit">Envoyer</button>

                </form>

            </div>
        </div>
    </body>
</html>
