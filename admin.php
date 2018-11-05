<?php
require('include/checkLogin.php');
require('include/connection.php');
require('include/searchLoan.php');
if (!isset($_GET["pagination"])) {
    $pagination = 1;
} else {
    $pagination = $_GET["pagination"];
}
if (isset($_POST['addLoanType'])) {
    $createLoanType = $mysqli->prepare("INSERT INTO loantypes (description) VALUES (?)") or die ("There was an error with the database connection. " . $mysqli->error);
    $createLoanType->bind_param("s",$_POST['loanTypeDescription']);
    $createLoanType->execute() or die ("There was an error with the database connection. " . $mysqli->error);
    header("Location: admin.php?page=2");
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
                        if ($page == 1) { // admin dashboard
                            ?>

                            <?php
                        } elseif ($page == 2) { // loan types
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Loan Types</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-data__tool">
                                        <div class="table-data__tool-left">
                                        </div>
                                        <div class="table-data__tool-right">
                                            <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#addNewLoanType">
                                                <i class="zmdi zmdi-plus"></i>add loan type</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-12">
                                    <div class="table-responsive table--no-card m-b-40">
                                        <table class="table table-borderless table-striped table-earning">
                                            <thead>
                                            <tr>
                                                <th>Loan Type Description</th>
                                                <th style="text-align: center;">Edit</th>
                                                <th style="text-align: center;">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $getLoanTypes = $mysqli->query("SELECT * FROM loantypes WHERE softDelete = 0 ORDER BY description") or die ("There was an error with the database connection. " . $mysqli->error);
                                            if (!$getLoanTypes->num_rows) {
                                                
                                            } else {
                                                while ($loanTypesRow = $getLoanTypes->fetch_assoc()) {
                                                    ?>
                                                    <tr onmouseover="ChangeColor(this, true);"
                                                        onmouseout="ChangeColor(this, false);">
                                                        <td><?php echo $loanTypesRow["description"]; ?></td>
                                                        <td style="text-align:center;">
                                                            <div class="table-data-feature">
                                                                <a href="loanType.php?id=<?php echo $loanTypesRow["id"]; ?>&function=edit">
                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="zmdi zmdi-edit"></i>
                                                                    </button>
                                                                </a>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <div class="table-data-feature">
                                                                <a href="loanType.php?id=<?php echo $loanTypesRow["id"]; ?>&function=delete">
                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <i class="zmdi zmdi-delete"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } // end of loan types
                                            } // end of check for loan types
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } elseif ($page == 3) { // ffr types
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Foreclosure/Forfeiture Types</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-data__tool">
                                        <div class="table-data__tool-left">
                                        </div>
                                        <div class="table-data__tool-right">
                                            <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#addNewFFRType">
                                                <i class="zmdi zmdi-plus"></i>add FFR type</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table--no-card m-b-40">
                                        <table class="table table-borderless table-striped table-earning">
                                            <thead>
                                            <tr>
                                                <th>Foreclosure/Forfeiture Description</th>
                                                <th style="text-align: center;">Edit</th>
                                                <th style="text-align: center;">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $getFFRTypes = $mysqli->query("SELECT * FROM ffr WHERE softDelete = 0 AND description <> 'Manual Entry' ORDER BY description") or die ("There was an error with the database connection. " . $mysqli->error);
                                            if (!$getFFRTypes->num_rows) {

                                            } else {
                                                while ($FFRTypesRow = $getFFRTypes->fetch_assoc()) {
                                                    ?>
                                                    <tr onmouseover="ChangeColor(this, true);"
                                                        onmouseout="ChangeColor(this, false);">
                                                        <td><?php echo $FFRTypesRow["description"]; ?></td>
                                                        <td style="text-align:center;">
                                                            <div class="table-data-feature">
                                                                <a href="ffr.php?id=<?php echo $FFRTypesRow["id"]; ?>&function=edit">
                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                    </button>
                                                                </a>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <div class="table-data-feature">
                                                                <a href="ffr.php?id=<?php echo $FFRTypesRow["id"]; ?>&function=delete">
                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <i class="zmdi zmdi-delete"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } // end of ffr types
                                            } // end of check for ffr types
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } elseif ($page == 4) { // workflows
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Workflows</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-data__tool">
                                        <div class="table-data__tool-left">
                                        </div>
                                        <div class="table-data__tool-right">
                                            <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#addNewWorkflow">
                                                <i class="zmdi zmdi-plus"></i>add workflow</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table--no-card m-b-40">
                                        <table class="table table-borderless table-striped table-earning">
                                            <thead>
                                            <tr>
                                                <th>Loan Type</th>
                                                <th>Foreclosure/Forfeiture Type</th>
                                                <th style="text-align: center;">Edit</th>
                                                <th style="text-align: center;">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $getWorkflows = $mysqli->query("SELECT loanType, ffrType FROM tasklist GROUP BY loanType, ffrType") or die ("There was an error with the database connection. " . $mysqli->error);
                                            if (!$getWorkflows->num_rows) {

                                            } else {
                                                while ($workflowsRow = $getWorkflows->fetch_assoc()) {
                                                    $getEnums = $mysqli->query("SELECT (SELECT description FROM loantypes WHERE id = " . $workflowsRow["loanType"] . ") AS loanType, (SELECT description FROM ffr WHERE id = " . $workflowsRow["ffrType"] . ") AS ffrType") or die ("There was an error with database connection. " . $mysqli->error);
                                                    $enumsRow = $getEnums->fetch_assoc();
                                                    ?>
                                                    <tr onmouseover="ChangeColor(this, true);"
                                                        onmouseout="ChangeColor(this, false);">
                                                        <td><?php echo $enumsRow["loanType"]; ?></td>
                                                        <td><?php echo $enumsRow["ffrType"]; ?></td>
                                                        <td style="text-align:center;">
                                                            <div class="table-data-feature">
                                                                <a href="workflow.php?loanType=<?php echo $workflowsRow["loanType"]; ?>&ffrType=<?php echo $workflowsRow["ffrType"]; ?>&function=edit">
                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                        <i class="zmdi zmdi-edit"></i>
                                                                    </button>
                                                                </a>
                                                        </td>
                                                        <td style="text-align:center;">
                                                            <div class="table-data-feature">
                                                                <a href="workflow.php?loanType=<?php echo $workflowsRow["loanType"]; ?>&ffrType=<?php echo $workflowsRow["ffrType"]; ?>&function=delete">
                                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                        <i class="zmdi zmdi-delete"></i>
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } // end of workflows
                                            } // end of check for workflows
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
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
            <!--Modal for adding a new loan type-->
            <div class="modal fade" id="addNewLoanType" tabindex="-1" role="dialog" aria-labelledby="addNewLoanType"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewLoanTypeLabel">Add Loan Type</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . "?page=2"; ?>" method="post">
                            <div class="modal-body" style="text-align: center;">
                                <div class="row form-group">
                                    <div class="col col-md-6" style="text-align: right;">
                                        <label for="loanTypeDescription"
                                               class=" form-control-label">Loan Type Description:
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-6" style="text-align: left;">
                                        <input type="text"
                                               id="loanTypeDescription"
                                               name="loanTypeDescription"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="addLoanType" class="btn btn-primary">Add Loan Type</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--End of modal for adding a new loan type-->
            <!--Modal for adding a new FFR type-->
            <div class="modal fade" id="addNewFFRType" tabindex="-1" role="dialog" aria-labelledby="addNewFFRType"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewFFRTypeLabel">Add Foreclosure/Forfeiture Type</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . "?page=3"; ?>" method="post">
                            <div class="modal-body" style="text-align: center;">
                                <div class="row form-group">
                                    <div class="col col-md-6" style="text-align: right;">
                                        <label for="FFRTypeDescription"
                                               class=" form-control-label">Foreclosure/Forfeiture Type Description:
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-6" style="text-align: left;">
                                        <input type="text"
                                               id="FFRTypeDescription"
                                               name="FFRTypeDescription"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="addFFRType" class="btn btn-primary">Add Foreclosure/Forfeiture Type</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--End of modal for adding a new FFR type-->
            <!--Modal for adding a new workflow-->
            <div class="modal fade" id="addNewWorkflow" tabindex="-1" role="dialog" aria-labelledby="addNewWorkflow"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewWorkflowLabel">Add Workflow</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . "?page=4"; ?>" method="post">
                            <div class="modal-body" style="text-align: center;">
                                <div class="row form-group">
                                    <div class="col col-md-6" style="text-align: right;">
                                        <label for="loanType"
                                               class=" form-control-label">Loan Type: </label>
                                    </div>
                                    <div class="col-12 col-md-6" style="text-align: left;">
                                        <select name="loanType"
                                                id = "loanType"
                                                class = "form-control">
                                            <?php
                                            $getLoanTypes = $mysqli->query("SELECT id, description FROM loantypes WHERE softDelete = 0 ORDER BY description") or die ("There was an error with the dataabse connection. " . $mysqli->error);
                                            if (!$getLoanTypes->num_rows) {
                                                echo '<option value="0">No Loan Types -- Please Add One</option>';
                                            } else {
                                                while ($loanTypesRow = $getLoanTypes->fetch_assoc()) {
                                                    echo '<option value="' . $loanTypesRow["id"] . '">' . $loanTypesRow["description"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6" style="text-align: right;">
                                        <label for="ffrType"
                                               class=" form-control-label">Foreclosure/Forfeiture Type: </label>
                                    </div>
                                    <div class="col-12 col-md-6" style="text-align: left;">
                                        <select name="ffrType"
                                                id = "ffrType"
                                                class = "form-control">
                                            <?php
                                            $getFFRTypes = $mysqli->query("SELECT id, description FROM ffr WHERE softDelete = 0 ORDER BY description") or die ("There was an error with the dataabse connection. " . $mysqli->error);
                                            if (!$getFFRTypes->num_rows) {
                                                echo '<option value="0">No Foreclosure/Forfeiture Types -- Please Add One</option>';
                                            } else {
                                                while ($FFRTypesRow = $getFFRTypes->fetch_assoc()) {
                                                    echo '<option value="' . $FFRTypesRow["id"] . '">' . $FFRTypesRow["description"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="addWorkflow" class="btn btn-primary">Add Workflow</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--End of modal for adding a new workflow-->
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
