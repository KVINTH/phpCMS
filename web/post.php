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

    // THUS BEGINS THE QUERY FOR COMMENTS ON posts
    $commentQuery = "SELECT * FROM comments where PostID = :id ORDER BY PostID ASC";
    $commentStatement = $db->prepare($commentQuery);

    $commentStatement->bindValue(':id', $id, PDO::PARAM_INT);
    $commentStatement->execute();

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
                    <h4><?=$row['PostDate']?> - <a href="editpost.php?id=<?=$row['PostID']?>">edit</a></h4>
                </header>
                <content>
                    <p>
                        <?=$row['PostContent']?>
                    </p>
                </content>
            </div>

            <div id="comments">
                <?php while($comment = $commentStatement->fetch()): ?>
                    <div id="comment">
                        <p>
                            <?=$comment['Content']?>
                        </p>

                        Posted by:
                        <?php
                        $commentorQuery = "SELECT UserID, Username FROM users WHERE UserID = :userID";
                        $commentorStatement = $db->prepare($commentorQuery);
                        $commentorStatement->bindValue(':userID', $comment['UserID']);
                        $commentorStatement->execute();
                        $commentorRow = $commentorStatement->fetch();

                        echo $commentorRow[1];
                        ?>

                    </div>
                <?php endwhile ?>

            </div>

        </div>
    </body>
</html>
