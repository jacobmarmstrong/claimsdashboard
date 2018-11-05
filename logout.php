<?php
session_start();
unset($_SESSION['userID']);
unset($_SESSION['time']);
header("Location: login.php"); // send to login page
exit();
?>