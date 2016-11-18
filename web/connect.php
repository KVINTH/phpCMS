<?php

    define('DB_DSN', 'mysql:host=localhost;dbname=cms;charset=utf8');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    $db = "";
try{
    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
} catch (PDOException $e) {
    print "Error: " . $e -> getMessage();
    die();
}


/*
$dbstr = getenv('CLEARDB_DATABASE_URL');
$dbstr = substr("$dbstr", 8);
$dbstrarruser = explode(":", $dbstr);
//Please don't look at these names. Yes I know that this is a little bit trash :D
$dbstrarrhost = explode("@", $dbstrarruser[1]);
$dbstrarrrecon = explode("?", $dbstrarrhost[1]);
$dbstrarrport = explode("/", $dbstrarrrecon[0]);
$dbpassword = $dbstrarrhost[0];
$dbhost = $dbstrarrport[0];
$dbport = $dbstrarrport[0];
$dbuser = $dbstrarruser[0];
$dbname = $dbstrarrport[1];
unset($dbstrarrrecon);
unset($dbstrarrport);
unset($dbstrarruser);
unset($dbstrarrhost);
unset($dbstr);
/*  //Uncomment this for debug reasons
echo $dbname . " - name<br>";
echo $dbhost . " - host<br>";
echo $dbport . " - port<br>";
echo $dbuser . " - user<br>";
echo $dbpassword . " - passwd<br>";
*/
/*
try {
    $dbanfang = 'mysql:host=' . $dbhost . ';dbname=' . $dbname;
    $db = new PDO($dbanfang, $dbuser, $dbpassword);
} catch (PDOException $e) {
    print "Error: " . $e -> getMessage();
    die();
}



*/






//You can only use this with the standard port!

/*
define('PATH_TO_SSL_CLIENT_KEY_FILE', 'bc369f8fac8ab9-key.pem');
define('PATH_TO_SSL_CLIENT_CERT_FILE', 'bc369f8fac8ab9-cert.pem');
define('PATH_TO_CA_CERT_FILE', 'cleardb-ca.pem');

define('HOSTNAME', '');
define('USERNAME', '');
define('PASSWORD', '');
define('DATABASE_NAME', '');

$db = "";

try {
    $db = mysqli_init();

    $db->ssl_set(PATH_TO_SSL_CLIENT_KEY_FILE, PATH_TO_SSL_CLIENT_CERT_FILE, PATH_TO_CA_CERT_FILE, null, null);
    $db->real_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
} catch (Exception $e) {
    print "Error: " . $e -> getMessage();
    die();
}

*/
?>
