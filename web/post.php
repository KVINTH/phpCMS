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
        <script src='https://www.google.com/recaptcha/api.js'></script>
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

                <div id="comments">
                    <?php while($comment = $commentStatement->fetch()): ?>
                        <div id="comment">
                            <div id="commentImage">
                                <?php
                                $picQuery = "SELECT ProfilePicPath FROM users WHERE UserID = :userID";
                                $picStatement = $db->prepare($picQuery);
                                $picStatement->bindValue(':userID', $comment['UserID']);
                                $picStatement->execute();
                                $picRow = $picStatement->fetch();
                                ?>
                                <img src="<?=$picRow[0]?>" />
                            </div>
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
                    <div id="newcomment">
                        <form action="comment_process.php" method="post">
                            <fieldset>
                                <textarea id="content" name="content" rows="4" cols="50"></textarea>
                                <?php $user = $_SESSION['userid'] ?>
                                <input name="postid" type="hidden" id="postid" value="<?=$row['PostID']?>"/>
                                <input name="userid" type="hidden" id="userid" value="<?=$user?>"/>
                                <input id="submit" type="submit" value="Comment"/>
                                <div class="g-recaptcha" data-sitekey="6Le-6gwUAAAAANbWMq9sT26Ct-83SmigEdHZhPK4"></div>
                            </fieldset>

                        </form>
                    </div>
                </div>
            </div>



        </div>
    </body>
</html>
