<?php
    require 'authenticate.php';
    require '../connect.php';
    $query = "SELECT * FROM posts ORDER BY PostID ASC";

    $statement = $db->prepare($query);

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
            <th><a href="view_posts.php?sortby=title">Title</a></th>
            <th><a href="view_posts.php?sortby=created">Created At</a></th>
            <th><a href="view_posts.php?sortby=updated">Last Updated</a></th>
            <th>

            </th>
        </tr>

        <?php while($row = $statement->fetch()):?>
            <tr>
                <td>
                    <a href="../post.php?id=<?=$row['PostID']?>"><?=$row['PostTitle']?></a>
                </td>
                <td>
                    <?=$row['PostDate']?>
                </td>
                <td>
                    <?=$row['EditDate']?>
                </td>
                <td>
                    <form method="post" action="view_comments.php">
                        <input type="hidden" name="id" value="<?=$row['PostID']?>">
                        <input type="submit" name="submit" value="Comments" />
                    </form>
                </td>
            </tr>
        <?php endwhile ?>
    </table>
    <a href="../admin/">Click to return to Administration Panel</a>
</body>
