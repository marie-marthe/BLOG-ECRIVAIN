<?php

// Fichier PHP contenant la connexion à votre BDD
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_jean;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

session_start();

if ($_SESSION['isAdmin']) {
echo "Welcome" . $_SESSION['authUser'];
    }else {
echo "Get out you're not authorized";
    }

$posts = [];
$sql = "SELECT
                p.id as id,
                p.title as title,
                aU.username as adminUser,
                c.name as category,
                p.date as date
            FROM
                post p
            LEFT JOIN adminUser aU 
            ON p.adminUser_FK = aU.id
            LEFT JOIN category c 
            ON p.category_FK = c.id;";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

?>
