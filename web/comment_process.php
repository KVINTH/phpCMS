<?php
require 'connect.php';
require 'constants.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (isset($_POST['g-recaptcha-response']))
{

    $recaptcha = new \ReCaptcha\Recaptcha($secret);

    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

    if ($resp->isSuccess())
    {
        if ($_POST && isset($_POST['content'])
                   && !empty($_POST['content'])
                   && isset($_POST['userid'])
                   && !empty($_POST['userid'])
                   && isset($_POST['postid'])
                   && !empty($_POST['postid']))
        {
           $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $userID = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
           $postID = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);

           $userID = intval($userID);
           $postID = intval($postID);

           $query = "INSERT INTO comments (Content, PostID, UserID) VALUES (:content, :post, :user)";

           $statement = $db->prepare($query);

           $statement->bindValue(':content', $content);
           $statement->bindValue(':user', $userID);
           $statement->bindValue('post', $postID);

           if ($statement->execute())
           {
               header('Location: ' . $_SERVER['HTTP_REFERER']);

               // header('Location: ' . );

           }


        }
        else
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

    }
    else
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}




?>
