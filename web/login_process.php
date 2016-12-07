<?php
include 'connect.php';
session_start();
if (isset($_POST['username']) && isset ($_POST['password'])) {


    $query = "SELECT * FROM users WHERE Username = :username LIMIT 1";
    $statement = $db->prepare($query);

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $statement->bindValue('username', $username, PDO::PARAM_STR);
    $statement->execute();

    $row = $statement->fetch();

    $hash = $row['Password'];

    $verified = password_verify($password, $hash);

    if ($verified) {
        if (isset($_POST['rememberme'])) {
            /* Set cookie to last 1 year */
            setcookie('username', $_POST['username'], time() + 60 * 60 * 24 * 365, '/account', 'www.example.com');
            setcookie('password', password_hash($_POST['password'], PASSWORD_DEFAULT), time() + 60 * 60 * 24 * 365, '/account', 'www.example.com');
        } else {
            /* Cookie expires when browser closes */
            setcookie('username', $_POST['username'], false, '/account', 'www.example.com');
            setcookie('password', password_hash($_POST['password'], PASSWORD_DEFAULT), false, '/account', 'www.example.com');
        }

        $role = $row['Role'];
        $userID = $row['UserID'];

        if ($role == 1)
        {
            $_SESSION['isadmin'] = true;
        }

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userID;


        header('Location: index.php');
    } else {
        echo 'Username/Password Invalid';
    }
}
else
{
    echo 'You must supply a username and password.';
}
?>
