<?php
session_start();
require '../include/mysqli_connect.php';

if (isset($_SESSION["adminid"])) {
    unset($_SESSION["adminid"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminid = mysqli_real_escape_string($dbc, $_POST['adminid']);
    $password = mysqli_real_escape_string($dbc, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE adminid = '$adminid' and password = '$password' and activation=true LIMIT 1";
    $result = $dbc->query($sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION["adminid"] = $row["adminid"];
            echo '<script>alert("Welcome back , ' . $row["name"] . '")</script>';
            header("location: home.php");
            exit();
        }
    } else {
        echo '<script>alert("Invalid Account or Password !\nAny help please contact your manager!")</script>';
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Log in</title>

        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center h1">
                    <b>Admin</b>Tradee
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="AdminID" name="adminid">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                    <!--<span class="fas fa-address-card"></span>-->
                                    <!--<span class="fas fa-envelope"></span>-->
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </form>

                    <p class="mb-1">
                        <a href="">Forgot password</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>