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



if(!isset($_SESSION["isAdmin"]) || (isset($_SESSION["isAdmin"]) && !$_SESSION["isAdmin"])) {
    echo "Unauthorized Access";
    exit;
}

$categories = [];
if (isset($_POST["name"])) {
    $sql = "INSERT INTO category(name) VALUES (:name);";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $_POST["name"]);
    $stmt->execute();
}

$sql = "SELECT id, name FROM category;";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$categories = $stmt->fetchAll();

if (isset($_POST["name"])){
    echo json_encode($categories);
    return;
}
if (isset($_POST["title"]) && isset($_POST["post"])) {
    $sql = "INSERT INTO post(title, content, FK_category, FK_adminUser, date)) VALUES (:title, :content, :categoryId, :authorId, :date)";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':title', $_POST['title']);
    $stmt->bindValue(':content', $_POST['post']);
    $stmt->bindValue(':categoryId', $_POST['category']);
    $stmt->bindValue(':authorId', $_SESSION['id']);
    $stmt->bindValue(':date', date("Y-m-d H:i:s"));
    $stmt->execute();
    return;
}
?>



<select>
    <?php
    foreach ($categories as $category)
    {
        echo "<option value='".$category[0]."'>".$category[1]."</option>";
    }
    ?>
</select>




<html>
<head>
    <meta charset="utf-8">
    <title>Admin Article </title>
</head>
<body>
<h1>Rédaction d'un article : </h1>
<div>
    <div>
        <div>Choisissez la catégorie :</div>
        <div>
            <select>
                <?php
                foreach ($categories as $category)
                {
                    echo "<option value='".$category."'>".$category."</option>";
                }
                ?>
            </select>
        </div>
        <div>
            Ajouter une nouvelle catégorie :
            <button id="addCategory">Créer une nouvelle catégorie</button>
        </div>
    </div>
    <div><textarea name="editor"></textarea></div>
    <div>
        <button id="publish">Publier</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );

    $('#addCategory').on('click', function(){
        var newName = prompt("Entrez le nom de votre catégorie :");
        $.ajax({
            method: "POST",
            data: {
                "name": newName
            },
            dataType: "json",
            success: function(categories){
                var categoriesHtml;
                for (category of categories){
                    categoriesHtml += "<option value='" + category[0] + "'>" + category[1] +  "</option>";
                }
                $('#listCategories').html(categoriesHtml);
            }
        });
        $('#publish').on('click', function(){
            $.ajax({
                method: "POST",
                data: {
                    "post": CKEDITOR.instances.editor.getData(),
                    "title": $("#postTitle").val(),
                    "category" : $("#listCategories").val()
                },
                success: function(){
                    window.location.href = "/blog_jean/admin/admin.php";
                }
            })
        });
</script>
</body>
</html
