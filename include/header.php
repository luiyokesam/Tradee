<?php
ob_start();
session_start();
require '../include/mysqli_connect.php';
include '../user/loading.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!--Bootstrap CSS--> 
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">-->
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
        <!--<link rel='stylesheet' href="../bootstrap/css/bootstrap.css" type="text/css">-->

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

        <link rel="shortcut icon" href="../img/icon/tradee_favicon.svg" type="image/x-icon">

        <!-- Google Font: Source Sans Pro -->
        <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">-->
    </head>
    <body>
        <!-- Optional JavaScript; choose one of the two! -->
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>-->
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>-->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>-->
        <!--<script src="../bootstrap/js/bootstrap.js"></script>-->

        <nav class="navbar  navbar-expand-lg navbar-light sticky-md-top bg-white align-items-center align-content-center p-0 pt-2 pb-1">
            <div class="container-lg d-flex align-content-center align-items-center">
                <div class="d-inline-flex flex-grow-1">
                    <a class="navbar-brand p-0 m-0" href="../php/index.php">
                        <img src="../img/icon/tradee_logo.svg" alt="Logo" style="width:70px;" class="d-inline-block align-text-top">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="toggleMobileMenu">
                        <div style="font-size: 15px;">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link nav-link-header head-higlight pr-0" href="#">Clothing</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link nav-link-header pr-0" href="#">Accessories</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link nav-link-header pr-0" href="#">Services</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle pr-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        About
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li class="dropdown-head" style="font-size: 15px;">Policies</li>
                                        <li><a class="dropdown-item nav-link-header" href="../php/privacy.php">Privacy</a></li>
                                        <li><a class="dropdown-item nav-link-header" href="../php/terms.php">Terms</a></li>
                                        <li><a class="dropdown-item nav-link-header" href="../php/how_it_works.php">How it works</a></li>
                                        <li><a class="dropdown-item nav-link-header" href="../php/trust.php">Trust and safety</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-head" style="font-size: 15px;">Company</li>
                                        <li><a class="dropdown-item nav-link-header" href="../php/about.php">About us</a></li>
                                        <li><a class="dropdown-item nav-link-header" href="#">Event</a></li>
                                        <li><a class="dropdown-item nav-link-header" href="../php/contact.php">Contact</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!--Search bar-->
                    <!--                    <form class="d-flex">
                                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                            <button class="btn btn-outline-success" type="submit">Search</button>
                                        </form>-->

                    <?php
                    if (isset($_SESSION['loginuser'])) {
                        echo "<div class='ml-auto'>"
                        . "<a class='' href='../user/trade_list.php' role='button' style='color: #8791aa; margin-right: 5px;'>"
                        . "<i class='far fa-bell' style='font-size: 1.1em;'></i>"
                        . "</a>"
                        . "<a class='' href='' role='button' style='text-decoration: none; color: #8791aa; margin-right: 5px;'>"
                        . "<i class='far fa-heart' style='font-size: 1.1em;'></i>"
                        . "</a>"
                        . "<ul class='navbar-nav me-0' style='display: inline-block;'>"
                        . "<li class='nav-item dropdown'>"
                        . "<a class='nav-link dropdown-toggle p-0' href=''  id='navbarDropdown' role='button' style='margin-right: 5px;'  data-bs-toggle='dropdown' aria-expanded='false'>"
                        . "<i class='far fa-user-circle' style='font-size: 1.2em;'></i>"
                        . "</a>"
                        . "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>"
                        . "<li><a class='dropdown-item nav-link-header' href='../user/my_profile.php'>Profile</a></li>"
                        . "<li><a class='dropdown-item nav-link-header' href='../user/setting_profile.php'>Settings</a></li>"
                        . "<li><a class='dropdown-item nav-link-header' href='../user/logout.php'>Logout</a></li>"
                        . "</ul>"
                        . "</li>"
                        . "</ul>"
                        . "<a class='btn btn-trade-header mr-1' href='../user/upload_item.php' role='button' style='font-size: 14px;'>Upload now</a>"
                        . "<a class='btn-question' href='#'>"
//                        . "<i class='far fa-question-circle' style='color: #8791aa; font-size: 1.3em;'></i>"
                        . "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='22' height='22'><path d='M10.97 8.265a1.45 1.45 0 00-.487.57.75.75 0 01-1.341-.67c.2-.402.513-.826.997-1.148C10.627 6.69 11.244 6.5 12 6.5c.658 0 1.369.195 1.934.619a2.45 2.45 0 011.004 2.006c0 1.033-.513 1.72-1.027 2.215-.19.183-.399.358-.579.508l-.147.123a4.329 4.329 0 00-.435.409v1.37a.75.75 0 11-1.5 0v-1.473c0-.237.067-.504.247-.736.22-.28.486-.517.718-.714l.183-.153.001-.001c.172-.143.324-.27.47-.412.368-.355.569-.676.569-1.136a.953.953 0 00-.404-.806C12.766 8.118 12.384 8 12 8c-.494 0-.814.121-1.03.265zM13 17a1 1 0 11-2 0 1 1 0 012 0z'></path><path fill-rule='evenodd' d='M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zM2.5 12a9.5 9.5 0 1119 0 9.5 9.5 0 01-19 0z'></path></svg>"
                        . "</a>"
                        . "</div>";
                    } else {
                        echo "<div class='float-right'>"
                        . "<a class='btn btn-login-header me-1' href='../user/login.php' role='button' style='font-size: 14px;'>Sign up | Log in</a>"
                        . "<a class='btn-question' href='#'>"
                        . "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='22' height='22'><path d='M10.97 8.265a1.45 1.45 0 00-.487.57.75.75 0 01-1.341-.67c.2-.402.513-.826.997-1.148C10.627 6.69 11.244 6.5 12 6.5c.658 0 1.369.195 1.934.619a2.45 2.45 0 011.004 2.006c0 1.033-.513 1.72-1.027 2.215-.19.183-.399.358-.579.508l-.147.123a4.329 4.329 0 00-.435.409v1.37a.75.75 0 11-1.5 0v-1.473c0-.237.067-.504.247-.736.22-.28.486-.517.718-.714l.183-.153.001-.001c.172-.143.324-.27.47-.412.368-.355.569-.676.569-1.136a.953.953 0 00-.404-.806C12.766 8.118 12.384 8 12 8c-.494 0-.814.121-1.03.265zM13 17a1 1 0 11-2 0 1 1 0 012 0z'></path><path fill-rule='evenodd' d='M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zM2.5 12a9.5 9.5 0 1119 0 9.5 9.5 0 01-19 0z'></path></svg>"
                        . "</a>"
                        . "</div>";
                    }
                    ?>
                </div>
            </div>
        </nav>

        <!--        <div class="container-fluid border-bottom">
                    <nav class="navbar navbar-expand-lg mb-2">
                        <div class="container-lg">
                            <form class="container-lg d-flex">
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-top rounded-bottom" placeholder="Search...">
                                    <button class="btn btn-outline-secondary mx-2 me-0" type="button" id="button-addon2">Search</button>
                                </div>
                            </form>
                        </div>
                    </nav>
                </div>-->

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
    </body>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /*font-family: "Maison Neue", "Helvetica Neue", "Helvetica-Neue", "Arial", sans-serif;*/
            /*font-family: "Bahnschrift Condensed", Georgia, serif;*/
            font-size: 100%;
        }

        a{
            text-decoration: none;
        }

        .breadcrumb{
            background: #f8f9fa;
            background-color: #f8f9fa;
        }

        .dropdown-head{
            display: block;
            width: 100%;
            padding: .25rem 1rem;
            clear: both;
            font-weight: 400;
            color: #bdb9b9;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            cursor: default;
        }

        .nav-link-header{
            font-size: 14px;
        }

        .head-higlight{
            color: #7cf279;
        }

        /*        a .nav-link-header:hover{
                    color: #09B1BA;
                    background-color: transparent;
                    transition-duration: 0.3s;
                    transition-delay: 0.5s;
                }*/

        .nav-link-header:hover{
            color: #09B1BA;
            background-color: transparent;
            transition-duration: 0.3s;
            /*transition-delay: 0.5s;*/
        }

        .btn-login-header{
            color: #09B1BA;
            border-color: #7cf279;
            background-color: #fff;
        }

        .btn-login-header:hover{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }

        .btn-login-header:active{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }

        /*        .btn-login-header{
                    color: #fff;
                    border-color: #09B1BA;
                    background-color: #7cf279;
                    color: #fff;
                    background-color: #09B1BA;
                    border: #09B1BA;
                }
        
                .btn-login-header:hover{
                    background-color: #09acb5;
                    border-color: #09acb5;
                    transition-delay: 0.1s;
                    color: #6de66a;
                    border-color: #6de66a;
                    background-color: #fff;
                    transition-duration: 0.2s;
                }*/

        .btn-trade-header{
            color: #09B1BA;
            border-color: #7cf279;
            background-color: #fff;
        }

        .btn-trade-header:hover{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }

        .btn-trade-header:active{
            color: #fff;
            border-color: #7cf279;
            background-color: #7cf279;
            transition-duration: 0.2s;
        }
    </style>
</html>