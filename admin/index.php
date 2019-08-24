
<?php

require_once('../include/config.php');

session_start();

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT password, id FROM adminUser WHERE username = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch();

    $isValid = password_verify($password, $result[0]);

    if ($isValid) {
        $_SESSION['isAdmin'] = true;
        $_SESSION['authUser'] = $username;
        $_SESSION['id'] = $result[1];
        header('Location: /blog_jean/admin/admin.php');
    }
}


?>

<body>
<?php
echo "<h2>Welcome " . $_SESSION['authUser']."</h2> ";
?>
<div>
    <table>
        <table style="width:100%">
            <tr class="table-first-line">
                <th>Auteur</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Date</th>
            </tr>
            <?php
            foreach ($posts as $post) {
                echo "<tr>
    <td>".$post["adminUser"]."</td>
    <td>".$post["title"]."</td>
    <td>".$post["category"]."</td>
    <td>".$post["date"]."</td>
    </tr>";
            }
            ?>

        </table>
</div>
<div>
    <a href="/blog_jean/admin/redactor.php" target="_blank">Créer un nouvel article</a>
</div>
</body>


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

