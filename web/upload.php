<?php
session_start();
require 'connect.php';
require 'ResizeImage.php';
$userid = $_SESSION['userid'];

$target_dir = "images/profile_pictures/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOK = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);


if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOK = 1;
    }
    else {
        echo "File is not an image.";
        $uploadOK = 0;
    }
}

/*
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOK = 0;
}
*/

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOK = 0;
}
// Allow certain file formats
if($imageFileType != "jpg"
&& $imageFileType != "png"
&& $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOK = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOK == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "images/profile_pictures/{$userid}.{$imageFileType}")) {

        $query = "UPDATE users SET ProfilePicPath = '/images/profile_pictures/{$userid}.{$imageFileType}' WHERE UserID = :UserID";
        $statement = $db->prepare($query);

        $id = $_SESSION['userid'];
        $statement->bindValue(':UserID', $id, PDO::PARAM_INT);

        $resize = new ResizeImage("images/profile_pictures/$userid.$imageFileType");

        $path = "images/profile_pictures/{$userid}.{$imageFileType}";

        $resize->resizeTo(100, 100, 'maxWidth');
        $resize->saveImage($path);

        if ($statement->execute())
        {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            header('Location: profile.php');
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
