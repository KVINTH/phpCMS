<!-- TOP BAR -->
<header id ="topheader">
    <a href="index.php"><img name="logo" id="logo" src="images/logo.jpg" alt="logo"></a>
    <input name="search" id="search" type="search" />
    <input name="searchimage" id="searchimage" type="image" src="images/search.jpg" />
</header>
<div id="topprofile">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <?= $_SESSION['username'] ?> | <?=$_SESSION['userid'] ?>
    <?php else: ?>
    <?php endif ?>
</div>
