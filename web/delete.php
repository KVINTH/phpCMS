<?php
require 'connect.php';
session_start();
if ($_POST['delete'] == 'Delete')
{
    $id = $_SESSION['userid'];

    // Find filename of current Profile profile_pictures
    $pictureQuery = "SELECT ProfilePicPath FROM users WHERE UserID = :UserID";
    $pictureStatement = $db->prepare($pictureQuery);
    $pictureStatement->bindValue(':UserID', $id, PDO::PARAM_INT);
    $pictureStatement->execute();
    $pictureRow = $pictureStatement->fetch();
    $picturePath = $pictureRow[0];

    $query = "UPDATE users SET ProfilePicPath = 'images/profile_pictures/default.jpg' WHERE UserID = :UserID";

    $statement = $db->prepare($query);

    $statement->bindValue(':UserID', $id, PDO::PARAM_INT);

    $path = 'images/profile_pictures/' . $id;

    echo $picturePath;
    unlink($picturePath);

    if ($statement->execute())
    {
        header('Location: profile.php');
        exit;
    }

}
