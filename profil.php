<?php

session_start();


if(empty($get_id_forum) || empty($get_id_topic)){
    header('Location: /forum');
    exit;
}

$req = $DB->query("SELECT t.*, DATE_FORMAT(t.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom
		FROM topic T
		LEFT JOIN utilisateur U ON U.id = T.id_user
		WHERE t.id = ? AND t.id_forum = ?
		ORDER BY t.date_creation DESC",
    array($get_id_topic, $get_id_forum));

$req = $req->fetch();

if(!isset($req['id'])){
    header('Location: /forum/' . $get_id_forum);
    exit;
}

$req_commentaire = $DB->query("SELECT TC.*, DATE_FORMAT(TC.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom, U.nom
		FROM topic_commentaire TC
		LEFT JOIN utilisateur U ON U.id = TC.id_user
		WHERE id_topic = ?
		ORDER BY date_creation DESC",
    array($get_id_topic));

$req_commentaire = $req_commentaire->fetchAll();

if(!empty($_POST)){
    extract($_POST);
    $valid = true;

    // On se positionne sur le formulaire d'ajout d'un commentaire
    if (isset($_POST['ajout-commentaire'])){

        // On récupère le contenu du commentaire
        $text = (String) trim($text);

        // On fait quelques vérifications
        if(empty($text)){
            $valid = false;
            $er_commentaire = "Il faut mettre un commentaire";
        }elseif(iconv_strlen($text, 'UTF-8') <= 3){
            $valid = false;
            $er_commentaire = "Il faut mettre plus de 3 caractères";
        }
        // Par précaution on sécurise notre commentaire
        $text = htmlentities($text);

        if($valid){

            $date_creation = date('Y-m-d H:i:s');

            // On insètre le commentaire dans la base de données
            $DB->insert("INSERT INTO topic_commentaire (id_topic, id_user, text, date_creation) VALUES (?, ?, ?, ?)",
                array($get_id_topic, $_SESSION['id'], $text, $date_creation));

            header('Location: /forum/' . $get_id_forum . '/' . $get_id_topic);
            exit;
        }
    }
}
include('../include/config.php');
// S'il n'y a pas de session alors on ne va pas sur cette page

if(!isset($_SESSION['id'])){
    header('Location: index.php'>);
    exit;
}
// On récupère les informations de l'utilisateur connecté
$afficher_profil = $DB->query("SELECT * 
  FROM utilisateur 
  WHERE id = ?",
    array($_SESSION['id']));

$afficher_profil = $afficher_profil->fetch();

?>


<html lang="fr">
<head>
    <meta charset="utf-8">
    ﻿    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    ﻿    <meta name="viewport" content="width=device-width, initial-scale=1">
    ﻿<title>Mon profil</title>
    ﻿  <head>
        ﻿  <body>
﻿  <h2>Voici le profil de <?= $afficher_profil['nom'] . $afficher_profil['prenom']; ?></h2>
﻿    <div>Quelques informations sur vous : </div>
﻿<ul>
    ﻿  <li>Votre id est : <?= $afficher_profil['id'] ?></li>
    <﻿li>Votre mail est : <?= $afficher_profil['mail'] ?></li>
    ﻿<li>Votre compte a été crée le : <?= $afficher_profil['date_creation_compte'] ?></li>
</ul>
﻿</body>
</html>

