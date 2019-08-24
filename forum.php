<?php
session_start();
include('../include/config.php'); // Fichier PHP contenant la connexion à votre BDD

$req = $DB->query("SELECT * 
    FROM forum
    ORDER BY ordre");

$req = $req->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    ﻿<base href="/"/>
    ﻿<meta charset="utf-8"/>
    ﻿<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    ﻿<title>Forum</title>
    ﻿<link rel="stylesheet" href="../css/bootstrap.min.css"/>
    ﻿<link rel="stylesheet" href="../css/style.css"/>
    ﻿</head>
﻿<body>
﻿<?php

﻿require_once('view/menu.php');

?>
<div class="container">
    ﻿<div class="row">
        <div class="col-sm-0 col-md-0 col-lg-0"></div>
        ﻿<div class="col-sm-12 col-md-12 col-lg-12">
            ﻿<h1 style="text-align: center">Forum</h1>
            ﻿<div class="table-responsive" style="margin-top: 10px">
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                    </tr>
                    <?php
                    foreach($req as $r){
                        ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><a href="forum/<?= $r['id'] ?>"><?= $r['titre'] ?></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>