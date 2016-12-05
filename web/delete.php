<?php
require 'connect.php';
session_start();
if ($_POST['delete'] == 'Delete')
{
    // gets the currently logged in user id
    $id = $_SESSION['userid'];

    // Creates a query to select the profile picture path
    $pictureQuery = "SELECT ProfilePicPath FROM users WHERE UserID = :UserID";

    // Prepares the SQL statement to get the profile picture path
    $pictureStatement = $db->prepare($pictureQuery);

    // Binds the userID to the statement
    $pictureStatement->bindValue(':UserID', $id, PDO::PARAM_INT);

    // Executes the query
    $pictureStatement->execute();

    // Stores all the rows found by query in a variable
    $pictureRow = $pictureStatement->fetch();

    // Stores the profile picture path in a variable
    $picturePath = $pictureRow[0];

    // Creates a query to set the profile picture path to the default path
    $query = "UPDATE users SET ProfilePicPath = 'images/profile_pictures/default.jpg' WHERE UserID = :UserID";

    // Prepares the SQL statement to set the profile picture path
    $statement = $db->prepare($query);

    // Binds the userID to the statement
    $statement->bindValue(':UserID', $id, PDO::PARAM_INT);

    // deletes the old profile picture from the server
    // using the path that was previously stored
    unlink($picturePath);

    if ($statement->execute())
    {
        header('Location: profile.php');
        exit;
    }

}
