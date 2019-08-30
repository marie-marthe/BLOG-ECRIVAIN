<?php

session_start();


// Fichier PHP contenant la connexion à votre BDD
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_jean;charset=utf8', 'root', 'root');
}

catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

//  Récupération de l'utilisateur et de son pass hashé

$req = $bdd->prepare('SELECT email, password FROM adminUser WHERE username = :username');

$req->execute(array(

    'mail' => $mail));

$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);


if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();

        $_SESSION['email'] = $resultat['email'];
        $_SESSION['username'] = $username;
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}

if (isset($_SESSION['id']) AND isset($_SESSION['username'])) {
    echo 'Bonjour ' . $_SESSION['username'];
}

// S'il y a une session alors on ne retourne plus sur cette page
if (isset($_SESSION['email'])){
    header('Location: redactor.php');
    exit;
}

?>

<!DOCTYPE html>

<form  method="POST">
    <div>
        <h2>Login</h2>
    </div>
    <div>
        <input id="username" type="text" name="username" placeholder="Username">
    </div>
    <div>
        <input id="password" type="password" name="password" placeholder="Password">
    </div>
    <div>
        <input type="submit" value="Submit">
    </div>
</form>
