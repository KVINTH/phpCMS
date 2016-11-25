<?php if (isset($_SESSION['loggedin'])
        && $_SESSION['loggedin'] == true
        && isset($_SESSION['isadmin'])
        && $_SESSION['isadmin'] == true): ?>
    <p>
        <a href="admin">Administration Panel</a>
    </p>
<?php else: ?>
    <p>
    </p>
<?php endif ?>
