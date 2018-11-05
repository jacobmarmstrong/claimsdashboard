<?php
?>
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Search by loan number..." />
                    <button class="au-btn--submit" type="submit" name="searchLoan">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="content">
                                <?php
                                $getUserName = $mysqli->query("SELECT firstName, lastName FROM users WHERE id = " . $_SESSION["userID"]);
                                $userNameRow = $getUserName->fetch_assoc();
                                $userName = $userNameRow["firstName"] . " " . $userNameRow["lastName"];
                                ?>
                                <a class="js-acc-btn" href="#"><?php echo $userName; ?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="account-dropdown__body">
                                    <!--<div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                    </div>-->
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="logout.php">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>