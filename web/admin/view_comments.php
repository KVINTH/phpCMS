<?php
    require 'authenticate.php';
    require '../connect.php';

    $query = "SELECT * FROM comments WHERE PostID = :PostID ORDER BY PostID ASC";
    $statement = $db->prepare($query);

    $postID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $statement->bindValue(':PostID', $postID, PDO::PARAM_INT);

    $statement->execute();

    if (isset($_GET['sortby'])
    &&  $_GET['sortby'] == 'title')
    {
        $titleQuery = "SELECT * from posts ORDER BY PostTitle ASC";
        $db = $GLOBALS['db'];

        $statement = $db->prepare($titleQuery);
        $statement->execute();
    }
    else if (isset($_GET['sortby'])
    &&  $_GET['sortby'] == 'created')
    {
        $query = "SELECT * FROM posts ORDER BY PostDate ASC";
        $db = $GLOBALS['db'];
        $statement = $db->prepare($query);
        $statement->execute();
    }
    else if (isset($_GET['sortby'])
    && $_GET['sortby'] == 'updated')
    {
        $query = "SELECT * FROM posts ORDER BY EditDate ASC";
        $db = $GLOBALS['db'];
        $statement = $db->prepare($query);
        $statement->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>yourSPACE - View All Posts</title>
    <link rel="stylesheet" type="text/css" href="/stylesheet.css">
</head>
<body>
    <table>
        <tr>
            <th><a href="view_posts.php?sortby=title">Content</a></th>
            <th><a href="view_posts.php?sortby=created">Posted By</a></th>
        </tr>

        <?php while($row = $statement->fetch()):?>
            <tr>
                <td>
                    <?=$row['Content']?>
                </td>
                <td>
                    <?php

                    $userQuery = "SELECT UserID, Username FROM users WHERE UserID = :userID";
                    $userStatement = $db->prepare($userQuery);
                    $userStatement->bindValue(':userID', $row['UserID']);
                    $userStatement->execute();
                    $userRow = $userStatement->fetch();

                    echo $userRow[1];
                    ?>
                </td>
                <td>
                    <form method="post" action="delete_comment.php">
                        <input type="hidden" name="id" value="<?=$row['CommentID']?>">
                        <input type="submit" name="submit" value="Delete" />
                    </form>
                </td>
            </tr>
        <?php endwhile ?>
    </table>
    <a href="../admin/">Click to return to Administration Panel</a>
</body>
