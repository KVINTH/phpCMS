<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/stylesheet.css" />
    <title>User Logon</title>
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
            <h2>User Login </h2>
                <div>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
                        <p>
                            You are already logged in. <br />

                            <a href="logout.php">click here to log out</a>
                        </p>
                    <?php else: ?>
                        <form name="login" method="post" action="login_process.php">
                            Username: <input type="text" name="username"><br>
                            Password: <input type="password" name="password"><br>
                            Remember Me: <input type="checkbox" name="rememberme" value="1"><br>
                            <input type="submit" name="submit" value="Login!">
                        </form>
                    <?php endif ?>
                </div>
            </body>
            </div>
        </div>


</html>
