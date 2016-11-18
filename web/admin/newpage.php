<?php
    //require 'authenticate.php';
    require '../connect.php';

    $query = "SELECT * FROM categories ORDER BY CategoryID DESC";
    $statement = $db->prepare($query);

    $statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>yourSPACE - New Page</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
    <div id="topheader">
    </div>
    <div id ="all_blogs">
        <div class="blog_post">
            <form action="process.php" method="post">
                <fieldset>
                    <legend>
                        New Page
                    </legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"></textarea>
                    </p>
                    <p>
                        <label for="category">Category</label>
                        <select name="category">
                            <?php while ($row = $statement->fetch()): ?>
                                <option><?=$row['CategoryName']?></option>
                            <?php endwhile ?>
                        </select>
                    </p>
                    <p>
                        <input name="submit" type="submit" value="Create" />
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>
