<?php
require('include/checkLogin.php');
require('include/connection.php');
require('include/searchLoan.php');
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: index.php");
    exit();
}
if (isset($_POST['complete'])) {
    $getData = $mysqli->query("SELECT * FROM taskdata WHERE taskID = " . $_GET["task"]) or die ("There was an error with the database connection. " . $mysqli->error);
    if ($getData->num_rows > 0) {
        while ($taskData = $getData->fetch_assoc()) { //insert data for completed task
            if ($taskData["dataType"] == "text" || $taskData["dataType"] == "select") {
                $table = "loanleveltaskdatatext";
            } elseif ($taskData["dataType"] == "decimal") {
                $table = "loanleveltaskdatadecimal";
            } elseif ($taskData["dataType"] == "date") {
                $table = "loanleveltaskdatadate";
            }
            $insertData = $mysqli->query("INSERT INTO $table (loanID, taskID, dataName, dataValue) VALUES ($id, " . $_GET["uniqueTaskID"] . ", '" . $taskData["dataName"] . "', '" . $_POST[str_replace(" ","", $taskData["dataName"])] . "')") or die ("There was an error with the database connection. " . $mysqli->error);
        }
    }
    $completeTask = $mysqli->query("UPDATE loanleveltasks SET completedDate = NOW() WHERE id = " . $_GET["uniqueTaskID"]) or die ("There was an error with the database connection. " . $mysqli->error); //insert completed date for task
    $getNextTask = $mysqli->query("SELECT A.nextTaskID, (SELECT days FROM tasklist WHERE id = A.nextTaskID) AS days
    FROM tasklist A
    WHERE id = " . $_GET["task"]) or die ("There was an error with the database connection. " . $mysqli->error);
    if ($getNextTask->fetch_assoc()["nextTaskID"]) {
        $getNextTask->data_seek(0);
        $nextTask = $getNextTask->fetch_assoc();
        $checkRepeat = $mysqli->query("SELECT A.taskID, A.conditionName, A.conditionValue, A.conditionTask, B.* FROM repeattask A JOIN tasklist B ON A.nextTaskID = B.id WHERE A.taskID = " . $_GET["task"]) or die ("There was an error with the database connection. " . $mysqli->error); // check if task needs to repeat
        if ($checkRepeat->num_rows) {
            $repeatRow = $checkRepeat->fetch_assoc();
            $checkCondition = $mysqli->query("SELECT COUNT(*) AS total FROM " . substr($repeatRow["conditionName"],0,strpos($repeatRow["conditionName"],".")) . " A WHERE A." . substr($repeatRow["conditionName"],strpos($repeatRow["conditionName"],".") + 1) . " = '" . $repeatRow["conditionValue"] . "' AND (SELECT taskID FROM loanleveltasks WHERE id = A.taskID) = " . $repeatRow["conditionTask"] . " AND A.taskID = (SELECT MAX(id) FROM loanleveltasks WHERE taskID = " . $repeatRow["conditionTask"] . ")") or die ("There was an error with database connection. " . $mysqli->error);
            if ($checkCondition->fetch_assoc()["total"] != 0) {
                $createTask = $mysqli->query("INSERT INTO loanleveltasks (loanID, taskID, dueDate) VALUES ($id, " . $repeatRow["id"] . ", '" . date('Y-m-d', strtotime('today + ' . $repeatRow["days"] . ' days')) . "')") or die ("There was an error with the database connection. " . $mysqli->error); //create next task
            } else {
                $createTask = $mysqli->query("INSERT INTO loanleveltasks (loanID, taskID, dueDate) VALUES ($id, " . $nextTask["nextTaskID"] . ", '" . date('Y-m-d', strtotime('today + ' . $nextTask["days"] . ' days')) . "')") or die ("There was an error with the database connection. " . $mysqli->error); //create next task
            }
        } else {
            $createTask = $mysqli->query("INSERT INTO loanleveltasks (loanID, taskID, dueDate) VALUES ($id, " . $nextTask["nextTaskID"] . ", '" . date('Y-m-d', strtotime('today + ' . $nextTask["days"] . ' days')) . "')") or die ("There was an error with the database connection. " . $mysqli->error); //create next task
        }
    }
    header("Location: loan.php?id=$id"); // redirect if no next task (loan should be done in claims)
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Claims Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <!--<header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.php">
                            <img src="images/icon/logo.jpg" alt="ClaimsDashboard" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="index.html">Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="chart.html">
                                <i class="fas fa-chart-bar"></i>Charts</a>
                        </li>
                        <li>
                            <a href="table.html">
                                <i class="fas fa-table"></i>Tables</a>
                        </li>
                        <li>
                            <a href="form.html">
                                <i class="far fa-check-square"></i>Forms</a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-calendar-alt"></i>Calendar</a>
                        </li>
                        <li>
                            <a href="map.html">
                                <i class="fas fa-map-marker-alt"></i>Maps</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="login.html">Login</a>
                                </li>
                                <li>
                                    <a href="register.html">Register</a>
                                </li>
                                <li>
                                    <a href="forget-pass.html">Forget Password</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="button.html">Button</a>
                                </li>
                                <li>
                                    <a href="badge.html">Badges</a>
                                </li>
                                <li>
                                    <a href="tab.html">Tabs</a>
                                </li>
                                <li>
                                    <a href="card.html">Cards</a>
                                </li>
                                <li>
                                    <a href="alert.html">Alerts</a>
                                </li>
                                <li>
                                    <a href="progress-bar.html">Progress Bars</a>
                                </li>
                                <li>
                                    <a href="modal.html">Modals</a>
                                </li>
                                <li>
                                    <a href="switch.html">Switchs</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grids</a>
                                </li>
                                <li>
                                    <a href="fontawesome.html">Fontawesome Icon</a>
                                </li>
                                <li>
                                    <a href="typo.html">Typography</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>-->
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    Claims Dashboard
                    <!--<img src="images/icon/logo.jpg" alt="Cool Admin" />-->
                </a>
            </div>
            <?php
            require('include/sidebar.php');
            ?>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php
            require('include/header.php');
            ?>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                    <?php
                                    if (isset($msg) && $msg == 1) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            Loan number not found. Try again.
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                                        <?php
                                    } else {
                                        $getLoan = $mysqli->query("SELECT A.*, B.description AS loantype, C.description AS ffrType 
                                        FROM loans A 
                                        JOIN loantypes B ON A.loanType = B.id
                                        JOIN ffr C ON A.ffrType = C.id
                                        WHERE A.id = " . $id) or die ("There was an error with the database connection " . $mysqli->error);
                                        $row = $getLoan->fetch_assoc();
                                        ?>
            <div class="overview-wrap">
                <h2 class="title-1"><?php echo $row["loanNumber"] . " (" . $row["borrowerName"] . ")"; ?></h2>
            </div>
        </div>
    </div>
    <div class="row m-t-25">
        <div class="col-lg-12">
            <div class="progress mb-2">
                <?php
                $getTotalTaskCount = $mysqli->query("SELECT COUNT(*) AS total FROM tasklist WHERE loanType = (SELECT loanType FROM loans WHERE id = $id) AND ffrType = (SELECT ffrType FROM loans WHERE id = $id)") or die ("There was an error with the database connection. " . $mysqli->error);
                $totalTaskCount = $getTotalTaskCount->fetch_assoc()["total"];
                $getCompletedTasks = $mysqli->query("SELECT COUNT(DISTINCT taskID) AS total FROM loanleveltasks WHERE loanID = $id AND completedDate IS NOT NULL") or die ("There was an error with the database connection." . $mysqli->error);
                $completedTaskCount = $getCompletedTasks->fetch_assoc()["total"];
                $percentageComplete = round(($completedTaskCount / $totalTaskCount) * 100);
                ?>
                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $percentageComplete; ?>%" aria-valuenow="<?php echo $percentageComplete; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percentageComplete; ?>%</div>
            </div>
        </div>
    </div>
    <div class="row m-t-25">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Loan Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <table style="text-align:right;" border="0" width="100%;">
                                <tr>
                                    <td>
                                        Loan Type:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Investor:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Type of Foreclosure/Forfeiture:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Foreclosure/Forfeiture Date:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Acquisition Date:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Current UPB:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Current Escrow Balance:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Paid to Date:
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <table border="0">
                                <tr>
                                    <td>
                                        <?php echo $row["loantype"]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $row["investor"]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $row["ffrType"]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo DateTime::createFromFormat('Y-n-j', $row["ffrDate"])->format("n/j/Y"); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php
                                        if (empty($row["acquisitionDate"])) {
                                            echo "N/A";
                                        } else {
                                            echo DateTime::createFromFormat('Y-n-j', $row["ffrDate"])->format("n/j/Y");
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo ($row["upb"] < 0 ? "$(" . (number_format(abs($row["upb"]), 2)) . ")": "$" . number_format($row["upb"], 2)); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo ($row["escrowBalance"] < 0 ? "$(" . (number_format(abs($row["escrowBalance"]), 2)) . ")": "$" . number_format($row["escrowBalance"], 2)); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo DateTime::createFromFormat('Y-n-j', $row["paidToDate"])->format("n/j/Y"); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Next Task</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php
                    $getTask = $mysqli->query("SELECT A.dueDate, A.id AS uniqueTaskID, B.*
                    FROM loanleveltasks A
                    JOIN tasklist B ON A.taskID = B.id
                    WHERE A.loanID = $id AND A.completedDate IS NULL") or die ("There was an error with the database connection. " . $mysqli->error);
                    if ($getTask->num_rows == 0) {
                        echo "<p>No next task.</p>";
                    } else {
                        $task = $getTask->fetch_assoc();
                        ?>

                        <div class="col-6">
                            <table style="text-align:right;" border="0" width="100%">
                                <tr>
                                    <td>
                                        Next Task:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Due Date:
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <table border="0">
                                <tr>
                                    <td>
                                        <?php echo $task["title"]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo DateTime::createFromFormat('Y-n-j', $task["dueDate"])->format("n/j/Y"); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <p style="text-align: center; width: 100%;">
                            <br/>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#largeModal"
                                    style="width: 40%;">
                                Complete Task
                            </button>
                        </p>
                        <?php
                    } // end of next task print out
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Transaction Details</h4>
                </div>
                <div class="card-body">
                    <div class="custom-tab">

                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="custom-nav-home-tab" data-toggle="tab" href="#custom-nav-home" role="tab" aria-controls="custom-nav-home"
                                   aria-selected="true">All Transactions</a>
                                <a class="nav-item nav-link" id="custom-nav-profile-tab" data-toggle="tab" href="#custom-nav-profile" role="tab" aria-controls="custom-nav-profile"
                                   aria-selected="false">Payments</a>
                                <a class="nav-item nav-link" id="custom-nav-contact-tab" data-toggle="tab" href="#custom-nav-contact" role="tab" aria-controls="custom-nav-contact"
                                   aria-selected="false">Escrow</a>
                                <a class="nav-item nav-link" id="custom-nav-contact-tab" data-toggle="tab" href="#custom-nav-contact" role="tab" aria-controls="custom-nav-contact"
                                   aria-selected="false">Expenses</a>
                            </div>
                        </nav>
                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="custom-nav-home" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh
                                    dreamcatcher synth. Cosby sweater eu banh mi, irure terry richardson ex sd. Alip placeat salvia cillum iphone.
                                    Seitan alip s cardigan american apparel, butcher voluptate nisi .</p>
                            </div>
                            <div class="tab-pane fade" id="custom-nav-profile" role="tabpanel" aria-labelledby="custom-nav-profile-tab">
                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh
                                    dreamcatcher synth. Cosby sweater eu banh mi, irure terry richardson ex sd. Alip placeat salvia cillum iphone.
                                    Seitan alip s cardigan american apparel, butcher voluptate nisi .</p>
                            </div>
                            <div class="tab-pane fade" id="custom-nav-contact" role="tabpanel" aria-labelledby="custom-nav-contact-tab">
                                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh
                                    dreamcatcher synth. Cosby sweater eu banh mi, irure terry richardson ex sd. Alip placeat salvia cillum iphone.
                                    Seitan alip s cardigan american apparel, butcher voluptate nisi .</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require('include/footer.php');
    ?>
    </div>
    </div>
    </div>
    <?php
    }
    ?>
            <!-- END MAIN CONTENT-->
    <?php
    if (isset($task)) {
        ?>
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="largeModalLabel"><?php echo $task["title"]; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id&task=" . $task["id"] . "&uniqueTaskID=" . $task["uniqueTaskID"]; ?>" method="post">
                        <div class="modal-body" style="text-align: center;">
                            <p>
                                <?php echo stripslashes($task["body"]); ?>
                                <br/> <br/>
                            </p>
                            <?php
                            $getData = $mysqli->query("SELECT * FROM taskdata WHERE taskID = " . $task["id"]) or die ("There was an error with the database connection. " . $mysqli->error);
                            if ($getData->num_rows > 0) {
                                echo '';
                                while ($taskData = $getData->fetch_assoc()) {
                                    if ($taskData["dataType"] == "decimal") {
                                        $dataType = "text";
                                    } else {
                                        $dataType = $taskData["dataType"];
                                    }
                                    if ($taskData["dataType"] == "select") { // data type is select list
                                        ?>
                                        <div class="row form-group">
                                            <div class="col col-md-6" style="text-align: right;">
                                                <label for="<?php echo str_replace(" ", "", $taskData["dataName"]); ?>"
                                                       class=" form-control-label"><?php echo $taskData["dataName"]; ?>
                                                </label>
                                            </div>
                                            <div class="col-12 col-md-6" style="text-align: left;">
                                                <select name="<?php echo str_replace(" ","", $taskData["dataName"]); ?>"
                                                        id = "<?php echo str_replace(" ","", $taskData["dataName"]); ?>"
                                                        class="form-control">
                                                    <?php
                                                    $possibleValues = explode(",",$taskData["possibleValues"]); // cycle through possible values
                                                    foreach ($possibleValues as $possibleValue) {
                                                        echo '<option value="' . $possibleValue . '">' . $possibleValue . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="row form-group">
                                            <div class="col col-md-6" style="text-align: right;">
                                                <label for="<?php echo str_replace(" ", "", $taskData["dataName"]); ?>"
                                                       class=" form-control-label"><?php echo str_replace(" ", "", $taskData["dataName"]); ?>
                                                    :</label>
                                            </div>
                                            <div class="col-12 col-md-6" style="text-align: left;">
                                                <input type="<?php echo $dataType; ?>"
                                                       id="<?php echo str_replace(" ", "", $taskData["dataName"]); ?>"
                                                       name="<?php echo str_replace(" ", "", $taskData["dataName"]); ?>"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="complete" class="btn btn-primary">Complete Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } // end of task completion box
    ?>
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
