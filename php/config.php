<?php
define("DBNAME", "projetphp");
define("DBHOST", "localhost");
define("DBPASS", "");
define("DBUSER", "root");

$dsn = "mysql:dbname=" . DBNAME . ";dbhost=" . DBHOST;
try {
    //connect into the database
    $db = new PDO($dsn, DBUSER, DBPASS);

    //defini le jeux de caractere
    $db->exec("SET NAMES utf8");

    //defini le valeur de retour entant que des tableaux associatifs
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die($e->getMessage());
}