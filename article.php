<?php

$id = intval($_GET['p']);

$sql = "SELECT
                p.id as id,
                p.title as title,
                aU.username as adminUser,
                c.name as category,
                p.date as date,
                p.content as content
            FROM
                post p
            LEFT JOIN adminUser aU 
            ON p.FK_adminUser = aU.id
            LEFT JOIN category c 
            ON p.category_FK = c.id
            WHERE p.id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$post = $stmt->fetch();

if (isset($_POST["author"]) && isset($_POST["email"]) && isset($_POST["content"]) && isset($id)) {
    $sql = "INSERT INTO comment(author, email, content, post_FK, date)
                VALUES (:author, :email, :content, :postId, :date);";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':author', $_POST["author"]);
    $stmt->bindValue(':email', $_POST["email"]);
    $stmt->bindValue(':content', $_POST["content"]);
    $stmt->bindValue(':postId', $id);
    $stmt->bindValue(':date', date("Y-m-d H:i:s"));
    $stmt->execute();
}

$sql = "SELECT 
                c.content as content, 
                c.date as date, 
                c.author as author
            FROM 
                comment c
            WHERE c.FK_post = :id
            ORDER BY date, id DESC;";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$comments = $stmt->fetchAll();

?>

<script>
    CKEDITOR.replace( 'editor' );

    $('#addComment').on('click', function(){
        $.ajax({
            method: "POST",
            data: {
                "author": $("#user").val(),
                "email": $("#mail").val(),
                "content": CKEDITOR.instances.editor.getData()
            },
            success: function(){
                var newComment = "<div class='content-post'><div class='content-article'>" + CKEDITOR.instances.editor.getData() + "</div><div class='comment-name'>Par " + $("#user").val() + "</div></div>";
                $("#listComment").prepend(newComment);
            }
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="wrap-post">
                <?php
                echo
                    "<div class='header-post'>
                                <div class='title-post'>".$post["title"]."
                                <div class='info-post'>".$post["category"].", par ".$post["adminUser"]." le ".$post["date"]."</div>
                            </div>
                            </div>
                            <div class='content-post'>
                                <div class='content-article'>".$post["content"]."</div>                
                            </div>";
                ?>
            </div>
            <div class="comments wrap-post">
                <div class="header-post">
                    <div class="title-post">Commentaires</h2></div>
                </div>
                <div id="listComment">
                    <?php
                    foreach($comments as $comment) {
                        echo
                            "<div class='content-post'>
                                    <div class='content-article'>".$comment["content"]."</div>                
                                    <div class='comment-name'>Par ".$comment["author"]."</div>
                                </div>";
                    }
                    ?>
                </div>
            </div>
            <div class="comments wrap-post">
                <div class="header-post">
                    <div class="title-post">Ecrire un commentaire</h2></div>
                </div>
                <div class="content-post">
                    <div class="form-group">
                        <label for="user">Nom :</label>
                        <input type="text" class="form-control" id="user" value="Anonymous" />
                        <label for="mail">Email :</label>
                        <input type="email" class="form-control" id="mail" />
                    </div>
                    <div><textarea name="editor"></textarea></div>
                    <div><button id="addComment" class="flat-button">Publier</div></div>
            </div>
        </div>
    </div>
</div>