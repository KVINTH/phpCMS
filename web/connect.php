<?php
## ##########################################
## PDO connection to ClearDB
## This code was found at
## https://github.com/plehr/Heroku-and-PDO
$dbstr = getenv('CLEARDB_DATABASE_URL');
if (!empty($dbstr))
{
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

    try {
        $dbanfang = 'mysql:host=' . $dbhost . ';dbname=' . $dbname;
        $db = new PDO($dbanfang, $dbuser, $dbpassword);
    } catch (PDOException $e) {
        print "Error: " . $e -> getMessage();
        die();
    }
}
else
{
    require('constants.php');
    define('DB_DSN', 'mysql:host=localhost;dbname=cms;charset=utf8');
    define('DB_USER', $dbUser);
    define('DB_PASS', $dbPass);
    $dbstr = getenv('CLEARDB_DATABASE_URL');
    $db = "";
    try{
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e -> getMessage();
        die();
    }
}
