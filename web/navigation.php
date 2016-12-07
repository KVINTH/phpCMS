<ul id="menu">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <li><a href="/profile.php" name="profile">Profile</a></li>
        <li><a href="/index.php" name="news">News Feed</a></li>
        <li><a href="/logout.php" name="logout">Logout</a></li>
        <!--<li><a href="?link=logout" name="logout">Logout</a></li> -->
    <?php else: ?>
        <li><a href="/join.php" name="signup">Sign Up</a></li>
        <!-- <li><a href="?link=join" name="signup">Sign Up</a></li> -->
        <li><a href="/login.php" name="login">Login</a></li>
        <!-- <li><a href="?link=login" name="login">Login</a></li> -->
    <?php endif ?>
</ul>
