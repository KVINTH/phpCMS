<?php
require '../connect.php';
require 'authenticate.php';
if ($_POST['submit'] == 'Delete')
{
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // DELETE FROM `categories` WHERE `categories`.`CategoryID` = 7
    $query = "DELETE FROM categories WHERE CategoryID = :id";
    $statement = $db->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    if ($statement->execute())
    {
        header('Location: editcategories.php');
        exit;
    }
    else
    {
        header('Refresh: 5; URL=editcategories.php');
        echo    "The category cannot be deleted.<br/>
                 Update the category of existing posts to delete this one.<br/>
                 You will be redirected within 5 seconds. ";
    }

}
else if ($_POST['submit'] == 'Create')
{
    $categoryName = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (strlen($categoryName) > 3)
    {
        $query = "INSERT INTO categories (CategoryID, CategoryName) VALUES (NULL, :name)";

        $statement = $db->prepare($query);

        $statement->bindValue(':name', $categoryName);

        if ($statement->execute())
        {
            header('Location: editcategories.php');
            exit;
        }
    }
    else
    {
        header('Refresh: 5; URL=editcategories.php');
        echo "Category Name must be atleast 3 characters. <br/>";
        echo "You will be redirected within 5 seconds.";
    }


}

 ?>
