<?php
session_start();
require '../include/mysqli_connect.php';

if (!isset($_SESSION['adminid'])) {
    header("Location: index.php");
    exit();
} else {
    $sql = "SELECT * FROM admin WHERE adminid = '" . $_SESSION['adminid'] . "' LIMIT 1";
    $result = $dbc->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $current_admin = $row;
            break;
        }
    } else {
        echo '<script>alert("Extract data error !\nContact IT department to maintainence");window.location.href = "index.php";</script>';
        exit();
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
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
    </head>
    <body>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="home.php" class="brand-link">
                <img src="../bootstrap/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">Admin</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="admin_details.php?id=<?php echo $current_admin["adminid"] ?>" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    <?php echo $current_admin["name"] ?>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="home.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="admin_list.php" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Admin list
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="customer_list.php" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    Customer list
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="item_list.php" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>
                                    Item list
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="trade_list.php" class="nav-link">
                                <i class="nav-icon fas fa-sync-alt"></i>
                                <p>
                                    Trading list
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="delivery_list.php" class="nav-link">
                                <!--<i class="nav-icon fas fa-box-open"></i>-->
                                <!--<i class="nav-icon fas fa-copy"></i>-->
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    Delivery list
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="event_list.php" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>
                                    Event list
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="feedback_list.php" class="nav-link">
                                <i class="nav-icon fas fa-comment-alt"></i>
                                <p>
                                    Feedback list
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="report.php" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Report
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Log out
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <script src="../bootstrap/plugins/jquery/jquery.min.js"></script>
        <script src="../bootstrap/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <script src="../bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../bootstrap/plugins/chart.js/Chart.min.js"></script>
        <script src="../bootstrap/plugins/sparklines/sparkline.js"></script>
        <script src="../bootstrap/plugins/jquery-knob/jquery.knob.min.js"></script>
        <script src="../bootstrap/plugins/moment/moment.min.js"></script>
        <script src="../bootstrap/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="../bootstrap/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="../bootstrap/plugins/summernote/summernote-bs4.min.js"></script>
        <script src="../bootstrap/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <script src="../bootstrap/dist/js/adminlte.js"></script>
        <script src="../bootstrap/dist/js/pages/dashboard.js"></script>
        <script src="../bootstrap/dist/js/demo.js"></script>
        <script src="../bootstrap/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    </body>
</html>