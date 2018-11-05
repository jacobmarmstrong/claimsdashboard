<?php
if (isset($_POST["searchLoan"])) { // if user is searching for loan
    $searchLoan = $mysqli->prepare("SELECT id FROM loans WHERE loanNumber = ?") or die ("There was an error with the database connection. " . $mysqli->error);
    $searchLoan->bind_param("i",$_POST["search"]) or die ("There was an error with the database connection. " . $mysqli->error);
    $searchLoan->execute() or die ("There was an error with the database connection. " . $mysqli->error);
    $res = $searchLoan->get_result();
    if ($res->num_rows == 1) { // if result
        $row = $res->fetch_assoc();
        header("Location: loan.php?id=" . $row["id"]); // send to loan page
        exit();
    } else {
        header("Location: loan.php?msg=1");
        exit();
    }
}
?>