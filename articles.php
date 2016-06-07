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
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <title>Annonce</title>
    </head>
    <body>
        <?php
        include './menu/showmenu.php';
        $aid = intval($_REQUEST['idarticle']);
               
        
        
        ?>
        <div class="panel" id='article'>
            <div class="panel-body">
                <div class="pull-left col-lg-4">
                    <iframe src="articleImages.php?id=<?php echo $aid; ?>" width="100%" height="400">                        
                    </iframe>
                </div>
                <div class="col-lg-4">
                    <label for="description">Libelle ddddddddd</label>

                    <div id='description'>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation
                    </div>

                    <br/><br/>
                    <label for="description">Prix : 0000</label>
                </div>
                <div id="info" class="pull-right col-lg-4">
                    Createur del'annonce : <?php echo $_SESSION['uname'] ?>
                    <br/>
                    Le : 00/00/0000
                    <br/><br/>

                    Tel. :
                    <br/>
                    E-mail :
                    <br/>
                    Adresse :
                    <br/><br/><br/>

                    Etat de l'annonce : Ouvert
                </div>

            </div>
        </div>
        <!--##############################################################################################-->
        <div id="articles" class = "panel panel-primary">
            <div class = "panel-heading">
                <h3 class = "panel-title">Commentaire(s)</h3>
            </div>
            <div class = "panel-body">
                <div id='comments' class="col-lg-12">
                    <ul class="media-list forum">
                        <!-- Forum Post -->
                        <li class="media well">
                            <div class="pull-left user-info col-lg-1" href="#">
                                <img class="avatar img-circle img-thumbnail" src="./img/Koala.jpg"
                                     width="64" alt="Generic placeholder image">
                                <br/>
                                <strong><a href="user.html">Prenom N.</a></strong>
                                <small>Membre</small>
                                <br>

                            </div>
                            <div class="media-body">

                                <!-- Post Text -->
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero.qqqqq
                                <!-- Post Text EMD -->
                            </div>
                            <div id='postOptions' class="media-right">
                                00/00/0000
                                <br/>
                                <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-exclamation-sign"></i></span></a>
                                <br/>
                                <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-remove-sign"></i></span></a>
                            </div>
                        </li>
                        <!-- Forum Post END -->
                        <!-- Forum Post -->
                        <li class="media well">
                            <div class="pull-left user-info col-lg-1" href="#">
                                <img class="avatar img-circle img-thumbnail" src="http://snipplicious.com/images/guest.png"
                                     width="64" alt="Generic placeholder image">
                                <br/>
                                <strong><a href="user.html">Prenom N.</a></strong>
                                <small>Membre</small>
                                <br>

                            </div>
                            <div class="media-body">

                                <!-- Post Text -->
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero.qqqqq
                                <!-- Post Text EMD -->
                            </div>
                            <div id='postOptions' class="media-right">
                                00/00/0000
                                <br/>
                                <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-exclamation-sign"></i></span></a>
                                <br/>
                                <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-remove-sign"></i></span></a>
                            </div>
                        </li>
                        <!-- Forum Post END -->
                        <!-- Forum Post -->
                        <li class="media well">
                            <div class="pull-left user-info col-lg-1" href="#">
                                <img class="avatar img-circle img-thumbnail" src="http://snipplicious.com/images/guest.png"
                                     width="64" alt="Generic placeholder image">
                                <br/>
                                <strong><a href="user.html">Prenom N.</a></strong>
                                <small>Membre</small>
                                <br>

                            </div>
                            <div class="media-right">
                                <form role="form" action="#">                            
                                    <textarea id='txt' rows="5" cols="100" maxlength="500"></textarea>
                                    <br/>
                                    <button type="submit" class="btn btn-success" name="submit">Envoyer</button>
                                </form>

                            </div>
                        </li>
                        <!-- Forum Post END -->

                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
