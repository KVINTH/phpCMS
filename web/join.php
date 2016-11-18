<?php
$usernameError = $passwordError = $repeatPasswordError = $emailError = $ageError = "";

require 'connect.php';

$username = "";
$password = "";
$email = "";
$gender = "";
$age = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"]) || !isset($_POST["username"])) {
        $usernameError = "Username is required <br />";
    }
    else if (strlen($_POST["username"]) < 3 || strlen($_POST["username"]) > 15) {
        $usernameError = "Username must be between 3 and 15 characters";
    }
    else {
        $usernameError = "";
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
    else if (intval($_POST["age"]) < 12) {
        $ageError = "You must be over the age of 12 to join.";
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

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>yourSPACE </title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css" />
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
                <form action="join.php" method="post">
                    <fieldset>
                        <legend>
                            New Member
                        </legend>
                        <p>
                            <label for="title">Username: </label>
                            <input name="username" id="username" />
                            <span class="error">* <?php echo $usernameError; ?></span>
                        </p>
                        <p>
                            <label for="password">Password: </label>
                            <input name="password" type="password" id="password" />
                            <span class="error">* <?php echo $passwordError; ?></span>
                        </p>
                        <p>
                            <label for="password">Repeat Password: </label>
                            <input name="repeat_password" type="password" id="repeat_password" />
                            <span class="error">* <?php echo $repeatPasswordError; ?></span>
                        </p>
                        <p>
                            <label for="email">Email: </label>
                            <input name="email" type="email" id="email" />
                            <span class="error">* <?php echo $emailError; ?></span>
                        </p>
                        <p>
                            <label for="age">Age: </label>
                            <input name="age" type="number" id="age" />
                            <span class="error">* <?php echo $ageError; ?></span>
                        </p>
                        <p>
                            <label for="gender">Gender: </label>
                            <select name="gender" id="gender">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </p>
                        <p>
                            <input name="submit" type="submit" value="Create" />
                        </p>
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>
