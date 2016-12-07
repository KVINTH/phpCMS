<?php
session_start();
require 'connect.php';

$query = "SELECT * FROM users WHERE UserID = :UserID";
$statement = $db->prepare($query);

$id = $_SESSION['userid'];


$statement->bindValue(':UserID', $id, PDO::PARAM_INT);

$statement->execute();

$row = $statement->fetch();

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
            <div id="profilepic">
                <img src="<?=$row['ProfilePicPath']?>">
            </div>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>
            <form action="delete.php" method="post">
                <input type="hidden" value="$id" name="id">
                <input type="submit" value="Delete" name="delete">
            </form>
        </div>
    </div>
</body>
</html>
