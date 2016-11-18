<?php
    //require 'authenticate.php';
    //require 'connect.php';

    $query = "SELECT * FROM categories ORDER BY CategoryID DESC";
    $statement = $db->prepare($query);
    $statement->execute();

    $user = "";
?>

<form action="post_process.php" method="post">
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
