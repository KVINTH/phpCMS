<?php
    require 'connect.php';
    session_start();
    $query = "SELECT * FROM pages ORDER BY PageID DESC";

    $statement = $db->prepare($query);

    $statement->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>yourSPACE </title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
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
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <div id="newpost">
                <?php include('newpost.php') ?>
            </div>
            <?php include('feed.php') ?>
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
