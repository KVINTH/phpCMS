<?php
require 'connect.php';
session_start();

if ($_GET != null)
{
    $query = "SELECT * FROM posts where PostID = :id LIMIT 1";
    $statement = $db->prepare($query);

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch();

    if(empty($row)) {
        header('Location: index.php');
        exit;
    }
}
else {
    header('Location: index.php');
    exit;
}

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Post -</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
        <div class="topbar">
            <?php include 'topbar.php' ?>
        </div>

        <div class="nav">
            <?php include 'navigation.php' ?>
        </div>

        <div class="wrapper">
            <div id="content">
                <header>
                    <h1><?=$row['PostTitle']?></h1>
                    <h4>
                        <?=$row['PostDate']?> <?php if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == true): ?>
                        - <a href="editpost.php?id=<?=$row['PostID']?>">edit</a>
                        <?php else: ?>
                        <?php endif ?>
                    </h4>
                </header>
                <content>
                    <p>
                        <?=$row['PostContent']?>
                    </p>
                </content>
            </div>
        </div>
    </body>
</html>
