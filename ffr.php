<?php
require('include/checkLogin.php');
require('include/connection.php');
require('include/searchLoan.php');
$error = null;
if (isset($_GET['function'])) {
    $function = $_GET['function']; // function is either delete or edit
} else {
    header("Location: admin.php?page=3");
}
if (isset($_GET['id'])) {
    $id = $_GET['id']; // id of loan type
    $getFFRType = $mysqli->query("SELECT * FROM ffr WHERE id = $id AND description <> 'Manual Entry'") or die ("There was an error with the database connection. " . $mysqli->error);
    $FFRTypeRow = $getFFRType->fetch_assoc();
} else {
    header("Location: admin.php?page=3"); // redirect if no id sent to page
}
if (isset($_POST["cancel"])) {
    header("Location: admin.php?page=3"); // redirect if user clicks cancel
    exit();
}
if (isset($_POST["edit"])) {
    if (empty($_POST['description'])) {
        $error .= "You must enter a description.";
    }
    if (empty($error)) {
        $update = $mysqli->query("UPDATE ffr SET description = '" . addslashes($_POST['description']) . "' WHERE id = $id AND description <> 'Manual Entry'") or die ("There was an error with the database connection. " . $mysqli->error);
        header("Location: admin.php?page=3");
        exit();
    }
}
if (isset($_POST["delete"])) { // check for active loans with ffr type before soft deleting
    $checkForLoans = $mysqli->query("SELECT COUNT(*) AS total FROM loans WHERE ffrType = $id AND status = 1") or die ("There was an error with the database connection. " . $mysqli->error);
    if ($checkForLoans->fetch_assoc()["total"] == 0) { // if no loans with ffr type, then do soft delete
        $delete = $mysqli->query("UPDATE ffr SET softDelete = 1 WHERE id = $id AND description <> 'Manual Entry'") or die ("There was an error with the database connection. " . $mysqli->error);
        header("Location: admin.php?page=3");
        exit();
    } else { // don't do soft delete if active loans with ffr type
        $error .= "You cannot delete this foreclosure/forfeiture type because there are active loans using it.";
    }
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
    <script type="text/javascript">
        function ChangeColor(tableRow, highLight)
        {
            if (highLight)
            {
                tableRow.style.backgroundColor = '#dcfac9';
            }
            else
            {
                tableRow.style.backgroundColor = 'white';
            }
        }

        function DoNav(theUrl)
        {
            document.location.href = theUrl;
        }
    </script>
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
                                    <h2 class="title-1">Edit <?php echo $FFRTypeRow["description"]; ?></h2>
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
                                        <label for="description" class="control-label mb-1">Description: </label>
                                        <input type="text" name="description" value="<?php echo $FFRTypeRow["description"]; ?>" class="form-control"/>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
                                        <button type="submit" name="edit" class="btn btn-primary">Edit Foreclosure/Forfeiture Type
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    } elseif ($function == "delete") { // delete loan type
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Delete <?php echo $FFRTypeRow["description"]; ?></h2>
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
                                        <p><br /> Are you sure you want to delete this foreclosure/forfeiture type? (Note: You can only delete
                                            this foreclosure/forfeiture type if there are no active loans under this foreclosure/forfeiture type.)</p>
                                        <br />
                                        <button type="submit" class="btn btn-secondary" name="cancel">Cancel</button>
                                        <button type="submit" name="delete" class="btn btn-primary">Delete Foreclosure/Forfeiture Type
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
