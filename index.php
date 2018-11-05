<?php
require('include/checkLogin.php');
require('include/connection.php');
require('include/searchLoan.php');
if (!isset($_GET["pagination"])) {
    $pagination = 1;
} else {
    $pagination = $_GET["pagination"];
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Welcome back!</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row m-t-25">
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c1">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-account-o"></i>
                                            </div>
                                            <div class="text">
                                                <h2>50</h2>
                                                <span>Claims Filed MTD</span>
                                            </div>
                                        </div>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-shopping-cart"></i>
                                            </div>
                                            <div class="text">
                                                <h2>84.71%</h2>
                                                <span>Recovery Rate MTD</span>
                                            </div>
                                        </div>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c3">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-calendar-note"></i>
                                            </div>
                                            <div class="text">
                                                <h2>97 days</h2>
                                                <span>Referral to Write-off MTD</span>
                                            </div>
                                        </div>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c4">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="text">
                                                <h2>$1,060,386</h2>
                                                <span>Total Claim Money MTD</span>
                                            </div>
                                        </div>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25"><?php if ($page == 1) { echo "Personal Dashboard"; } elseif ($page == 2) { echo "All Loans"; } ?></h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Loan Number</th>
                                                <th>Borrower Name</th>
                                                <th>Loan Type</th>
                                                <th>FCL/FFR</th>
                                                <th>Next Task</th>
                                                <th>Next Task Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($page == 1) {
                                            $getLoans = $mysqli->query("SELECT A.*, B.description AS loanTypeDescription, C.description AS ffrTypeDescription, CASE WHEN D.dueDate IS NULL THEN 'N/A' ELSE D.dueDate END AS dueDate, CASE WHEN E.title IS NULL THEN 'N/A' ELSE E.title END AS title FROM loans A JOIN loanTypes B ON A.loanType = B.id JOIN ffr C ON A.ffrType = C.id LEFT JOIN loanleveltasks D ON A.id = D.loanID AND D.completedDate IS NULL LEFT JOIN tasklist E ON D.taskID = E.id WHERE A.loanType IN (SELECT Z.loanType FROM assignments Z WHERE Z.userID = " . $_SESSION["userID"] . ") AND A.status = 1 ORDER BY COALESCE((SELECT Y.dueDate FROM loanleveltasks Y WHERE Y.loanID = A.id AND Y.completedDate IS NULL),'1990-01-01') DESC, A.id LIMIT " . ((($pagination - 1) * 10)) . ", 10") or die ("There was an error with the database connection. " . $mysqli->error);
                                        } elseif ($page == 2) {
                                            $getLoans = $mysqli->query("SELECT A.*, B.description AS loanTypeDescription, C.description AS ffrTypeDescription, CASE WHEN D.dueDate IS NULL THEN 'N/A' ELSE D.dueDate END AS dueDate, CASE WHEN E.title IS NULL THEN 'N/A' ELSE E.title END AS title FROM loans A JOIN loanTypes B ON A.loanType = B.id JOIN ffr C ON A.ffrType = C.id LEFT JOIN loanleveltasks D ON A.id = D.loanID AND D.completedDate IS NULL LEFT JOIN tasklist E ON D.taskID = E.id WHERE A.status = 1 ORDER BY COALESCE((SELECT Y.dueDate FROM loanleveltasks Y WHERE Y.loanID = A.id AND Y.completedDate IS NULL),'1990-01-01') DESC, A.id LIMIT " . ((($pagination - 1) * 10)) . ", 10") or die ("There was an error with the database connection. " . $mysqli->error);
                                        }
                                        if (!$getLoans->num_rows) {

                                        } else {
                                            while ($loansRow = $getLoans->fetch_assoc()) {
                                                ?>
                                                <tr onmouseover="ChangeColor(this, true);"
                                                    onmouseout="ChangeColor(this, false);"
                                                    onclick="DoNav('loan.php?id=<?php echo $loansRow["id"]; ?>');">
                                                    <td><?php echo $loansRow["loanNumber"]; ?></td>
                                                    <td><?php echo $loansRow["borrowerName"]; ?></td>
                                                    <td><?php echo $loansRow["loanTypeDescription"]; ?></td>
                                                    <td><?php echo $loansRow["ffrTypeDescription"]; ?></td>
                                                    <td><?php echo $loansRow["title"]; ?></td>
                                                    <td><?php if ($loansRow["dueDate"] == "N/A") { echo "N/A"; } else { echo DateTime::createFromFormat('Y-n-j', $loansRow["dueDate"])->format("n/j/Y"); } ?></td>
                                                </tr>
                                                <?php
                                            } // end of loans
                                        } // end of check for loans
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <?php
                                // pagination
                                if ($page == 1) {
                                    $getNumberofPages = $mysqli->query("SELECT COUNT(*) AS total FROM loans WHERE loanType IN (SELECT Z.loanType FROM assignments Z WHERE Z.userID = " . $_SESSION["userID"] . ") AND status = 1") or die ("There was an error with the database connection. " . $mysqli->error);
                                } elseif ($page == 2) {
                                    $getNumberofPages = $mysqli->query("SELECT COUNT(*) AS total FROM loans WHERE status = 1") or die ("There was an error with the database connection. " . $mysqli->error);
                                }

                                $numberofPages = ceil($getNumberofPages->fetch_assoc()["total"] / 10);
                                if ($pagination != 1) { // previous page link if current page isn't page 1
                                    ?>
                                    <a href="index.php?page=<?php echo $page; ?>&pagination=<?php echo $pagination - 1; ?>"><button type="button" class="btn btn-primary"><<</button></a>
                                    <?php
                                }
                                for ($i = 0; $i < $numberofPages; $i++) { // page number link for each page number
                                    ?>
                                    <a href="index.php?page=<?php echo $page; ?>&pagination=<?php echo $i + 1; ?>"><button type="button" class="btn <?php if ($pagination == ($i + 1)) { echo "btn-secondary"; } else { echo "btn-primary"; } ?>"><?php echo $i + 1; ?></button></a>
                                <?php
                                }
                                if ($pagination != $numberofPages) { // next page link if current page isn't last page
                                    ?>
                                    <a href="index.php?page=<?php echo $page; ?>&pagination=<?php echo $pagination + 1; ?>"><button type="button" class="btn btn-primary">>></button></a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
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
