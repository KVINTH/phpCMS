<?php
    //require 'authenticate.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($db)){
        include 'connect.php';
    }

    require '../vendor/autoload.php';
    $query = "SELECT * FROM categories ORDER BY CategoryID ASC";
    $statement = $db->prepare($query);
    $statement->execute();

    $user = "";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>New Post</title>
        <!-- Make sure the path to CKEditor is correct. -->
        <!-- <script src="../vendor/ckeditor/ckeditor/ckeditor.js"></script> -->
    </head>
    <body>
        <form action="\post_process.php" method="post">
            <fieldset>
                <legend>
                    New Post
                </legend>
                <p>
                    <label for="title">Title</label>
                    <input name="title" id="title" />
                </p>
                <p>
                    <label for="content">Content</label>
                    <textarea name="content" id="content"></textarea>
                    <script>
                        //CKEDITOR.replace( 'content' );
                    </script>
                </p>
                <p>
                    <label for="category">Category</label>
                    <select name="category">
                        <?php while ($row = $statement->fetch()): ?>
                            <option name="category" id="category" value="<?=$row['CategoryID']?>"><?=$row['CategoryName']?></option>
                        <?php endwhile ?>
                    </select>
                </p>
                <p>
                    <?php $user = $_SESSION['userid'] ?>
                    <input name="userid" type="hidden" id="userid" value="<?=$user?>"/>
                    <input name="submit" type="submit" value="Create" />
                </p>
            </fieldset>
        </form>
    </body>
</html>
