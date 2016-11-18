<?php require 'connect.php';
session_start();
if ($_GET != null)
{
    $query = "SELECT * FROM posts WHERE PostID = :id LIMIT 1";
    $statement = $db->prepare($query);

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $row = $statement->fetch();

    if(empty($row))
    {
        header('Location: index.php');
        exit;
    }

}
else {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Edit Post</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    </head>
    <body>
        <div class="topbar">
            <?php include 'topbar.php'?>
        </div>

        <div class="nav">
            <?php include 'navigation.php'?>
        </div>

        <div class="wrapper">
            <div id="content">
            <form action="post_process.php" method="post">
                <fieldset>
                    <legend>
                        Edit Post
                    </legend>
                    <p>
                        <label for="title">Title</label>
                        <?="<input name=\"title\" id=\"title\" value=\"". $row['PostTitle'] . "\" />" ?>
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"><?=$row['PostContent']?></textarea>
                    </p>
                    <p>
                        <input type="hidden" name="id" value="<?=$row['PostID']?>"/>
                        <input name="submit" type="submit" value="Update" />
                        <input name="submit" type="submit" value="Delete" onclick="return confirm('Are you sure?')" />
                    </p>
                </fieldset>
            </form>

            </div>

        </div>
        <div class="footer">
            <?php include('footer.php') ?>
        </div>
    </body>
</html>
