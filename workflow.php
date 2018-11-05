<?php
require('include/checkLogin.php');
require('include/connection.php');
require('include/searchLoan.php');
$error = null;
function moveElement(&$array, $a, $b) {
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
}
if (isset($_GET['function'])) {
    $function = $_GET['function']; // function is either delete or edit
} else {
    header("Location: admin.php?page=4");
}
if (isset($_GET['loanType']) && isset($_GET['ffrType'])) {
    $loanType = $_GET['loanType']; // id of loan type
    $ffrType = $_GET['ffrType']; // id of ffr type
    $getEnums = $mysqli->query("SELECT (SELECT description FROM loantypes WHERE id = $loanType) AS loanType, (SELECT description FROM ffr WHERE id = $ffrType) AS ffrType") or die ("There was an error with database connection. " . $mysqli->error);
    $enumsRow = $getEnums->fetch_assoc();
} else {
    header("Location: admin.php?page=4"); // redirect if no id sent to page
}
if (isset($_POST["cancel"])) {
    header("Location: workflow.php?loanType=$loanType&ffrType=$ffrType&function=$function"); // redirect if user clicks cancel
    exit();
}
if (isset($_POST["edit"])) {
    if (empty($_POST['title'])) {
        $error .= "You must enter a task title. <br />";
    }
    if (empty($_POST['body'])) {
        $error .= "You must enter a task body. <br />";
    }
    if (empty($_POST['days'])) {
        $error .= "You must enter the number of days it should take to complete the task. <br />";
    }
    if (!is_numeric($_POST['days'])) {
        $error .= "The number of days to complete the task must be a number. <br />";
    }
    if ($_POST['nextTask'] == 0) { // user selected the option "there are no other tasks," so will reassign to no next task
        $_POST['nextTask'] = "NULL";
    }
    if ($_POST['order'] == 0) { // user selected the option "there are no other tasks," so will reassign to last task
        $_POST['order'] = 1;
    }
    if (empty($error)) {
        if ($_POST['originalOrder'] != ($_POST['order'] - 1)) { // check if order changed (have to re-order all tasks if so)
            $getOrder = $mysqli->query("SELECT id FROM tasklist A WHERE A.loanType = $loanType AND A.ffrType = $ffrType ORDER BY A.listOrder") or die ("There was an error with the database connection. " . $mysqli->error);
            $taskList = array();
            while ($orderRow = $getOrder->fetch_assoc()) {
                array_push($taskList,$orderRow["id"]);
            }
            moveElement($taskList,($_POST["originalOrder"] - 1),($_POST['order'] - 1)); // reorders tasks
            for ($i = 1; $i < count($taskList); $i++) { // update sort order
                $update = $mysqli->query("UPDATE tasklist SET listOrder = $i WHERE id = " . $taskList[$i - 1]) or die ("There was an error with the database connection. " . $mysqli->error);
            }
        }
        $update = $mysqli->query("UPDATE tasklist SET title = '" . $_POST['title'] . "', body = '" . addslashes($_POST['body']) . "', days = " . $_POST['days'] . ", nextTaskID = " . $_POST['nextTask'] ." WHERE id = " . $_POST['currentTask']) or die ("There was an error with the database connection. " . $mysqli->error);
        header("Location: workflow.php?loanType=$loanType&ffrType=$ffrType&function=$function");
        exit();
    }
}
if (isset($_POST["delete"])) { // check for active loans with loantype before soft deleting

}
if (isset($_POST["add"])) { // add new task

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
                    <?php
                    if ($function == "edit") { // edit loan type
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Edit Workflow</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        <p><br /> Loan Type: <?php echo $enumsRow["loanType"]; ?> <br />
                                            Foreclosure/Forfeiture Type: <?php echo $enumsRow["ffrType"]; ?></p>
                                    </div>
                                    <div class="table-data__tool-right">
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#addNewTask">
                                            <i class="zmdi zmdi-plus"></i>add task</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (!empty($error)) {
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><br /><b><?php echo $error; ?></b></p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="table-responsive table--no-card m-b-40">
                                        <table class="table table-borderless table-striped table-earning">
                                            <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Task Title</th>
                                                <th>Task Description</th>
                                                <th>Days to Complete</th>
                                                <th>Next Task</th>
                                                <th>Repeat?</th>
                                                <th style="text-align: center;">Edit</th>
                                                <th style="text-align: center;">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getTasks = $mysqli->query("SELECT A.*, (SELECT title FROM tasklist WHERE id = A.nextTaskID) AS nextTaskTitle, (SELECT id FROM repeattask WHERE taskID = A.id) AS repeattask FROM tasklist A WHERE A.loanType = $loanType AND A.ffrType = $ffrType ORDER BY A.listOrder") or die ("There was an error with the database connection. " . $mysqli->error);
                                                while ($taskRow = $getTasks->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $taskRow["listOrder"]; ?></td>
                                                        <td><?php echo $taskRow["title"]; ?></td>
                                                        <td><?php echo substr($taskRow["body"],0,20); if(strlen($taskRow["body"]) > 20) { echo "..."; }; ?></td>
                                                        <td><?php echo $taskRow["days"]; ?></td>
                                                        <td><?php echo $taskRow["nextTaskTitle"]; ?></td>
                                                        <td><?php if (!empty($taskRow["repeattask"])) { echo "Yes"; } else { echo "No"; } ?></td>
                                                        <td>
                                                            <div class="table-data-feature">
                                                                <button class="item" data-toggle="modal" data-target="#editTask<?php echo $taskRow["id"]; ?>" data-placement="top" title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-data-feature">
                                                                <button class="item" data-toggle="modal" data-target="#deleteTask<?php echo $taskRow["id"]; ?>"  data-placement="top" title="Delete">
                                                                    <i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } elseif ($function == "delete") { // delete loan type
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Delete <?php echo $loanTypeRow["description"]; ?></h2>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (!empty($error)) {
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><br /><b><?php echo $error; ?></b></p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <p><br /> Are you sure you want to delete this loan type? (Note: You can only delete
                                            this loan type if there are no active loans under this loan type.)</p>
                                        <br />
                                        <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
                                        <button type="submit" name="delete" class="btn btn-primary">Delete Loan Type
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    require('include/footer.php');
                    ?>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- start of create task modal -->
        <div class="modal fade" id="addNewTask" tabindex="-1" role="dialog" aria-labelledby="addNewTaskLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewTaskLabel">Add New Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?loanType=$loanType&ffrType=$ffrType&function=edit"; ?>" method="post">
                        <div class="modal-body" style="text-align: center;">
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="title" class=" form-control-label">Title: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <input type="text"
                                           id="title"
                                           name="titleNew"
                                           value="<?php if(isset($_POST['titleNew'])) { echo $_POST['titleNew']; } ?>"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="body" class=" form-control-label">Body: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <textarea name="bodyNew" id="body" rows="5" class="form-control"><?php if(isset($_POST['bodyNew'])) { echo $_POST['bodyNew']; } ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="days" class=" form-control-label">Days to Complete: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <input type="text"
                                           id="days"
                                           name="daysNew"
                                           value="<?php if(isset($_POST['daysNew'])) { echo $_POST['daysNew']; } ?>"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="nextTask" class=" form-control-label">Next Task: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <select name="nextTaskNew"
                                            id = "nextTask"
                                            class="form-control">
                                        <option value="-1" <?php if(isset($_POST['nextTaskNew']) && $_POST['nextTaskNew'] == "NULL") { echo 'selected="selected"'; } ?>>No Next Task</option>
                                        <?php
                                        $getOtherTasks = $mysqli->query("SELECT id, title FROM tasklist WHERE loanType = $loanType AND ffrType = $ffrType ORDER BY listOrder") or die ("There was an error with the database connection. " . $mysqli->error);
                                        if ($getOtherTasks->num_rows == 0) {
                                            echo '<option value="0">No Other Tasks -- Add Others or Select "No Next Task"</option>';
                                        } else {
                                            while($otherTasksRow = $getOtherTasks->fetch_assoc()) {
                                                echo '<option value="' . $otherTasksRow['id'] . '"';
                                                if ($_POST['nextTaskNew'] == $otherTasksRow["id"]) { echo ' selected="selected"'; }
                                                echo '>' . $otherTasksRow['title'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="order" class=" form-control-label">Before: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <select name="orderNew"
                                            id = "order"
                                            class="form-control">
                                        <?php
                                        $getOtherTasks = $mysqli->query("SELECT id, title, listOrder FROM tasklist WHERE loanType = $loanType AND ffrType = $ffrType ORDER BY listOrder") or die ("There was an error with the database connection. " . $mysqli->error);
                                        if ($getOtherTasks->num_rows == 0) {
                                            echo '<option value="0">No Other Tasks -- Add Others or Select "No Next Task"</option>';
                                        } else {
                                            while($otherTasksRow = $getOtherTasks->fetch_assoc()) {
                                                echo '<option value="' . $otherTasksRow['id'] . '"';
                                                if ($_POST['orderNew'] == ($otherTasksRow["listOrder"] - 1)) { echo ' selected="selected"'; }
                                                echo '>' . $otherTasksRow['title'] . '</option>';
                                            }
                                        }
                                        ?>
                                        <option value="-1" <?php if(isset($_POST['orderNew']) && $_POST['orderNew'] == 1) { echo 'selected="selected"'; } ?>>Last Task</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="add" class="btn btn-primary">Add Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of create task modal -->
        <?php
        $getTasks->data_seek(0);
        while ($taskRow = $getTasks->fetch_assoc()) {
        ?>
        <!--start of edit task modals-->
        <div class="modal fade" id="editTask<?php echo $taskRow["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="editTask<?php echo $taskRow["id"]; ?>Label"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTask<?php echo $taskRow["id"]; ?>Label">Edit <?php echo $taskRow["title"]; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?loanType=$loanType&ffrType=$ffrType&function=edit"; ?>" method="post">
                        <div class="modal-body" style="text-align: center;">
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="title" class=" form-control-label">Title: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           value="<?php echo $taskRow["title"]; ?>"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="body" class=" form-control-label">Body: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <textarea name="body" id="body" rows="5" class="form-control"><?php echo stripslashes($taskRow["body"]); ?></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="days" class=" form-control-label">Days to Complete: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <input type="text"
                                           id="days"
                                           name="days"
                                           value="<?php echo $taskRow["days"]; ?>"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="nextTask" class=" form-control-label">Next Task: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <select name="nextTask"
                                            id = "nextTask"
                                            class="form-control">
                                        <option value="-1" <?php if (empty($taskRow["nextTaskID"])) { echo 'selected="selected"'; } ?>>No Next Task</option>
                                        <?php
                                        $getOtherTasks = $mysqli->query("SELECT id, title FROM tasklist WHERE id <> " . $taskRow["id"] . " AND loanType = $loanType AND ffrType = $ffrType ORDER BY listOrder") or die ("There was an error with the database connection. " . $mysqli->error);
                                        if ($getOtherTasks->num_rows == 0) {
                                            echo '<option value="0">No Other Tasks -- Add Others or Select "No Next Task"</option>';
                                        } else {
                                            while($otherTasksRow = $getOtherTasks->fetch_assoc()) {
                                                echo '<option value="' . $otherTasksRow['id'] . '"';
                                                if ($taskRow["nextTaskID"] == $otherTasksRow["id"]) { echo ' selected="selected"'; }
                                                echo '>' . $otherTasksRow['title'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-6" style="text-align: right;">
                                    <label for="order" class=" form-control-label">Before: </label>
                                </div>
                                <div class="col-12 col-md-6" style="text-align: left;">
                                    <select name="order"
                                            id = "order"
                                            class="form-control">
                                        <?php
                                        $getOtherTasks = $mysqli->query("SELECT id, title, listOrder FROM tasklist WHERE id <> " . $taskRow["id"] . " AND loanType = $loanType AND ffrType = $ffrType ORDER BY listOrder") or die ("There was an error with the database connection. " . $mysqli->error);
                                        if ($getOtherTasks->num_rows == 0) {
                                            echo '<option value="0">No Other Tasks -- Add Others or Select "No Next Task"</option>';
                                        } else {
                                            while($otherTasksRow = $getOtherTasks->fetch_assoc()) {
                                                echo '<option value="' . $otherTasksRow['id'] . '"';
                                                if ($taskRow["listOrder"] == ($otherTasksRow["listOrder"] - 1)) { echo ' selected="selected"'; }
                                                echo '>' . $otherTasksRow['title'] . '</option>';
                                            }
                                        }
                                        ?>
                                        <option value="-1" <?php if (empty($taskRow["nextTaskID"])) { echo 'selected="selected"'; }?>>Last Task</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="originalOrder" value="<?php echo $taskRow["listOrder"]; ?>" />
                            <input type="hidden" name="currentTask" value="<?php echo $taskRow["id"]; ?>" />
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="edit" class="btn btn-primary">Edit Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of edit task modals-->
        <!-- start of delete task modals-->
            <div class="modal fade" id="deleteTask<?php echo $taskRow["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteTask<?php echo $taskRow["id"]; ?>Label"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteTask<?php echo $taskRow["id"]; ?>Label">Delete <?php echo $taskRow["title"]; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . "?loanType=$loanType&ffrType=$ffrType&function=delete"; ?>" method="post">
                            <div class="modal-body" style="text-align: center;">
                                <div class="row form-group">
                                    <p>Are you sure you want to delete this task? </p>
                                    <p>(Note: You cannot delete a task if it is still active for any loans or if it is the only task in a workflow.)</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="currentTask" value="<?php echo $taskRow["id"]; ?>" />
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="delete" class="btn btn-primary">Delete Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>


        <!-- end of delete task modals-->
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
