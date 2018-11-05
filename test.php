<?php
require('include/connection.php');
$testQuery = $mysqli->query("SELECT A.nextTaskID, (SELECT days FROM tasklist WHERE id = A.nextTaskID) AS days
    FROM tasklist A
    WHERE id = 9");
if ($testQuery->fetch_assoc()["nextTaskID"]) {
    $testQuery->data_seek(0);
    $queryRow = $testQuery->fetch_assoc();
    echo $queryRow["nextTaskID"];
} else {
    echo "No";
}
?>
