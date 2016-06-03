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

        <title>User page</title>
    </head>
    <body>
        <?php
        include './menu/adminMenu.html';
        ?>

        <div class="panel" id='information'>
            <div class="panel-body">

                <div class="pull-left col-lg-2">
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                    </a>


                </div>
                <div class="col-lg-4">


                    <div id='description'>
                        Nom: Nom
                        <br/>
                        Prenom : Prenom
                        <br/>
                        Genre : Homme
                    </div>

                    
                </div>
                <div id="info" class="pull-right col-lg-4">
                    <div class="panel-default">
                        <div class = "panel-heading">
                            <h3 class = "panel-title">Contact</h3>
                        </div>
                        <div class="panel-body">
                            Createur del'annonce : Prenom N.
                            <br/>
                            Le : 00/00/0000
                            <br/><br/>
                            Tel. :
                            <br/>
                            E-mail :
                            <br/>
                            Adresse :
                            <br/><br/><br/>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--
        <div class="panel">
            <div class="pull-left col-lg-2">
                <a href="#" class="thumbnail">
                    <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                </a>
            </div>

            <div class="panel panel-default" class="pull-right">
                <div class = "panel-heading">
                    <h3 class = "panel-title">Contact</h3>
                </div>

                <div class="panel-body">
                    Tel. :
                    <br/>
                    E-mail :
                    <br/>
                    Adresse :
                    <br/>
                </div>
            </div>
        </div>

        -->









        <div id="articles" class = "panel panel-primary">
            <div class = "panel-heading">
                <h3 class = "panel-title">Mes annonce(s)</h3>
            </div>
            <div class = "panel-body">
                <ul class="media-list forum">
                    <!-- Forum Post -->
                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>
                    <!-- Forum Post END -->
                    <!-- Forum Post -->
                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>
                    <!-- Forum Post END -->
                    <!-- Forum Post -->
                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>
                    <!-- Forum Post END -->
                    <!-- Forum Post -->
                    <li class="media well">

                        <div class="pull-left col-lg-2">
                            <a href="#" class="thumbnail">
                                <img alt="Image" src="http://i.imgur.com/tAHVmXi.jpg">
                            </a>
                        </div>

                        <div class="col-lg-6">
                            <b>Libelle </b>
                            <br/><br/>
                            <p>Debut description sdfsrvwscfewrgsexarewf...</p>
                        </div>


                        <div class="col-lg-4">
                            Createur de l'annonce : Prenom N.
                            <br/><br/>
                            Le 00/00/0000
                            <br/><br/>
                            Prix : 000
                        </div>
                    </li>
                    <!-- Forum Post END -->

                </ul>
            </div>
        </div>

    </body>
</html>
