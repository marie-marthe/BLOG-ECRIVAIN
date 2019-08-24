<?php

// Permet de savoir s'il y a une session.
// C'est à dire si un utilisateur c'est connecté à votre site
    session_start();

// Fichier PHP contenant la connexion à votre BDD

include('../include/config.php');


?>

<!DOCTYPE html>


<html>


﻿<head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    ﻿<meta charset="utf-8"/>
    ﻿<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Accueil</title>
</head>

﻿<body>

﻿<a href="index.php"><h1>Billet simple pour l'Alaska</h1></a>

<h2>par Jean Forteroche</h2>
<br/>

<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="index.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <?php

if(!isset($_SESSION['id'])){ // Si on ne détecte pas de session alors on verra les liens ci-dessous
    ?>
    <!-- Liens de nos futures pages -->

    <?php

}else{ // Sinon s'il y a une session alors on verra les liens ci-dessous
    ﻿?>
    <a href="admin/profil.php">Mon profil</a>
    <a href="admin/deconnexion.php">Déconnexion</a>
    <li class="nav-item">
        <a class="nav-link" href="admin/profil.php">Mon profil</a>
    </li>
    ﻿<?php
}
?>
        </ul>
        <ul class="navbar-nav ml-md-auto">
            <?php
            if(!isset($_SESSION['id'])){
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin/connexion.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin/deconnexion.php">Déconnexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin/motdepasse.php">Mot de passe oublié</a>
                </li>
                <?php
            }else{
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin/deconnexion.php">Déconnexion</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<section class="banner style2">

    <div class="content">

        <br/>
        <br/>

        <p class="major"> <br/>« Bienvenue en Alaska »  <b>Je vous propose de découvrir, chaque vendredi
                soir, pendant 10 semaines, un chapitre de ce nouveau roman.</b>  <br/> N’hésitez pas à <b>commenter chacun d'entre eux.</b> </br>Je vous ferai des retours au fur et à mesure.
            </br> Bonne lecture mes lecteurs !</p>
    </div>

    <div class="image">
        <img src="content/alaska.png" alt="" />
    </div>

</section>


<section class="spotlight style1 orient-right content-align-center">

    <div class="content">
        </br><h3 class="intro">Lisez et appréciez mon dernier chapitre :</h3>

        <?php foreach ($posts as $post): ?>

            <h2><?= $post['title'] ?></h2>
            <h4 class="dateintro">Publié le <?= $post['date_fr'] ?></h4>

            <p><?= $post['content'] ?><br /></p>

            <div class="button"><a href="post/index">Découvrez les précédents chapitres !</a></div>

        <?php endforeach; ?>


    </div>

</section>


</body>

﻿</html>