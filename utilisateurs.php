<?php
session_start();
include('../include/config.php');

if (!isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
}

// On récupère tous les utilisateurs sauf l'utilisateur en cours
$afficher_profil = $DB->query("SELECT * 
    FROM utilisateur 
    WHERE id <> ?",
    array($_SESSION['id']));
$afficher_profil = $afficher_profil->fetchAll(); // fetchAll() permet de récupérer plusieurs enregistrements
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs du site</title>
</head>
<body>
<div>Utilisateurs</div>
<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Voir le profil</th>
    </tr>
    <?php
    // Foreach agit comme une boucle mais celle-ci s'arrête de façon intelligente.
    // Elle s'arrête avec le nombre de lignes qu'il y a dans la variable $afficher_profil
    // La variable $afficher_profil est comme un tableau contenant plusieurs valeurs
    // pour lire chacune des valeurs distinctement on va mettre un pointeur que l'on appellera ici $ap
    foreach($afficher_profil as $ap){
        ?>
        <tr>
            <td><?= $ap['nom'] ?></td>
            <td><?= $ap['prenom'] ?></td>
            <td><a href="voir_profil.php?id=<?= $ap['id'] ?>">Aller au profil</a></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>