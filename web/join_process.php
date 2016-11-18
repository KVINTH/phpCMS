<?php
require 'connect.php';

$username = "";
$password = "";
$email = "";
$gender = "";
$age = "";


$usernameError = "";
$passwordError = "";
$emailError = "";
$genderError = "";
$ageError = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"]) || !isset($_POST["username"])) {
        $usernameError = "Username is required <br />";
    }
    else if (strlen($_POST["username"]) > 15 || strlen($_POST["username"] < 3)){
        $usernameError = "Username must be between 3 and 15 characters";
    }
    else {
        $username = test_input($_POST["username"]);

    }

    if (empty($_POST["password"])) {
        $passwordError = "Password is required <br />";
    }
    else if (strlen($_POST["password"]) < 8 || strlen($_POST["password"]) > 50)
    {
        $passwordError = "Password must be between 8 and 50 characters";
    }
    else if ($_POST["password"] != $_POST["repeat_password"])
    {
        $passwordError = "Passwords do not match";
    }
    else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["email"])) {
        $emailError = "Email is required <br />";
    }
    else {
        $email = test_input($_POST["email"]);
    }

    if (empty($_POST["age"])) {
        $ageError = "Age is required <br />";
    }
    else {
        $age = test_input($_POST["age"]);
    }


    $gender = $_POST["gender"];


    if ($_POST && isset($_POST['username'])
               && isset($_POST['password'])
               && isset($_POST['repeat_password'])
               && isset($_POST['email'])
               && isset($_POST['age'])

               && !empty($_POST['username'])
               && !empty($_POST['password'])
               && !empty($_POST['repeat_password'])
               && !empty($_POST['email'])
               && !empty($_POST['age']))
    {

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);

        $pass = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, email, age, gender) VALUES (:username, :pass, :email, :age, :gender)";
        $statement = $db->prepare($query);

        $statement->bindValue(':username', $username);
        $statement->bindValue(':pass', $pass);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':age', $age);
        $statement->bindValue(':gender', $gender);

        if ($statement->execute()) {
            header('Location: index.php');
            exit;
        } else {
            echo "username is already taken \n";
        }
    }
    else
    {
        echo $usernameError;
        echo $passwordError;
        echo $emailError;
        echo $genderError;
        echo $ageError;
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}





?>
