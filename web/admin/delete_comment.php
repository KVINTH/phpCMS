<?php
require '../connect.php';
require 'authenticate.php';
if ($_POST['submit'] == 'Delete')
{
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // DELETE FROM `categories` WHERE `categories`.`CategoryID` = 7
    $query = "DELETE FROM comments WHERE CommentID = :id";
    $statement = $db->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    if ($statement->execute())
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>
