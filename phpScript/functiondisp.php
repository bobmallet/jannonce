<?php
/*
Fichier: functiondisp.php
Auteur: Kevin Zaffino
Date: 15/06/2016
Version:1.10
Description: Contient les fonction d'affichage du site
Copyright (Ex: TPI 2016 - Kevin Zaffino © 2016)
*/

/**
 * Retourne le nom et le prenom avec le format "Prenom N."
 * @param string $firstname     Nom
 * @param string $lastname      Prenom
 * @return (string) format Prenom N.
 */
function formatUserName($firstname, $lastname) {
    return ucfirst($firstname) . " " . substr(ucfirst($lastname), 0, 1) . ".";
}


/**
 * Retourne du code html pour afficher un article sur la page d'accueil
 * @param Array $data       Donnée de l'utilisateur (id,name,description,date de creation, price)
 * @param string $imgpath   Chemin de l'image à afficher
 * @return string
 */
function articleFormat($data, $imgpath) {
    
    $creator_id = intval($data['id_Users']);
    $creator_firstname = getUserInfo($creator_id)['firstname'];
    $creator_lastname = getUserInfo($creator_id)['lastname'];
    $creatorname = formatUserName($creator_firstname, $creator_lastname);
    
    $output = "\n<li class=\"media well\">";
    $output .= "\n<div class=\"pull-left col-lg-2\">";
    $output .= "\n<a href=\"articles.php?idarticle=" . $data['id'] . "\" class=\"thumbnail\">";
    $output .= "<img alt=\"Image\" src=\"" . $imgpath . "\">";
    $output .= "\n</a>";
    $output .= "\n</div>";
    $output .= "<div class=\"col-lg-6\">";
    $output .= "\n<a href=\"articles.php?idarticle=" . $data['id'] . "\">";
    $output .= "\n<b>" . $data['name'] . "</b>";
    $output .= "\n</a>";
    $output .= "<br/><br/>";
    $output .= "\n<p>" . descriptionSize($data['description']) . "</p>";
    $output .= "\n</div>";
    $output .= "\n<div class=\"col-lg-4\">";
    $output .= "\nCréateur de l'annonce : ". $creatorname;
    $output .= "\n<br/><br/>";
    $output .= "\nLe " . $data['creationdate'];
    $output .= "\n<br/><br/>";
    $output .= "\nPrix : " . $data['price'];
    $output .= "\n</div>";
    $output .= "\n</li>";
    $output .= "\n</li>";

    return $output;
}

/**
 * Retourne un string d'un certain nombre de charactère avec "..." a la fin
 * @param string $desc    Description à raccourcir
 * @return string
 */
function descriptionSize($desc) {
    return substr($desc, 0, 50) . "...";
}


/**
 * Retourne du code html pout afficher le commentaire
 * @param Array $data           Données du commentaire
 * @param int $creatorid        Identifiant du createur de l'article
 * @return string               Code HTML
 */
function commentFormat($data, $creatorid) {
    $uid = intval($data['id_Users']);
    $userinfo = getUserInfo($uid);

    if ($userinfo['privilege'] == "2") {
        $priv = "Admin";
    } else {
        $priv = "Membre";
    }

    if ($data['state'] == "1") {
        $comment = $data['comm'];
    } else {
        $comment = "Commentaire en attente de modération";
    }


    $btn = "";

    if (getUserID() == $creatorid) {
        $btn .= "<input type=\"submit\" name=\"state\" class=\"btn btn-warning\" value=\"!\" />";
    }

    if (getPrivilege() == PRIV_ADMIN) {
        $btn .= "<input type=\"submit\" name=\"ban\" class=\"btn btn-danger\" value=\"X\"/>";
    }

    $output = "    \n<li class=\"media well\">
                            \n<div class=\"pull-left user-info col-lg-1\">
                               \n <img class=\"avatar img-circle img-thumbnail\" src=\"" . $userinfo['path'] . "\"
                                     \nwidth=\"64\" alt=\"Generic placeholder image\">
                                \n<br/>
                                \n<strong><a href=\"user.html\">" . formatUserName($userinfo['firstname'], $userinfo['lastname']) . "</a></strong>
                               \n <br/><small>" . $priv . "</small>
                               \n <br>

                            \n</div>
                           \n <div class=\"media-body\">" .
            $comment
            . "\n </div>
                            \n<div id='postOptions' class=\"media-right\">
                                " . $data['date_com'] . "
                                \n<br/>"
            .
            "\n<form action=\"#\" method=\"post\">
                                    <input type=\"hidden\" name=\"comstate\" value=\"" . $data['state'] . "\"/>
                                    <input type=\"hidden\" name=\"idcom\" value=\"" . $data['id'] . "\"/>"
            . $btn .
            "</form>"
            .
            //\n<a href=\"#\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i></span></a>
            //\n<br/>
            //\n<a href=\"#\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-remove-sign\"></i></span></a>



            "\n</div>
                        \n</li>";

    return $output;
}


/**
 * Converti un tableau php en table html.
 * Le paramètre facultatif $assoc permet d'afficher une ligne d'entete si le tableau est associatif.
 * @param array $anArray Un tableau php (indexé ou associatif)
 * @param boolean $assoc (true si le tableau est associatif)
 * @return string Une chaîne qui contient un tableau html indenté.
 */
function Array2Html($anArray, $assoc = false) {
    $output = "\n<table class=\"table table-bordered\">";
    $lig = 0;

    // Si le tableau est associatif, la première ligne contient le nom des colonnes
    if ($assoc) {
        $firstLine = true;
        foreach ($anArray as $line) {
            if ($firstLine) {
                $output .= "\n <tr>";
                // affiche les entetes en th
                foreach ($line as $key => $value) {
                    $output .= "\n <th>" . $key . "</th>";
                }
                $output .= "\n </tr>";
                $output .= "\n <tr>";
                // affiche les entetes en th
                foreach ($line as $key => $value) {
                    $output .= "\n <td>" . $value . "</td>";
                }
                $output .= "\n </tr>";
                $firstLine = false;
            } else {
                if (($lig++ % 2) == 1)
                    $output .= "\n <tr>";
                else
                    $output .= "\n <tr class = \"odd\">";
// affiche les entetes en td
                foreach ($line as $key => $value) {
                    $output .= "\n    <td>" . $value . "</td>";
                }
                $output .= "\n  </tr>";
            }
        }
    } else {
// Tableau indexé
        for ($lig = 0; $lig < count($anArray); $lig++) {
            if (($lig % 2) == 0)
                $output .= "\n  <tr>";
            else
                $output .= "\n  <tr class=\"odd\">";
// Compte le nombre de colonnes
            for ($col = 0; $col < count($anArray[$lig]); $col++) {
                $output .= "\n    <td>" . $anArray[$lig][$col] . "</td>";
            }
            $output .= "\n  </tr>";
        }
    }

// Compte le nombre de lignes
    $output .= "\n</table>";
    return $output;
}


/**
 * Retourne du code html pout faire un select avec tous les pays
 * @param string $selectedcountry       Nom du pays (a specifier pour definir l'attribut selected)
 * @return string       Code HTML
 */
function selectCountry($selectedcountry = null) {
    $output = "\n<select name=\"country\" class=\"form-control\" id=\"country\">";
    foreach (getAllCountry() as $value) {

        if ($selectedcountry == $value['name']) {
            $selected = "selected";
        } else {
            $selected = "";
        }



        $output .="\n<option value=\"" . $value['iso'] . "\"" . $selected . ">" . $value['name'] . "</option>";
    }

    $output .= "\n</select>";

    return $output;
}
