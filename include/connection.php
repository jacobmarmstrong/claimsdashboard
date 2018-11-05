<?php
$mysqli = new mysqli("localhost","root","","claims");
if ($mysqli->connect_errno) {
    die("Failed to connect to the database: " . $mysqli->connect_error);
}
?>
