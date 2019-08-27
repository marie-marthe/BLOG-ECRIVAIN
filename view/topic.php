<?php
session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_jean;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}



// Récupération de l'id de la catégorie

$get_id_forum = (int) trim(htmlentities($_GET['id_forum']));

// Récupération de l'id du topic

$get_id_topic = (int) trim(htmlentities($_GET['id_topic']));

// Si l'une des variables est vide alors on redirige vers la page forum

if(empty($get_id_forum) || empty($get_id_topic)){
    header('Location: view/forum.php');
    exit;
}
// On va sélectionner les informations nécessaire pour afficher notre topic

$req = $DB->query("SELECT t.*, DATE_FORMAT(t.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom
    FROM topic T
    LEFT JOIN utilisateur U ON U.id = T.id_user
    WHERE t.id = ? AND t.id_forum = ?
    ORDER BY t.date_creation DESC",
    array($get_id_topic, $get_id_forum));
$req = $req->fetch();

if(!isset($req['id'])){
    header('Location: view/forum.php/' . $get_id_forum);
    exit;
}

// On vient sélectionner les informations nécessaire pour afficher les commentaires
// postés sur ce topic

$req_commentaire = $DB->query("SELECT TC.*, DATE_FORMAT(TC.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom, U.nom
    FROM topic_commentaire TC
    LEFT JOIN utilisateur U ON U.id = TC.id_user
    WHERE id_topic = ?
    ORDER BY date_creation DESC",
    array($get_id_topic));
$req_commentaire = $req_commentaire->fetchAll();


?>
<!DOCTYPE html>
<html>
<head>
    <base href="/"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Topic</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>
<?php
require_once('view/menu.php');
?>
<div class="container">
    <div class="row">
        <div class="col-sm-0 col-md-0 col-lg-0"></div>
            <div class="col-sm-12 col-md-12 col-lg-12">
            <h1 style="text-align: center">Topic : <?= $req['titre'] ?></h1>
            <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px">
                <h3>Contenu</h3>
                <div style="border-top: 2px solid #eee; padding: 10px 0"><?= $req['contenu'] ?></div>
                <div style="color: #CCC; font-size: 10px; text-align: right">
                    <?= $req['date_c'] ?>
                    par
                    <?= $req['prenom'] ?>
                </div>
            </div>
            <!-- On vient afficher les commentaire avec un foreach -->
        </div> style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
        ﻿<h3>Commentaires</h3>
    </div> lass="table-responsive">
    <table class="table table-striped">
        ﻿  <?php
        foreach($req_commentaire as $rc){
            ?>
            <tr>
                <td><?= "De " . $rc['nom'] . " " . $rc['prenom'] ?>﻿</td>
                <td><?= $rc['text'] ?></td>
                ﻿<td><?= $rc['date_c'] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
            </div>
﻿       </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>