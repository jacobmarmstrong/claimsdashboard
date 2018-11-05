<?php
$getRole = $mysqli->query("SELECT roleID FROM users WHERE id = '" . $_SESSION["userID"] . "'") or die ("There was an error with the database connection. " . $mysqli->error);
$row = $getRole->fetch_assoc() or die ("There was an error with the database connection. " . $mysqli->error);
$userRole = $row["roleID"];
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
?>
<div class="menu-sidebar__content js-scrollbar1">
    <nav class="navbar-sidebar">
        <ul class="list-unstyled navbar__list">
            <li class="<?php if (basename($_SERVER['PHP_SELF']) == "index.php") { echo "active "; } ?>has-sub">
                <a class="js-arrow" href="#">
                    <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                <ul class="list-unstyled navbar__sub-list js-sub-list">
                    <li<?php if ($page == 1 && basename($_SERVER['PHP_SELF']) == "index.php") { echo ' class="active"'; } ?>>
                        <a href="index.php?page=1">My Dashboard</a>
                    </li>
                    <li<?php if ($page == 2 && basename($_SERVER['PHP_SELF']) == "index.php") { echo ' class="active"'; }?>>
                        <a href="index.php?page=2">All Loans</a>
                    </li>
                </ul>
            </li>
            <?php
            if ($userRole > 1) {
                ?>
                <li class="<?php if (basename($_SERVER['PHP_SELF']) == "admin.php") { echo "active "; } ?>has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tachometer-alt"></i>Administrator</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li<?php if ($page == 1 && basename($_SERVER['PHP_SELF']) == "admin.php") { echo ' class="active"'; } ?>>
                            <a href="admin.php?page=1">Admin Dashboard</a>
                        </li>
                        <li<?php if ($page == 2 && basename($_SERVER['PHP_SELF']) == "admin.php") { echo ' class="active"'; } ?>>
                            <a href="admin.php?page=2">Loan Types</a>
                        </li>
                        <li<?php if ($page == 3 && basename($_SERVER['PHP_SELF']) == "admin.php") { echo ' class="active"'; }?>>
                            <a href="admin.php?page=3">Foreclosure/Forfeiture Types</a>
                        </li>
                        <li<?php if ($page == 4 && basename($_SERVER['PHP_SELF']) == "admin.php") { echo ' class="active"'; }?>>
                            <a href="admin.php?page=4">Workflows</a>
                        </li>
                        <li<?php if ($page == 5 && basename($_SERVER['PHP_SELF']) == "admin.php") { echo ' class="active"'; }?>>
                            <a href="admin.php?page=5">Add Loan</a>
                        </li>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
</div>