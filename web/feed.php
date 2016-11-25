<!--
The index of the blog shows the 5 most recent blog posts
-->

<?php

//$query = "SELECT * FROM posts ORDER BY PostID DESC";

$query = "SELECT * from posts INNER JOIN categories ON posts.CategoryID = categories.CategoryID ORDER BY PostID DESC";

$statement = $db->prepare($query);

$statement->execute();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body>

        <div id ="all_blogs">
            <?php $i = 1 ?>
            <?php while(($row = $statement->fetch()) && ($i <=5)): ?>
                <div class="feed">
                    <header>
                        <?= "<h1>". $row['PostTitle']. "</h1>" ?>
                        <h4><?= $row['PostDate'] ?>

                            <?php if (isset($_SESSION['loggedin'])
                                    && $_SESSION['loggedin'] == true
                                    && isset($_SESSION['isadmin'])
                                    && $_SESSION['isadmin'] == true): ?>
                                    
                                    <!-- the - below is for styling -->
                                    - <a href="editpost.php?id=<?=$row['PostID']?>">edit</a>

                            <?php else: ?>
                            <?php endif ?>

                            </h4>
                    </header>
                    <content>
                        <?php if (strlen($row['PostContent']) > 200): ?>
                            <?= substr($row['PostContent'], 0, 199) ?>
                            ... <a href="post.php?id=<?=$row['PostID']?>">Read more</a>
                        <?php else: ?>
                            <?= $row['PostContent']?>
                        <?php endif ?>
                    </content>
                    <div id="info">
                        <p>
                            Posted by:
                            <?php

                            $userQuery = "SELECT UserID, Username FROM users WHERE UserID = :userID";
                            $userStatement = $db->prepare($userQuery);
                            $userStatement->bindValue(':userID', $row['UserID']);
                            $userStatement->execute();
                            $userRow = $userStatement->fetch();

                            echo $userRow[1];
                            ?>

                            in Category:  <?= $row['CategoryName']?>
                        </p>

                    </div>
                </div>
            <?php endwhile ?>
        </div>


</body>
</html>
