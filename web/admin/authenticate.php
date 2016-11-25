<?php
session_start();
    if (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] == false)
    {
        header('Location: ../index.php');
        exit;
    }
    else {

    }
?>
