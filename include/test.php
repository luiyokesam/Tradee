<?php
session_start();
//require '../database_connection.php';
//include '../Loading.php';
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../bootstrap/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../bootstrap/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="../bootstrap/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../bootstrap/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../bootstrap/plugins/summernote/summernote-bs4.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../boostrap/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../boostrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../boostrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../boostrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../boostrap/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../bootstrap/plugins/daterangepicker/daterangepicker.css">
    <script src="../boostrap/plugins/jquery/jquery.min.js"></script>
    <script src="../boostrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../boostrap/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../boostrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../boostrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../boostrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../boostrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../boostrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../boostrap/plugins/jszip/jszip.min.js"></script>
    <script src="../boostrap/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../boostrap/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../boostrap/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../boostrap/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../boostrap/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="../boostrap/dist/js/adminlte.min.js"></script>
    <script src="../boostrap/plugins/moment/moment.min.js"></script>
    <script src="../boostrap/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="../boostrap/plugins/daterangepicker/daterangepicker.js"></script>
</head>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="index.php" class="navbar-brand">
            <img class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">LETS BID SDN BHD</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Auctions</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="All_Auctions.php" class="dropdown-item">All Auctions</a></li>
                        <li><a href="Upload_Auction.php" class="dropdown-item" <?php
                            if (!isset($_SESSION["Current_User"])) {
                                echo "style='display:none'";
                            }
                            ?>>Upload An Auctions</a></li>
                        <li><a href="My_Auctions.php" class="dropdown-item" <?php
                            if (!isset($_SESSION["Current_User"])) {
                                echo "style='display:none'";
                            }
                            ?>>My Auctions</a></li>
                        <li><a href="My_Win_Bidding_Auction.php" class="dropdown-item" <?php
                            if (!isset($_SESSION["Current_User"])) {
                                echo "style='display:none'";
                            }
                            ?>>Won Bidding Auctions</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">About Us</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="Contact_Us.php" class="dropdown-item">Contact Us</a></li>
                    </ul>
                </li>
                <li class="nav-item" style="display:<?php
                if (isset($_SESSION["Current_User"])) {
                    echo "block";
                } else {
                    echo "none";
                }
                ?>">
                    <a href="Mail_Box.php" class="nav-link">
                        Mail Box 
                        <span class="right badge badge-danger"><?php
                            if (isset($_SESSION["Current_User"])) {
                                $sql = "SELECT COUNT(`No`) FROM `mail_box` WHERE `User_Id` = '{$_SESSION["Current_User"]["User_Id"]}' AND `Seen` = 'No'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo $row[0];
                                        break;
                                    }
                                } else {
                                    echo "0";
                                }
                            }
                            ?></span>
                    </a>
                </li>
                <li class="nav-item dropdown" style="display:<?php
                if (isset($_SESSION["Current_User"])) {
                    echo "block";
                } else {
                    echo "none";
                }
                ?>">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">More</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="My_Bidding_History.php" class="dropdown-item">My Bidding History</a></li>
                        <li><a href="Transactions.php" class="dropdown-item">Transactions</a></li>
                        <li><a href="My_Credit_Transfer_History.php" class="dropdown-item">Credit Transfer History</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" <?php
        if (isset($_SESSION["Current_User"])) {
            echo "style='display:none'";
        }
        ?>>
            <li><a href="Login.php" class="dropdown-item">Login</a></li>
            <li><a href="Register.php" class="dropdown-item" style="color:green">Register</a></li>
        </ul>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" <?php
        if (!isset($_SESSION["Current_User"])) {
            echo "style='display:none'";
        }
        ?>>
            <li><a href="Profile.php" class="dropdown-item" style="color:blue"><?php
                    if (isset($_SESSION["Current_User"])) {
                        echo $_SESSION["Current_User"]["Name"];
                    }
                    ?></a></li>
            <li><a href="Log_Out.php" class="dropdown-item" style="color:red">Log Out</a></li>
        </ul>
    </div>
</nav>
<script src="../bootstrap/plugins/jquery/jquery.min.js"></script>
<script src="../bootstrap/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="../bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../bootstrap/plugins/chart.js/Chart.min.js"></script>
<script src="../bootstrap/plugins/sparklines/sparkline.js"></script>
<script src="../bootstrap/plugins/moment/moment.min.js"></script>
<script src="../bootstrap/plugins/daterangepicker/daterangepicker.js"></script>
<script src="../bootstrap/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../bootstrap/plugins/summernote/summernote-bs4.min.js"></script>
<script src="../bootstrap/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="../bootstrap/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="../bootstrap/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../bootstrap/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="../bootstrap/plugins/jquery-knob/jquery.knob.min.js"></script>

<script src="../bootstrap/dist/js/adminlte.js"></script>
<script src="../bootstrap/dist/js/pages/dashboard.js"></script>
<script src="../bootstrap/dist/js/demo.js"></script>