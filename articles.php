<?php
require_once './phpScript/inc.all.php';

$aid = intval($_REQUEST['idarticle']);
$articleinfo = articleInfo($aid);
$banned = intval($articleinfo['banned']);

if ($banned) {
    header('Location: index.php');
}
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

        <style>
            .media-right {
                width: 400px ;
            }
        </style>



        <?php
        include './menu/showmenu.php';
        $aid = intval($_REQUEST['idarticle']);

        $articleinfo = articleInfo($aid);
        $userinfo = getUserInfo(intval($articleinfo['id_Users']));

        $state = intval($articleinfo['state']);
        //var_dump($userinfo);
        //var_dump($articleinfo);

        $vmail = intval($articleinfo['mailvisible']);
        $vphone = intval($articleinfo['phonevisible']);
        $vadress = intval($articleinfo['adressvisible']);

        if (isset($_REQUEST['post'])) {
            $com = filter_input(INPUT_POST, 'txt');
            $date = date("Y-m-d H:i:s");
            addComment(getUserID(), $aid, $date, $com);
            header("refresh:0");
        }

        if (isset($_REQUEST['state'])) {
            //var_dump($_REQUEST['idcom']);
            //var_dump(explode(",",$_REQUEST['idcom'] ));
            //$ucom = intval(explode(",",$_REQUEST['idcom'])[0]);
            //$acom = intval(explode(",",$_REQUEST['idcom'])[1]);
            $idcom = intval($_REQUEST['idcom']);
            $comstate = intval($_REQUEST['comstate']);


            if ($comstate == 1) {
                $reversestate = 0;
            } else {
                $reversestate = 1;
            }

            changeComState($idcom, $reversestate);
            header("refresh:0");
        }
        
        if(isset($_REQUEST['ban'])){
            $idcom = intval($_REQUEST['idcom']);
            banComment($idcom);
            header("refresh:0");
        }
        
        
        ?>
        <div class="panel" id='article'>
            <div class="panel-body">
                <div class="pull-left col-lg-4">
                    <iframe src="articleImages.php?id=<?php echo $aid; ?>" width="100%" height="400">                        
                    </iframe>
                </div>
                <div class="col-lg-4">
                    <label for="description"><?php echo $articleinfo['name']; ?></label>

                    <div id='description'>
                        <?php echo $articleinfo['description']; ?>
                    </div>

                    <br/><br/>
                    <label for="description">Prix : <?php echo $articleinfo['price']; ?></label>
                </div>
                <div id="info" class="pull-right col-lg-4">
                    Createur del'annonce : <?php echo $_SESSION['uname'] ?>
                    <br/>
                    Le : <?php echo $articleinfo['creationdate']; ?>
                    <br/><br/>
                    <?php
                    if ($vphone) {
                        echo 'Tel. : ' . getUserTel() . '<br/>';
                    }

                    if ($vmail) {
                        echo 'E-mail : ' . getUserMail() . '<br/>';
                    }

                    if ($vadress) {
                        echo 'Addresse : ' . getUserAdress() . '<br/>';
                    }
                    ?>

                    <br/><br/><br/>

                    Etat de l'annonce : <?php
                    if ($state) {
                        echo 'Ouvert';
                    } else {
                        echo 'Fermé';
                    }
                    ?>
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
                        <?php
                        $articlecreator = intval(articleInfo($aid)['id_Users']);
                        foreach (getArticleComments($aid) as $value) {
                            print commentFormat($value,$articlecreator);
                        }
                        ?>
                        <!-- Forum Post -->
                        <!--
                                                <li class="media well">
                                                    <div class="pull-left user-info col-lg-1">
                                                        <img class="avatar img-circle img-thumbnail" src="./img/Koala.jpg"
                                                             width="64" alt="Generic placeholder image">
                                                        <br/>
                                                        <strong><a href="user.html"><?php echo $_SESSION['uname'] . "<br/>"; ?></a></strong>
                                                        <small>Membre</small>
                                                        <br>
                        
                                                    </div>
                                                    <div class="media-body">
                        
                        
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero.qqqqq
                        
                                                    </div>
                                                    <div id='postOptions' class="media-right">
                                                        2016-06-07 13:46:28
                                                        <br/>
                                                        
                                                        <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-exclamation-sign"></i></span></a>
                                                        <br/>
                                                        <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-remove-sign"></i></span></a>
                                                        
                                                        <form action="#" method="post">
                                                            <input type="hidden" name="idcom" value="2"/>
                                                            <input type="submit" name="state" class="btn btn-warning" value="!" />
                                                            <input type="submit" name="ban" class="btn btn-danger" value="X"/>
                                                        </form>
                                                        
                                                    </div>
                                                </li>
                        -->
                        <!-- Forum Post END -->



                        <?php if (getPrivilege() != PRIV_UNKNOWN) { ?>
                            <!-- Forum Add -->

                            <li class="media well">
                                <div class="pull-left user-info col-lg-1" href="#">
                                    <img class="avatar img-circle img-thumbnail" src="<?php echo getImagePath(); ?>"
                                         width="64" alt="Generic placeholder image">
                                    <br/>
                                    <strong><a href="user.html"><?php echo $_SESSION['uname'] . "<br/>"; ?></a></strong>
                                    <small>Membre</small>
                                    <br>

                                </div>
                                <div class="media-right">
                                    <form role="form" action="#" method="post">                            
                                        <textarea name='txt' rows="5" cols="100" maxlength="500" required></textarea>
                                        <br/>
                                        <button type="submit" class="btn btn-success" name="post">Envoyer</button>
                                    </form>

                                </div>
                            </li>
                            <!-- Forum Post END -->
                        <?php } ?>


                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
