<?php
    require 'authenticate.php';
    require '../connect.php';

    $query = "SELECT * FROM categories ORDER BY CategoryID ASC";
    $statement = $db->prepare($query);

    $statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>yourSPACE - New Page</title>
    <link rel="stylesheet" type="text/css" href="/stylesheet.css">
</head>
<body>
    <table>
        <tr>
            <th>Category</th>
            <th>Action</th>
        </tr>

        <?php while($row = $statement->fetch()):?>
            <tr>
                <td>
                    <?=$row['CategoryName']?>
                </td>
                <td>
                    <form method="post" action="category_process.php">
                        <input type="hidden" name="id" value="<?=$row['CategoryID']?>">
                        <input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure?')"  />
                    </form>
                </td>
            </tr>
        <?php endwhile ?>
        <form method="post" action="category_process.php">
        <tr>
            <td>
                <input type="text" id="category" name="category">
            </td>
            <td>

                    <button type="submit" name="submit" value="Create">Create</button>

            </td>
        </tr>
        </form>
    </table>
    <a href="../admin/">Click to return to Administration Panel</a>
</body>
