<?php
require 'connect.php';
require_once __DIR__ . '/../vendor/autoload.php';
use JasonGrimes\Paginator;
session_start();
    // This query gets a list of all categories for the advanced search function
    $categoryQuery = "SELECT * FROM categories ORDER BY CategoryID ASC";
    $categoryStatement = $db->prepare($categoryQuery);
    $categoryStatement->execute();
    if (!isset($_GET['category']))
    {
        $input = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // This query gets all the Posts with the specified search content
        $query = "SELECT * FROM posts WHERE PostContent LIKE '%$input%'";
        $statement = $db->prepare($query);

        // The query above will not work with a bound value
        $statement->bindValue(':input', $input);
        $statement->execute();

        $totalItems = count($statement->fetch());
        $itemsPerPage = 5;
        $currentPage = 1;
       $urlPattern = '/foo/page/(:num)';

       $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
    }
    else if (isset($_GET['category']))
    {
        $input = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $categoryInput = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM posts WHERE PostContent LIKE '%$input%' AND CategoryID = :categoryID";
        $statement = $db->prepare($query);

        //$statement->bindValue(':input', $input);
        $statement->bindValue(':categoryID', $categoryInput);
        $statement->execute();

        $totalItems = count($statement->fetch());
        $itemsPerPage = 5;
        $currentPage;
       echo $totalItems;
    }


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>yourSPACE </title>
    <link rel="stylesheet" type="text/css" href="/stylesheet.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
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
        <div id="advsearch">
            <form action="/search.php">
                <fieldset>
                    <legend>
                        Advanced Search
                    </legend>
                    <p>
                        <label for="search">Search</label>
                        <input name="search" id="search" />
                    </p>
                    <p>
                        <label for="category">Category</label>
                        <select name="category">
                            <?php while ($categoryRow = $categoryStatement->fetch()): ?>
                                <option name="category" id="category" value="<?=$categoryRow['CategoryID']?>"><?=$categoryRow['CategoryName']?></option>
                            <?php endwhile ?>
                        </select>
                    </p>
                    <p>
                        <input name="submit" type="submit" value="Advanced Search"/>
                    </p>
                </fieldset>
            </form>
        </div>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <div id ="feed">
                <?php $i = 1 ?>
                <?php while($row = $statement->fetch()): ?>
                    <div class="feed">
                        <header>
                            <h4><a href="posts/<?=$row['PostID']?>.php"><?=$row['PostTitle']?></a></h4>
                            <h4>
                                <?= $row['PostDate'] ?>

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
                                ... <a href="posts/<?=$row['PostID']?>.php">Read more</a>
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

                            </p>

                        </div>
                    </div>
                <?php endwhile ?>
            </div>
        <?php else: ?>
            <p>
                Please log in to see this page.
            </p>
        <?php endif ?>

    </div>

</div>
<div class="footer">
    <?php include('footer.php') ?>
</div>
</body>
</html>
