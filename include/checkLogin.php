<?php
session_start();
if (isset($_SESSION['userID']) && isset($_SESSION['time'])) {
    if ($_SESSION['time']->diff(new DateTime('now'))->format("%h") > 0) { // unsets user's sessions if logged in for more than an hour
        unset($_SESSION['userID']);
        unset($_SESSION['time']);
        header("Location: login.php?msg=1"); // send to login page
        exit();
    } else {
        $_SESSION['time'] = new DateTime("now"); // resets user login time
        if (basename($_SERVER['PHP_SELF']) == "login.php") { // if logged in and access login page, send to index page
            header("Location: index.php");
            exit();
        }
    }
} else {
    if (basename($_SERVER['PHP_SELF']) != "login.php") { // if not logged in, send to login page
        header("Location: login.php");
        exit();
    }
}
?>