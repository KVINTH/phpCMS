<?php
require 'connect.php';
if ($_POST['submit'] == 'Delete')
{
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM posts WHERE PostID = :id";
    $statement = $db->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    if ($statement->execute())
    {
        header('Location: index.php');
        exit;
    }

}
if ($_POST && isset($_POST['title'])
           && isset($_POST['content'])
           && !empty($_POST['title'])
           && !empty($_POST['content'])
        /* && isset($_POST['userid'])
           && !empty($_POST['userid'])) */
){
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($_POST['submit'] == "Create")
        {
            $categoryID = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
            $userID = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);

            $userID = intval($userID);
            // INSERT INTO `posts` (`PostID`, `PostTitle`, `PostContent`, `PostDate`, `EditDate`, `CategoryID`, `UserID`) VALUES (NULL, ':title', ':content', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000', '4', '32')
            $query = "INSERT INTO posts (PostTitle, PostContent, CategoryID, UserID) VALUES (:title, :content, :category, :user)";
            $statement = $db->prepare($query);

            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':category', $categoryID);
            //$statement->bindValue(':useridnumber', $userID);
            $statement->bindValue(':user', $userID);
        }
        else if ($_POST['submit'] == "Update")
        {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            $editdate = time();

            $query = "UPDATE posts SET PostTitle = :title, PostContent = :content WHERE PostID = :id";
            $statement = $db->prepare($query);

            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            //$statement->bindValue(':editdate', $editdate);
        }
        if ($statement->execute())
        {
            header('Location: index.php');
            exit;
        }

}
 ?>
