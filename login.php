<?php
require('include/checkLogin.php'); // check user's login
require('include/connection.php'); // connect to MySQL
$error = null; // error string
if (isset($_POST['submit'])) { // once user submits form
    if (!strpos($_POST['email'],'@') || !strpos($_POST['email'], '.') || empty($_POST['email'])) { // throws error if email doesn't contain '@' or '.' or if it's empty
        $error .= "Please enter a valid email address.";
    }
    if (empty($_POST['password'])) { // throws error if password is empty
        $error .= "<br /> Please enter a password.";
    }
    if (empty($error)) { // if no error, lookup user
        if (!$searchUsers = $mysqli->prepare("SELECT id, password FROM Users WHERE email = ?")) {
            die("There was an error with the database connection. " . $mysqli->error);
        }
        if (!$searchUsers->bind_param('s',$_POST['email'])) {
            die("There was an error with the database connection. " . $mysqli->error);
        }
        if (!$searchUsers->execute()) {
            die("There was an error with the database connection. " . $mysqli->error);
        }
        $res = $searchUsers->get_result();
        if ($res->num_rows == 1) { // user with email found
            $row = $res->fetch_assoc();
            if (password_verify($_POST['password'],$row["password"])) { // successful login
                $_SESSION['userID'] = $row["id"];
                $_SESSION['time'] = new DateTime("now");
                header("Location: index.php");
            } else { // incorrect password
                $error .= "Invalid login credentials. Please try again.";
            }
        } else { // email not found
            $error .= "Invalid login credentials. Please try again.";
        }
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

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.jpg" alt="ClaimsDashboard">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <?php
                                if (!empty($error)) { // if errors, print them out
                                    ?>
                                    <div class="form-group" style="text-align:center;">
                                        <span style="color: red;"><?php echo $error; ?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>
                                <!--<div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label>
                                    <label>
                                        <a href="#">Forgotten Password?</a>
                                    </label>
                                </div>-->
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="submit">sign in</button>
                                <!--<div class="social-login-content">
                                    <div class="social-button">
                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">sign in with facebook</button>
                                        <button class="au-btn au-btn--block au-btn--blue2">sign in with twitter</button>
                                    </div>
                                </div>-->
                            </form>
                            <div class="register-link">
                                <p>
                                    <a href="#">Forgot Password</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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