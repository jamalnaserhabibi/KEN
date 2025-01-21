<?php
session_start();

function user_logged_in()
{
    if (!isset($_SESSION['thid'])) {
        header("Location:login.php");
        exit(0);
    }
}

function user_type_is($types = array())
{
    if (!isset($_SESSION['thetype']) or !in_array($_SESSION['thetype'], $types)) {
        header("Location:login.php");
        exit(0);
    }
}

?>