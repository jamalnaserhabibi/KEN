<?php
$server = "localhost";
$username = "root";
$passwd = "";
try {
    $connect = new PDO("mysql:host=$server;dbname=kendb", $username, $passwd);

} catch (PDOException $e) {
    echo($e->getMessage());
}
?>